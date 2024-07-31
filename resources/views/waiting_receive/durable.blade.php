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
                                <h1 class="card-title text-primary ">เบิก/ยืมครุภัณฑ์</h1>
                                {{-- <button href="{{ url('durable-articles-requisition-export/pdf') }}" target="_blank" data-bs-toggle="modal" data-bs-target="#exampleModalBuy"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานการเบิกครุภัณฑ์</button> --}}
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัสครุภัณฑ์</th>
                                                <th>หมวดหมู่ครุภัณฑ์</th>
                                                <th>ชื่อครุภัณฑ์</th>
                                                <th>รายละเอียดครุภัณฑ์</th>
                                                <th>จำนวน</th>
                                                <th>สถานะ </th>
                                                <th>รอรับของ </th>
                                                <th>วันที่เบิก </th>
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
                                                    <td>{{ $da->category_code }}-{{ $da->type_code }}-{{ $da->description }}
                                                    </td>
                                                    <td>{{ $da->category_name }}</td>
                                                    <td>{{ $da->type_name }}</td>
                                                    <td>{{ $da->durableArticles_name }}</td>
                                                    <td>{{ $da->groupWithdrawCount }}</td>

                                                    <td>
                                                        @if ($da->status == '0')
                                                            @if ($da->statusApproval == '0')
                                                                <span class="badge bg-label-info me-1">รอการอนุมัติ</span>
                                                            @elseif ($da->statusApproval == '1')
                                                                <span class="badge bg-label-success me-1">อนุมัติ</span>
                                                            @else
                                                                <span class="badge bg-label-warning me-1">ไม่อนุมัติ</span>
                                                            @endif
                                                        @elseif ($da->status == '1')
                                                            <span
                                                                class="badge bg-label-warning me-1">ยกเลิกเบิกครุภัณฑ์</span>
                                                        @elseif ($da->status == '2')
                                                            <span
                                                                class="badge bg-label-info me-1">รอการอนุมัติคึนครุภัณฑ์</span>
                                                        @elseif ($da->status == '3')
                                                            <span class="badge bg-label-primary me-1">คึนครุภัณฑ์</span>
                                                        @endif

                                                    </td>

                                                    <td>
                                                        @if ($da->statusApproval == '1' && $da->status == '0')
                                                            @if ($da->starts_waiting_receive == 'on')
                                                                <span class="badge bg-label-success me-1">รับของเเล้ว</span>
                                                            @else
                                                                <span class="badge bg-label-warning me-1">รอรับของ</span>
                                                            @endif
                                                        @endif

                                                    </td>


                                                    <td>{{ date('d-m-Y', strtotime($da->created_at)) }}</td>
                                                    {{--  <td>{{ $da->building_name }} &nbsp;{{ $da->floor }} &nbsp;
                                                        {{ $da->room_name }}</td> --}}

                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                {{--  <a class="dropdown-item"
                                                                    href="{{ url('material-requisition-show', $da->id) }}"><i
                                                                        class='bx bxs-show alert-destroy'></i>รับของเเล้ว</a> --}}
                                                                <a class="dropdown-item alert-destroy"
                                                                    href="{{ url('durable-waiting-receive', $da->id) }}">
                                                                    <i class='bx bxs-archive-in me-1'></i>รับของเเล้ว</a>
                                                            </div>
                                                        </div>

                                                    </td>
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
