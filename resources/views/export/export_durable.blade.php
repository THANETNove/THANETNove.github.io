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
                                <h1 class="card-title text-primary ">รายงานครุภัณฑ์</h1>

                                <div>
                                    <form method="POST" action="{{ route('buy-export/pdf') }}" target="_blank">
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
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        value="0" id="flexRadioDefault1" checked>
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        ทั้งหมด
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        value="1" id="flexRadioDefault2">
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        ประเภทวัสดุ
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        value="2" id="flexRadioDefault2">
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        ประเภทครุภัณฑ์
                                                    </label>
                                                </div>
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
