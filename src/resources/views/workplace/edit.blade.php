@extends('layouts.app')

@section('title', '作業場所変更 | ' . config('app.name'))

@section('content')
<div class="h-full ml-14 mt-20 mb-10 md:ml-64">
  <div class="flex mt-10 mx-4"> 
    <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">作業場所変更</h2>
  </div>
  <div class="mx-4 mt-5">
    <div class="w-full mb-2 rounded-lg shadow-xs dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
      <div class="flex flex-wrap">
        <form method="POST" action="{{ route('workplace.update', $workplace->id) }}" class="w-full h-adr">
          @csrf
          <input type="hidden" class="p-country-name" value="Japan">
          <div class="md:w-4/5 mx-auto p-2">
            <label for="client_name" class="leading-7 text-sm text-gray-600">顧客名</label>
            <div>
              <select name="client_id"
                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                <option value=""></option>
                @foreach($clients as $key => $client)
                  <option value="{{ $key }}" @if($key === (int)old('client_id', $workplace->client_id)) selected @endif>{{ $client }}</option>
                @endforeach
              </select>
            </div>
            <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="name" class="leading-7 text-sm text-gray-600">店舗名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $workplace->name) }}"
              class="p-postal-code w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('name')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="post_code" class="leading-7 text-sm text-gray-600">郵便番号</label>
            <input type="text" id="post_code" name="post_code" value="{{ old('post_code', $workplace->post_code) }}" maxlength="8"
              class="p-postal-code w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('post_code')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $workplace->address) }}"
              class="p-region p-locality p-street-address p-extended-address w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <x-input-error :messages="$errors->get('address')" class="mt-2 dark:text-gray-400" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <button
              class="flex text-xs mx-auto text-white bg-blue-800 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 dark:text-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600">登録</button>
          </div>
        </form>
        <form method="POST" action="{{ route('workplace.destroy', $workplace->id) }}" class="w-full">
          @csrf
          <div class="p-2 w-full">
            <button
            class="flex text-xs mx-auto text-white bg-slate-800 border-0 py-2 px-6 focus:outline-none hover:bg-slate-600 dark:text-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600">削除</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection