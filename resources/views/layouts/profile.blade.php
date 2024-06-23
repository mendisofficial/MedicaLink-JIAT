@extends('layouts.app')

@section('title','Dashboard')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/profile-main.css') }}">
@endsection

@section('page-content')

    <div class="col-12">

        <div class="profile-nav mb-4" id="profile-nav">

            <a href="{{ route('admin.patientProfile',['id' => $patient->id]) }}" class="nav-link {{ Route::currentRouteName() == 'admin.patientProfile' ? 'active' : '' }}">Overview</a>

            <a href="{{ route('admin.patientProfileReports',['id' => $patient->id]) }}" class="nav-link {{ Route::currentRouteName() == 'admin.patientProfileReports' ? 'active' : '' }}">Reports</a>

        </div>

    </div>

@endsection
