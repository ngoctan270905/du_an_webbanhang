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

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

   
} 