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
        'permissions' => [],
      ],
      'settings' => [
        'icon' => 'settings',
        'title' => 'Configurações',
        'permissions' => [
          'USER_MENU'
        ],
        'sub_menu' => [
          'users' => [
            'icon' => 'users',
            'route_name' => 'admin.users.index',
            'params' => [],
            'title' => 'Usuários',
            'permissions' => [
              'USER_MENU'
            ]
          ],
        ],
      ],
    ];
  }
}
