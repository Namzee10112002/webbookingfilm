@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2>Sửa thông tin rạp phim</h2>

    <form action="{{ route('admin.companies.theaters.update', [$theater->company_id,$theater->city_id,$theater->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="image_theater" class="form-label">Ảnh rạp</label>
            <input type="text" name="image_theater" id="image_theater" 
                   class="form-control" value="{{ old('image_theater', $theater->image_theater) }}" required>
        </div>
        <div class="mb-3">
            <label for="name_theater" class="form-label">Tên rạp</label>
            <input type="text" name="name_theater" id="name_theater" 
                   class="form-control" value="{{ old('name_theater', $theater->name_theater) }}" required>
        </div>

        <div class="mb-3">
            <label for="address_theater" class="form-label">Địa chỉ</label>
            <input type="text" name="address_theater" id="address_theater" 
                   class="form-control" value="{{ old('address_theater', $theater->address_theater) }}" required>
        </div>

        <div class="mb-3">
            <label for="city_id" class="form-label">Thành phố</label>
            <select name="city_id" id="city_id" class="form-select" required>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" 
                        {{ $theater->city_id == $city->id ? 'selected' : '' }}>
                        {{ $city->name_city }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">Thuộc hãng</label>
            <select name="company_id" id="company_id" class="form-select" required>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" 
                        {{ $theater->company_id == $company->id ? 'selected' : '' }}>
                        {{ $company->name_company }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.companies.theaters', [$theater->company_id,$theater->city_id]) }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
