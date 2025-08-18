@extends('user.layout')

@section('title', 'Hãng rạp phim')

@section('content')
<div class="container mt-4">
    <h3>Danh sách các hãng rạp</h3>
    <div class="row">
        @foreach($companies as $company)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $company->logo_company ?: '/images/default-company.jpg' }}" class="card-img-top" width="100%" height="300px">
                    <div class="card-body text-center">
                        <h5>{{ $company->name_company }}</h5>
                        <a href="{{ route('companies.show', $company->id) }}" class="btn btn-primary btn-sm">Xem rạp</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
