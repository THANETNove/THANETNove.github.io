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
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="firstName" class="form-label">รหัสพนักงาน</label>
                                            <input class="form-control" type="text" id="employee_id" name="employee_id"
                                                value="{{ $data['employee_id'] }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="firstName" class="form-label">คำนำหน้า</label>
                                            <input class="form-control" type="text" id="prefix" name="prefix"
                                                value="{{ $data['prefix'] }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="firstName" class="form-label">ชื่อ</label>
                                            <input class="form-control" type="text" id="firstName" name="first_name"
                                                value="{{ $data['first_name'] }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="lastName" class="form-label">นามสกุล</label>
                                            <input class="form-control" type="text" name="last_name"
                                                value="{{ $data['last_name'] }}" id="last_name">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                                id="email" name="email" value="{{ $data['email'] }}" />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6" style="display: none">
                                            <label for="password" class="form-label">password</label>
                                            <input class="form-control " type="password" id="password" name="password"
                                                value="{{ $data['password'] }}" />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="phone_number"
                                                class="form-label @error('phone_number') is-invalid @enderror">เบอร์โทร</label>
                                            <input type="number" class="form-control" id="phone_number" name="phone_number"
                                                value="{{ $data['phone_number'] }}">
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="mb-3 col-md-12">
                                            <label for="phone_number" class="form-label">เเผนก</label>
                                            <select class="form-select" name="department_id"
                                                aria-label="Default select example">

                                                <option>ไม่มีเเผนก</option>
                                                @foreach ($depart as $dep)
                                                    @if ($dep->id == $data['department_id'])
                                                        <option value="{{ $dep->id }}" selected>เเผนก
                                                            {{ $dep->department_name }}</option>
                                                    @else
                                                        <option value="{{ $dep->id }}">เเผนก
                                                            {{ $dep->department_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        @php
                                            $dataProvinces = DB::table('provinces')->get();
                                            $dataDistricts = DB::table('districts')->get();
                                            $dataSubdistrict = DB::table('subdistricts')->get();
                                        @endphp

                                        <div class="mb-3 col-md-6">
                                            <label for="address" class="form-label">ที่อยู่</label>
                                            <input type="text" class="form-control" value="{{ $data['address'] }}"
                                                id="address" name="address" placeholder="ที่อยู่" required />

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="provinces" class="form-label">จังหวัด</label>
                                            <select class="select-address select-address form-select font-size-12-black"
                                                name="provinces" id="provinces" aria-label="Default select example">
                                                <option selected disabled>จังหวัด</option>
                                                @foreach ($dataProvinces as $provinces)
                                                    @if ($data['provinces'] == $provinces->id)
                                                        <option value="{{ $provinces->id }}" selected>
                                                            {{ $provinces->name_th }}</option>
                                                    @else
                                                        @if (Auth::user()->status == '2')
                                                            <option value="{{ $provinces->id }}">
                                                                {{ $provinces->name_th }}
                                                            </option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="first_name" class="form-label">แขวง/ อำเภอ</label>
                                            <select class="select-address form-select mt-2 font-size-12-black"
                                                name="districts" id="districts" aria-label="Default select example">
                                                <option selected disabled>แขวง/ อำเภอ</option>
                                                @foreach ($dataSubdistrict as $subdistrict)
                                                    @if ($data['subdistrict'] == $subdistrict->id)
                                                        <option value="{{ $subdistrict->id }}" selected>
                                                            {{ $subdistrict->name_th }}</option>
                                                    @else
                                                        @if (Auth::user()->status == '2')
                                                            <option value="{{ $subdistrict->id }}">
                                                                {{ $subdistrict->name_th }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="first_name" class="form-label">เขต/ ตำบล</label>
                                            <select class="select-address form-select mt-2 font-size-12-black"
                                                name="subdistrict" id="subdistrict" aria-label="Default select example">
                                                <option selected disabled>เขต/ ตำบล</option>
                                                @foreach ($dataDistricts as $districts)
                                                    @if ($data['districts'] == $districts->id)
                                                        <option value="{{ $districts->id }}" selected>
                                                            {{ $districts->name_th }}</option>
                                                    @else
                                                        @if (Auth::user()->status == '2')
                                                            <option value="{{ $districts->id }}">
                                                                {{ $districts->name_th }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="first_name" class="form-label">รหัสไปรษณีย์</label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code"
                                                value="{{ $data['zip_code'] }}" placeholder="รหัสไปรษณีย์" />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="first_name" class="form-label">สถานะ
                                            </label>
                                            <select
                                                class="select-address form-select mt-2 font-size-12-black  @error('status') is-invalid @enderror"
                                                name="status" id="status" aria-label="Default select example">
                                                <option selected disabled>สถานะ</option>
                                                @if ($data['status'] == '0')
                                                    <option value="{{ $data['status'] }}" selected>ผู้เบิก</option>
                                                    @if ($data['statusEmployee'] == 'on')
                                                        <option value="1">เจ้าหน้าที่วัสดุ</option>
                                                    @endif
                                                @elseif ($data['status'] == '1')
                                                    @if ($data['statusEmployee'] == 'on')
                                                        <option value="0">ผู้เบิก</option>
                                                    @endif
                                                    <option value="{{ $data['status'] }}"selected>เจ้าหน้าที่วัสดุ
                                                    </option>
                                                @elseif ($data['status'] == '2')
                                                    {{--         @if ($data['statusEmployee'] == 'on')
                                                        <option value="0">ผู้เบิก</option>
                                                        <option value="1">เจ้าหน้าที่วัสดุ</option>
                                                    @endif --}}
                                                    <option value="{{ $data['status'] }}" selected>หัวหน้าวัสดุ</option>
                                                @endif
                                            </select>
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="first_name" class="form-label">สถานะพนักงาน</label>
                                            <select class="select-address form-select mt-2 font-size-12-black"
                                                name="statusEmployee" id="statusEmployee"
                                                aria-label="Default select example">
                                                <option selected disabled>สถานะพนักงาน</option>
                                                @if ($data['statusEmployee'] == 'on')
                                                    <option value="{{ $data['statusEmployee'] }}" selected>ปกติ
                                                    </option>
                                                    @if ($data['statusEmployee'] == 'on')
                                                        <option value="off">ระงันการใช้งาน</option>
                                                    @endif
                                                @else
                                                    <option value="{{ $data['statusEmployee'] }}" selected>ระงันการใช้งาน
                                                    </option>
                                                    @if ($data['statusEmployee'] == 'on')
                                                        <option value="on">ปกติ</option>
                                                    @endif
                                                @endif
                                            </select>

                                        </div>
                                    </div>

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

    <script>
        document.getElementById('employee_id').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // ลบตัวอักษรที่ไม่ใช่ตัวเลข
            if (value.length > 2) {
                value = value.slice(0, 2) + '-' + value.slice(2);
            }
            if (value.length > 5) {
                value = value.slice(0, 5) + '-' + value.slice(5);
            }
            if (value.length > 9) {
                value = value.slice(0, 9) + '-' + value.slice(9, 13);
            }
            e.target.value = value;
        });
    </script>
@endsection
