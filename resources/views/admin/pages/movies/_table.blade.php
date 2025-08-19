<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>Ảnh</th>
            <th>Thông tin phim</th>
            <th>Thống kê</th>
            <th>Bình luận</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($movies as $movie)
            <tr style="height: 200px;">
                <!-- Cột ảnh -->
                <td class="col-1 align-middle">
                    <img src="{{ $movie->image_movie }}" width="80">
                </td>

                <!-- Cột thông tin -->
                <td class="col-3 align-middle">
                    <strong>{{ $movie->name_movie }}</strong><br>
                    Thể loại: {{ $movie->categories }}<br>
                    Quốc gia: {{ $movie->country }}<br>
                    Đạo diễn: {{ $movie->director }}<br>
                    Diễn viên: {{ $movie->actors }}<br>
                    <small>Phát hành: {{ $movie->date_release }}</small>
                </td>

                <!-- Cột thống kê -->
                <td class="col-1 align-middle">
                    <span class="badge bg-primary">Thích: {{ $movie->likes_count }}</span><br>
                    <span class="badge bg-success">
                        Rate TB: {{ number_format($movie->rates()->avg('user_rate'), 1) }}
                    </span>
                </td>

                <!-- Cột quản lý bình luận -->
                <td class="col-1 align-middle">
                    <a href="{{ route('admin.movies.comments', $movie->id) }}" class="btn btn-sm btn-info">
                        Quản lý ({{ $movie->comments()->count() }})
                    </a>
                </td>

                <!-- Cột hành động -->
                <td class="col-6 align-top">
                    <!-- Khung edit inline -->
                    <div style="max-height:180px; overflow-y:auto; padding:5px; border:1px solid #ddd; border-radius:5px;">
                        <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('admin.pages.movies._form')
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Cập nhật</button>
                        </form>
                    </div>

                    <!-- Nút toggle ẩn/hiện -->
                    <form action="{{ route('admin.movies.toggle', $movie->id) }}" method="POST" class="d-inline mt-2">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm {{ $movie->status_movie == 1 ? 'btn-success' : 'btn-warning' }}">
                            {{ $movie->status_movie == 1 ? 'Hiện' : 'Ẩn' }}
                        </button>
                    </form>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="5">Không có phim</td>
            </tr>
        @endforelse
    </tbody>
</table>