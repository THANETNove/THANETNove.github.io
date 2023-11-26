@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เบิกวัสดุอุปกรณ์</h1>
                        <form method="POST" action="{{ route('material-requisition-store') }}">
                            @csrf
                            <div class="row">
                                <p style="color: red" id="out-stock"></p>
                                <div class="mb-3 col-md-6">

                                    <label for="prefix" class="form-label">รหัสวัสดุ</label>
                                    <input type="text" class="form-control" id="code_requisition" name="code_requisition"
                                        placeholder="รหัสวัสดุ" required />
                                    <div id="popup" style="display: none;" class="mt-2">
                                        <!-- Content of the popup goes here -->
                                    </div>
                                    <button type="button" id="btn-danger" class="btn btn-danger mt-3"
                                        style="display: none;"></button>
                                </div>

                                <div class="mb-3 col-md-6" {{-- style="display:none" --}}>
                                    <label for="prefix" class="form-label">ชื่อ</label>
                                    <input type="text" class="form-control" id="material-name" name="material_name"
                                        placeholder="ชื่อ" required />
                                    <div id="popup-name" style="display: none;" class="mt-2">
                                        <!-- Content of the popup goes here -->
                                    </div>
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">วัสดุที่เหลือ</label>
                                    <input type="text"
                                        class="form-control  @error('remaining_amount') is-invalid @enderror"
                                        id="remaining-amount" name="remaining_amount" placeholder="วัสดุที่เหลือ" required
                                        readonly />
                                    @error('remaining_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6" style="display:none">
                                    <label for="" class="form-label">id</label>
                                    <input type="text" class="form-control" id="material-id" name="material_id"
                                        placeholder="id" required readonly />
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
                                    <label for="name_material_count" class="form-label">ชื่อเรียกจำนวนนับวัสดุ </label>
                                    <input type="text"
                                        class="form-control @error('name_material_count') is-invalid @enderror"
                                        id="name-material-count" name="name_material_count"
                                        placeholder="ชื่อเรียกจำนวนนับวัสดุ" required readonly />
                                    @error('name_material_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>



                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
