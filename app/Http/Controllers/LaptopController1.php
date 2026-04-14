<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaptopController1 extends Controller
{
    private function buildQuery(Request $request, ?int $categoryId = null)
    {
        $query = DB::table('san_pham');

        if ($categoryId !== null) {
            $query->where('id_danh_muc', $categoryId);
        }

        if ($request->sort === 'asc') {
            $query->orderBy('gia', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('gia', 'desc');
        }

        return $query;
    }

    // Hàm hiển thị mặc định trang chủ (Lấy 20 laptop)
    public function index(Request $request)
    {
        $laptops = $this->buildQuery($request)->limit(20)->get();
        $title = 'Danh sách laptop';

        return view('laptop.index', compact('laptops', 'title'));
    }

    // Hàm hiển thị khi click vào Thương hiệu trên Menu (Lấy tất cả thuộc hãng đó)
    public function category(Request $request, $id)
    {
        $currentCategory = DB::table('danh_muc_laptop')->where('id', $id)->first();
        $laptops = $this->buildQuery($request, (int) $id)->get();
        $title = $currentCategory ? $currentCategory->ten_danh_muc : 'Danh mục laptop';

        return view('laptop.index', compact('laptops', 'title'));
    }
    // Hàm hiển thị khi click vào nút Tìm kiếm (Lấy tất cả laptop có tên chứa từ khóa)
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $categories = DB::table('danh_muc_laptop')->get();
        $laptops = DB::table('san_pham')
            ->where('tieu_de', 'like', '%' . $keyword . '%')
            ->get();

        $title = "Kết quả tìm kiếm cho: " . $keyword;
        return view('laptop.index', compact('laptops', 'categories', 'title', 'keyword'));
    }
}
