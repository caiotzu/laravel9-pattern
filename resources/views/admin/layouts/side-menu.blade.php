@include('../admin/layouts/components/mobile-menu')
@include('../admin/layouts/components/top-bar')
<div class="flex overflow-hidden">
  <!-- BEGIN: Side Menu -->
  <nav class="side-nav">
    <ul>
      @foreach ($admin_side_menu as $menuKey => $menu)
        @if ($menu == 'devider')
          <li class="side-nav__devider my-6"></li>
        @else
          <li>
            <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}" class="{{ $admin_first_level_active_index == $menuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
              <div class="side-menu__icon">
                <i data-lucide="{{ $menu['icon'] }}"></i>
              </div>
              <div class="side-menu__title">
                {{ $menu['title'] }}
                @if (isset($menu['sub_menu']))
                  <div class="side-menu__sub-icon {{ $admin_first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}">
                    <i data-lucide="chevron-down"></i>
                  </div>
                @endif
              </div>
            </a>
            @if (isset($menu['sub_menu']))
              <ul class="{{ $admin_first_level_active_index == $menuKey ? 'side-menu__sub-open' : '' }}">
                @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                  <li>
                    <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="{{ $admin_second_level_active_index == $subMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                      <div class="side-menu__icon">
                        <i data-lucide="{{ $subMenu['icon'] }}"></i>
                      </div>
                      <div class="side-menu__title">
                        {{ $subMenu['title'] }}
                        @if (isset($subMenu['sub_menu']))
                          <div class="side-menu__sub-icon {{ $admin_second_level_active_index == $subMenuKey ? 'transform rotate-180' : '' }}">
                            <i data-lucide="chevron-down"></i>
                          </div>
                        @endif
                      </div>
                    </a>
                    @if (isset($subMenu['sub_menu']))
                      <ul class="{{ $admin_second_level_active_index == $subMenuKey ? 'side-menu__sub-open' : '' }}">
                        @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                          <li>
                            <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="{{ $admin_third_level_active_index == $lastSubMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                              <div class="side-menu__icon">
                                <i data-lucide="{{ $subMenu['icon'] }}"></i>
                              </div>
                              <div class="side-menu__title">{{ $lastSubMenu['title'] }}</div>
                            </a>
                          </li>
                        @endforeach
                      </ul>
                    @endif
                  </li>
                @endforeach
              </ul>
            @endif
          </li>
        @endif
      @endforeach
    </ul>
  </nav>

  <div class="content">
    @yield('adminContent')
  </div>
</div>
