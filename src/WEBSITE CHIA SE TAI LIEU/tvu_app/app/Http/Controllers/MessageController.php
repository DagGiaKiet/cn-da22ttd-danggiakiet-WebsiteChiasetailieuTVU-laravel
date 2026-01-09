<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of messages.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        // Get all conversations
        $messages = \App\Models\Message::where('sender_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->with(['sender', 'recipient', 'document'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Group by conversation partner
        $conversationsMap = [];
        
        foreach ($messages as $message) {
            $otherUserId = $message->sender_id == $userId ? $message->recipient_id : $message->sender_id;
            
            if (!isset($conversationsMap[$otherUserId])) {
                $otherUser = $message->sender_id == $userId ? $message->recipient : $message->sender;
                
                $unreadCount = \App\Models\Message::where('sender_id', $otherUserId)
                    ->where('recipient_id', $userId)
                    ->unread()
                    ->count();
                
                $conversationsMap[$otherUserId] = [
                    'id' => $otherUserId,
                    'user' => $otherUser,
                    'last_message' => $message,
                    'unread_count' => $unreadCount,
                ];
            }
        }
        
        $conversations = array_values($conversationsMap);
        
        // Get selected conversation if user_id is provided
        $selectedConversation = null;
        $conversationMessages = [];
        
        if ($request->has('user_id')) {
            $otherUserId = $request->user_id;
            $conversationMessages = \App\Models\Message::betweenUsers($userId, $otherUserId)
                ->with(['sender', 'document'])
                ->orderBy('created_at', 'asc')
                ->get();
            
            if (isset($conversationsMap[$otherUserId])) {
                $selectedConversation = $conversationsMap[$otherUserId];
                
                // Mark messages as read
                \App\Models\Message::where('sender_id', $otherUserId)
                    ->where('recipient_id', $userId)
                    ->unread()
                    ->update(['is_read' => true, 'read_at' => now()]);
            }
        } elseif (!empty($conversations)) {
            // Select first conversation by default
            $selectedConversation = $conversations[0];
            $otherUserId = $selectedConversation['id'];
            
            $conversationMessages = \App\Models\Message::betweenUsers($userId, $otherUserId)
                ->with(['sender', 'document'])
                ->orderBy('created_at', 'asc')
                ->get();
            
            // Mark messages as read
            \App\Models\Message::where('sender_id', $otherUserId)
                ->where('recipient_id', $userId)
                ->unread()
                ->update(['is_read' => true, 'read_at' => now()]);
        }
        
        return view('messages.index', compact('conversations', 'selectedConversation', 'conversationMessages'));
    }

    /**
     * Get unread messages count for the authenticated user.
     */
    public function unreadCount()
    {
        $count = \App\Models\Message::where('recipient_id', Auth::id())
            ->unread()
            ->count();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get all conversations for the authenticated user.
     */
    public function conversations()
    {
        $userId = Auth::id();
        
        // Get all messages where user is sender or recipient
        $messages = \App\Models\Message::where('sender_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->with(['sender', 'recipient', 'document'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Group by conversation partner
        $conversationsMap = [];
        
        foreach ($messages as $message) {
            $otherUserId = $message->sender_id == $userId ? $message->recipient_id : $message->sender_id;
            
            // Only keep the latest message for each conversation
            if (!isset($conversationsMap[$otherUserId])) {
                $otherUser = $message->sender_id == $userId ? $message->recipient : $message->sender;
                
                // Count unread messages from this user
                $unreadCount = \App\Models\Message::where('sender_id', $otherUserId)
                    ->where('recipient_id', $userId)
                    ->unread()
                    ->count();
                
                $conversationsMap[$otherUserId] = [
                    'id' => $otherUserId,
                    'user' => [
                        'name' => $otherUser->name,
                        'email' => $otherUser->email,
                        'avatar' => $otherUser->avatar ? asset('storage/' . $otherUser->avatar) : \App\Models\Message::getInitials($otherUser->name),
                        'has_avatar' => !empty($otherUser->avatar),
                        'online' => false // TODO: Implement online status
                    ],
                    'last_message' => $message->message,
                    'time' => $message->created_at->diffForHumans(),
                    'unread_count' => $unreadCount,
                    'document' => $message->document ? [
                        'id' => $message->document->id,
                        'name' => $message->document->name,
                        'image' => $message->document->image
                    ] : null
                ];
            }
        }
        
        return response()->json(['conversations' => array_values($conversationsMap)]);
    }

    /**
     * Show a specific conversation.
     */
    public function show($id)
    {
        // TODO: Implement conversation view
        return view('messages.show', ['conversationId' => $id]);
    }

    /**
     * Send a new message.
     */
    public function send(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'document_id' => 'nullable|exists:documents,id'
        ]);

        $message = \App\Models\Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'document_id' => $request->document_id,
            'message' => $request->message,
        ]);

        $message->load('sender', 'document');

        // Broadcast event for real-time updates
        try {
            event(new \App\Events\NewMessage(
                $request->message,
                Auth::id(),
                $request->recipient_id
            ));
        } catch (\Exception $e) {
            // Continue even if broadcasting fails
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Tin nhắn đã được gửi',
            'data' => $message
        ]);
    }

    /**
     * Mark messages as read.
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'integer'
        ]);

        \App\Models\Message::whereIn('id', $request->message_ids)
            ->where('recipient_id', Auth::id())
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Đã đánh dấu tin nhắn đã đọc'
        ]);
    }
}
