<?php

namespace App\Http\Controllers;

use App\Traits\DBTransactionTrait;
use App\Traits\ResponseTrait;

abstract class BaseAPIController
{
    use ResponseTrait, DBTransactionTrait;
}
