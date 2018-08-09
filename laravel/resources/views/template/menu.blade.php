<li><a class="app-menu__item" href="{{ action('WelcomeController@index') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

@if(session('level') == 'a')
<li><a class="app-menu__item" href="{{ action('KluiController@index') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">KLUI</span></a></li>
@endif

<li><a class="app-menu__item" href="{{ action('PerusahaanController@index') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Perusahaan</span></a></li>

@if(session('level') == 'a')
<li><a class="app-menu__item" href="{{ action('UserController@index') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">User</span></a></li>
@endif

@if(session('level') == 'a')
<li><a class="app-menu__item" href="{{ action('ConfigController@index') }}"><i class="app-menu__icon fa fa-gears"></i><span class="app-menu__label">Config</span></a></li>
@endif