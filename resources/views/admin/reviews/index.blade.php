@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách đánh giá</h3>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form action="{{ route('admin.reviews.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" name="noi_dung" class="form-control" placeholder="Tìm theo nội dung" value="{{ request('noi_dung') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <select name="trang_thai" class="form-control">
                                        <option value="">Tất cả trạng thái</option>
                                        <option value="1" {{ request('trang_thai') == '1' ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="0" {{ request('trang_thai') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                <a href="{{ route('admin.reviews.create') }}" class="btn btn-success">Thêm mới</a>
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                   <!-- Reviews Table -->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Sản phẩm</th>
            <th>Nội dung</th>
            <th>Đánh giá (sao)</th> <!-- NEW -->
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reviews as $review)
            <tr>
                <td>{{ $review->id }}</td>
                <td>{{ $review->user->name }}</td>
                <td>{{ $review->product->ten_san_pham }}</td>
                <td>{{ $review->noi_dung }}</td>
                <td>
                    @if($review->rating)
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                        <span class="ml-1">({{ $review->rating }}/5)</span>
                    @else
                        <span class="text-muted">Chưa đánh giá</span>
                    @endif
                </td>
                <td>
                    @if($review->trang_thai)
                        <span class="text-success">Hoạt động</span>
                    @else
                        <span class="text-danger">Không hoạt động</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Không có dữ liệu</td>
            </tr>
        @endforelse
    </tbody>
</table>


                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 