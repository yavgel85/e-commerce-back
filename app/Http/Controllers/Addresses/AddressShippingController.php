<?php

namespace App\Http\Controllers\Addresses;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingMethodResource;
use App\Models\Address;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AddressShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function __invoke(Address $address): AnonymousResourceCollection
    {
        $this->authorize('show', $address);

        return ShippingMethodResource::collection(
            $address->country->shippingMethods
        );
    }
}
