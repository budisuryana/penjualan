<div class="form-body">
    <div class="form-group {!! ($errors->has('typecode') ? 'has-error' : '' ) !!}">
        {!! Form::label('typecode', 'Code', array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('typecode', null, array('class' => 'form-control')) !!}
            @if($errors->has('typecode'))
                <span class="help-block">{{ $errors->first('typecode') }}</span>
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

    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                {!! Form::submit('Save', array('class' => 'btn green')) !!}
                <a href="{{ URL::previous() }}" class="btn default">Cancel</a>
            </div>
        </div>
    </div>
</div>