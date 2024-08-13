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
                                <h1 class="card-title text-primary ">อนุมัติวัสดุอุปกรณ์</h1>
                                {{-- <button href="{{ url('material-requisition-export/pdf') }}" target="_blank" data-bs-toggle="modal" data-bs-target="#exampleModalBuy"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานการเบิกวัสดุอุปกรณ์</button> --}}
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif
                                @if ($errors->has('remaining_amount_zero'))
                                    <p style="color: red;font-size: 20px;" class="text-center">
                                        {{ $errors->first('remaining_amount_zero') }}
                                    </p>
                                @endif

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>

                                                <th>หมวดวัสดุ</th>
                                                <th>ชื่อวัสดุ</th>
                                                <th>จำนวนที่เบิก</th>
                                                <th>วันที่เบิก </th>
                                                @if (Auth::user()->status != '0')
                                                    <th>ชื่อ นามสกุล ผู้เบิก </th>
                                                @endif
                                                {{-- <th>ที่เก็บ </th> --}}

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

                                                    <td>{{ $da->name }}</td>
                                                    <td>{{ number_format($da->amount_withdraw) }}&nbsp;&nbsp;
                                                        {{ $da->name_material_count }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($da->created_at)->locale('th')->translatedFormat('j F Y') }}
                                                    </td>

                                                    @if (Auth::user()->status != '0')
                                                        <td>{{ $da->prefix }} {{ $da->first_name }} {{ $da->last_name }}
                                                        </td>
                                                    @endif
                                                    {{--  <td>{{ $da->building_name }} &nbsp;{{ $da->floor }} &nbsp;
                                                        {{ $da->room_name }}</td> --}}

                                                    <td>
                                                        {{-- <a href="{{ url('approved-material', $da->id) }}"
                                                            class="alert-destroy">
                                                            <button type="button" class="btn btn-info">อนุมัติ</button>
                                                        </a> --}}
                                                        <button type="button" class="btn btn-info" style="margin-left: 6px"
                                                            onclick="setId2('{{ $da->id }}','{{ $da->amount_withdraw }}',{{ $da->remaining_amount }})"
                                                            data-bs-toggle="modal" data-bs-target="#modalCenter2">
                                                            อนุมัติ
                                                        </button>

                                                        <button type="button" class="btn btn-danger"
                                                            style="margin-left: 6px"
                                                            onclick="setId('{{ $da->id }}',{{ $da->remaining_amount }})"
                                                            data-bs-toggle="modal" data-bs-target="#modalCenter">
                                                            ไม่อนุมัติ
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>

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
                    <h5 id="amount-ithdraw-count2"></h5>
                    <form class="user" id="myForm" method="POST" action="{{ route('not-approved-material') }}">
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

    <div class="modal fade" id="modalCenter2" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">อนุมัติ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="amount-ithdraw-count"></h5>
                    <form class="user" id="myForm" method="POST" action="{{ route('approved-material') }}">
                        @csrf

                        <input type="text" name="id" id="rejectedId2" value="" style="display: none;">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">จำนวนที่อนุมัติ</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class="bx bx-comment"></i></span>
                                    <input type="number" class="form-control" name="withdrawCount"
                                        oninput="inputCountApprovve(this)" id="withdraw-count">
                                </div>
                                <p id="overfilled" style="margin-top: 8px;color: red;"></p>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">บันทึก</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let number = 0;

        function setId(id, amount_withdraw) {
            $('#amount-ithdraw-count2').empty();

            $('#rejectedId').val(id);
            $('#amount-ithdraw-count2').html("จำนวนคงเหลือ  " + amount_withdraw.toLocaleString());
        }

        function setId2(id, withdrawCount, amount_withdraw) {
            number = amount_withdraw;
            $('#amount-ithdraw-count').empty();

            $('#rejectedId2').val(id);
            $('#withdraw-count').val(withdrawCount);
            $('#amount-ithdraw-count').html("จำนวนคงเหลือ  " + amount_withdraw.toLocaleString());
            console.log("444");
            const submitButton = document.getElementById('submitButton');
            const overfilledMessage = document.getElementById('overfilled');

            // แปลงค่า input เป็นตัวเลข
            if (!isNaN(withdrawCount) && parseFloat(withdrawCount) > parseFloat(amount_withdraw)) {
                overfilledMessage.textContent = 'จำนวนที่อนุมัติเกินที่มีอยู่';
                submitButton.disabled = true;
                submitButton.classList.add('btn-secondary'); // เปลี่ยนสีปุ่มเป็นสีเทา
                submitButton.classList.remove('btn-primary'); // ลบคลาส btn-primary
            } else {
                overfilledMessage.textContent = '';
                submitButton.disabled = false;
                submitButton.classList.add('btn-primary'); // เปลี่ยนสีปุ่มเป็นสีหลัก
                submitButton.classList.remove('btn-secondary'); // ลบคลาส btn-secondary
            }

        }

        function inputCountApprovve(input) {
            $('#overfilled').empty();
            if (input.value < 1) {
                input.value = input;
            }
            const submitButton = document.getElementById('submitButton');
            const overfilledMessage = document.getElementById('overfilled');

            // แปลงค่า input เป็นตัวเลข
            const numberValue = parseFloat(input.value);

            if (!isNaN(numberValue) && numberValue > number) {
                overfilledMessage.textContent = 'จำนวนที่อนุมัติเกินที่มีอยู่';
                submitButton.disabled = true;
                submitButton.classList.add('btn-secondary'); // เปลี่ยนสีปุ่มเป็นสีเทา
                submitButton.classList.remove('btn-primary'); // ลบคลาส btn-primary
            } else {
                overfilledMessage.textContent = '';
                submitButton.disabled = false;
                submitButton.classList.add('btn-primary'); // เปลี่ยนสีปุ่มเป็นสีหลัก
                submitButton.classList.remove('btn-secondary'); // ลบคลาส btn-secondary
            }
        }
    </script>
@endsection
