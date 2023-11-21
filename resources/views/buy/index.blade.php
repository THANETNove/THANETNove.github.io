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
                                {{--  <a href="{{ url('personnel-export/pdf') }}"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานข้อมูลวัสดุ</a> --}}
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
                                                <th>ราคา ต่อชิ้น</th>
                                                <th>ราคา รวม</th>
                                                <th>สถานะ</th>
                                                <th>Actions</th>

                                            </tr>
                                        </thead>
                                        @php
                                            $i = 1;
                                        @endphp
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($data->where('status', '0')->sortByDesc('created_at') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->type }}</td>
                                                    <td>{{ $da->buy_name }}</td>
                                                    <td>{{ $da->quantity }}</td>
                                                    <td>{{ $da->price_per_piece }}</td>
                                                    <td>{{ $da->total_price }}</td>
                                                    <td>{{ $da->details }}</td>
                                                    <td>
                                                        <span class="badge bg-label-info me-1">รอการซื้อ</span>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            @foreach ($data->where('status', '1')->sortByDesc('created_at') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->type }}</td>
                                                    <td>{{ $da->buy_name }}</td>
                                                    <td>{{ $da->quantity }}</td>
                                                    <td>{{ $da->price_per_piece }}</td>
                                                    <td>{{ $da->total_price }}</td>
                                                    <td>{{ $da->details }}</td>
                                                    <td>
                                                        <span class="badge bg-label-success me-1">ซื้อเเล้ว</span>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            @foreach ($data->where('status', '2')->sortByDesc('created_at') as $da)
                                                <tr>
                                                    <th scope="row">{{ $i++ }}</th>
                                                    <td>{{ $da->type }}</td>
                                                    <td>{{ $da->buy_name }}</td>
                                                    <td>{{ $da->quantity }}</td>
                                                    <td>{{ $da->price_per_piece }}</td>
                                                    <td>{{ $da->total_price }}</td>
                                                    <td>{{ $da->details }}</td>
                                                    <td>
                                                        <span class="badge bg-label-warning me-1">ยกเลิกซื้อ</span>

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
