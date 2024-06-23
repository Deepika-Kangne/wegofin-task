<!DOCTYPE html>
@include('header')
<html>
<head>
    <title>Dashboard</title>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src=  "{{ asset('js/dashboard.js') }}" ></script>
     <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div id="navbar">
        <div><h1>Welcome to your dashboard!</h1></div>
        <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="border: 5px;border-color: black !important;background: red;">Logout</button>
        </form>
    </div>
    <div >
      <b><p>Get Emi Details for each loan :</p></b>
      <button type="button" class="fadeIn fourth" id="processData">Process Data</button>
      <div id="tableContainer" style="display: none;"></div>
    </div>
</body>
</html>
