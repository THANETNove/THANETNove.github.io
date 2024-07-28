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
                                <h1 class="card-title text-primary ">ข้อมูลวัสดุ</h1>
                                {{--  <a href="{{ url('material-export/pdf') }}" target="_blank"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานข้อมูลวัสดุ</a> --}}
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif


                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัส</th>
                                                <th>ประเภทวัสดุ</th>
                                                <th>ชื่อ</th>
                                                <th></th>
                                                {{--  <th>จำนวนวัสดุ</th> --}}
                                                {{-- <th>จำนวนวัสดุ เเพค/โหล</th> --}}
                                                <th>จำนวนที่เหลือ</th>
                                                <th>หน่วย</th>

                                                {{--   <th>ที่จัดเก็บ</th> --}}
                                                <th>date</th>
                                                <th>Actions</th>

                                            </tr>
                                        </thead>
                                        @php
                                            $i = 1;
                                        @endphp
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data->groupBy('group_class') as $groupedData)
                                                @foreach ($groupedData->sortBy(['type_durableArticles', 'description', 'durableArticles_number']) as $da)
                                                    <tr>
                                                        <th scope="row">{{ $i++ }}</th>
                                                        <td>{{ $da->code_material }}
                                                        </td>
                                                        <td>{{ $da->category_name }}</td>
                                                        <td>{{ $da->material_name }}</td>
                                                        @php

                                                            $percent_of_A = number_format($da->material_number) * 0.2;

                                                            $percent_of_A_int = round($percent_of_A);

                                                        @endphp
                                                        <td>
                                                            @if (number_format($da->remaining_amount) < $percent_of_A_int)
                                                                @if (number_format($da->remaining_amount) == 0)
                                                                    <span class="badge bg-label-danger me-1">วัสดุหมด</span>
                                                                @else
                                                                    <span
                                                                        class="badge bg-label-warning me-1">วัสดุใกล้หมด</span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        {{--  <td>{{ number_format($da->material_number) }}</td> --}}
                                                        <td>{{ number_format($da->remaining_amount) }}</td>
                                                        <td>{{ $da->name_material_count }}</td>
                                                        <td>{{ (new Carbon\Carbon($da->created_at))->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="#"
                                                                        data-bs-toggle="modal"
                                                                        onclick="setId('{{ $da->id }}')"
                                                                        data-bs-target="#modalCenter">
                                                                        <i class='bx bx-cart'></i> สั่งซื้อ</a>


                                                                    <a class="dropdown-item"
                                                                        href="{{ url('material-show', $da->id) }}"><i
                                                                            class='bx bxs-show'></i> View</a>
                                                                    <a class="dropdown-item"
                                                                        href="{{ url('material-edit', $da->id) }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach


                                        </tbody>
                                    </table>
                                    <div class="mt-5">
                                        {!! $data->links() !!}
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">จำนวนที่ต้องซื้อ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="user" id="myForm" method="POST" action="{{ route('buy-shop-store') }}">
                        @csrf

                        <input type="text" name="buy_id" id="rejectedId" value="" style="display: none;">
                        <div class="row">
                            <div class="col mb-3">

                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class="bx bx-cart"></i></span>
                                    <input type="text" name="required_quantity" class="form-control" id="rejectedId"
                                        required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setId(id) {
            $('#rejectedId').val(id);
        }
    </script>

    <!-- / Layout wrapper -->
@endsection
