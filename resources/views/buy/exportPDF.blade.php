<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $name_export }}</title>
    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    @include('layouts.fonts_DPF')
    <style>
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
                                <h1 class="card-title text-primary td-center">
                                    องค์การบริหารส่วน ตำบลบางแม่นาง อำเภอบางใหญ่ จังหวัดนนทบุรี
                                </h1>
                                <h1 class="card-title text-primary td-center">
                                    {{ $name_export }}
                                </h1>
                                <h1 class="card-title text-primary td-center mt-32">
                                    ณ วันที่ {{ $date_export }}
                                </h1>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">ลำดับ</th>
                                                <th scope="col">ประเภท</th>
                                                <th scope="col">ชื่อประเภท</th>
                                                <th scope="col">ชื่อ</th>
                                                <th scope="col">จำนวน</th>
                                                <th scope="col">ราคา</th>
                                                <th scope="col">ราคารวม</th>
                                                <th>วันที่สร้าง</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($data as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>
                                                        วัสดุ
                                                        {{--  @if ($da->typeBuy == 1)
                                                            วัสดุ
                                                        @else
                                                            ครุภัณฑ์
                                                        @endif --}}
                                                    </td>
                                                    <td>{{ $da->category_name }}</td>
                                                    <td>
                                                        {{ $da->material_name }}
                                                    </td>
                                                    <td class="td-center">{{ number_format($da->quantity) }} </td>

                                                    <td class="td-center">{{ number_format($da->price_per_piece) }}
                                                    </td>
                                                    <td class="td-center">{{ number_format($da->total_price) }}</td>
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
