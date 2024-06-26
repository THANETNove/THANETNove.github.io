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
                                <h1 class="card-title text-primary ">ครุภัณฑ์ที่ชำรุด</h1>
                                {{--  <a href="{{ url('durable-articles-damaged-export/pdf') }}" target="_blank"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานข้อมูลครุภัณฑ์ที่ชำรุด</a> --}}
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัสครุภัณฑ์</th>
                                                <th>หมวดหมู่ครุภัณฑ์</th>
                                                <th>ชื่อครุภัณฑ์</th>
                                                <th>รายละเอียดครุภัณฑ์</th>
                                                <th>สถานะการชำรุด</th>

                                                {{--  @if (Auth::user()->status != '0')
                                                    <th>ชื่อ นามสกุล ผู้แจ้ง </th>
                                                @endif --}}
                                                <th>สถานะ </th>
                                                <th>รายละเอียด</th>
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

                                                    <td>{{ $da->category_code }}-{{ $da->type_code }}-{{ $da->description }}-{{ $da->group_count }}
                                                    </td>

                                                    <td>{{ $da->category_name }}</td>
                                                    <td>{{ $da->type_name }}</td>
                                                    <td>{{ $da->durableArticles_name }}</td>

                                                    <td>
                                                        @if ($da->status_damaged == 0)
                                                            <span class="badge bg-label-success me-1">ซ่อมได้</span>
                                                        @else
                                                            <span class="badge bg-label-warning me-1">ซ่อมไม่ได้</span>
                                                        @endif

                                                    </td>

                                                    {{--  @if (Auth::user()->status != '0')
                                                        <td>{{ $da->prefix }} {{ $da->first_name }} {{ $da->last_name }}
                                                        </td>
                                                    @endif --}}
                                                    <td>
                                                        @if ($da->status == '0')
                                                            <span class="badge bg-label-success me-1">ชำรุด</span>
                                                        @elseif ($da->status == '1')
                                                            <span class="badge bg-label-warning me-1">ยกเลิก</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $da->damaged_detail }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($da->created_at)) }}</td>
                                                    @if ($da->status == '0')
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>

                                                                <div class="dropdown-menu">
                                                                    @if (Auth::user()->status > '0')
                                                                        {{--  <a class="dropdown-item"
                                                                            href="{{ url('durable-articles-damaged-edit', $da->id) }}"><i
                                                                                class="bx bx-edit-alt me-1"></i> Edit</a> --}}
                                                                        @if (Auth::user()->status == '2')
                                                                            <a class="dropdown-item alert-destroy"
                                                                                href="{{ url('durable-articles-damaged-destroy', $da->id) }}"><i
                                                                                    class="bx bx-trash me-1"></i> ยกเลิก</a>
                                                                        @endif
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
