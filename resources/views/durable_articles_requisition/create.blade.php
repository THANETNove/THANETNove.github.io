@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เบิกครุภัณฑ์</h1>
                        <form method="POST" action="{{ route('durable-articles-requisition-store') }}">
                            @csrf
                            <div class="row">
                                <p style="color: red" id="out-stock"></p>

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">หมวดหมู่</label>

                                    <select class="form-select" onchange="groupDurableArticles(this.value)" id="id-group"
                                        name="group_id" aria-label="Default select example">
                                        <option selected disabled>เลือกหมวดหมู่</option>
                                        @foreach ($group as $gro)
                                            <option value="{{ $gro->id }}">{{ $gro->category_name }}</option>
                                        @endforeach


                                    </select>

                                </div>

                                <div class="mb-3 col-md-6" {{-- style="display:none" --}}>
                                    <label for="prefix" class="form-label">ชื่อ</label>
                                    <select class="form-select" name="durable_articles_name" id="durable_articles_name"
                                        aria-label="Default select example">
                                        <option selected disabled>เลือกครุภัณฑ์</option>

                                    </select>
                                </div>

                                <div class="mb-3 col-md-6" {{-- style="display:none" --}}>
                                    <label for="prefix" class="form-label">รายละเอียดรุภัณฑ์</label>
                                    <select class="form-select" name="details_name" id="details-name"
                                        aria-label="Default select example">
                                        <option selected disabled>รายละเอียดรุภัณฑ์</option>

                                    </select>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รหัสครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="code_durable_articles"
                                        name="code_durable_articles" placeholder="รหัสครุภัณฑ์" required />

                                </div>
                                <div class="mb-3 col-md-6" style="display: none">
                                    <label for="prefix" class="form-label">durable_articles_id</label>
                                    <input type="text" class="form-control" id="durable_articles_id"
                                        name="durable_articles_id" placeholder="รหัสครุภัณฑ์" required />
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
                                    <label for="prefix" class="form-label">จำนวนที่ต้องการเบิก</label>
                                    <input type="number"
                                        class="form-control @error('amount_withdraw') is-invalid @enderror"
                                        id="amount_withdraw" name="amount_withdraw" placeholder="จำนวนที่ต้องการเบิก"
                                        min="1" required />
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
                                        placeholder="ชื่อเรียกจำนวนนับครุภัณฑ์" required readonly />
                                    @error('name_durable_articles_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
