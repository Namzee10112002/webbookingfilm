@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h3>Chọn phim để xem hóa đơn</h3>

    <ul class="list-group">
        @foreach($movies as $movie)
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    <strong>{{ $movie->name_movie }}</strong><br>
                    <small>Thể loại: {{ $movie->categories }} | Quốc gia: {{ $movie->country }}</small>
                </div>
                <a href="{{ route('admin.movie', $movie->id) }}" class="btn btn-sm btn-primary">
                    Xem hóa đơn
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
