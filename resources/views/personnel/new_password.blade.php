@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-12">
                            <div class="card-body">
                                <h1 class="card-title text-primary ">New Password</h1>
                                <div class="row">
                                    <form class="user" id="myForm" method="POST"
                                        action="{{ route('update-password', Auth::user()->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3 col-md-6">
                                            <label for="firstName" class="form-label">รหัสผ่านใหม่</label>
                                            <input class="form-control" type="password" id="password" name="password"
                                                required>
                                        </div>
                                        <div class="row mt-4">
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
@endsection
