@extends('admin.layout')
@section('title', 'Sơ đồ ghế - ' . $room->name_room)
@push('styles')
<style>
  .seat{font-size:22px;cursor:default;color:#ccc;}
  .seat.booked{color:red!important;}
  .seat:hover{opacity:.9}
</style>
@endpush
@section('content')
<div class="container mt-4">
  <h3>Sơ đồ ghế – {{ $room->name_room }} ({{ $room->theater->name_theater }})</h3>
  <p><strong>Phim:</strong> {{ $show->movie->name_movie }} |
     <strong>Giờ:</strong> {{ date('H:i d/m/Y', strtotime($show->time_start)) }}</p>

  <div class="text-center bg-dark text-white py-2 mb-4 rounded">MÀN HÌNH</div>

  <div class="d-flex flex-column align-items-center mb-4">
    @php $seatIndex = 1; @endphp
    @for($row = 0; $row < $rows; $row++)
      <div class="d-flex mb-2">
        <span class="me-2">{{ chr(65 + $row) }}</span>
        @for($col = 1; $col <= $seatsPerRow; $col++)
          @if($seatIndex <= $totalSeats)
          @php 
                    $seat_number = chr(65 + $row) . $col; 
                @endphp
          @php $isBooked = in_array($seatIndex, $bookedSeats); @endphp
          <div class="seat mx-1 {{ $isBooked ? 'booked' : '' }}" data-seat="{{ $seatIndex }}" 
                    data-seat-label="{{ $seat_number }}" 
                    data-bs-toggle="tooltip" 
                    title="{{ $seat_number }}" title="{{ $seat_number }}">
            <i class="fa-solid fa-couch"></i>
          </div>
          @php $seatIndex++; @endphp
          @endif
        @endfor
      </div>
    @endfor
  </div>

  <div class="mb-3">
    <i class="seat fa-solid fa-couch"></i> Ghế trống
    <i class="seat booked fa-solid fa-couch ms-3"></i> Ghế đã đặt
  </div>
</div>
@endsection
@push('scripts')
<script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el))
</script>
@endpush