<x-laptop-layout>
    <x-slot name="title">Chi tiết sản phẩm</x-slot>

    <h2 class="text-center text-primary font-weight-bold my-3">CHI TIẾT SẢN PHẨM</h2>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/image/'.$laptop->hinh_anh) }}" alt="{{ $laptop->tieu_de ?? $laptop->ten_san_pham }}" style="max-width: 100%; height: auto;">
                </div>
                <div class="col-md-8">
                    <h4 class="mb-3">{{ $laptop->tieu_de ?? $laptop->ten_san_pham }}</h4>
                    <p><strong>CPU:</strong> {{ $laptop->cpu ?? '' }}</p>
                    <p><strong>RAM:</strong> {{ $laptop->ram ?? '' }}</p>
                    <p><strong>Ổ cứng:</strong> {{ $laptop->o_cung ?? '' }}</p>
                    <p><strong>Khối lượng:</strong> {{ $laptop->khoi_luong ?? '' }}</p>
                    <p><strong>Nhu cầu:</strong> {{ $laptop->nhu_cau ?? '' }}</p>
                    <p><strong>Giá:</strong> {{ number_format($laptop->gia_ban ?? $laptop->gia ?? 0, 0, ',', '.') }} VNĐ</p>

                    <a href="{{ route('laptop.manage') }}" class="btn btn-secondary mt-2">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</x-laptop-layout>
