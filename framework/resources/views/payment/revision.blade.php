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

        <div class="portlet box green">

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

                {!! Form::open(array('route' => 'payment.revision', 'class' => 'form-horizontal', 'method' => 'GET')) !!}

                    <div class="form-body">

                    <div class="form-group {!! ($errors->has('invoice') ? 'has-error' : '' ) !!}">

                        {!! Form::label('invoice', 'Invoice No.', array('class' => 'col-md-3 control-label')) !!}

                        <div class="col-md-4">

                            {!! Form::select('invoice', $invoice, \Input::get('invoice'), array('class' => 'form-control select2me', 'placeholder' => 'Please Select')) !!}

                            @if($errors->has('invoice'))

                                <span class="help-block">{{ $errors->first('invoice') }}</span>

                            @endif

                        </div>

                    </div>



                    <div class="form-actions">

                        <div class="row">

                            <div class="col-md-offset-3 col-md-9">

                                {!! Form::submit('Search', array('class' => 'btn green')) !!}

                            </div>

                        </div>

                    </div>

                </div>

                {!! Form::close() !!}

            </div>

        </div>

    </div>

</div>



@if($cnt)

<div class="row">

    <div class="col-md-12">

        @include('layouts.partials.alert')

        <div class="portlet box blue">

            <div class="portlet-title">

                <div class="caption">

                    <i class="fa fa-gift"></i>Detail Invoice

                </div>

                <div class="tools">

                    <a href="javascript:;" class="collapse">

                    </a>

                </div>

            </div>

            <div class="portlet-body form">

                {!! Form::open(array('route' => 'payment.store.revision', 'class' => 'form-horizontal')) !!}

                    <div class="form-body">

                    @foreach($query as $row)

                    <div class="form-group">

                        {!! Form::label('invoice_no', 'Invoice No.', array('class' => 'col-md-3 control-label')) !!}

                        <div class="col-md-2">

                            <p class="form-control-static">{{ $row->invoice_no }}</p>
                            {!! Form::hidden('invoice_no', $row->invoice_no) !!}

                            @if($errors->has('invoice_no'))

                                <span class="help-block">{{ $errors->first('invoice_no') }}</span>

                            @endif

                        </div>

                    </div>

                    <div class="form-group">

                        {!! Form::label('customer', 'Customer', array('class' => 'col-md-3 control-label')) !!}

                        <div class="col-md-5">

                            <p class="form-control-static">{{ $row->name }}</p>

                        </div>

                    </div>

                    <div class="form-group">

                        {!! Form::label('amount', 'Total Amount', array('class' => 'col-md-3 control-label')) !!}

                        <div class="col-md-5">

                            <p class="form-control-static">{{ $row->amount }}</p>

                        </div>

                    </div>

                    <div class="form-group">

                        {!! Form::label('description', 'Description', array('class' => 'col-md-3 control-label')) !!}

                        <div class="col-md-5">

                            {!! Form::textarea('description', null, array('class' => 'form-control', 'rows' => 5)) !!}

                            @if($errors->has('description'))

                                <span class="help-block" style="color:red;">{{ $errors->first('description') }}</span>

                            @endif

                        </div>

                    </div>

                    <div class="form-actions">

                        <div class="row">

                            <div class="col-md-offset-3 col-md-9">

                                {!! Form::submit('Save', array('class' => 'btn blue')) !!}

                                <a href="{{ URL::previous() }}" class="btn default">Cancel</a>

                            </div>

                        </div>

                    </div>

                @endforeach

                </div>

                {!! Form::close() !!}

            </div>

        </div>

    </div>

</div>

@endif



@endsection

