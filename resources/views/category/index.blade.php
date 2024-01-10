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
                                <h1 class="card-title text-primary ">หมวดหมู่วัสดุเเละครุภัณฑ์</h1>
                                {{-- <a href="{{ url('personnel-export/pdf') }}"
                                    class="btn rounded-pill btn-outline-info mb-3">รายงานข้อมูลครุภัณฑ์</a> --}}
                                @if (session('message'))
                                    <p class="message-text text-center mt-4"> {{ session('message') }}</p>
                                @endif
                                <div class="group-category">
                                    <form class="user" id="myForm" method="POST"
                                        action="{{ route('category-index') }}" enctype="multipart/form-data">
                                        @csrf
                                        <select class="form-select" onchange="myFunction(this.value)" name="search"
                                            aria-label="Disabled select example">
                                            <option value="3" @if ($id_search == 3) selected @endif>
                                                หมวดหมู่ทั้งหมด</option>
                                            <option value="1" @if ($id_search == 1) selected @endif>
                                                หมวดหมู่วัสดุ</option>
                                            <option value="2" @if ($id_search == 2) selected @endif>
                                                หมวดหมู่ครุภัณฑ์</option>
                                        </select>
                                    </form>

                                </div>

                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ชื่อหมวดหมู่</th>
                                                <th>หมวดหมู่</th>
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
                                                        <td>{{ $da->category_name }}
                                                        </td>
                                                        <td>
                                                            @if ($da->category_id == 1)
                                                                <span
                                                                    class="badge bg-label-primary me-1">หมวดหมู่วัสดุ</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-label-info me-1">หมวดหมู่ครุภัณฑ์</span>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        href="{{ url('category-edit', $da->id) }}">
                                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                                    </a>
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

    <!-- / Layout wrapper -->
@endsection
