@if ($errors->count() > 0)
<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Tutup</span></button>
    <strong>Error!</strong>
    	@foreach ($errors->all('<p>:message</p>') as $error)
            {!! $error !!}
        @endforeach
</div>
@endif