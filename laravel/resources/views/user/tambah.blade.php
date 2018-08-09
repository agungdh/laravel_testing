@extends('template.template')

@section('nav')
  @include('user.nav')
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Tambah User</h3>
      <div class="tile-body">
        <form method="post" action="{{ action('UserController@store') }}">
          @csrf

          <div class="form-group">
            <label class="control-label">Nama</label>
            <input class="form-control" type="text" required placeholder="Masukan Nama" name="data[nama]">
          </div>

          <div class="form-group">
            <label class="control-label">Username</label>
            <input class="form-control" type="text" required placeholder="Masukan Username" name="data[username]">
          </div>
          
          <div class="form-group">
            <label class="control-label">Password</label>
            <input class="form-control" type="password" required placeholder="Masukan Password" name="data[password]">
          </div>

          <div class="form-group">
            <label class="control-label">Level</label>
            <select class="form-control select2" required name="data[level]" id="level">
              <option value="a">Administrator</option>
              <option value="k">Kabupaten</option>
            </select>
          </div>
          
          <div class="form-group">
            <label class="control-label">Kabupaten</label>
            <select class="form-control select2" name="data[kab_id]" id="kab_id">
              @foreach($kabupaten as $item)
              <option value="{{ $item->id }}">{{ ucwords(strtolower($item->nama_kab)) }}</option>
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
  $("input[type='submit']").click();
});

$('.select2').select2();
</script>
@endsection