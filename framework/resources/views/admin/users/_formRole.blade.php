

<div class="form-body">

    <div class="form-group">

        {!! Form::label('name', 'Role Name', array('class' => 'col-md-3 control-label')) !!}

        <div class="col-md-4">

            {!! Form::text('name', null, array('class' => 'form-control')) !!}

        </div>

    </div>

<div class="portlet box green-haze">

    <div class="portlet-title">

        <div class="caption">

          <i class="fa fa-globe"></i>Menu Access

        </div>

        <div class="tools">

          <a href="javascript:;" class="collapse">

          </a>

        </div>

    </div>

    <div class="portlet-body">

       <table class="table table-striped table-bordered table-hover" id="sample_2">

          <thead>

            <tr>
              <th>No.</th>
              <th>Menu ID</th>
              <th>Description</th>
              <th>Type</th>
              <th>Access</th>
            </tr>

          </thead>

          <tbody>
               <?php $i = 1 ?> 
               @foreach ($appMenu as $menu)
                  <tr>
                    <td style="text-align:center;width:5%;">{{ $i++ }}</td>
                    <td style="text-align:center;width:8%;">{{ $menu->menu_id }}</td>
                    <td>{{ $menu->description }}</td>
                    <td><b>
                        @if (is_null($menu->parent)) Main Menu @else Action @endif
                    </b></td>
                    <td style="text-align:center;width:5%;">                                    
                        {!! Form::checkbox("menu_id[$menu->menu_id]", $menu->menu_id, null, 
                        array($menu->checked ? 'checked' : null)) !!}
                    </td>
                  </tr>

                @foreach($menu->childs as $level2)

                    <tr>
                        <td style="text-align:center;width:5%;">{{ $i++ }}</td>
                        <td style="text-align:center;width:8%;">{{ $level2->menu_id }}</td>

                        <td>{{$level2->description}}</td>

                        <td><b><i>

                            @if (!is_null($level2->parent)) Sub Menu Level 2 @else Action @endif

                        </i></b></td>

                        <td style="text-align:center;width:5%;">

                            {{Form::checkbox("menu_id[$level2->menu_id]", $level2->menu_id, null, array($level2->checked ? 'checked' : null))}}

                        </td>

                    </tr>

                @foreach($level2->childs as $level3)

                    <tr>
                        <td style="text-align:center;width:5%;">{{ $i++ }}</td>
                        <td style="text-align:center;width:8%;">{{ $level3->menu_id }}</td>

                        <td>{{ $level3->description }}</td>

                        <td><i>

                            @if (!is_null($level3->parent)) Sub Menu Level 3 @else Action @endif

                        </i></td>

                        <td style="text-align:center;width:5%;">

                            {!! Form::checkbox("menu_id[$level3->menu_id]", $level3->menu_id, null, array($level3->checked ? 'checked' : null)) !!}

                        </td>

                    </tr>

                @foreach($level3->childs as $level4)

                    <tr>
                        <td style="text-align:center;width:5%;">{{ $i++ }}</td>
                        <td style="text-align:center;width:8%;">{{ $level4->menu_id }}</td>

                        <td>{{ $level4->description }}</td>

                        <td><i>

                            @if (!is_null($level4->parent)) Sub Menu Level 4 @else Action @endif

                        </i></td>

                        <td style="text-align:center;width:5%;">

                            {!! Form::checkbox("menu_id[$level4->menu_id]", $level4->menu_id, null, array($level4->checked ? 'checked' : null)) !!}

                        </td>

                    </tr>

                @endforeach

              @endforeach

            @endforeach

          @endforeach 

        </tbody>

      </table>

   </div>
   
</div>

@if(isset($pageAccess))

<div class="portlet box green-haze">

    <div class="portlet-title">

        <div class="caption">

          <i class="fa fa-globe"></i>Page Access

        </div>

        <div class="tools">

          <a href="javascript:;" class="collapse">

          </a>

        </div>

    </div>

    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover" id="sample_3">
          <thead>
            <tr>
              <th>Menu ID</th>
              <th>Description</th>
              <th>Route</th>
              <th>Page</th>
              <th>Access</th>
            </tr>
          </thead>
          <tbody>
           <?php $i = 1 ?>
           @foreach ($pageAccess as $akses)
              <tr>
                <td style="text-align:center;width:8%;">{{ $akses->menu_id }}</td>
                <td>{{ $akses->description }}</td>
                <td>{{ $akses->menu_alias }}</td>
                <td>{{ $rolename }}</td>
                <td style="text-align:center;width:5%;">                                    
                    {!! Form::checkbox("akses_id[$akses->menu_id]", $akses->menu_id, null, 
                    array($akses->checked ? 'checked' : null)) !!}
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
    
</div>   

@endif



    <div class="form-actions">

        <div class="row">

            <div class="col-md-offset-3 col-md-9">

                {!! Form::submit('Save', array('class' => 'btn green')) !!}

                <a href="{{ URL::previous() }}" class="btn default">Cancel</a>

            </div>

        </div>

    </div>

</div>