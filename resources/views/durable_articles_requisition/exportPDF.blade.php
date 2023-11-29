<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงานข้อมูลสถานที่</title>
    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    @include('layouts.fonts_DPF')
    <style>
        .table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle !important;
        }

        .badge {
            font-size: 0.8rem;
        }
    </style>

</head>

<body>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-12">
                            @php
                                $i = 1;
                                $j = 1;
                                $count = $data->count();
                                $countApprovalWait = $data
                                    ->where('statusApproval', '0')
                                    ->where('status', 'on')
                                    ->count();
                                $countApproval = $data->where('statusApproval', '1')->count();
                                $countNotApproval = $data->where('statusApproval', '2')->count();

                            @endphp
                            <div class="card-body">
                                <h1 class="card-title text-primary ">เบิกครุภัณฑ์</h1>
                                <p>รายงานข้อมูลการเบิกครุภัณฑ์</p>
                                <p class="mt--16">จำนวนเบิกครุภัณฑ์ {{ $count }}</p>
                                <p class="mt--16">จำนวนอนุมัติเบิกครุภัณฑ์ {{ $countApproval }}</p>
                                <p class="mt--16">จำนวนไม่อนุมัติเบิกครุภัณฑ์ {{ $countNotApproval }}</p>
                                <p class="mt--16">จำนวนรอเบิกครุภัณฑ์ {{ $countApprovalWait }}</p>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <th>ลำดับ</th>
                                            <th>รหัสครุภัณฑ์</th>
                                            <th>ชื่อครุภัณฑ์</th>
                                            <th>จำนวนที่เบิก</th>
                                            <th>หน่วยนับ </th>
                                            @if (Auth::user()->status != '0')
                                                <th>ชื่อ นามสกุล ผู้เบิก </th>
                                            @endif
                                            <th>การอนุมัติ </th>
                                            <th>สถานะ </th>

                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->code_durable_articles }}</td>
                                                    <td>{{ $da->durable_articles_name }}</td>
                                                    <td>{{ $da->amount_withdraw }}</td>
                                                    <td>{{ $da->name_durable_articles_count }}</td>
                                                    @if (Auth::user()->status != '0')
                                                        <td>{{ $da->prefix }} {{ $da->first_name }}
                                                            {{ $da->last_name }}
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @if ($da->status == 'on')
                                                            @if ($da->statusApproval == '0')
                                                                <span
                                                                    class="badge bg-label-info me-1">รอการอนุมัติ</span>
                                                            @elseif ($da->statusApproval == '1')
                                                                <span class="badge bg-label-success me-1">อนุมัติ</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-label-warning me-1">ไม่อนุมัติ</span>
                                                            @endif
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($da->status == 'on')
                                                            <span
                                                                class="badge bg-label-success me-1">เบิกครุภัณฑ์</span>
                                                        @else
                                                            <span
                                                                class="badge bg-label-warning me-1">ยกเลิกเบิกครุภัณฑ์</span>
                                                        @endif
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
</body>

</html>
