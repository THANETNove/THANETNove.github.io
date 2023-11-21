@extends('layouts.app')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row justify-content-center mt-3">
                        <div class="col-sm-7">
                            <div class="card-body ">
                                <h1 class="card-title text-primary ">เเก้สถานที่จัดเก็บ</h1>
                                <div class="col-xxl">
                                    <div class=" mb-4">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0">สถานที่จัดเก็บ</h5>
                                            <small class="text-muted float-end"></small>
                                        </div>
                                        <div class="card-body">
                                            <form class="user" id="myForm" method="POST"
                                                action="{{ route('storage-update', $data['id']) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label"
                                                        for="basic-default-name">ชื่ออาคาร</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control"
                                                            value="{{ $data['building_name'] }}" name="building_name"
                                                            id="basic-default-name" placeholder="ชื่ออาคาร">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label"
                                                        for="basic-default-name">ชั้น</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control"
                                                            name="floor"id="basic-default-name"
                                                            value="{{ $data['floor'] }}" placeholder="ชั้น">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label"
                                                        for="basic-default-name">ชื่อห้อง</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="room_name"
                                                            value="{{ $data['room_name'] }}" id="basic-default-name"
                                                            placeholder="ชื่อห้อง">
                                                    </div>
                                                </div>

                                                <div class="row justify-content-end">
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
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
