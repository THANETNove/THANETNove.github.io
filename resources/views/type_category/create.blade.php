@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เพิ่ม ชื่อครุภัณฑ์</h1>
                        <form method="POST" action="{{ route('typeCategory-store') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="department_name" class="form-label">หมวดหมู่</label>

                                    <select class="form-select" name="type_id" aria-label="Default select example">
                                        <option selected disabled>เลือกหมวดหมู่</option>
                                        @foreach ($group as $gr)
                                            <option value="{{ $gr->id }}">
                                                {{ $gr->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-8">
                                    <label for="type_code" class="form-label">รหัสชื่อ</label>
                                    <input id="type_code" type="number" class="form-control" name="type_code" required
                                        placeholder="รหัสชื่อ" autocomplete="category_code">

                                    @error('category_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="category_name" class="form-label">ชื่อ</label>
                                    <input id="category_name" type="text" class="form-control" name="type_name" required
                                        placeholder="ชื่อหมวดหมู่" autocomplete="category_name">
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
