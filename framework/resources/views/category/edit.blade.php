@extends('template')
@section('content')
                    
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-green-haze">
            <i class="icon-settings font-green-haze"></i>
            <span class="caption-subject bold uppercase"> {{ $title }}</span>
        </div>
        <div class="actions">
            <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
            </a>
        </div>
    </div>
    @include('layouts.partials.validation')
    <div class="portlet-body form">
    {!! Form::model($data, array('route' => ['category.update', 'id' => $data->id], 'class' => 'form-horizontal')) !!}
        @include('category.form')   
        {!! Form::close() !!}
    </div>
</div>
@endsection

