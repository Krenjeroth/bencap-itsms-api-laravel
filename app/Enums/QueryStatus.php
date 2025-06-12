<?php

namespace App\Enums;

enum QueryStatus:string
{
    case Queued = 'queued';
    case CheckingStock = 'checking_stock';
    case AwaitingStock = 'awaiting_stock';
    case InProgress = 'in_progress';
    case AwaitingUser = 'awaiting_user';
    case AwaitingVendor = 'awaiting_vendor';
    case Resolved = 'resolved';
    case Closed = 'closed';
    case Cancelled = 'cancelled';
    case Reopened = 'reopened';
}
