<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>


<div id="app" class="container">
    @yield('content')
</div>
<img style="width: 300px; margin-top: 60px;" src="{{asset('images/kveto.jpg')}}" class="kveto">

</body>
<script src="{{ asset('js/app.js') }}"></script>
</html>
