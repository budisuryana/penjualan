<div class="form-body">
    <div class="form-group {!! ($errors->has('employeecode') ? 'has-error' : '' ) !!}">
        {!! Form::label('employeecode', 'Code', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('employeecode', null, array('class' => 'form-control')) !!}
            @if($errors->has('employeecode'))
                <span class="help-block">{{ $errors->first('employeecode') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('name') ? 'has-error' : '' ) !!}">
        {!! Form::label('name', 'Name', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('name', null, array('class' => 'form-control')) !!}
            @if($errors->has('name'))
                <span class="help-block">{{ $errors->first('name') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('address') ? 'has-error' : '' ) !!}">
        {!! Form::label('address', 'Address', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::textarea('address', null, array('class' => 'form-control', 'rows' => 5)) !!}
            @if($errors->has('address'))
                <span class="help-block">{{ $errors->first('address') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('city') ? 'has-error' : '' ) !!}">
        {!! Form::label('city', 'City', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('city', null, array('class' => 'form-control')) !!}
            @if($errors->has('city'))
                <span class="help-block">{{ $errors->first('city') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('zip_code') ? 'has-error' : '' ) !!}">
        {!! Form::label('zip_code', 'Postal Code', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('zip_code', null, array('class' => 'form-control')) !!}
            @if($errors->has('zip_code'))
                <span class="help-block">{{ $errors->first('zip_code') }}</span>
            @endif
        </div>
    </div>

    

    <div class="form-group {!! ($errors->has('phone') ? 'has-error' : '' ) !!}">
        {!! Form::label('phone', 'Phone', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('phone', null, array('class' => 'form-control')) !!}
            @if($errors->has('phone'))
                <span class="help-block">{{ $errors->first('phone') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group {!! ($errors->has('email') ? 'has-error' : '' ) !!}">
        {!! Form::label('email', 'Email', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('email', null, array('class' => 'form-control')) !!}
            @if($errors->has('email'))
                <span class="help-block">{{ $errors->first('email') }}</span>
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


