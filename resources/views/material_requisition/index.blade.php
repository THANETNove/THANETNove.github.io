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
                                <button {{-- href="{{ url('material-requisition-export/pdf') }}" target="_blank" --}} data-bs-toggle="modal" data-bs-target="#exampleModalBuy"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานการเบิกวัสดุอุปกรณ์</button>
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
                                                    <td>{{ number_format($da->amount_withdraw) }}</td>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModalBuy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">รายการข้อมูลเข้า</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('material-requisition-export/pdf') }}" target="_blank">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-6">
                                <label for="exampleFormControlInput1" class="form-label">วันที่เริ่มต้น</label>
                                <input type="text" class="form-control date-created_at" name="start_date" id="start_date"
                                    placeholder="yyy-mm-dd" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="exampleFormControlTextarea1" class="form-label">วันที่สิ้นสุด</label>
                                <input type="text" class="form-control date-created_at" name="end_date" id="end_date"
                                    placeholder="yyyy-mm-dd" required>
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
