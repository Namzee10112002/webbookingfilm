@extends('admin.layout')
@section('title','Sửa hãng rạp')
@section('content')
<div class="container py-3">
  <h3 class="mb-3">Sửa hãng rạp</h3>
  <form class="card card-body" method="post" action="{{ route('admin.companies.update',$company->id) }}">
    @csrf @method('put')
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Tên hãng</label>
        <input name="name_company" class="form-control" value="{{ $company->name_company }}" required>
      </div>
      <div class="col-md-5">
        <label class="form-label">Logo (URL)</label>
        <input name="logo_company" class="form-control" value="{{ $company->logo_company }}" required>
      </div>
      <div class="col-md-2">
        <label class="form-label">Hiển thị</label>
        <select class="form-select" name="status_company">
          <option value="1" @selected($company->status_company==1)>Hiện</option>
          <option value="0" @selected($company->status_company==0)>Ẩn</option>
        </select>
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">Lưu</button>
      </div>
    </div>
  </form>
</div>
@endsection
