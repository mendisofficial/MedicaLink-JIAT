<div class="px-0 section-blur shadow-lg" id="sidebar-container">
    <div class="sidebar" id="sidebar">

        <div class="sidebar-header mb-md-4 d-none d-md-block">
            <div class="app-icon">
                <img src="{{ asset('./images/favicon.png') }}" alt="App Logo">
            </div>
        </div>
        <ul class="sidebar-list mt-3">
            <li class="sidebar-list-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }} order-3">
                <a href="{{ route('admin.dashboard') }}">
                    <span class="material-symbols-outlined">
                        home
                    </span>
                </a>
            </li>
            <li class="sidebar-list-item order-1 {{ (Route::currentRouteName() == 'admin.searchPatientForm') ? 'active' : '' }}">
                <a href="{{ route('admin.searchPatientForm') }}">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                </a>
            </li>
            <li class="sidebar-list-item order-2 {{ (Route::currentRouteName() == 'admin.managePatients' || Route::currentRouteName() == 'admin.addPatientForm') ? 'active' : '' }}">
                <a href="{{ route('admin.managePatients') }}">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                </a>
            </li>
        </ul>
        <div class="account-info mt-md-auto d-none d-md-flex">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="account-info-picture">
                    <span class="material-symbols-outlined">logout</span>
                </button>
            </form>
        </div>
    </div>
</div>
