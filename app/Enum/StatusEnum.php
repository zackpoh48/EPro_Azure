<?php
namespace App\Enum;

enum StatusEnum: int
{
    case Draft = 1;
    case Submitted = 2;
    case Rejected = 3;
    case Approved = 4;
    case Verified = 5;
    case Revoked = 6;
}
