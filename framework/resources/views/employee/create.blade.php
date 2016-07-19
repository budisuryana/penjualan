@extends('template')
@section('content')

<div class="page-bar">
    <ul class="page-breadcrumb">
      <li>
        <i class="fa fa-home"></i>
        <a href="index.html">Home</a>
        <i class="fa fa-angle-right"></i>
      </li>
      <li>
        <a href="#">{{ $title }}</a>
      </li>
    </ul>
</div><br/>

<div class="row">
    <div class="col-md-12">
        @include('layouts.partials.alert')
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>{{ $title }}
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse">
                    </a>
                </div>
            </div>

            <div class="portlet-body form">
                {!! Form::open(array('route' => 'employee.store', 'class' => 'form-horizontal')) !!}
                @include('employee._form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
    $('#country').on('change', function(e){
        console.log(e);
        var country_id = e.target.value;

        $.get('{{ url('information') }}/country-state-city-ajax?country_id=' + country_id, function(data) {
            console.log(data);
            $('#state').empty();
            $.each(data, function(index,subCatObj){
                $('#state').append(''+subCatObj.name+'');
            });
        });
    });
</script>