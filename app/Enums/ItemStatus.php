<?php

namespace App\Enums;

enum ItemStatus: string
{
    case TO_DO = "to do";
    case IN_PROGRESS = "in progress";
    case READY = "ready";
    case DONE = "done";
}
