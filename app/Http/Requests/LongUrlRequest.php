<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 3/2/17
 * Time: 9:19 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LongUrlRequest extends FormRequest
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
            'long_url' => 'required|string|max:2000',
        ];
    }
}
