@extends('admin.layout')
@section('title','Chọn thành phố - '.$company->name_company)
@section('content')
<div class="container py-3">
  <h3 class="mb-3">Xem rạp của <strong>{{ $company->name_company }}</strong> theo thành phố</h3>
  <div class="card card-body">
    <form method="get" onsubmit="event.preventDefault(); window.location = this.city_id.value;">
      <label class="form-label">Chọn thành phố</label>
      <select class="form-select" name="city_id" required
        onchange="document.getElementById('goBtn').href='{{ route('admin.companies.theaters',[$company->id,'__CITY__']) }}'.replace('__CITY__',this.value)">
        <option value="">-- Chọn --</option>
        @foreach($cities as $city)
          <option value="{{ $city->id }}">{{ $city->name_city }}</option>
        @endforeach
      </select>
      <a id="goBtn" class="btn btn-primary mt-3" href="#" onclick="if(this.href.endsWith('#')) return false;">Xem danh sách rạp</a>
    </form>
  </div>
</div>
@endsection
