@extends('layouts.app')

@section('title','Dashboard')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/registerpatient.css') }}">
@endsection

@section('page-content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Patient Form -->
    <div class="col-12">

        <div id="patient-form" class="section-blur">

            <h4>Patient Registration Form</h4>

            <form class="patient-form mt-3" method="POST" action="{{ route('admin.storePatient') }}" enctype="multipart/form-data">
                @csrf

                <h6>Basic Information</h6>

                <div class="row g-3 mb-4">

                    <div class="col-12">
                        <label for="nic" class="form-label">NIC :</label>
                        <input type="text" class="form-control" id="nic" name="nic">
                    </div>

                    <div class="col-12">
                        <label for="name" class="form-label">Patient Full Name :</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="col-md-6">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="date_of_birth">
                    </div>

                    <div class="col-6">
                        <label for="gender" class="form-label">Gender :</label>
                        <div class="d-flex">

                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" id="gridCheck" name="gender" value="male">
                                <label class="form-check-label" for="gridCheck">
                                    Male
                                </label>
                            </div>

                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" id="gridCheck2" name="gender" value="female">
                                <label class="form-check-label" for="gridCheck2">
                                    Female
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="gridCheck3" name="gender" value="other">
                                <label class="form-check-label" for="gridCheck3">
                                    Other
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" class="form-control"></textarea>
                    </div>

                </div>

                <h6>Other Information</h6>

                <div class="row g-3">

                    <div class="col-md-4">
                        <label for="bloodGroup" class="form-label">Blood Group</label>
                        <select id="bloodGroup" name="blood_group" class="form-select">
                            <option selected>Choose...</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="height" class="form-label">Height :</label>
                        <input type="number" class="form-control" id="height" name="height">
                    </div>

                    <div class="col-md-4">
                        <label for="weight" class="form-label">Weight :</label>
                        <input type="number" class="form-control" id="weight" name="weight">
                    </div>

                    <div class="col-12">
                        <label for="contact_number" class="form-label">Contact Number :</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number">
                    </div>

                    <div class="col-12">
                        <label for="file" class="form-label">Profile Picture:</label>
                        <input type="file" class="form-control" id="file" name="file">
                    </div>

                    <div class="col-12 controls">
                        <button type="submit" id="register-btn" class="my-3 me-2">
                            <span class="me-2 text-nowrap">Register Patient</span>
                            <span class="material-symbols-outlined">
                                how_to_reg
                            </span>
                        </button>

                        <button type="button" id="cancel-btn">
                            <span class="me-2">Cancel</span>
                            <span class="material-symbols-outlined">
                                cancel
                            </span>
                        </button>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection
