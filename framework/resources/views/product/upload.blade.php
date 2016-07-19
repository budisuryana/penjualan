@extends('template')
@section('content')

<div class="page-bar">
    <ul class="page-breadcrumb">
      <li>
        <i class="fa fa-home"></i>
        <a href="index.html">Home</a>
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
        @include('layouts.partials.validation')
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>{{ $title }}
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::open(array('route' => 'product.import', 'class' => 'form-horizontal', 'files' => true)) !!}
                    <div class="form-body">
                        <div class="form-group">
                            {!! Form::label('', '', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-4">
                                <a href="{{ route('product.download') }}" class="btn purple btn-sm">Download Template <i class="fa fa-download"></i></a>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('excel', 'Browse File', array('class' => 'col-md-3 control-label')) !!}
                            <div class="col-md-4">
                                {!! Form::file('excel') !!}
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    {!! Form::submit('Upload', array('class' => 'btn green')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection