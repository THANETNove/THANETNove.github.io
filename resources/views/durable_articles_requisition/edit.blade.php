@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เเก้ไข{{ $data[0]->name_type }}ครุภัณฑ์ </h1>
                        <form method="POST" action="{{ route('durable-articles-requisition-update', $data[0]->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <p style="color: red" id="out-stock"></p>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">หมวดหมู่ครุภัณฑ์ </label>
                                    <input type="text" class="form-control" id="code_durable_articles"
                                        name="code_durable_articles" value="{{ $data[0]->category_name }}" required
                                        readonly />

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">ชื่อครุภัณฑ์ </label>
                                    <input type="text" class="form-control" value="{{ $data[0]->type_name }}" required
                                        readonly />

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รายละเอียดครุภัณฑ์ </label>
                                    <input type="text" class="form-control" value="{{ $data[0]->durableArticles_name }}"
                                        required readonly />

                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รหัสครุภัณฑ์ </label>
                                    <input type="text" class="form-control" id="code_durable_articles"
                                        name="code_durable_articles" placeholder="รหัสครุภัณฑ์"
                                        value="{{ $data[0]->category_code }}-{{ $data[0]->type_code }}-{{ $data[0]->description }}"
                                        required readonly />

                                </div>

                                <div class="mb-3 col-md-6" {{-- style="display:none" --}}>
                                    <label for="prefix" class="form-label">ชื่อ</label>
                                    <input type="text" class="form-control" id="durable_articles-name"
                                        name="durable_articles_name" placeholder="ชื่อ"
                                        value={{ $data[0]->durableArticles_name }} required readonly />
                                    <div id="popup-durable" style="display: none;" class="mt-2">
                                        <!-- Content of the popup goes here -->
                                    </div>
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">ครุภัณฑ์ที่เหลือ</label>
                                    <input type="text"
                                        class="form-control  @error('remaining_amount') is-invalid @enderror"
                                        id="remaining-amount" name="remaining_amount" value={{ $countData }}
                                        placeholder="ครุภัณฑ์ที่เหลือ" required readonly />
                                    @error('remaining_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">จำนวนที่ต้องการ{{ $data[0]->name_type }}
                                    </label>
                                    <input type="number"
                                        class="form-control @error('amount_withdraw') is-invalid @enderror"
                                        id="amount_withdraw" name="amount_withdraw" placeholder="จำนวนที่ต้องการ"
                                        value="{{ $data[0]->groupWithdrawCount }}" min="1"
                                        max="{{ $data[0]->groupWithdrawCount + $countData }}" required />
                                    @error('amount_withdraw')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6" style="display: none">
                                    <label for="prefix" class="form-label">จำนวนเบิกก่อนหน้า
                                    </label>
                                    <input type="number"
                                        class="form-control @error('amount_withdraw') is-invalid @enderror"
                                        id="amount_withdraw" name="previous_amount_withdraw" placeholder="จำนวนที่ต้องการ"
                                        value="{{ $data[0]->groupWithdrawCount }}" required />
                                    @error('amount_withdraw')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name_durable_articles_count" class="form-label">ชื่อเรียกจำนวนนับครุภัณฑ์
                                    </label>
                                    <input type="text"
                                        class="form-control @error('name_durable_articles_count') is-invalid @enderror"
                                        id="name-durable_articles-count" name="name_durable_articles_count"
                                        value={{ $data[0]->name_durable_articles_count }}
                                        placeholder="ชื่อเรียกจำนวนนับครุภัณฑ์" required readonly />
                                    @error('name_durable_articles_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>



                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">บักทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
