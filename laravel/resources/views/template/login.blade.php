@php
$config = DB::table('config')->first();
@endphp

@php ($now = date('YmdHis'))

@php($flashdata = session('flashdata'))

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
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
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>{{ $config->judul_aplikasi }}</h1>
      </div>
      <div class="login-box">
        <form class="login-form" method="post" action="{{ action('WelcomeController@login') }}">
          @csrf
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
          <div class="form-group">
            <label class="control-label">USERNAME</label>
            <input class="form-control" type="text" required name="username" placeholder="Username" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" required name="password" placeholder="Password">
          </div>
          <br>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset("assets/js/jquery-3.2.1.min.js") }}"></script>
    <script src="{{ asset("assets/js/popper.min.js") }}"></script>
    <script src="{{ asset("assets/js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("assets/js/main.js") }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset("assets/js/plugins/pace.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>

    <script type="text/javascript">
      $('form').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
          url: "{{ action('WelcomeController@login') }}",
          type: 'post',
          data: $('form').serialize(),
          success: function(respone){ 
            respon = JSON.parse(respone);

            if (respon.login == true) {
              window.location = "{{ action('WelcomeController@index') }}";
            } else {
              swal(respon.header, respon.pesan, respon.status);
            }
          },
          error: function(respone){
            console.log(respone);
          }
        });
      });
    </script>

  </body>
</html>
