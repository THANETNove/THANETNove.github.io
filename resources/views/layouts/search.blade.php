@php
    $currentURL = basename($_SERVER['REQUEST_URI']);
    $searchPaths = ['storage-index', 'personnel-index', 'durable-articles-index', 'material-index', 'buy-index', 'material-requisition-index', 'durable-articles-requisition-index', 'durable-articles-requisition-index', 'durable-articles-damaged-index'];
    $pathSearch = in_array($currentURL, $searchPaths) ? $currentURL : null;
@endphp

@if ($pathSearch)
    <form class="user" id="myForm" method="POST" action="{{ route($pathSearch) }}" enctype="multipart/form-data">
        @csrf
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" name="search" placeholder="Search..."
                    aria-label="Search..." />
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </div>
        </div>
    </form>
@endif
