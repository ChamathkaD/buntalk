<?php

namespace Cyntrek\OutletPickup\Carriers;

use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Shipping\Carriers\AbstractShipping;

class OutletPickup extends AbstractShipping
{
    /**
     * Shipping method code
     *
     * @var string
     */
    protected $code = 'outletpickup';

    /**
     * Returns rate for shipping method
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        if (! $this->isAvailable()) {
            return false;
        }

        $object = new CartShippingRate;

        $object->carrier = 'outletpickup';
        $object->carrier_title = $this->getConfigData('title');
        $object->method = 'outletpickup_outletpickup';
        $object->method_title = $this->getConfigData('title');
        $object->method_description = $this->getConfigData('description');
        $object->price = 0;
        $object->base_price = 0;

        return $object;
    }
}
