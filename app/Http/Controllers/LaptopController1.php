<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LaptopController1 extends Controller
{
    private function activeProductsQuery()
    {
        $query = DB::table('san_pham');

        if (Schema::hasColumn('san_pham', 'status')) {
            $query->where('status', 1);
        }

        return $query;
    }

    private function getPriceColumn(): string
    {
        return Schema::hasColumn('san_pham', 'gia_ban') ? 'gia_ban' : 'gia';
    }

    private function buildQuery(Request $request, ?int $categoryId = null)
    {
        $query = $this->activeProductsQuery();

        if ($categoryId !== null) {
            $query->where('id_danh_muc', $categoryId);
        }

        $priceColumn = $this->getPriceColumn();

        if ($request->sort === 'asc') {
            $query->orderBy($priceColumn, 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy($priceColumn, 'desc');
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
        $laptops = $this->activeProductsQuery()
            ->where('tieu_de', 'like', '%' . $keyword . '%')
            ->get();

        $title = "Kết quả tìm kiếm cho: " . $keyword;
        return view('laptop.index', compact('laptops', 'title', 'keyword'));
    }

    // Hàm hiển thị các cuốn sách trong trang quản lý sách
    public function manage()
    {
        $laptops = $this->activeProductsQuery()->get();
        return view('laptop.manage', compact('laptops'));
    }

    // Hàm xóa sách (cập nhật trường status về 0)
    public function destroy($id)
    {
        if (!Schema::hasColumn('san_pham', 'status')) {
            return redirect()->route('laptop.manage')->with('error', 'Chưa có cột status trong bảng san_pham.');
        }

        DB::table('san_pham')->where('id', $id)->update(['status' => 0]);

        return redirect()->route('laptop.manage')->with('success', 'Đã xóa sản phẩm thành công');
    }
}
