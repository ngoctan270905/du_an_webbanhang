@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-3 sm:p-4 lg:p-6">
        <div class="space-y-4">
            <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Danh sách liên hệ</h3>
                </div>

                <div class="space-y-4">
                    @if(session('success'))
                        <div class="relative rounded-lg bg-green-100 p-3 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="relative rounded-lg bg-red-100 p-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Contacts Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="w-full min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Họ tên</th>
                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Số điện thoại</th>
                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nội dung</th>
                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($contacts as $contact)
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ $contact->ho_ten }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ $contact->so_dien_thoai }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ $contact->email }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-500">{{ Str::limit($contact->noi_dung, 50) }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                                    class="rounded-lg bg-blue-500 p-1.5 text-white transition-colors duration-200 hover:bg-blue-600">
                                                    <!-- Icon mắt (Xem chi tiết) -->
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
                                        <td colspan="5" class="whitespace-nowrap px-3 py-2 text-center text-sm text-gray-500">
                                            Không có liên hệ nào
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-end">
                        {{ $contacts->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
