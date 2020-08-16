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
            'plan' => 'max:30|required',
            'time' => 'date_format:G:i'
        ];
    }

    public function messages()
    {
        return [
        "title.required" => "タイトルを入力してください",
        "title.max" => "タイトルは20文字以内で入力してください",
        "plan.required" => "内容を入力してください",
        "plan.max" => "内容は30文字以内で入力してください"
        ];
      }
}
