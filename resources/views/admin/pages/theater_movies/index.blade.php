@extends('admin.layout')
@section('title','Phim đang chiếu - '.$theater->name_theater)
@section('content')
<div class="container py-3">
  <h3 class="mb-3">Phim đang chiếu tại: {{ $theater->name_theater }}</h3>

  {{-- Thêm phim đang chiếu (tạo 1 suất chiếu) --}}
  <div class="card card-body mb-4">
    <form method="post" action="{{ route('admin.companies.theater.movies.attach',$theater->id) }}">
      @csrf
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Chọn phim</label>
          <select class="form-select" name="movie_id" required>
            @foreach(\App\Models\Movie::orderBy('id','desc')->get() as $m)
              <option value="{{ $m->id }}">{{ $m->name_movie ?? ('#'.$m->id) }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Phòng</label>
          <select class="form-select" name="room_id" required>
            @foreach($rooms as $r)
              <option value="{{ $r->id }}">{{ $r->name_room }} ({{ $r->seat }} ghế)</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Giá</label>
          <input type="number" name="price" class="form-control" min="0" value="100000" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Bắt đầu</label>
          <input type="datetime-local" name="time_start" class="form-control" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Kết thúc</label>
          <input type="datetime-local" name="time_end" class="form-control" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-primary w-100">Lưu</button>
        </div>
      </div>
    </form>
  </div>

  {{-- Danh sách phim đang chiếu (distinct) --}}
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>#</th><th>Tên phim</th><th>Hành động</th></tr></thead>
      <tbody>
        @forelse($movies as $m)
        <tr>
          <td>{{ $m->id }}</td>
          <td>{{ $m->name_movie ?? '(không tên)' }}</td>
          <td class="d-flex gap-2">
            <a class="btn btn-sm btn-outline-primary"
               href="{{ route('admin.companies.shows',[$theater->id,$m->id]) }}">Quản lý suất chiếu</a>
          </td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-muted">Chưa có phim nào đang chiếu tại rạp này.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
