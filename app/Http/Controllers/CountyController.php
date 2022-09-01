<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\CountyService;

use Exception;

class CountyController extends Controller {

  protected $countyService;

  public function __construct(CountyService $countyService) {
    $this->countyService = $countyService;
  }

  public function search(Request $request) {
    try {
      return $this->countyService->countySearch($request->county);
    } catch (Exception $e) {
      return [];
    }
  }
}
