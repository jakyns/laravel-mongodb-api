<?php

namespace Api\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

use App\Models\Customer;

class CustomerTransformer extends TransformerAbstract
{
    public function transform(Customer $customer)
    {
        return [
            'id'          => $customer->_id,
            'name'        => $customer->name,
            'description' => $customer->description,
            'email'       => $customer->email,
            'created_at'  => Carbon::parse($customer->created_at)->toDateTimeString(),
            'updated_at'  => Carbon::parse($customer->updated_at)->toDateTimeString(),
            'features'    => $customer->features,
        ];
    }
}
