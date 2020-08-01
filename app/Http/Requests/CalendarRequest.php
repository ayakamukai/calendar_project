<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
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
            'year'=>'regex:/^[0-9]{4}$/',
            'month'=>'regex:/^[0-9]{1,2}$/',
            'date'=>'date'
        ];
    }
    public function getValidatorInstance()
    {
        if ($this->query('year') && $this->query('month'))
        {
            $dateFormat = [$this->query('year'), $this->query('month'), 1];
            $checkDate = implode("-", $dateFormat);
            $this->merge([
                'date' => $checkDate
            ]);
        }

        return parent::getValidatorInstance();
    }

    public function messages() {
        return [
        "required" => "必須項目です。",
        "email" => "メールアドレスの形式で入力してください。",
        "numeric" => "数値で入力してください。",
        "opinion.max" => "500文字以内で入力してください。"
        ];
      }
}
