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
                                <h1 class="card-title text-primary ">รายงานครุภัณฑ์ ประจำปี
                                    {{ $currentYear + 543 }}</h1>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัส</th>
                                                <th>ประเภทครุภัณฑ์</th>
                                                <th>ชื่อ</th>
                                                <th>จำนวน</th>
                                                <th>ที่เบิกได้</th>
                                                <th>ชำรุด</th>
                                                <th>จำหน่าย</th>
                                                <th>ซ่อม</th>
                                                <th>ค่าเสื่อม</th>
                                                <th>หน่วย</th>
                                                <th>ที่เก็บ</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $i = 1;
                                        @endphp
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data->groupBy('group_class') as $groupedData)
                                                @foreach ($groupedData->sortBy(['type_durableArticles', 'description', 'durableArticles_number']) as $da)
                                                    <tr>
                                                        <th scope="row">{{ $i++ }}</th>
                                                        <td>{{ $da->group_class }}-{{ $da->type_durableArticles }}-{{ $da->description }}
                                                        </td>
                                                        <td>{{ $da->category_name }}</td>
                                                        <td>{{ $da->durableArticles_name }}</td>
                                                        <td class="td-center">
                                                            {{ number_format($da->durableArticles_number) }}</td>
                                                        <td class="td-center">{{ number_format($da->remaining_amount) }}
                                                        </td>
                                                        <td class="td-center">{{ number_format($da->damaged_number) }}
                                                        </td>
                                                        <td class="td-center">
                                                            {{ number_format($da->bet_on_distribution_number) }}</td>
                                                        <td class="td-center">{{ number_format($da->repair_number) }}
                                                        </td>
                                                        <td class="td-center">
                                                            {{ number_format($da->depreciation_price) }}</td>
                                                        <td class="td-center">{{ $da->name_durableArticles_count }}
                                                        </td>
                                                        <td>{{ $da->building_name }} &nbsp;{{ $da->floor }} &nbsp;
                                                            {{ $da->room_name }}</td>
                                                    </tr>
                                                @endforeach
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
