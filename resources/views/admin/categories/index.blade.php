@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-3 sm:p-4 lg:p-6">
        <div class="space-y-4">
            <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Danh sách danh mục</h3>
                    <div class="flex items-center space-x-2">
                        <!-- Nút Thùng rác (nếu cần) có thể thêm ở đây -->
                        <a href="{{ route('admin.categories.create') }}"
                            class="rounded-lg bg-green-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            + Thêm danh mục
                        </a>
                        <a href="{{ route('admin.categories.trashed') }}"
                            class="rounded-lg bg-gray-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Thùng rác
                        </a>
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

                    <form action="{{ route('admin.categories.index') }}" method="GET"
                        class="rounded-lg border border-gray-200 p-3">
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                            <input type="text" name="ten_danh_muc"
                                class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Tìm kiếm theo tên danh mục" value="{{ request('ten_danh_muc') }}">
                            <select name="trang_thai"
                                class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1" {{ request('trang_thai') == '1' ? 'selected' : '' }}>Hoạt động
                                </option>
                                <option value="0" {{ request('trang_thai') == '0' ? 'selected' : '' }}>Không hoạt động
                                </option>
                            </select>
                            <div class="flex items-center space-x-2">
                                <button type="submit"
                                    class="w-1/2 rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Tìm kiếm
                                </button>
                                <button type="button" onclick="window.location='{{ route('admin.categories.index') }}'"
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
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        ID</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Tên danh mục</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Trạng thái</th>
                                    <th
                                        class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($categories as $category)
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-900">
                                            {{ $category->id }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                            {{ $category->ten_danh_muc }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm">
                                            @if ($category->trang_thai)
                                                <span
                                                    class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Hoạt
                                                    động</span>
                                            @else
                                                <span
                                                    class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Không
                                                    hoạt động</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('admin.categories.show', $category->id) }}"
                                                    class="rounded-lg bg-blue-500 p-1.5 text-white transition-colors duration-200 hover:bg-blue-600">
                                                    <!-- Icon mắt (Xem chi tiết) -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M2 12s5-8 10-8 10 8 10 8-5 8-10 8-10-8-10-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                    class="rounded-lg bg-yellow-500 p-1.5 text-white transition-colors duration-200 hover:bg-yellow-600">
                                                    <!-- Icon bút chì (Sửa) -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="rounded-lg bg-red-500 p-1.5 text-white transition-colors duration-200 hover:bg-red-600"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                                        <!-- Icon thùng rác (Xóa) -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path
                                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                            </path>
                                                            <line x1="10" y1="11" x2="10"
                                                                y2="17"></line>
                                                            <line x1="14" y1="11" x2="14"
                                                                y2="17"></line>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="whitespace-nowrap px-3 py-2 text-center text-sm text-gray-500">
                                            Không có danh mục nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end">
                        {{ $categories->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
