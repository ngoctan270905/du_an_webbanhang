@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-3 sm:p-4 lg:p-6">
    <div class="space-y-4">

        <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-800">Danh sách danh mục đã xóa</h3>
                <a href="{{ route('admin.categories.index') }}"
                    class="rounded-lg bg-gray-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    ← Quay lại
                </a>
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
                
                <form method="GET" action="{{ route('admin.categories.trashed') }}"
                    class="rounded-lg border border-gray-200 p-3">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                        <input type="text" name="ten_danh_muc"
                            class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Tên danh mục" value="{{ request('ten_danh_muc') }}">
                        <select name="trang_thai"
                            class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tất cả trạng thái</option>
                            <option value="1" {{ request('trang_thai') === '1' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ request('trang_thai') === '0' ? 'selected' : '' }}>Không hoạt động</option>
                        </select>
                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="w-1/2 rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Tìm kiếm
                            </button>
                            <button type="button" onclick="window.location='{{ route('admin.categories.trashed') }}'"
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
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tên danh mục</th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Trạng thái</th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Thời gian xóa</th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($trashedCategories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-900">{{ $category->id }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ $category->ten_danh_muc }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                        @if ($category->trang_thai)
                                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Hoạt động</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ $category->deleted_at->format('d/m/Y H:i:s') }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục danh mục này?')">
                                                @csrf
                                                <button type="submit"
                                                    class="rounded-lg bg-green-500 p-1.5 text-white transition-colors duration-200 hover:bg-green-600"
                                                    title="Khôi phục">
                                                    <i class="fa-solid fa-arrow-rotate-left h-3 w-3"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.categories.forceDelete', $category->id) }}" method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa VĨNH VIỄN danh mục này? Thao tác này không thể hoàn tác!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-lg bg-red-500 p-1.5 text-white transition-colors duration-200 hover:bg-red-600"
                                                    title="Xóa vĩnh viễn">
                                                    <i class="fa-solid fa-trash-can h-3 w-3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="whitespace-nowrap px-3 py-2 text-center text-sm text-gray-500">Không có danh mục nào trong thùng rác</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end">
                    {{ $trashedCategories->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection