<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>


<div class="container">
    @yield('content')
</div>
<img style="width: 300px; margin-top: 60px;" src="{{asset('images/kveto.jpg')}}" class="kveto">

</body>
</html>
