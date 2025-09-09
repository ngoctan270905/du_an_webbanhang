<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;
use App\Mail\ContactReplyMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('ho_ten')) {
            $query->where('ho_ten', 'LIKE', '%' . $request->ho_ten . '%');
        }

        if ($request->filled('so_dien_thoai')) {
            $query->where('so_dien_thoai', 'LIKE', '%' . $request->so_dien_thoai . '%');
        }

        $contacts = $query->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_content' => 'required|string|max:2000',
        ]);

        $contact = Contact::findOrFail($id);

        // Lưu vào bảng contact_replies
        $reply = ContactReply::create([
            'contact_id' => $contact->id,
            'user_id'    => auth()->id(),
            'content'    => $request->reply_content,
        ]);

        // Gửi email cho khách hàng (nếu có email)
        if ($contact->email) {
            Mail::to($contact->email)->send(
                new ContactReplyMail($contact, $request->reply_content)
            );
        }

        return redirect()
            ->route('admin.contacts.show', $contact->id)
            ->with('success', 'Đã gửi trả lời đến khách hàng.');
    }
}
