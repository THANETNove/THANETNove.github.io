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
                                <input type="text" class="form-control" value="{{ $data[0]->category_name }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">รหัสวัสดุ</label>
                                <input type="text" class="form-control" value="{{ $data[0]->code_requisition }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">ชื่อ </label>
                                <input type="text" class="form-control" value="{{ $data[0]->name }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">จำนวนที่เบิก </label>
                                <input type="text" class="form-control"
                                    value="{{ number_format($data[0]->amount_withdraw) }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">หน่วยนับ </label>
                                <input type="text" class="form-control" value="{{ $data[0]->name_material_count }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">ชื่อ นามสกุล ผู้เบิก </label>
                                <input type="text" class="form-control"
                                    value="{{ $data[0]->prefix }} {{ $data[0]->first_name }} {{ $data[0]->last_name }}">

                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">ที่จัดเก็บ</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $data[0]->building_name }} &nbsp;{{ $data[0]->floor }} &nbsp;{{ $data[0]->room_name }}</textarea>

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">วันที่สร้าง</label>

                                <input type="text" class="form-control"
                                    value="{{ (new Carbon\Carbon($data[0]->created_at))->format('d-m-Y') }}">
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
                                <label for="prefix" class="form-label">การอนุมัติ</label>
                                <p>
                                    @if ($data[0]->status_approve == '0')
                                        <span class="badge bg-label-primary me-1">รออนุมัติ</span>
                                    @elseif ($data[0]->status_approve == '1')
                                        <span class="badge bg-label-warning me-1">อนุมัติ</span>
                                    @else
                                        <span class="badge bg-label-danger me-1">ไม่อนุมัติ</span>
                                    @endif
                                </p>
                            </div>

                            @if ($data[0]->status_approve == '2')
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">หมายเหตุ</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $data[0]->commentApproval }}</textarea>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
