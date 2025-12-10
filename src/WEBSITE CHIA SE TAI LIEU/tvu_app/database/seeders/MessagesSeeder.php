<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        
        if ($users->count() < 2) {
            $this->command->info('Cần ít nhất 2 users để tạo tin nhắn mẫu.');
            return;
        }

        $documents = \App\Models\Document::take(3)->get();
        
        // Tạo một số cuộc hội thoại mẫu
        $conversations = [
            [
                'user1' => $users[0]->id,
                'user2' => $users[1]->id ?? $users[0]->id,
                'messages' => [
                    ['sender' => 1, 'text' => 'Chào bạn, mình thấy bạn đăng tặng sách Giáo trình giải tích 1.'],
                    ['sender' => 1, 'text' => 'Sách này còn không ạ?'],
                    ['sender' => 2, 'text' => 'Chào bạn, sách vẫn còn nhé.'],
                    ['sender' => 1, 'text' => 'Tuyệt vời! Bạn có thể cho mình xin vào chiều nay được không?'],
                    ['sender' => 2, 'text' => 'Được bạn. Khoảng 3h chiều nay ở thư viện trung tâm nhé.'],
                    ['sender' => 2, 'text' => 'Bạn tới nơi thì nhắn mình.'],
                ]
            ],
        ];

        // Nếu có thêm users, tạo thêm hội thoại
        if ($users->count() >= 3) {
            $conversations[] = [
                'user1' => $users[0]->id,
                'user2' => $users[2]->id,
                'messages' => [
                    ['sender' => 2, 'text' => 'Bạn có tài liệu môn Cấu trúc dữ liệu không?'],
                    ['sender' => 1, 'text' => 'Có bạn, mình có mấy file PDF rất hay.'],
                    ['sender' => 2, 'text' => 'Cảm ơn bạn nhiều nhé!'],
                ]
            ];
        }

        if ($users->count() >= 4) {
            $conversations[] = [
                'user1' => $users[0]->id,
                'user2' => $users[3]->id,
                'messages' => [
                    ['sender' => 2, 'text' => 'Bạn có ở gần cổng chính không?'],
                    ['sender' => 1, 'text' => 'Mình đang ở thư viện bạn nhé.'],
                ]
            ];
        }

        foreach ($conversations as $conv) {
            $user1 = $conv['user1'];
            $user2 = $conv['user2'];
            
            foreach ($conv['messages'] as $index => $msg) {
                $senderId = $msg['sender'] == 1 ? $user1 : $user2;
                $recipientId = $msg['sender'] == 1 ? $user2 : $user1;
                
                // Tạo tin nhắn với timestamp khác nhau
                $createdAt = now()->subMinutes(count($conv['messages']) - $index);
                
                \App\Models\Message::create([
                    'sender_id' => $senderId,
                    'recipient_id' => $recipientId,
                    'document_id' => $documents->isNotEmpty() && $index == 0 ? $documents->random()->id : null,
                    'message' => $msg['text'],
                    'is_read' => $index < count($conv['messages']) - 1, // Tin nhắn cuối chưa đọc
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }

        $this->command->info('Đã tạo ' . count($conversations) . ' cuộc hội thoại mẫu.');
    }
}
