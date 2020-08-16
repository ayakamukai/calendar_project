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
            'plan' => 'max:100',
            'time' => ['date_format:G:i',
                'regex/^[0-9]{1,2}:[0-9]{2}$/']
            ];
    }

    public function messages()
    {
        return [
        "title.required" => "タイトルを入力してください",
        "title.max" => "タイトルは20文字以内で入力してください",
        "plan.max" => "内容は100文字以内で入力してください",
        "time.date_format" => "HH:SS形式で入力してください",
        "time.regex" => "正しい時刻を入力してください",
        ];
      }
}
