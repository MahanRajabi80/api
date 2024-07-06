<?php

namespace App\Enums;

enum ReviewStatus: string {
    case NO_RESPONSE = 'NO_RESPONSE';
    case REJECT = 'REJECT';
    case ACCEPT = 'ACCEPT';
    case WORKING = 'WORKING';
    case NOT_WORKING = 'NOT_WORKING';
}
