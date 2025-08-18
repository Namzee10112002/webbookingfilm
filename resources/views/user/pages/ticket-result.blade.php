@extends('user.layout')

@section('title', 'Kết quả tra cứu vé')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Kết quả tra cứu</h2>

    <div class="card mb-5">
        <div class="card-body ">
            <h4>Thông tin đơn hàng #{{ $order->id }}</h4>
            <p><strong>Tên khách hàng:</strong> {{ $order->name_order }}</p>
            <p><strong>Email:</strong> {{ $order->email_order }}</p>
            <p><strong>SĐT:</strong> {{ $order->phone_order }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->date_order }}</p>
            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_order,0,',','.') }} ₫</p>

            <h5>Vé đã đặt:</h5>
            <ul>
                @foreach($order->details as $detail)
                <li>
                    Phim: {{ $detail->seat->show->movie->name_movie }} <br>
                    Rạp: {{ $detail->seat->show->room->theater->name_theater }} <br>
                    Phòng: {{ $detail->seat->show->room->name_room }} <br>
                    Suất chiếu: {{ date('H:i d/m/Y', strtotime($detail->seat->show->time_start)) }} <br>
                    Ghế: <strong>{{ $detail->seat_label }}</strong>
                </li>
                @endforeach
            </ul>

        </div>
    </div>
</div>
@endsection