@php
    $dataProvinces = DB::table('provinces')->get();
@endphp

<div class="mb-3">
    <label for="first_name" class="form-label">ที่อยู่</label>
    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"
        placeholder="ที่อยู่" required />
    @error('address')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="mb-3">
    <label for="first_name" class="form-label">จังหวัด</label>
    <select class="select-address select-address form-select font-size-12-black" name="provinces" id="provinces"
        aria-label="Default select example">
        <option selected disabled>จังหวัด</option>
        @foreach ($dataProvinces as $provinces)
            <option value="{{ $provinces->id }}">{{ $provinces->name_th }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="first_name" class="form-label">แขวง/ อำเภอ</label>
    <select class="select-address form-select mt-2 font-size-12-black" name="districts" id="districts"
        aria-label="Default select example">
        <option selected disabled>แขวง/ อำเภอ</option>
    </select>
</div>
<div class="mb-3">
    <label for="first_name" class="form-label">เขต/ ตำบล</label>
    <select class="select-address form-select mt-2 font-size-12-black" name="subdistrict" id="subdistrict"
        aria-label="Default select example">
        <option selected disabled>เขต/ ตำบล</option>
    </select>
</div>

<div class="mb-3">
    <label for="first_name" class="form-label">รหัสไปรษณีย์</label>
    <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="รหัสไปรษณีย์" />
</div>
