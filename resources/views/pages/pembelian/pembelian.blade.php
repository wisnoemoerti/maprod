@extends('template')
@section('title')
	MAPROD | Data Manajement Pembelian
@endsection
@section('content')

<!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Data Manajement Pembelian</h1>
  <p class="mb-4">Ini adalah data manajement Pembelian.</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Manajement Pembelian</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered global-table" id="tablePembelian" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>Nama</th>
              <th>Harga</th>
              <th>Tanggal</th>
              <th width="12%"><a href="javascript:void(0);" class="btn btn-primary btn-circle add-modal" data-jenis="pembelian" data-url="{{route('modal')}}"><i class="fa fa-plus"></i></a></th>
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
    $('#tablePembelian').DataTable({
      ordering: false,
      responsive: true,
      processing: true,
      serverSide: true,
      saveState: true,
      ajax: '{{ route('tablePembelian') }}',
      columns: [
          { data: 'DT_RowIndex', searchable: false },
          { data: 'nama', name: 'nama' },
          { data: 'harga', name: 'harga' },
          { data: 'tanggal', name: 'tanggal' },
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