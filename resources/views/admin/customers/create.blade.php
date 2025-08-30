@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thêm mới khách hàng</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customers.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="ho_ten" class="form-label">Họ tên</label>
                            <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" 
                                   id="ho_ten" name="ho_ten" value="{{ old('ho_ten') }}" required>
                            @error('ho_ten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('so_dien_thoai') is-invalid @enderror" 
                                   id="so_dien_thoai" name="so_dien_thoai" value="{{ old('so_dien_thoai') }}">
                            @error('so_dien_thoai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dia_chi" class="form-label">Địa chỉ</label>
                            <textarea class="form-control @error('dia_chi') is-invalid @enderror" 
                                      id="dia_chi" name="dia_chi" rows="3">{{ old('dia_chi') }}</textarea>
                            @error('dia_chi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 