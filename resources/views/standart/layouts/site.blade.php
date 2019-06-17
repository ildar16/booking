<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title or 'Booking' }}</title>
    <meta charset="utf-8">

    <meta name="description" content="{{ $meta_desc or 'Book apartment for your vacation.' }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {{--CSS--}}
    <link rel="stylesheet" type="text/css" href="{{ asset(config('settings.theme') . '/css/reset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(config('settings.theme') . '/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(config('settings.theme') . '/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(config('settings.theme') . '/css/bootstrap-datepicker3.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(config('settings.theme') . '/css/bootstrap-slider.min.css') }}">
    {{--JS--}}
    <script type="text/javascript" src="{{ asset(config('settings.theme') . '/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset(config('settings.theme') . '/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset(config('settings.theme') . '/js/bootstrap-datepicker.ru.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset(config('settings.theme') . '/js/bootstrap-notify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset(config('settings.theme') . '/js/bootstrap-slider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset(config('settings.theme') . '/js/main.js') }}"></script>
</head>
<body>

<section class="hero">

    <header>
        <div class="wrapper">
            <a href="/"><img src="{{ asset(config('settings.theme') . '/img/logo.png') }}" class="logo" alt="" titl=""/></a>
            <a href="/" class="hamburger"></a>
            <nav>
                @yield('navigation')

                @if (Route::has('login'))
                    @auth
                    <a class="login_btn" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }} ({{ Auth::user()->name }})
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="{{ url('/cabinet') }}" class="login_btn">Cabinet</a>
                    <a href="{{ url('/cabinet/book') }}" class="login_btn">My Books</a>
                @else
                    <a href="{{ route('register') }}" class="login_btn">Register</a>
                    <a href="{{ route('login') }}" class="login_btn">Login</a>
                    @endauth

                @endif

            </nav>
        </div>
    </header>

</section>

@yield('search')

@yield('content')

@yield('footer')

<script>

    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            $.notify({
                message: "{{ $error }}"
            }, {
                type: 'danger'
            });
        @endforeach
    @endif

    @if(session('status'))
        $.notify({
            title: "{{ session('status') }}",
            message: "Please check you e-mail and cabinet"
        }, {
            type: 'success'
        });
    @endif

    @if(session('error'))
        $.notify({
            message: "{{ session('error') }}"
        }, {
            type: 'danger'
        });
    @endif

    @if(session('warning'))
        $.notify({
            message: "{{ session('warning') }}"
        }, {
            type: 'warning'
        });
    @endif

</script>
</body>
</html>