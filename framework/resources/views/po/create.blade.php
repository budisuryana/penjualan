<link rel="stylesheet" href="http://codeorigin.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
?>
@extends('template')

@section('content')

<style type="text/css">

    .ui-autocomplete {

    

    z-index:2147483647;

    

}

</style>

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

<div class="row">

  <div class="col-md-12">
    @include('layouts.partials.validation')
    <div class="alert alert-danger info" style="display:none;">
        <ul></ul>
    </div>
    {!! Form::open(array('route' => 'po.store', 'class' => 'horizontal-form', 'role' => 'form')) !!}
    <input id="token" type="hidden" value="{{$encrypted_token}}">
      <div class="form-body">

        <div class="row">

          <div class="col-md-3">

            <div class="form-group">

              <label class="control-label">Supplier</label>

              {!! Form::select('supplierid', $supplier, null, array('class' => 'form-control select2me', 'placeholder' => 'Select Supplier', 'id' => 'supplierid')) !!}

            </div>

          </div>

          <div class="col-md-3">

            <div class="form-group">

              <label class="control-label">PO No.</label>

              {!! Form::text('po_no', $po_no, ['id' => 'po_no', 'class' => 'form-control', 'readonly' => true]) !!}

            </div>

          </div>

          <div class="col-md-3">

            <div class="form-group">

              <label class="control-label">Branch</label>

              {!! Form::hidden('branch_id', $branch_id, array('class' => 'form-control', 'id' => 'branchcode')) !!}
              {!! Form::text('branchname', $branchname, array('class' => 'form-control', 'id' => 'branchname', 'readonly' => true)) !!}

            </div>

          </div>

        </div>

      </div>

      <div class="portlet">

        <div class="portlet-body">

          <div class="table-container">

            <table class="table table-striped table-bordered table-hover" id="datatable_ajax">

              <thead>

              <tr role="row" class="heading">

                  <th width="15%">Product</th>

                  <th width="5%">Quantity</th>

                  <th width="8%">Unit Conversion</th>

                  <th width="10%">Price</th>

                  <th width="5%">Disc (%)</th>

                  <th width="5%">Disc ($)</th>

                  <th width="10%">Amount</th>

                  <th width="5%">&nbsp;</th>

              </tr>

              <tr role="row" class="filter">

                  <td>

                      {!! Form::hidden('id', null, array('id' => 'id')) !!}

                      {!! Form::text('name', null, array('class' => 'form-control form-filter input-sm', 'id' => 'name')) !!}

                  </td>

                  <td>

                      {!! Form::text('qty', null, array('class' => 'form-control form-filter input-sm', 'id' => 'qty', 'onkeyup' => 'cost_total()')) !!}

                  </td>

                  <td>

                      {!! Form::select('unit_conversion_id', $conversion, null, array('class' => 'form-control select2me', 'id' => 'unit_conversion_id')) !!}

                  </td>

                  <td>

                      {!! Form::text('price', null, array('class' => 'form-control form-filter input-sm', 'id' => 'price', 'onkeyup' => 'cost_total()')) !!}

                  </td>

                  <td>

                      {!! Form::text('discount_per', null, array('class' => 'form-control form-filter input-sm', 'id' => 'discount_per', 'onkeyup' => 'discount_total()')) !!}

                  </td>

                  <td>

                      {!! Form::text('discount_value', null, array('class' => 'form-control form-filter input-sm', 'id' => 'discount_value', 'readonly' => true)) !!}

                  </td>

                  <td>

                      {!! Form::text('amount', null, array('class' => 'form-control form-filter input-sm', 'id' => 'amount', 'readonly' => true)) !!}

                  </td>

                  <td style="text-align:center;">

                     {!! Form::button('Add', array('name' => 'op', 'class' => 'btn btn-sm green add')) !!}

                  </td>

              </tr>

              </thead>

              <tbody>

              </tbody>

            </table>

          </div>

        </div>

      </div>

  </div>

</div>



<div class="row">

  <div class="col-md-12">

    <div class="portlet">

      <div class="portlet-body">

        <div class="table-container">

          <table class="table table-striped table-bordered table-hover" id="table">

          <thead>

          <tr>

            <th>Product Name</th>

            <th>Quantity</th>

            <th>Price</th>

            <th>Discount ($)</th>

            <th>Amount</th>

            <th style="text-align:center;">&nbsp;</th>

          </tr>

          </thead>

          <tbody id="item-list" name="item-list">

          @if(Session::has('items'))

          <?php $i = 0 ?>

          @foreach(Session::get('items') as $temp)

            <tr id="item{{ $temp['id'] }}">

              <td>{{ $temp['name'] }}</td>

              <td style="text-align:right;">{{ $temp['qty'] }}</td>

              <td style="text-align:right;">{{ $temp['price'] }}</td>

              <td style="text-align:right;">{{ $temp['discount_value'] }}</td>

              <td style="text-align:right;">{{ $temp['amount'] }}</td>

              <td style="text-align:center;width:5%;">

                <a href="{{url('po/deleteitem', $i++)}}" class="btn btn-xs btn-danger">

                Delete <i class="fa fa-trash"></i> </a>

              </td>

            </tr>

          @endforeach

          @endif

          </tbody>

          </table>

        </div>

      </div>

    </div>

    {!! Form::submit('Save', array('name' => 'op', 'class' => 'btn purple')) !!}    

  </div>  

</div>

{!! Form::close() !!}



@endsection

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>

<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

{!! Html::script("/assets/app/ajax-po.js") !!}

<script type="text/javascript">

  $(function(){

      $("#name").autocomplete({

          source: "{{ route('autocomplete.product') }}",

          minLength: 1,

          select: function( event, ui ) {

              $('#id').val(ui.item.id);

              $('#name').val(ui.item.value);

              $('#price').val(ui.item.cost_price);

          }

      });

  });

</script>

<script type="text/javascript">

function cost_total() {

    var price = 0;

    var totalprice = 0;

    var totaldiscount = 0;

    var discount_per = $('#discount_per').val();

    var qty = $('#qty').val();

    var cost_price = $('#price').val();

    if (qty > 0 && cost_price > 0) {

        price = (qty * cost_price);

        totaldiscount = (qty * cost_price) * (discount_per / 100);

        totalprice = price - totaldiscount;

        $('#amount').val(totalprice);

        $('#discount_value').val(totaldiscount);

    }

    

}



function discount_total() {

    var totalprice = 0;

    var totaldiscount = 0;

    var totalAmount = 0;

    var discount_per = $('#discount_per').val();

    var qty = $('#qty').val();

    var cost_price = $('#price').val();



    if (qty > 0 && cost_price > 0) {

        totalprice = (qty * cost_price);

        totaldiscount = (qty * cost_price) * (discount_per / 100);

        totalAmount = totalprice - totaldiscount;

        $('#amount').val(totalAmount);

        $('#discount_value').val(totaldiscount);

    }

}

</script>

