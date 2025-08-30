<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

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

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $dataValidate = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'nullable|string|max:20',
            'noi_dung' => 'nullable|string|max:255',
        ]);

        Contact::create($dataValidate);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Thêm liên hệ thành công!');
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $dataValidate = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'nullable|string|max:20',
            'noi_dung' => 'nullable|string|max:255',
        ]);

        $contact->update($dataValidate);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Cập nhật liên hệ thành công!');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Xóa liên hệ thành công!');
    }
} 