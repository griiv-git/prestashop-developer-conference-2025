<?php

namespace Griiv\Customer\Enum;

enum AddressType: string
{
    case SHIPPING  = 'shipping';
    case BILLING   = 'billing';
}
