<!DOCTYPE html>
<html>
<head>
    <title>Patient Profile</title>
</head>
<body>
<h2>Welcome, {{ $patient->name }}</h2>
<p>Name: {{ $patient->name }}</p>
<p>NIC: {{ $patient->nic }}</p>
<p>Gender: {{ $patient->gender }}</p>
<p>Blood Group: {{ $patient->blood_group }}</p>
<p>Height: {{ $patient->height }} cm</p>
<p>Weight: {{ $patient->weight }} kg</p>
<p>Date of Birth: {{ $patient->dob }}</p>
<p>Contact Number: {{ $patient->contact_number }}</p>
<p>Hospital: {{ $patient->hospital->name }}</p>

<h3>Vaccination History</h3>
<table>
    <thead>
    <tr>
        <th>Vaccine Name</th>
        <th>Brand</th>
        <th>Date Administered</th>
        <th>Hospital</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($vaccinations as $vaccination)
        <tr>
            <td>{{ $vaccination->vaccineBrand->vaccine_name ?? 'error vaccine name' }}</td>
            <td>{{ $vaccination->vaccineBrand->brand_name ?? 'error vaccine brand' }}</td>
            <td>{{ $vaccination->date_administered ?? 'error date' }}</td>
            <td>{{ $vaccination->hospital->name ?? 'error hospital name' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h3>Medical Records</h3>
<table>
    <thead>
    <tr>
        <th>Record Type</th>
        <th>Description</th>
        <th>Date Created</th>
        <th>Hospital</th>
        <th>File</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($medicalRecords as $record)
        <tr>
            <td>{{ $record->record_type }}</td>
            <td>{{ $record->description }}</td>
            <td>{{ $record->created_at }}</td>
            <td>{{ $record->hospital->name }}</td>
{{--            <td><a href="{{ asset('storage/medical_records/' . $record->file_path) }}" target="_blank">View File</a></td>--}}
            <td><a href="{{ $record->file_path }}" target="_blank">View File</a></td>
        </tr>
    @endforeach
    </tbody>
</table>

<form method="POST" action="{{ route('patient.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
</body>
</html>
