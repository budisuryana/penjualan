



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



<a href="{{ route('sale.create.new') }}" class="btn blue">New Invoice <i class="fa fa-plus-circle"></i> </a>

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

                        	<th>Date</th>

                        	<th>Type</th>

                        	<th>Invoice No.</th>

                        	<th>Customer</th>

                          <th>Billing</th>

                          <th>Status</th>

                          <th>&nbsp;</th>

                    	</tr>

                	</thead>

                    <tbody>

                      <?php $i = 1 ?>

                      @foreach($data as $row)

                      <?php 

                      if($row->paid_status == 'Unpaid')

                        {

                            $label = 'danger';

                        }

                        else

                        {

                            $label  = 'info';

                            

                        }

                        

                        ?>

                        <tr>

                          <td>{{ \Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y') }}</td>

                          <td>{{ $row->type }}</td>

                          <td>{{ $row->invoice_no }}</td>

                          <td>{{ $row->customer }}</td>

                          <td style="text-align:right;">{{ $row->billing }}</td>

                          <td style="text-align:center;width:5%;"><span class="label label-sm label-{{ $label }}">{{ $row->paid_status }} </span></td>

                          <td style="text-align:center;width:5%;">

                            <a href="{{ url('sale/invoice/' .$row->invoice_no) }}" target="_blank" class="btn green btn-xs">

                            Print <i class="fa fa-print"></i> </a>

                          </td>

                        </tr>

                      @endforeach

                    </tbody>

            	</table>

			</div>

		</div>

	</div>	

</div>



@endsection



