<?php

namespace App\Enums;

enum OrderStatus: string
{
    case TO_DO = "to do";
    case IN_PROGRESS = "in progress";
    case READY = "ready";
    case DONE = "done";
}
