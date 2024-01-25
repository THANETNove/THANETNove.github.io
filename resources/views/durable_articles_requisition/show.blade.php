@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">รายละเอียดการเบิกครุภัณฑ์ </h1>

                        <div class="row">
                            <p style="color: red" id="out-stock"></p>
                            <div class="mb-3 col-md-6">

                                <label for="prefix" class="form-label">หมวดหมู่ครุภัณฑ์ </label>
                                <input type="text" class="form-control" id="code_durable_articles"
                                    name="code_durable_articles" placeholder="รหัสครุภัณฑ์"
                                    value="{{ $data[0]->category_name }}" required />
                            </div>
                            <div class="mb-3 col-md-6">

                                <label for="prefix" class="form-label">รหัสครุภัณฑ์ </label>
                                <input type="text" class="form-control" id="code_durable_articles"
                                    name="code_durable_articles" placeholder="รหัสครุภัณฑ์"
                                    value="{{ $data[0]->code_durable_articles }}" required />
                            </div>

                            <div class="mb-3 col-md-6" {{-- style="display:none" --}}>
                                <label for="prefix" class="form-label">ชื่อ</label>
                                <input type="text" class="form-control" id="durable_articles-name"
                                    name="durable_articles_name" placeholder="ชื่อ"
                                    value={{ $data[0]->durableArticles_name }} required />
                                <div id="popup-durable" style="display: none;" class="mt-2">
                                    <!-- Content of the popup goes here -->
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="prefix" class="form-label">จำนวนที่ต้องการเบิก</label>
                                <input type="number" class="form-control @error('amount_withdraw') is-invalid @enderror"
                                    id="amount_withdraw" name="amount_withdraw" placeholder="จำนวนที่ต้องการเบิก"
                                    value="{{ $data[0]->amount_withdraw }}" required />

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name_durable_articles_count" class="form-label">ชื่อเรียกจำนวนนับครุภัณฑ์
                                </label>
                                <input type="text"
                                    class="form-control @error('name_durable_articles_count') is-invalid @enderror"
                                    id="name-durable_articles-count" name="name_durable_articles_count"
                                    value={{ $data[0]->name_durable_articles_count }}
                                    placeholder="ชื่อเรียกจำนวนนับครุภัณฑ์" required />

                            </div>

                            @if (Auth::user()->status > 0)
                                <div class="mb-3 col-md-6">
                                    <label for="name_durable_articles_count" class="form-label">ชื่อ นามสกุล ผู้เบิก
                                    </label>
                                    @php
                                        $name = $data[0]->prefix . ' ' . $data[0]->first_name . ' ' . $data[0]->last_name;
                                    @endphp
                                    <input type="text"
                                        class="form-control @error('name_durable_articles_count') is-invalid @enderror"
                                        id="name-durable_articles-count" name="name_durable_articles_count"
                                        value="{{ $name }}" placeholder="ชื่อเรียกจำนวนนับครุภัณฑ์" required />

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name_durable_articles_count" class="form-label">เเผนก
                                    </label>

                                    <input type="text"
                                        class="form-control @error('name_durable_articles_count') is-invalid @enderror"
                                        id="name-durable_articles-count" name="name_durable_articles_count"
                                        value="{{ $data[0]->department_name }}" required />

                                </div>
                            @endif
                            <div class="mb-3 col-md-6">
                                <label for="name_durable_articles_count" class="form-label">ที่เก็บ
                                </label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $data[0]->building_name }} &nbsp;{{ $data[0]->floor }} &nbsp;{{ $data[0]->room_name }}</textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name_durable_articles_count" class="form-label">ระยะประกัน

                                </label>
                                @php
                                    $originalDate = $data[0]->warranty_period;
                                    $newDate = (new DateTime($originalDate))->format('d/m/Y');
                                    $newDate2 = new DateTime($originalDate);
                                    $targetDate = $newDate2;
                                    $now = new DateTime();

                                    $daysRemaining = $now > $targetDate ? 0 : $now->diff($targetDate)->format('%a') + 1;
                                @endphp
                                <div>
                                    {{ $newDate }}
                                    @if ($now->format('Y-m-d') == $targetDate->format('Y-m-d'))
                                        <span class="badge bg-label-primary me-1">วันสุดท้ายของประกัน</span>
                                    @else
                                        @if ($daysRemaining > 0)
                                            <span class="badge bg-label-primary me-1">เหลือเวลา
                                                {{ $daysRemaining }} วัน</span>
                                        @else
                                            <span class="badge bg-label-warning me-1">หมดประกัน</span>
                                        @endif
                                    @endif
                                </div>

                            </div>
                            @if ($data[0]->status == 'on')
                                <div class="mb-3 col-md-6">
                                    <label for="name_durable_articles_count" class="form-label">การอนุมัติ
                                    </label>
                                    <div>
                                        @if ($data[0]->statusApproval == '0')
                                            <span class="badge bg-label-info me-1">รอการอนุมัติ</span>
                                        @elseif ($data[0]->statusApproval == '1')
                                            <span class="badge bg-label-success me-1">อนุมัติ</span>
                                        @else
                                            <span class="badge bg-label-warning me-1">ไม่อนุมัติ</span>
                                        @endif

                                    </div>
                                </div>
                            @endif
                            <div class="mb-3 col-md-6">
                                <label for="name_durable_articles_count" class="form-label">สถานะ
                                </label>
                                <div>
                                    @if ($data[0]->status == 'on')
                                        <span class="badge bg-label-success me-1">เบิกครุภัณฑ์</span>
                                    @else
                                        <span class="badge bg-label-warning me-1">ยกเลิกเบิกครุภัณฑ์</span>
                                    @endif
                                </div>
                            </div>
                            @if ($data[0]->statusApproval == '2')
                                <div class="mb-3 col-md-6">
                                    <label for="name_durable_articles_count" class="form-label">หมายเหตุ
                                    </label>
                                    <textarea id="basic-icon-default-message" name="commentApproval" class="form-control" placeholder="หมายเหตุ "
                                        aria-label="หมายเหตุ" aria-describedby="basic-icon-default-message2" style="height: 78px;"> {{ $data[0]->commentApproval }}</textarea>
                                </div>
                            @endif
                            <div class="mb-3 col-md-6">
                                <label for="name_durable_articles_count" class="form-label">วันที่เบิก
                                </label>
                                @php
                                    $dateOriginal = $data[0]->created_at;
                                    $newFormatDate = (new DateTime($originalDate))->format('d/m/Y');

                                @endphp
                                <div>

                                    <span class="badge bg-label-primary me-1">
                                        {{ $newFormatDate }} </span>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--   ชื่อ นามสกุล ผู้เบิก	ระยะประกัน	การอนุมัติ	สถานะ --}}
    </div>
@endsection
