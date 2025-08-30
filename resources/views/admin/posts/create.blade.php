@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thêm mới bài viết</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="tieu_de" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control @error('tieu_de') is-invalid @enderror" 
                                   id="tieu_de" name="tieu_de" value="{{ old('tieu_de') }}" required>
                            @error('tieu_de')
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
                            <label for="hinh_anh" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control @error('hinh_anh') is-invalid @enderror" 
                                   id="hinh_anh" name="hinh_anh">
                            @error('hinh_anh')
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
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection