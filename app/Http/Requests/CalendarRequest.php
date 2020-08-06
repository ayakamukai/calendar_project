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
            'title' => 'max:20',
            // 'title' => 'required',
            'plan' => 'max:100',
            'year' => 'regex:/^[0-9]{4}$/',
            'month' => 'regex:/^[0-9]{1,2}$/',
            'date' => 'date',
        ];
    }
    // public function getValidatorInstance()
    // {
    //     if ($this->query('year') && $this->query('month'))
    //     {
    //         $dateFormat = [$this->query('year'), $this->query('month'), 1];
    //         $checkDate = implode("-", $dateFormat);
    //         $this->merge([
    //             'date' => $checkDate
    //         ]);
    //     }

    //     return parent::getValidatorInstance();
    // }

    public function messages()
    {
        return [
        "title.required" => "タイトルを入力してください",
        "title.max" => "タイトルは20文字以内で入力してください",
        "plan.max" => "内容は100文字以内で入力してください"

        ];
      }
}
