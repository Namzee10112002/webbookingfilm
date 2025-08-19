@extends('user.layout')

@section('title', $company->name_company)

@section('content')
<div class="container mt-4">
    <h3>{{ $company->name_company }}</h3>
    <p>Chọn thành phố để xem các rạp:</p>
    <select id="citySelect" class="form-select mb-3">
        <option value="">-- Chọn thành phố --</option>
        @foreach($cities as $city)
        <option value="{{ $city->id }}">{{ $city->name_city }}</option>
        @endforeach
    </select>

    <div id="theaterList" class="mt-4"></div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#citySelect').change(function() {
            let cityId = $(this).val();
            if (!cityId) return;

            $.post("{{ route('companies.theaters', $company->id) }}", {
                _token: '{{ csrf_token() }}',
                city_id: cityId
            }, function(theaters) {
                let html = '';
                theaters.forEach(t => {
                    html += `<div class="card mb-3">
                    <div class="card-body">
                        <h5>${t.name_theater}</h5>
                        <p>${t.address_theater}</p>
                        <button class="btn btn-sm btn-info" onclick="loadMovies(${t.id})">Xem phim</button>
                        <div id="movies-${t.id}" class="mt-2"></div>
                    </div>
                </div>`;
                });
                $('#theaterList').html(html);
            });
        });
    });

    function loadMovies(theaterId) {
        $.post(`/theaters/${theaterId}/movies`, {
            _token: '{{ csrf_token() }}'
        }, function(movies) {
            let html = '<ul>';
            movies.forEach(m => {
                html += `<li>${m.name_movie}
                        <button class="btn btn-sm btn-danger ms-2" onclick="chooseDate(${theaterId}, ${m.id})">Đặt vé</button>
                        <div id="shows-${theaterId}-${m.id}" class="mt-2"></div>
                    </li>`;
            });

            html += '</ul>';
            $(`#movies-${theaterId}`).html(html);
        });
    }

    function chooseDate(theaterId, movieId){
    let html = `
        <div class="mt-2">
            <label>Chọn ngày:</label>
            <input type="date" id="date-${theaterId}-${movieId}" 
                   class="form-control" min="{{ date('Y-m-d') }}">
            <button class="btn btn-sm btn-primary mt-2" 
                onclick="loadShows(${theaterId}, ${movieId})">Xem suất chiếu</button>
        </div>
        <div id="list-shows-${theaterId}-${movieId}" class="mt-3"></div>
    `;
    $(`#shows-${theaterId}-${movieId}`).html(html);
}

function loadShows(theaterId, movieId){
    let date = $(`#date-${theaterId}-${movieId}`).val();
    if(!date){
        alert("Vui lòng chọn ngày");
        return;
    }

    $.post(`/theaters/${theaterId}/movies/${movieId}/shows`, 
        {_token: '{{ csrf_token() }}', date: date}, 
        function(shows){
            let html = '';
            if(shows.length === 0){
                html = '<p>Không có suất chiếu trong ngày này.</p>';
            } else {
                html = '<ul>';
                shows.forEach(s => {
                    let start = formatTime(s.time_start);
                    let end   = formatTime(s.time_end);
                    html += `<li class="mt-2">
                        ${s.room.name_room} 
                        | ${start} → ${end} 
                        | Giá: ${s.price.toLocaleString('vi-VN')} ₫
                        <a href="/booking/${s.id}/seats" class="btn btn-sm btn-success ms-2">Chọn ghế</a>
                    </li>`;
                });
                html += '</ul>';
            }
            $(`#list-shows-${theaterId}-${movieId}`).html(html);
        }
    );
}

function formatTime(dateStr){
    let d = new Date(dateStr);
    return d.toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'});
}

</script>
@endpush