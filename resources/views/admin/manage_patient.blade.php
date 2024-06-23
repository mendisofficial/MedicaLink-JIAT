@extends('layouts.app')

@section('title','Dashboard')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/patient.css') }}">
    <link rel="stylesheet" href="{{ asset('css/searchBar.css') }}">
@endsection

@section('page-content')

    <!-- Search Section -->
    <div class="col-12">

        <div id="search-controls-section" class="mb-4 py-2 px-3 section-blur">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.managePatients') }}" method="GET">
                <div class="search-controls d-flex align-items-center">
                    <button class="fs-5">
                        <i class="bi bi-search"></i>
                    </button>
                    <!-- <div class="vr mx-2"></div> -->
                    <input type="text" class="search-bar" name="query" value="{{ $query }}" placeholder="Search for patients...">
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
                                    <input type="radio" id="type1" name="type" value="nic" class="radio" {{ $type == 'nic'? 'checked' : '' }}>
                                    <label for="type1"># Reference Number</label>
                                </li>
                                <li class="category">
                                    <input type="radio" id="type2" name="type" value="name" class="radio" {{ $type == 'name'? 'checked' : '' }}>
                                    <label for="type2"># Patient Name</label>
                                </li>
                                <li class="category">
                                    <input type="radio" id="type3" name="type" value="hospital" class="radio" {{ $type == 'hospital'? 'checked' : '' }}>
                                    <label for="type3"># Registered Hospital</label>
                                </li>
                            </ul>
                        </div>

                        <div class="col date-controls mb-3">
                            <div class="control mb-2">
                                <h6 class="me-2">Select Start Date: </h6>
                                <input type="date">
                            </div>
                            <div class="control">
                                <h6 class="me-2">Select End Date: </h6>
                                <input type="date">
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <!-- Patient List Section -->
    <div class="col-12">

        <div id="search-result-section" class="section-blur">

            <div class="d-flex align-items-center">
                <h4 class="mb-0">Your Patients</h4>
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-2 me-md-3 text-nowrap">Showing {{ count($patients) }} results</span>
                    <a class="add-btn" href="{{ route('admin.addPatientForm') }}">
                        <span class="me-2 d-none d-md-block">Add Patient</span>
                        <span class="material-symbols-outlined">
                            person_add
                        </span>
                    </a>
                </div>
            </div>

            <hr>

            <div class="patient-list">

                @if (count($patients) > 0)
                    @foreach ($patients as $patient)

                    <div class="patient">

                        <img src="{{ $patient->profile_photo_path }}" alt="profile-image">

                        <div class="info">
                            <span class="highlight">Reference No: {{ $patient->nic }}</span>
                            <span>Name: {{ $patient->name }}</span>
                        </div>

                        <div class="info temp">
                            <span>Registered Hospital: {{ $patient->hospital->name }}</span>
                            <span>Registered Date: {{ $patient->created_at->format('d/m/Y') }}</span>
                        </div>

                        <div class="info temp">
                            <span>Last Updated Date: {{ $patient->updated_at->format('d/m/Y') }}</span>
                            <span>First Updated Date: {{ $patient->created_at->format('d/m/Y') }}</span>
                        </div>

                        <div class="controls">
                            <a href="{{ route('admin.patientProfile', ['id' => $patient->id]) }}">
                                <button class="edit mb-2 mb-md-0 me-md-2">
                                    <span class="material-symbols-outlined">
                                        edit_square
                                    </span>
                                </button>
                            </a>
                            <form action="{{ route('admin.deletePatient', ['id' => $patient->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="delete" type="submit">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>

                    @endforeach
                @else
                    <p class="text-center my-4">No results were found...</p>
                @endif

            </div>
        </div>

    </div>

@endsection
