@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เเก้ไข ชื่อครุภัณฑ์</h1>
                        <form method="POST" action="{{ route('typeCategory-update', $data['id']) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="department_name" class="form-label">หมวดหมู่</label>

                                    <select class="form-select" name="type_id" aria-label="Default select example">
                                        <option selected disabled>เลือกหมวดหมู่</option>
                                        @foreach ($group as $gr)
                                            @if ($data['type_id'] == $gr->id)
                                                <option value="{{ $gr->id }}" selected>
                                                    {{ $gr->category_name }}</option>
                                            @else
                                                <option value="{{ $gr->id }}">
                                                    {{ $gr->category_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-8">
                                    <label for="type_code" class="form-label">รหัสชื่อ</label>
                                    <input id="type_code" type="text" class="form-control" name="type_code" required
                                        placeholder="รหัสชื่อ" value="{{ $data['type_code'] }}"
                                        autocomplete="category_code">

                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="category_name" class="form-label">ชื่อ</label>
                                    <input id="category_name" type="text" class="form-control"
                                        value="{{ $data['type_name'] }}" name="type_name" required
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
