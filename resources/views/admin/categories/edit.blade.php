@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh sửa danh mục</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="ten_danh_muc">Tên danh mục</label>
                            <input type="text" class="form-control @error('ten_danh_muc') is-invalid @enderror" 
                                   id="ten_danh_muc" name="ten_danh_muc" 
                                   value="{{ old('ten_danh_muc', $category->ten_danh_muc) }}" required>
                            @error('ten_danh_muc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="trang_thai">Trạng thái</label>
                            <select class="form-control @error('trang_thai') is-invalid @enderror" 
                                    id="trang_thai" name="trang_thai" required>
                                <option value="1" {{ old('trang_thai', $category->trang_thai) == '1' ? 'selected' : '' }}>
                                    Hoạt động
                                </option>
                                <option value="0" {{ old('trang_thai', $category->trang_thai) == '0' ? 'selected' : '' }}>
                                    Không hoạt động
                                </option>
                            </select>
                            @error('trang_thai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 