



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


                        	<th>Invoice Date</th>

                        	<th>Invoice No.</th>

                        	<th>Customer</th>

                          <th>Status</th>

                          <th>Billing</th>

                          <th>&nbsp;</th>

                    	</tr>

                	</thead>

                    <tbody>

                      <?php $i = 1 ?>

                      @foreach($data as $row)

                      <?php 

                      if($row->status == 'Unpaid')

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

                          <td>{{ $row->invoice_no }}</td>

                          <td>{{ $row->name }}</td>

                          <td style="text-align:center;width:5%;"><span class="label label-sm label-{{ $label }}">{{ $row->status }} </span></td>

                          <td style="text-align:right;">{{ $row->billing }}</td>

                          <td style="text-align:center;width:5%;">

                            @if($row->status == 'Unpaid')

                            <a href="{{ url('payment/create/' .$row->invoice_no) }}" class="btn green btn-xs">

                            Add Payment <i class="fa fa-plus"></i> </a>

                            @else

                            <a href="{{ url('payment/view/' .$row->receipt_no) }}" class="btn blue btn-xs">

                            Print <i class="fa fa-print"></i> </a>

                            @endif

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



