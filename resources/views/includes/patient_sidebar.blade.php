<div class="px-0 section-blur shadow-lg" id="sidebar-container">
    <div class="sidebar" id="sidebar">

        <div class="sidebar-header mb-md-4 d-none d-md-block">
            <div class="app-icon">
                <img src="{{ asset('./images/favicon.png') }}" alt="App Logo">
            </div>
        </div>
        <ul class="sidebar-list mt-3">
            <li class="sidebar-list-item {{ Route::currentRouteName() == 'patient.dashboard' ? 'active' : '' }} order-3">
                <a href="{{ route('patient.dashboard') }}">
                    <span class="material-symbols-outlined">
                        home
                    </span>
                </a>
            </li>
            <li class="sidebar-list-item order-1 {{ (Route::currentRouteName() == 'patient.search') ? 'active' : '' }}">
                <a href="{{ route('patient.search') }}">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                </a>
            </li>
        </ul>
        <div class="account-info mt-md-auto d-none d-md-flex">
            <form method="POST" action="{{ route('patient.logout') }}">
                @csrf
                <button class="account-info-picture">
                    <span class="material-symbols-outlined">logout</span>
                </button>
            </form>
        </div>
    </div>
</div>
