<?php

namespace App\Http\Enums;

enum EReturnOrderStatus: string
{
    case pending = "Returned Pending";
    case accepted = "Returned Accepted";
    case canceled = "Canceled Returned";
}
