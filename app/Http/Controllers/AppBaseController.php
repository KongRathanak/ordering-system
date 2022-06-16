<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;

/**
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    use ApiResponser;
}
