@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">ลงทะเบียนครุภัณฑ์ชำรุด</h1>
                        <form method="POST" action="{{ route('durable-articles-damaged-store') }}">
                            @csrf
                            <div class="row">
                                <p style="color: red" id="out-stock"></p>

                                <div class="mb-3 col-md-6" style="display: none">
                                    <label for="prefix" class="form-label">id ครุภัณฑ์ชำรุด</label>
                                    <input type="text" class="form-control" id="durable_id" name="durable_articles_id"
                                        placeholder="id ครุภัณฑ์ชำรุด" required />
                                </div>
                                <p style="color:red; font-size: 18px;" id="damaged_number_error"></p>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รหัสครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="durable_articles_code"
                                        name="durable_articles_code" oninput="durableArticlesCode()"
                                        placeholder="รหัสครุภัณฑ์" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">หมวดหมู่ครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="durable_group" name="durable_group"
                                        placeholder="ชื่อครุภัณฑ์ชำรุด" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">ชื่อครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="durable_name" name="durable_name"
                                        placeholder="ชื่อครุภัณฑ์ชำรุด" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รายละเอียดครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="durable_description"
                                        name="durable_articles_name" placeholder="ชื่อครุภัณฑ์ชำรุด" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รายละเอียดครุภัณฑ์ชำรุด</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="details_damaged" rows="3"></textarea>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">สถานะการชำรุด</label>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="radio" value="0" name="status_damaged"
                                            id="flexRadioDefault1" checked>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            ซ่อมได้
                                        </label>
                                    </div>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="radio" value="1" name="status_damaged"
                                            id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            ซ่อมไม่ได้
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-2">
                                <button type="submit" id="submit" class="btn btn-primary me-2">บักทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
