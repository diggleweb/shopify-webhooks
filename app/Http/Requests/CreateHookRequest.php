<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateHookRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'topic' => [
                'required',
                'regex:((carts/(create|update))|(checkouts/(create|delete|update))|(collections/(create|deletion|update))|(customer_groups/(create|delete|update))|(customers/(create|delete|disable|enable|update))|(refunds/(create))|(fulfillments/(create|update))|(orders/(cancelled|create|delete|fulfilled|partially_fulfilled|paid|updated))|(products/(create|delete|update))|(shop/update)|(app/uninstalled))'
            ],
            'address' => 'required|url',
            'format' => 'required',
        ];
    }

    /**
    * Set custom messages for validator errors.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'regex' => 'Not a valid topic.'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
