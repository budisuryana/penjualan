
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
        {!! Form::open(array('route' => 'report.product', 'class' => 'form-horizontal', 'method' => 'GET')) !!}
        <div class="form-body">
            <div class="form-group">
                {!! Form::label('productcode', 'Product Code.', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-3">
                    {!! Form::text('productcode', Input::get('productcode'), array('class' => 'form-control ')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('name', 'Product Name', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-3">
                    {!! Form::text('name', Input::get('name'), array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('supplier_id', 'Supplier', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-3">
                    {!! Form::select('supplier_id', array('' => 'Select Supplier') + $supplier->toArray(), Input::get('supplier_id'), array('class' => 'form-control select2me')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('category_id', 'Category', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-3">
                    {!! Form::select('category_id', array('' => 'Select Category') + $category->toArray(), Input::get('category_id'), array('class' => 'form-control select2me')) !!}
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
                      	<th>Code</th>
                      	<th>Product</th>
                      	<th>Category</th>
                        <th>Supplier</th>
                        <th>Sell Price</th>
                        <th>Cost Price</th>
                        <th>Stock</th>
                  	</tr>
              	</thead>
                @if(count($data))
                <tbody>
                  <?php $i = 1 ?>
                  @foreach($data as $row)
                    <tr>
                      <td>{{ $row->productcode }}</td>
                      <td>{{ $row->name }}</td>
                      <td>{{ $row->category }}</td>
                      <td>{{ $row->supplier }}</td>
                      <td>{{ $row->sell_price }}</td>
                      <td>{{ $row->cost_price }}</td>
                      <td>{{ $row->stock }}</td>
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