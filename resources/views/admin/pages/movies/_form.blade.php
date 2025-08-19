<div class="mb-3">
    <label>Tên phim</label>
    <input type="text" name="name_movie" class="form-control" value="{{ old('name_movie', $movie->name_movie ?? '') }}">
</div>
<div class="mb-3">
    <label>Mô tả</label>
    <textarea name="description_movie" class="form-control">{{ old('description_movie', $movie->description_movie ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Ảnh poster (URL)</label>
    <input type="text" name="image_movie" class="form-control" value="{{ old('image_movie', $movie->image_movie ?? '') }}">
</div>
<div class="mb-3">
    <label>Ngày phát hành</label>
    <input type="date" name="date_release" class="form-control" value="{{ old('date_release', $movie->date_release ?? '') }}">
</div>
<div class="mb-3">
    <label>Thể loại</label>
    <input type="text" name="categories" class="form-control" value="{{ old('categories', $movie->categories ?? '') }}">
</div>
<div class="mb-3">
    <label>Quốc gia</label>
    <input type="text" name="country" class="form-control" value="{{ old('country', $movie->country ?? '') }}">
</div>
<div class="mb-3">
    <label>Đạo diễn</label>
    <input type="text" name="director" class="form-control" value="{{ old('director', $movie->director ?? '') }}">
</div>
<div class="mb-3">
    <label>Diễn viên</label>
    <input type="text" name="actors" class="form-control" value="{{ old('actors', $movie->actors ?? '') }}">
</div>
<div class="mb-3">
    <label>Thời lượng (phút)</label>
    <input type="number" name="duration" class="form-control" value="{{ old('duration', $movie->duration ?? '') }}">
</div>
<div class="mb-3">
    <label>Trailer (iframe code)</label>
    <textarea name="trailer" class="form-control">{{ old('trailer', $movie->trailer ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Trạng thái</label>
    <select name="status_movie" class="form-select">
        <option value="0" {{ old('status_movie', $movie->status_movie ?? '') == 0 ? 'selected' : '' }}>Đang chiếu</option>
        <option value="2" {{ old('status_movie', $movie->status_movie ?? '') == 2 ? 'selected' : '' }}>Sắp chiếu</option>
        <option value="1" {{ old('status_movie', $movie->status_movie ?? '') == 1 ? 'selected' : '' }}>Ẩn</option>
    </select>
</div>
