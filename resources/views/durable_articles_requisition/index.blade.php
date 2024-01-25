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
                                <h1 class="card-title text-primary ">เบิกครุภัณฑ์</h1>
                                <a href="{{ url('durable-articles-requisition-export/pdf') }}" target="_blank"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานการเบิกครุภัณฑ์</a>
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
                                                <th>จำนวนที่เบิก</th>
                                                <th>หน่วยนับ </th>

                                                @if (Auth::user()->status != '0')
                                                    <th>ชื่อ นามสกุล ผู้เบิก </th>
                                                @endif
                                                <th>ระยะประกัน </th>
                                                <th>วันที่เบิก </th>
                                                <th>การอนุมัติ </th>
                                                <th>สถานะ </th>
                                                <th>ที่เก็บ </th>
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
                                                    <td>{{ $da->code_durable_articles }}</td>
                                                    <td>{{ $da->category_name }}</td>
                                                    <td>{{ $da->type_name }}</td>
                                                    <td>{{ $da->durableArticles_name }}</td>
                                                    <td>{{ $da->amount_withdraw }}</td>
                                                    <td>{{ $da->name_durable_articles_count }}</td>
                                                    @if (Auth::user()->status != '0')
                                                        <td>{{ $da->prefix }} {{ $da->first_name }} {{ $da->last_name }}
                                                        </td>
                                                    @endif
                                                    @php
                                                        $originalDate = $da->warranty_period;
                                                        $newDate = (new DateTime($originalDate))->format('d/m/Y');
                                                        $newDate2 = new DateTime($originalDate);
                                                        $targetDate = $newDate2;
                                                        $now = new DateTime();

                                                        $daysRemaining = $now > $targetDate ? 0 : $now->diff($targetDate)->format('%a') + 1;
                                                    @endphp
                                                    <td>{{ $newDate }}
                                                        @if ($now->format('Y-m-d') == $targetDate->format('Y-m-d'))
                                                            <span
                                                                class="badge bg-label-primary me-1">วันสุดท้ายของประกัน</span>
                                                        @else
                                                            @if ($daysRemaining > 0)
                                                                <span class="badge bg-label-primary me-1">เหลือเวลา
                                                                    {{ $daysRemaining }} วัน</span>
                                                            @else
                                                                <span class="badge bg-label-warning me-1">หมดประกัน</span>
                                                            @endif
                                                        @endif

                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($da->created_at)) }}</td>
                                                    <td>
                                                        @if ($da->status == '0')
                                                            @if ($da->statusApproval == '0')
                                                                <span class="badge bg-label-info me-1">รอการอนุมัติ</span>
                                                            @elseif ($da->statusApproval == '1')
                                                                <span class="badge bg-label-success me-1">อนุมัติ</span>
                                                            @else
                                                                <span class="badge bg-label-warning me-1">ไม่อนุมัติ</span>
                                                            @endif
                                                        @endif

                                                    </td>

                                                    <td>
                                                        @if ($da->status == '0')
                                                            <span class="badge bg-label-success me-1">เบิกครุภัณฑ์</span>
                                                        @elseif ($da->status == '1')
                                                            <span
                                                                class="badge bg-label-warning me-1">ยกเลิกเบิกครุภัณฑ์</span>
                                                        @else
                                                            <span class="badge bg-label-primary me-1">คึนครุภัณฑ์</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $da->building_name }} &nbsp;{{ $da->floor }} &nbsp;
                                                        {{ $da->room_name }}</td>

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
                                                                    {{--  <a class="dropdown-item"
                                                                        href="{{ url('durable-articles-requisition-edit', $da->id) }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a> --}}

                                                                    <a class="dropdown-item alert-destroy"
                                                                        href="{{ url('durable-articles-requisition-destroy', $da->id) }}"><i
                                                                            class="bx bx-trash me-1"></i> ยกเลิก</a>
                                                                @endif
                                                                {{--  @if ($da->statusApproval == '1' && $da->status == '0')
                                                                    @if (Auth::user()->status > '1')
                                                                        <a class="dropdown-item alert-destroy"
                                                                            href="{{ url('durable-articles-requisition-return', $da->id) }}">

                                                                            <i class='bx bxs-send'></i>
                                                                            คึนครุภัณฑ์</a>
                                                                    @endif
                                                                @endif --}}
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
