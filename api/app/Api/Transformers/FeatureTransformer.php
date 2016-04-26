<?php

namespace Api\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

use App\Models\Feature;

class FeatureTransformer extends TransformerAbstract
{
    public function transform(Feature $feature)
    {
        return [
            'id'           => $feature->_id,
            'name'         => $feature->name,
            'display_name' => $feature->display_name,
            'description'  => $feature->description,
            'created_at'   => Carbon::parse($feature->created_at)->toDateTimeString(),
            'updated_at'   => Carbon::parse($feature->updated_at)->toDateTimeString(),
        ];
    }
}
