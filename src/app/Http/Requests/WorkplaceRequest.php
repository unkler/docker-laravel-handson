<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkplaceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'name' => ['required', 'string', 'max:255'],
            'post_code' => ['required', 'string', 'regex:/^([0-9]{3})(-?[0-9]{4})$/'],
            'prefecture_id' => ['required', 'integer', 'exists:prefectures,id'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'regex:/\A(0{1}\d{1,4}-?\d{1,4}-?\d{4})\z/u', 'unique:workplaces,phone_number,' . $this->id],
            
        ];
    }

    /**
     * バリーデーション前の整形処理
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->filled('post_code')) {
            $this->merge(['post_code' => mb_convert_kana($this->post_code, 'a', 'UTF-8')]);
        }
        if ($this->filled('address')) {
            $this->merge(['address' => mb_convert_kana($this->address, 'a', 'UTF-8')]);
        }
    }

    /**
     * バリーデーション後(DB登録前)の整形処理
     *
     * @return void
     */
    public function passedValidation()
    {
        //郵便番号の「-」を取り除き、DB登録
        if (str_contains($this->post_code, '-')) {
            $this->merge(['post_code' => str_replace('-', '', $this->post_code)]);
        }
    }

    /**
     * 項目名
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => '作業場所',
        ];
    }
}
