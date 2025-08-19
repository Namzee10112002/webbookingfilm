@extends('admin.layout')

@section('content')
    <div class="container mt-4">
        <h2>Quản lý phim</h2>
        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.pages.movies._form')
            <button type="submit" class="btn btn-success">Thêm phim</button>
        </form>

        {{-- Phim đang chiếu --}}
        <h4>🎬 Phim đang chiếu</h4>
        @include('admin.pages.movies._table', ['movies' => $nowShowing])

        {{-- Phim sắp chiếu --}}
        <h4 class="mt-4">⏳ Phim sắp chiếu</h4>
        @include('admin.pages.movies._table', ['movies' => $comingSoon])

        {{-- Phim ẩn --}}
        <h4 class="mt-4">🙈 Phim ẩn</h4>
        @include('admin.pages.movies._table', ['movies' => $hidden])
    </div>
@endsection