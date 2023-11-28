<?php

namespace App\Enums;

enum Roles: string
{
   case ADMIN = 'Admin';
   case OWNER = 'Owner';
   case Store = 'Store';
   case CUSTOMER = 'Customer';
}
