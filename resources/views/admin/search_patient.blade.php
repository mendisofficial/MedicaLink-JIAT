@extends('layouts.app')

@section('title','Dashboard')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/searchBar.css') }}">
@endsection

@section('page-content')

    <!-- Search Section -->
    <div class="col-12">
        <div id="search-controls-section" class="mb-4 py-2 px-3 section-blur">
            <form action="{{ route('admin.searchPatientForm') }}" method="GET">
                <div class="search-controls d-flex align-items-center">
                    <button class="fs-5">
                        <i class="bi bi-search"></i>
                    </button>
                    <input type="text" class="search-bar" name="query" value="{{ $query }}" placeholder="Search for patients... (Default search method is NIC)">
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
                                    <input type="radio" id="type1" name="type" value="nic" class="radio" {{ $type == 'nic' ? 'checked' : '' }}>
                                    <label for="type1"># NIC</label>
                                </li>
                                <li class="category">
                                    <input type="radio" id="type2" name="type" value="name" class="radio" {{ $type == 'name' ? 'checked' : '' }}>
                                    <label for="type2"># Patient Name</label>
                                </li>
                                <li class="category">
                                    <input type="radio" id="type3" name="type" value="hospital" class="radio" {{ $type == 'hospital' ? 'checked' : '' }}>
                                    <label for="type3"># Registered Hospital</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Result Section -->
    <div class="col-12">
        <div id="search-result-section" class="section-blur">
            <div class="d-flex align-items-center">
                <h4 class="mb-0">Patient Details</h4>
                <span class="ms-auto">Showing {{ count($patients) }} results</span>
            </div>
            <hr>
            <div class="patient-list">
                @if (count($patients) > 0)
                    @foreach ($patients as $patient)
                    <div class="patient">
                        <img src="{{ $patient->profile_photo_path }}" alt="profile-image">
                        <div class="info">
                            <span class="highlight">NIC: {{ $patient->nic }}</span>
                            <span>Name: {{ $patient->name }}</span>
                        </div>
                        <div class="info temp">
                            <span>Registered Hospital: {{ $patient->hospital->name }}</span>
                            <span>Registered Date: {{ $patient->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="info temp">
                            <span>Gender: {{ $patient->gender }}</span>
                            <span>Blood Group: {{ $patient->blood_group }}</span>
                        </div>
                        <a class="view-btn d-none d-md-flex" href="{{ route('admin.patientProfile', ['id' => $patient->id]) }}">
                            <span class="me-2">View Profile</span>
                            <span class="material-symbols-outlined">
                                visibility
                            </span>
                        </a>
                    </div>
                    @endforeach
                @else
                    <p class="text-center my-4">No results were found...</p>
                @endif
            </div>
        </div>
    </div>

@endsection
