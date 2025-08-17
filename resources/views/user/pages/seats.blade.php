@extends('user.layout')

@section('title', 'Chọn ghế - ' . $show->room->name_room)
@push('styles')
    <style>
        .seat {
            font-size: 22px;
            cursor: pointer;
            color: #ccc;
            /* ghế trống */
        }

        .seat.booked {
            color: red !important;
            cursor: not-allowed;
        }

        .seat.selected {
            color: green !important;
        }

        .seat:hover:not(.booked):not(.selected) {
            color: orange;
        }
    </style>
@endpush
@section('content')
    <div class="container mt-4">
        <h3>Chọn ghế - {{ $show->room->name_room }} ({{ $show->room->theater->name_theater }})</h3>
        <p><strong>Phim:</strong> {{ $show->movie->name_movie }} | <strong>Giờ:</strong>
            {{ date('H:i d/m/Y', strtotime($show->time_start)) }}</p>

        {{-- Màn hình --}}
        <div class="text-center bg-dark text-white py-2 mb-4 rounded">MÀN HÌNH</div>

        {{-- Bản đồ ghế --}}
        <form id="seatForm" action="{{ route('booking.storeSeats', $show->id) }}" method="POST">
            @csrf
            <div class="d-flex flex-column align-items-center mb-4">
                @php $seatIndex = 1; @endphp
                @for($row = 0; $row < $rows; $row++)
                    <div class="d-flex mb-2">
                        <span class="me-2">{{ chr(65 + $row) }}</span> {{-- A, B, C --}}
                        @for($col = 1; $col <= $seatsPerRow; $col++)
                            @if($seatIndex <= $totalSeats)
                                @php $seat_number = chr(65 + $row) . $col; @endphp
                                <div class="seat mx-1 {{ in_array($seatIndex, $bookedSeats) ? 'booked' : '' }}"
                                    data-seat="{{ $seatIndex }}">
                                    <i class="fa-solid fa-couch"></i>
                                </div>

                                @php $seatIndex++; @endphp
                            @endif
                        @endfor
                    </div>
                @endfor
            </div>

            {{-- Input hidden --}}
            <input type="hidden" name="seats" id="selectedSeats">


            {{-- Chú thích --}}
            <div class="mb-3">
                <i class="seat fa-solid fa-couch"></i> Ghế trống
                <i class="seat selected fa-solid fa-couch ms-3"></i> Ghế bạn chọn
                <i class="seat booked fa-solid fa-couch ms-3"></i> Ghế đã đặt
            </div>


            {{-- Tổng tiền --}}
            <div class="mb-3">
                <strong>Tổng tiền: </strong><span id="totalPrice">0 ₫</span>
            </div>
            {{-- Thông tin khách hàng --}}
            <div class="mb-3">
                <label for="name_order" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" name="name_order" id="name_order"
                    value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
            </div>
            <div class="mb-3">
                <label for="email_order" class="form-label">Email</label>
                <input type="email" class="form-control" name="email_order" id="email_order"
                    value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
            </div>
            <div class="mb-3">
                <label for="phone_order" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" name="phone_order" id="phone_order"
                    value="{{ auth()->check() ? auth()->user()->phone : '' }}" required>
            </div>

            {{-- Phương thức thanh toán --}}
            <div class="mb-3">
                <label class="form-label">Phương thức thanh toán</label>
                <select class="form-select" name="payment_method" id="payment_method" required>
                    <option value="">-- Chọn phương thức --</option>
                    <option value="0">Chuyển khoản</option>
                    <option value="1">Momo</option>
                </select>
            </div>

            {{-- Popup QR chuyển khoản --}}
            <div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                        <h5>Thanh toán chuyển khoản</h5>
                        <p><strong>Phim:</strong> {{ $show->movie->name_movie }}</p>
                        <p><strong>Xuất chiếu:</strong> {{ date('H:i d/m/Y', strtotime($show->time_start)) }}</p>
                        <p><strong>Rạp:</strong> {{ $show->room->theater->name_theater }}</p>
                        <p><strong>Số tiền:</strong> <span id="qrAmount">0 ₫</span></p>
                        <div class="text-center mb-3">
                            <img src="https://down-vn.img.susercontent.com/file/sg-11134201-22100-2cwzke2vi6iv8f"
                                alt="QR thanh toán" class="img-fluid" style="max-width:250px">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
            @if (session('error'))
                <div class="alert alert-error mt-3">
                    {{ session('error') }}
                </div>
            @endif

            <button type="submit" id="btnPay" class="btn btn-success mb-5" disabled>Thanh toán</button>

        </form>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            let price = {{ $show->price }};
            let selected = [];

            function formatVND(n) {
                return n.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
            }

            // chọn ghế
            $('.seat').click(function () {
                if ($(this).hasClass('booked')) return;

                let seat = $(this).data('seat');
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    selected = selected.filter(s => s !== seat);
                } else {
                    $(this).addClass('selected');
                    selected.push(seat);
                }

                $('#selectedSeats').val(selected.join(',')); // ✅ gửi chuỗi
                let total = selected.length * price;
                $('#totalPrice').text(formatVND(total));
                $('#qrAmount').text(formatVND(total));

                $('#btnPay').prop('disabled', selected.length === 0);
            });

            // validate khi submit
            $('#seatForm').submit(function (e) {
                if (selected.length === 0) {
                    e.preventDefault();
                    alert("Bạn phải chọn ít nhất 1 ghế trước khi thanh toán!");
                    return false;
                }

                let total = selected.length * price;
                if (total <= 0) {
                    e.preventDefault();
                    alert("Tổng tiền không hợp lệ!");
                    return false;
                }

            });

            // xử lý chọn phương thức thanh toán
            $('#payment_method').change(function () {
                let method = $(this).val();
                if (method == '0') { // chuyển khoản
                    let modal = new bootstrap.Modal(document.getElementById('qrModal'));
                    modal.show();
                }
            });
        });
    </script>

@endpush