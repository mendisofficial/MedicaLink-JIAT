<!DOCTYPE html>
<html>
<head>
    <title>MedicaLink</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<h1>Welcome to the MedicaLink System</h1>
<h2>Patient</h2>
<a href="{{ route('patient.login') }}">Patient Login</a><br>
<h2>Admin</h2>
<a href="{{ route('admin.login') }}">Admin Login</a><br>
</body>
</html>
