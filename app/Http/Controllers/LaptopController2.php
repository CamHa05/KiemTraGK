<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SuccessfulOrderEmail;

class LaptopController2 extends Controller
{
    function chiTiet($id)
    {
        $laptop = DB::table('san_pham')->where('id', $id)->first();
        return view('chi-tiet', compact('laptop'));
    }
    function cartAdd(Request $request)
    {
        $request->validate([
            "id" => ["required", "numeric"],
            "num" => ["required", "numeric"]
        ]);
        $id = $request->id;
        $num = $request->num;
        $cart = [];
        if (session()->has('cart')) {
            $cart = session()->get("cart");
            if (isset($cart[$id]))
                $cart[$id] += $num;
            else
                $cart[$id] = $num;
        } else {
            $cart[$id] = $num;
        }
        session()->put("cart", $cart);
        return count($cart);
    }
    public function order()
    {
        $cart = [];
        $data = [];
        $quantity = [];
        if (session()->has('cart')) {
            $cart = session("cart");
            $list_laptop = "";
            foreach ($cart as $id => $value) {
                $quantity[$id] = $value;
                $list_laptop .= $id . ", ";
            }
            $list_laptop = substr($list_laptop, 0, strlen($list_laptop) - 2);
            $data = DB::table("san_pham")->whereRaw("id in (" . $list_laptop . ")")->get();
        }
        return view("order", compact("quantity", "data"));
    }
    public function cartDelete(Request $request)
    {
        $request->validate([
            "id" => ["required", "numeric"]
        ]);
        $id = $request->id;
        $cart = [];
        if (session()->has('cart')) {
            $cart = session()->get("cart");
            unset($cart[$id]);
        }
        session()->put("cart", $cart);
        return redirect()->route('order');
    }
    public function orderCreate(Request $request)
    {
        $request->validate([
            "hinh_thuc_thanh_toan" => ["required", "numeric"]
        ]);
        $orderId = null;
        if (session()->has('cart')) {
            $order = [
                "ngay_dat_hang" => DB::raw("now()"),
                "tinh_trang" => 1,
                "hinh_thuc_thanh_toan" => $request->hinh_thuc_thanh_toan,
                "user_id" => Auth::user()->id
            ];
            $orderId = DB::transaction(function () use ($order) {
                $id_don_hang = DB::table("don_hang")->insertGetId($order);
                $cart = session("cart");
                $list_laptop = "";
                $quantity = [];
                foreach ($cart as $id => $value) {
                    $quantity[$id] = $value;
                    $list_laptop .= $id . ", ";
                }
                $list_laptop = substr($list_laptop, 0, strlen($list_laptop) - 2);
                $data = DB::table("san_pham")->whereRaw("id in (" . $list_laptop . ")")->get();
                $detail = [];
                foreach ($data as $row) {
                    $detail[] = [
                        "ma_don_hang" => $id_don_hang,
                        "laptop_id" => $row->id,
                        "so_luong" => $quantity[$row->id],
                        "don_gia" => $row->gia
                    ];
                }
                DB::table("chi_tiet_don_hang")->insert($detail);
                session()->forget('cart');

                return $id_don_hang;
            });
        }

        if ($orderId !== null) {
            Auth::user()->notify(new SuccessfulOrderEmail($orderId));
            return redirect()->route('order')->with('status', 'Đặt hàng thành công');
        }

        return redirect()->route('order')->with('status', 'Giỏ hàng đang trống');
    }
}
