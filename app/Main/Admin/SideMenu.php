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
          'USER_MENU'
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
          // 'permissions' => [
          //   'icon' => 'unlock',
          //   'route_name' => 'admin.users.index',
          //   'other_route' => [
          //   ],
          //   'params' => [],
          //   'title' => 'Permissões',
          //   'permissions' => [
          //     'USER_MENU'
          //   ]
          // ],
        ],
      ],
    ];
  }
}
