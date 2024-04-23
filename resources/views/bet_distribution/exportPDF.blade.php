<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $name_export }}</title>
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
                                <h1 class="card-title text-primary td-center">
                                    ศูนย์ปฏิบัติการ อบต.บางเเม่นาง อ.บางใหญ่ จ.นนทบุรี
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
                                                <th>ลำดับ </th>
                                                <th>รหัสครุภัณฑ์ </th>
                                                <th>หมวดหมู่ครุภัณฑ์</th>
                                                <th>ชื่อครุภัณฑ์</th>
                                                <th>ชื่อย่อครุภัณฑ์</th>
                                                <th>จำหน่าย</th>
                                                <th>หน่วยนับ</th>
                                                <th>ราคาซาก</th>
                                                <th>สถานะ </th>

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
                                                    <td class="td-center">{{ $da->code_durable_articles }}</td>
                                                    <td>{{ $da->category_name }}</td>
                                                    <td>{{ $da->type_name }}</td>
                                                    <td>{{ $da->durableArticles_name }}</td>
                                                    <td class="td-center">
                                                        1</td>
                                                    <td class="td-center">{{ $da->name_durableArticles_count }}</td>
                                                    <td class="td-center">{{ number_format($da->salvage_price) }}</td>


                                                    <td class="td-center">
                                                        <span class="badge bg-label-success me-1">เเทงจำหน่าย</span>
                                                    </td>
                                                    <td>{{ $da->repair_detail }}</td>

                                                    <td>{{ date('d-m-Y', strtotime($da->created_at)) }}</td>
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
