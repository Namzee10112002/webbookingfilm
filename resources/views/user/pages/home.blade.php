@extends('user.layout')

@section('title', 'Trang chủ')

@section('content')
    {{-- Banner quảng cáo --}}
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img height="600px"
                    src="https://designercomvn.s3.ap-southeast-1.amazonaws.com/wp-content/uploads/2017/07/26020212/poster-phim-hanh-dong.jpg"
                    class="d-block w-100" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img height="600px"
                    src="https://designercomvn.s3.ap-southeast-1.amazonaws.com/wp-content/uploads/2017/07/26020157/poster-phim-kinh-di.jpg"
                    class="d-block w-100" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img height="600px" src="https://insieutoc.vn/wp-content/uploads/2021/02/poster-ngang.jpg"
                    class="d-block w-100" alt="Banner 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    {{-- Phim nổi bật --}}
    <section class="container mt-5">
        <h3 class="mb-4">🎥 Phim đang chiếu nổi bật</h3>
        <div class="row">
            @foreach($movies as $movie)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $movie->image_movie ? $movie->image_movie : '/images/default-movie.jpg' }}"
                            class="card-img-top" alt="{{ $movie->name_movie }}" style="height: 300px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $movie->name_movie }}</h5>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('movie.show', $movie->id) }}" class="btn btn-outline-success btn-sm">Chi
                                        tiết</a>
                                    <a class="btn btn-danger btn-sm btn-book" data-movie="{{ $movie->id }}"
                                        data-bs-toggle="modal" data-bs-target="#cityModal">
                                        Đặt vé
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <section class="container mt-5">
    <h3 class="mb-4">Phim sắp chiếu</h3>
    <div class="row">
        @forelse($moviesComing as $movie)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $movie->image_movie ?: '/images/default-movie.jpg' }}" class="card-img-top" alt="{{ $movie->name_movie }}" style="height: 300px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->name_movie }}</h5>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('movie.show', $movie->id) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                            <span class="badge bg-warning text-dark">Sắp chiếu</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>Hiện chưa có phim sắp chiếu nào.</p>
        @endforelse
    </div>
</section>
    {{-- Modal chọn thành phố --}}
    <div class="modal fade" id="cityModal" tabindex="-1" aria-labelledby="cityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cityModalLabel">Chọn thành phố</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select id="citySelect" class="form-select">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name_city }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="selectedMovieId">
                </div>
                <div class="modal-footer">
                    <button type="button" id="confirmCity" class="btn btn-primary">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    @if (session('momo_pay_url'))
    <script>
        window.open('{{ session('momo_pay_url') }}', '_blank');
    </script>
@endif
@if (session('success'))
    <script>
        alert('Cảm ơn bạn đã đặt vé xem phim của chúng tôi. Đây là mã đơn hàng {{ session('success') }} của bạn hãy đưa mã này cho nhân viên soát vé để được vào ! Bạn cũng có thể tra cứu vé của mình bằng mã này!');
    </script>
@endif
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            // Lấy movie id khi bấm nút Đặt vé
            $('.btn-book').click(function () {
                let movieId = $(this).data('movie');
                $('#selectedMovieId').val(movieId);
            });

            // Xác nhận chọn city
            $('#confirmCity').click(function () {
                let cityId = $('#citySelect').val();
                let movieId = $('#selectedMovieId').val();
                window.location.href = "/movie/" + movieId + "/book/" + cityId;
            });
        });
    </script>
@endpush