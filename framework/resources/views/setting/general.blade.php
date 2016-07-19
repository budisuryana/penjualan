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

</div><br/>



<div class="row">

    <div class="col-md-12">

        @include('layouts.partials.alert')

        {!! Form::open(array('route' => 'setting.general.store', 'class' => 'form-horizontal', 'files' => true)) !!}

        <div class="tabbable-line boxless tabbable-reversed">

            <div class="tab-content">

            @include('setting._formGeneral')

            </div>

        </div><br/>

        {!! Form::submit('Save Changes', array('class' => 'btn green')) !!}

        {!! Form::close() !!}

    </div>

</div>

@endsection

