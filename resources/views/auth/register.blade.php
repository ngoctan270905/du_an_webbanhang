@extends('layouts.auth')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Đăng Ký</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif
        <form action="{{ route('register-post')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Họ và Tên:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu:</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-success w-100">Đăng Ký</button>
        </form>
        <p class="mt-3 text-center">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>
    </div>
@endsection
