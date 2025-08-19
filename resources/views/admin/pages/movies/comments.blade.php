@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h3>Bình luận cho phim: {{ $movie->name_movie }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Nội dung</th>
                <th>Ngày</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $cmt)
            <tr>
                <td>{{ $cmt->user_id }}</td>
                <td>{{ $cmt->content_comment }}</td>
                <td>{{ $cmt->date_comment }}</td>
                <td>{{ $cmt->status_comment ? 'Hiện' : 'Ẩn' }}</td>
                <td>
                    <form action="{{ route('admin.comments.toggle', $cmt->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm {{ $cmt->status_comment ? 'btn-warning' : 'btn-success' }}">
                            {{ $cmt->status_comment ? 'Ẩn' : 'Hiện' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
