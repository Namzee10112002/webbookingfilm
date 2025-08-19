@extends('user.layout')

@section('title', 'Đặt vé - ' . $movie->name_movie)

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><strong>{{ $movie->name_movie }}</strong> - Rạp tại {{ $city->name_city }}</h3>

        {{-- Filter ngày --}}
        <form method="GET" class="d-flex">
            <input type="date" name="date" value="{{ $date }}" class="form-control me-2">
            <button type="submit" class="btn btn-secondary">Lọc</button>
        </form>
    </div>

    {{-- Filter hãng rạp --}}
    <div class="mb-3">
        <button class="btn btn-outline-dark me-2 filter-company" data-id="all">Tất cả</button>
        @foreach($companies as $company)
            <button class="btn btn-outline-primary me-2 filter-company" data-id="{{ $company->id }}">
                {{ $company->name_company }}
            </button>
        @endforeach
    </div>

    {{-- Danh sách rạp --}}
    <div class="row" id="theater-list">
        @foreach($theaters as $theater)
            <div class="col-md-6 mb-4 theater-item" data-company="{{ $theater->company_id }}">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div>
                            <img src="{{ $theater->image_theater ?: '/images/default-theater.jpg' }}" class="card-img-top mb-2"
                                 alt="{{ $theater->name_theater }}" style="height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="card-title">{{ $theater->name_theater }}</h5>
                        <p class="text-muted mb-1">
                            <i class="bi bi-building"></i> {{ $theater->company->name_company }}
                        </p>
                        <p class="mb-2"><i class="bi bi-geo-alt"></i> {{ $theater->address_theater }}</p>

                        {{-- Nút xổ xuống suất chiếu --}}
                        <button class="btn btn-danger " type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#schedules-{{ $theater->id }}">
                            Xem suất chiếu
                        </button>

                        <div class="collapse mt-3" id="schedules-{{ $theater->id }}">
                            @forelse($theater->shows as $show)
                                <div class="border rounded p-2 mb-2">
                                    <strong>Bắt đầu:</strong> {{ date('H:i', strtotime($show->time_start)) }} - 
                                    <strong>Kết thúc:</strong> {{ date('H:i', strtotime($show->time_end)) }} <br>
                                    <strong>Còn:</strong> {{ $show->available_seats }} ghế
                                    <a href="{{ route('booking.seats', $show->id) }}" class="btn btn-sm btn-primary float-end">
                                        Chọn ghế
                                    </a>
                                </div>
                            @empty
                                <p class="text-muted">Không có suất chiếu cho ngày này.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Filter theo hãng
    $('.filter-company').click(function(){
        let companyId = $(this).data('id');
        if(companyId === 'all') {
            $('.theater-item').show();
        } else {
            $('.theater-item').hide();
            $('.theater-item[data-company="'+companyId+'"]').show();
        }
    });
</script>
@endpush
