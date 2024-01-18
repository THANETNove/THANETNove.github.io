@extends('layouts.app')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-12">

                            <div class="card-body">
                                <h1 class="card-title text-primary ">ครุภัณฑ์ที่แทงจำหน่าย </h1>
                                <a href="{{ url('bet-distribution-export/pdf') }}" target="_blank"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานข้อมูลครุภัณฑ์ที่แทงจำหน่าย</a>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ </th>
                                                <th>หมวดหมู่ครุภัณฑ์</th>
                                                <th>รหัสครุภัณฑ์</th>
                                                <th>ชื่อครุภัณฑ์</th>
                                                <th>จำนวนที่เเทงจำหน่าย</th>
                                                <th>หน่วยนับ</th>
                                                <th>ราคาซาก</th>
                                                <th>สถานะ </th>
                                                <th>สถานะการอนุมัติ </th>
                                                <th>รายละเอียด</th>
                                                <th>รายละเอียดการอนุมัติ</th>
                                                <th>วันที่สร้าง</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $i = 1;
                                        @endphp
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->category_name }}</td>
                                                    <td>{{ $da->code_durable_articles }}</td>
                                                    <td>{{ $da->durableArticles_name }}</td>
                                                    <td>{{ number_format($da->amount_bet_distribution) }}</td>
                                                    <td>{{ $da->name_durable_articles_count }}</td>
                                                    <td>{{ number_format($da->salvage_price) }}</td>

                                                    <td>
                                                        @if ($da->statusApproval == '0')
                                                            <span class="badge bg-label-success me-1">รออนุมัติ</span>
                                                        @elseif ($da->statusApproval == '1')
                                                            <span class="badge bg-label-primary me-1">อนุมัติ</span>
                                                        @else
                                                            <span class="badge bg-label-warning me-1">ไม่อนุมัติ</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($da->status == 'on')
                                                            <span class="badge bg-label-success me-1">เเทงจำหน่าย</span>
                                                        @else
                                                            <span class="badge bg-label-warning me-1">ยกเลิก</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $da->repair_detail }}</td>
                                                    <td>{{ $da->commentApproval }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($da->created_at)) }}</td>
                                                    @if ($da->status == 'on' && $da->statusApproval == '0')
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        href="{{ url('bet-distribution-edit', $da->id) }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                    @if (Auth::user()->status == '2')
                                                                        <a class="dropdown-item alert-destroy"
                                                                            href="{{ url('bet-distribution-destroy', $da->id) }}"><i
                                                                                class="bx bx-trash me-1"></i> ยกเลิก</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-5">
                                        {!! $data->links() !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- / Layout wrapper -->
@endsection
