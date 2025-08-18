@extends('admin.layout')
@section('title','Suất chiếu - '.$movie->name_movie.' @ '.$theater->name_theater)
@section('content')
<div class="container py-3">
  <h3 class="mb-3">Suất chiếu: {{ $movie->name_movie }} – {{ $theater->name_theater }}</h3>

  <form class="card card-body mb-4" method="post" action="{{ route('admin.companies.shows.store',[$theater->id,$movie->id]) }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Phòng</label>
        <select class="form-select" name="room_id" required>
          @foreach($theater->rooms as $r)
            <option value="{{ $r->id }}">{{ $r->name_room }}</option>
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
      <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">Lưu</button>
      </div>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr>
        <th>#</th><th>Phòng</th><th>Giờ</th><th>Giá</th><th>Trạng thái</th><th>Hành động</th>
      </tr></thead>
      <tbody>
        @foreach($shows as $s)
        <tr>
          <td>{{ $s->id }}</td>
          <td>{{ $s->room->name_room }}</td>
          <td>{{ date('H:i d/m/Y', strtotime($s->time_start)) }} → {{ date('H:i d/m/Y', strtotime($s->time_end)) }}</td>
          <td>{{ number_format($s->price) }} ₫</td>
          <td>{!! $s->status_show ==0 ?'<span class="badge bg-success">Hiện</span>':'<span class="badge bg-secondary">Ẩn</span>' !!}</td>
          <td class="d-flex flex-wrap gap-2">
            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.companies.shows.monitor',$s->id) }}">Xem bản đồ ghế</a>
            <form method="post" action="{{ route('admin.companies.shows.toggle',$s->id) }}">
              @csrf @method('patch')
              <button class="btn btn-sm btn-outline-dark">{{ $s->status_show ==0 ? 'Ẩn':'Hiện' }}</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
