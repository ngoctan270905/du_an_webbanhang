@extends('layouts.admin')

@section('content')

<div class="container mx-auto mt-10 p-3 sm:p-4 lg:p-6 flex items-center justify-center">
<div class="max-w-xl w-full bg-white p-8 rounded-2xl shadow-2xl space-y-6">
<div class="text-center">
<h3 class="text-3xl font-bold text-indigo-900">Chi Tiết Người Dùng</h3>
<p class="mt-2 text-gray-500">Thông tin chi tiết về tài khoản người dùng.</p>
</div>

    <div class="space-y-4">
        <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center transition-all duration-300 hover:shadow-lg">
            <span class="text-gray-600 font-medium">ID:</span>
            <span class="text-indigo-900 font-semibold">{{ $user->id }}</span>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center transition-all duration-300 hover:shadow-lg">
            <span class="text-gray-600 font-medium">Tên:</span>
            <span class="text-indigo-900 font-semibold">{{ $user->name }}</span>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center transition-all duration-300 hover:shadow-lg">
            <span class="text-gray-600 font-medium">Email:</span>
            <span class="text-indigo-900 font-semibold">{{ $user->email }}</span>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center transition-all duration-300 hover:shadow-lg">
            <span class="text-gray-600 font-medium">Vai trò:</span>
            <span class="text-indigo-900 font-semibold">{{ $user->role }}</span>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center transition-all duration-300 hover:shadow-lg">
            <span class="text-gray-600 font-medium">Ngày tạo:</span>
            <span class="text-indigo-900 font-semibold">{{ $user->created_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    
    <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8">
        <a href="{{ route('admin.users.index') }}"
            class="w-full sm:w-auto text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors">
            Quay lại
        </a>
        <a href="{{ route('admin.users.edit', $user->id) }}"
            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
            Chỉnh sửa
        </a>
    </div>
</div>

</div>
@endsection