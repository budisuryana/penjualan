@extends('template')

@section('content')





<h3 class="page-title">

Sale <small>invoice</small>

</h3>



<?php 
$system = \App\Models\SettingGeneral::all();
$logo   = $system[0]['logo'];
$app_name = $system[0]['app_name'];
?>

<div class="invoice">

				<div class="row invoice-logo">

					<div class="col-xs-6 invoice-logo-space">

					{!! Html::image('/assets/img/' .$logo, $app_name, array('class' => 'img-responsive', 'height' => '150px', 'width' => '300px')) !!}

					</div>

					<div class="col-xs-6">

						<p>

							 {{ $data2->invoice_no }} / {{ $data2->invoice_date }} <span class="muted">

							 </span>

						</p>

					</div>

				</div>

				<hr/>

				<div class="row">

					<div class="col-xs-4">

						<h3>Customer:</h3>

						<ul class="list-unstyled">

							<li>

								 {{ $data2->name }}

							</li>

							<li>

								 {{ $data2->address }}

							</li>

							<li>

								 {{ $data2->phone }}

							</li>

							<li>

								 {{ $data2->email }}

							</li>

						</ul>

					</div>

					<div class="col-xs-4">

					</div>

					<div class="col-xs-4">

						<h3>Payment Details:</h3>

						<ul class="list-unstyled">

							<li>

								 Invoice No : {{ $data2->invoice_no }}

							</li>

							<li>

								 Invoice Date : {{ $data2->invoice_date }}

							</li>

						</ul>

					</div>

				</div>

				<div class="row">

					<div class="col-xs-12">

						<table class="table table-striped table-hover">

						<thead>

						<tr>

							<th>

								 #

							</th>

							<th>

								 Product

							</th>

							<th class="hidden-480">

								 Category

							</th>

							<th class="hidden-480">

								 Quantity

							</th>

							<th class="hidden-480">

								 Unit Cost

							</th>

							<th>

								 Total

							</th>

						</tr>

						</thead>

						<tbody>

						<?php $i = 1; ?>

						@foreach($data1 as $row)

						<tr>

							<td>

								 {{ $i++ }}

							</td>

							<td>

								 {{ $row->product }}

							</td>

							<td class="hidden-480">

								 {{ $row->category }}

							</td>

							<td class="hidden-480">

								 {{ $row->qty }}

							</td>

							<td class="hidden-480">

								 {{ $row->price }}

							</td>

							<td>

								 {{ $row->amount }}

							</td>

						</tr>

						@endforeach

						</tbody>

						</table>

					</div>

				</div>

				<div class="row">

					<div class="col-xs-4">

						<div class="well">

							<address>

							<strong>{{ $system[0]['company'] }}</strong><br/>

							{{ $system[0]['company_address'] }}<br/>

							<abbr title="Phone">Phone:</abbr> {{ $system[0]['phone'] }} <br/> 

							<abbr title="Email">Email:</abbr> {{ $system[0]['email'] }}

							</address>

							<address>

							<strong>{{ $data2->first_name .' '. $data2->last_name }}</strong><br/>

							<a href="mailto:#">

							{{ $data2->emailuser }} </a>

							</address>

						</div>

					</div>

					<div class="col-xs-4">

						<div class="well">

							{{-- $list->message --}}

						</div>

					</div>

					<div class="col-xs-4 invoice-block">

						<ul class="list-unstyled amounts">

							<li>

								<strong>Total amount:</strong> {{ $total }}

							</li>

							

						</ul>

						<br/>

						<a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">

						Print <i class="fa fa-print"></i>

						</a>

					</div>

				</div>

			</div>



@endsection