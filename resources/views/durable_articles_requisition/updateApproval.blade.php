@extends('layouts.app')

@section('content')
    <!-- Content  aaa -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-12">

                            <div class="card-body">
                                <h1 class="card-title text-primary ">อนุมัติครุภัณฑ์</h1>
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>เบิก/ยืม</th>
                                                <th>รหัสครุภัณฑ์</th>
                                                <th>หมวดหมู่</th>
                                                <th>ชื่อครุภัณฑ์</th>
                                                <th>รายละเอียดครุภัณฑ์</th>
                                                <th>จำนวนที่เบิก</th>
                                                <th>หน่วยนับ </th>
                                                @if (Auth::user()->status != '0')
                                                    <th>ชื่อ นามสกุล ผู้เบิก </th>
                                                @endif
                                                {{--  <th>ระยะประกัน </th> --}}
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
                                                    <td>{{ $da->name_type }}</td>
                                                    <td>{{ $da->code_durable_articles }}</td>
                                                    <td>{{ $da->category_name }}</td>
                                                    <td>{{ $da->type_name }}</td>
                                                    <td>{{ $da->durableArticles_name }}</td>
                                                    <td>{{ $da->groupWithdrawCount }}</td>
                                                    <td>{{ $da->name_durable_articles_count }}</td>
                                                    @if (Auth::user()->status != '0')
                                                        <td>{{ $da->prefix }} {{ $da->first_name }} {{ $da->last_name }}
                                                        </td>
                                                    @endif
                                                    {{-- @php
                                                        $originalDate = $da->created_at;
                                                        $newDate = (new DateTime($originalDate))->modify('+7 days')->format('d/m/Y');
                                                        $newDate2 = (new DateTime($originalDate))->modify('+7 days');
                                                        $targetDate = $newDate2;
                                                        $now = new DateTime();

                                                        $daysRemaining = $now > $targetDate ? 0 : $now->diff($targetDate)->format('%a') + 1;
                                                    @endphp --}}
                                                    {{--                            <td>{{ $newDate }}
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

                                                    </td> --}}
                                                    <td>
                                                        <a href="{{ url('approved', $da->id) }}" class="alert-destroy">
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
                    <form class="user" id="myForm" method="POST" action="{{ route('not-approved') }}">
                        @csrf

                        <input type="text" name="id" id="rejectedId" value="" style="display: none;">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">หมายเหตุ</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class="bx bx-comment"></i></span>
                                    <textarea id="basic-icon-default-message" name="commentApproval" class="form-control" placeholder="หมายเหตุ "
                                        aria-label="หมายเหตุ" aria-describedby="basic-icon-default-message2" style="height: 78px;"></textarea>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
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
