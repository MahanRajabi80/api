<?php

namespace App\Enums;

enum ReportStatus: string
{
    case PENDING = 'PENDING';
    case REJECT = 'REJECT';
    case ACCEPT = 'ACCEPT';
}
