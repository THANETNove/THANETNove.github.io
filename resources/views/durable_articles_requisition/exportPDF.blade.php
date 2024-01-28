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
                    <h1 class="card-title text-primary ">รายงานการเบิกครุภัณฑ์ ประจำปี
                        {{ $currentYear + 543 }}</h1>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>หมวดหมู่ครุภัณฑ์</th>
                                    <th>รหัสวัสดุ</th>
                                    <th>ชื่อวัสดุ</th>
                                    <th>ที่เบิก</th>

                                    @if (Auth::user()->status != '0')
                                        <th>ชื่อ นามสกุล ผู้เบิก </th>
                                    @endif
                                    <th>เเผนก </th>
                                    <th>ระยะประกัน </th>
                                    <th>วันที่เบิก </th>


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
                                        <td>{{ $da->amount_withdraw }} {{ $da->name_durable_articles_count }}</td>

                                        @if (Auth::user()->status != '0')
                                            <td>{{ $da->prefix }} {{ $da->first_name }} {{ $da->last_name }}
                                            </td>
                                        @endif
                                        <td>{{ $da->department_name }}</td>
                                        @php
                                            $originalDate = $da->created_at;
                                            $newDate = (new DateTime($originalDate))->modify('+7 days')->format('d/m/Y');
                                            $newDate2 = (new DateTime($originalDate))->modify('+7 days');
                                            $targetDate = $newDate2;
                                            $now = new DateTime();

                                            $daysRemaining = $now > $targetDate ? 0 : $now->diff($targetDate)->format('%a') + 1;
                                        @endphp
                                        <td>{{ $newDate }}
                                        </td>
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
