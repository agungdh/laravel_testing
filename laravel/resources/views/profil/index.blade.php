@extends('template.template')

@section('nav')
  @include('profil.nav')
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Profil</h3>
      <div class="tile-body">
        <form method="post" action="{{ action('ProfilController@ubah') }}" enctype="multipart/form-data" id="form_ubah">
          @method('put')
          @csrf

          <div class="form-group">
            <label class="control-label">Username</label>
            <input class="form-control" disabled type="text" value="{{ $user->username }}" required placeholder="Masukan Username" name="username">
          </div>

          <div class="form-group">
            <label class="control-label">Nama</label>
            <input class="form-control" type="text" value="{{ $user->nama }}" required placeholder="Masukan Nama" name="nama">
          </div>

          <div class="form-group">
            <label class="control-label">Foto</label>
            <input class="form-control" type="file" name="foto">
          </div>

          </div>
          <div class="tile-footer">
            <button id="simpan" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="{{ action('WelcomeController@index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" style="visibility: hidden;">
          </div>
        </form>
    </div>

    <div class="tile">
      <h3 class="tile-title">Ubah Password</h3>
      <div class="tile-body">
        <form method="post" action="{{ action('ProfilController@gantiPassword') }}" enctype="multipart/form-data" id="form_ubah_password">
          @method('put')
          @csrf

          <div class="form-group">
            <label class="control-label">Password</label>
            <input class="form-control" type="password" required placeholder="Masukan Password" name="password" id="password1">
          </div>

          <div class="form-group">
            <label class="control-label">Password Lagi</label>
            <input class="form-control" type="password" required placeholder="Masukan Password Lagi" id="password2">
          </div>

          </div>
          <div class="tile-footer">
            <button id="ganti" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Ubah Password</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="{{ action('WelcomeController@index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" style="visibility: hidden;">
          </div>
        </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$('#simpan').click(function(){
  $("#form_ubah").submit();
});

$('#ubah').click(function(){
  $("#form_ubah_password").submit();
});

$('#form_ubah_password').submit(function() {
  if ($("#password1").val() != $("#password2").val()) {
    swal("Error !!!", "Password Tidak Sama !!!", "error");
    return false;
  } else {
    $("#form_ubah_password").submit();      
  }
});
</script>
@endsection