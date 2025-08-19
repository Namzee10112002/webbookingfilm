@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h3>Chi tiết hóa đơn #{{ $order->id }}</h3>

    <p><strong>Khách hàng:</strong> {{ $order->name_order ?? '' }}</p>
    <p><strong>Hãng rạp:</strong> {{ $order->details->first()->seat->show->room->theater->company->name_company ?? '' }}</p>
    <p><strong>Rạp:</strong> {{ $order->details->first()->seat->show->room->theater->name_theater ?? '' }}</p>
    <p><strong>Ngày đặt:</strong> {{ $order->date_order }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($order->total_order, 0, ',', '.') }} đ</p>

    <h5>Danh sách vé:</h5>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Phim</th>
                <th>Suất chiếu</th>
                <th>Ghế</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->details as $detail)
            <tr>
                <td>{{ $detail->seat->show->movie->name_movie }}</td>
                <td>{{ $detail->seat->show->time_start ?? '' }} - {{ $detail->seat->show->time_end ?? '' }}</td>
                @php
    $row = chr(65 + floor(($detail->seat->seat_number - 1) / 20));
    $col = ($detail->seat->seat_number - 1) % 10 + 1;
@endphp
<td>{{ $row }}{{ $col }}</td>
                <td>{{ number_format($detail->seat->show->price, 0, ',', '.') }} đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
