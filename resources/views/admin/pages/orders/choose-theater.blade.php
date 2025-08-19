@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h3>Chọn rạp để xem hóa đơn</h3>

    <ul class="list-group">
        @foreach($theaters as $theater)
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    <strong>{{ $theater->name_theater }}</strong><br>
                    <small>Hãng rạp: {{ $theater->company->name_company ?? '' }}</small>
                </div>
                <a href="{{ route('admin.theater', $theater->id) }}" class="btn btn-sm btn-primary">
                    Xem hóa đơn
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
