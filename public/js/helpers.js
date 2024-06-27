function showLoading() {
	$("body").LoadingOverlay("show", {
		image: imageloading_path,
	});
}

function hideLoading() {
	$("body").LoadingOverlay("hide", true);
}

function removeClassModal() {
	$('.modal-dialog').removeClass('modal-full');
	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').removeClass('modal-md');
	$('.modal-dialog').removeClass('modal-sm');
}

$('.global-table').on('click', '.add-modal', function (e) {
	removeClassModal();
    showLoading();
    url = $(this).data('url');
    jenis= $(this).data('jenis');
    $.ajax({
        type: "GET",
        url: url,
        data:{
            jenis:jenis,
        },
        success: function (data) {
            hideLoading();
            console.log(data);
            $('#myModal').modal('show');
            $('#modal_title').html(data.modal_title);
            $('#modal_body').html(data.modal_body);
            $('#modal_footer').html(data.modal_footer);
            $('#modal_size').addClass(data.modal_size);
        },
        error: function (response) {
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

$('.global-table').on('click', '.stok-modal', function (e) {
    removeClassModal();
    showLoading();
    url = $(this).data('url');
    jenis= $(this).data('jenis');
    id = $(this).data('id');
    tbl = $(this).data('table');
    $.ajax({
        type: "GET",
        url: url,
        data:{
            jenis:jenis,
            id:id,
            table:tbl,
        },
        success: function (data) {
            hideLoading();
            console.log(data);
            $('#myModal').modal('show');
            $('#modal_title').html(data.modal_title);
            $('#modal_body').html(data.modal_body);
            $('#modal_footer').html(data.modal_footer);
            $('#modal_size').addClass(data.modal_size);
        },
        error: function (response) {
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

$('.global-table').on('click', '.edit-modal', function (e) {
    removeClassModal();
    showLoading();
    url = $(this).data('url');
    jenis= $(this).data('jenis');
    id = $(this).data('id');
    tbl = $(this).data('table');
    $.ajax({
        type: "GET",
        url: url,
        data:{
            jenis:jenis,
            id:id,
            table:tbl,
        },
        success: function (data) {
            hideLoading();
            console.log(data);
            $('#myModal').modal('show');
            $('#modal_title').html(data.modal_title);
            $('#modal_body').html(data.modal_body);
            $('#modal_footer').html(data.modal_footer);
            $('#modal_size').addClass(data.modal_size);
        },
        error: function (response) {
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

$('.global-table').on('click', '.delete-modal', function (e) {
	id = $(this).data('id');
    url = $(this).data('url');
    tbl = $(this).data('tbl');
	Swal.fire({
	  title: 'Apakah anda yakin?',
	  text: "Anda tidak akan dapat mengembalikan ini!",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  cancelButtonText: 'Batal',
	  confirmButtonText: 'Ya, Hapus ini!'
	}).then((result) => {
	  if (result.value) {
	  	showLoading();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "DELETE",
            url: url,
            data: {
                id:id,
            },
            dataType: 'json',
            success: function (data) {
                hideLoading();
                $('#'+tbl).DataTable().ajax.reload();
                swal.close();
                toastr.success(data.message,{
                    timeOut: 5000
                });
            },
            error: function (json) {
                hideLoading();
            }
        });
	  }
	})
});

function sendData(url,tbl) {
    var formData = new FormData($("#form")[0]);
    formData.append('metode', 'tambah');
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (data) {
            console.log(data);
            hideLoading();
            $('#myModal').modal('hide');
            $('#'+tbl).DataTable().ajax.reload();
            toastr.success(data.message, {
                timeOut: 5000
            });
        },
        error: function (data) {
            if (data.status === 422) {
                hideLoading();
                var res = data.responseJSON;
                var coba = new Array();
                $.each(res.errors, function (key, value) {
                    coba.push(key); 
                    if ($('[name='+key+']').parent().is("div.input-group")) {
                    $('[name='+key+']').parents("div.form-group").addClass('has-error');
                    $('[name='+key+']').parent().next('.help-block').show().text(value);    
                    }
                    else{
                    $('[name='+key+']').parent().addClass('has-error');
                    $('[name='+key+']').next('.help-block').show().text(value);
                    }
                    console.log(coba);
                    $('[name='+coba[0]+']').focus();
                });

            } else {
                $('#myModal').modal('hide');
                hideLoading();
                swal({
                    icon: 'error',
                    text: 'Gagal Menambah data.',
                    title: 'Maaf',
                });
            }
        }
    });
}

function editData(url,tbl) {
    var formData = new FormData($("#form")[0]);
    formData.append('metode', 'edit');
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
        	console.log(data);
            hideLoading();
            $('#'+tbl).DataTable().ajax.reload();
            $('#myModal').modal('hide');
            toastr.success(data.message, {
                timeOut: 5000
            });
        },
        error: function (data) {
            console.log(data);
            if (data.status === 422) {
                hideLoading();
                var res = data.responseJSON;
                var coba = new Array();
                $.each(res.errors, function (key, value) {
                    coba.push(key); 
                    if ($('[name='+key+']').parent().is("div.input-group")) {
                    $('[name='+key+']').parents("div.form-group").addClass('has-error');
                    $('[name='+key+']').parent().next('.help-block').show().text(value);    
                    }
                    else{
                    $('[name='+key+']').parent().addClass('has-error');
                    $('[name='+key+']').next('.help-block').show().text(value);
                    }
                    console.log(coba);
                    $('[name='+coba[0]+']').focus();
                });

            } else {
                $('#myModal').modal('hide');
                hideLoading();
                swal({
                    icon: 'error',
                    text: 'Gagal Menambah data laboratorium.',
                    title: 'Maaf',
                });
            }
        }
    });
}


$('#form').submit(function (e) {
    showLoading();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    e.preventDefault();
    if(document.getElementById("btn-ok-hidden") != null){
        document.getElementById("btn-ok-hidden").click();
        $("#btn-save").prop( "disabled", true );
        showLoading();
    }else{
        $("#btn-save").prop( "disabled", true );
        showLoading();
    }
    var action = $("#btn-save").data('action');
    var url =    $("#btn-save").data('url');
    var tbl =    $("#btn-save").data('tbl');
    $('.help-block').html('');
    $('.form-group').removeClass('has-error');
    switch (action) {
        case 'add':
            setTimeout(() => {
                sendData(url,tbl);
            }, 800);
            break;
        case 'edit':
            setTimeout(() => {
            editData(url,tbl);
            }, 800);
            break;
        case 'proses':
            setTimeout(() => {
            prosesData(url,tbl);
            }, 800);
            break;
    }
});