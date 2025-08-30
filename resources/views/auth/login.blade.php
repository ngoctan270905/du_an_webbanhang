{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.auth')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Đăng Nhập</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif
        <form action="{{ route('login-post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
        </form>
        <p class="mt-3 text-center">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>
    </div>
@endsection
