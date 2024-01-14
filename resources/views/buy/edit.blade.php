@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เเก้ไขระบบลงทะเบียนรับเข้า</h1>
                        <form method="POST" action="{{ route('buy-update', $buy[0]->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label for="description" class="form-label">ประเภทการซื้อ</label>
                                    <select class="form-select  @error('typeBuy') is-invalid @enderror" name="typeBuy"
                                        aria-label="Default select example" required>
                                        @if ($buy[0]->typeBuy == '1')
                                            <option value="{{ $buy[0]->typeBuy }}">วัสดุ</option>
                                        @else
                                            <option value="{{ $buy[0]->typeBuy }}">ครุภัณฑ์</option>
                                        @endif
                                    </select>
                                    @error('typeBuy')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="id_name" class="form-label">id </label>
                                    <input id="id_name" type="text"
                                        class="form-control @error('id_name') is-invalid @enderror" name="id_name"
                                        value="{{ $buy[0]->code_buy }}" required placeholder="ชื่อวัสดุ"
                                        autocomplete="id_name">

                                    @error('id_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="buy_name" class="form-label">ชื่อวัสดุ</label>
                                    <input id="buy_name" type="text"
                                        class="form-control @error('buy_name') is-invalid @enderror" name="buy_name"
                                        value="@if ($buy[0]->typeBuy == 1) {{ $buy[0]->material_name }} @else {{ $buy[0]->durableArticles_name }} @endif"
                                        required placeholder="ชื่อวัสดุ" autocomplete="buy_name">

                                    @error('buy_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="quantity" class="form-label">จำนวน</label>
                                    <input id="quantity" type="number" value="{{ $buy[0]->quantity }}"
                                        class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                        placeholder="จำนวน" autocomplete="quantity">

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
                                        name="counting_unit" placeholder="หน่วยนับ" value="{{ $buy[0]->counting_unit }}"
                                        required autocomplete="counting_unit">

                                    @error('counting_unit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="price_per_piece" class="form-label">ราคาต่อ (ชิ้น,หน่วย,อื่นๆ)</label>
                                    <input id="price_per_piece" type="number" value="{{ $buy[0]->price_per_piece }}"
                                        class="form-control @error('price_per_piece') is-invalid @enderror"
                                        name="price_per_piece" placeholder="ราคาต่อ (ชิ้น,อื่นๆ)" required
                                        autocomplete="price_per_piece">

                                    @error('price_per_piece')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="total_price" class="form-label">ราคารวม</label>
                                    <input id="total_price" type="number" value="{{ $buy[0]->total_price }}"
                                        class="form-control @error('total_price') is-invalid @enderror" name="total_price"
                                        required placeholder="ชื่อเรียกจำนวนนับวัสดุ" autocomplete="total_price">

                                    @error('total_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="total_price" class="form-label">วันรับเข้า</label>

                                    <input class="date form-control" type="text" value="{{ $buy[0]->date_enter }}"
                                        name="date_enter" placeholder="dd-mm-yyyy">

                                    @error('total_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="total_price" class="form-label">รายละเอียด</label>
                                    <textarea class="form-control" name="details" id="exampleFormControlTextarea1" rows="3"> {{ $buy[0]->details }}</textarea>

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
