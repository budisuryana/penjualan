
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
<h3 class="page-title">{{ $title }}</h3>
<div class="row">
  <div class="col-md-12">
    <div class="portlet-body form">
        {!! Form::open(array('route' => 'report.sales', 'class' => 'form-horizontal', 'method' => 'GET')) !!}
        <div class="form-body">
            <div class="form-group">
                {!! Form::label('date', 'Select Date', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-4">
                <div class="input-group date-picker input-daterange" data-date="2012/11/10" 
                data-date-format="yyyy-mm-dd">
                {!! Form::text('from', Input::get('from'), array('class' => 'form-control')) !!}
                <span class="input-group-addon">to </span>
                {!! Form::text('until', Input::get('until'), array('class' => 'form-control')) !!}
                </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('invoice_no', 'Invoice No.', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-3">
                    {!! Form::text('invoice_no', Input::get('invoice_no'), array('class' => 'form-control ')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('customer', 'Customer', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-3">
                    {!! Form::text('customer', Input::get('customer'), array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('status', 'Status', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-3">
                    {!! Form::select('status', $status, Input::get('status'), array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-2 col-md-10">
                    {!! Form::submit('Filter', array('class' => 'btn blue')) !!}
                </div>
            </div>
        </div>  
        {!! Form::close() !!}
    </div>
  </div>
</div>
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
            	<table class="table table-striped table-bordered table-hover">
              	<thead>
                  	<tr>
                      	<th>Type</th>
                      	<th>Invoice No.</th>
                      	<th>Customer</th>
                        <th>Billing</th>
                        <th>Status</th>
                  	</tr>
              	</thead>
                @if(count($data))
                <tbody>
                  <?php $i = 1 ?>
                  @foreach($data as $row)
                    <tr>
                      <td>{{ $row->type }}</td>
                      <td>{{ $row->invoice_no }}</td>
                      <td>{{ $row->name }}</td>
                      <td style="text-align:right;">{{ $row->billing }}</td>
                      <td style="text-align:center;width:5%;">{{ $row->paid_status }}</td>
                    </tr>
                  @endforeach
                </tbody>
                @endif
        </table>
			</div>
		</div>
    <div class="pagination">
      {!! $data->links() !!}
    </div>
	</div>	
</div>



@endsection