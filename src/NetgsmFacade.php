<?php

namespace Vomsis\Netgsm;

use Illuminate\Support\Facades\Facade;

/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 18.02.2018
 * Time: 14:14
 */

class NetgsmFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "netgsm";
    }
}