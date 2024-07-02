@if (isset($id))
    <input type="hidden" name="id" value="{{ $id }}">
@endif
<div class="row">
    <div class="col-lg-4">
        <div class="form-group has-error">
            <label class="form-control-label">Nama : <span style="color: red">*</span></label>
            <select class="custom-select" name="product_id">
                <option disabled selected>-- Silahkan pilih jenis bakso --</option>
                @foreach ($jenis as $item)
                    <option value="{{ $item->id }}"
                        {{ isset($product_id) && $product_id == $item->id ? 'selected' : '' }}>
                        {{ $item->name }} ISI ({{ $item->pack_size }})
                    </option>
                @endforeach
            </select>
            <span class="has-error help-block"></span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group has-error">
            <label class="form-control-label">Tanggal Produksi: <span style="color: red">*</span></label>
            <input autocomplete="off" class="form-control" type="date" name="production_date"
                value="{{ isset($production_date) ? $production_date : \Carbon\Carbon::now()->format('Y-m-d') }}"
                required>

            <span class="has-error help-block"></span>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group has-error">
            <label class="form-control-label">Stok: <span style="color: red">*</span></label>
            <input autocomplete="off" class="form-control" type="number" name="quantity"
                value="{{ isset($stock->quantity) ? $stock->quantity : '' }}" placeholder="Masukan Stok" required>
            <span class="has-error help-block"></span>
        </div>
    </div>
</div>
