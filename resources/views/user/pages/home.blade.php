@extends('user.layout')

@section('title', 'Trang chủ')

@section('content')
    {{-- Banner quảng cáo --}}
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img height="600px" src="https://designercomvn.s3.ap-southeast-1.amazonaws.com/wp-content/uploads/2017/07/26020212/poster-phim-hanh-dong.jpg" class="d-block w-100" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img height="600px" src="https://designercomvn.s3.ap-southeast-1.amazonaws.com/wp-content/uploads/2017/07/26020157/poster-phim-kinh-di.jpg" class="d-block w-100" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img height="600px" src="https://insieutoc.vn/wp-content/uploads/2021/02/poster-ngang.jpg" class="d-block w-100" alt="Banner 3">
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
        <div id="movieCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner movie-slide">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="/images/movie1.jpg" class="w-100 rounded">
                            <p class="text-center mt-2">Tên phim 1</p>
                        </div>
                        <div class="col-md-3">
                            <img src="/images/movie2.jpg" class="w-100 rounded">
                            <p class="text-center mt-2">Tên phim 2</p>
                        </div>
                        <div class="col-md-3">
                            <img src="/images/movie3.jpg" class="w-100 rounded">
                            <p class="text-center mt-2">Tên phim 3</p>
                        </div>
                        <div class="col-md-3">
                            <img src="/images/movie4.jpg" class="w-100 rounded">
                            <p class="text-center mt-2">Tên phim 4</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="/images/movie1.jpg" class="w-100 rounded">
                            <p class="text-center mt-2">Tên phim 1</p>
                        </div>
                        <div class="col-md-3">
                            <img src="/images/movie2.jpg" class="w-100 rounded">
                            <p class="text-center mt-2">Tên phim 2</p>
                        </div>
                        <div class="col-md-3">
                            <img src="/images/movie3.jpg" class="w-100 rounded">
                            <p class="text-center mt-2">Tên phim 3</p>
                        </div>
                        <div class="col-md-3">
                            <img src="/images/movie4.jpg" class="w-100 rounded">
                            <p class="text-center mt-2">Tên phim 4</p>
                        </div>
                    </div>
                </div>
                {{-- Thêm các slide khác ở đây --}}
            </div>
        </div>
    </section>
@endsection
