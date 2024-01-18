<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ URL::asset('/assets/img/icons/unicons/logo.png') }}" alt
                    class="w-px-50 h-auto rounded-circle" />
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">DPME</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">


        @if (Auth::user()->status > 0)
            <li class="menu-item" id="department">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-widget'></i>
                    <div data-i18n="Account Settings">เเผนก</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" id="department-index">
                        <a href="{{ url('department-index') }}" class="menu-link">
                            <div data-i18n="Account">เเผนก</div>
                        </a>
                    </li>
                    <li class="menu-item" id="department-create">
                        <a href="{{ url('department-create') }}" class="menu-link">
                            <div data-i18n="Notifications">เพิ่มเเผนก</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item" id="personnel">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{--  <i class="menu-icon tf-icons bx bx-dock-top"></i> --}}
                    <i class='menu-icon tf-icons bx bx-user'></i>
                    <div data-i18n="Account Settings">ระบบบุคลากร </div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" id="personnel-index">
                        <a href="{{ url('personnel-index') }}" class="menu-link">
                            <div data-i18n="Account">ดูบุคลากร</div>
                        </a>
                    </li>
                    <li class="menu-item" id="personnel-create">
                        <a href="{{ url('personnel-create') }}" class="menu-link">
                            <div data-i18n="Notifications">เพิ่มบุคลากร</div>
                        </a>
                    </li>
                </ul>
            </li>


            @if (Auth::user()->status == 2)
                <li class="menu-item" id="approval">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class='menu-icon tf-icons bx bxs-select-multiple'></i>
                        <div data-i18n="Account Settings">อนุมัติครุภัณฑ์</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" id="approval-update">
                            <a href="{{ url('approval-update') }}" class="menu-link">
                                <div data-i18n="Notifications">อนุมัติครุภัณฑ์</div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <li class="menu-item" id="storage">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-buildings'></i>
                    <div data-i18n="Account Settings">สถานที่จัดเก็บ</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" id="storage-index">
                        <a href="{{ url('storage-index') }}" class="menu-link">
                            <div data-i18n="Account">ดูสถานที่</div>
                        </a>
                    </li>
                    <li class="menu-item" id="storage-create">
                        <a href="{{ url('storage-create') }}" class="menu-link">
                            <div data-i18n="Notifications">เพิ่มสถานที่</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item" id="category">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-grid-alt'></i>
                    <div data-i18n="Account Settings">หมวดหมู่วัสดุเเละครุภัณฑ์</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" id="category-index">
                        <a href="{{ url('category-index') }}" class="menu-link">
                            <div data-i18n="Account">วัสดุเเละครุภัณฑ์</div>
                        </a>
                    </li>
                    <li class="menu-item" id="category-create">
                        <a href="{{ url('category-create') }}" class="menu-link">
                            <div data-i18n="Notifications">ลงทะเบียนหมวดวัสดุเเละครุภัณฑ์</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item" id="material">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-add-to-queue'></i>
                    <div data-i18n="Account Settings">ระบบลงทะเบียนวัสดุ</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" id="material-index">
                        <a href="{{ url('material-index') }}" class="menu-link">
                            <div data-i18n="Account">วัสดุ</div>
                        </a>
                    </li>
                    <li class="menu-item" id="material-create">
                        <a href="{{ url('material-create') }}" class="menu-link">
                            <div data-i18n="Notifications">ลงทะเบียนวัสดุ</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item" id="durable-articles">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bx-add-to-queue'></i>
                    <div data-i18n="Account Settings">ระบบลงทะเบียนครุภัณฑ์</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" id="durable-articles-index">
                        <a href="{{ url('durable-articles-index') }}" class="menu-link">
                            <div data-i18n="Account">ครุภัณฑ์</div>
                        </a>
                    </li>
                    <li class="menu-item" id="durable-articles-create">
                        <a href="{{ url('durable-articles-create') }}" class="menu-link">
                            <div data-i18n="Notifications">ลงทะเบียนครุภัณฑ์</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item" id="buy">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-cart-add'></i>
                    <div data-i18n="Account Settings">ระบบการรับเข้า</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" id="buy-index">
                        <a href="{{ url('buy-index') }}" class="menu-link">
                            <div data-i18n="Account">รับเข้า</div>
                        </a>
                    </li>
                    <li class="menu-item" id="buy-create">
                        <a href="{{ url('buy-create') }}" class="menu-link">
                            <div data-i18n="Notifications">ลงทะเบียนรับเข้า</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <li class="menu-item" id="material-requisition">
            <a href="javascript:void(0);" class="menu-link menu-toggle">

                <i class='menu-icon tf-icons bx bxs-blanket'></i>
                <div data-i18n="Authentications">ระบบเบิกวัสดุ</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" id="material-requisition-index">
                    <a href="{{ url('material-requisition-index') }}" class="menu-link">
                        <div data-i18n="Basic">วัสดุอุปกรณ์</div>
                    </a>
                </li>
                <li class="menu-item" id="material-requisition-create">
                    <a href="{{ url('material-requisition-create') }}" class="menu-link">
                        <div data-i18n="Basic">เบิกวัสดุอุปกรณ์</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item" id="durable-articles-requisition">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-baby-carriage'></i>
                <div data-i18n="Authentications">ระบบเบิกครุภัณฑ์</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" id="durable-articles-requisition-index">
                    <a href="{{ url('durable-articles-requisition-index') }}" class="menu-link">
                        <div data-i18n="Basic">ครุภัณฑ์</div>
                    </a>
                </li>
                <li class="menu-item" id="durable-articles-requisition-create">
                    <a href="{{ url('durable-articles-requisition-create') }}" class="menu-link">
                        <div data-i18n="Basic">เบิกครุภัณฑ์</div>
                    </a>
                </li>
            </ul>
        </li>

        @if (Auth::user()->status > 0)
            <li class="menu-item" id="durable-articles-damaged">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-layer-plus'></i>
                    <div data-i18n="Authentications">ระบบครุภัณฑ์ชำรุด</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" id="durable-articles-damaged-index">
                        <a href="{{ url('durable-articles-damaged-index') }}" class="menu-link">
                            <div data-i18n="Basic">ครุภัณฑ์ที่ชำรุด</div>
                        </a>
                    </li>
                    <li class="menu-item" id="durable-articles-damaged-create">
                        <a href="{{ url('durable-articles-damaged-create') }}" class="menu-link">
                            <div data-i18n="Basic">ลงทะเบียนครุภัณฑ์ชำรุด</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item" id="durable-articles-repair">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-wrench'></i>
                    <div data-i18n="Authentications">ระบบการซ่อมครุภัณฑ์</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" id="durable-articles-repair-index">
                        <a href="{{ url('durable-articles-repair-index') }}" class="menu-link">
                            <div data-i18n="Basic">การซ่อมครุภัณฑ์</div>
                        </a>
                    </li>
                    <li class="menu-item" id="durable-articles-repair-create">
                        <a href="{{ url('durable-articles-repair-create') }}" class="menu-link">
                            <div data-i18n="Basic">ลงทะเบียนซ่อมครุภัณฑ์</div>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="menu-item" id="bet-distribution">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-log-out-circle'></i>
                    <div data-i18n="Authentications">ระบบการเเทงจำหน่ายครุภัณฑ์</div>
                </a>
                <ul class="menu-sub">
                    @if (Auth::user()->status == 2)
                        <li class="menu-item" id="bet-distribution-indexApproval">
                            <a href="{{ url('bet-distribution-indexApproval') }}" class="menu-link">
                                <div data-i18n="Basic">อนุมัติเเทงจำหน่ายครุภัณฑ์</div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item" id="bet-distribution-index">
                        <a href="{{ url('bet-distribution-index') }}" class="menu-link">
                            <div data-i18n="Basic">การเเทงจำหน่ายครุภัณฑ์</div>
                        </a>
                    </li>
                    <li class="menu-item" id="bet-distribution-create">
                        <a href="{{ url('bet-distribution-create') }}" class="menu-link">
                            <div data-i18n="Basic">ลงทะเบียนเเทงจำหน่ายครุภัณฑ์</div>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="menu-item  mb-10" id="calculator">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-calculator'></i>
                    <div data-i18n="Authentications">ระบบการคำนวณค่าเสื่อม</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" id="calculator-create">
                        <a href="{{ url('calculator-create') }}" class="menu-link">
                            <div data-i18n="Basic">คำนวณค่าเสื่อม</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

    </ul>
</aside>
