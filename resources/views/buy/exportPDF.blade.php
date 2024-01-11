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

                            @endphp
                            <div class="card-body">
                                <h1 class="card-title text-primary ">รายการเข้า</h1>
                                <p>รายงานการเข้า</p>
                                <p class="mt--16">จำนวนทั้งหมด {{ $count }} รายการ</p>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ประเภท</th>
                                                <th>ชื่อ</th>
                                                <th>จำนวน</th>
                                                <th>หน่วยนับ</th>
                                                <th>ราคา ต่อชิ้น</th>
                                                <th>ราคา รวม</th>
                                                <th>รายละเอียด</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>
                                                        @if ($da->typeBuy == 1)
                                                            ประเภทวัสดุ
                                                        @else
                                                            ประเภทครุภัณฑ์
                                                        @endif
                                                    </td>
                                                    <td>{{ $da->category_name }}</td>
                                                    <td>
                                                        @if ($da->typeBuy == 1)
                                                            {{ $da->material_name }}
                                                        @else
                                                            {{ $da->durableArticles_name }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $da->quantity }}</td>
                                                    <td>{{ $da->counting_unit }}</td>
                                                    <td>{{ $da->price_per_piece }}</td>
                                                    <td>{{ $da->total_price }}</td>
                                                    <td>{{ $da->details }}</td>
                                                    <td>
                                                        <span class="badge bg-label-info me-1">รอการซื้อ</span>
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
