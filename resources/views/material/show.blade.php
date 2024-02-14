@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">รายละเอียดระบบลงทะเบียนวัสดุ</h1>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">รหัส </label>
                                <p>{{ $data[0]->code_material }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ประเภทวัสดุ </label>
                                <p>{{ $data[0]->category_name }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ชื่อ</label>
                                <p>{{ $data[0]->material_name }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">จำนวนวัสดุ </label>
                                <p>{{ number_format($data[0]->material_number) }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">จำนวนที่เหลือ </label>
                                <p>{{ number_format($data[0]->remaining_amount) }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">หน่วย </label>
                                <p>{{ $data[0]->name_material_count }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ที่จัดเก็บ </label>
                                <p>{{ $data[0]->building_name }} &nbsp;{{ $data[0]->floor }} &nbsp;
                                    {{ $data[0]->room_name }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">วันที่สร้าง </label>
                                <p>{{ (new Carbon\Carbon($data[0]->created_at))->format('d-m-Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
