@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">ลงทะเบียนเเทงจำหน่ายครุภัณฑ์</h1>
                        <form method="POST" action="{{ route('bet-distribution-store') }}">
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
                                    <select class="form-select" id="durable_articles_repair_name"
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
                                    <label for="prefix" class="form-label">จำนวนที่จำหน่าย</label>
                                    <input type="number" class="form-control @error('amount_repair') is-invalid @enderror"
                                        id="amount_withdraw" name="amount_repair" placeholder="จำนวนที่ชำรุด" min="1"
                                        required readonly />
                                    @error('amount_repair')
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
                                    <label for="prefix" class="form-label">รายละเอียดการซ่อม</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="repair_detail" rows="3"></textarea>
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
