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
                                <h1 class="card-title text-primary ">ข้อมูลการจัดซื้อ</h1>
                                <a href="{{ url('buy-export/pdf') }}"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานข้อมูลวัสดุ</a>
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ประเภท</th>
                                                <th>ชื่อ</th>
                                                <th>จำนวน</th>
                                                <th>หน่วยนับ</th>
                                                <th>ราคา ต่อชิ้น</th>
                                                <th>ราคา รวม</th>
                                                <th>รายละเอียด</th>
                                                <th>สถานะ</th>
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
                                                    <td>{{ $da->category_name }}</td>
                                                    <td>
                                                        @if ($da->typeBuy == 1)
                                                            {{ $da->material_name }}
                                                        @else
                                                            {{ $da->durableArticles_name }}
                                                        @endif
                                                    </td>
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
                                                                        <a class="dropdown-item"
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

    <!-- / Layout wrapper -->
@endsection
