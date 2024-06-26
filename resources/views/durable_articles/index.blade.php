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
                                <h1 class="card-title text-primary ">ข้อมูลครุภัณฑ์</h1>
                                {{--   <a href="{{ url('durable-articles-export/pdf') }}" target="_blank"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานข้อมูลครุภัณฑ์</a> --}}
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>

                                                <th>ชื่อ</th>
                                                <th>จำนวนเต็ม</th>
                                                <th>เหลือ</th>
                                                <th>ชำรุด</th>
                                                <th>แทงจำหน่าย</th>
                                                <th>ซ่อม</th>
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

                                                    <td>{{ $da->durableArticles_name }}</td>

                                                    <td>{{ number_format($da->codeDurableArticlesCount) }}</td>
                                                    <td>{{ number_format($da->remainingAmountCount) }}</td>
                                                    <td>{{ number_format($da->damagedNumberCount) }}</td>
                                                    <td>{{ number_format($da->betDistributionNumberCount) }}</td>
                                                    <td>{{ number_format($da->repairNumberCount) }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                    href="{{ url('durable-articles-show', $da->id) }}"><i
                                                                        class='bx bxs-show'></i>View</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ url('durable-articles-edit', $da->id) }}">
                                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
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
