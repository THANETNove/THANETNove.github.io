<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>


    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        @include('layouts.search')

        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            @php
                $dataDuAc = DB::table('durable_articles_requisitions')
                    ->where('durable_articles_requisitions.status', '0')
                    ->where('durable_articles_requisitions.statusApproval', '0')
                    ->leftJoin('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
                    ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
                    ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                    ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                    ->select(
                        'durable_articles_requisitions.*',
                        'categories.category_name',
                        'type_categories.type_name',
                        'durable_articles.durableArticles_name',
                        'users.prefix',
                        'users.first_name',
                        'users.last_name',
                    )

                    ->groupBy('durable_articles_requisitions.group_withdraw')
                    ->selectRaw('count(durable_articles_requisitions.group_withdraw) as groupWithdrawCount')
                    ->orderBy('durable_articles_requisitions.id', 'DESC')
                    ->get();

                $dataBet = DB::table('bet_distributions')
                    ->where('bet_distributions.status', '=', 'on')
                    ->where('bet_distributions.statusApproval', '=', '0')
                    ->leftJoin('durable_articles', 'bet_distributions.durable_articles_id', '=', 'durable_articles.id')
                    ->leftJoin('categories', 'bet_distributions.group_id', '=', 'categories.id')
                    ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                    ->select(
                        'bet_distributions.*',
                        'durable_articles.durableArticles_name',
                        'categories.category_name',
                        'type_categories.type_name',
                    )
                    ->orderBy('bet_distributions.id', 'DESC')
                    ->get();

                $dataReq = DB::table('durable_articles_requisitions')
                    ->where('durable_articles_requisitions.status', 2)
                    ->where('durable_articles_requisitions.statusApproval', 1)
                    ->join('users', 'durable_articles_requisitions.id_user', '=', 'users.id')
                    ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                    ->leftJoin('durable_articles', 'durable_articles_requisitions.group_id', '=', 'durable_articles.id')
                    ->leftJoin('type_categories', 'durable_articles.type_durableArticles', '=', 'type_categories.id')
                    ->leftJoin('categories', 'durable_articles.group_class', '=', 'categories.id')
                    ->leftJoin(
                        'storage_locations',
                        'durable_articles.code_material_storage',
                        '=',
                        'storage_locations.code_storage',
                    )
                    ->select(
                        'durable_articles_requisitions.*',
                        'type_categories.type_name',
                        'type_categories.type_code',
                        'users.prefix',
                        'users.first_name',
                        'users.last_name',
                        'departments.department_name',
                        'durable_articles.durableArticles_name',
                        'durable_articles.warranty_period',
                        'durable_articles.description',
                        'durable_articles.group_count',
                        'durable_articles.durableArticles_number',
                        'categories.category_name',
                        'categories.category_code',
                        'storage_locations.building_name',
                        'storage_locations.floor',
                        'storage_locations.room_name',
                    )

                    ->orderBy('durable_articles_requisitions.id', 'DESC')
                    ->get();

                $countData = $dataDuAc->count() + $dataBet->count() + $dataReq->count();

            @endphp
            <!-- Place this tag where you want the button to render. -->

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">

                    <div class="avatar">
                        <samp class="warn"> {{ $countData }}</samp>

                        <i class='bx bxs-bell-ring'
                            style='font-size: 32px;display: flex;margin-top: 8px;margin-left: -10px;'></i>

                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">

                    @if ($dataDuAc->count() > 0)
                        <li>
                            <a class="dropdown-item" href="{{ url('approval-update') }}">
                                <i class='bx warn-2'>{{ $dataDuAc->count() }}</i>
                                <span class="align-middle col-8">อนุมัติครุภัณฑ์</span>
                            </a>
                        </li>
                    @endif
                    @if ($dataBet->count() > 0)
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('bet-distribution-indexApproval') }}">

                                <i class='bx warn-2'>{{ $dataBet->count() }}</i>
                                <span class="align-middle">อนุมัติครุภัณฑ์จำหน่าย</span>
                            </a>
                        </li>
                    @endif
                    @if ($dataReq->count() > 0)
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('return-item-index') }}">

                                <i class='bx warn-2'>{{ $dataReq->count() }}</i>
                                <span class="align-middle">คึนครุภัณฑ์</span>
                            </a>
                        </li>
                    @endif





                </ul>
            </li>
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ URL::asset('/assets/img/avatars/1.png') }}" alt
                            class="w-px-40 h-auto rounded-circle" />


                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ URL::asset('/assets/img/avatars/1.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ Auth::user()->email }}</span>
                                    <small class="text-muted">
                                        @if (Auth::user()->status == '0')
                                            ผู้เบิก
                                        @elseif (Auth::user()->status == '1')
                                            เจ้าหน้าที่วัสดุ
                                        @else
                                            หัวหน้าวัสดุ
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->


        </ul>
    </div>
</nav>
