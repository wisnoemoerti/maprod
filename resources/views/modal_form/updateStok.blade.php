@if (isset($id))
<input type="hidden" name="id" value="{{$id}}">
@endif
<div class="row">
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label">Tipe: <span style="color: red">*</span></label>
      <div class="row" class="col-lg-12">
        <div class="col-lg-6">
          <input type="radio" id="Pengurangan" name="type" value="Pengurangan">
          <label for="Pengurangan">Pengurangan</label><br>
        </div>
        <div class="col-lg-6">
          <input required="" type="radio" id="Penambahan" name="type" value="Penambahan">
          <label for="Penambahan">Penambahan</label><br>
        </div>
      </div>
      <span class="has-error help-block"></span>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group has-error">
      <label class="form-control-label">Stok : <span style="color: red">*</span></label>
      <input autocomplete="off" class="form-control" type="number" name="jumlah_stok" value="" placeholder="Masukan perubahan stok" required>
      <span class="has-error help-block"></span>
    </div>
  </div>
</div>