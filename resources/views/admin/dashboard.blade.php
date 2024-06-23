@extends('layouts.app')

@section('title','Dashboard')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('page-content')

    <!-- Statistics Section -->
    <div class="col-12" id="stats-section">
        <div class="stat-container pb-4">
            <div class="stat section-blur">
                <div class="me-5">
                    <h6>Total Number of Patients</h6>
                    <h4>{{ $totalPatients }}</h4>
                </div>
                <div class="icon">
                    <span class="material-symbols-outlined">
                        personal_injury
                    </span>
                </div>
            </div>
            <div class="stat section-blur">
                <div class="me-5">
                    <h6>Patients in Your Hospital</h6>
                    <h4>{{ $hospitalPatients }}</h4>
                </div>
                <div class="icon">
                    <span class="material-symbols-outlined">
                        personal_injury
                    </span>
                </div>
            </div>
            <div class="stat section-blur">
                <div class="me-5">
                    <h6>Patients This Month</h6>
                    <h4>{{ $hospitalPatientsThisMonth }}</h4>
                </div>
                <div class="icon">
                    <span class="material-symbols-outlined">
                        personal_injury
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Patients on admins hospital -->
    <div class="col-12" id="latest-patients">
        <div class="patients-container section-blur">
            <h4>Newly Created Accounts</h4>
            <div class="patient-list mt-2">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Patient</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Added Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($newAccounts as $account)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                <div class="patient">
                                    <img src="{{ $account->profile_photo_path }}" alt="profile-image">
                                    <div>
                                        <span class="fw-medium">NIC: {{ $account->nic }}</span>
                                        <span>{{ $account->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $account->gender }}</td>
                            <td>{{ $account->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Updates Section -->
    <div class="col-12" id="latest-updates-section">
        <div class="update-container section-blur mt-4">
            <h4>Recent Updates</h4>
            <div class="update-list mt-2">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" class="d-none d-md-table-cell">#</th>
                        <th scope="col">Profile</th>
                        <th scope="col">Updated Date</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($recentUpdates as $update)
                        <tr>
                            <th scope="row" class="d-none d-md-table-cell">{{ $loop->iteration }}</th>
                            <td>
                                <div class="patient">
                                    <img src="{{ $update->patient->profile_photo_path }}" alt="profile-image">
                                    <div>
                                        <span class="fw-medium">NIC: {{ $update->patient->nic }}</span>
                                        <span>{{ $update->patient->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $update->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($update instanceof App\Models\MedicalRecord)
                                    Medical Record
                                @elseif ($update instanceof App\Models\Vaccination)
                                    Vaccination
                                @endif
                            </td>
                            <td>
                                <p class="update-description">
                                    @if ($update instanceof App\Models\MedicalRecord)
                                        {{ Str::limit($update->description, 50) }}
                                    @elseif ($update instanceof App\Models\Vaccination)
                                        {{ Str::limit($update->description, 50) }}
                                    @endif
                                </p>
                            </td>
                            <td>
                                <a href="{{ route('admin.patientProfile', $update->patient_id) }}"><span class="material-symbols-outlined">arrow_forward</span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
