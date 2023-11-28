<?php

namespace App\Enums;

enum RecurringType: string
{
    case ONETIME = 'Onetime';
    case WEEKLY = 'Weekly';
    case MONTHLY = 'Monthly';
    case YEARLY = 'Yearly';
}