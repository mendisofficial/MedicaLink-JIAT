@extends('layouts.base')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endsection

@section('content')

    <section id="main" class="py-0">
        <div id="main-container" class="container-fluid px-md-4 pt-4 pb-1 pb-md-4">
            <div class="row p-0">

                @yield('page-content')

            </div>
        </div>

        @if (session('guard') == 'admin')
            @include('includes.admin_sidebar')
        @else
            @include('includes.patient_sidebar')
        @endif
    </section>

@endsection

@section('additional')
@endsection

@section('script')
    @parent
    <script src="{{ asset('js/sidebar.js') }}"></script>
@endsection