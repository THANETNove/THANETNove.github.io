@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">แจ้งอุปกรณ์ชำรุด</h1>
                        <form method="POST" action="{{ route('durable-articles-damaged-store') }}">
                            @csrf
                            <div class="row">
                                <p style="color: red" id="out-stock"></p>
                                <div class="mb-3 col-md-6" style="display: none;">
                                    <label for="prefix" class="form-label">id ครุภัณฑ์</label>
                                    <input type="text" class="form-control durable_articles_id" id="durable_articles_id"
                                        name="durable_articles_id" placeholder="รหัสครุภัณฑ์" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รหัสครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="code_durable_articles"
                                        name="code_durable_articles" placeholder="รหัสครุภัณฑ์" required />
                                    <div id="popup-code" style="display: none;" class="mt-2">
                                        <!-- Content of the popup goes here -->
                                    </div>
                                    <button type="button" id="btn-danger-durable" class="btn btn-danger mt-3"
                                        style="display: none;"></button>
                                </div>

                                <div class="mb-3 col-md-6" {{-- style="display:none" --}}>
                                    <label for="prefix" class="form-label">ชื่อ</label>
                                    <input type="text" class="form-control durable_articles-name" id="durable_articles-name"
                                        name="durable_articles_name" placeholder="ชื่อ" required />
                                    <div id="popup-durable" style="display: none;" class="mt-2">
                                        <!-- Content of the popup goes here -->
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">ครุภัณฑ์ที่เหลือ</label>
                                    <input type="text"
                                        class="form-control  @error('remaining_amount') is-invalid @enderror"
                                        id="remaining-amount" name="remaining_amount" placeholder="ครุภัณฑ์ที่เหลือ"
                                        required readonly />
                                    @error('remaining_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">จำนวนที่ชำรุด</label>
                                    <input type="number"
                                        class="form-control @error('amount_damaged') is-invalid @enderror"
                                        id="amount_withdraw" name="amount_damaged" placeholder="จำนวนที่ชำรุด"
                                        min="1" required />
                                    @error('amount_damaged')
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
                                        placeholder="ชื่อเรียกจำนวนนับครุภัณฑ์" required readonly />
                                    @error('name_durable_articles_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รายละเอียดการชำรุด</label>
                                    <input type="text" class="form-control" id="damaged_detail"
                                        name="damaged_detail" placeholder="รายละเอียดการชำรุด" required />
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
