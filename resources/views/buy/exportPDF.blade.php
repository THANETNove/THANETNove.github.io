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
                                $count = $data->count();
                                $count0 = $data->where('status', '0')->count();
                                $count1 = $data->where('status', '1')->count();
                                $count2 = $data->where('status', '2')->count();

                            @endphp
                            <div class="card-body">
                                <h1 class="card-title text-primary ">สถานที่จัดเก็บ</h1>
                                <p>รายงานข้อมูลสถานที่จัดเก็บ</p>
                                <p class="mt--16">จำนวนทั้งหมด {{ $count }} รายการ</p>
                                <p class="mt--16">จำนวนการสั่งซื้อ {{ $count0 }} รายการ</p>
                                <p class="mt--16">จำนวนการซื้อสำเร็จ {{ $count1 }} รายการ</p>
                                <p class="mt--16">จำนวนการยกเลิกการซื้อ {{ $count2 }} รายการ</p>
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
                                            @foreach ($data->where('status', '=', '0') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->typeBuy }}</td>
                                                    <td>{{ $da->buy_name }}</td>
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
                                            <br>
                                            @foreach ($data->where('status', '1') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->typeBuy }}</td>
                                                    <td>{{ $da->buy_name }}</td>
                                                    <td>{{ $da->quantity }}</td>
                                                    <td>{{ $da->counting_unit }}</td>
                                                    <td>{{ $da->price_per_piece }}</td>
                                                    <td>{{ $da->total_price }}</td>
                                                    <td>{{ $da->details }}</td>
                                                    <td>
                                                        <span class="badge bg-label-success me-1">ซื้อเเล้ว</span>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            <br>
                                            @foreach ($data->where('status', '2') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->typeBuy }}</td>
                                                    <td>{{ $da->buy_name }}</td>
                                                    <td>{{ $da->quantity }}</td>
                                                    <td>{{ $da->counting_unit }}</td>
                                                    <td>{{ $da->price_per_piece }}</td>
                                                    <td>{{ $da->total_price }}</td>
                                                    <td>{{ $da->details }}</td>
                                                    <td>
                                                        <span class="badge bg-label-warning me-1">ยกเลิกซื้อ</span>

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
