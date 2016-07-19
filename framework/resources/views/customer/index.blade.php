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



<a href="{{ route('customer.create') }}" class="btn blue btn-sm"><i class="fa fa-plus-circle"></i> Add</a>
<!--button class="btn green btn-sm" name="btn-upload" id="btn-upload"><i class="fa fa-upload"></i> Import Customer</button-->
<br/><br/>

<div class="row">

  <div class="col-md-12">

      @include('layouts.partials.alert')

      <div class="portlet box green-haze">

      <div class="portlet-title">

        <div class="caption">

          <i class="fa fa-globe"></i>List Customer

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

              <th>City</th>

              <th>Zip Code</th>

              <th>&nbsp;</th>

            </tr>

          </thead>

        </table>

      </div>

    </div>

  </div>  

</div>

{!! Form::close() !!}  

@endsection

{!! Html::script("/assets/global/plugins/jquery.min.js") !!} 
<script>
$(function() {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('customer.data') !!}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'city', name: 'city' },
            { data: 'zip_code', name: 'zip_code' },
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


