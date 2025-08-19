@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h3>Chọn hãng rạp để xem hóa đơn</h3>
    <ul class="list-group">
        @foreach($companies as $company)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $company->name_company }}</span>
                <a href="{{ route('admin.company', $company->id) }}" class="btn btn-sm btn-primary">
                    Xem hóa đơn
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
