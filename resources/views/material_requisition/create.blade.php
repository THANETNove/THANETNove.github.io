@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เบิกวัสดุอุปกรณ์</h1>
                        <form method="POST" action="{{ route('personnel-store') }}">
                            @csrf
                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">รหัสวัสดุ</label>
                                    <input type="text" class="form-control @error('prefix') is-invalid @enderror"
                                        id="prefix" name="prefix" placeholder="คำนำหน้า" required />
                                    @error('prefix')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="prefix" class="form-label">ชื่อวัสดุ</label>
                                    <input type="text" class="form-control @error('employee_id') is-invalid @enderror"
                                        id="employee_id" name="employee_id" placeholder="รหัสพนักงาน" required />
                                    @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="first_name" class="form-label">จำนวนที่มี</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                        id="first_name" name="first_name" placeholder="ชื่อ" required />
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="first_name" class="form-label">จำนวนเบิก</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name" placeholder="นามสกุล" required />
                                    @error('last_name')
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
