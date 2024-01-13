@extends('layouts.app')

@section('content')
    <!-- Content -->
    {{-- test upcode --}}
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-12">

                            <div class="card-body">
                                <h1 class="card-title text-primary ">เบิกวัสดุอุปกรณ์</h1>
                                <a href="{{ url('material-requisition-export/pdf') }}"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานการเบิกวัสดุอุปกรณ์</a>
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>หมวดวัสดุ</th>
                                                <th>รหัสวัสดุ</th>
                                                <th>ชื่อวัสดุ</th>
                                                <th>จำนวนที่เบิก</th>
                                                <th>หน่วยนับ </th>
                                                @if (Auth::user()->status != '0')
                                                    <th>ชื่อ นามสกุล ผู้เบิก </th>
                                                @endif
                                                <th>ที่เก็บ </th>
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
                                                    <td>{{ $da->code_requisition }}</td>
                                                    <td>{{ $da->name }}</td>
                                                    <td>{{ $da->amount_withdraw }}</td>
                                                    <td>{{ $da->name_material_count }}</td>
                                                    @if (Auth::user()->status != '0')
                                                        <td>{{ $da->prefix }} {{ $da->first_name }} {{ $da->last_name }}
                                                        </td>
                                                    @endif
                                                    <td>{{ $da->building_name }} &nbsp;{{ $da->floor }} &nbsp;
                                                        {{ $da->room_name }}</td>
                                                    <td>
                                                        @if ($da->status == 'on')
                                                            <span class="badge bg-label-success me-1">เบิกวัสดุ</span>
                                                        @else
                                                            <span class="badge bg-label-warning me-1">ยกเลิกเบิกวัสดุ</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($da->status == 'on')
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">

                                                                    <a class="dropdown-item"
                                                                        href="{{ url('material-requisition-edit', $da->id) }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                    @if (Auth::user()->status != '1')
                                                                        <a class="dropdown-item alert-destroy"
                                                                            href="{{ url('material-requisition-destroy', $da->id) }}"><i
                                                                                class="bx bx-trash me-1"></i> ยกเลิก</a>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        @endif
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
