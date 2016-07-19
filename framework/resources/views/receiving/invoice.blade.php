@extends('template')
@section('content')


<h3 class="page-title">
Sale <small>invoice</small>
</h3>

<?php 
setlocale(LC_TIME, '');
$date = Carbon\Carbon::parse($list->date_order, 'Europe/Berlin')->formatLocalized('%A %d %B %Y'); ?>
<div class="invoice">
				<div class="row invoice-logo">
					<div class="col-xs-6 invoice-logo-space">
					{!! HTML::image('/assets/img/laravos2.png', 'Laravel POS System', array('class' => 'img-responsive', 'height' => '150px', 'width' => '300px')) !!}
					</div>
					<div class="col-xs-6">
						<p>
							 {{ $list->invoice_no }} / {{ $list->date_order }} <span class="muted">
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
								 {{ $list->name }}
							</li>
							<li>
								 {{ $list->address }}
							</li>
							<li>
								 {{ $list->phone }}
							</li>
							<li>
								 {{ $list->email }}
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
								 Item
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
						@foreach($list2 as $lists2)
						<tr>
							<td>
								 {{ $i++ }}
							</td>
							<td>
								 {{ $lists2->item_name }}
							</td>
							<td class="hidden-480">
								 {{ $lists2->category_name }}
							</td>
							<td class="hidden-480">
								 {{ $lists2->qty }}
							</td>
							<td class="hidden-480">
								 {{ $lists2->price }}
							</td>
							<td>
								 {{ $lists2->amount }}
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
							<strong>Loop, Inc.</strong><br/>
							795 Park Ave, Suite 120<br/>
							San Francisco, CA 94107<br/>
							<abbr title="Phone">P:</abbr> (234) 145-1810 </address>
							<address>
							<strong>{{ Sentinel::getUser()->first_name .' '. Sentinel::getUser()->last_name }}</strong><br/>
							<a href="mailto:#">
							{{ Sentinel::getUser()->email }} </a>
							</address>
						</div>
					</div>
					<div class="col-xs-8 invoice-block">
						<ul class="list-unstyled amounts">
							<li>
								<strong>Total amount:</strong> {{ $subtotal }}
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