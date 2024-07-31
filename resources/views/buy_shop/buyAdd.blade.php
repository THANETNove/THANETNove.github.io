@extends('layouts.app')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-12">
                            <div class="col-11 p-4">
                                <form method="POST" action="{{ route('buy-shop-add') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="text" class="form-control date-created_at" name="start_date"
                                                id="start_date" placeholder="yyyy-mm-dd" required>
                                        </div>

                                        <!-- End Date -->
                                        <div class="mb-3 col-6">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="text" class="form-control date-created_at" name="end_date"
                                                id="end_date" placeholder="yyyy-mm-dd" required>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">ค้นหา</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title text-primary ">ข้อมูลวัสดุที่ซื้อ</h1>
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


                                            @php
                                                $previousStatus = -1;
                                            @endphp
                                            @foreach ($data->groupBy('group_class') as $groupedData)
                                                @foreach ($groupedData->sortBy([['status_buy', 'asc'], ['type_durableArticles', 'asc'], ['description', 'asc'], ['durableArticles_number', 'asc']]) as $da)
                                                    @if ($previousStatus !== -1 && $previousStatus !== $da->status_buy)
                                                        <tr>
                                                            <td colspan="8"></td>

                                                        </tr> <!-- Adding a new line when status_buy changes -->
                                                    @endif
                                                    @php
                                                        $previousStatus = $da->status_buy;
                                                    @endphp
                                                    <tr>
                                                        <th scope="row">{{ $i++ }}</th>
                                                        <td>{{ $da->category_name }}</td>
                                                        <td>{{ $da->material_name }}</td>
                                                        <td>{{ number_format($da->total_amount_received) }}</td>
                                                        <td>{{ $da->name_material_count }}</td>
                                                        <td>{{ (new Carbon\Carbon($da->created_at))->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            @if ($da->status_buy == 1)
                                                                <span class="bg-label-success me-1">ซื้อเเล้ว</span>
                                                            @else
                                                                <span class="bg-label-warning me-1">ยกเลิกซื้อ</span>
                                                            @endif
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



    <!-- / Layout wrapper -->
@endsection
