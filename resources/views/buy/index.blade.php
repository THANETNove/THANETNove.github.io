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
                                <h1 class="card-title text-primary ">รายการข้อมูลเข้า</h1>
                                <button {{-- href="{{ url('buy-export/pdf') }}" target="_blank"  --}} data-bs-toggle="modal" data-bs-target="#exampleModalBuy"
                                    class="btn rounded-pill btn-outline-info mb-3">รายการข้อมูลเข้า</button>
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ประเภท</th>
                                                <th>ชื่อประเภท</th>
                                                <th>ชื่อ</th>
                                                <th>รายละเอียด</th>
                                                <th>จำนวน</th>
                                                <th>หน่วยนับ</th>
                                                <th>ราคา ต่อชิ้น</th>
                                                <th>ราคา รวม</th>
                                                <th>รายละเอียด</th>
                                                <th>สถานะ</th>
                                                <th>วันรับเข้า</th>
                                                <th>วันที่สร้าง</th>
                                                <th>Actions</th>

                                            </tr>
                                        </thead>
                                        @php
                                            $i = 1;

                                        @endphp
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>
                                                        @if ($da->typeBuy == 1)
                                                            ประเภทวัสดุ
                                                        @else
                                                            ประเภทครุภัณฑ์
                                                        @endif
                                                    </td>
                                                    <td>{{ $da->category_name }}</td>
                                                    @if ($da->typeBuy == 1)
                                                        <td>
                                                            {{ $da->material_name }}
                                                        </td>
                                                        <td>
                                                        </td>
                                                    @endif
                                                    @if ($da->typeBuy == 2)
                                                        <td>
                                                            {{ $da->type_name }}
                                                        </td>
                                                        <td>
                                                            {{ $da->durableArticles_name }}
                                                        </td>
                                                    @endif
                                                    <td>{{ number_format($da->quantity) }}</td>
                                                    <td>{{ $da->counting_unit }}</td>
                                                    <td>{{ number_format($da->price_per_piece) }} </td>
                                                    <td>{{ number_format($da->total_price) }}</td>
                                                    <td>{{ $da->details }}</td>
                                                    <td>
                                                        @if ($da->status == 0)
                                                            <span class="badge bg-label-info me-1">เพิ่มรายการ</span>
                                                        @else
                                                            <span class="badge bg-label-warning me-1">ยกเลิกรายการ</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $da->date_enter }}</td>

                                                    <td>{{ date('d-m-Y', strtotime($da->created_at)) }}</td>

                                                    <td>
                                                        @if ($da->status == 0)
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        href="{{ url('buy-edit', $da->id) }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                    @if (Auth::user()->status == '2')
                                                                        <a class="dropdown-item alert-destroy"
                                                                            href="{{ url('buy-destroy', $da->id) }}"><i
                                                                                class="bx bx-trash me-1"></i> Delete</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                    {{--  <div class="mt-5">
                                        {!! $data->links() !!}
                                    </div> --}}
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModalBuy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">รายการข้อมูลเข้า</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('buy-export/pdf') }}" target="_blank">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-6">
                                <label for="exampleFormControlInput1" class="form-label">วันที่เริ่มต้น</label>
                                <input type="text" class="form-control date-created_at" name="start_date" id="start_date"
                                    placeholder="yyy-mm-dd" required>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="exampleFormControlTextarea1" class="form-label">วันที่สิ้นสุด</label>
                                <input type="text" class="form-control date-created_at" name="end_date" id="end_date"
                                    placeholder="yyyy-mm-dd" required>
                            </div>
                            <div class="mb-4 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="0"
                                        id="flexRadioDefault1" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        ทั้งหมด
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="1"
                                        id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        ประเภทวัสดุ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="2"
                                        id="flexRadioDefault2">
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

    <!-- / Layout wrapper -->
@endsection
