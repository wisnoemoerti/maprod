@if (isset($id))
    <input type="hidden" name="id" value="{{ $id }}">
@endif
<div class="row">
    <div class="col-lg-4">
        <div class="form-group has-error">
            <label class="form-control-label">Nama : <span style="color: red">*</span></label>
            <input autocomplete="off" class="form-control" type="text" name="name"
                value="{{ isset($name) ? $name : '' }}" placeholder="Masukan Nama" required
                {{ isset($id) ? 'disabled' : '' }}>
            <span class="has-error help-block"></span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group has-error">
            <label class="form-control-label">Ukuran Pack : <span style="color: red">*</span></label>
            <input autocomplete="off" class="form-control" type="number" name="pack_size"
                value="{{ isset($pack_size) ? $pack_size : '' }}" placeholder="Masukan Ukuran Pack" required>
            <span class="has-error help-block"></span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group has-error">
            <label class="form-control-label">Harga : <span style="color: red">*</span></label>
            <input autocomplete="off" class="form-control" type="number" name="price"
                value="{{ isset($price) ? $price : '' }}" placeholder="Masukan Harga" required>
            <span class="has-error help-block"></span>
        </div>
    </div>
</div>
