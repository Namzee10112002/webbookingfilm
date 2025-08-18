@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2>Sửa thông tin phòng chiếu</h2>

    <form action="{{ route('admin.companies.rooms.update', [$room->theater_id ,$room->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name_room" class="form-label">Tên phòng</label>
            <input type="text" name="name_room" id="name_room" 
                   class="form-control" value="{{ old('name_room', $room->name_room) }}" required>
        </div>

        <div class="mb-3">
            <label for="theater_id" class="form-label">Thuộc rạp</label>
            <select name="theater_id" id="theater_id" class="form-select" required>
                @foreach($theaters as $theater)
                    <option value="{{ $theater->id }}" 
                        {{ $room->theater_id == $theater->id ? 'selected' : '' }}>
                        {{ $theater->name_theater }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="seat" class="form-label">Sức chứa</label>
            <input type="number" name="seat" id="seat" 
                   class="form-control" value="{{ old('seat', $room->seat) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.companies.rooms', $room->theater_id) }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
