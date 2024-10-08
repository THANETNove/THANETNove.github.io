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

                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">เเบบกลุ่ม</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">เเบบรายชิ้น</button>
                                    </li>

                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab" tabindex="0">
                                        <div class="table-responsive text-nowrap">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>ลำดับ</th>
                                                        {{--  <th>รหัสครุภัณฑ์</th>
                                                        <th>หมวดหมู่ครุภัณฑ์</th> --}}
                                                        <th>ชื่อครุภัณฑ์</th>
                                                        {{--  <th>รายละเอียดครุภัณฑ์</th> --}}
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
                                                            {{--    <td>{{ $da->category_code }}-{{ $da->type_code }}-{{ $da->description }}
                                                            </td>
                                                            <td>{{ $da->category_name }}</td>
                                                            <td>{{ $da->type_name }}</td> --}}
                                                            <td>{{ $da->durableArticles_name }}</td>
                                                            <td>{{ $da->groupWithdrawCount }}</td>

                                                            <td>
                                                                @if ($da->status == '0')
                                                                    @if ($da->statusApproval == '0')
                                                                        <span
                                                                            class="badge bg-label-info me-1">รอการอนุมัติ</span>
                                                                    @elseif ($da->statusApproval == '1')
                                                                        <span
                                                                            class="badge bg-label-success me-1">อนุมัติ</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-label-warning me-1">ไม่อนุมัติ</span>
                                                                    @endif
                                                                @elseif ($da->status == '1')
                                                                    <span
                                                                        class="badge bg-label-warning me-1">ยกเลิกเบิกครุภัณฑ์</span>
                                                                @elseif ($da->status == '2')
                                                                    <span
                                                                        class="badge bg-label-info me-1">รอการอนุมัติคึนครุภัณฑ์</span>
                                                                @elseif ($da->status == '3')
                                                                    <span
                                                                        class="badge bg-label-primary me-1">คึนครุภัณฑ์</span>
                                                                @endif

                                                            </td>

                                                            <td>
                                                                @if ($da->statusApproval == '1' && $da->status == '0')
                                                                    @if ($da->starts_waiting_receive == 'on')
                                                                        <span
                                                                            class="badge bg-label-success me-1">รับของเเล้ว</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-label-warning me-1">รอรับของ</span>
                                                                    @endif
                                                                @endif

                                                            </td>


                                                            <td>{{ date('d-m-Y', strtotime($da->created_at)) }}</td>


                                                            <td>

                                                                <div class="dropdown">
                                                                    <button type="button"
                                                                        class="btn p-0 dropdown-toggle hide-arrow"
                                                                        data-bs-toggle="dropdown">
                                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item"
                                                                            href="{{ url('durable-articles-requisition-show', $da->id) }}"><i
                                                                                class='bx bxs-show'></i> View</a>
                                                                        @if ($da->statusApproval == '0' && $da->status == '0')
                                                                            <a class="dropdown-item"
                                                                                href="{{ url('durable-articles-requisition-edit', $da->id) }}"><i
                                                                                    class="bx bx-edit-alt me-1"></i>
                                                                                Edit</a>

                                                                            <a class="dropdown-item alert-destroy"
                                                                                href="{{ url('durable-articles-requisition-destroy', $da->id) }}"><i
                                                                                    class="bx bx-trash me-1"></i> ยกเลิก</a>
                                                                        @endif
                                                                        @if ($da->statusApproval == '1' && $da->status == '0')
                                                                            @if ($da->starts_waiting_receive == 'on')
                                                                                <a class="dropdown-item alert-destroy"
                                                                                    href="{{ url('durable-articles-requisition-return', $da->id) }}">

                                                                                    <i class='bx bxs-send'></i>
                                                                                    คึนครุภัณฑ์</a>
                                                                            @endif
                                                                        @endif
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
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                        aria-labelledby="pills-profile-tab" tabindex="0">
                                        <div class="table-responsive text-nowrap">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>ลำดับ</th>
                                                        {{--         <th>รหัสครุภัณฑ์</th>
                                                        <th>หมวดหมู่ครุภัณฑ์</th>
                                                        <th>ชื่อครุภัณฑ์</th> --}}
                                                        <th>ชื่อครุภัณฑ์</th>
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
                                                    @foreach ($data2 as $da2)
                                                        <tr>
                                                            <th scope="row">{{ $i++ }}</th>
                                                            {{--     <td>{{ $da2->category_code }}-{{ $da2->type_code }}-{{ $da2->description }}
                                                            </td>
                                                            <td>{{ $da2->category_name }}</td>
                                                            <td>{{ $da2->type_name }}</td> --}}
                                                            <td>{{ $da2->durableArticles_name }}</td>
                                                            <td>{{ $da2->amount_withdraw }}</td>

                                                            <td>
                                                                @if ($da2->status == '0')
                                                                    @if ($da2->statusApproval == '0')
                                                                        <span
                                                                            class="badge bg-label-info me-1">รอการอนุมัติ</span>
                                                                    @elseif ($da2->statusApproval == '1')
                                                                        <span
                                                                            class="badge bg-label-success me-1">อนุมัติ</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-label-warning me-1">ไม่อนุมัติ</span>
                                                                    @endif
                                                                @elseif ($da2->status == '1')
                                                                    <span
                                                                        class="badge bg-label-warning me-1">ยกเลิกเบิกครุภัณฑ์</span>
                                                                @elseif ($da2->status == '2')
                                                                    <span
                                                                        class="badge bg-label-info me-1">รอการอนุมัติคึนครุภัณฑ์</span>
                                                                @elseif ($da2->status == '3')
                                                                    <span
                                                                        class="badge bg-label-primary me-1">คึนครุภัณฑ์</span>
                                                                @endif

                                                            </td>

                                                            <td>
                                                                @if ($da2->statusApproval == '1' && $da2->status == '0')
                                                                    @if ($da2->starts_waiting_receive == 'on')
                                                                        <span
                                                                            class="badge bg-label-success me-1">รับของเเล้ว</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-label-warning me-1">รอรับของ</span>
                                                                    @endif
                                                                @endif

                                                            </td>


                                                            <td>{{ date('d-m-Y', strtotime($da2->created_at)) }}</td>


                                                            <td>

                                                                <div class="dropdown">
                                                                    <button type="button"
                                                                        class="btn p-0 dropdown-toggle hide-arrow"
                                                                        data-bs-toggle="dropdown">
                                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item"
                                                                            href="{{ url('durable-articles-requisition-showList', $da2->id) }}"><i
                                                                                class='bx bxs-show'></i> View</a>
                                                                        @if ($da2->statusApproval == '0' && $da2->status == '0')
                                                                            <a class="dropdown-item"
                                                                                href="{{ url('durable-articles-requisition-edit', $da2->id) }}"><i
                                                                                    class="bx bx-edit-alt me-1"></i>
                                                                                Edit</a>

                                                                            <a class="dropdown-item alert-destroy"
                                                                                href="{{ url('durable-articles-requisition-destroy', $da2->id) }}"><i
                                                                                    class="bx bx-trash me-1"></i>
                                                                                ยกเลิก</a>
                                                                        @endif
                                                                        @if ($da2->statusApproval == '1' && $da2->status == '0')
                                                                            @if ($da2->starts_waiting_receive == 'on')
                                                                                <a class="dropdown-item alert-destroy"
                                                                                    href="{{ url('durable-articles-requisition-return-list', $da2->id) }}">

                                                                                    <i class='bx bxs-send'></i>
                                                                                    คึนครุภัณฑ์</a>
                                                                            @endif
                                                                        @endif
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
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalBuy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">รายการข้อมูลเข้า</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('durable-articles-requisition-export/pdf') }}"
                        target="_blank">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-6">
                                <label for="exampleFormControlInput1" class="form-label">วันที่เริ่มต้น</label>
                                <input type="text" class="form-control date-created_at" name="start_date"
                                    id="start_date" placeholder="yyy-mm-dd" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="exampleFormControlTextarea1" class="form-label">วันที่สิ้นสุด</label>
                                <input type="text" class="form-control date-created_at" name="end_date"
                                    id="end_date" placeholder="yyyy-mm-dd" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">เเผนก</label>
                                <select class="form-select" name="dep_name" aria-label="Default select example">
                                    <option value="all" selected>เลือกทุกเเผนก</option>
                                    @foreach ($department as $de)
                                        <option value="{{ $de->id }}">{{ $de->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">รายงาน</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- / Layout wrapper -->
@endsection
