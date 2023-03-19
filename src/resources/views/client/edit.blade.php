@extends('layouts.app')

@section('title', '取引先変更 | ' . config('app.name'))

@section('content')
<div class="h-full ml-14 mt-20 mb-10 md:ml-64">
  <div class="flex mt-10 mx-4"> 
    <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">取引先変更</h2>
  </div>
  
  <div class="mx-4 mt-5">
    <div class="w-full mb-2 rounded-lg shadow-xs dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
      <div class="flex flex-wrap">
        <form method="POST" action="{{ route('client.update', $client->id) }}" class="w-full h-adr">
          @csrf
          <input type="hidden" class="p-country-name" value="Japan">
          <div class="md:w-4/5 mx-auto p-2">
            <label for="client_name" class="leading-7 text-sm text-gray-600">顧客名</label>
            <input type="text" id="client_name" name="client_name" value="{{ old('client_name', $client->client_name) }}"
              class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('client_name')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="post_code" class="leading-7 text-sm text-gray-600">郵便番号</label>
            <input type="text" id="post_code" name="post_code" value="{{ old('post_code', $client->post_code) }}" maxlength="8"
              class="p-postal-code w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('post_code')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $client->address) }}"
              class="p-region p-locality p-street-address p-extended-address w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('address')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="phone_number" class="leading-7 text-sm text-gray-600">電話番号</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $client->phone_number) }}" maxlength="21"
              class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
            <input type="text" id="email" name="email" value="{{ old('email', $client->email) }}" maxlength="254"
              class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('email')" class="mt-2 dark:text-gray-400" />
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