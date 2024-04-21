@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">ระบบลงทะเบียนครุภัณฑ์</h1>


                        <ul class="nav nav-pills mb-3 mt-4" id="pills-tab" role="tablist">
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
                                @include('buy.create')
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab" tabindex="0">
                                <form method="POST" action="{{ route('durable-articles-store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="material_name" class="form-label">หมวดหมู่ครุภัณฑ์</label>

                                            <select class="form-select" name="group_class" id="durable-articles-group-id"
                                                aria-label="Default select example">
                                                <option selected disabled>หมวดหมู่ครุภัณฑ์</option>
                                                @foreach ($group as $gro)
                                                    <option value="{{ $gro->id }}">{{ $gro->category_name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="type_durableArticles" class="form-label">ครุภัณฑ์</label>

                                            <select class="form-select" name="type_durableArticles"
                                                id="durable-articles-type-durableArticles"
                                                aria-label="Default select example">
                                                <option selected disabled>เลือกครุภัณฑ์</option>

                                            </select>

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="description" class="form-label">รหัสรายละเอียด</label>
                                            <input id="description" type="number"
                                                class="form-control @error('description') is-invalid @enderror"
                                                name="description" required placeholder="รายละเอียด"
                                                autocomplete="description">

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
                                            <input type="number" oninput="calculateTotalPrice()"
                                                class="form-control quantity2 @error('durableArticles_number') is-invalid @enderror"
                                                name="durableArticles_number" required placeholder="จำนวนครุภัณฑ์"
                                                autocomplete="durableArticles_number">

                                            @error('durableArticles_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="name_durableArticles_count"
                                                class="form-label">ชื่อเรียกจำนวนนับครุภัณฑ์
                                                (เช่น
                                                เตียง คัน เครื่อง
                                                อื่น ๆ
                                                )</label>
                                            <input id="name_durableArticles_count" type="text"
                                                class="form-control @error('name_durableArticles_count') is-invalid @enderror"
                                                name="name_durableArticles_count" required
                                                placeholder="ชื่อเรียกจำนวนนับครุภัณฑ์"
                                                autocomplete="name_durableArticles_count">
                                        </div>


                                        <div class="mb-3 col-md-6">
                                            <label for="price_per" class="form-label">ราคาต่อ
                                                (ชิ้น,หน่วย,อื่นๆ)</label>
                                            <input type="number" oninput="calculateTotalPrice()"
                                                class="form-control price_per2 @error('price_per') is-invalid @enderror"
                                                name="price_per" placeholder="ราคาต่อ (ชิ้น,อื่นๆ)" required
                                                autocomplete="price_per">

                                            @error('price_per')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="total_price" class="form-label">ราคารวม</label>
                                            <input id="total_price2" type="number"
                                                class="form-control @error('total_price') is-invalid @enderror"
                                                name="total_price" required placeholder="ชื่อเรียกจำนวนนับวัสดุ"
                                                min="1" autocomplete="total_price">

                                            @error('total_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="name_durableArticles_count"
                                                class="form-label">ระยะเวลประกัน</label>
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
                                        {{--  <div class="mb-3 col-md-12">
                                            <label for="details" class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" name="details" id="exampleFormControlTextarea1" rows="3"></textarea>
                                        </div> --}}
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
