@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết đánh giá</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">ID:</label>
                                <p>{{ $review->id }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Khách hàng:</label>
                                <p>{{ $review->user->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sản phẩm:</label>
                                <p>{{ $review->product->ten_san_pham }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nội dung:</label>
                                <p>{{ $review->noi_dung }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Đánh giá (sao):</label>
                                <p>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star fa-lg {{ $review->rating >= $i ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Trạng thái:</label>
                                <p>
                                    @if($review->trang_thai)
                                        <span class="text-success">Hoạt động</span>
                                    @else
                                        <span class="text-danger">Không hoạt động</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ngày tạo:</label>
                                <p>{{ $review->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ngày cập nhật:</label>
                                <p>{{ $review->updated_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 