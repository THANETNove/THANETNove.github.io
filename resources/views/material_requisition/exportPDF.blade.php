<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $name_export }}</title>
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
                                                <th>ลำดับ</th>
                                                @if ($type != 3)
                                                    <th>หมวดวัสดุ</th>
                                                @endif
                                                <th>รหัสวัสดุ</th>
                                                <th>ชื่อวัสดุ</th>
                                                <th>จำนวนที่เบิก</th>
                                                <th>หน่วย</th>

                                                @if ($type != 5)
                                                    @if (Auth::user()->status != '0')
                                                        <th>ชื่อ นามสกุล ผู้เบิก </th>
                                                    @endif
                                                @endif
                                                @if ($type != 5 && $type != 4 && Auth::user()->status != '0')
                                                    <th>เเผนก </th>
                                                @endif
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
                                                    @if ($type != 3)
                                                        <td>{{ $da->category_name }}</td>
                                                    @endif
                                                    <td>{{ $da->code_requisition }}</td>
                                                    <td>{{ $da->name }}</td>
                                                    <td class="td-center">{{ number_format($da->amount_withdraw) }}</td>
                                                    <td class="td-center">{{ $da->name_material_count }}</td>
                                                    @if ($type != 5)
                                                        @if (Auth::user()->status != '0')
                                                            <td>{{ $da->prefix }} {{ $da->first_name }}
                                                                {{ $da->last_name }}
                                                            </td>
                                                        @endif
                                                    @endif
                                                    @if ($type != 5 && $type != 4 && Auth::user()->status != '0')
                                                        <td>
                                                            {{ $da->department_name }}
                                                        </td>
                                                    @endif

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
