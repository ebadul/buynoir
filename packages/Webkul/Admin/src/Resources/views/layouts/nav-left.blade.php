<div class="navbar-left buynoir-navbar-left">
    <ul class="menubar">
        @foreach ($menu->items as $menuItem)
            <li class="menu-item {{ $menu->getActive($menuItem) }}"  style="{{!empty($menuItem['style'])?$menuItem['style']:''}}">
                <a href="{{ count($menuItem['children']) ? current($menuItem['children'])['url'] : $menuItem['url'] }}">
                    <span class="icon {{ $menuItem['icon-class'] }}"></span>
                    
                    <span>{{ trans($menuItem['name']) }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>