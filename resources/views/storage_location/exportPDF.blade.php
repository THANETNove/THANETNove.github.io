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
                            @php
                                $i = 1;
                                $j = 1;
                                $countOn = $data->where('status', 'on')->count();
                                $countOff = $data->where('status', 'off')->count();

                            @endphp
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
                                                <th>ชื่ออาคาร</th>
                                                <th>ชั้น</th>
                                                <th>ชื่อห้อง</th>
                                                <th>สถานะ</th>

                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            {{--  <h3>เปิดใช้งาน</h3> --}}
                                            @foreach ($data->where('status', 'on')->sortByDesc('created_at') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->building_name }}</td>
                                                    <td class="td-center">{{ $da->floor }}</td>
                                                    <td>{{ $da->room_name }}</td>
                                                    <td class="td-center">เปิดใช้งานอยู่</td>

                                                </tr>
                                            @endforeach
                                            <br>
                                            {{--  <h3>ปิดใช้งาน</h3> --}}
                                            @foreach ($data->where('status', 'off')->sortByDesc('created_at') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->building_name }}</td>
                                                    <td>{{ $da->floor }}</td>
                                                    <td>{{ $da->room_name }}</td>
                                                    <td>ปิดใช้งานอยู่</td>



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
