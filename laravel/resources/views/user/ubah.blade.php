@extends('template.template')

@section('nav')
  @include('user.nav')
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Ubah User</h3>
      <div class="tile-body">
        <form method="post" action="{{ action('UserController@update', $user->id) }}" id="form_user">
          @method('put')
          @csrf

          <div class="form-group">
            <label class="control-label">Nama</label>
            <input class="form-control" type="text" required placeholder="Masukan Nama" name="data[nama]" value="{{ $user->nama }}">
          </div>

          <div class="form-group">
            <label class="control-label">Username</label>
            <input class="form-control" type="text" required placeholder="Masukan Username" name="data[username]" value="{{ $user->username }}">
          </div>
          
          <div class="form-group">
            <label class="control-label">Level</label>
            <select class="form-control select2" required name="data[level]" id="level">
              <option {{ $user->level == 'a' ? 'selected' : null }} value="a">Administrator</option>
              <option {{ $user->level == 'k' ? 'selected' : null }} value="k">Kabupaten</option>
            </select>
          </div>
          
          <div class="form-group">
            <label class="control-label">Kabupaten</label>
            <select class="form-control select2" name="data[kab_id]" id="kab_id">
              @foreach($kabupaten as $item)
              <option {{ $user->kab_id == $item->id ? 'selected' : null }} value="{{ $item->id }}">{{ ucwords(strtolower($item->nama_kab)) }}</option>
              @endforeach
            </select>
          </div>

          </div>
          <div class="tile-footer">
            <button id="simpan" class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Simpan</button>
            &nbsp;&nbsp;&nbsp;
            <a class="btn btn-secondary" href="{{ action('UserController@index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a> <input type="submit" style="visibility: hidden;">
          </div>
        </form>
    </div>

    <div class="tile">
      <h3 class="tile-title">Ubah Password</h3>
      <div class="tile-body">
        <form method="post" action="{{ action('UserController@gantiPassword', $user->id) }}" enctype="multipart/form-data" id="form_ubah_password">
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
cek();

$("#level").change(function() {
  cek();
});

function cek() {
  if ($("#level").val() == 'a') {
    $("#kab_id").prop("disabled", true);
  } else {
    $("#kab_id").prop("disabled", false);
  }
}

$('#simpan').click(function(){
  $("#form_user").submit();
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

$('.select2').select2();
</script>
@endsection