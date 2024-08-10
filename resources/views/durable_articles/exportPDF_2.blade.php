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
        /* Optional: Add some basic styling */
        .td-center {
            text-align: center;
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
                                    <table class="table" id="durableArticlesTable">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัส</th>
                                                <th>ประเภทครุภัณฑ์</th>
                                                <th>ชื่อ</th>
                                                <th>หน่วย</th>
                                                <th>ราคา</th>
                                                <th>ค่าเสื่อม /ปี</th> <!-- Added Depreciation Column -->
                                                <th>ค่าเสื่อม /วัน</th>
                                                <th>อายุการใช้งาน</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-border-bottom-0">
                                            @php
                                                $i = 1; // Initialize $i before the loops start
                                            @endphp
                                            @foreach ($data->groupBy('group_class') as $groupedData)
                                                @foreach ($groupedData->sortBy(['type_durableArticles', 'description', 'durableArticles_number']) as $da)
                                                    <tr>
                                                        <th scope="row">{{ $i++ }}</th>
                                                        <td>{{ $da->category_code }}-{{ $da->type_code }}-{{ $da->description }}-{{ $da->group_count }}
                                                        </td>
                                                        <td>{{ $da->category_name }}</td>
                                                        <td>{{ $da->durableArticles_name }}</td>
                                                        <td class="td-center">{{ $da->name_durableArticles_count }}
                                                        </td>
                                                        <td>{{ number_format($da->price_per) }}</td>
                                                        @php
                                                            $perYear = $da->price_per / $da->service_life; // ค่าเสื่อต่อปี
                                                            $currentYear = \Carbon\Carbon::now()->year;
                                                            $createdYear = \Carbon\Carbon::parse($da->created_at)->year;
                                                            $yearsPassed =
                                                                \Carbon\Carbon::parse($da->created_at)->diffInYears(
                                                                    \Carbon\Carbon::now(),
                                                                ) + 1; // อายุการใช้งานปี
                                                            $calPriceY = $da->price_per - $perYear * $yearsPassed;

                                                            $daysPassed = \Carbon\Carbon::parse(
                                                                $da->created_at,
                                                            )->diffInDays(\Carbon\Carbon::now()); // อายุการใช้งานวัน

                                                            $perDays = $perYear / 365; // ค่าเสื่อต่อวัน
                                                            $calPerDays = $perDays * $daysPassed;
                                                            $calPriceD = $da->price_per - $calPerDays;

                                                        @endphp
                                                        <td>
                                                            {{--   @if ($calPriceY < 1)
                                                                1
                                                            @else
                                                                {{ number_format($calPriceY, 2) }}
                                                            @endif --}}
                                                            @for ($year = 1; $year <= $da->service_life; $year++)
                                                                @php
                                                                    $calPriceY2 = $da->price_per - $perYear * $year; // คำนวณราคาหลังจากแต่ละปี
                                                                    $loopYear = $createdYear + $year - 1; // คำนวณปีที่อยู่ในลูป

                                                                @endphp
                                                                <div
                                                                    style="{{ $loopYear == $currentYear
                                                                        ? '    padding-left: 8px;background-color: #09ab3a;padding-right: 8px;color: #FFFF;'
                                                                        : '' }}">
                                                                    <span>ปีที่ {{ $year }}</span> &nbsp;
                                                                    <span>
                                                                        @if ($calPriceY2 < 1)
                                                                            1 <!-- กรณีที่ราคาต่ำกว่า 1 -->
                                                                        @else
                                                                            {{ number_format($calPriceY2, 2) }}
                                                                            <!-- แสดงราคาหลังจากหักค่าเสื่อม -->
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            @endfor
                                                        </td>
                                                        <td>
                                                            {{ number_format($calPriceD, 2) }}
                                                        </td>
                                                        <td>
                                                            @if ($da->service_life)
                                                                {{ number_format($da->service_life) }} &nbsp;ปี
                                                            @endif
                                                        </td>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const serviceLife = 5; // The service life in years

            document.querySelectorAll("#durableArticlesTable tbody tr").forEach(row => {
                const pricePer = parseFloat(row.getAttribute(
                    'data-price-per')); // Assuming the price is set as data attribute
                const salvagePrice = parseFloat(row.getAttribute(
                    'data-salvage-price')); // Assuming the salvage price is set as data attribute

                let price, priceDepreciation;

                if (salvagePrice === 0) {
                    price = (pricePer * 20) / 100 / serviceLife;
                } else {
                    price = (pricePer - salvagePrice) / serviceLife;
                }

                priceDepreciation = pricePer - price;

                const depreciationCell = row.querySelector('.depreciation');
                depreciationCell.textContent = priceDepreciation.toLocaleString();
            });
        });
    </script>
</body>

</html>
