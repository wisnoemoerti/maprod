@if (isset($id))
<input type="hidden" name="id" value="{{$id}}">
@endif
<div class="row">
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label">Nama : <span style="color: red">*</span></label>
      <input autocomplete="off" class="form-control" type="text" name="nama" value="{{(isset($nama) ? $nama : '' )}}" placeholder="Masukan Nama" required>
      <span class="has-error help-block"></span>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label">Stok : <span style="color: red">*</span></label>
      <input autocomplete="off" class="form-control" type="number" name="jumlah_stok" value="{{(isset($jumlah_stok) ? $jumlah_stok : '' )}}" placeholder="Masukan Stok" required>
      <span class="has-error help-block"></span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label">Satuan : <span style="color: red">*</span></label>
      <input autocomplete="off" class="form-control" type="text" name="satuan" value="{{(isset($satuan) ? $satuan : '' )}}" placeholder="Masukan Satuan" required>
      <span class="has-error help-block"></span>
    </div>
  </div>
</div>
