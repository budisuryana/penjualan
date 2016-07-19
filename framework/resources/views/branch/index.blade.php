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

{!! Form::open(array('route' => 'branch.delete', 'class' => 'form-horizontal')) !!}
<a href="{{ route('branch.create') }}" class="btn blue btn-sm"><i class="fa fa-plus-circle"></i> Add</a>
<button class="btn red btn-sm" type="submit" name="button" value="Delete" onClick="return onDelete();">
<i class="glyphicon glyphicon-trash"></i> Delete
</button>
<br/><br/>
<div class="row">
  <div class="col-md-12">
    @include('layouts.partials.alert')
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

        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>
              <th class="table-checkbox" style="text-align:center;width:5%;">
	              <input type="checkbox" onchange="checkAll(this)" name="CheckAll[]"/>
	          </th>
              <th>Name</th>
              <th>Address</th>
              <th>City</th>
              <th>Type</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          <?php $i = 1 ?>
          @foreach($data as $row)
              <tr>
                  <td style="text-align:center;width:5%;">
                    <input type="checkbox" class="checkboxes" name="chkDel[]" id="chkDel" value="{{ $row->id }}"/>
                  </td>
                  <td>{{ $row->name }}</td>
                  <td>{{ $row->address }}</td>
                  <td>{{ $row->city }}</td>
                  <td>{{ $row->branchType->name }}</td>
                  <td style="text-align:center;width:5%;">
                    <a href="{{ URL::route('branch.edit', $row->id) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                  </td>
              </tr>
          @endforeach
          </tbody>
        </table>
        <input type="hidden" name="hdnCount" value="<?php echo $i ?>"> 
      </div>
    </div>
  </div>  
</div>

@endsection
{!! Html::script("/assets/global/plugins/jquery.min.js") !!} 
<script type="text/javascript">
  function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');

         if (ele.checked) {
             for (var i = 0; i < checkboxes.length; i++) {
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = true;
                 }
             }
         } else {
             for (var i = 0; i < checkboxes.length; i++) {
                 console.log(i)
                 if (checkboxes[i].type == 'checkbox') {
                     checkboxes[i].checked = false;
                 }
             }
         }
    }

  function onDelete()
  {
    
    if (document.getElementById('chkDel').checked == false)
    {
        bootbox.alert ("Silahkan klik centang terlebih dulu pada baris yang akan di hapus.");
        return false;
    }
    else
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
  }

</script>