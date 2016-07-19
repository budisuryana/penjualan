@include('layouts.partials.alert')

<div class="portlet-body form">
  <form action="{{ url('insert_receiving') }}" class="horizontal-form" method="post" id="form_receiving">
  <input type="hidden" name="id">
    <div class="form-body">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">PO No.</label>
            {!! Form::select('po_no', $po_no, $poSelected, array('class' => 'form-control select2me', 'id' => 'po_no', 'required' => true)) !!}
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">Supplier</label>
            <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $suppID }}">
            <input type="text" id="supplier" class="form-control" name="supplier" value="{{ $suppName }}" readonly="">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">Faktur No.</label>
            <input type="text" id="faktur_no" class="form-control" name="faktur_no">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">Receiving Date</label>
            <input type="text" id="date" class="form-control date-picker" value="{{ date('Y-m-d') }}" name="date">
          </div>
        </div>
        
      </div>
      <!--/row-->
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">Person in Charge</label>
            <input type="text" id="person" class="form-control" name="person">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">Note</label>
            <textarea name="note" class="form-control" rows="5" cols="50"></textarea>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
<div class="col-md-12">
  <div class="portlet">
    <div class="portlet-title">
      <div class="caption">
        <i class="fa fa-shopping-cart"></i>Order Listing
      </div>
    </div>
    <div class="portlet-body">
      <div class="table-container">
        <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
        <thead>
        
        <tr role="row" class="heading">
          <th rowspan="2" style="text-align:center;vertical-align: middle;">Item Name</th>
          <th colspan="2" style="text-align:center;vertical-align: middle;">Purchasing Order</th>
          <th rowspan="2" style="text-align:center;vertical-align: middle; width: 40px; ">Qty <br/>Received</th>
          <th colspan="8" style="text-align:center;vertical-align: middle; ">Receiving</th>
          <th rowspan="2" style="text-align:center;vertical-align: middle; width: 120px;">Total</th>
          
        </tr>

        <tr role="row" class="heading">  
          <th style="text-align:center;vertical-align: middle; width: 50px;">Qty</th>
          <th style="text-align:center;vertical-align: middle; width: 120px;">Unit</th>
          <th style="text-align:center;vertical-align: middle; width: 50px;">Qty</th>
          <th style="text-align:center;vertical-align: middle; width: 70px;">Batch</th>
          <th style="text-align:center;vertical-align: middle; width: 70px;">Exp.Date<BR>E.g (31-01-2000)</th>
          <th style="text-align:center;vertical-align: middle; width: 120px;">Unit Conversion</th>
          <th style="text-align:center;vertical-align: middle; width: 6px;">Discount (%)</th>
          <th style="text-align:center;vertical-align: middle; width: 120px;">Discount ($)</th>
          <th style="text-align:center;vertical-align: middle; width: 100px;">Price</th>
          <th style="text-align:center;vertical-align: middle; width: 60px;">Tax (%)</th>
        </tr>

        <?php  
        $n = 1;
        $unitId = 0;
        $unitName = '';
        $unitPO = '';
        $conversionUnit = '';
        $batch_no = '';
        $qty = 0;
        $price = 0;
        $qty = 0;
        $subTotal = 0;
        $total = 0;
        $totalTax = 0;
        $pricePlusTax = 0;
        $discValue = 0;
        $qtyPO = 0;
        $pricePO = '';
        $qtyReceiving = 0;
        $itemReceivingId = 0;
        ?>
        @if (!empty($data))
        @foreach($data as $row)
        <?php
        $qtyPO = $row->qty;

        if (isset($row->unit_id)) {
            $rowUnitID   = DB::table('unit')->where('id', $row->unit_id)->value('id');
            $rowUnitName = DB::table('unit')->where('id', $row->unit_id)->value('name');
            $unitId     = $rowUnitID;
            $unitName   = $rowUnitName;
            $unitPO     = $rowUnitName;
        }        
        if ($row->qty > 0) {
            $qty = $row->qty;
        }else{
            $qty = 0;
        }
        if ($row->discount_per > 0) {
            $discPer = $row->discount_per;
        }
        if ($row->discount_value > 0) {
            $discValue = $row->discount_value;
        }
        
        if ($row->price > 0) {
            $price = (float) $row->price;
            $pricePO = (float) $row->price;
        }
        
        

        if(!empty($row->unit_conversion_id)){
            $conversionUnit = $row->unit_conversion_id;
        }

        $complete_date = '';
        

        

        $complete_date = date('d-m-Y');        
        $qty = ($qty * $price) - $discValue;
        $totalTax = $qty * ($row->tax / 100);
        $pricePlusTaxx = $qty + $totalTax;
        $pricePlusTax  = floor($pricePlusTaxx);
        $subTotal = $subTotal + $pricePlusTax;
        $total = $subTotal - $discount;        
        ?>
        <tr role="row" class="filter" id="<?php echo $n ?>">
          <td>
            <span id="item_name_show"> {{ $row->item_name }} </span>
            <input type="hidden" name="item_id<?php echo $n ?>" id="item_id<?php echo $n ?>" value="{{ $row->item_id }}">
            <input type="hidden" name="previous_qty<?php echo $n ?>" value="<?php echo $qtyReceiving ?>" />
            <input type="hidden" name="previous_price<?php echo $n ?>" value="<?php echo (int) $price ?>" />
            <input type="hidden" id="count_po<?php echo $n ?>" name="count_po<?php echo $n ?>" value="<?php echo $row->qty ?>" />
          </td>
          <td style="text-align:right;">
            <span id="count_po<?php echo $n ?>"> {{ $row->qty }} </span>
          </td>
          <td><?php echo $unitPO; ?></td>
          <td style="text-align:right;">
            <span id="qty_received<?php echo $n ?>"><?php echo $qtyReceiving ?></span>
          </td>
          <td>
            <input type="text" class="form-control form-filter input-sm qty" name="qty<?php echo $n ?>" id="qty<?php echo $n ?>" value="<?php echo $row->qty ?>" style="width:50px;text-align:right;">
          </td>
          <td>
            <input type="text" class="form-control form-filter input-sm batch" name="batch<?php echo $n ?>" id="batch<?php echo $n ?>" value="<?php echo $batch_no; ?>" style="width:80px;text-align:right;">
          </td>
          <td>
            <input type="text" class="form-control form-filter input-sm exp_date" name="exp_date<?php echo $n ?>" value="<?php echo $complete_date; ?>" id="exp_date<?php echo $n ?>" style="width:90px;text-align:right;"/>
          </td>
          <td>
            {!! Form::select('unit_conversion_id' . $n, $options_conversion, $conversionUnit, array('class' => 'form-control select2me unit_conversion', 'id' => 'unit_conversion_id' . $n)) !!}
          </td>
          <td>
            <input type="text" class="form-control form-filter input-sm discount_per" name="discount_per<?php echo $n ?>" id="discount_per<?php echo $n ?>" value="<?php echo $row->discount_per ?>" style="text-align:right;"/>
          </td>
          <td style="text-align:right;">
            <span id="discountshow<?php echo $n ?>"><?php echo number_format($row->discount_value, 0, ",", "."); ?></span>
            <input type="hidden" class="form-control form-filter input-sm discount_value" name="discount_value<?php echo $n ?>" id="discount_value<?php echo $n ?>" value="<?php echo $row->discount_value ?>" />
          </td>
          <td style="text-align:right;">
            <input type="text" class="form-control form-filter input-sm price" name="price<?php echo $n ?>" id="price<?php echo $n ?>" value="<?php echo (int) $price ?>">
          </td>
          <td style="text-align:right;">
            <input type="text" class="form-control form-filter input-sm tax" name="tax<?php echo $n ?>" id="tax<?php echo $n ?>" value="<?php echo (int) $row->tax ?>">
          </td>
          <td style="text-align:right;">
            <input type="text" class="form-control form-filter input-sm subtotal_cost" name="subtotal_cost<?php echo $n ?>" id="subtotal_cost<?php echo $n ?>" value="<?php echo (int) $pricePlusTax ?>">
          </td>
          
        </tr>
        <?php $n++; ?>
        @endforeach
        @endif
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="12" style="text-align:right;font-size:15px;">SUB TOTAL&nbsp;&nbsp;&nbsp;</td>
            <td colspan="2" style="text-align:right;">
                <input type="hidden" name="max_item" id="max_item" value="<?php echo ($n-1)?>"/>
                <input type="text" name="sub_total" class="form-control form-filter input-sm" id="sub_total" value="<?php echo $subTotal ?>" style="text-align:right;" readonly="readonly"></td>
        </tr>
        <tr>
            <td colspan="12" style="text-align:right;font-size:15px;">DISCOUNT ($)&nbsp;&nbsp;&nbsp;</td>
            <td colspan="2" style="text-align:right;"><input type="text" name="discount" id="discount" value="<?php echo $discount ?>" 
            style="text-align:right;" class="form-control form-filter input-sm"/></span></td>
        </tr>
        <tr>
            <td colspan="12" style="text-align:right;font-size:15px;">TOTAL&nbsp;&nbsp;&nbsp;</td>
            <td colspan="2" style="text-align:right;"><input type="text" name="total_cost" id="total_cost" value="<?php echo $total ?>" style="text-align:right;" readonly="readonly" class="form-control form-filter input-sm"></span></td>
        </tr>
        
    </tfoot>
        </table>
      </div>
    </div>
    <div class="actions">
    <button type="button" class="btn btn-primary" id="save-button"><i class="fa fa-check"></i>
    <span class="hidden-480">
    Save </span></button>
    </div>
    </form>  
  </div>
</div>
</div>
<input type="hidden" name="allow_submit" id="allow_submit" />
<div id="load-check-no-faktur"></div>
<div id="confirm-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>Confirmation</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure want to save this data ?</p>
            </div>
            <div class="modal-footer">
                <a id="confirm-modal-cancel" href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
                <a id="confirm-modal-continue" href="#" class="btn btn-danger">Continue</a>
            </div>
        </div>
    </div>
</div>
<div id="confirm-no-faktur-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>Confirmation</h3>
            </div>
            <div class="modal-body">
                <p>Faktur No has already taken! Please try another</p>
            </div>
            <div class="modal-footer">
                <a id="delete-modal-cancel" href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>                
            </div>
        </div>
    </div>
</div>
<div id="confirm-qty-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>Confirmation</h3>
            </div>
            <div class="modal-body">
                <p>The quantity of receiving exceeds of the quantity order!</p>
            </div>
            <div class="modal-footer">
                <a id="delete-modal-cancel" href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>                
            </div>
        </div>
    </div>
</div>
<script>
  $(function() {

    $("select[name='po_no']").on('change', function() {
            var po_no = $(this).val();
            window.location = "<?php echo url('addreceiving') ?>" + "/" + po_no;
        });

    $('#faktur_no').on('change', function() {
        var noFaktur = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo url('check_no_faktur') ?>",
            data: {faktur_no: noFaktur}
        }).done(function(result) {
            if (result == 1) {
                $('#confirm-no-faktur-modal').modal('show');
                $('#faktur_no').val('');
            }
        });
    });

    $('#save-button').on('click', function(e) {
       $('#confirm-modal').modal('show');
       $('#confirm-modal-continue').on('click', function(){
           $('#form_receiving').submit();
       })
      
    });

    $('.qty').bind('keyup', function() {
            var receivingId = $('input[name=id]').val();
            qtyAttId = this.id;
            i = qtyAttId.replace('qty', "");
            qtyPO = $('#count_po' + i).text();
            qtyReceive = $('#qty_received' + i).text();

            if (parseFloat(qtyReceive) > 0) {
                qtyReceive = 0;
            }

            if ((parseFloat(qtyPO) - parseFloat(qtyReceive)) < $(this).val()) {
                $('#confirm-qty-modal').modal('show');
                $(this).val('');
                $('#allow_submit').val('N');
            } else {
                $('#allow_submit').val('Y');
            }

            calculate_cost(i);

    });

    $('.price').bind('keyup', function() {
        var priceAttId = this.id;
        var i = priceAttId.replace('price', "");
        calculate_total_per_item(i);
         
    });

    $('#discount').bind('keyup', function() {
        calculate_total();
    });

    $('.discount_per').bind('keyup', function() {
        var discount_per = this.id;
        var i = discount_per.replace('discount_per', "");
        calculate_total_per_item(i);
        
    });
    
    $('.tax').bind('keyup', function() {
        var tax = this.id;
        var i = tax.replace('tax', "");
        calculate_total_per_item(i);
    });

    function calculate_total_per_item(i) 
    {
        var taxPercent       = $('#tax' + i).val();  
        var discountPercent  = $('#discount_per' + i).val();
        var qty              = $('#qty' + i).val();
        var price            = parseFloat($('#price' + i).val().replace(/\./g, '').replace(/\,/g, '.'));

        discountValue = 0;
        taxValue      = 0;
        totalCost     = 0;

        if (qty > 0 && price > 0) 
        {
              if(parseInt(discountPercent) > 0)
              {
                  discountValue  = parseFloat(price * (discountPercent / 100));
              }
      
              if(parseInt(taxPercent) > 0)
              {
                taxValue    = parseFloat((price-discountValue)*(taxPercent/100));
              }

              totalCost     = (((price-discountValue)+taxValue)*qty).toFixed(2);
              $('#subtotal_cost' + i).val(totalCost);
              $('#discountshow' + i).text(discountValue);
              $('#discount_value' + i).val(discountValue);
        }
        
        calculate_total();
    }

    function calculate_cost(i) 
    {
        var id = $('input[name=id]').val();
        var discount_per = $('#discount_per' + i).val();
        var qty = $('#qty' + i).val();
        var costPrice = $('#price' + i).val().replace(/\./g, '');
        var tax       = $('#tax' + i).val() / 100;  
        
        if (qty > 0 && costPrice > 0) 
        {
            var price = qty * costPrice;
            var totalDiscount     = (costPrice) * (discount_per / 100);
            var total_Price       = price - totalDiscount;
            var totalTax          = total_Price * tax;
            var totalPricePlusTax = total_Price + totalTax;
            var totalPrice        = totalPricePlusTax.toFixed(2);

            $('#discountshow' + i).text(totalDiscount);
            $('#discount_value' + i).val(totalDiscount);
            $('#subtotal_cost' + i).val(totalPrice);
        }
        else
        {
            $('#discountshow' + i).text(0);
            $('#discount_value' + i).val(0);
            $('#subtotal_cost' + i).val(0);
        }

        calculate_total();
    }

    function calculate_discount(i) 
    {
            var totalPrice = 0;
            var totalTax = 0;
            var pricePlusTax = 0;
            var totalDiscount = 0;
            var totalPrice2 = 0;
            var total_Price = 0;
            var tax       = $('#tax' + i).val();  
            var discount_per = $('#discount_per' + i).val();
            var qty = $('#qty' + i).val();
            var costPrice = parseFloat($('#price' + i).val().replace(/\./g, ''));

            if (qty > 0 && costPrice > 0) 
            {
                
                discount      = costPrice * (discount_per / 100);
                taxValue      = totalPrice * (tax / 100);
                totalPrice    = (((costPrice-discount)+taxValue)*qty).toFixed(2);

                pricePlusTax  = total_Price + pricePlusTax;
                totalPrice2   = parseInt(pricePlusTax);
                
                $('#subtotal_cost' + i).val(totalPrice);
                $('#discountshow' + i).text(discount);
                $('#discount_value' + i).val(discount);
            }
            
            calculate_total();
    }
        
    function calculate_tax(i) 
    {
        var id = $('input[name=id]').val();
        var discount_per = $('#discount_per' + i).val();
        var qty = $('#qty' + i).val();
        var costPrice = $('#price' + i).val().replace(/\./g, '');
        var tax       = $('#tax' + i).val() / 100;  
        
        if (qty > 0 && costPrice > 0) {
            var price = qty * costPrice;
            var totalDiscount = (qty * costPrice) * (discount_per / 100);
            var total_Price = price - totalDiscount;
            var totalTax    = total_Price * tax;
            var totalPricePlusTax = total_Price + totalTax;
            var totalPrice = totalPricePlusTax.toFixed(2);

            $('#discountshow' + i).text(totalDiscount);
            $('#discount_value' + i).val(totalDiscount);
            $('#subtotal_cost' + i).val(totalPrice);
        }
        
        calculate_total();
    }
        
    function calculate_total() 
    {
        subTotal   = 0;
        totalPrice = 0;
        $('.total_cost').each(function() {
            var val = $(this).val();
            console.debug(val);
            subTotal = subTotal + parseFloat(val);
        });

        $('#sub_total').val(subTotal);

        var subTotal = $('#sub_total').val();
        var discount = $('#discount').val();
        totalPrice = parseFloat(subTotal - discount);
        $('#total_cost').val(totalPrice);
    }
        
    $('.dateExp').bind('change', function() {
        var tglExpId = this.id;
        i = tglExpId.replace('dateExp', "");
        txtVal = $('#dateExp'+i).val();
        if(isDate(txtVal)){
        }else{
            alert('Invalid Date');
            $('#dateExp'+i).val('');
        }
    });

    function isDate(txtDate)
{
    var currVal = txtDate;
    if(currVal == '')
        return false;

    var rxDatePattern = /^(0?[1-9]|[12][0-9]|3[01])[\-\-](0?[1-9]|1[012])[\-\-]\d{4}$/; //Declare Regex
//    var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; //Declare Regex
    var dtArray = currVal.match(rxDatePattern); // is format OK?

    if (dtArray == null) 
        return false;

    //Checks for mm/dd/yyyy format.
    dtMonth = dtArray[3];
    dtDay= dtArray[5];
    dtYear = dtArray[1];        

    if (dtMonth < 1 || dtMonth > 12) 
        return false;
    else if (dtDay < 1 || dtDay> 31) 
        return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
        return false;
    else if (dtMonth == 2) 
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay> 29 || (dtDay ==29 && !isleap)) 
                return false;
    }
    return true;
}

   }); 
</script>

<script type="text/javascript">
  function fullScreen() {
    window.open("", "_self", 'fullscreen=yes, scrollbars=auto');
  }
</script>