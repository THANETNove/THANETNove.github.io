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
                                <h1 class="card-title text-primary ">สถานที่จัดเก็บ</h1>
                                <a href="{{ url('storage-export/pdf') }}" target="_blank"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานข้อมูลสถานที่</a>
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ชื่ออาคาร</th>
                                                <th>ชั้น</th>
                                                <th>ชื่อห้อง</th>
                                                <th>สถานะ</th>
                                                @if (Auth::user()->status == '2')
                                                    <th>Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        @php
                                            $i = 1;
                                        @endphp
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data->where('status', 'on')->sortByDesc('created_at') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->building_name }}</td>
                                                    <td>{{ $da->floor }}</td>
                                                    <td>{{ $da->room_name }}</td>
                                                    <td><span class="badge bg-label-success me-1">เปิดใช้งานอยู่</span>
                                                    </td>
                                                    @if (Auth::user()->status == '2')
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        href="{{ url('storage-edit', $da->id) }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                    <a class="dropdown-item alert-destroy"
                                                                        href="{{ url('storage-destroy', $da->id) }}"><i
                                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach

                                            @foreach ($data->where('status', 'off')->sortByDesc('created_at') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->building_name }}</td>
                                                    <td>{{ $da->floor }}</td>
                                                    <td>{{ $da->room_name }}</td>
                                                    <td><span class="badge bg-label-warning me-1">ปิดใช้งานอยู่</span>
                                                    </td>

                                                    @if (Auth::user()->status == '2')
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item alert-destroy"
                                                                        href="{{ url('storage-update-status', $da->id) }}">
                                                                        <i class='bx bx-up-arrow-circle'></i> update
                                                                        status</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif

                                                </tr>
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
    <!-- / Layout wrapper -->
@endsection
