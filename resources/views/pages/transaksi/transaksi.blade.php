@extends('template')
@section('title')
    MAPROD | List Transaksi
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">List Transaksi</h1>
    <p class="mb-4">Ini adalah List Transaksi.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered global-table" id="tablelistTransaction" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Batch</th>
                            <th>Tanggal</th>
                            <th>Jumlah Stok</th>
                            <th>Tipe Transaksi</th>
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
            $('#tablelistTransaction').DataTable({
                ordering: false,
                responsive: true,
                processing: true,
                serverSide: true,
                saveState: true,
                ajax: '{{ route('tablelistTransaction') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'batch_number',
                        name: 'batch_number'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'transaction_type',
                        name: 'transaction_type'
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
