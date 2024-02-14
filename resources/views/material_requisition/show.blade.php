@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary mb-5">รายละเอียดการเบิกวัสดุอุปกรณ์</h1>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">หมวดวัสดุ</label>
                                <p>{{ $data[0]->category_name }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">รหัสวัสดุ</label>
                                <p>{{ $data[0]->code_requisition }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">ชื่อ </label>
                                <p>{{ $data[0]->name }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">จำนวนที่เบิก </label>
                                <p>{{ number_format($data[0]->amount_withdraw) }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">หน่วยนับ </label>
                                <p>{{ $data[0]->name_material_count }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">ชื่อ นามสกุล ผู้เบิก </label>
                                <p>{{ $data[0]->prefix }} {{ $data[0]->first_name }} {{ $data[0]->last_name }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">สถานะ</label>
                                <p>
                                    @if ($data[0]->status == 'on')
                                        <span class="badge bg-label-success me-1">เบิกวัสดุ</span>
                                    @else
                                        <span class="badge bg-label-warning me-1">ยกเลิกเบิกวัสดุ</span>
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">ที่จัดเก็บ</label>
                                <p>
                                <p>{{ $data[0]->building_name }} &nbsp;{{ $data[0]->floor }} &nbsp;
                                    {{ $data[0]->room_name }}</p>
                                </p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">วันที่สร้าง</label>
                                <p>{{ (new Carbon\Carbon($data[0]->created_at))->format('d-m-Y') }}</p>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
