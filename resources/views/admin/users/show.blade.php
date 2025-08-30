@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Chi tiết người dùng</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>ID:</strong> {{ $user->id }}
            </div>
            <div class="mb-3">
                <strong>Tên:</strong> {{ $user->name }}
            </div>
            <div class="mb-3">
                <strong>Email:</strong> {{ $user->email }}
            </div>
            <div class="mb-3">
                <strong>Vai trò:</strong> {{ $user->role }}
            </div>
            <div class="mb-3">
                <strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i') }}
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Chỉnh sửa</a>
        </div>
    </div>
</div>
@endsection