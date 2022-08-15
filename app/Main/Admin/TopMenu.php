<?php

namespace App\Main\Admin;

class TopMenu {
  /**
   * List of top menu items.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public static function menu() {
    return [
      'dashboard' => [
        'icon' => 'home',
        'title' => 'Dashboard',
      ],
      'settings' => [
        'icon' => 'settings',
        'title' => 'Configurações',
        'sub_menu' => [
          'users' => [
            'icon' => 'users',
            'route_name' => 'admin.users.index',
            'params' => [],
            'title' => 'Usuários'
          ],
        ]
      ],
    ];
  }
}
