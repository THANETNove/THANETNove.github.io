@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เเก้ไขลงทะเบียนซ่อมครุภัณฑ์</h1>
                        <form method="POST" action="{{ route('bet-distribution-update', $data[0]->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <p style="color: red" id="out-stock"></p>

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">หมวดหมู่ครุภัณฑ์</label>
                                    {{--   <select class="form-select" onchange="groupDurableArticlesRepair(this.value)"
                                        id="id-group" name="group_id" aria-label="Default select example">
                                        <option selected disabled>เลือกหมวดหมู่</option>
                                        @foreach ($group as $gro)
                                            <option value="{{ $gro->id }}">{{ $gro->category_name }}</option>
                                        @endforeach
                                    </select> --}}
                                    <input type="text" class="form-control" id="code_durable_articles" name="group_id"
                                        value="{{ $data[0]->category_name }}" placeholder="code_durable_articles" required
                                        readonly />
                                </div>

                                <div class="mb-3 col-md-6" {{-- style="display:none" --}}>
                                    <label for="prefix" class="form-label">ชื่อ</label>
                                    {{-- <select class="form-select" name="durable_articles_name"
                                        id="durable_articles_repair_name" aria-label="Default select example">
                                        <option selected disabled>เลือกวัสดุ</option>
                                    </select> --}}
                                    <input type="text" class="form-control" id="durable_articles_repair_name"
                                        name="durable_articles_repair_name" value="{{ $data[0]->durableArticles_name }}"
                                        placeholder="code_durable_articles" required readonly />
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รหัสครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="code_durable_articles"
                                        name="code_durable_articles" value="{{ $data[0]->code_durable_articles }}"
                                        placeholder="รหัสครุภัณฑ์" required readonly />

                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">จำนวนที่ซ่อม</label>
                                    <input type="number"
                                        class="form-control @error('amount_bet_distribution') is-invalid @enderror"
                                        id="amount_withdraw" name="amount_bet_distribution"
                                        value="{{ $data[0]->amount_bet_distribution }}" placeholder="จำนวนที่ชำรุด"
                                        min="1" required readonly />
                                    @error('amount_bet_distribution')
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
                                        placeholder="ชื่อเรียกจำนวนนับครุภัณฑ์"
                                        value="{{ $data[0]->name_durable_articles_count }}" required readonly />
                                    @error('name_durable_articles_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="salvage_price" class="form-label">ราคาซาก
                                    </label>
                                    <input type="number" class="form-control @error('salvage_price') is-invalid @enderror"
                                        id="salvage_price" name="salvage_price" value="{{ $data[0]->salvage_price }}"
                                        placeholder="ราคาซาก" min="1" required />
                                    @error('salvage_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รายละเอียดการซ่อม</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="repair_detail" rows="3">{{ $data[0]->repair_detail }}</textarea>
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
