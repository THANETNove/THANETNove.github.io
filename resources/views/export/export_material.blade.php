@extends('layouts.app')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-12">

                            <div class="card-body">
                                <h1 class="card-title text-primary ">รายงานวัสดุ</h1>
                                <div>
                                    <form method="POST" action="{{ route('export-material/pdf') }}" id="exportFrom"
                                        target="_blank">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-6">
                                                <label for="start_date" class="form-label">Start Date</label>
                                                <input type="text" class="form-control date-created_at" name="start_date"
                                                    id="start_date" placeholder="yyyy-mm-dd" required>
                                            </div>

                                            <!-- End Date -->
                                            <div class="mb-3 col-6">
                                                <label for="end_date" class="form-label">End Date</label>
                                                <input type="text" class="form-control date-created_at" name="end_date"
                                                    id="end_date" placeholder="yyyy-mm-dd" required>
                                            </div>
                                            <div class="mb-4 mt-3">
                                                @if (Auth::user()->status >= 1)
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="search"
                                                            value="0" id="flexRadioDefault0" checked>
                                                        <label class="form-check-label" for="flexRadioDefault0">
                                                            รายงานวัสดุคงเหลือ
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="search"
                                                            value="1" id="flexRadioDefault1">
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            รายงานวัสดุหมด
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="search"
                                                            value="2" id="flexRadioDefault2">
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            รายการรับเข้า
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="search"
                                                            value="3" id="flexRadioDefault3">
                                                        <label class="form-check-label" for="flexRadioDefault3">
                                                            รายงานเบิกวัสดุแยกตามประเภท
                                                        </label>
                                                    </div>

                                                    <div class="form-check mt-3 mb-3" id="categories-type">
                                                        <select class="form-select" name="categories_type"
                                                            id="categories_type" aria-label="Default select example"
                                                            required>
                                                            <option selected disabled>เลือกประเภท</option>
                                                            @foreach ($categories_type as $cate)
                                                                <option value="{{ $cate->id }}">
                                                                    {{ $cate->category_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="search"
                                                            value="4" id="flexRadioDefault4">
                                                        <label class="form-check-label" for="flexRadioDefault4">
                                                            รายงานเบิกวัสดุแยกตามหน่วยงาน
                                                        </label>
                                                    </div>
                                                    <div class="form-check mt-3 mb-3" id="department-type">
                                                        <select class="form-select" name="department_type"
                                                            id="department_type" aria-label="Default select example">
                                                            <option selected disabled>เลือกหน่วยงาน</option>
                                                            @foreach ($department_type as $dep)
                                                                <option value="{{ $dep->id }}">
                                                                    {{ $dep->department_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="search"
                                                            value="5" id="flexRadioDefault5">
                                                        <label class="form-check-label" for="flexRadioDefault5">
                                                            รายงานเบิกตามชื่อ
                                                        </label>
                                                    </div>
                                                    <div class="form-check mt-3 mb-3" id="users-type">
                                                        <select class="form-select" name="users_type" id="users_type"
                                                            aria-label="Default select example">
                                                            <option selected disabled>เลือกชื่อ</option>


                                                            @foreach ($users_type as $user)
                                                                <option value="{{ $user->id }}">
                                                                    {{ $user->prefix }} {{ $user->first_name }}
                                                                    {{ $user->last_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="search"
                                                            value="6" id="flexRadioDefault6">
                                                        <label class="form-check-label" for="flexRadioDefault6">
                                                            รายงานเบิกทั้งหมด
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio" name="search"
                                                            value="7" id="flexRadioDefault7">
                                                        <label class="form-check-label" for="flexRadioDefault7">
                                                            รายงานการรอซื้อ
                                                        </label>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">รายงาน</button>
                                    </form>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- / Layout wrapper -->
@endsection
