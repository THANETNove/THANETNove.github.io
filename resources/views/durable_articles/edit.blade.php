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
                                    <label for="group_class" class="form-label">กลุ่ม/ประเภท</label>
                                    <input id="group_class" type="number"
                                        class="form-control @error('group_class') is-invalid @enderror" name="group_class"
                                        required placeholder="กลุ่ม/ประเภท" value="{{ $dueArt['group_class'] }}"
                                        autocomplete="group_class">

                                    @error('group_class')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="type_durableArticles" class="form-label">ชนิด</label>
                                    <input id="type_durableArticles" type="number"
                                        value="{{ $dueArt['type_durableArticles'] }}"
                                        class="form-control @error('type_durableArticles') is-invalid @enderror"
                                        name="type_durableArticles" required placeholder="ชนิด"
                                        autocomplete="type_durableArticles">

                                    @error('type_durableArticles')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="description" class="form-label">รายละเอียด</label>
                                    <input id="description" type="number"
                                        class="form-control @error('description') is-invalid @enderror" name="description"
                                        required placeholder="รายละเอียด" value="{{ $dueArt['description'] }}"
                                        autocomplete="description">

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="material_name" class="form-label">หมวดหมู่ครุภัณฑ์</label>
                                    {{--  <input id="material_name" type="text"
                                        class="form-control @error('material_name') is-invalid @enderror"
                                        name="group_id" required placeholder="ชื่อวัสดุ" autocomplete="material_name"> --}}
                                    <select class="form-select" name="group_id" aria-label="Default select example">
                                        <option selected disabled>หมวดหมู่ครุภัณฑ์</option>
                                        @foreach ($group as $gro)
                                            @if ($dueArt['group_id'] == $gro->id)
                                                <option value="{{ $gro->id }}" selected>{{ $gro->category_name }}
                                                </option>
                                            @else
                                                <option value="{{ $gro->id }}">{{ $gro->category_name }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                    @error('group_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="durableArticles_name" class="form-label">ชื่อครุภัณฑ์</label>
                                    <input id="durableArticles_name" type="text"
                                        class="form-control @error('durableArticles_name') is-invalid @enderror"
                                        name="durableArticles_name" value="{{ $dueArt['durableArticles_name'] }}" required
                                        placeholder="ชื่อครุภัณฑ์" autocomplete="durableArticles_name">

                                    @error('durableArticles_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="durableArticles_number" class="form-label">จำนวนครุภัณฑ์</label>
                                    <input id="durableArticles_number" type="number"
                                        class="form-control @error('durableArticles_number') is-invalid @enderror"
                                        name="durableArticles_number" value="{{ $dueArt['durableArticles_number'] }}"
                                        required placeholder="จำนวนครุภัณฑ์" autocomplete="durableArticles_number">

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
                                        value="{{ $dueArt['name_durableArticles_count'] }}"
                                        autocomplete="name_durableArticles_count">

                                    @error('name_durableArticles_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="code_material_storage" class="form-label">ที่เก็บครุภัณฑ์</label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="code_material_storage" required>
                                        <option selected disabled>ที่เก็บครุภัณฑ์</option>
                                        @foreach ($data as $lo)
                                            @if ($lo->code_storage == $dueArt['code_material_storage'])
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
