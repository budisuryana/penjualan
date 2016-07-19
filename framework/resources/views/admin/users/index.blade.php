@extends('template')

@section('content')

<div class="page-bar">
  <ul class="page-breadcrumb">
    <li>
      <i class="fa fa-home"></i>
      <a href="#">Home</a>
      <i class="fa fa-angle-right"></i>
      <a href="#">Admin</a>
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

<a href="{{ route('role') }}" class="btn purple btn-sm">Add Role <i class="fa fa-plus-circle"></i></a>
<a href="{{ route('user.create') }}" class="btn blue btn-sm">Add User <i class="fa fa-plus-circle"></i></a>
<br/><br/>
<div class="row">
  <div class="col-md-9">
    @include('layouts.partials.alert')
    <div class="portlet box green-haze">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-globe"></i>List Users
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
              <th>First Name</th>
              <th>Last Name</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          <?php $i = 1 ?>
          @foreach($user as $row)
              <tr>
                  <td>{{ $row->first_name }}</td>
                  <td>{{ $row->last_name }}</td>
                  <td>{{ $row->username }}</td>
                  <td>{{ $row->email }}</td>
                  <td>{{ $row->role }}</td>
                  <td style="text-align:center;width:5%;">
                      <a href="{{ URL::route('user.edit', $row->id) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                  </td>
              </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="portlet box green-haze">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-globe"></i>List Role
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
        </div>
      </div>
      <div class="portlet-body">

        <table class="table table-striped table-bordered table-hover">
          <tbody>
          @foreach ($roles as $role)
            <tr>
              <td>{{ $role->name }}</td>
              <td style="text-align:center;"><a href="{{ URL::route('role.edit', $role->id) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a></td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection



