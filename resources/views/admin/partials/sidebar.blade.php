<nav id="sidebar-nav">
  <ul>
    @foreach($global->menus as $menu)
    <li class="active">
      <a href="@if(empty($menu['submenus'])){{ admin_url($menu['uri']) }}@endif"> <i class="{{ $menu['icon'] }}"></i>{{ $menu['label'] }}@if(!empty($menu['submenus'])) <span class="pull-right"><i class="ion-ios-arrow-down"></i></span>@endif</a>
      @if(!empty($menu['submenus']))
      <ul class="nav-sub">
        @foreach($menu['submenus'] as $submenu)
         <li><a href="{{ admin_url($submenu['uri']) }}"><span>{{ $submenu['label'] }}</span></a></li>
        @endforeach
      </ul>
      @endif
    </li>
    @endforeach
  </ul>
</nav>