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
                                <h1 class="card-title text-primary ">ข้อมูลวัสดุที่สั่งซื้อ</h1>
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
                                                <th>ประเภทวัสดุ</th>
                                                <th>ชื่อ</th>
                                                <th>จำนวนที่ต้องการซื้อ</th>
                                                <th>หน่วย</th>
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

                                                        <td>{{ $da->category_name }}</td>
                                                        <td>{{ $da->material_name }}</td>

                                                        <td>{{ number_format($da->required_quantity) }}</td>
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
                                                                    {{--  <a class="dropdown-item" data-bs-toggle="modal"
                                                                        onclick="setId('{{ $da->buy_id }}')"
                                                                        data-bs-target="#modalCenter">
                                                                        <i class='bx bx-check-square '></i> ซื้อเเล้ว</a> --}}
                                                                    <a class="dropdown-item"
                                                                        href="{{ url('buy-shop-destroy', $da->buy_id) }}"><i
                                                                            class='bx bx-trash'></i> ยกเลิกการสั่งซื้อ</a>


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
                    <h5 class="modal-title" id="modalCenterTitle">จำนวนที่ซื้อ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="user" id="myForm" method="POST" action="{{ route('buy-shop-update') }}">
                        @csrf

                        <input type="text" name="buy_id" id="rejectedId" value="" style="display: none;">
                        <div class="row">
                            <div class="col mb-3">

                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class="bx bx-cart"></i></span>
                                    <input type="text" name="amount_received" class="form-control" id="rejectedId"
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
