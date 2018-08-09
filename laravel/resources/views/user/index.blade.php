@extends('template.template')

@section('nav')
  @include('user.nav')
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="tile-title-w-btn">
            <h3 class="title">Data User</h3>
            <p><a class="btn btn-primary icon-btn" href="{{ action('UserController@create') }}"><i class="fa fa-plus"></i>User</a></p>
          </div>
          <table class="table table-hover table-bordered datatable">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Level</th>
                <th>Kabupaten</th>
                <th>Proses</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tabel as $item)
                <tr>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->username }}</td>
                  <td>{{ $item->level }}</td>
                  <td>{{ $item->kabupaten }}</td>
                  <td>
                    <div class="btn-group">
                      <a class="btn btn-primary" href="{{ action('UserController@edit', $item->id) }}" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></a>
                      <form method="post" id="form_hapus_{{ $item->id }}" action="{{ action('UserController@destroy', $item->id) }}">
                        @method('delete')
                        @csrf
                      <a class="btn btn-primary" href="#" onclick="hapus('{{ $item->id }}')" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$(".datatable").DataTable({
    "scrollX": true,
    "autoWidth": false,
});

function hapus(id) {
    swal({
        title: 'Apakah anda yakin?',
        text: "Data akan dihapus!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus!'
    }).then(function(result) {
        if (result.value) {
            $("#form_hapus_" + id).submit();
        }
    });
};
</script>
@endsection