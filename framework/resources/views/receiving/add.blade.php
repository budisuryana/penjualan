<div class="row">
<div class="col-md-12">
<form id="form_add_item" class="form-horizontal" role="form">
<input name="id" type="hidden" id="id" />
    <div class="form-body">
    <div class="form-group">
        <label class="control-label col-md-3">Item Name </label>
        <div class="col-md-9">
            <input name="item_name" type="text" class="form-control" id="item_name"/>
            <input type="hidden" name="item_id" id="item_id">
        </div>
    </div>
                        
    <div class="form-group">
        <label class="control-label col-md-3">Stock </label>
        <div class="col-md-9">
            <input name="stock" type="text" class="form-control" id="stock" readonly="readonly" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Quantity </label>
        <div class="col-md-9">
            <input name="qty" type="text" class="form-control" id="qty"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Price </label>
        <div class="col-md-9">
            <input name="price" type="text" class="form-control" id="price" readonly="readonly"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Discount (%) </label>
        <div class="col-md-9">
            <input name="discount_per" type="text" class="form-control" id="discount_per" value="0" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Discount ($) </label>
        <div class="col-md-9">
            <input name="diskonrp" type="text" class="form-control" id="diskonrp" readonly="readonly"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Sub Total </label>
        <div class="col-md-9">
            <input name="amount" type="text" class="form-control" id="amount" readonly="readonly"/>
        </div>
    </div>

    <div class="form-actions">
        <div class="row">
           <div class="col-md-offset-3 col-md-9">
           <button type="submit" class="btn green ok">Submit</button>
           </div>
        </div>
    </div>
    </div>
</form>
</div>
</div>
