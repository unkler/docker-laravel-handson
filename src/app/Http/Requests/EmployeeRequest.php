<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'last_name' => ['required', 'string', 'max:30'],
            'first_name' => ['required', 'string', 'max:30'],
            'last_name_kana' => ['required', 'string', 'max:30', 'regex:/\A[ァ-ヴーｦ-ﾟ]+\z/u'],
            'first_name_kana' => ['required', 'string', 'max:30', 'regex:/\A[ァ-ヴーｦ-ﾟ]+\z/u'],
            'contract_type_id' => ['required', 'integer', 'exists:contract_types,id'],
            'post_code' => ['required', 'string', 'regex:/\A([0-9]{3})(-?[0-9]{4})\z/u'],
            'prefecture_id' => ['required', 'integer', 'exists:prefectures,id'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'regex:/\A(0{1}\d{1,4}-?\d{1,4}-?\d{4})\z/u', 'unique:employees,phone_number,' . $this->id],
            'email' => ['required', 'string', 'email:filter,dns', 'unique:employees,email,' . $this->id],
            'birthday' => ['required', 'string', 'date_format:Y-m-d', 'before:today'],
            // 'profile_image' => ['file', 'max:3072', 'mimes:jpeg,gif,png'],
        ];
    }

    /**
     * バリーデーション前の整形処理
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->filled('last_name_kana')) {
            $this->merge(['last_name_kana' => mb_convert_kana($this->last_name_kana, 'KVA', 'UTF-8')]);
        }
        if ($this->filled('first_name_kana')) {
            $this->merge(['first_name_kana' => mb_convert_kana($this->first_name_kana, 'KVA', 'UTF-8')]);
        }
        if ($this->filled('post_code')) {
            $this->merge(['post_code' => mb_convert_kana($this->post_code, 'a', 'UTF-8')]);
        }
        if ($this->filled('address')) {
            $this->merge(['address' => mb_convert_kana($this->address, 'a', 'UTF-8')]);
        }
        if ($this->filled('phone_number')) {
            $this->merge(['phone_number' => mb_convert_kana($this->phone_number, 'a', 'UTF-8')]);
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
        //生年月日の「/」を「-」に置換し、DB登録
        if (str_contains($this->birthday, '/')) {
            $this->merge(['birthday' => str_replace('/', '-', $this->birthday)]);
        }
    }
}
