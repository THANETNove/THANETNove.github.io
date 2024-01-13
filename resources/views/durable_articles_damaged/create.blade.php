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

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">หมวดหมู่ครุภัณฑ์</label>
                                    <select class="form-select" onchange="groupDurableArticlesDamaged(this.value)"
                                        id="id-group" name="group_id" aria-label="Default select example">
                                        <option selected disabled>เลือกหมวดหมู่</option>
                                        @foreach ($group as $gro)
                                            <option value="{{ $gro->id }}">{{ $gro->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6" {{-- style="display:none" --}}>
                                    <label for="prefix" class="form-label">ชื่อ</label>
                                    <select class="form-select" name="durable_articles_name"
                                        id="durable_articles_damaged_name" aria-label="Default select example">
                                        <option selected disabled>เลือกวัสดุ</option>

                                    </select>
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รหัสครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="code_durable_damaged_articles"
                                        name="code_durable_articles" placeholder="รหัสครุภัณฑ์" required />

                                </div>



                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">ครุภัณฑ์ทั้งหมด</label>
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
                                    <input type="number" class="form-control @error('amount_damaged') is-invalid @enderror"
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
                                    <textarea class="form-control" name="damaged_detail" placeholder="รายละเอียดการชำรุด" id="exampleFormControlTextarea1"
                                        rows="3"></textarea>
                                    {{--  <input type="text" class="form-control" id="damaged_detail"
                                        name="damaged_detail" placeholder="รายละเอียดการชำรุด" required /> --}}
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
