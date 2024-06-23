@extends('layouts.base')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    @parent
@endsection

@section('content')

    <section id="main" class="py-0">
        <div id="main-container" class="container-fluid px-md-4 pt-4 pb-1 pb-md-4">

            <div class="working-container section-blur">
                
                <div class="anime">

                    <img src="./assets/img/app/under-construction.gif" alt="animation">

                    <div class="desc">

                        <h3>Page Under Construction</h3>

                        <p class="mt-4">
                            This feature is not yet supported. We are currently working on it. 
                            For more updates about all the latest features and services please visit our website.
                        </p>

                        <a href="" class="shadow mt-3">
                            <span class="me-2">Visit MedicaLink.co</span>
                            <span class="material-symbols-outlined">
                                arrow_right_alt
                            </span>
                        </a>
                    </div>

                </div>

            </div>

        </div>

        @if (Session::get('guard') == 'admin')
            @include('includes.admin_sidebar')
        @else
            @include('includes.patient_sidebar')
        @endif
    </section>

@endsection

@yield('additional')

@section('script')
    <script src="{{ asset('js/sidebar.js') }}"></script>
    @parent
@endsection