<div class="row">
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label"><strong>Nama : </strong></label>
      <span class="form-text">{{ $dataTransaksi[0]->nama_pembeli }}</span>
      <span class="has-error help-block"></span>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label"><strong>Tanggal : </strong></label>
      <span class="form-text">{{ \Carbon\Carbon::parse($dataTransaksi[0]->tanggal_transaksi)->format('d F Y  h:i') }}</span>
      <span class="has-error help-block"></span>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label"><strong>Keterangan : </strong></label>
      <span class="form-text">{{ $dataTransaksi[0]->keterangan }}</span>
      <span class="has-error help-block"></span>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="table-responsive">
      <table class="table table-bordered global-table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nama Barang</th>
            <th>Jumlah Barang</th>
            <th>Harga</th>
          </tr>
        </thead>

        <tbody>
          @foreach($dataListBarang as $data => $value)
          <tr>
            <td>{{ $value->nama}}</td>
            <td>{{$value->jumlah_barang}}</td>
            <td>Rp. {{number_format($value->harga,2,',','.')}}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
                <tr>
                  <td colspan="2"><strong>Total Harga : </strong> </td>
                  <td colspan="1">Rp. {{number_format($dataTransaksi[0]->total_pembayaran,2,',','.')}}</td>
                </tr>
              </tfoot>
      </table>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label"><strong>Jumlah yang di bayar : </strong></label>
      <span class="form-text">{{ $dataTransaksi[0]->bayar }}</span>
      <span class="has-error help-block"></span>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label"><strong>Kembalian : </strong></label>
      <span class="form-text">{{ $dataTransaksi[0]->kembalian }}</span>
      <span class="has-error help-block"></span>
    </div>
  </div>
</div>