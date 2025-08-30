@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết danh mục</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">ID</th>
                                    <td>{{ $category->id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên danh mục</th>
                                    <td>{{ $category->ten_danh_muc }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        <span class="badge badge-{{ $category->trang_thai ? 'success' : 'danger' }}">
                                            {{ $category->trang_thai ? 'Hoạt động' : 'Không hoạt động' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo</th>
                                    <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày cập nhật</th>
                                    <td>{{ $category->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Danh sách sản phẩm trong danh mục</h4>
                            @if($category->product->count() > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($category->product as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->ten_san_pham }}</td>
                                                <td>{{ number_format($product->gia) }} đ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">Chưa có sản phẩm nào trong danh mục này.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 