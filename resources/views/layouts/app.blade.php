<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.head')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu aside -->
            @include('layouts.aside')


            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('layouts.navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    @yield('content')
                    <!-- / Content -->
                    @include('layouts.footer')
                    <!-- Footer -->

                </div>

                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->


        </div>

        <!-- Overlay -->

    </div>

    <div class="layout-overlay layout-menu-toggle"></div>

    @include('layouts.script')
</body>

</html>
