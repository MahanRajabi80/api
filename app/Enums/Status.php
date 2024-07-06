<?php

namespace App\Enums;

enum Status: string {
    case REJECT = 'REJECT';
    case PENDING = 'PENDING';
    case PUBLISH = 'PUBLISH';
    case REMOVE = 'REMOVE';
    case SPAM = 'SPAM';
}
