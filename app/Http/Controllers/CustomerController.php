<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();
        
        if ($request->filled('ho_ten')) {
            $query->where('ho_ten', 'LIKE', '%' . $request->ho_ten . '%');
        }
        
        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->filled('so_dien_thoai')) {
            $query->where('so_dien_thoai', 'LIKE', '%' . $request->so_dien_thoai . '%');
        }

        $customers = $query->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $dataValidate = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'so_dien_thoai' => 'nullable|string|max:20',
            'dia_chi' => 'nullable|string|max:255',
        ]);

        Customer::create($dataValidate);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Thêm khách hàng thành công!');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $dataValidate = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $id,
            'so_dien_thoai' => 'nullable|string|max:20',
            'dia_chi' => 'nullable|string|max:255',
        ]);

        $customer->update($dataValidate);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Cập nhật khách hàng thành công!');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Xóa khách hàng thành công!');
    }
} 