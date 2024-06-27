@if (isset($id))
    <input type="hidden" name="id" value="{{ $id }}">
@endif
<div class="row">
    <div class="col-lg-6">
        <div class="form-group has-error">
            <label class="form-control-label">Nama : <span style="color: red">*</span></label>
            <input autocomplete="off" class="form-control" type="text" name="nama"
                value="{{ isset($nama) ? $nama : '' }}" placeholder="Masukan Nama" required>
            <span class="has-error help-block"></span>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group has-error">
            <label class="form-control-label">Stok Pack: <span style="color: red">*</span></label>
            <input autocomplete="off" class="form-control" type="number" name="jumlah_stok"
                value="{{ isset($jumlah_stok) ? $jumlah_stok : '' }}" placeholder="Masukan Stok" required>
            <span class="has-error help-block"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="form-group has-error">
            <label class="form-control-label">Jenis Pack (Butir): <span style="color: red">*</span></label>
            <input autocomplete="off" class="form-control" type="number" name="jenis_pack"
                value="{{ isset($jenis_pack) ? $jenis_pack : '' }}" placeholder="Masukan Jenis Pack" required>
            <span class="has-error help-block"></span>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group has-error">
            <label class="form-control-label">Harga : <span style="color: red">*</span></label>
            <input autocomplete="off" class="form-control" type="number" name="harga"
                value="{{ isset($harga) ? $harga : '' }}" placeholder="Masukan Harga" required>
            <span class="has-error help-block"></span>
        </div>
    </div>
</div>
