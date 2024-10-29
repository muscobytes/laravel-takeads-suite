<?php

namespace Muscobytes\Laravel\Takeads\Coupons\Services;

use Muscobytes\Laravel\TakeadsApi\TakeadsApi;

class TakeadsCouponsService
{
    public function __construct(
        private TakeadsApi $api
    )
    {
        //
    }
}
