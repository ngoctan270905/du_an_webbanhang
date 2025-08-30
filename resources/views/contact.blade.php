@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Liên hệ với chúng tôi</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="ho_ten" class="form-label">Họ tên</label>
                <input type="text" class="form-control" name="ho_ten" value="{{ old('ho_ten') }}" required>
            </div>

            <div class="mb-3">
                <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" name="so_dien_thoai" value="{{ old('so_dien_thoai') }}">
            </div>

            <div class="mb-3">
                <label for="noi_dung" class="form-label">Nội dung</label>
                <textarea class="form-control" name="noi_dung" rows="4" required>{{ old('noi_dung') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Gửi liên hệ</button>
        </form>
    </div>
@endsection
