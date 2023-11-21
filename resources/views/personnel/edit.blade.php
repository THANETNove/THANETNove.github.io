@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-12">
                            <div class="card-body">
                                <h1 class="card-title text-primary ">เเก้ไขข้อมูลบุคลากร</h1>
                                <form class="user" id="myForm" method="POST"
                                    action="{{ route('personnel-update', $data['id']) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    @include('personnel.view')
                                    <div class="row mt-3">
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
@endsection
