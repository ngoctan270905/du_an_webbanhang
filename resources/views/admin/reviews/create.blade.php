@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thêm mới đánh giá</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reviews.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="id_nguoi_dung" class="form-label">Khách hàng</label>
                            <select class="form-control @error('id_nguoi_dung') is-invalid @enderror" 
                                    id="id_nguoi_dung" name="id_nguoi_dung" required>
                                <option value="">Chọn khách hàng</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('id_nguoi_dung') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_nguoi_dung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_san_pham" class="form-label">Sản phẩm</label>
                            <select class="form-control @error('id_san_pham') is-invalid @enderror" 
                                    id="id_san_pham" name="id_san_pham" required>
                                <option value="">Chọn sản phẩm</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('id_san_pham') == $product->id ? 'selected' : '' }}>
                                        {{ $product->ten_san_pham }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_san_pham')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="noi_dung" class="form-label">Nội dung</label>
                            <textarea class="form-control @error('noi_dung') is-invalid @enderror" 
                                      id="noi_dung" name="noi_dung" rows="3">{{ old('noi_dung') }}</textarea>
                            @error('noi_dung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Đánh giá (sao)</label>
                            <select class="form-control @error('rating') is-invalid @enderror"
                                    id="rating" name="rating" required>
                                <option value="">Chọn số sao</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} sao
                                    </option>
                                @endfor
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        

                        <div class="mb-3">
                            <label for="trang_thai" class="form-label">Trạng thái</label>
                            <select class="form-control @error('trang_thai') is-invalid @enderror" 
                                    id="trang_thai" name="trang_thai" required>
                                <option value="1" {{ old('trang_thai') == '1' ? 'selected' : '' }}>
                                    Hoạt động
                                </option>
                                <option value="0" {{ old('trang_thai') == '0' ? 'selected' : '' }}>
                                    Không hoạt động
                                </option>
                            </select>
                            @error('trang_thai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 