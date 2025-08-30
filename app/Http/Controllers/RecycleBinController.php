<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Post;
use App\Models\Review;
use App\Models\Contact;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecycleBinController extends Controller
{
    public function index()
    {
        $products = Product::onlyTrashed()->paginate(5);
        $categories = Category::onlyTrashed()->paginate(5);
        $posts = Post::onlyTrashed()->paginate(5);
        $reviews = Review::onlyTrashed()->paginate(5);
        $contacts = Contact::onlyTrashed()->paginate(5);
        $banners = Banner::onlyTrashed()->paginate(5);

        return view('admin.recycle-bin.index', compact(
            'products',
            'categories',
            'posts',
            'reviews',
            'contacts',
            'banners'
        ));
    }

    public function restore($type, $id)
    {
        switch ($type) {
            case 'product':
                $item = Product::withTrashed()->findOrFail($id);
                break;
            case 'category':
                $item = Category::withTrashed()->findOrFail($id);
                break;
            case 'post':
                $item = Post::withTrashed()->findOrFail($id);
                break;
            case 'review':
                $item = Review::withTrashed()->findOrFail($id);
                break;
            case 'contact':
                $item = Contact::withTrashed()->findOrFail($id);
                break;
            case 'banner':
                $item = Banner::withTrashed()->findOrFail($id);
                break;
            default:
                return redirect()->route('admin.recycle-bin.index')
                    ->with('error', 'Loại dữ liệu không hợp lệ!');
        }

        $item->restore();
        return redirect()->route('admin.recycle-bin.index')
            ->with('success', 'Khôi phục thành công!');
    }

    public function forceDelete($type, $id)
    {
        switch ($type) {
            case 'product':
                $item = Product::withTrashed()->findOrFail($id);
                if ($item->hinh_anh) {
                    Storage::disk('public')->delete($item->hinh_anh);
                }
                break;
            case 'category':
                $item = Category::withTrashed()->findOrFail($id);
                break;
            case 'post':
                $item = Post::withTrashed()->findOrFail($id);
                break;
            case 'review':
                $item = Review::withTrashed()->findOrFail($id);
                break;
            case 'contact':
                $item = Contact::withTrashed()->findOrFail($id);
                break;
            case 'banner':
                $item = Banner::withTrashed()->findOrFail($id);
                if ($item->hinh_anh) {
                    Storage::disk('public')->delete($item->hinh_anh);
                }
                break;
            default:
                return redirect()->route('admin.recycle-bin.index')
                    ->with('error', 'Loại dữ liệu không hợp lệ!');
        }

        $item->forceDelete();
        return redirect()->route('admin.recycle-bin.index')
            ->with('success', 'Xóa vĩnh viễn thành công!');
    }
} 