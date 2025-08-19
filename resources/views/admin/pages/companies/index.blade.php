@extends('admin.layout')
@section('title','Hãng rạp phim')
@section('content')
<div class="container py-3">
  <h3 class="mb-3">Hãng rạp phim</h3>

  {{-- Form thêm mới --}}
  <form class="card card-body mb-4" method="post" action="{{ route('admin.companies.store') }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Tên hãng</label>
        <input name="name_company" class="form-control" required>
      </div>
      <div class="col-md-5">
        <label class="form-label">Logo (URL)</label>
        <input name="logo_company" class="form-control" placeholder="https://..." required>
      </div>
      <div class="col-md-2">
        <label class="form-label">Hiển thị</label>
        <select class="form-select" name="status_company">
          <option value="1">Hiện</option>
          <option value="0" selected>Ẩn</option>
        </select>
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">Lưu</button>
      </div>
    </div>
  </form>

  {{-- Bảng danh sách --}}
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr>
        <th>#</th><th>Logo</th><th>Tên</th><th>Trạng thái</th><th>Hành động</th>
      </tr></thead>
      <tbody>
        @foreach($companies as $c)
        <tr>
          <td>{{ $c->id }}</td>
          <td><img src="{{ $c->logo_company }}" alt="" style="height:40px"></td>
          <td>{{ $c->name_company }}</td>
          <td>{!! $c->status_company == 0 ? '<span class="badge bg-success">Hiện</span>' : '<span class="badge bg-secondary">Ẩn</span>' !!}</td>
          <td class="d-flex gap-2">
            <a class="btn btn-sm btn-outline-primary"
               href="{{ route('admin.companies.cities',$c->id) }}">Xem chi tiết</a>
            <a class="btn btn-sm btn-outline-warning"
               href="{{ route('admin.companies.edit',$c->id) }}">Sửa</a>
            <form method="post" action="{{ route('admin.companies.toggle',$c->id) }}">
              @csrf @method('patch')
              <button class="btn btn-sm btn-outline-dark">{{ $c->status_company == 0 ? 'Ẩn' : 'Hiện' }}</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
