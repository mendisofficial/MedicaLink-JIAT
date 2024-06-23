@extends('layouts.base')

@section('title','Patient Login')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    @parent
@endsection

@section('content')

    <section id="main" class="py-0">

        <div id="login-container" class="container-fluid">

            <form class="section-blur" method="POST" action="/patient/login" id="login-form">

                @csrf
                <div class="logo">
                    <img src="{{ asset('images/logo-main.png') }}" alt="logo">
                    <p class="text-center mt-4 mb-md-1 fw-medium">Login to your account to continue....</p>
                </div>

                <div class="username input">
                    <span class="material-symbols-outlined">
                        person
                    </span>
                    <input type="text" id="usernameInput" placeholder="NIC" name="nic" autofocus>
                </div>
                <label for="usernameInput" class="text-danger" id="usernameLabel"></label>

                <div class="password input">
                    <span class="material-symbols-outlined">
                        key
                    </span>
                    <input type="password"  name="password" id="passwordInput" placeholder="Password">
                </div>
                <label for="usernameInput" class="text-danger" id="passwordLabel"></label>

                <div class="sign-in-btn mt-5">
                    <button id="login-btn">
                        <span class="me-3">
                            Sign In
                        </span>
                        <span class="material-symbols-outlined">
                            login
                        </span>
                    </button>
                </div>
            </form>

        </div>

        <div id="shape1" class="shape">

        </div>

        <div id="shape2" class="shape">

        </div>

    </section>

@endsection

@section('scripts')
    <script src="{{ asset('js/patient/login.js') }}"></script>
@endsection
