<?php

namespace App\Enums;

enum RejectionRemark: string
{
    case BLURRY = 'blurry';
    case CORRUPT = 'corrupt_file';
    case EXPIRED = 'expired_document';
    case INVALID = 'invalid_document';
    case INCOMPLETE = 'incomplete_information';
}