@extends('admin.layout')
@section('title','Phòng - '.$theater->name_theater)
@section('content')
<div class="container py-3">
  <h3 class="mb-3">Phòng chiếu - {{ $theater->name_theater }}</h3>

  <form class="card card-body mb-4" method="post" action="{{ route('admin.companies.rooms.store',$theater->id) }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-5">
        <label class="form-label">Tên phòng</label>
        <input name="name_room" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Số ghế</label>
        <input type="number" min="1" name="seat" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Hiển thị</label>
        <select class="form-select" name="status_room">
          <option value="1">Hiện</option>
          <option value="0" selected>Ẩn</option>
        </select>
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">Lưu</button>
      </div>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr>
        <th>#</th><th>Tên phòng</th><th>Số ghế</th><th>Trạng thái</th><th>Hành động</th>
      </tr></thead>
      <tbody>
        @foreach($rooms as $r)
        <tr>
          <td>{{ $r->id }}</td>
          <td>{{ $r->name_room }}</td>
          <td>{{ $r->seat }}</td>
          <td>{!! $r->status_room == 0?'<span class="badge bg-success">Hiện</span>':'<span class="badge bg-secondary">Ẩn</span>' !!}</td>
          <td class="d-flex gap-2">
            <a class="btn btn-sm btn-outline-warning" href="{{ route('admin.companies.rooms.edit',[$theater->id,$r->id]) }}">Sửa</a>
            <form method="post" action="{{ route('admin.companies.rooms.toggle',[$theater->id,$r->id]) }}">
              @csrf @method('patch')
              <button class="btn btn-sm btn-outline-dark">{{ $r->status_room == 0? 'Ẩn':'Hiện' }}</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
