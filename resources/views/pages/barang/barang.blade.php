@extends('template')
@section('title')
    MAPROD | Persediaan Bakso
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Manajement Persediaan Bakso</h1>
    <p class="mb-4">Ini adalah data manajement Persediaan Bakso.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Persediaan Bakso</h6>
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
                            <th>Ukuran Pack</th>
                            <th>Stok</th>
                            <th>Tanggal Kadaluarasa</th>
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'pack_size',
                        name: 'pack_size'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'expired_at',
                        name: 'expired_at',
                        render: function(data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                return formatDate(new Date(data));
                            }
                            return data;
                        }
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'batch_number',
                        name: 'batch_number'
                    },
                ],
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });
        });

        function formatDate(date) {
            const months = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const day = date.getDate();
            const month = months[date.getMonth()];
            const year = date.getFullYear();

            return `${day} ${month} ${year}`;
        }
    </script>
@endsection
