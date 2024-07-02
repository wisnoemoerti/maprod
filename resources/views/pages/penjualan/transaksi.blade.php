@extends('template')
@section('title')
    MAPROD | Transaksi Penjualan
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6" style="overflow-y:scroll; overflow-x:hidden; height:700px;">
            <div class="row" id="list-barang">
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transaksi Penjualan</h6>
                </div>
                <form role="form" id="form-transaksi" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-error">
                                    <label class="form-control-label">Nama Pembeli : <span
                                            style="color: red">*</span></label>
                                    <input autocomplete="off" class="form-control" type="text" name="nama"
                                        placeholder="Masukan Nama" required>
                                    <span class="has-error help-block"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group has-error">
                                    <label class="form-control-label">Keterangan : </label>
                                    <input autocomplete="off" class="form-control" type="text" name="keterangan"
                                        placeholder="Masukan Keterangan" required>
                                    <span class="has-error help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered global-table" width="100%" cellspacing="0"
                                    id="belanjaan">
                                    <thead>
                                        <tr>
                                            <th width="20%">Nama Barang</th>
                                            <th width="20%">Qty</th>
                                            <th width="20%">Harga</th>
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Total Harga </td>
                                            <td colspan="2"><input type="hidden" name="total_pembayaran"
                                                    value="'+parseInt($(this).data('harga'))+'" />
                                                <div id='total-harga'>Rp 0</div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-error">
                                    <label class="form-control-label">Bayar : <span style="color: red">*</span></label>
                                    <input autocomplete="off" class="form-control bayar" type="text" name="bayar"
                                        placeholder="Masukan Jumlah Bayar" value=0 required min="1">
                                    <span class="has-error help-block"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group has-error">
                                    <label class="form-control-label">Kembalian : </label>
                                    <input autocomplete="off" class="form-control" type="text" name="kembalian"
                                        placeholder="Jumlah Kembalian" readonly="true">
                                    <span class="has-error help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="float: right; width: 100%">
                        <button type="submit" id="btn-save-transaksi" class="btn btn-success float-right mr-10"><i
                                class ="fa fa-check"></i> Selesai</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <script>
        function count_all() {
            var all_price = 0;
            $('.harga_barang').each(function() {
                all_price += parseInt(this.value);
            });
            $('input[name ="total_pembayaran"').val(all_price);
            $('#total-harga').text('Rp ' + formatNumber(all_price));
            $('input[name ="total_pembayaran"').val(all_price);

            if (parseInt($('input[name ="bayar"').val()) != 0 && parseInt($('input[name ="bayar"').val()) !== null) {
                var total = parseInt($('input[name ="bayar"').val()) - all_price;
                if (isNaN(total)) {
                    total = 0;
                }
                $('input[name ="kembalian"').val(total);
            }
        }

        // UnFormatRp: function (x) {

        //       var val = x;
        //       var parts = val.replace(/,/g, "");
        //       return parts;
        //   };

        function formatNumber(x) {
            var parts = x
                .toString()
                .split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(".");
        };

        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: '{{ url('/getBarang') }}',
                data: {
                    Barang: '',
                },
                success: function(data) {
                    $('#list-barang').append(data);

                },
                error: function(response) {
                    console.log(response);
                    swal({
                        icon: 'error',
                        text: 'Gagal Membuka modal.',
                        title: 'Maaf',
                    });
                },
            });
        });
        $(document).on('click', '.tambah-barang', function(e) {
            // console.log($(this).data('id'));
            console.log($(this).data('stock'));
            if ($('#belanjaan > tbody').find('#' + $(this).data('id')).length > 0) {
                count = parseInt($('input[name ="barang[' + $(this).data('id') + '][qty]"]').val());
                $('input[name ="barang[' + $(this).data('id') + '][qty]"]').val(count + 1);
                total = (count + 1) * parseInt($(this).data('harga'));
                $('#total-hrg' + $(this).data('id') + '').text('Rp ' + formatNumber(total))
                $('input[name ="barang[' + $(this).data('id') + '][harga]"').val(total);
                count_all()
            } else {
                $('#belanjaan > tbody').append(
                    '<tr id="' + $(this).data('id') + '" data-harga="' + $(this).data('harga') + '">' +
                    '<td>' + $(this).data('nama') + '<br> Rp ' + formatNumber($(this).data('harga')) + '</td>' +
                    '<td><input autocomplete="off" class="form-control jumlah_barang" oninput="this.value = !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null"  max="' +
                    $(this).data('stock') + '" data-id="' +
                    $(this).data('id') + '" type="number" name="barang[' + $(this).data('id') +
                    '][qty]" min="1" value=1></td>' +
                    '<td> <input type="hidden" class="harga_barang" name="barang[' + $(this).data('id') +
                    '][harga]" value="' + parseInt($(this).data('harga')) + '" /> <div id="total-hrg' + $(this)
                    .data('id') + '">Rp ' + formatNumber($(this).data('harga')) + '</div></td>' +
                    '<td><button class="btn btn-danger btn-circle hapus-barang" data-id="' + $(this).data(
                        'id') + '"><i class="fas fa-trash"></i></button></td>' +
                    '</tr>'
                );
                count_all()
            }
        });

        $(document).on('click', '.hapus-barang', function(e) {
            $('#belanjaan > tbody').find('#' + $(this).data('id')).remove();
            count_all()
        });

        $(document).on('input', '.jumlah_barang', function() {
            var id = $(this).data('id');
            var total = parseInt($(this).val()) * parseInt($('#' + id).data('harga'));
            if (isNaN(total)) {
                total = 0;
            }
            $('#total-hrg' + id).text('Rp ' + formatNumber(total));
            $('input[name ="barang[' + id + '][harga]"').val(total);
            count_all()
        });

        $(document).on('input', '.bayar', function() {
            var total = parseInt($(this).val()) - $('input[name ="total_pembayaran"').val();
            if (isNaN(total)) {
                total = 0;
            }
            $('input[name ="kembalian"').val(total);
        });

        $('#form-transaksi').submit(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            if ($('#belanjaan > tbody tr').length < 1) {
                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Belum ada barang yang di tambahkan !',
                });
            } else if (parseInt($('input[name ="bayar"').val()) < parseInt($('input[name ="total_pembayaran"')
                    .val())) {
                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah uang yang di bayar kurang !',
                });
            } else {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda tidak akan dapat merubah data ini!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Ya, Lanjutkan!'
                }).then((result) => {
                    console.log(result);
                    if (result.value) {
                        showLoading();
                        var formData = new FormData($("#form-transaksi")[0]);
                        $.ajax({
                            type: "POST",
                            url: '{{ url('/post/transaction') }}',
                            data: formData,
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                console.log(data);
                                hideLoading();
                                toastr.success(data.message, {
                                    timeOut: 5000
                                });
                                $('#list-barang').html('');
                                $.ajax({
                                    type: "GET",
                                    url: '{{ url('/getBarang') }}',
                                    data: {
                                        Barang: '',
                                    },
                                    success: function(data) {
                                        $('#list-barang').append(data);

                                    },
                                    error: function(response) {
                                        console.log(response);
                                        swal({
                                            icon: 'error',
                                            text: 'Gagal Membuka modal.',
                                            title: 'Maaf',
                                        });
                                    },
                                });
                                Swal.fire({
                                    type: 'question',
                                    title: 'Pemberitahuan',
                                    text: 'Apakah anda ingin mencetak nota ?',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    cancelButtonText: 'Batal',
                                    confirmButtonText: 'Ya, Lanjutkan!'
                                }).then((result) => {
                                    if (result.value) {
                                        var APP_URL = {!! json_encode(url('/')) !!}
                                        window.open(APP_URL + '/struk');
                                    }
                                    if (result.dismiss) {
                                        $('#form-transaksi').trigger("reset");
                                        $('#belanjaan > tbody').find('tr').remove();
                                        $('input[name ="total_pembayaran"').val(0);
                                        $('#total-harga').text('Rp ' + formatNumber(0));
                                    }
                                });
                            },
                            error: function(data) {
                                console.log(data);
                                // if (data.status === 422) {
                                //     hideLoading();
                                //     var res = data.responseJSON;
                                //     var coba = new Array();
                                //     $.each(res.errors, function (key, value) {
                                //         coba.push(key); 
                                //         if ($('[name='+key+']').parent().is("div.input-group")) {
                                //         $('[name='+key+']').parents("div.form-group").addClass('has-error');
                                //         $('[name='+key+']').parent().next('.help-block').show().text(value);    
                                //         }
                                //         else{
                                //         $('[name='+key+']').parent().addClass('has-error');
                                //         $('[name='+key+']').next('.help-block').show().text(value);
                                //         }
                                //         console.log(coba);
                                //         $('[name='+coba[0]+']').focus();
                                //     });

                                // } else {
                                //     $('#myModal').modal('hide');
                                //     hideLoading();
                                //     swal({
                                //         icon: 'error',
                                //         text: 'Gagal Menambah data.',
                                //         title: 'Maaf',
                                //     });
                                // }
                            }
                        });
                    }

                })
            }


        });
    </script>
@endsection
