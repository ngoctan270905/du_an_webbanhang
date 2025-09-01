@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-3 sm:p-4 lg:p-6">
<div class="space-y-4">

        <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-800">Danh sách sản phẩm đã xóa</h3>
                <a href="{{ route('admin.products.index') }}"
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

                <form method="GET" action="{{ route('admin.products.trashed') }}"
                    class="rounded-lg border border-gray-200 p-3">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                        <input type="text" name="ma_san_pham"
                            class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Mã sản phẩm" value="{{ request('ma_san_pham') }}">
                        <input type="text" name="ten_san_pham"
                            class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Tên sản phẩm" value="{{ request('ten_san_pham') }}">
                        <select name="category_id"
                            class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tất cả danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->ten_danh_muc }}
                                </option>
                            @endforeach
                        </select>
                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="w-1/2 rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Tìm kiếm
                            </button>
                            <button type="button" onclick="window.location='{{ route('admin.products.trashed') }}'"
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
                                    Mã SP</th>
                                <th
                                    class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Tên SP</th>
                                <th
                                    class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Tác giả</th>
                                <th
                                    class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Hình ảnh</th>
                                <th
                                    class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Danh mục</th>
                                <th
                                    class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Giá</th>
                                <th
                                    class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Số lượng</th>
                                <th
                                    class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Thời gian xóa</th>
                                <th
                                    class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($trashedProducts as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-900">
                                        {{ $product->id }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                        {{ $product->ma_san_pham }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                        {{ $product->ten_san_pham }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                        {{ $product->author }}</td>
                                    <td class="px-3 py-2">
                                        @if ($product->hinh_anh && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->hinh_anh))
                                            <img src="{{ asset('storage/' . $product->hinh_anh) }}"
                                                alt="Hình ảnh sản phẩm" class="h-10 w-10 object-cover">
                                        @else
                                            <span class="text-xs text-gray-400">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                        {{ $product->category->ten_danh_muc ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                        @if ($product->gia_khuyen_mai)
                                            <span
                                                class="text-red-600">{{ number_format($product->gia_khuyen_mai, 0, ',', '.') }}
                                                đ</span>
                                            <span
                                                class="line-through text-gray-400 text-xs">{{ number_format($product->gia, 0, ',', '.') }}
                                                đ</span>
                                        @else
                                            <span>{{ number_format($product->gia, 0, ',', '.') }} đ</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                        {{ $product->so_luong }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                        {{ $product->deleted_at->format('d/m/Y H:i:s') }}</td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('admin.products.restore', $product->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục sản phẩm này?')">
                                                @csrf
                                                @method('POST')
                                                <button type="submit"
                                                    class="rounded-lg bg-green-500 p-1.5 text-white transition-colors duration-200 hover:bg-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M12 20s-8-2-8-11a8 8 0 0 1 16 0c0 9-8 11-8 11z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                        <path d="M16 12l-4 4-4-4"></path>
                                                        <path d="M12 8v4"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.products.force-delete', $product->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn sản phẩm này? Thao tác này không thể hoàn tác!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-lg bg-red-500 p-1.5 text-white transition-colors duration-200 hover:bg-red-600">
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
                                    <td colspan="9"
                                        class="whitespace-nowrap px-3 py-2 text-center text-sm text-gray-500">Không có
                                        sản phẩm nào trong thùng rác</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end">
                    {{ $trashedProducts->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection