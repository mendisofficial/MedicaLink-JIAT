@extends('layouts.app')

@section('title','Profile Overview')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/profile-main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-overview.css') }}">
@endsection

@section('page-content')

    @parent

    <input type="hidden" value="{{ $patient->id }}" name="id" id="patientIdField">
    <!-- Basic Details -->
    <div class="col-12 col-lg-3">
        <div class="profile-main section-blur shadow">
            <div class="profile-image p-4">
                <img src="{{ $patient->profile_photo_path }}" alt="profile">
            </div>
            <h4 class="title text-center">{{ $patient->name }}</h4>

            <div class="container-fluid px-0">

                <div class="row profile-section px-4 pt-3 gx-3">
                    <div class="col-12 col-md-6 col-lg-12">
                        <h5>Basic Information</h5>

                        <div class="container-fluid px-0 pb-3">
                            <div class="row">
                                <div class="profile-group col-12">
                                    <li class="title">Date of Birth</li>
                                    <li>{{ $patient->date_of_birth }}</li>
                                </div>

                                <div class="profile-group col-6">
                                    <li class="title">Age</li>
                                    <li>{{ $patient->age }} Years</li>
                                </div>

                                <div class="profile-group col-6">
                                    <li class="title">Gender</li>
                                    <li>{{ $patient->gender }}</li>
                                </div>

                                <div class="profile-group col-12">
                                    <li class="title">Address</li>
                                    <li>{{ $patient->address }}</li>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-12">
                        <h5>Other Information</h5>

                        <div class="container-fluid px-0 pb-3">
                            <div class="row">
                                <div class="profile-group">
                                    <li class="title">Blood Group</li>
                                    <li>{{ $patient->blood_group }}</li>
                                </div>

                                <div class="profile-group col-6">
                                    <li class="title">Height</li>
                                    <li>{{ $patient->height }} m</li>
                                </div>

                                <div class="profile-group col-6">
                                    <li class="title">Weight</li>
                                    <li>{{ $patient->weight }}</li>
                                </div>

                                <div class="profile-group col-12">
                                    <li class="title">Registered By</li>
                                    <li>{{ $patient->hospital->name }}</li>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-12">
                        <button class="share-button py-2 mb-3">
                            SHARE PROFILE <i class="bi bi-share-fill ms-2"></i>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Other Sections -->
    <div class="col mt-4 mt-lg-0">
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

            <div class="record-data my-4">

                <h5>Vaccination Details</h5>

                <div class="table-container mt-2 py-2 px-md-4">
                    <div class="vaccination-table mt-2" id="dataTableBody">

                    </div>
                </div>
            </div>
        </div>

        <!-- Ad Section -->
        <div class="ad-container my-4 py-2 px-4 section-blur shadow">

            <div class="ad-text">
                <h5 class="fw-bold">Get MedicaLink on your mobile phone</h5>
                <p class="mb-0 d-none d-md-block">
                    Experience the convenience and accessibility of MedicaLink right at your fingertips.
                    Whether you're managing patient records, checking vaccination histories, or updating medical records, MedicaLink's mobile app brings all the essential features to your smartphone.
                </p>
                <button class="btn btn-primary mt-3 mt-md-4">Buy From Playstore <i
                        class="bi bi-google-play ms-2"></i>
                </button>
            </div>

            <img src="{{ asset('./images/ad-image.png') }}" alt="advertisement">
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script src="{{ asset('js/patient/profileOverview.js') }}"></script>
@endsection
