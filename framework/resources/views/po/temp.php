<br/>
<h3>PO Detail</h3>
<div class="row">
<div class="col-md-12">
<div class="portlet">
      <div class="portlet-body">
        <div class="table-container">
          <form name="frm_trx" id="frm_trx">
          <table class="table table-striped table-bordered table-hover" id="table">
          <thead>
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Unit</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Amount</th>
            <th style="text-align:center;">&nbsp;</th>
          </tr>
          </thead>
          <tfoot>
          <tr>
              <th colspan="5" style="text-align:right">Total:</th>
              <th></th>
              <th>&nbsp;</th>
          </tr>
          <tr>
              <th colspan="5" style="text-align:right">Balance Due:</th>
              <th><span id="balance_due">  </span></th>
              <th>&nbsp;</th>
          </tr>
          </tfoot>
          </table>
        </div>
      </div>
    </div>
<br><br>  
<div>
<button type="button" class="btn purple save">
<i class="fa fa-check"></i> Save  
</button>
<a href="<?php echo URL::previous() ?>" class="btn green"><i class="fa fa-reply"></i> Cancel</a>
<a href="#" onclick="clear_po()" class="btn red"><i class="fa fa-trash"></i> Clear</a>
</div>
</form>  
</div>

</div>



</div>
