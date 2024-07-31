@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">ลงทะเบียนเเทงจำหน่ายครุภัณฑ์</h1>
                        <form method="POST" action="{{ route('bet-distribution-store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <p style="color: red" id="out-stock"></p>

                                <div class="col-md-6" style="display: none;">
                                    <label for="prefix" class="form-label"> ครุภัณฑ์จำหน่าย</label>
                                    <input type="text" class="form-control" name="durable_articles_id"
                                        id="durable_articles_id">
                                </div>
                                <div class="col-md-6" style="display: none;">
                                    <label for="prefix" class="form-label">ชื่อครุภัณฑ์จำหน่าย</label>
                                    <input type="text" class="form-control" name="durable_articles_name"
                                        id="durable_articles_name">
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">หมวดหมู่ครุภัณฑ์</label>
                                    <select class="form-select" onchange="groupDurableArticlesRepair(this.value)"
                                        id="id-group" name="group_id" aria-label="Default select example">
                                        <option selected disabled>เลือกหมวดหมู่</option>
                                        @foreach ($group as $gro)
                                            <option value="{{ $gro->id }}">{{ $gro->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-md-6" {{-- style="display:none" --}}>
                                    <label for="prefix" class="form-label">ชื่อครุภัณฑ์</label>
                                    <select class="form-select" id="durable_articles_repair_name2"
                                        aria-label="Default select example">
                                        <option selected disabled>เลือกครุภัณฑ์</option>

                                    </select>
                                </div>

                                <div class="mb-3 col-md-6" {{-- style="display:none" --}}>
                                    <label for="prefix" class="form-label">รายละเอียดครุภัณฑ์</label>
                                    <select class="form-select" name="details_repair_name" id="details_repair_name"
                                        aria-label="Default select example">
                                        <option selected disabled>เลือกรายละเอียด</option>

                                    </select>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รหัสครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="code_durable_articles"
                                        name="code_durable_articles" placeholder="รหัสครุภัณฑ์" required readonly />

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">ราคาเเทงจำหน่าย</label>
                                    <input type="number" class="form-control" id="depreciation_price" name="salvage_price"
                                        placeholder="ราคาเเทงจำหน่าย" min="1" />

                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รายละเอียดเเทงจำหน่าย</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="repair_detail" rows="3"></textarea>
                                </div>
                                {{--  <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">เเทงจำหน่ายเเบบกลุ่ม</label>
                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" value="1" name="group_sales"
                                            id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                           เเทงจำหน่ายเเบบกลุ่ม
                                        </label>

                                    </div> --}}
                            </div>
                            <div class="mb-5 col-md-6">
                                <label for="pdf_file">Choose PDF file:</label>
                                <input type="file" class="form-control-file" id="pdf_file" name="pdf_file">
                                @error('pdf_file')
                                    <div style="color: red;font-size: 16px;margin-top: 8px;">{{ $message }}</div>
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
