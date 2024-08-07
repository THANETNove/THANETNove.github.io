@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เเก้ไขระบบลงทะเบียนครุภัณฑ์</h1>
                        @method('PUT')
                        <form method="POST" action="{{ route('durable-articles-update', $dueArt['id']) }}">
                            @csrf
                            @method('PUT')
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
                                        aria-label="Default select example" disabled>
                                        <option selected disabled>หมวดหมู่ครุภัณฑ์ </option>
                                        @foreach ($group as $gro)
                                            @if ($dueArt['group_class'] == $gro->id)
                                                <option value="{{ $gro->id }}" selected>{{ $gro->category_name }}
                                                </option>
                                            @else
                                                <option value="{{ $gro->id }}">{{ $gro->category_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="type_durableArticles" class="form-label">รหัสครุภัณฑ์</label>


                                    <input id="type_code" type="text" class="form-control" name="type_categories_code"
                                        value="{{ $dueArt['type_code'] }}" disabled>

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="type_name" class="form-label">ชื่อครุภัณฑ์</label>


                                    <input id="type-articles" type="text" name="type_categories_name"
                                        class="form-control" value="{{ $dueArt['type_name'] }}" disabled>

                                </div>

                                <input id="type-articles" type="text" class="form-control" style="display: none"
                                    value="{{ $dueArt['type_durableArticles'] }}">


                                <div class="mb-3 col-md-6">
                                    <label for="description" class="form-label">รหัสรายละเอียด</label>
                                    <input id="description" type="number"
                                        class="form-control @error('description') is-invalid @enderror" name="description"
                                        required placeholder="รายละเอียด" value="{{ $dueArt['description'] }}"
                                        autocomplete="description" disabled>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="material_name" class="form-label">ชื่อครุภัณฑ์ย่อ</label>
                                    <input id="durableArticles_name" type="text" class="form-control"
                                        name="durableArticles_name" value="{{ $dueArt['durableArticles_name'] }}" required
                                        placeholder="ชื่อครุภัณฑ์ย่อ" autocomplete="durableArticles_name">

                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="durableArticles_number" class="form-label">จำนวนครุภัณฑ์</label>
                                    <input id="durableArticles_number" type="number"
                                        class="form-control @error('durableArticles_number') is-invalid @enderror"
                                        name="durableArticles_number" required placeholder="จำนวนครุภัณฑ์"
                                        autocomplete="durableArticles_number" value="1" readonly disabled>

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
                                        name="name_durableArticles_count"
                                        value="{{ $dueArt['name_durableArticles_count'] }}" required
                                        placeholder="ชื่อเรียกจำนวนนับครุภัณฑ์" autocomplete="name_durableArticles_count"
                                        disabled>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name_durableArticles_count" class="form-label">อายุการใช้
                                        /ปี</label>
                                    <input type="text" class=" form-control " name="service_life" placeholder="5"
                                        value="{{ $dueArt['service_life'] }}" required autocomplete="service_life"
                                        disabled>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name_durableArticles_count" class="form-label">ระยะเวลาประกัน
                                    </label>
                                    {{--     <input id="warranty_period" type="text" class="dateMin form-control "
                                        name="warranty_period" required value="{{ $dueArt['warranty_period'] }}"
                                        placeholder="dd-mm-yyyy" autocomplete="warranty_period"> --}}
                                    <div class="d-flex">
                                        <input class="form-control me-2 warranty_period_start" type="text"
                                            value="{{ $dueArt['warranty_period_start'] }}" name="warranty_period_start"
                                            placeholder="dd-mm-yyyy">
                                        <input class="form-control warranty_period_end" type="text"
                                            value="{{ $dueArt['warranty_period_end'] }}" name="warranty_period_end"
                                            placeholder="dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="code_material_storage" class="form-label">ที่เก็บครุภัณฑ์</label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="code_material_storage" required>
                                        <option selected disabled>ที่เก็บครุภัณฑ์</option>
                                        @foreach ($data as $lo)
                                            @if ($dueArt['code_material_storage'] == $lo->code_storage)
                                                <option value="{{ $lo->code_storage }}" selected>{{ $lo->building_name }}
                                                    {{ $lo->floor }} {{ $lo->room_name }}</option>
                                            @else
                                                <option value="{{ $lo->code_storage }}">{{ $lo->building_name }}
                                                    {{ $lo->floor }} {{ $lo->room_name }}</option>
                                            @endif
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
