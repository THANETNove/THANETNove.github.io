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
                                <h1 class="card-title text-primary ">รายงานสถานที่จัดเก็บ</h1>

                                <div>
                                    <br>
                                    <a href="{{ url('storage-export/pdf') }}" target="_blank"
                                        class="btn rounded-pill btn-outline-info mb-3">รายงาน</a>

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
