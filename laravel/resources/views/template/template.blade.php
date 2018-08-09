@php
$config = DB::table('config')->first();
@endphp

@php ($now = date('YmdHis'))
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/EasyAutocomplete-1.3.5/easy-autocomplete.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/EasyAutocomplete-1.3.5/easy-autocomplete.themes.min.css') }}">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>{{ $config->judul_aplikasi }}</title>

    <!-- Favicon -->
    @if (file_exists('uploads/favicon'))
      @php ($favicon = 'uploads/favicon')
    @else
      @php ($favicon = 'assets/favicon.png')
    @endif

    <link rel="shortcut icon" href="{{ asset($favicon) }}?time={{ $now }}"/>
  </head>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{ url('/') }}">{{ $config->judul_menu }}</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="{{ action('ProfilController@index') }}"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            <li><a class="dropdown-item" href="{{ action('WelcomeController@logout') }}"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <!-- User Image -->
      @if (file_exists('uploads/favicon' . session('id')))
        @php ($favicon = 'uploads/favicon')
      @else
        @php ($favicon = 'assets/favicon.png')
      @endif
      @if (file_exists('uploads/userimage/' . session('id')))
        @php ($userimage = 'uploads/userimage/' . session('id'))
      @else
        @php ($userimage = 'assets/user.png')
      @endif

      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset($userimage) . '?time=' . $now }}" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">{{ session('nama') }}</p>
          <p class="app-sidebar__user-designation">{{ session('username') }}</p>
        </div>
      </div>
      <ul class="app-menu">
        @include('template.menu')
      </ul>
    </aside>
    <main class="app-content">
      @yield('nav')
      @yield('content')
    </main>
    <!-- Start JS -->
    <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('assets/js/plugins/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/bootstrap-notify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/chart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/jquery.vmap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/jquery.vmap.sampledata.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/jquery.vmap.world.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/jquery-ui.custom.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bower_components/numeral/min/numeral.min.js') }}"></script>
    <!-- End JS -->

    <!-- JS Manual -->
    @yield('js')

  </body>
</html>