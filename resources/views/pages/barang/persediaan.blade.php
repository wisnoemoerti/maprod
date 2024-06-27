@extends('template')
@section('title')
	MAPROD | Data Persediaan Bahan
@endsection
@section('content')

<!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Persediaan Bahan</h1>
  <p class="mb-4">Anda dapat menambah, menghapus, mengubah, dan menambah stok persediaan bahan.</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Persediaan Bahan</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered global-table" id="tablePersediaan" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>Nama</th>
              <th>Stok</th>
              <th width="15%"><a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Tambah Persediaan" class="btn btn-primary btn-circle add-modal" data-jenis="persediaan" data-url="{{route('modal')}}"><i class="fa fa-plus"></i></a></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>

        @component('components.modal')
        @slot('id_modal','myModal')
        @slot('id_form','form')
        @slot('size_modal','modal_size')
        @slot('title_modal','modal_title')
        @slot('body_modal','modal_body')
        @slot('footer_modal','modal_footer')
        @endcomponent
        
      </div>
    </div>
  </div>
@endsection
@section('js')
<script>
  $(document).ready(function() {
    $('#tablePersediaan').DataTable({
      ordering: false,
      responsive: true,
      processing: true,
      serverSide: true,
      saveState: true,
      ajax: '{{ route('tablePersediaan') }}',
      columns: [
          { data: 'DT_RowIndex', searchable: false },
          { data: 'nama', name: 'nama' },
          { data: 'jumlah_stok', name: 'jumlah_stok' },
          { data: 'actions', searchable: false },
      ],
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      }
    });

    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
  });
</script>
@endsection