@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">
            <div class="col-12 mb-4 order-0">

                <div class="card ">
                    <div class="card-body">
                        <h1 class="card-title text-primary ">เเก้ไขระบบลงทะเบียนวัสดุ</h1>
                        <form class="user" id="myForm" method="POST" action="{{ route('material-update', $mate['id']) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="group_class" class="form-label">กลุ่ม/ประเภท</label>
                                    <input id="group_class" type="number"
                                        class="form-control @error('group_class') is-invalid @enderror" name="group_class"
                                        required value="{{ $mate['group_class'] }}" placeholder="กลุ่ม/ประเภท"
                                        autocomplete="group_class">

                                    @error('group_class')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="type_durableArticles" class="form-label">ชนิด</label>
                                    <input id="type_durableArticles" type="number"
                                        class="form-control @error('type_durableArticles') is-invalid @enderror"
                                        name="type_durableArticles" required placeholder="ชนิด"
                                        value="{{ $mate['type_durableArticles'] }}" autocomplete="type_durableArticles">

                                    @error('type_durableArticles')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="description" class="form-label">รายละเอียด</label>
                                    <input id="description" type="number"
                                        class="form-control @error('description') is-invalid @enderror" name="description"
                                        required placeholder="รายละเอียด" autocomplete="description"
                                        value="{{ $mate['description'] }}">

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="material_name" class="form-label">ชื่อวัสดุ</label>
                                    <input id="material_name" type="text"
                                        class="form-control @error('material_name') is-invalid @enderror"
                                        name="material_name" required placeholder="ชื่อวัสดุ"
                                        value="{{ $mate['material_name'] }}" autocomplete="material_name">

                                    @error('material_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="material_number" class="form-label">จำนวนวัสดุชิ้น</label>
                                    <input id="material_number" type="number"
                                        class="form-control @error('material_number') is-invalid @enderror"
                                        name="material_number" value="{{ $mate['material_number'] }}" required
                                        placeholder="จำนวนวัสดุ" autocomplete="material_number">

                                    @error('material_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                {{--          <div class="mb-3 col-md-6">
                                    <label for="material_number_pack_dozen" class="form-label">จำนวนวัสดุ
                                        เเพค/โหล</label>
                                    <input id="material_number_pack_dozen" type="number"
                                        class="form-control @error('material_number_pack_dozen') is-invalid @enderror"
                                        name="material_number_pack_dozen" placeholder="จำนวนวัสดุ เเพค/โหล"
                                        value="{{ $mate['material_number_pack_dozen'] }}"
                                        autocomplete="material_number_pack_dozen">

                                    @error('material_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div> --}}
                                <div class="mb-3 col-md-6">
                                    <label for="name_material_count" class="form-label">ชื่อเรียกจำนวนนับวัสดุ (เช่น อัน ตัว
                                        อื่น ๆ
                                        )</label>
                                    <input id="name_material_count" type="text"
                                        class="form-control @error('name_material_count') is-invalid @enderror"
                                        name="name_material_count" required placeholder="ชื่อเรียกจำนวนนับวัสดุ"
                                        value="{{ $mate['name_material_count'] }}" autocomplete="name_material_count">

                                    @error('name_material_count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="code_material_storage" class="form-label">ที่เก็บวัสดุ</label>
                                    <select class="form-select" aria-label="Default select example"
                                        name="code_material_storage" required>
                                        <option selected disabled>ที่เก็บวัสดุ</option>
                                        @foreach ($data as $lo)
                                            @if ($lo->code_storage == $mate['code_material_storage'])
                                                <option value="{{ $lo->code_storage }}" selected>{{ $lo->building_name }}
                                                    {{ $lo->floor }} {{ $lo->room_name }}</option>
                                            @else
                                                <option value="{{ $lo->code_storage }}">{{ $lo->building_name }}
                                                    {{ $lo->floor }} {{ $lo->room_name }}</option>
                                            @endif
                                        @endforeach

                                    </select>
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
