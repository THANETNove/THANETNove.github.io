@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary mb-5 ">รายละเอียดระบบลงทะเบียนครุภัณฑ์</h1>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">รหัส </label>
                                <input type="text" class="form-control"
                                    value="{{ $data[0]->category_code }}-{{ $data[0]->type_code }}-{{ $data[0]->description }}-{{ $data[0]->group_count }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ประเภทครุภัณฑ์ </label>
                                <input type="text" class="form-control" value="{{ $data[0]->category_name }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ชื่อ </label>
                                <input type="text" class="form-control" value="{{ $data[0]->type_name }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">หน่วย </label>
                                <input type="text" class="form-control"
                                    value="{{ $data[0]->name_durableArticles_count }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ที่จัดเก็บ </label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $data[0]->building_name }} &nbsp;{{ $data[0]->floor }} &nbsp;{{ $data[0]->room_name }}</textarea>

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">วันที่สร้าง </label>

                                <input type="text" class="form-control"
                                    value="{{ date('d-m-Y', strtotime($data[0]->created_at)) }}">
                            </div>
                            <div class="table-responsive text-nowrap mt-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>จำนวน</th>
                                            <th>จำนวนที่เบิกได้</th>
                                            <th>ชำรุด</th>
                                            <th>แทงจำหน่าย</th>
                                            <th>ซ่อม</th>
                                            <th>ค่าเสื่อม</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <tr>

                                            <td>{{ number_format($data[0]->durableArticles_number) }}</td>
                                            <td>{{ number_format($data[0]->remaining_amount) }}</td>
                                            <td>{{ number_format($data[0]->damaged_number) }}</td>
                                            <td>{{ number_format($data[0]->bet_on_distribution_number) }}</td>
                                            <td>{{ number_format($data[0]->repair_number) }}</td>
                                            <td>{{ number_format($data[0]->depreciation_price) }}</td>



                                        </tr>

                                    </tbody>

                                </table>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
