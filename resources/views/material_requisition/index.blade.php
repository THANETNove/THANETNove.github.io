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
                                <h1 class="card-title text-primary ">เบิกวัสดุอุปกรณ์</h1>
                                <a href="{{ url('personnel-export/pdf') }}"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานการเบิกวัสดุอุปกรณ์</a>
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัสวัสดุ</th>
                                                <th>ชื่อวัสดุ</th>
                                                <th>จำนวนที่เบิก</th>
                                                <th>ชื่อเรียกหน่วยนับ </th>
                                                @if (Auth::user()->status != '0')
                                                    <th>ชื่อ นามสกุล ผู้เบิก </th>
                                                @endif

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
                                                    <td>{{ $da->code_requisition }}</td>
                                                    <td>{{ $da->material_name }}</td>
                                                    <td>{{ $da->amount_withdraw }}</td>
                                                    <td>{{ $da->name_material_count }}</td>
                                                    @if (Auth::user()->status != '0')
                                                        <td>{{ $da->prefix }} {{ $da->first_name }} {{ $da->last_name }}
                                                        </td>
                                                    @endif
                                                    {{--   @if (Auth::user()->status == '2')
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        href="{{ url('personnel-show', $da->id) }}"><i
                                                                            class='bx bxs-show'></i> View</a>
                                                                    @if ($da->statusEmployee == 'on')
                                                                        <a class="dropdown-item"
                                                                            href="{{ url('personnel-edit', $da->id) }}"><i
                                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                        @if (Auth::user()->id != $da->id)
                                                                            <a class="dropdown-item"
                                                                                href="{{ url('personnel-destroy', $da->id) }}"><i
                                                                                    class="bx bx-trash me-1"></i> Delete</a>
                                                                        @endif
                                                                    @else
                                                                        <a class="dropdown-item"
                                                                            href="{{ url('personnel-update-status', $da->id) }}">
                                                                            <i class='bx bx-up-arrow-circle'></i> update
                                                                            status</a>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif --}}
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
