<?php

namespace App\Main\Admin;

class SideMenu {
  /**
   * List of side menu items.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public static function menu() {
    return [
      'dashboard' => [
        'icon' => 'home',
        'title' => 'Dashboard',
        'other_route' => [],
        'permissions' => [],
      ],
      'settings' => [
        'icon' => 'settings',
        'title' => 'Configurações',
        'other_route' => [],
        'permissions' => [
          'USER_MENU',
          'PERMISSION_MENU',
          'SYSTEM_MENU'
        ],
        'sub_menu' => [
          'users' => [
            'icon' => 'users',
            'route_name' => 'admin.users.index',
            'other_route' => [
              'admin.users.create',
              'admin.users.edit',
            ],
            'params' => [],
            'title' => 'Usuários',
            'permissions' => [
              'USER_MENU'
            ]
          ],
          'permissions' => [
            'icon' => 'unlock',
            'route_name' => 'admin.permissions.index',
            'other_route' => [
              'admin.permissions.create',
              'admin.permissions.edit',
            ],
            'params' => [],
            'title' => 'Permissões',
            'permissions' => [
              'PERMISSION_MENU'
            ]
          ],
          'system' => [
            'icon' => 'airplay',
            'route_name' => 'admin.systems.index',
            'other_route' => [
              'admin.systems.create',
              'admin.systems.edit',
            ],
            'params' => [],
            'title' => 'Sistema',
            'permissions' => [
              'SYSTEM_MENU'
            ]
          ],
        ],
      ],
    ];
  }
}
