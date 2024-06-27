<div class="modal fade" id="{{$id_modal}}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" id="{{ $size_modal }}" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="{{ $title_modal }}"></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
      </div>
      <form role="form" id="{{ $id_form }}" enctype="multipart/form-data">
      <div class="modal-body" id="{{ $body_modal }}">
      </div>
      <div class="modal-footer" id="{{ $footer_modal }}">
      </div>
    </form>
    </div>
  </div>
</div>