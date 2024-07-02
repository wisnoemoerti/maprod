@extends('template')
@section('title')
    MAPROD | Data Manajement Penjualan
@endsection
@section('content')
    <h1 class="h3 mb-2 text-gray-800">Data Manajement Penjualan</h1>
    <p class="mb-4">Ini adalah data manajement Penjualan.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Manajement Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered global-table" id="tablePenjualan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            <th width="12%"></a></th>
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
            $('#tablePenjualan').DataTable({
                ordering: false,
                responsive: true,
                processing: true,
                serverSide: true,
                saveState: true,
                ajax: '{{ route('tablePenjualan') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },
                    {
                        data: 'buyer_name',
                        name: 'buyer_name'
                    },
                    {
                        data: 'total_payment',
                        name: 'total_payment'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'actions',
                        searchable: false
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

        $('#tablePenjualan').on('click', '.info-modal', function(event) {
            removeClassModal();
            showLoading();
            url = $(this).data('url');
            jenis = $(this).data('jenis');
            id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    jenis: jenis,
                    id: id,
                },
                success: function(data) {
                    hideLoading();
                    console.log(data);
                    $('#myModal').modal('show');
                    $('#modal_title').html(data.modal_title);
                    $('#modal_body').html(data.modal_body);
                    $('#modal_footer').html(data.modal_footer);
                    $('#modal_size').addClass(data.modal_size);
                },
                error: function(response) {
                    console.log(response);
                    hideLoading();
                    swal({
                        icon: 'error',
                        text: 'Gagal Membuka modal.',
                        title: 'Maaf',
                    });
                },
            });
        });
    </script>
@endsection
