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
                            @php
                                $i = 1;
                                $j = 1;
                                $count0 = $data->where('status', '0')->count();
                                $count1 = $data->where('status', '1')->count();
                                $count2 = $data->where('status', '2')->count();
                                $countOn = $data->where('statusEmployee', 'on')->count();
                                $countOff = $data->where('statusEmployee', 'off')->count();

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
                                {{--   <p>จำนวนหัวหน้าวัสดุ &nbsp; {{ $count2 }} &nbsp; คน</p>
                                <p>จำนวนเจ้าหน้าที่วัสดุ &nbsp; {{ $count1 }} &nbsp; คน</p>
                                <p>จำนวนพนักงาน &nbsp; {{ $countOn }} &nbsp; คน</p>
                                <p>จำนวนพนักงานพ้นสภาพ &nbsp; {{ $countOff }} &nbsp; คน</p> --}}
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัสพนักงาน</th>
                                                <th>ชื่อ นามสกุล</th>
                                                <th>เบอร์โทร</th>
                                                <th>สถานะพนักงาน</th>
                                                <th>สถานะ</th>

                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            {{--  <h3>เปิดใช้งาน</h3> --}}
                                            @foreach ($data->where('status', '2')->sortByDesc('created_at') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->employee_id }}</td>
                                                    <td>{{ $da->prefix }} {{ $da->first_name }} {{ $da->last_name }}
                                                    </td>
                                                    <td>{{ $da->phone_number }}</td>
                                                    <td>หัวหน้าวัสดุ</td>
                                                    <td>
                                                        @if ($da->statusEmployee == 'on')
                                                            <span class="badge bg-label-success me-1">พนักงาน</span>
                                                        @else
                                                            <span class="badge bg-label-warning me-1">พ้นสภาพ</span>
                                                        @endif

                                                    </td>

                                                </tr>
                                            @endforeach
                                            @foreach ($data->where('status', '1')->sortByDesc('created_at') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->employee_id }}</td>
                                                    <td>{{ $da->prefix }} {{ $da->first_name }}
                                                        {{ $da->last_name }}
                                                    </td>
                                                    <td>{{ $da->phone_number }}</td>
                                                    <td>เจ้าหน้าที่วัสดุ </td>
                                                    <td>
                                                        @if ($da->statusEmployee == 'on')
                                                            <span class="badge bg-label-success me-1">พนักงาน</span>
                                                        @else
                                                            <span class="badge bg-label-warning me-1">พ้นสภาพ</span>
                                                        @endif

                                                    </td>

                                                </tr>
                                            @endforeach
                                            @foreach ($data->where('status', '0')->sortByDesc('created_at') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->employee_id }}</td>
                                                    <td>{{ $da->prefix }} {{ $da->first_name }}
                                                        {{ $da->last_name }}
                                                    </td>
                                                    <td>{{ $da->phone_number }}</td>
                                                    <td>ผู้เบิก</td>
                                                    <td>
                                                        @if ($da->statusEmployee == 'on')
                                                            <span class="badge bg-label-success me-1">พนักงาน</span>
                                                        @else
                                                            <span class="badge bg-label-warning me-1">พ้นสภาพ</span>
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
