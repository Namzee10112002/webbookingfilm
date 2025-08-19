@extends('user.layout')

@section('title', $movie->name_movie)

@section('content')
    <div class="container mt-4">
        <div class="row">
            {{-- Cột trái: Thông tin phim (30%) --}}
            <div class="col-md-4">
                <div class="card mb-3">
                    <img src="{{ $movie->image_movie ?: '/images/default-movie.jpg' }}" class="card-img-top"
                        alt="{{ $movie->name_movie }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $movie->name_movie }}</h5>
                        <ul class="list-unstyled">
                            <li><strong>Thể loại:</strong> {{ $movie->categories }}</li>
                            <li><strong>Đạo diễn:</strong> {{ $movie->director }}</li>
                            <li><strong>Diễn viên:</strong> {{ $movie->actors }}</li>
                            <li><strong>Thời lượng:</strong> {{ $movie->duration }} phút</li>
                            <li><strong>Quốc gia:</strong> {{ $movie->country }}</li>
                            <li><strong>Ngày phát hành:</strong> {{ $movie->date_release }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Cột phải: Nội dung chính (70%) --}}
            <div class="col-md-8">
                {{-- Poster, tên, mô tả, nút đặt vé --}}
                <div class="mb-4">
                    <h2>{{ $movie->name_movie }}</h2>
                    <p>{{ $movie->description_movie }}</p>
                    <a class="btn btn-danger btn-sm btn-book" data-movie="{{ $movie->id }}" data-bs-toggle="modal"
                        data-bs-target="#cityModal">
                        Đặt vé
                    </a>
                </div>

                {{-- Trailer --}}
                @if($movie->trailer)
                    <div class="mb-4">
                        <h4>Trailer</h4>
                        <div class="ratio ratio-16x9">
                            {!! $movie->trailer !!}
                        </div>
                    </div>
                @endif
                {{-- Like + Rating --}}
                <div class="mb-4">
                    <h4>Cảm nhận của bạn</h4>

                    {{-- Like --}}
                    @auth
                        <button id="btn-like" class="btn btn-sm {{ $userLiked ? 'btn-secondary' : 'btn-outline-secondary' }}">
                            {{ $userLiked ? 'Đã thích' : 'Thích' }}
                        </button>
                    @else
                        <p><a href="{{ route('auth', ['form' => 'login']) }}">Đăng nhập</a> để like và đánh giá.</p>
                    @endauth

                    <p class="mt-2">Tổng lượt thích: <span id="like-count">{{ $totalLikes }}</span></p>

                    {{-- Rating --}}
                    @auth
                        <div id="rating" class="mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star star {{ $userRating >= $i ? 'text-warning' : 'text-secondary' }}"
                                    data-value="{{ $i }}" style="cursor:pointer; font-size: 22px;"></i>
                            @endfor
                        </div>
                    @endauth

                    <p class="mt-2">
                        Trung bình:
                        <span id="avg-rating">{{ number_format($avgRating, 1) }}</span>
                        <i class="fa fa-star text-warning"></i>
                    </p>
                </div>

                {{-- Comment --}}
                <div class="mb-4">
                    <h4>Bình luận</h4>
                    @auth
                        <form action="{{ route('movie.comment', $movie->id) }}" method="POST" class="mb-3">
                            @csrf
                            <textarea name="content" class="form-control mb-2" rows="3"
                                placeholder="Nhập bình luận..."></textarea>
                            <button type="submit" class="btn btn-success">Gửi</button>
                        </form>
                    @else
                        <p><a href="{{ route('auth', ['form' => 'login']) }}">Đăng nhập</a> để bình luận.</p>
                    @endauth

                    {{-- Danh sách comment --}}
                    @forelse($comments as $comment)
                        <div class="border rounded p-2 mb-2">
                            <strong>{{ $comment->user->name }}</strong>
                            <small class="text-muted">{{ $comment->date_comment }}</small>
                            <p class="mb-0">{{ $comment->content_comment }}</p>
                        </div>
                    @empty
                        <p>Chưa có bình luận nào.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

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
            // Like
            $('#btn-like').click(function () {
                $.post("{{ route('movie.like', $movie->id) }}", { _token: '{{ csrf_token() }}' }, function (res) {
                    $('#like-count').text(res.totalLikes);
                    if (res.status === 'liked') {
                        $('#btn-like').removeClass('btn-outline-secondary').addClass('btn-secondary').text('Đã thích');
                    } else {
                        $('#btn-like').removeClass('btn-secondary').addClass('btn-outline-secondary').text('Thích');
                    }
                });
            });

            // Rating
            $('.star').click(function () {
                let value = $(this).data('value');
                $.post("{{ route('movie.rate', $movie->id) }}", {
                    _token: '{{ csrf_token() }}',
                    rate: value
                }, function (res) {
                    $('#avg-rating').text(res.avgRating);
                    $('.star').each(function () {
                        if ($(this).data('value') <= value) {
                            $(this).removeClass('text-secondary').addClass('text-warning');
                        } else {
                            $(this).removeClass('text-warning').addClass('text-secondary');
                        }
                    });
                });
            });
        });
    </script>

@endpush