<x-laptop-layout>
	<x-slot name="title">Quản lý sản phẩm</x-slot>

	<h2 class="text-center text-primary font-weight-bold my-2">QUẢN LÝ SẢN PHẨM</h2>

	@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif

	@if(session('error'))
		<div class="alert alert-danger">{{ session('error') }}</div>
	@endif

	<table id="products-table" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Tiêu đề</th>
				<th>CPU</th>
				<th>RAM</th>
				<th>Ổ cứng</th>
				<th>Khối lượng</th>
				<th>Nhu cầu</th>
				<th>Giá</th>
				<th>Ảnh</th>
				<th>Thao tác</th>
			</tr>
		</thead>
		<tbody>
			@foreach($laptops as $item)
				<tr>
					<td>{{ $item->tieu_de ?? $item->ten_san_pham }}</td>
					<td>{{ $item->cpu ?? '' }}</td>
					<td>{{ $item->ram ?? '' }}</td>
					<td>{{ $item->o_cung ?? '' }}</td>
					<td>{{ $item->khoi_luong ?? '' }}</td>
					<td>{{ $item->nhu_cau ?? '' }}</td>
					<td>{{ number_format($item->gia_ban ?? $item->gia ?? 0, 0, ',', '.') }}</td>
					<td>
						<img src="{{ asset('storage/image/'.$item->hinh_anh) }}" alt="{{ $item->tieu_de ?? $item->ten_san_pham }}" style="width:40px; height:auto;">
					</td>
					<td class="d-flex">
						<a href="{{ url('chi-tiet/' . $item->id) }}" class="btn btn-primary btn-sm mr-2">Xem</a>
						<form action="{{ route('laptop.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn btn-danger btn-sm">Xóa</button>
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<script>
		$(document).ready(function () {
			$('#products-table').DataTable({
				pageLength: 10,
				lengthMenu: [10, 25, 50, 100],
			});
		});
	</script>
</x-laptop-layout>
