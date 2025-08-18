@extends('admin.layout')
@section('title','Quản lý người dùng')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Danh sách người dùng</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Tổng chi tiêu</th>
                    <th>Số phim đã thích</th>
                    <th>Số bình luận</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key=>$u)
                <tr id="row-{{ $u->id }}">
                    <td>{{ $key+1 }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->phone }}</td>
                    <td>{{ number_format($u->total_spent,0,',','.') }} ₫</td>
                    <td>{{ $u->total_likes }}</td>
                    <td>{{ $u->total_comments }}</td>
                    <td>
                        <span class="badge {{ $u->status == 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $u->status == 0 ? 'Hoạt động' : 'Bị khóa' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-{{ $u->status == 0 ? 'danger':'success' }} toggle-status" 
                                data-id="{{ $u->id }}">
                            {{ $u->status == 0 ? 'Khóa' : 'Mở khóa' }}
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('.toggle-status').click(function(){
        let btn = $(this);
        let id = btn.data('id');

        $.post("{{ url('admin/users') }}/"+id+"/toggle-status", {
            _token: "{{ csrf_token() }}"
        }, function(res){
            if(res.success){
                let row = $("#row-"+id);
                let badge = row.find('span.badge');
                if(res.status == 0){
                    badge.removeClass('bg-danger').addClass('bg-success').text('Hoạt động');
                    btn.removeClass('btn-success').addClass('btn-danger').text('Khóa');
                }else{
                    badge.removeClass('bg-success').addClass('bg-danger').text('Bị khóa');
                    btn.removeClass('btn-danger').addClass('btn-success').text('Mở khóa');
                }
            }
        });
    });
});
</script>
@endpush
