<x-laptop-layout>
    <x-slot name="title">{{ $title ?? 'Danh sách laptop' }}</x-slot>
    <div class="d-flex justify-content-end my-3">
        <span class="mr-2 mt-1">Sắp xếp:</span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}" class="btn btn-sm btn-outline-primary mr-2">
            Giá tăng dần <i class="fa fa-arrow-up"></i>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}" class="btn btn-sm btn-outline-primary">
            Giá giảm dần <i class="fa fa-arrow-down"></i>
        </a>
    </div>

    <div class="list-laptop">
        @forelse($laptops as $item)
        <div class="laptop">
            <a href="#">
                <img src="{{ asset('storage/image/'.$item->hinh_anh) }}" alt="{{ $item->tieu_de ?? $item->ten_san_pham }}" style="width:100%; height:auto;">

                <div class="p-2 d-flex flex-column" style="min-height: 140px;">
                    <h6 style="font-size:14px; color:#122333; font-weight:bold; line-height:1.35; min-height: 56px; margin-bottom: 10px;">
                        {{ $item->tieu_de ?? $item->ten_san_pham }}
                    </h6>

                    <p class="text-danger font-weight-bold mb-1 mt-auto">
                        {{ number_format($item->gia_ban ?? $item->gia, 0, ',', '.') }} VNĐ
                    </p>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center text-muted mt-5">
            <p>Không có sản phẩm nào để hiển thị.</p>
        </div>
        @endforelse
    </div>
</x-laptop-layout>