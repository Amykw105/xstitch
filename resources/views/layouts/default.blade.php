<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('/css/app.css')}}" rel="stylesheet" type="text/css">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
      <div class="site_header">
        <nav class="header-nav">
            <div class="container">


                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    <!-- user/logout -->
                    {{ Auth::user()->name }}
                        <a href="{{ url('/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

            </div>
        </nav>
      </div>
      <div class="fixed-footer-nav">
        <nav class="action-nav">
          <ul class="nav">
              <li>Activity Feed</li>
              <li>New Status</li>
              <li>My Projects</li>
          </ul>
        </nav>
      </div>


        <div class="container main-wrapper">
          <div class="content_wrapper">
            @section('sidebar')
                @include('components.sidebar')
            @show
            <div class="main_content">
              @yield('content')
            </div>
          </div>
        </div>




    </div> <!-- end of #app -->


    <!-- Scripts -->
    <script src="{{ mix('/js/app.js')}}"></script>
</body>
</html>
