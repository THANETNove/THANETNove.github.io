@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary mb-5 ">รายละเอียดระบบลงทะเบียนวัสดุ</h1>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">รหัส </label>
                                <input type="text" class="form-control" value="{{ $data[0]->code_material }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ประเภทวัสดุ </label>
                                <input type="text" class="form-control" value="{{ $data[0]->category_name }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ชื่อ</label>
                                <input type="text" class="form-control" value="{{ $data[0]->material_name }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">จำนวนวัสดุ </label>
                                <input type="text" class="form-control"
                                    value="{{ number_format($data[0]->material_number) }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">จำนวนที่เหลือ </label>
                                <input type="text" class="form-control"
                                    value="{{ number_format($data[0]->remaining_amount) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">หน่วย </label>
                                <input type="text" class="form-control" value="{{ $data[0]->name_material_count }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ที่จัดเก็บ </label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $data[0]->building_name }} &nbsp;{{ $data[0]->floor }} &nbsp;{{ $data[0]->room_name }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">วันที่สร้าง </label>
                                <input type="text" class="form-control"
                                    value="{{ (new Carbon\Carbon($data[0]->created_at))->format('d-m-Y') }}">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
