@if (Session::has('successMessage'))
<div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Tutup</span></button>
    <strong>Success!</strong> {{ Session::get('successMessage') }}
</div>
@elseif (Session::has('infoMessage'))
<div class="alert alert-info" role="alert">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Tutup</span></button>
	<strong>Info!</strong> {{ Session::get('infoMessage') }}
</div>
@elseif (Session::has('warningMessage'))
<div class="alert alert-warning" role="alert">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Tutup</span></button>
	<strong>Warning!</strong> {{ Session::get('warningMessage') }}
</div>
@elseif (Session::has('errorMessage'))
<div class="alert alert-danger" role="alert">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Tutup</span></button>
	<strong>ERROR!</strong> {{ Session::get('errorMessage') }}
</div>
@endif