@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เเก้ไข เเผนก</h1>
                        <form method="POST" action="{{ route('department-update', $data->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="department_name" class="form-label">ชื่อเเผนก</label>
                                    <input id="department_name" type="text"
                                        class="form-control @error('department_name') is-invalid @enderror"
                                        name="department_name" value="{{ $data->department_name }}" required
                                        placeholder="เเผนก" autocomplete="department_name">

                                    @error('department_name')
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
