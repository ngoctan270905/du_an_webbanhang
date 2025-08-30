@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh sửa banner</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="tieu_de" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control @error('tieu_de') is-invalid @enderror" 
                                   id="tieu_de" name="tieu_de" value="{{ old('tieu_de', $banner->tieu_de) }}" required>
                            @error('tieu_de')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hinh_anh" class="form-label">Hình ảnh</label>
                            @if($banner->hinh_anh)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $banner->hinh_anh) }}" alt="{{ $banner->tieu_de }}" style="max-width: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('hinh_anh') is-invalid @enderror" 
                                   id="hinh_anh" name="hinh_anh">
                            @error('hinh_anh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Chỉ chấp nhận file ảnh (jpeg, png, jpg, gif) và kích thước tối đa 2MB</div>
                        </div>

                        <div class="mb-3">
                            <label for="trang_thai" class="form-label">Trạng thái</label>
                            <select class="form-control @error('trang_thai') is-invalid @enderror" 
                                    id="trang_thai" name="trang_thai" required>
                                <option value="1" {{ old('trang_thai', $banner->trang_thai) == '1' ? 'selected' : '' }}>
                                    Hoạt động
                                </option>
                                <option value="0" {{ old('trang_thai', $banner->trang_thai) == '0' ? 'selected' : '' }}>
                                    Không hoạt động
                                </option>
                            </select>
                            @error('trang_thai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 