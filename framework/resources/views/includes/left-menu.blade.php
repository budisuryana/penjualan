

@foreach ($menus as $group)
    <li class="start active open">
        <a href="{{ URL::to('dashboard') }}"><i class="icon-home"></i><span class="title">Dashboard</span></a>
    </li>
    @foreach ($group->appMenu as $menuKat)
        <li class="xn-title">{{ $menuKat->description }}</li>
        @foreach ($menuKat->childs as $lv1)
            @if (count($lv1->childs)==0 && $lv1->menu_alias != null)
                <li>
                    <a href="{{URL::route($lv1->menu_alias)}}"><span class="{{ $lv1->menu_icon }}"></span> <span class="xn-text">{{ $lv1->description }}</a>
                </li>
            @else
                <li class="xn-openable">
                    <a href="#"><span class="{{ $lv1->menu_icon }}"></span> <span class="xn-text">{{ $lv1->description }}</span></a>
                    <ul>
                        @foreach ($lv1->childs as $lv2)
                            @if (count($lv2->childs)==0 && $lv2->menu_alias != null)
                                <li>
                                    <a href="{{URL::route($lv2->menu_alias)}}"><span class="{{ $lv2->menu_icon }}"></span> <span class="xn-text">{{ $lv2->description }}</a>
                                </li>
                            @else
                                <!-- Menu Level 4 jika diinginkan-->
                                <li class="xn-openable">
                                    <a href="#"><span class="{{ $lv2->menu_icon }}"></span> <span class="xn-text">{{ $lv2->description }}</span></a>
                                    <ul>
                                        @foreach ($lv2->childs as $lv3)
                                            @if (count($lv3->childs)==0 && $lv3->menu_alias != null)
                                                <li>
                                                    <a href="{{URL::route($lv3->menu_alias)}}"><span class="{{ $lv3->menu_icon }}"></span> <span class="xn-text">{{ $lv3->description }}</a>
                                                </li>
                                            @else
                                                <!-- Menu Level 5 jika diinginkan-->
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
@endforeach