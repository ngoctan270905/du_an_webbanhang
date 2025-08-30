@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>Thùng rác</h2>

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

        <!-- Sản phẩm -->
        @if($products->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách sản phẩm đã xóa</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Ngày xóa</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->ma_san_pham }}</td>
                                    <td>{{ $product->ten_san_pham }}</td>
                                    <td>{{ number_format($product->gia) }}đ</td>
                                    <td>{{ $product->so_luong }}</td>
                                    <td>{{ $product->deleted_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <form action="{{ route('admin.recycle-bin.restore', ['type' => 'product', 'id' => $product->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có muốn khôi phục sản phẩm này?')">
                                                Khôi phục
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.recycle-bin.force-delete', ['type' => 'product', 'id' => $product->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn sản phẩm này?')">
                                                Xóa vĩnh viễn
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        @endif

        <!-- Danh mục -->
        @if($categories->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách danh mục đã xóa</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <th>Ngày xóa</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->ten_danh_muc }}</td>
                                    <td>{{ $category->deleted_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <form action="{{ route('admin.recycle-bin.restore', ['type' => 'category', 'id' => $category->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có muốn khôi phục danh mục này?')">
                                                Khôi phục
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.recycle-bin.force-delete', ['type' => 'category', 'id' => $category->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn danh mục này?')">
                                                Xóa vĩnh viễn
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        @endif

        <!-- Bài viết -->
        @if($posts->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách bài viết đã xóa</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Ngày xóa</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->tieu_de }}</td>
                                    <td>{{ $post->deleted_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <form action="{{ route('admin.recycle-bin.restore', ['type' => 'post', 'id' => $post->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có muốn khôi phục bài viết này?')">
                                                Khôi phục
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.recycle-bin.force-delete', ['type' => 'post', 'id' => $post->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn bài viết này?')">
                                                Xóa vĩnh viễn
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $posts->links() }}
                </div>
            </div>
        @endif

        <!-- Đánh giá -->
        @if($reviews->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách đánh giá đã xóa</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th>Sản phẩm</th>
                                <th>Ngày xóa</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>{{ $review->user->name }}</td>
                                    <td>{{ $review->product->ten_san_pham }}</td>
                                    <td>{{ $review->deleted_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <form action="{{ route('admin.recycle-bin.restore', ['type' => 'review', 'id' => $review->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có muốn khôi phục đánh giá này?')">
                                                Khôi phục
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.recycle-bin.force-delete', ['type' => 'review', 'id' => $review->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đánh giá này?')">
                                                Xóa vĩnh viễn
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $reviews->links() }}
                </div>
            </div>
        @endif

        <!-- Liên hệ -->
        @if($contacts->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách liên hệ đã xóa</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ tên</th>
                                <th>Số điện thoại</th>
                                <th>Ngày xóa</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>{{ $contact->ho_ten }}</td>
                                    <td>{{ $contact->so_dien_thoai }}</td>
                                    <td>{{ $contact->deleted_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <form action="{{ route('admin.recycle-bin.restore', ['type' => 'contact', 'id' => $contact->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có muốn khôi phục liên hệ này?')">
                                                Khôi phục
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.recycle-bin.force-delete', ['type' => 'contact', 'id' => $contact->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn liên hệ này?')">
                                                Xóa vĩnh viễn
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $contacts->links() }}
                </div>
            </div>
        @endif

        <!-- Banner -->
        @if($banners->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh sách banner đã xóa</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Hình ảnh</th>
                                <th>Ngày xóa</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>{{ $banner->tieu_de }}</td>
                                    <td>
                                        @if($banner->hinh_anh)
                                            <img src="{{ asset('storage/' . $banner->hinh_anh) }}" alt="" width="60px">
                                        @else
                                            Không có ảnh
                                        @endif
                                    </td>
                                    <td>{{ $banner->deleted_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <form action="{{ route('admin.recycle-bin.restore', ['type' => 'banner', 'id' => $banner->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có muốn khôi phục banner này?')">
                                                Khôi phục
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.recycle-bin.force-delete', ['type' => 'banner', 'id' => $banner->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn banner này?')">
                                                Xóa vĩnh viễn
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $banners->links() }}
                </div>
            </div>
        @endif

        @if($products->count() == 0 && $categories->count() == 0 && $posts->count() == 0 && $reviews->count() == 0 && $contacts->count() == 0 && $banners->count() == 0)
            <div class="alert alert-info">
                Thùng rác trống
            </div>
        @endif
    </div>
@endsection 