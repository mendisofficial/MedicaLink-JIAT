@extends('layouts.app')

@section('title','Profile Reports')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/profile-main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/searchBar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-reports.css') }}">
@endsection

@section('page-content')

    @parent

    <!-- Search Section -->
    <div class="col-12">
        <div id="search-controls-section" class="mb-4 py-2 px-3 section-blur">

            <form action="" method="GET" class="mb-0">
                <div class="search-controls d-flex align-items-center">
                    <button class="fs-5">
                        <i class="bi bi-search"></i>
                    </button>
                    <!-- <div class="vr mx-2"></div> -->
                    <input type="text" class="search-bar" name="query" placeholder="Search for vaccinations or medical records...">
                    <div class="vr mx-2"></div>
                    <button class="fs-5" data-bs-toggle="collapse" data-bs-target="#search-filter"
                        aria-expanded="false" aria-controls="search-filter" type="button">
                        <i class="bi bi-ui-checks-grid"></i>
                    </button>
                </div>

                <div class="container-fluid search-filter collapse" id="search-filter">
                    <div class="row pt-3">

                        <div class="col">
                            <h6>Select search type</h6>
                            <ul>
                                <li class="category">
                                    <input type="radio" id="type1" name="type" value="title" class="radio" checked>
                                    <label for="type1"># Record Title</label>
                                </li>
                                <li class="category active">
                                    <input type="radio" id="type2" name="type" value="location" class="radio">
                                    <label for="type2"># Record Location</label>
                                </li>
                                <li class="category">
                                    <input type="radio" id="type3" name="type" value="all" class="radio">
                                    <label for="type3"># All</label>
                                </li>
                            </ul>
                        </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Reports Sections -->
    <div class="col">
        <!-- Medical Records -->
        <div class="record-container px-4 py-3 section-blur shadow">

            <div class="section-controls py-3">

                <div class="section-links">
                    <button class="me-2 active px-3 py-2" id="vaccineButton">
                        <span class="d-none d-md-inline">Vaccinations</span>
                        <i class="bi bi-virus2 ms-md-2"></i>
                    </button>
                    <button class="me-2 px-3 py-2" id="reportButton">
                        <span class="d-none d-md-inline">Medical Reports</span>
                        <i class="bi bi-clipboard2-pulse ms-md-2"></i>
                    </button>
                </div>

            </div>

            <hr>

            <div class="record-data mt-4" id="record-data-container">

                <h5>Vaccination Details</h5>

                <div class="table-container mt-2 py-2 px-md-4">
                    <table class="table mt-md-2 mb-0" id="dataTableBody">
                        <thead>
                            <tr>
                                <th scope="col" class="d-none d-lg-table-cell">#</th>
                                <th scope="col">Vaccine Type</th>
                                <th scope="col" class="d-none d-md-table-cell">Brand</th>
                                <th scope="col">Location</th>
                                <th scope="col">Date</th>
                                <th scope="col" class="d-none d-md-table-cell">Dose</th>
                                <th scope="col" class="d-none d-lg-table-cell"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('additional')

    <!-- Popup Section -->
    <div id="pop-up-container" class="d-none">

        <div class="pop-up" id="pop-up">
            <button class="close-btn" id="pop-up-close">
                <span class="material-symbols-outlined">
                    cancel
                </span>
            </button>

            <!-- ==== Display View And Editing View Goes Here -->
            <div class="content" id="pop-up-content">

            </div>
        </div>

    </div>

@endsection

@section('scripts')
    @parent
    <script src="{{ asset('js/anime/anime.min.js') }}"></script>
    <script src="{{ asset('js/patient/profileReport.js') }}"></script>
@endsection
