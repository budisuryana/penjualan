<div class="form-body">
    <div class="form-group {!! ($errors->has('description') ? 'has-error' : '' ) !!}">
        {!! Form::label('description', 'Description', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('description', null, array('class' => 'form-control')) !!}
            @if($errors->has('description'))
                <span class="help-block">{{ $errors->first('description') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('menu_url') ? 'has-error' : '' ) !!}">
        {!! Form::label('menu_url', 'Menu Url', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('menu_url', null, array('class' => 'form-control')) !!}
            @if($errors->has('menu_url'))
                <span class="help-block">{{ $errors->first('menu_url') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('menu_alias') ? 'has-error' : '' ) !!}">
        {!! Form::label('menu_alias', 'Menu Alias', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('menu_alias', null, array('class' => 'form-control')) !!}
            @if($errors->has('menu_alias'))
                <span class="help-block">{{ $errors->first('menu_alias') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('ismenu') ? 'has-error' : '' ) !!}">
        {!! Form::label('ismenu', 'Is Menu', array('class' => 'col-md-3 control-label')) !!}
        <div class="radio-list">
            <label>{!! Form::radio('ismenu', 'Y', true) !!} Yes</label>
            <label>{!! Form::radio('ismenu', 'N', false) !!} No</label>
            @if($errors->has('ismenu'))
                <span class="help-block">{{ $errors->first('ismenu') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('parent') ? 'has-error' : '' ) !!}">
        {!! Form::label('parent', 'Parent', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::select('parent', $parent, null, array('class' => 'form-control select2me')) !!}
            @if($errors->has('parent'))
                <span class="help-block">{{ $errors->first('parent') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('menu_icon') ? 'has-error' : '' ) !!}">
        {!! Form::label('menu_icon', 'Menu Icon', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('menu_icon', null, array('class' => 'form-control')) !!}
            @if($errors->has('menu_icon'))
                <span class="help-block">{{ $errors->first('menu_icon') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('menu_order') ? 'has-error' : '' ) !!}">
        {!! Form::label('menu_order', 'Menu Order', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('menu_order', null, array('class' => 'form-control')) !!}
            @if($errors->has('menu_order'))
                <span class="help-block">{{ $errors->first('menu_order') }}</span>
            @endif
        </div>
    </div>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                {!! Form::submit('Save', array('class' => 'btn green')) !!}
                <a href="{{ URL::previous() }}" class="btn default">Cancel</a>
            </div>
        </div>
    </div>
</div>