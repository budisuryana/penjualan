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
        <a href="{{ route('user.list') }}">Users</a>
        <i class="fa fa-angle-right"></i>
      </li>
      <li>
        <a href="#">{{ $title }}</a>
      </li>
    </ul>
</div><br/>

<div class="row">
    <div class="col-md-12">
        @include('layouts.partials.alert')
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user"></i>{{ $title }}
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($role, array('route' => ['role.update', 'id' => $id], 'class' => 'form-horizontal')) !!}
                @include('admin.users._formRole')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
