@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách bài viết</h3>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <form action="{{ route('admin.posts.index') }}" method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="tieu_de" class="form-control"
                                            placeholder="Tìm theo tiêu đề" value="{{ request('tieu_de') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <select name="trang_thai" class="form-control">
                                            <option value="">Tất cả trạng thái</option>
                                            <option value="1" {{ request('trang_thai') == '1' ? 'selected' : '' }}>Hoạt
                                                động</option>
                                            <option value="0" {{ request('trang_thai') == '0' ? 'selected' : '' }}>
                                                Không hoạt động</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                    <a href="{{ route('admin.posts.create') }}" class="btn btn-success">Thêm mới</a>
                                </div>
                            </div>
                        </form>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Posts Table -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Nội dung</th>
                                    <th>Hình ảnh</th> <!-- Thêm cột hình ảnh -->
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->tieu_de }}</td>
                                        <td>{{ $post->noi_dung }}</td>
                                        <td>
                                            
                                            @if ($post->hinh_anh)
                                                <img src="{{ asset('storage/' . $post->hinh_anh) }}" alt="" width="150px">
                                            @else
                                                Không có ảnh.
                                            @endif
                                        </td>
                                        <td>
                                            @if ($post->trang_thai)
                                                <span class="text-success">Hoạt động</span>
                                            @else
                                                <span class="text-danger">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.posts.show', $post->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.posts.edit', $post->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                                        <!-- Cập nhật colspan thành 6 -->
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
