@foreach ($menus as $role)
    <li class="start active open">
        <a href="{{ URL::to('dashboard') }}">
            <i class="icon-home"></i>
            <span class="title">Dashboard</span>
        </a>
    </li>
    
    @foreach ($role->appMenu as $mainmenu)
        @if (count($mainmenu->childs)==0 && ($mainmenu->menu_alias != null))
        <li>
            <a href="{{URL::route($mainmenu->menu_alias)}}">
                <i class="{{ $mainmenu->menu_icon }}"></i>
                <span class="title">{{ $mainmenu->description }}</span>
            </a>
        </li>
        @else
            <li>
                <a href="#">
                    <i class="{{ $mainmenu->menu_icon }}"></i>
                    <span class="title">{{ $mainmenu->description }}</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @foreach ($mainmenu->childs as $lv2)
                        
                        @if (count($lv2->childs)==0 && ($lv2->menu_alias != null))
                            <li>
                                <a href="{{URL::route($lv2->menu_alias)}}">
                                <i class="{{ $lv2->menu_icon }}"></i>
                                    {{ $lv2->description }}
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="#">
                                    <i class="{{ $lv2->menu_icon }}"></i>
                                    <span class="title">{{ $lv2->description }}</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    @foreach ($lv2->childs as $lv3)
                                      
                                      @if (count($lv3->childs)==0 && ($lv3->menu_alias != null))  
                                        <li>
                                            <a href="{{URL::route($lv3->menu_alias)}}">
                                            <i class="{{ $lv3->menu_icon }}"></i>
                                                {{ $lv3->description }}
                                            </a>
                                        </li>
                                      @else
                                      <li>
                                          <a href="#">
                                                <i class="{{ $lv3->menu_icon }}"></i>
                                                <span class="title">{{ $lv3->description }}</span>
                                                <span class="arrow"></span>
                                          </a>
                                          <ul class="sub-menu">
                                              @foreach ($lv3->childs as $lv4)
                                                <li>
                                                    <a href="{{URL::route($lv4->menu_alias)}}">
                                                    <i class="{{ $lv4->menu_icon }}"></i>
                                                        {{ $lv4->description }}
                                                    </a>
                                                </li>
                                              @endforeach
                                          </ul>
                                      </li>  
                                     @endif
                                   @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach
@endforeach
