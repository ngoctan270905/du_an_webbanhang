@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-3 sm:p-4 lg:p-6">
<div class="space-y-4">
<div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
<div class="mb-4 flex items-center justify-between">
<h3 class="text-xl font-semibold text-gray-800">Danh sách người dùng</h3>
<div class="flex items-center space-x-2">
<a href="{{ route('admin.users.create') }}"
class="rounded-lg bg-green-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
+ Thêm người dùng
</a>
<!-- Nút Thùng rác (nếu cần) có thể thêm ở đây -->
</div>
</div>

            <div class="space-y-4">
                @if (session('success'))
                    <div class="relative rounded-lg bg-green-100 p-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="relative rounded-lg bg-red-100 p-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.users.index') }}" method="GET"
                    class="rounded-lg border border-gray-200 p-3">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                        <input type="text" name="name"
                            class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Tìm theo tên" value="{{ request('name') }}">
                        <select name="role"
                            class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tất cả vai trò</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="w-1/2 rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Tìm kiếm
                            </button>
                            <button type="button" onclick="window.location='{{ route('admin.users.index') }}'"
                                class="w-1/2 rounded-lg bg-gray-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Xóa bộ lọc
                            </button>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                    <table class="w-full min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    ID</th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Tên</th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Email</th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Vai trò</th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-900">{{ $user->id }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ $user->name }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ $user->role }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="rounded-lg bg-blue-500 p-1.5 text-white transition-colors duration-200 hover:bg-blue-600">
                                                <!-- Icon mắt (Xem chi tiết) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M2 12s5-8 10-8 10 8 10 8-5 8-10 8-10-8-10-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="rounded-lg bg-yellow-500 p-1.5 text-white transition-colors duration-200 hover:bg-yellow-600">
                                                <!-- Icon bút chì (Sửa) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-lg bg-red-500 p-1.5 text-white transition-colors duration-200 hover:bg-red-600"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                                    <!-- Icon thùng rác (Xóa) -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="whitespace-nowrap px-3 py-2 text-center text-sm text-gray-500">
                                        Không có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end">
                    {{ $users->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection