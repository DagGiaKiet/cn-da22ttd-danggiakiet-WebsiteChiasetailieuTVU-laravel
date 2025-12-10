<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('static.contact');
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $contact = Contact::create($data);

        // Optional: send email to support (requires mail config)
        try {
            if (config('mail.mailers.smtp.host')) {
                Mail::raw(
                    "Liên hệ mới từ: {$contact->name} <{$contact->email}>\n\nChủ đề: {$contact->subject}\n\nNội dung:\n{$contact->message}",
                    function ($m) use ($contact) {
                        $m->to(config('mail.from.address') ?: 'support@tracuasachtvu.edu.vn', 'Hỗ trợ TVU')
                          ->subject('[Trao Đổi Sách TVU] Liên hệ mới');
                    }
                );
            }
        } catch (\Throwable $e) {
            // Không chặn luồng nếu gửi email thất bại; dữ liệu đã lưu DB
        }

        return redirect()->route('contact')
            ->with('success', 'Cảm ơn bạn! Tin nhắn đã được gửi. Chúng tôi sẽ phản hồi sớm.');
    }
}
