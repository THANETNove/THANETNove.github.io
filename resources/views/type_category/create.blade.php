@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เพิ่ม ชื่อครุภัณฑ์</h1>
                        <form method="POST" action="{{ route('photo-store') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="department_name" class="form-label">หมวดหมู่</label>

                                    <select class="form-select" name="photo_id" aria-label="Default select example">
                                        <option>เลือกหมวดหมู่</option>
                                        @foreach ($group as $gr)
                                            <option value="{{ $gr->category_code }}">
                                                {{ $gr->category_name }} {{ $gr->category_code }}</option>
                                        @endforeach


                                    </select>

                                </div>
                                <div class="mb-3 col-md-8">
                                    <label for="category_code" class="form-label">รหัสชื่อ</label>
                                    <input id="category_code" type="text"
                                        class="form-control @error('photo_code') is-invalid @enderror" name="category_code"
                                        required placeholder="รหัสหมวดหมู่/ประเภท" autocomplete="category_code">

                                    @error('category_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="mb-3 col-md-8">
                                        <label for="category_name" class="form-label">ชื่อ</label>
                                        <input id="category_name" type="text"
                                            class="form-control @error('category_name') is-invalid @enderror"
                                            name="photo_name" required placeholder="ชื่อหมวดหมู่"
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
