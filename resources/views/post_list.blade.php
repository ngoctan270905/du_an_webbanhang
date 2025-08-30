@extends('layouts.master')

@section('title', 'Danh Sách Bài Viết')

@section('content')
<style>
    .post-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .post-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .post-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
    }

    .search-form {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .search-form input[type="text"] {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .search-form select {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .search-form button {
        padding: 0.5rem 1.5rem;
        background: #e63946;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-form button:hover {
        background: #d00000;
    }

    .post-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .post-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .post-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .post-body {
        padding: 1rem;
    }

    .post-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .post-excerpt {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .post-meta {
        font-size: 0.85rem;
        color: #999;
    }

    .pagination {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    .pagination a, .pagination span {
        padding: 0.5rem 1rem;
        margin: 0 0.25rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
    }

    .pagination a:hover {
        background: #e63946;
        color: #fff;
        border-color: #e63946;
    }

    .pagination .current {
        background: #e63946;
        color: #fff;
        border-color: #e63946;
    }
</style>

<div class="post-container">
    <!-- Header -->
    <div class="post-header">
        <h1>Danh Sách Bài Viết</h1>
        <form action="{{ route('posts.list') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Tìm kiếm bài viết..." value="{{ request('search') }}">
            <select name="sort_by">
                <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
            </select>
            <button type="submit">Tìm kiếm</button>
        </form>
    </div>

    <!-- Danh sách bài viết -->
    <div class="post-list">
        @forelse ($posts as $post)
            <div class="post-card">
                @if ($post->hinh_anh)
                    <img src="{{ asset('storage/' . $post->hinh_anh) }}" class="post-image" alt="{{ $post->tieu_de }}">
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" class="post-image" alt="Placeholder">
                @endif
                <div class="post-body">
                    <h2 class="post-title">{{ $post->tieu_de }}</h2>
                    <p class="post-excerpt">{{ Str::limit($post->noi_dung, 100) }}</p>
                    <p class="post-meta">Đăng ngày: {{ $post->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        @empty
            <p class="text-muted">Không có bài viết nào.</p>
        @endforelse
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-end mt-3">
      {{ $posts->links('pagination::bootstrap-5') }}
  </div>
</div>
@endsection