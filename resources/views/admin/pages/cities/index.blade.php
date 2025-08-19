@extends('admin.layout')

@section('title', 'Quản lý thành phố')
@push('styles')
<style>
    [aria-hidden="true"] {
        pointer-events: none;
    }
</style>
@endpush
@section('content')
<div class="container mt-4">
    <h3>Quản lý thành phố</h3>

    {{-- Form thêm --}}
    <form action="{{ route('admin.cities.store') }}" method="POST" class="row g-2 mb-4">
        @csrf
        <div class="col-md-6">
            <input type="text" name="name_city" class="form-control" placeholder="Tên thành phố" required>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success">Thêm</button>
        </div>
    </form>

    {{-- Bảng danh sách --}}
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên thành phố</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cities as $city)
            <tr data-id="{{ $city->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>
                    <input type="text" class="form-control city-name-input"
                        value="{{ $city->name_city }}"
                        data-id="{{ $city->id }}">
                </td>
                <td>
                    <button class="btn btn-sm toggle-status {{ $city->status_city ? 'btn-danger' : 'btn-success' }}"
                        data-id="{{ $city->id }}">
                        {{ $city->status_city ? 'Ẩn' : 'Hiện' }}
                    </button>
                </td>
                <td>
                    <button class="btn btn-primary btn-save" data-id="{{ $city->id }}">
                        Lưu
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    // Khi bấm nút Lưu
    $('.btn-save').click(function(){
        let id = $(this).data('id');
        let name = $(`input.city-name-input[data-id="${id}"]`).val();

        $.ajax({
            url: `/admin/cities/${id}`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name_city: name
            },
            success: function(res){
                alert('Cập nhật thành công');
            },
            error: function(){
                alert('Có lỗi xảy ra!');
            }
        });
    });

    // Toggle status
    $('.toggle-status').click(function(){
        let id = $(this).data('id');
        $.ajax({
            url: `/admin/cities/${id}/toggle`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res){
                location.reload();
            }
        });
    });
});
</script>

@endpush