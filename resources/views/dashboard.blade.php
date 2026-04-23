<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
    <p>Kamu berhasil login dengan email: {{ Auth::user()->email }}</p>

    <hr>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>