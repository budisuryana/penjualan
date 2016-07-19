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
</div>
<h3 class="page-title">
{{ $title }}
</h3>

<a href="{{ route('menu.create') }}" class="btn blue btn-sm">Add <i class="fa fa-plus-circle"></i></a>
<br/><br/>
<div class="row">
  <div class="col-md-12">
    @include('layouts.partials.alert')
    <div class="portlet box green-haze">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-globe"></i>{{ $title }}
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse">
          </a>
        </div>
      </div>
      <div class="portlet-body">
        <div class="dd" id="nestable_list_1">
          <ol class="dd-list">
            <?php $i=1; ?>
              @foreach($data as $topmenu)
                @if($topmenu->parent == null && count($topmenu->childs)==0)
                  <li class="dd-item" data-id="{{ $i++ }}">
                      <div class="dd-handle">
                      {{ $topmenu->description }}
                      <div style="float:right;">
                      <a href="{{ URL::route('menu.edit', ['id' => $topmenu->menu_id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>  
                      <a href="{{ URL::route('menu.delete', ['id' => $topmenu->menu_id]) }}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a></div>
                      </div>
                  </li>
                @elseif($topmenu->parent == null && count($topmenu->childs) > 0)                               
                <li class="dd-item" data-id="{{ $i++ }}">
                  <div class="dd-handle">{{ $topmenu->description }}
                    <div style="float:right;">
                    <a href="{{ URL::route('menu.edit', ['id' => $topmenu->menu_id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>  
                    <a href="{{ URL::route('menu.delete', ['id' => $topmenu->menu_id]) }}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a></div>
                  </div>
                  <ol class="dd-list">
                  @foreach($topmenu->childs as $submenu)
                    @if(count($submenu->childs)==0 )
                      <li class="dd-item" data-id="3">
                          <div class="dd-handle">{{ $submenu->description }}
                            <div style="float:right;">
                            <a href="{{ URL::route('menu.edit', ['id' => $submenu->menu_id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>  
                            <a href="{{ URL::route('menu.delete', ['id' => $submenu->menu_id]) }}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a></div>
                          </div>
                      </li>
                      @elseif(count($submenu->childs) > 0)
                        <li class="dd-item" data-id="2">
                        <div class="dd-handle">{{ $submenu->description }}
                          <div style="float:right;">
                          <a href="{{ URL::route('menu.edit', ['id' => $submenu->menu_id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>  
                          <a href="{{ URL::route('menu.delete', ['id' => $submenu->menu_id]) }}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a></div>
                        </div>
                        <ol class="dd-list">
                          @foreach($submenu->childs as $hasmenu)
                          <li class="dd-item" data-id="3">
                                <div class="dd-handle">{{ $hasmenu->description }}
                                  <div style="float:right;">
                                  <a href="{{ URL::route('menu.edit', ['id' => $hasmenu->menu_id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>  
                                  <a href="{{ URL::route('menu.delete', ['id' => $hasmenu->menu_id]) }}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a></div>
                                </div>
                            </li>
                            @endforeach
                        </ol>
                    </li>
                      @endif
                  @endforeach    
                  </ol>
                </li>
              @endif
            @endforeach
          </ol>
        </div>
      </div>
    </div>
  </div>  
</div>

@endsection

 
              
                  
                                                 
                
                      

                  
                