



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

<a href="{{ url('po/create') }}" class="btn blue">Add <i class="fa fa-plus-circle"></i> </a>

<br/><br/>

<div class="row">

    <div class="col-md-12">

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

            				<th>No.</th>

            				<th>PO No.</th>

            				<th>Date</th>

            				<th>Supplier</th>

            				<th>Branch</th>

                    <th style="text-align: center;">Received<br/>Status</th>

                    <th style="text-align: center;">Verified<br/>Status</th>

            				<th style="text-align: center;">Ordered<br/>By</th>

                    <th style="text-align: center;">Verified<br/>By</th>

            				<th>&nbsp;</th>

        				</tr>

    				</thead>

                    <tbody>

                    <?php $i = 1 ?>

                      @foreach($data as $row)
                      <?php
                      if($row->status_receiving == 0)
                      {
                          $received = 'Unreceived';
                          $color    = 'danger';
                      }
                      else
                      {
                          $received = 'Received';
                          $color    = 'success';
                      }

                      if($row->verified == 0)
                      {
                          $verified = 'Unverified';
                          $color    = 'danger';
                      }
                      else
                      {
                          $verified = 'Verified';
                          $color    = 'success';
                      }
                      ?>

                        <tr>

                          <td style="text-align:center;width:5%;">{{ $i++ }}</td>

                          <td>{{ $row->po_no }}</td>

                          <td>{{ $row->date_order }}</td>

                          <td>{{ $row->supplier->name }}</td>

                          <td>{{ $row->branch->name }}</td>

                          <td style="text-align: center;">
                          <span class="label label-sm label-{{ $color }}"> 
                          {{ $received }}
                          </span>
                          </td>

                          <td style="text-align: center;">
                          <span class="label label-sm label-{{ $color }}">
                          {{ $verified }}
                          </span>
                          </td>

                          <td>{{ $row->user->first_name.' '.$row->user->last_name }}</td>

                          <td>{{ $row->verifby }}</td>

                          <td style="text-align:center;width:5%;">

                            <a href="{{ URL::route('po.print', $row->po_no) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-print"></i> Print</a>

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



