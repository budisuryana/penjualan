<div class="tab-pane active" id="tab_0">
    <div class="portlet-body form">
        <div class="form-body">
        <div class="form-group">
            {!! Form::label('productcode', 'Code', array('class' => 'col-md-3 control-label')) !!}
            <div class="col-md-4">
                {!! Form::text('productcode', null, array('class' => 'form-control', 'id' => 'productcode')) !!}
                @if($errors->has('productcode'))
                <span class="help-block" style="color:red;">{{ $errors->first('productcode') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('name', 'Name', array('class' => 'col-md-3 control-label')) !!}
            <div class="col-md-4">
                {!! Form::text('name', null, array('class' => 'form-control', 'id' => 'name')) !!}
                @if($errors->has('name'))
                <span class="help-block" style="color:red;">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('category_id', 'Category', array('class' => 'col-md-3 control-label')) !!}
            <div class="col-md-4">
                {!! Form::select('category_id', $category, null, array('class' => 'form-control select2me', 'id' => 'category_id', 'placeholder' => 'Please Select')) !!}
                @if($errors->has('category_id'))
                <span class="help-block" style="color:red;">{{ $errors->first('category_id') }}</span>
                @endif
            </div>
        </div>
        </div>
    </div>
</div>

<div class="tab-pane" id="tab_1">
    <div class="portlet-body form">
        <div class="form-body">
        <div class="form-group">
            {!! Form::label('stock', 'Stock', array('class' => 'col-md-3 control-label')) !!}
            <div class="col-md-4">
                {!! Form::text('stock', null, array('class' => 'form-control', 'onkeypress' => 'validate(event)', 'id' => 'stock')) !!}
                @if($errors->has('stock'))
                <span class="help-block" style="color:red;">{{ $errors->first('stock') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('cost_price', 'Cost Price', array('class' => 'col-md-3 control-label')) !!}
            <div class="col-md-4">
                {!! Form::text('cost_price', null, array('class' => 'form-control', 'onkeypress' => 'validate(event)', 'id' => 'cost_price')) !!}
                @if($errors->has('cost_price'))
                <span class="help-block" style="color:red;">{{ $errors->first('cost_price') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('sell_price', 'Sell Price', array('class' => 'col-md-3 control-label')) !!}
            <div class="col-md-4">
                {!! Form::text('sell_price', null, array('class' => 'form-control', 'onkeypress' => 'validate(event)', 'id' => 'sell_price')) !!}
                @if($errors->has('sell_price'))
                <span class="help-block" style="color:red;">{{ $errors->first('sell_price') }}</span>
                @endif
            </div>
        </div>    
        </div>
    </div>
</div>

<div class="tab-pane" id="tab_2">
    <div class="portlet-body form">
        <div class="form-body">
            <div class="form-group">
            {!! Form::label('supplier_id', 'Supplier', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="icheck-list">
                            @foreach ($supplier as $supp)
                            <label>
                            {!! Form::checkbox("supplier_id[$supp->id]", $supp->id, null, array($supp->checked ? 'checked' : null)) !!}
                            {!! $supp->name !!}
                            </label>
                            @endforeach
                            @if($errors->has('supplier_id'))
                                <span class="help-block" style="color:red;">{{ $errors->first('supplier_id') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane" id="tab_3">
    <div class="portlet-body form">
        <div class="form-body">
            <div class="row fileupload-buttonbar">
                <div class="col-lg-12">
                    <span class="btn green fileinput-button">
                    <i class="fa fa-plus"></i>
                    <span>
                    Add files... </span>
                    <input type="file" name="files[]" multiple="">
                    </span>
                    <button type="submit" class="btn blue start">
                    <i class="fa fa-upload"></i>
                    <span>
                    Start upload </span>
                    </button>
                    <button type="reset" class="btn warning cancel">
                    <i class="fa fa-ban-circle"></i>
                    <span>
                    Cancel upload </span>
                    </button>
                    <button type="button" class="btn red delete">
                    <i class="fa fa-trash"></i>
                    <span>
                    Delete </span>
                    </button>
                    <input type="checkbox" class="toggle">
                    <span class="fileupload-process">
                    </span>
                </div>
                <div class="col-lg-5 fileupload-progress fade">
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;">
                        </div>
                    </div>
                    <div class="progress-extended">
                         &nbsp;
                    </div>
                </div>
            </div>
            <table role="presentation" class="table table-striped clearfix">
            <tbody class="files">
            </tbody>
            </table>
        </div>
    </div>
</div>

{!! Html::script("/assets/global/plugins/jquery.min.js") !!}
{!! Html::script("/assets/jquery.elevatezoom.js") !!}
<script type="text/javascript">
function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>