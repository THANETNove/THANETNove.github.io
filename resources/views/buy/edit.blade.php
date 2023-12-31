@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">ระบบลงทะเบียนการจัดซื้อ</h1>
                        <form method="POST" action="{{ route('buy-store') }}">
                            @csrf
                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label for="description" class="form-label">ประเภทการซื้อ</label>
                                    <select class="form-select  @error('type') is-invalid @enderror" name="type"
                                        aria-label="Default select example" required>
                                        <option selected disabled>ประเภทการซื้อ</option>
                                        @if ($buy['type'] == 'ครุภัณฑ์')
                                            <option value="ครุภัณฑ์" selected>ครุภัณฑ์</option>
                                            <option value="วัสดุ">วัสดุ</option>
                                        @else
                                            <option value="ครุภัณฑ์">ครุภัณฑ์</option>
                                            <option value="วัสดุ" selected>วัสดุ</option>
                                        @endif

                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="buy_name" class="form-label">ชื่อวัสดุ</label>
                                    <input id="buy_name" type="text"
                                        class="form-control @error('buy_name') is-invalid @enderror" name="buy_name"
                                        value="{{ $buy['buy_name'] }}" required placeholder="ชื่อวัสดุ"
                                        autocomplete="buy_name">

                                    @error('buy_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="quantity" class="form-label">จำนวน</label>
                                    <input id="quantity" type="number" value="{{ $buy['quantity'] }}"
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
                                        name="counting_unit" placeholder="หน่วยนับ" value="{{ $buy['counting_unit'] }}"
                                        required autocomplete="counting_unit">

                                    @error('counting_unit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="price_per_piece" class="form-label">ราคาต่อ (ชิ้น,หน่วย,อื่นๆ)</label>
                                    <input id="price_per_piece" type="number" value="{{ $buy['price_per_piece'] }}"
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
                                    <input id="total_price" type="number" value="{{ $buy['total_price'] }}"
                                        class="form-control @error('total_price') is-invalid @enderror" name="total_price"
                                        required placeholder="ชื่อเรียกจำนวนนับวัสดุ" autocomplete="total_price">

                                    @error('total_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="total_price" class="form-label">รายละเอียด</label>
                                    <textarea class="form-control" name="details" id="exampleFormControlTextarea1" rows="3"> {{ $buy['details'] }}</textarea>

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
