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

        {!! Form::open(array('route' => 'product.store', 'class' => 'form-horizontal', 'files' => true, 'id' => 'fileupload')) !!}

        <div class="tabbable-line boxless tabbable-reversed">

            <ul class="nav nav-tabs">

                <li class="active">

                    <a href="#tab_0" data-toggle="tab">

                    Detail Product </a>

                </li>

                <li>

                    <a href="#tab_1" data-toggle="tab">

                    Price/Discount </a>

                </li>

                <li>

                    <a href="#tab_2" data-toggle="tab">

                    Product Supplier </a>

                </li>

                <!--li>

                    <a href="#tab_3" data-toggle="tab">

                    Product Image </a>

                </li-->

            </ul>

            <div class="tab-content">

            @include('product.form')

            </div>

        </div><br/>

        {!! Form::submit('Save Changes', array('class' => 'btn green')) !!}

        <a href="{{ URL::previous() }}" class="btn yellow">Cancel</a>

        {!! Form::close() !!}

    </div>

</div>

@endsection

