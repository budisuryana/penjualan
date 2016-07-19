<div class="row">
<div class="col-md-12">
<form id="form_po_return" class="form-horizontal" role="form">
<input name="id" type="hidden" id="id" />

    <div class="form-body">
    <div class="form-group">
        <label class="control-label col-md-3">Item Name </label>
        <div class="col-md-9">
            <input name="item_name1" type="text" class="form-control" id="item_name1"/>
            <input type="hidden" name="item_id1" id="item_id1">
        </div>
    </div>
                        
    <div class="form-group">
        <label class="control-label col-md-3">Stock </label>
        <div class="col-md-9">
            <input name="stock1" type="text" class="form-control" id="stock1"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Quantity </label>
        <div class="col-md-3">
            <input name="qty1" type="text" class="form-control" id="qty1"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Description </label>
        <div class="col-md-9">
        <textarea name="description" class="form-control" id="description" rows="5"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Price </label>
        <div class="col-md-9">
            <input name="price1" type="text" class="form-control" id="price1"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Sub Total </label>
        <div class="col-md-9">
            <input name="amount1" type="text" class="form-control" id="amount1"/>
        </div>
    </div>

    <div class="form-actions">
        <div class="row">
           <div class="col-md-offset-3 col-md-9">
           <button type="submit" class="btn green return">Submit</button>
           </div>
        </div>
    </div>
    </div>
</form>
</div>
</div>