<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
 ?>
@extends('template')

@section('content')

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="#">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">{{ $title }}</a>
        </li>
    </ul>
</div>
<h3 class="page-title">
{{ $title }}
</h3>


<a href="{{ route('supplier.create') }}" class="btn blue btn-sm"><i class="fa fa-plus-circle"></i> Add</a>
<br/><br/>
<div class="row">
  <div class="col-md-12">
        
        <div class="portlet box green-haze">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>{{ $title }}
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                </table>
            </div>
        </div>
    </div>  
</div>

@endsection
{!! Html::script("/assets/global/plugins/jquery.min.js") !!} 

<script>
$(function() {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('supplier.data') !!}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action', orderable: false, searchable: false, sWidth: '15%', sClass: "center"}
        ]
    });
});
</script>

<script type="text/javascript">
  function onDelete()
  {
    
    if(confirm('Apa anda yakin akan menghapus data ini ?') == true)
    {
        return true;
    }
    else
    {
        return false;
    }

  }

</script>