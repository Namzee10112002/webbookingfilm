@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2>📊 Báo cáo thống kê</h2>

    {{-- Bộ lọc --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-2">
            <select name="year" class="form-select">
                @for($y = now()->year; $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <select name="month" class="form-select">
                <option value="">-- Cả năm --</option>
                @for($m=1;$m<=12;$m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Lọc</button>
        </div>
    </form>

    {{-- Các chỉ số tổng quan --}}
    <div class="row text-center mb-4">
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h5>Doanh thu</h5>
                <strong>{{ number_format($totalRevenue, 0, ',', '.') }} đ</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h5>Đơn hàng</h5>
                <strong>{{ $totalOrders }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h5>Vé bán</h5>
                <strong>{{ $totalTickets }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h5>Người dùng</h5>
                <strong>{{ $usersCount }}</strong>
            </div>
        </div>
    </div>

    <div class="row text-center mb-4">
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h5>Số phim</h5>
                <strong>{{ $moviesCount }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h5>Số rạp</h5>
                <strong>{{ $theatersCount }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h5>Tổng lượt thích</h5>
                <strong>{{ $likesCount }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h5>Rate trung bình</h5>
                <strong>{{ number_format($avgRate,1) }}</strong>
            </div>
        </div>
    </div>

    {{-- Biểu đồ doanh thu --}}
    <div class="card mt-4 p-3">
        <h5>📈 Doanh thu theo tháng ({{ $year }})</h5>
        <canvas id="revenueChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json(range(1,12)),
        datasets: [{
            label: 'Doanh thu',
            data: @json(array_values($monthlyRevenue)),
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endpush
