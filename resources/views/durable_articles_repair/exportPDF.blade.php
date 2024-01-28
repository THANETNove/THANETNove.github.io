<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงานข้อมูลสถานที่</title>
    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    @include('layouts.fonts_DPF')
</head>

<body>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-12">
                            <div class="card-body">
                                <h1 class="card-title text-primary ">รายงานครุภัณฑ์ที่ซ่อม ประจำปี
                                    {{ $currentYear + 543 }}</h1>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>หมวดหมู่ครุภัณฑ์</th>
                                                <th>รหัสครุภัณฑ์</th>
                                                <th>ชื่อครุภัณฑ์</th>
                                                <th>จำนวนที่ซ่อม</th>
                                                <th>หน่วยนับ</th>
                                                <th>สถานะ </th>
                                                <th>ค่าซ่อม </th>
                                                <th>รายละเอียด</th>
                                                <th>วันที่สร้าง</th>
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
                                                    <td>{{ $da->code_durable_articles }}</td>
                                                    <td>{{ $da->durableArticles_name }}</td>
                                                    <td class="td-center">{{ number_format($da->amount_repair) }}</td>
                                                    <td class="td-center">{{ $da->name_durable_articles_count }}</td>
                                                    <td class="td-center">
                                                        @if ($da->status == '0')
                                                            <span class="badge bg-label-success me-1">ซ่อม</span>
                                                        @elseif ($da->status == '1')
                                                            <span class="badge bg-label-warning me-1">ยกเลิก</span>
                                                        @else
                                                            <span class="badge bg-label-primary me-1">ซ่อมสำเร็จ</span>
                                                        @endif
                                                    </td>
                                                    <td class="td-center">{{ number_format($da->repair_price) }}</td>
                                                    <td>{{ $da->repair_detail }}</td>
                                                    <td class="td-center">
                                                        {{ date('d-m-Y', strtotime($da->created_at)) }}</td>
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
