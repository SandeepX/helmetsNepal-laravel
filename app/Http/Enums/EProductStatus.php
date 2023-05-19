<?php

namespace App\Http\Enums;
enum EProductStatus: string
{
    case active = "active";
    case rejected = "rejected";
    case pending = "pending";
}
