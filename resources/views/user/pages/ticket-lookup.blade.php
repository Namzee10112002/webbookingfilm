@extends('user.layout')

@section('title', 'Tra cứu vé')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tra cứu vé</h2>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form action="{{ route('ticket.search') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="order_id" class="form-label">Nhập mã đơn hàng</label>
            <input type="text" name="order_id" id="order_id" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mb-5">Tra cứu</button>
    </form>
</div>
@endsection
