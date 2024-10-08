@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary mb-5 ">รายละเอียดระบบลงทะเบียนครุภัณฑ์</h1>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">รหัส </label>
                                <input type="text" class="form-control"
                                    value="{{ $data[0]->category_code }}-{{ $data[0]->type_code }}-{{ $data[0]->description }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ประเภทครุภัณฑ์ </label>
                                <input type="text" class="form-control" value="{{ $data[0]->category_name }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ชื่อ </label>
                                <input type="text" class="form-control" value="{{ $data[0]->type_name }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">รายละเอียด </label>
                                <input type="text" class="form-control" value="{{ $data[0]->durableArticles_name }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">หน่วย </label>
                                <input type="text" class="form-control"
                                    value="{{ $data[0]->name_durableArticles_count }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">ที่จัดเก็บ </label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $data[0]->building_name }} &nbsp;{{ $data[0]->floor }} &nbsp;{{ $data[0]->room_name }}</textarea>

                            </div>
                            {{--  <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">อายุการใช้งาน </label>
                                <input type="text" class="form-control" value="{{ $data[0]->service_life }} ปี">

                            </div> --}}
                            <div class="mb-3 col-md-6">
                                <label for="material_name" class="form-label">วันที่สร้าง </label>

                                <input type="text" class="form-control"
                                    value="{{ date('d-m-Y', strtotime($data[0]->created_at)) }}">
                            </div>
                            <div class="table-responsive text-nowrap mt-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รหัส</th>
                                            <th>จำนวน</th>
                                            <th>จำนวนที่เบิกได้</th>
                                            <th>ชำรุด</th>
                                            <th>แทงจำหน่าย</th>
                                            <th>ซ่อม</th>
                                            <th>ค่าเสื่อม /ปี</th>
                                            <th>ค่าเสื่อม /วัน</th>
                                            <th>อายุการใช้งาน</th>
                                            <th>ระยะประกัน</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $i = 1;
                                    @endphp
                                    <tbody class="table-border-bottom-0">
                                        @foreach ($data as $da)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $da->category_code }}-{{ $da->type_code }}-{{ $da->description }}-{{ $da->group_count }}
                                                </td>
                                                <td>
                                                    @if ($da->durableArticles_number == 1)
                                                        <i class='bx bxs-check-circle' style="color: green;"></i>
                                                    @elseif($da->durableArticles_number == 0)
                                                        <i class='bx bx-x-circle' style="color: red;"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($da->remaining_amount == 1)
                                                        <i class='bx bxs-check-circle' style="color: green;"></i>
                                                    @elseif($da->remaining_amount == 0)
                                                        <i class='bx bx-x-circle' style="color: red;"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($da->damaged_number == 1)
                                                        <i class='bx bxs-check-circle' style="color: green;"></i>
                                                    @elseif($da->damaged_number == 0)
                                                        <i class='bx bx-x-circle' style="color: red;"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($da->bet_on_distribution_number == 1)
                                                        <i class='bx bxs-check-circle' style="color: green;"></i>
                                                    @elseif($da->bet_on_distribution_number == 0)
                                                        <i class='bx bx-x-circle' style="color: red;"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($da->repair_number == 1)
                                                        <i class='bx bxs-check-circle' style="color: green;"></i>
                                                    @elseif($da->repair_number == 0)
                                                        <i class='bx bx-x-circle' style="color: red;"></i>
                                                    @else
                                                        {{ number_format($da->repair_number) }}
                                                    @endif
                                                </td>
                                                @php
                                                    $perYear = $da->price_per / $da->service_life; // ค่าเสื่อต่อปี
                                                    $currentYear = \Carbon\Carbon::now()->year;
                                                    $createdYear = \Carbon\Carbon::parse($da->created_at)->year;
                                                    $yearsPassed =
                                                        \Carbon\Carbon::parse($da->created_at)->diffInYears(
                                                            \Carbon\Carbon::now(),
                                                        ) + 1; // อายุการใช้งานปี
                                                    $calPriceY = $da->price_per - $perYear * $yearsPassed;

                                                    $daysPassed = \Carbon\Carbon::parse($da->created_at)->diffInDays(
                                                        \Carbon\Carbon::now(),
                                                    ); // อายุการใช้งานวัน

                                                    $perDays = $perYear / 365; // ค่าเสื่อต่อวัน
                                                    $calPerDays = $perDays * $daysPassed;
                                                    $calPriceD = $da->price_per - $calPerDays;

                                                @endphp
                                                <td>
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
                                                {{--  <td>
                                                    @if ($calPriceY < 1)
                                                        1
                                                    @else
                                                        {{ number_format($calPriceY, 2) }}
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    {{ number_format($calPriceD, 2) }}
                                                </td>
                                                <td>
                                                    @if ($da->service_life)
                                                        {{ number_format($da->service_life) }} &nbsp;ปี
                                                    @endif
                                                </td>

                                                <td>
                                                    @php
                                                        $originalDate = $da->warranty_period_start;
                                                        $originalDate2 = $da->warranty_period_end;

                                                        // สร้าง DateTime objects
                                                        if ($originalDate2) {
                                                            // ตรวจสอบค่าของปี ค.ศ.
                                                            /*   echo 'ปี ค.ศ. ที่แปลงได้: ' . $gregorianYear . "\n"; */

                                                            $targetDate = new DateTime($originalDate2); // วันที่เป้าหมายในปี ค.ศ.

                                                            // วันที่ปัจจุบัน
                                                            $now = new DateTime(); // วันที่ปัจจุบันในปี ค.ศ.

                                                            if ($now > $targetDate) {
                                                                $daysRemaining = 0; // หากวันที่ปัจจุบันผ่านวันที่สิ้นสุดการรับประกันแล้ว
                                                            } else {
                                                                $daysRemaining = $now->diff($targetDate)->format('%a'); // คำนวณจำนวนวันที่เหลือ
                                                            }
                                                        }

                                                        // Debug output

                                                    @endphp
                                                    <div>

                                                        @if ($originalDate2)
                                                            @if ($now == $targetDate)
                                                                <span
                                                                    class="badge bg-label-primary me-1">วันสุดท้ายของประกัน</span>
                                                            @else
                                                                @if ($daysRemaining > 0)
                                                                    <span class="badge bg-label-primary me-1">เหลือเวลา
                                                                        {{ $daysRemaining }} วัน</span>
                                                                    {{--  @else
                                                                <span
                                                                    class="badge bg-label-warning me-1">หมดประกัน</span> --}}
                                                                @endif
                                                            @endif
                                                        @endif

                                                    </div>
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
    @endsection
