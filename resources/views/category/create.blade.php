@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เพิ่ม หมวดหมู่วัสดุเเละครุภัณฑ์</h1>
                        <form method="POST" action="{{ route('category-store') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="department_name" class="form-label">หมวดหมู่</label>

                                    <select class="form-select" name="category_id" aria-label="Default select example">
                                        <option selected disabled>เลือกหมวดหมู่</option>
                                        <option value="1">หมวดหมู่วัสดุ</option>
                                        <option value="2">หมวดหมู่ครุภัณฑ์</option>
                                    </select>

                                </div>
                                <div class="mb-3 col-md-8">
                                    <label for="category_name" class="form-label">ชื่อหมวดหมู่</label>
                                    <input id="category_name" type="text"
                                        class="form-control @error('category_name') is-invalid @enderror"
                                        name="category_name" required placeholder="ชื่อหมวดหมู่"
                                        autocomplete="category_name">

                                    @error('category_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
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
