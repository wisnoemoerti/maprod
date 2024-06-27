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
      <label class="form-control-label">Harga : <span style="color: red">*</span></label>
      <input autocomplete="off" class="form-control" type="number" name="harga" value="{{(isset($harga) ? $harga : '' )}}" placeholder="Masukan Harga" required>
      <span class="has-error help-block"></span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label">Keterangan : <span style="color: red">*</span></label>
      <input autocomplete="off" class="form-control" type="text" name="keterangan" value="{{(isset($keterangan) ? $keterangan : '' )}}" placeholder="Masukan Keterangan" required>
      <span class="has-error help-block"></span>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label">Tanggal : <span style="color: red">*</span></label>
      <input autocomplete="off" class="form-control" type="date" id="birthday" name="tanggal" value="{{(isset($tanggal) ? $tanggal : '' )}}" placeholder="Masukan Tanggal" required>
      <span class="has-error help-block"></span>
    </div>
  </div>
</div>
