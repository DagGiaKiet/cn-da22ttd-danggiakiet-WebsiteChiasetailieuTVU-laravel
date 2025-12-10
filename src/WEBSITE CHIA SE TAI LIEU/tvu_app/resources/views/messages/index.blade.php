@extends('layouts.app')

@section('title', 'Hộp thư - TVU Document Hub')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="layout-content-container mx-auto max-w-7xl">
        <div class="flex h-[calc(100vh-200px)] gap-4">
            <!-- Conversations List -->
            <aside class="w-full max-w-sm flex flex-col glass-effect rounded-xl overflow-hidden shadow-lg">
                <div class="p-4 border-b border-white/20 dark:border-black/20">
                    <label class="flex flex-col min-w-40 h-12 w-full">
                        <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                            <div class="text-slate-500 dark:text-gray-400 flex border-none bg-white/50 dark:bg-black/30 items-center justify-center pl-4 rounded-l-lg border-r-0">
                                <span class="material-symbols-outlined">search</span>
                            </div>
                            <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-slate-800 dark:text-white focus:outline-0 focus:ring-1 focus:ring-primary/50 border-none bg-white/50 dark:bg-black/30 h-full placeholder:text-slate-500 dark:placeholder:text-gray-400 px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal leading-normal" placeholder="Tìm kiếm cuộc trò chuyện" value=""/>
                        </div>
                    </label>
                </div>
                <div class="flex-1 overflow-y-auto">
                    @forelse($conversations as $index => $conversation)
                        @php
                            $isActive = $selectedConversation && $selectedConversation['id'] == $conversation['id'];
                            $colors = ['from-primary to-blue-600', 'from-purple-500 to-pink-500', 'from-green-500 to-teal-500', 'from-orange-500 to-red-500', 'from-indigo-500 to-purple-500'];
                            $colorClass = $colors[$index % count($colors)];
                        @endphp
                        <a href="{{ route('messages.index', ['user_id' => $conversation['id']]) }}" 
                           class="flex gap-4 px-4 py-3 justify-between cursor-pointer transition-colors {{ $isActive ? 'bg-primary/20 dark:bg-primary/30 border-l-4 border-primary' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                            <div class="flex items-center gap-4">
                                <div class="relative shrink-0">
                                    <div class="bg-gradient-to-br {{ $colorClass }} rounded-full size-14 flex items-center justify-center text-white font-bold text-sm">
                                        {{ \App\Models\Message::getInitials($conversation['user']->name) }}
                                    </div>
                                    @if($conversation['unread_count'] > 0)
                                        <div class="absolute bottom-0 right-0 size-4 bg-green-500 rounded-full border-2 border-white dark:border-slate-900"></div>
                                    @endif
                                </div>
                                <div class="flex flex-1 flex-col justify-center">
                                    <p class="text-slate-800 dark:text-white text-base font-medium leading-normal">{{ $conversation['user']->name }}</p>
                                    <p class="{{ $conversation['unread_count'] > 0 ? 'text-primary font-bold' : 'text-slate-500 dark:text-gray-400 font-normal' }} text-sm leading-normal truncate">
                                        {{ Str::limit($conversation['last_message']->message, 40) }}
                                    </p>
                                </div>
                            </div>
                            <div class="shrink-0 flex flex-col items-end justify-between">
                                <p class="{{ $conversation['unread_count'] > 0 ? 'text-primary' : 'text-slate-500 dark:text-gray-400' }} text-xs font-medium">
                                    {{ $conversation['last_message']->created_at->diffForHumans() }}
                                </p>
                                @if($conversation['unread_count'] > 0)
                                    <div class="flex size-6 items-center justify-center rounded-full bg-primary text-white text-xs font-bold">
                                        {{ $conversation['unread_count'] }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center">
                            <span class="material-symbols-outlined text-slate-400 text-5xl">chat_bubble_outline</span>
                            <p class="text-slate-500 dark:text-gray-400 mt-4">Chưa có tin nhắn nào</p>
                        </div>
                    @endforelse
                </div>
            </aside>

            <!-- Conversation View -->
            <div class="flex-1 flex flex-col rounded-xl overflow-hidden shadow-lg">
                @if($selectedConversation)
                    <header class="flex items-center justify-between p-4 border-b border-white/20 dark:border-white/10 bg-white/30 dark:bg-black/20 backdrop-blur-md glass-effect">
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-br from-primary to-blue-600 rounded-full size-12 flex items-center justify-center text-white font-bold text-sm">
                                {{ \App\Models\Message::getInitials($selectedConversation['user']->name) }}
                            </div>
                            <div class="flex flex-col">
                                <p class="text-slate-800 dark:text-white text-lg font-semibold leading-normal">{{ $selectedConversation['user']->name }}</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-slate-500 dark:text-gray-400 text-sm font-normal">{{ $selectedConversation['user']->email }}</p>
                                </div>
                            </div>
                        </div>
                        @if($selectedConversation['last_message']->document)
                            <div class="flex items-center gap-2">
                                @if($selectedConversation['last_message']->document->image)
                                    <div class="bg-cover bg-center rounded-lg size-12" style="background-image: url('{{ asset('storage/' . $selectedConversation['last_message']->document->image) }}')"></div>
                                @else
                                    <div class="bg-gradient-to-br from-slate-400 to-slate-600 rounded-lg size-12 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-white text-xl">book</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-slate-800 dark:text-white">{{ Str::limit($selectedConversation['last_message']->document->name, 20) }}</p>
                                    <p class="text-xs text-slate-500 dark:text-gray-400">Tài liệu liên quan</p>
                                </div>
                            </div>
                        @endif
                        <button class="p-2 rounded-full hover:bg-black/5 dark:hover:bg-white/5 text-slate-800 dark:text-white">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </button>
                    </header>
                @else
                    <header class="flex items-center justify-between p-4 border-b border-white/20 dark:border-white/10 bg-white/30 dark:bg-black/20 backdrop-blur-md glass-effect">
                        <div class="flex items-center gap-4">
                            <p class="text-slate-500 dark:text-gray-400">Chọn một cuộc trò chuyện để bắt đầu</p>
                        </div>
                    </header>
                @endif

                <div class="flex-1 flex flex-col p-6 overflow-y-auto space-y-4 bg-white/30 dark:bg-black/20 backdrop-blur-md" id="messagesContainer">
                    @if($selectedConversation && count($conversationMessages) > 0)
                        @php
                            $currentDate = null;
                        @endphp
                        @foreach($conversationMessages as $message)
                            @php
                                $messageDate = $message->created_at->format('Y-m-d');
                                $isSent = $message->sender_id == Auth::id();
                            @endphp
                            
                            @if($currentDate != $messageDate)
                                <div class="flex justify-center">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $message->created_at->format('d/m/Y, H:i') }}
                                    </span>
                                </div>
                                @php $currentDate = $messageDate; @endphp
                            @endif

                            @if($isSent)
                                <!-- Sent Message -->
                                <div class="flex items-end gap-2 max-w-lg ml-auto">
                                    <div class="bg-primary text-white p-3 rounded-t-lg rounded-bl-lg">
                                        <p class="text-sm">{{ $message->message }}</p>
                                        <p class="text-xs opacity-70 mt-1">{{ $message->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            @else
                                <!-- Received Message -->
                                <div class="flex items-end gap-2 max-w-lg">
                                    <div class="bg-gradient-to-br from-primary to-blue-600 rounded-full size-8 flex items-center justify-center text-white text-xs font-bold shrink-0 self-end">
                                        {{ \App\Models\Message::getInitials($message->sender->name) }}
                                    </div>
                                    <div class="bg-white/70 dark:bg-gray-700/70 p-3 rounded-t-lg rounded-br-lg">
                                        <p class="text-sm text-slate-800 dark:text-white">{{ $message->message }}</p>
                                        <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">{{ $message->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @elseif($selectedConversation)
                        <div class="flex items-center justify-center h-full">
                            <div class="text-center">
                                <span class="material-symbols-outlined text-slate-400 text-5xl">chat</span>
                                <p class="text-slate-500 dark:text-gray-400 mt-4">Chưa có tin nhắn nào</p>
                                <p class="text-slate-400 dark:text-gray-500 text-sm mt-2">Gửi tin nhắn đầu tiên để bắt đầu cuộc trò chuyện</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center h-full">
                            <div class="text-center">
                                <span class="material-symbols-outlined text-slate-400 text-5xl">forum</span>
                                <p class="text-slate-500 dark:text-gray-400 mt-4">Chọn một cuộc trò chuyện</p>
                                <p class="text-slate-400 dark:text-gray-500 text-sm mt-2">Chọn người dùng từ danh sách bên trái để bắt đầu nhắn tin</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Message Input -->
                @if($selectedConversation)
                    <div class="p-4 border-t border-white/20 dark:border-black/20 bg-white/30 dark:bg-black/20 backdrop-blur-md">
                        <form id="messageForm" class="flex items-center gap-4 bg-white/50 dark:bg-black/30 rounded-lg p-2">
                            @csrf
                            <input type="hidden" name="recipient_id" value="{{ $selectedConversation['id'] }}">
                            <button type="button" class="p-2 rounded-full hover:bg-black/10 dark:hover:bg-white/10 text-slate-500 dark:text-gray-400">
                                <span class="material-symbols-outlined">add_circle</span>
                            </button>
                            <input id="messageInput" name="message" class="flex-1 bg-transparent border-none focus:ring-0 text-sm text-slate-800 dark:text-white placeholder:text-slate-500 dark:placeholder:text-gray-400" placeholder="Nhập tin nhắn..." type="text" required/>
                            <button type="button" class="p-2 rounded-full hover:bg-black/10 dark:hover:bg-white/10 text-slate-500 dark:text-gray-400">
                                <span class="material-symbols-outlined">sentiment_satisfied</span>
                            </button>
                            <button type="submit" id="sendButton" class="flex items-center justify-center size-10 bg-primary rounded-lg text-white hover:opacity-90 transition-opacity">
                                <span class="material-symbols-outlined">send</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const messagesContainer = document.getElementById('messagesContainer');
    const sendButton = document.getElementById('sendButton');

    // Auto scroll to bottom
    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    // Initial scroll
    scrollToBottom();

    // Handle form submission
    if (messageForm) {
        messageForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (!message) return;

            const recipientId = document.querySelector('input[name="recipient_id"]').value;
            const csrfToken = document.querySelector('input[name="_token"]').value;

            // Disable send button
            sendButton.disabled = true;
            sendButton.style.opacity = '0.5';

            try {
                const response = await fetch('{{ route('messages.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        recipient_id: recipientId,
                        message: message
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Add message to UI immediately
                    const now = new Date();
                    const timeString = now.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
                    
                    const messageHtml = `
                        <div class="flex items-end gap-2 max-w-lg ml-auto">
                            <div class="bg-primary text-white p-3 rounded-t-lg rounded-bl-lg">
                                <p class="text-sm">${escapeHtml(message)}</p>
                                <p class="text-xs opacity-70 mt-1">${timeString}</p>
                            </div>
                        </div>
                    `;
                    
                    messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                    
                    // Clear input
                    messageInput.value = '';
                    
                    // Scroll to bottom
                    scrollToBottom();
                } else {
                    console.error('Server response:', data);
                    alert(data.message || 'Không thể gửi tin nhắn. Vui lòng thử lại.');
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            } finally {
                // Re-enable send button
                sendButton.disabled = false;
                sendButton.style.opacity = '1';
            }
        });

        // Send on Enter key
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                messageForm.dispatchEvent(new Event('submit'));
            }
        });
    }

    // Helper function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Auto-refresh messages every 5 seconds
    @if($selectedConversation)
        setInterval(function() {
            const currentUrl = window.location.href;
            fetch(currentUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Only update if not currently typing
                if (document.activeElement !== messageInput) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newMessages = doc.getElementById('messagesContainer');
                    
                    if (newMessages && messagesContainer.scrollHeight - messagesContainer.scrollTop < messagesContainer.clientHeight + 100) {
                        messagesContainer.innerHTML = newMessages.innerHTML;
                        scrollToBottom();
                    }
                }
            })
            .catch(error => console.error('Error refreshing messages:', error));
        }, 5000);
    @endif
});
</script>
@endpush
