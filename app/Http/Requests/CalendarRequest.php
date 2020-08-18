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
            'title' => 'max:20|required',
            'plan' => 'max:1000|required',
            'date_time' => ['date',
                            'regex:/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}\s[0-9]{1,2}:[0-9]{2}$/']
        ];
    }

    public function prepareForValidation()
    {
        $date_time = ($this->filled(['date', 'hour', 'minute'])) ? $this->date.' '.$this->hour.':'.$this->minute : '';
        $this->merge([
           'date_time' => $date_time
        ]);

    }

    public function messages()
    {
        return [
        "title.required" => "タイトルを入力してください",
        "title.max" => "タイトルは20文字以内で入力してください",
        "plan.max" => "内容は1000文字以内で入力してください",
        "plan.required" => "内容を入力してください",
        "date" => "正しい日時を入力してください",
        "regex" => "日時は数字で入力してください",
        ];
      }
}
