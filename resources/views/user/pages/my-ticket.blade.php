@extends('user.layout')

@section('title', 'Vé của tôi')

@section('content')
<div class="container mt-4">
    <h3>🎟 Vé của tôi</h3>

    {{-- Vé sắp chiếu --}}
    <h4 class="mt-4">Sắp chiếu</h4>
    @forelse($upcoming as $order)
    <div class="card mb-3">
        <div class="card-header">
            Mã đơn: #{{ $order->id }} | Ngày đặt: {{ $order->date_order }}
            | Tổng tiền: {{ number_format($order->total_order, 0, ',', '.') }} ₫
        </div>
        <div class="card-body">
            @php
            $show = $order->details[0]->seat->show;
            $seat = $order->details[0]->seat;
            @endphp
            <div class="border p-2 mb-2">
                <strong>Phim:</strong> {{ $show->movie->name_movie }} <br>
                <strong>Xuất chiếu:</strong> {{ date('H:i d/m/Y', strtotime($show->time_start)) }} <br>
                <strong>Rạp:</strong> {{ $show->room->theater->name_theater }} - Phòng {{ $show->room->name_room }} <br>
                <p><strong>Ghế:</strong>
                    <span class="seat-list" data-seats="{{ $order->details->pluck('seat.seat_number')->join(',') }}"></span>
                </p>

            </div>
        </div>
    </div>
    @empty
    <p>Không có vé sắp chiếu.</p>
    @endforelse

    {{-- Vé đã chiếu --}}
    <h4 class="mt-4">Đã chiếu</h4>
    @forelse($past as $order)
    <div class="card mb-3">
        <div class="card-header">
            Mã đơn: #{{ $order->id }} | Ngày đặt: {{ $order->date_order }}
            | Tổng tiền: {{ number_format($order->total_order, 0, ',', '.') }} ₫
        </div>
        <div class="card-body">
            @php
            $show = $order->details[0]->seat->show;
            $seat = $order->details[0]->seat;
            @endphp
            <div class="border p-2 mb-2">
                <strong>Phim:</strong> {{ $show->movie->name_movie }} <br>
                <strong>Xuất chiếu:</strong> {{ date('H:i d/m/Y', strtotime($show->time_start)) }} <br>
                <strong>Rạp:</strong> {{ $show->room->theater->name_theater }} - Phòng {{ $show->room->name_room }} <br>
                <p><strong>Ghế:</strong>
                    <span class="seat-list" data-seats="{{ $order->details->pluck('seat.seat_number')->join(',') }}"></span>
                </p>

            </div>
        </div>
    </div>
    @empty
    <p>Không có vé đã chiếu.</p>
    @endforelse
</div>
@endsection
@push('scripts')
<script>
    function formatSeatCode(seatNumber, seatsPerRow = 20) {
        let rowIndex = Math.floor((seatNumber - 1) / seatsPerRow); // Hàng
        let colIndex = (seatNumber - 1) % seatsPerRow + 1; // Ghế trong hàng
        return String.fromCharCode(65 + rowIndex) + colIndex; // Ví dụ: A1, B5
    }

    document.querySelectorAll('.seat-list').forEach(el => {
        let rawSeats = el.dataset.seats.split(',').map(Number);
        let formatted = rawSeats.map(s => formatSeatCode(s)).join(', ');
        el.textContent = formatted;
    });
</script>
@endpush