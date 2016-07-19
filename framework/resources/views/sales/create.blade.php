<link rel="stylesheet" href="http://codeorigin.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<?php
$encrypter = app('Illuminate\Encryption\Encrypter');
$encrypted_token = $encrypter->encrypt(csrf_token());
 ?>
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
<br>
<div class="row">
  <div class="col-md-12">
    <div class="alert alert-danger info" style="display:none;">
        <ul></ul>
    </div>
    {!! Form::open(array('route' => 'sale.store', 'class' => 'horizontal-form', 'role' => 'form', 'method' => 'post')) !!}
    {!! Form::hidden('invoice', $invoice, array('id' => 'invoice')) !!}
    <input id="token" type="hidden" value="{{$encrypted_token}}">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Invoice</label>
          {!! Form::text('invoice_no', $invoice, array('class' => 'form-control', 'readonly' => true)) !!}
          @if($errors->has('invoice_no'))
                <span class="help-block" style="color:red;">{{ $errors->first('invoice_no') }}</span>
          @endif
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Customer</label>
          {!! Form::select('customer_id', $customer, $custID, array('class' => 'form-control select2me', 'id' => 'customerid')) !!}
          @if($errors->has('customer_id'))
                <span class="help-block" style="color:red;">{{ $errors->first('customer_id') }}</span>
          @endif
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Invoice Date</label>
          {!! Form::text('invoice_date', date('Y-m-d'), array('class' => 'form-control date-picker', 'id' => 'invoice_date')) !!}
           @if($errors->has('invoice_date'))
                <span class="help-block" style="color:red;">{{ $errors->first('invoice_date') }}</span>
          @endif
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
</div>

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-body">
        <div class="table-container">
          <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
            <thead>
            <tr role="row" class="heading">
                <th width="10%">Product</th>
                <th width="5%">Qty</th>
                <th width="10%">Price</th>
                <th width="10%">Discount (%)</th>
                <th width="10%">Discount ($)</th>
                <th width="10%">Amount</th>
                <th width="5%">&nbsp;</th>
            </tr>
            <tr role="row" class="filter">
                <td>
                    {!! Form::hidden('productcode', null, array('id' => 'id')) !!}
                    {!! Form::text('name', null, array('class' => 'form-control form-filter input-sm', 'id' => 'name')) !!}
                    
                </td>
                <td>
                    {!! Form::text('qty', null, array('class' => 'form-control form-filter input-sm', 'id' => 'qty', 'onkeyup' => 'cost_total()')) !!}
                    
                </td>
                <td>
                    {!! Form::text('price', null, array('class' => 'form-control form-filter input-sm', 'id' => 'price', 'readonly' => true)) !!}
                    
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
                    {!! Form::button('Add', array('class' => 'btn btn-primary btn-sm add', 'name' => 'op')) !!}
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
                <a href="{{url('sale/deleteitem', $i++)}}" class="btn btn-xs btn-danger">
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
    <div class="pull-right">
    @if(count(Session::has('items')))
    {!! Form::submit('Save', array('name' => 'op', 'class' => 'btn btn-sm purple')) !!}
    <a href="#" onclick="clear_sale()" class="btn red btn-sm"><i class="fa fa-trash"></i> Clear</a>
    @endif
  </div>   
  </div>
</div>
{!! Form::close() !!}
@endsection

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
{!! Html::script("/assets/app/ajax-sale.js") !!}
<script type="text/javascript">
function clear_sale()
{
  if(confirm('Do you want to leave without saving ?'))
  {
    
      $.ajax({
        url : "{{ url('clearsale') }}",
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {
           reload_table();
           $('[name="customername"]').val('');
           $('[name="email"]').val('');
           $('[name="address"]').val('');
        }
    });

  }
}

function cost_total() {
    var price = 0;
    var totalprice = 0;
    var totaldiscount = 0;
    var discount_per = $('#discount_per').val();
    var qty = $('#qty').val();
    var sell_price = $('#price').val();

    if (qty > 0 && sell_price > 0) {
        price = (qty * sell_price);
        totaldiscount = (qty * sell_price) * (discount_per / 100);
        totalprice = price - totaldiscount;
        $('#discount_value').val(totaldiscount);
        $('#discount_per').val(totaldiscount);
        $('#amount').val(totalprice);
        
    }

}

function discount_total() {
    var totalprice = 0;
    var totaldiscount = 0;
    var totalAmount = 0;
    var discount_per = $('#discount_per').val();
    var qty = $('#qty').val();
    var sell_price = $('#price').val();

    if (qty > 0 && sell_price > 0) {
        totaldiscount = (qty * sell_price) * (discount_per / 100);
        totalprice = (qty * sell_price);
        totalAmount = totalprice - totaldiscount;
        $('#amount').val(totalAmount);
        $('#discount_value').val(totaldiscount);
    }
    
}
</script>
<script type="text/javascript">
$(function(){
  $("#name").autocomplete({
      source: "{{ route('autocomplete.product') }}",
      minLength: 1,
      select: function( event, ui ) {
          var itemId = event.target.id;
          $('#id').val(ui.item.id);
          $('#name').val(ui.item.value);
          $('#price').val(ui.item.sell_price);
          $('#description').val(ui.item.description);
      }
  });

  $('.date-picker').datepicker({
      showOn: "button",
      changeMonth: true,
      changeYear: true,
      yearRange: "-1:+0",
      format: "yyyy-mm-dd",
      maxDate: '0',
      language: 'id',
      highLight: true,
      autoclose: true
  });

});
</script>



