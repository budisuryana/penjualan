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

<h3 class="page-title">

{{ $title }}

</h3>





<a href="{{ url('deposit/create') }}" class="btn green btn-sm">Input Deposit <i class="fa fa-pencil"></i></a>

<br/><br/>

<div class="row">

  <div class="col-md-12">

		@include('layouts.partials.alert')

        <div class="portlet box green-haze">

			<div class="portlet-title">

				<div class="caption">

					<i class="fa fa-globe"></i>Deposit Customer

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

    					<th>Name</th>

                        <th>Address</th>

                        <th>City</th>

                        <th>Zip Code</th>

                        <th>Deposit</th>

    				</tr>

  				</thead>

                <tbody>

                <?php $i = 1 ?>

                @foreach($data as $row)

                    <tr>

                        <td>{{ $row->customer->name }}</td>

                        <td>{{ $row->customer->address }}</td>

                        <td>{{ $row->customer->city }}</td>

                        <td>{{ $row->customer->zip_code }}</td>

                        <td style="text-align:right;width:5%;">{{ $row->amount }}</td>

                    </tr>

                @endforeach

                </tbody>

				</table>

			</div>

		</div>

	</div>	

</div>

  

@endsection





