@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">ระบบลงทะเบียนวัสดุ</h1>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">ลงทะเบียนที่มีอยู่</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false">ลงทะเบียนใหม่</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                @include('material.createNew')
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab" tabindex="0">
                                <form method="POST" action="{{ route('material-store') }}">
                                    @csrf
                                    <div class="row">

                                        <div class="mb-3 col-md-6">
                                            <label for="material_name" class="form-label">หมวดหมู่วัสดุ</label>
                                            <select class="form-select" name="group_id" aria-label="Default select example">
                                                <option selected disabled>หมวดหมู่วัสดุ</option>
                                                @foreach ($group as $gro)
                                                    <option value="{{ $gro->id }}">{{ $gro->category_name }}</option>
                                                @endforeach

                                            </select>
                                            @error('group_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="material_name" class="form-label">ชื่อวัสดุ</label>
                                            <input id="material_name" type="text"
                                                class="form-control @error('material_name') is-invalid @enderror"
                                                name="material_name" required placeholder="ชื่อวัสดุ"
                                                autocomplete="material_name">

                                            @error('material_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="material_number" class="form-label">จำนวนวัสดุ (ต่อหน่วยนับ)</label>
                                            <input id="material_number" type="number" value="1"
                                                class="form-control @error('material_number') is-invalid @enderror"
                                                name="material_number" placeholder="จำนวนวัสดุ ชิ้น"
                                                autocomplete="material_number">

                                            @error('material_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="name_material_count" class="form-label">ชื่อเรียกจำนวนนับวัสดุ (เช่น
                                                อัน
                                                ห่อ
                                                อื่น ๆ
                                                )</label>
                                            <input id="name_material_count" type="text"
                                                class="form-control @error('name_material_count') is-invalid @enderror"
                                                name="name_material_count" required placeholder="ชื่อเรียกจำนวนนับวัสดุ"
                                                autocomplete="name_material_count">

                                            @error('name_material_count')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="code_material_storage" class="form-label">ที่เก็บวัสดุ</label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="code_material_storage" required>
                                                <option selected disabled>ที่เก็บวัสดุ</option>
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
        </div>
    </div>
@endsection
