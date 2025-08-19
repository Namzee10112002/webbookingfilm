@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2>Danh sách hóa đơn</h2>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Tìm theo mã, user, phim..." value="{{ request('q') }}">
            <button class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Rạp</th>
                <th>Tổng tiền</th>
                <th>Ngày đặt</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'Guest' }}</td>
                <td>{{ $order->details->first()->seat->show->room->theater->name_theater ?? '' }}</td>
                <td>{{ number_format($order->total_order, 0, ',', '.') }} đ</td>
                <td>{{ $order->date_order }}</td>
                <td>
                    <a href="{{ route('admin.show', $order->id) }}" class="btn btn-sm btn-info">Xem</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection
