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
                                <h1 class="card-title text-primary ">ครุภัณฑ์ที่แทงจำหน่าย</h1>
                                <a href="{{ url('personnel-export/pdf') }}"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานข้อมูลครุภัณฑ์ที่แทงจำหน่าย</a>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>หมวดหมู่ครุภัณฑ์</th>
                                                <th>รหัสครุภัณฑ์</th>
                                                <th>ชื่อครุภัณฑ์</th>
                                                <th>จำนวนที่เเทงจำหน่าย</th>
                                                <th>หน่วยนับ</th>
                                                <th>ราคาซาก</th>

                                                <th>สถานะการอนุมัติ </th>
                                                <th>รายละเอียด</th>
                                                <th>วันที่สร้าง</th>
                                                <th>การอนุมัติ </th>
                                            </tr>
                                        </thead>
                                        @php
                                            $i = 1;
                                        @endphp
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->category_name }} {{ $da->id }}</td>
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

                                                    <td>{{ $da->repair_detail }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($da->created_at)) }}</td>
                                                    <td>
                                                        <a href="{{ url('approved_bet_distribution', $da->id) }}"
                                                            class="alert-destroy">
                                                            <button type="button" class="btn btn-info">อนุมัติ</button>
                                                        </a>

                                                        <button type="button" class="btn btn-danger"
                                                            style="margin-left: 6px" onclick="setId('{{ $da->id }}')"
                                                            data-bs-toggle="modal" data-bs-target="#modalCenter">
                                                            ไม่อนุมัติ
                                                        </button>
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
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">ไม่อนุมัติ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="user" id="myForm" method="POST"
                        action="{{ route('not-approved-bet-distribution') }}">
                        @csrf

                        <input type="text" name="id" id="rejectedId" value="" style="display: none;">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">หมายเหตุ</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class="bx bx-comment"></i></span>
                                    <textarea id="basic-icon-default-message" name="commentApproval" class="form-control" placeholder="หมายเหตุ"
                                        aria-label="หมายเหตุ" aria-describedby="basic-icon-default-message2" style="height: 78px;"></textarea>
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
