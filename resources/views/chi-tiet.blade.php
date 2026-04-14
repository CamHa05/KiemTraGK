<x-laptop-layout>
    <x-slot name='title'>Chi tiết laptop</x-slot>
    <div class="laptop-info">
        <div>
            <img src="{{asset('storage/image/'.$laptop->hinh_anh)}}" alt="" style='width:100%;height:auto;object-fit:cover'>
        </div>
        <div>
            <h2>{{$laptop->tieu_de}}</h2>
            <p>CPU: {{$laptop->cpu}}</p>
            <p>RAM: {{$laptop->ram}}</p>
            <p>Ổ cứng: {{$laptop->luu_tru}}</p>
            <p>Chip đồ hoạ: {{$laptop->chip_do_hoa}}</p>
            <p>Màn hình: {{$laptop->man_hinh}}</p>
            <p>Giá: <span class='text-danger bold'>{{number_format($laptop->gia, 0, ',', '.')}} VNĐ</span></p>
            <p>Số lượng mua: <input type="number" id="product-number" name="so_luong" value="1" min="1">
                <button class='btn btn-primary ms-1' id='add-to-cart-btn' data-id="{{$laptop->id}}">Thêm vào giỏ hàng</button>
            </p>
            <hr>
            <h2>Thông tin khác</h2>
            <p>Khối lượng: {{$laptop->khoi_luong}}</p>
            <p>Webcam: {{$laptop->webcam}}</p>
            <p>Pin: {{$laptop->pin}}</p>
            <p>Kết nối không dây: {{$laptop->ket_noi_khong_day}}</p>
            <p>Bàn phím: {{$laptop->ban_phim}}</p>
            <p>Cổng kết nối: {{$laptop->cong_ket_noi}}</p>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#add-to-cart-btn").click(function() {
                id = "{{$laptop->id}}";
                num = $("#product-number").val()
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{route('cartadd')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "num": num
                    },
                    beforeSend: function() {},
                    success: function(data) {
                        $("#cart-number-product").html(data);
                    },
                    error: function(xhr, status, error) {},
                    complete: function(xhr, status) {}
                });
            });
        });
    </script>
</x-laptop-layout>