<x-mail::message>
# Đặt hàng thành công

Xin chào {{ $notifiable->name }},

Đơn hàng **#{{ $orderId }}** của bạn đã được đặt thành công.

## Danh sách sản phẩm:

<x-mail::table>
| STT | Tên sản phẩm | Số lượng | Đơn giá |
|-----|--------------|---------|---------|
@foreach($items as $key => $item)
| {{ $key + 1 }} | {{ $item->tieu_de }} | {{ $item->so_luong }} | {{ number_format($item->don_gia, 0, '.', ',') }} VND |
@endforeach
|  | **Tổng cộng** |  | **{{ number_format($totalPrice, 0, '.', ',') }} VND** |
</x-mail::table>

Cảm ơn bạn đã mua hàng tại hệ thống của chúng tôi!
</x-mail::message>