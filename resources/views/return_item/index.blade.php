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
                                <h1 class="card-title text-primary ">คืนครุภัณฑ์</h1>
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">คืนครุภัณฑ์กลุ่ม</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile"
                                            aria-selected="false">คืนครุภัณฑ์เเบบรายชิ้น</button>
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
                                                        <th>หมวดหมู่ครุภัณฑ์</th>
                                                        <th>รหัสวัสดุ</th>
                                                        <th>ชื่อวัสดุ</th>
                                                        <th>จำนวนที่เบิก</th>
                                                        <th>หน่วยนับ </th>

                                                        @if (Auth::user()->status != '0')
                                                            <th>ชื่อ นามสกุล ผู้เบิก </th>
                                                        @endif
                                                        <th>ระยะประกัน </th>
                                                        <th>วันที่เบิก </th>
                                                        <th>สถานะ </th>
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
                                                            <td>{{ $da->category_code }}-{{ $da->type_code }}-{{ $da->description }}
                                                            </td>
                                                            <td>{{ $da->durableArticles_name }}</td>
                                                            <td>{{ $da->total_amount_withdraw }}</td>
                                                            <td>{{ $da->name_durable_articles_count }}</td>
                                                            @if (Auth::user()->status != '0')
                                                                <td>{{ $da->prefix }} {{ $da->first_name }}
                                                                    {{ $da->last_name }}
                                                                </td>
                                                            @endif
                                                            @php
                                                                $originalDate = $da->warranty_period_start;
                                                                $originalDate2 = $da->warranty_period_end;
                                                                $newDate = (new DateTime($originalDate))->format(
                                                                    'd-m-Y',
                                                                );
                                                                $newDate2 = new DateTime($originalDate2);
                                                                $targetDate = $newDate2;
                                                                $now = new DateTime();

                                                                $daysRemaining =
                                                                    $now > $targetDate
                                                                        ? 0
                                                                        : $now->diff($targetDate)->format('%a') + 1;
                                                            @endphp

                                                            <td>
                                                                <div>
                                                                    {{ $newDate }} &nbsp; ถึง &nbsp;
                                                                    {{ $newDate2->format('d-m-Y') }}
                                                                    @if ($now->format('Y-m-d') == $targetDate->format('Y-m-d'))
                                                                        <span
                                                                            class="badge bg-label-primary me-1">วันสุดท้ายของประกัน</span>
                                                                    @else
                                                                        @if ($daysRemaining > 0)
                                                                            <span
                                                                                class="badge bg-label-primary me-1">เหลือเวลา
                                                                                {{ $daysRemaining }} วัน</span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-label-warning me-1">หมดประกัน</span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>{{ date('d-m-Y', strtotime($da->created_at)) }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-label-info me-1">รอการอนุมัติคืนครุภัณฑ์</span>
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button type="button"
                                                                        class="btn p-0 dropdown-toggle hide-arrow"
                                                                        data-bs-toggle="dropdown">
                                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item"
                                                                            href="{{ url('return-item-show', $da->id) }}">
                                                                            <i class='bx bxs-show'></i> View</a>
                                                                        <a class="dropdown-item alert-destroy"
                                                                            href="{{ url('return-item-approval', $da->id) }}">
                                                                            <i class='bx bxs-send'></i>
                                                                            อนุมัติคืนครุภัณฑ์ </a>
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
                                                        <th>หมวดหมู่ครุภัณฑ์</th>
                                                        <th>รหัสวัสดุ</th>
                                                        <th>ชื่อวัสดุ</th>
                                                        <th>จำนวนที่เบิก</th>
                                                        <th>หน่วยนับ </th>

                                                        @if (Auth::user()->status != '0')
                                                            <th>ชื่อ นามสกุล ผู้เบิก </th>
                                                        @endif
                                                        <th>ระยะประกัน </th>
                                                        <th>วันที่เบิก </th>
                                                        <th>สถานะ </th>
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
                                                            <td>{{ $da2->category_name }}</td>
                                                            <td>{{ $da2->category_code }}-{{ $da2->type_code }}-{{ $da2->description }}
                                                            </td>
                                                            <td>{{ $da2->durableArticles_name }}</td>
                                                            <td>{{ $da2->amount_withdraw }}</td>
                                                            <td>{{ $da2->name_durable_articles_count }}</td>
                                                            @if (Auth::user()->status != '0')
                                                                <td>{{ $da2->prefix }} {{ $da2->first_name }}
                                                                    {{ $da2->last_name }}
                                                                </td>
                                                            @endif
                                                            @php
                                                                $originalDate = $da2->warranty_period_start;
                                                                $originalDate2 = $da2->warranty_period_end;
                                                                $newDate = (new DateTime($originalDate))->format(
                                                                    'd-m-Y',
                                                                );
                                                                $newDate2 = new DateTime($originalDate2);
                                                                $targetDate = $newDate2;
                                                                $now = new DateTime();

                                                                $daysRemaining =
                                                                    $now > $targetDate
                                                                        ? 0
                                                                        : $now->diff($targetDate)->format('%a') + 1;
                                                            @endphp

                                                            <td>
                                                                <div>
                                                                    {{ $newDate }} &nbsp; ถึง &nbsp;
                                                                    {{ $newDate2->format('d-m-Y') }}
                                                                    @if ($now->format('Y-m-d') == $targetDate->format('Y-m-d'))
                                                                        <span
                                                                            class="badge bg-label-primary me-1">วันสุดท้ายของประกัน</span>
                                                                    @else
                                                                        @if ($daysRemaining > 0)
                                                                            <span
                                                                                class="badge bg-label-primary me-1">เหลือเวลา
                                                                                {{ $daysRemaining }} วัน</span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-label-warning me-1">หมดประกัน</span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>{{ date('d-m-Y', strtotime($da2->created_at)) }}</td>
                                                            {{-- <td>{{ $da2->id }}</td> --}}
                                                            <td>
                                                                <span
                                                                    class="badge bg-label-info me-1">รอการอนุมัติคืนครุภัณฑ์</span>
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button type="button"
                                                                        class="btn p-0 dropdown-toggle hide-arrow"
                                                                        data-bs-toggle="dropdown">
                                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item"
                                                                            href="{{ url('return-item-show-list', $da2->id) }}">
                                                                            <i class='bx bxs-show'></i> View</a>
                                                                        <a class="dropdown-item alert-destroy"
                                                                            href="{{ url('return-item-approval-list', $da2->id) }}">
                                                                            <i class='bx bxs-send'></i>
                                                                            อนุมัติคืนครุภัณฑ์</a>
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
                                {{--   <a href="{{ url('durable-articles-requisition-export/pdf') }}" target="_blank"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานการเบิกครุภัณฑ์</a> --}}


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
