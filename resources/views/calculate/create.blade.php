@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">ระบบการคำนวณค่าเสื่อมครุภัณฑ์</h1>
                        @if (session('message'))
                            <p class="message-text text-center mt-4 mb-4"> {{ session('message') }}</p>
                        @endif
                        <form method="POST" action="{{ route('calculator-store') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6" style="display:none">
                                    <label for="articles_id" class="form-label">id</label>
                                    <input id="articles_id" type="text" class="form-control" name="articles_id" required
                                        placeholder="id" autocomplete="articles_id" readonly>

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="categories_id" class="form-label">หมวดหมู่</label>
                                    <select class="form-select" onchange="calculateGroup(this.value)" name="group_id"
                                        id="group_id" aria-label="Default select example">
                                        <option selected>เลือกหมวดหมู่</option>
                                        @foreach ($group as $gro)
                                            <option value="{{ $gro->id }}">{{ $gro->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="buy_name" class="form-label">ชื่อครุภัณฑ์</label>
                                    {{--  <input id="buy_name" type="text"
                                        class="form-control @error('buy_name') is-invalid @enderror" name="buy_name"
                                        required placeholder="ชื่อวัสดุ" autocomplete="buy_name" readonly> --}}
                                    <select class="form-select" name="buy_name" id="calculate-id"
                                        aria-label="Default select example">
                                        <option selected>เลือกครุภัณฑ์</option>
                                    </select>
                                    @error('buy_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="categories_id" class="form-label" id="id-group">id</label>
                                    <input id="categories_id" type="text"
                                        class="form-control @error('categories_id') is-invalid @enderror"
                                        name="categories_id" required placeholder="id" autocomplete="categories_id"
                                        readonly>

                                    @error('categories_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="quantity" class="form-label">จำนวน</label>
                                    <input id="quantity" type="number"
                                        class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                        placeholder="จำนวน" autocomplete="quantity"readonly>

                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="counting_unit" class="form-label">หน่วยนับ</label>
                                    <input id="counting_unit" type="text"
                                        class="form-control @error('counting_unit') is-invalid @enderror"
                                        name="counting_unit" placeholder="หน่วยนับ" required autocomplete="counting_unit"
                                        readonly>

                                    @error('counting_unit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="price_per_piece" class="form-label">ราคา</label>
                                    <input id="price_per_piece" type="text"
                                        class="form-control @error('price_per_piece') is-invalid @enderror"
                                        name="price_per_piece" placeholder="ราคาต่อ (ชิ้น,อื่นๆ)" min="1" required
                                        autocomplete="price_per_piece" readonly>

                                    @error('price_per_piece')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="total_price" class="form-label">ราคาซาก</label>
                                    <input id="salvage_price" type="text"
                                        class="form-control @error('salvage_price') is-invalid @enderror"
                                        name="salvage_price" required placeholder="ราคาซาก" min="1"
                                        autocomplete="salvage_price" readonly>

                                    @error('total_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="period_use" class="form-label">ระยะการใช้</label>

                                    <input class="form-control" id="period_use" type="text" name="period_use"
                                        placeholder="ปี" readonly>


                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="service_life" class="form-label">อายุการใช้</label>

                                    <input class="form-control" id="service_life" type="text" name="service_life"
                                        placeholder="ปี" readonly>


                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="service_life" class="form-label">ค่าเสื่อม (%)</label>
                                    <input class="form-control" id="depreciation" type="text" value="20%"
                                        name="depreciation" placeholder="ค่าเสื่อม" readonly>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="service_life" class="form-label">ค่าเสื่อมครุภัณฑ์</label>
                                    <input class="form-control" id="calulate-depreciation" type="text"
                                        name="depreciation" placeholder="ค่าเสื่อม" readonly>
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
