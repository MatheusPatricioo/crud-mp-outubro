<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ url('assets/css/admin.template.css') }}">
    <title>@yield('title')</title>
</head>
<body>
    <nav>
        <div class="va--top">
            <a href="{{url('/admin')}}">
                <img src="{{url('assets/images/pages.png')}}" width="28" />
            </a>
        </div>

        <div class="nav--button">
            <a href="{{url('/admin/logout')}}">
                <img src="{{url('assets/images/logout.png')}}" width="28" />
            </a>
        </div>
    </nav>
    <section class="container">
        @yield('content')

    </section>

</body>
</html>
