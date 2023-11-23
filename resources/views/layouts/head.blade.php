<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="shortcut icon" href="{{ URL::asset('/assets/img/icons/unicons/logo.png') }}">

<title>DPME-Stystem</title>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="{{ URL::asset('/assets/vendor/fonts/boxicons.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ URL::asset('/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ URL::asset('/assets/vendor/css/theme-default.css') }}"
    class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ URL::asset('/assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ URL::asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

<link rel="stylesheet" href="{{ URL::asset('/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

<!-- Page CSS -->
<link rel="stylesheet" href="{{ URL::asset('/assets/vendor/css/pages/page-auth.css') }}" />
<!-- Helpers -->
<script src="{{ URL::asset('/assets/vendor/js/helpers.js') }}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ URL::asset('/assets/js/config.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
