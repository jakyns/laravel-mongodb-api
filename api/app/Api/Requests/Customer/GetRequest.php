<?php

namespace Api\Requests\Customer;

use Carbon\Carbon;

use Dingo\Api\Http\FormRequest;

class GetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'limit' => 'integer|max:100',
            'from'  => 'date',
            'to'    => 'date',
            'order' => 'string',
        ];
    }

    public function filters($keys = '')
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $this->replace([
            'limit' => $this->input('limit', 20),
            'from'  => $this->input('from', Carbon::create(2015, 1, 1)),
            'to'    => $this->input('to', Carbon::now()),
            'order' => $this->input('order', 'desc'),
        ]);

        return array_only($this->input(), $keys);
    }
}
