@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">ระบบลงทะเบียนครุภัณฑ์</h1>
                        <form method="POST" action="{{ route('durable-articles-store') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    {{--  <label for="group_class" class="form-label">กลุ่ม/ประเภท</label>
                                    <input id="group_class" type="number"
                                        class="form-control @error('group_class') is-invalid @enderror" name="group_class"
                                        required placeholder="กลุ่ม/ประเภท" autocomplete="group_class">

                                    @error('group_class')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                    <label for="material_name" class="form-label">หมวดหมู่ครุภัณฑ์</label>

                                    <select class="form-select" name="group_class" id="durable-articles-group-id"
                                        aria-label="Default select example">
                                        <option selected disabled>หมวดหมู่ครุภัณฑ์</option>
                                        @foreach ($group as $gro)
                                            <option value="{{ $gro->category_code }}">{{ $gro->category_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="type_durableArticles" class="form-label">ครุภัณฑ์</label>

                                    <select class="form-select" name="type_durableArticles"
                                        id="durable-articles-type-durableArticles" aria-label="Default select example">
                                        <option selected disabled>เลือกครุภัณฑ์</option>

                                    </select>

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="description" class="form-label">รหัสรายละเอียด</label>
                                    <input id="description" type="number"
                                        class="form-control @error('description') is-invalid @enderror" name="description"
                                        required placeholder="รายละเอียด" autocomplete="description">

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="material_name" class="form-label">ชื่อครุภัณฑ์ย่อ</label>
                                    <input id="durableArticles_name" type="text" class="form-control"
                                        name="durableArticles_name" required placeholder="ชื่อครุภัณฑ์ย่อ"
                                        autocomplete="durableArticles_name">

                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="durableArticles_number" class="form-label">จำนวนครุภัณฑ์</label>
                                    <input id="durableArticles_number" type="number"
                                        class="form-control @error('durableArticles_number') is-invalid @enderror"
                                        name="durableArticles_number" required placeholder="จำนวนครุภัณฑ์"
                                        autocomplete="durableArticles_number" value="1" readonly>

                                    @error('durableArticles_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name_durableArticles_count" class="form-label">ชื่อเรียกจำนวนนับครุภัณฑ์
                                        (เช่น
                                        เตียง คัน เครื่อง
                                        อื่น ๆ
                                        )</label>
                                    <input id="name_durableArticles_count" type="text"
                                        class="form-control @error('name_durableArticles_count') is-invalid @enderror"
                                        name="name_durableArticles_count" required placeholder="ชื่อเรียกจำนวนนับครุภัณฑ์"
                                        autocomplete="name_durableArticles_count">
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="name_durableArticles_count" class="form-label">ระยะเวลประกัน</label>
                                    <input id="warranty_period" type="text" class="date form-control "
                                        name="warranty_period" required placeholder="dd-mm-yyyy"
                                        autocomplete="warranty_period">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="code_material_storage" class="form-label">ที่เก็บครุภัณฑ์</label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="code_material_storage" required>
                                        <option selected disabled>ที่เก็บครุภัณฑ์</option>
                                        @foreach ($data as $lo)
                                            <option value="{{ $lo->code_storage }}">{{ $lo->building_name }}
                                                {{ $lo->floor }} {{ $lo->room_name }}</option>
                                        @endforeach

                                    </select>
                                </div>


                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">บักทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
