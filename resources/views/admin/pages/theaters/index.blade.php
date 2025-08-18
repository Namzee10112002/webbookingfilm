@extends('admin.layout')
@section('title','Rạp - '.$company->name_company.' - '.$city->name_city)
@section('content')
<div class="container py-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Rạp của {{ $company->name_company }} tại {{ $city->name_city }}</h3>
    <a href="{{ route('admin.companies.cities',$company->id) }}" class="btn btn-light">Đổi thành phố</a>
  </div>

  {{-- Thêm mới rạp --}}
  <form class="card card-body mb-4" method="post" action="{{ route('admin.companies.theaters.store',[$company->id,$city->id]) }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Tên rạp</label>
        <input name="name_theater" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Địa chỉ</label>
        <input name="address_theater" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Ảnh (URL)</label>
        <input name="image_theater" class="form-control" placeholder="https://..." required>
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">Lưu</button>
      </div>
    </div>
  </form>

  {{-- Bảng rạp --}}
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr>
        <th>#</th><th>Ảnh</th><th>Tên rạp</th><th>Địa chỉ</th><th>Phòng</th><th>Trạng thái</th><th>Hành động</th>
      </tr></thead>
      <tbody>
        @foreach($theaters as $t)
        <tr>
          <td>{{ $t->id }}</td>
          <td><img src="{{ $t->image_theater }}" style="height:40px"></td>
          <td>{{ $t->name_theater }}</td>
          <td>{{ $t->address_theater }}</td>
          <td>{{ $t->rooms_count }}</td>
          <td>{!! $t->status_theater == 0 ?'<span class="badge bg-success">Hiện</span>':'<span class="badge bg-secondary">Ẩn</span>' !!}</td>
          <td class="d-flex flex-wrap gap-2">
            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.companies.rooms',$t->id) }}">Chi tiết phòng</a>
            <a class="btn btn-sm btn-outline-info" href="{{ route('admin.companies.theater.movies',$t->id) }}">Phim đang chiếu</a>
            <a class="btn btn-sm btn-outline-warning" href="{{ route('admin.companies.theaters.edit',[$company->id,$city->id,$t->id]) }}">Sửa</a>
            <form method="post" action="{{ route('admin.companies.theaters.toggle',[$company->id,$city->id,$t->id]) }}">
              @csrf @method('patch')
              <button class="btn btn-sm btn-outline-dark">{{ $t->status_theater == 0 ? 'Ẩn':'Hiện' }}</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
