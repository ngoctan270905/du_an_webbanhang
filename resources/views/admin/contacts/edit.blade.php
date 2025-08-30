@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh sửa liên hệ</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="ho_ten" class="form-label">Họ tên</label>
                            <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" 
                                   id="ho_ten" name="ho_ten" value="{{ old('ho_ten', $contact->ho_ten) }}" required>
                            @error('ho_ten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('so_dien_thoai') is-invalid @enderror" 
                                   id="so_dien_thoai" name="so_dien_thoai" value="{{ old('so_dien_thoai', $contact->so_dien_thoai) }}">
                            @error('so_dien_thoai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="noi_dung" class="form-label">Nội dung</label>
                            <textarea class="form-control @error('noi_dung') is-invalid @enderror" 
                                      id="noi_dung" name="noi_dung" rows="3">{{ old('noi_dung', $contact->noi_dung) }}</textarea>
                            @error('noi_dung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 