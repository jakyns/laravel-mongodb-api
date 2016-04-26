<?php

namespace Api\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

use App\Models\User;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'         => $user->_id,
            'username'   => $user->username,
            'firstname'  => $user->firstname,
            'lastname'   => $user->lastname,
            'email'      => $user->email,
            'created_at' => Carbon::parse($user->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($user->updated_at)->toDateTimeString(),
        ];
    }
}
