
@extends('template')
{!! Html::script("/assets/Chart.min.js") !!}
@section('content')

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="#">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="#">Dashboard</a>
		</li>
	</ul>
</div>
<h3 class="page-title">
Income &amp; More
</h3>

<div class="row">
	<div class="col-md-12">
		@include('layouts.partials.alert')
	</div>	
</div>

<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue-madison">
			<div class="visual">
				<i class="fa fa-comments"></i>
			</div>
			<div class="details">
				<div class="number">
					 $ {{ $open_invoice->open_invoice }}
				</div>
				<div class="desc">
					 Open Invoice
				</div>
			</div>
			<a class="more" href="{{ url('sale') }}">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat red-intense">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					 $ {{ $paid->paid }}
				</div>
				<div class="desc">
					 Paid Last 30 Days
				</div>
			</div>
			<a class="more" href="{{ url('payment') }}">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<!--div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat green-haze">
			<div class="visual">
				<i class="fa fa-shopping-cart"></i>
			</div>
			<div class="details">
				<div class="number">
					 549
				</div>
				<div class="desc">
					 Overdue
				</div>
			</div>
			<a class="more" href="javascript:;">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple-plum">
			<div class="visual">
				<i class="fa fa-globe"></i>
			</div>
			<div class="details">
				<div class="number">
					 +89%
				</div>
				<div class="desc">
					 Products Popularity
				</div>
			</div>
			<a class="more" href="javascript:;">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div-->	
</div>

<!--div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue-madison">
			<div class="visual">
				<i class="fa fa-comments"></i>
			</div>
			<div class="details">
				<div class="number">
					 {{-- $open_invoice->open_invoice --}}
				</div>
				<div class="desc">
					 Purchase Order
				</div>
			</div>
			<a class="more" href="javascript:;">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat red-intense">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					 {{-- $paid->paid --}}
				</div>
				<div class="desc">
					 Receiving
				</div>
			</div>
			<a class="more" href="javascript:;">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat green-haze">
			<div class="visual">
				<i class="fa fa-shopping-cart"></i>
			</div>
			<div class="details">
				<div class="number">
					 549
				</div>
				<div class="desc">
					 Internal Transfer
				</div>
			</div>
			<a class="more" href="javascript:;">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple-plum">
			<div class="visual">
				<i class="fa fa-globe"></i>
			</div>
			<div class="details">
				<div class="number">
					 +89%
				</div>
				<div class="desc">
					 Stock Adjustment
				</div>
			</div>
			<a class="more" href="javascript:;">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>	
</div-->

<div class="row">
	<div class="col-md-12">
		<div class="portlet box green-haze">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i>Last Invoice
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
						</tr>
					</thead>
					<tbody>
					<?php $i = 0; ?>
            		@foreach ($data as $row)
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
						<tr class="odd gradeX">
							<td>{{ $row->invoice_date }}</td>
		                    <td>{{ $row->type }}</td>
		                    <td>{{ $row->invoice_no }}</td>
		                    <td>{{ $row->name }}</td>
		                    <td style="text-align:right;">{{ $row->billing }}</td>
		                    <td style="text-align:center;width:5%;"><span class="label label-sm label-{{ $label }}">{{ $row->paid_status }} </span></td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-sm-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-share font-red-sunglo hide"></i>
					<span class="caption-subject font-red-sunglo bold uppercase">Products</span>
					<span class="caption-helper"> Statistics...</span>
				</div>
			</div>
			<div class="portlet-body">
				<canvas id="chartProducts" width="500" height="400"></canvas>
				<script>
				var data = {
					labels:  <?php echo json_encode($categories) ?>,
					datasets: [
						{
							fillColor: "rgba(151,187,205,0.5)",
							strokeColor: "rgba(151,187,205,0.8)",
							pointColor: "rgba(220,220,220,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(220,220,220,1)",
							highlightFill: "rgba(151,187,205,0.75)",
							highlightStroke: "rgba(151,187,205,1)",
							data: <?php echo json_encode($products) ?>
						}
					]
				};

				var ctx = document.getElementById("chartProducts").getContext("2d");
				var myLineChart = new Chart(ctx).Bar(data);
				</script>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-share font-blue-steel hide"></i>
					<span class="caption-subject font-blue-steel bold uppercase">Recent Activities</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="scroller" style="height: 400px;" data-always-visible="1" data-rail-visible="0">
				<ul class="feeds">
					<li>
						<div class="col1">
							<div class="cont">
								<div class="cont-col1">
									<div class="label label-sm label-info">
										<i class="fa fa-check"></i>
									</div>
								</div>
								<div class="cont-col2">
									<div class="desc">
										 Last Login
									</div>
								</div>
							</div>
						</div>
						<div class="col2">
							<div class="date-col2">
								 {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \Sentinel::getUser()->last_login)->diffForHumans() }}
							</div>
						</div>
					</li>
					@foreach($activities as $act)
					<li>
						<div class="col1">
							<div class="cont">
								<div class="cont-col1">
									<div class="label label-sm label-info">
										<i class="fa fa-check"></i>
									</div>
								</div>
								<div class="cont-col2">
									<div class="desc">
										 {{ $act->description }}
									</div>
								</div>
							</div>
						</div>
						<div class="col2">
							<div class="date-col2">
								 {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $act->entry_time)->diffForHumans() }}
							</div>
						</div>
					</li>
					@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection		



