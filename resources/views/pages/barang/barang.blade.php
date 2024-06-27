@extends('template')
@section('title')
    MAPROD | Data Manajement Bakso
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Manajement Bakso</h1>
    <p class="mb-4">Ini adalah data manajement Bakso.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Manajement Bakso</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered global-table" id="tableBarang" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%"><a href="javascript:void(0);" class="btn btn-primary btn-circle add-modal"
                                    data-jenis="barang" data-url="{{ route('modal') }}"><i class="fa fa-plus"></i></a></th>
                            <th>Nama</th>
                            <th>Jenis Pack</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Batch</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                @component('components.modal')
                    @slot('id_modal', 'myModal')
                    @slot('id_form', 'form')
                    @slot('size_modal', 'modal_size')
                    @slot('title_modal', 'modal_title')
                    @slot('body_modal', 'modal_body')
                    @slot('footer_modal', 'modal_footer')
                @endcomponent

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#tableBarang').DataTable({
                ordering: false,
                responsive: true,
                processing: true,
                serverSide: true,
                saveState: true,
                ajax: '{{ route('tableBarang') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'actions',
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jenis_pack',
                        name: 'jenis_pack'
                    },
                    {
                        data: 'jumlah_stok',
                        name: 'jumlah_stok'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'batch',
                        name: 'batch'
                    },
                ],
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
@endsection
