@extends('layouts.app')

@section('title', '社員登録 | ' . config('app.name'))

@section('content')
<div class="h-full ml-14 mt-20 mb-10 md:ml-64">
  <div class="flex mt-10 mx-4"> 
    <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">社員登録</h2>
  </div>
  
  <div class="mx-4 mt-5">
    <div class="w-full mb-2 rounded-lg shadow-xs dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
      <div class="flex flex-wrap">
        <form method="POST" action="{{ route('employee.store') }}" class="w-full h-adr">
          @csrf
          <input type="hidden" class="p-country-name" value="Japan">
          <div class="md:w-4/5 mx-auto mt-3 p-2">
            <label for="last_name" class="leading-7 text-sm text-gray-600">氏名</label>
            <div class="flex justify-between">
              <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                class="w-full mr-2 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <x-input-error :messages="$errors->get('last_name')" class="mt-2 dark:text-gray-400" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="last_name_kana" class="leading-7 text-sm text-gray-600">氏名(カタカナ)</label>
            <div class="flex justify-between">
              <input type="text" id="last_name_kana" name="last_name_kana" value="{{ old('last_name_kana') }}"
                class="w-full mr-2 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
              <input type="text" id="first_name_kana" name="first_name_kana" value="{{ old('first_name_kana') }}"
                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <x-input-error :messages="$errors->get('last_name_kana')" class="mt-2 dark:text-gray-400" />
            <x-input-error :messages="$errors->get('first_name_kana')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="contract_type" class="leading-7 text-sm text-gray-600">雇用区分</label>
            <div>
              <select name="contract_type_id"
                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                <option value=""></option>
                @foreach($contract_types as $key => $contract_type)
                  <option value="{{ $key }}" @if($key === (int)old('contract_type_id')) selected @endif>{{ $contract_type }}</option>
                @endforeach
              </select>
            </div>
            <x-input-error :messages="$errors->get('contract_type_id')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="post_code" class="leading-7 text-sm text-gray-600">郵便番号</label>
            <input type="text" id="post_code" name="post_code" value="{{ old('post_code') }}" maxlength="8"
              class="p-postal-code w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('post_code')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}"
              class="p-region p-locality p-street-address p-extended-address w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('address')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="phone_number" class="leading-7 text-sm text-gray-600">電話番号</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" maxlength="21"
              class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}" maxlength="254"
              class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('email')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="birthday" class="leading-7 text-sm text-gray-600">生年月日</label>
            <input-date name="birthday" :old-birthday="{{ Illuminate\Support\Js::from(old('birthday')) }}"></input-date>
            <x-input-error :messages="$errors->get('birthday')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <button
              class="flex text-xs mx-auto text-white bg-blue-800 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 dark:text-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600">登録</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection