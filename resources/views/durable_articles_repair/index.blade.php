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
                                <h1 class="card-title text-primary ">ครุภัณฑ์ที่ซ่อม</h1>

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัสครุภัณฑ์</th>
                                                <th>หมวดหมู่ครุภัณฑ์</th>
                                                <th>ชื่อครุภัณฑ์</th>
                                                <th>รายละเอียดครุภัณฑ์</th>
                                                <th>หน่วยนับ</th>
                                                <th>สถานะ </th>
                                                <th>ค่าซ่อม </th>
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
                                                    <td>{{ $da->code_durable_articles }}</td>
                                                    <td>{{ $da->category_name }}</td>
                                                    <td>{{ $da->type_name }}</td>
                                                    <td>{{ $da->durableArticles_name }}</td>
                                                    <td>{{ $da->name_durableArticles_count }}</td>
                                                    <td>
                                                        @if ($da->status == '0')
                                                            <span class="badge bg-label-success me-1">ซ่อม</span>
                                                        @elseif ($da->status == '1')
                                                            <span class="badge bg-label-warning me-1">ยกเลิก</span>
                                                        @else
                                                            <span class="badge bg-label-primary me-1">ซ่อมสำเร็จ</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($da->repair_price != 0)
                                                            {{ number_format($da->repair_price) }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $da->repair_detail }}</td>
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
                                                                    {{--  <a class="dropdown-item"
                                                                        href="{{ url('get-articlesRepair-edit', $da->id) }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a> --}}
                                                                    @if (Auth::user()->status == '2')
                                                                        <a class="dropdown-item alert-destroy"
                                                                            href="{{ url('get-articlesRepair-destroy', $da->id) }}"><i
                                                                                class="bx bx-trash me-1"></i> ยกเลิก</a>
                                                                        {{--  <a class="dropdown-item  alert-destroy"
                                                                            href="{{ url('get-articlesRepair-updateRepair', $da->id) }}">
                                                                            <i class='bx bxs-check-circle'></i>
                                                                            ซ่อมสำเร็จ</a> --}}
                                                                        <a class="dropdown-item updateRepair"
                                                                            onclick="setId('{{ $da->id }}')"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalCenter">
                                                                            <i class='bx bxs-check-circle'></i>
                                                                            ซ่อมสำเร็จ
                                                                        </a>
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

    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">ราคาค่าซ่อม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="user" id="myForm" method="POST"
                        action="{{ route('get-articlesRepair-updateRepair') }}">
                        @csrf

                        <input type="text" name="id" id="rejectedId" value="" style="display: none;">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">ราคาค่าซ่อม</label>
                                <div class="input-group input-group-merge">

                                    <input type="number" name="repair_price" class="form-control" id="repair_price">

                                    {{--      <textarea id="basic-icon-default-message" name="commentApproval" class="form-control" placeholder="หมายเหตุ"
                                        aria-label="หมายเหตุ" aria-describedby="basic-icon-default-message2" style="height: 78px;"></textarea> --}}
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary ">บันทึก</button>
                </div>
                </form>


            </div>
        </div>
    </div>

    <script>
        function setId(id) {
            $('#rejectedId').val(id);
        }
    </script>

    <!-- / Layout wrapper -->
@endsection
