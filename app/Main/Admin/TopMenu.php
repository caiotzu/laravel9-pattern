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
        // 'sub_menu' => [
        //   'dashboard-overview-1' => [
        //     'icon' => '',
        //     'route_name' => 'dashboard-overview-1',
        //     'params' => [
        //         'layout' => 'side-menu',
        //     ],
        //     'title' => 'Overview 1'
        //   ],
        // ]
      ],
    ];
  }
}
