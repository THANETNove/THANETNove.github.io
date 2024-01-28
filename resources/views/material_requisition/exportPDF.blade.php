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
                            @php
                                $i = 1;
                                $j = 1;
                                $countOn = $data->where('status', 'on')->count();
                                $countOff = $data->where('status', 'off')->count();

                            @endphp
                            <div class="card-body">
                                <h1 class="card-title text-primary ">รายงานการเบิกวัสดุ ประจำปี
                                    {{ $currentYear + 543 }}</h1>
                                {{--    <p>รายงานข้อมูลการเบิกวัสดุอุปกรณ์</p>
                                <p class="mt--16">จำนวนเบิกวัสดุ {{ $countOn }}</p>
                                <p class="mt--16">จำนวนยกเลิกเบิกวัสดุ {{ $countOff }}</p> --}}
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>หมวดวัสดุ</th>
                                                <th>รหัสวัสดุ</th>
                                                <th>ชื่อวัสดุ</th>
                                                <th>จำนวนที่เบิก</th>
                                                <th>หน่วย</th>
                                                @if (Auth::user()->status != '0')
                                                    <th>ชื่อ นามสกุล ผู้เบิก </th>
                                                @endif

                                                <th>เเผนก </th>
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
                                                    <td>{{ $da->code_requisition }}</td>
                                                    <td>{{ $da->name }}</td>
                                                    <td class="td-center">{{ number_format($da->amount_withdraw) }}</td>
                                                    <td class="td-center">{{ $da->name_material_count }}</td>
                                                    @if (Auth::user()->status != '0')
                                                        <td>{{ $da->prefix }} {{ $da->first_name }}
                                                            {{ $da->last_name }}
                                                        </td>
                                                    @endif
                                                    <td>
                                                        {{ $da->department_name }}
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
