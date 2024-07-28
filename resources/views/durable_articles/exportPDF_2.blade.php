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
                                                <th>ค่าเสื่อม</th> <!-- Added Depreciation Column -->
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
                                                        <td class="depreciation">
                                                            @php
                                                                $serviceLife = $da->service_life; // อายุการใช้งานในปี
                                                                $pricePer = $da->price_per; // ราคาต่อหน่วย
                                                                $salvagePrice = $da->salvage_price; // ราคาซาก (กรณีที่มี)

                                                                // Calculate the total depreciation over the service life
                                                                if ($salvagePrice === 0 || $salvagePrice === null) {
                                                                    // กรณีที่ไม่มีราคาซาก ใช้สูตรค่าเสื่อมที่ลดลง 20% ต่อปี
                                                                    $depreciationPerYear =
                                                                        ($pricePer - $salvagePrice) / $serviceLife;
                                                                } else {
                                                                    // กรณีที่มีราคาซาก ใช้สูตรค่าเสื่อมที่ลดลงจนถึงราคาซาก
                                                                    $depreciationPerYear =
                                                                        ($pricePer - $salvagePrice) / $serviceLife;
                                                                }

                                                                // Output the depreciation for each year
                                                                for ($j = 1; $j <= $serviceLife; $j++) {
                                                                    // Calculate depreciated price for the current year
                                                                    $depreciatedPrice =
                                                                        $pricePer - $depreciationPerYear * $j;

                                                                    // Ensure depreciated price does not go below 1
                                                                    $depreciatedPrice = max($depreciatedPrice, 1);

                                                                    // Output formatted HTML with colored rows
                                                                    echo '<div class="col">';
                                                                    echo '<span>ปี ' .
                                                                        $j .
                                                                        ': </span>' .
                                                                        '<span>' .
                                                                        number_format($depreciatedPrice) .
                                                                        '</span>';
                                                                    echo '</div>';
                                                                }
                                                            @endphp
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
