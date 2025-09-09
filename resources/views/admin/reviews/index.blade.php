@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-3 sm:p-4 lg:p-6">
    <div class="space-y-4">
        <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-800">Danh sách sản phẩm có đánh giá</h3>
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

                <form action="{{ route('admin.reviews.index') }}" method="GET"
                    class="rounded-lg border border-gray-200 p-3">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                        <input type="text" name="noi_dung"
                            class="w-full rounded-lg border border-gray-300 p-1.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Tìm kiếm theo sản phẩm" value="{{ request('noi_dung') }}">
                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="w-1/2 rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Tìm kiếm
                            </button>
                            <button type="button" onclick="window.location='{{ route('admin.reviews.index') }}'"
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
                                    ID
                                </th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Sản phẩm
                                </th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Đánh giá
                                </th>
                                <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-3 py-2 text-sm font-medium text-gray-900">
                                        {{ $product->id }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                        {{ $product->ten_san_pham }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">
                                        {{ $product->reviews_count }} đánh giá
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2 text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                             <a href="{{ route('admin.reviews.showReviews', $product->id) }}"
                                                 class="rounded-lg bg-blue-500 p-1.5 text-white transition-colors duration-200 hover:bg-blue-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M2 12s5-8 10-8 10 8 10 8-5 8-10 8-10-8-10-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="whitespace-nowrap px-3 py-2 text-center text-sm text-gray-500">
                                        Không có sản phẩm nào có đánh giá
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end">
                    {{ $products->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection