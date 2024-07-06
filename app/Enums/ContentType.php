<?php

namespace App\Enums;

enum ContentType: string
{
    case REVIEW = 'REVIEW';
    case INTERVIEW = 'INTERVIEW';
    case COMMENT = 'COMMENT';
}
