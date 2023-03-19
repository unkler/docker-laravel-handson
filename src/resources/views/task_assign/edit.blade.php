@extends('layouts.app')

@section('title', '作業配分変更 | ' . config('app.name'))

@section('content')
<div class="h-full ml-14 mt-20 mb-10 md:ml-64">
  <div class="flex mt-10 mx-4"> 
    <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">作業配分変更</h2>
  </div>
  <div class="mx-4 mt-5">
    <div class="w-full mb-2 rounded-lg shadow-xs dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
      <div class="flex flex-wrap">
        <form method="POST" action="{{ route('task_assign.update', $task_assign[0]->workplace_id) }}" class="w-full">
          @csrf
          {{-- <div class="md:w-4/5 mx-auto p-2">
            <label for="client_name" class="leading-7 text-sm text-gray-600">顧客名</label>
            <div>
              <select name="client_id"
                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                <option value=""></option>
                @foreach($clients as $key => $client)
                  <option value="{{ $key }}" @if($key === (int)old('client_id')) selected @endif>{{ $client }}</option>
                @endforeach
              </select>
            </div>
            <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
          </div> --}}
          <div class="md:w-4/5 mx-auto p-2">
            <label for="name" class="leading-7 text-sm text-gray-600">店舗名</label>
            <div>
              <select name="workplace_id"
                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                <option value=""></option>
                @foreach($clients as $client)
                  @foreach($client->workplaces as $workplace)
                    <option value="{{ $workplace->id }}" @if($workplace->id === (int)old('workplace_id', $task_assign[0]->workplace_id)) selected @endif>{{ $workplace->name }}</option>
                  @endforeach
                @endforeach
              </select>
            </div>
            <x-input-error :messages="$errors->get('workplace_id')" class="mt-2" />
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="post_code" class="leading-7 text-sm text-gray-600">担当者</label>
            <employee :employees={{ Illuminate\Support\Js::from($employees) }} :old-employee-ids={{ Illuminate\Support\Js::from(old('employee_ids', $task_assign->pluck('employee_id'))) }}></employee>
            <x-input-error :messages="$errors->get('employee_ids')" class="mt-2" />
            @foreach($errors->get('employee_ids.*') as $employee_ids_errors)
              <x-input-error :messages="$employee_ids_errors" class="mt-2" />
            @endforeach
          </div>
          <div class="md:w-4/5 mx-auto p-2">
            <label for="birthday" class="leading-7 text-sm text-gray-600">作業日</label>
            <input-date name="birthday" :old-birthday="{{ Illuminate\Support\Js::from(old('birthday')) }}"></input-date>
            <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
          </div>
          {{-- <div class="p-2 w-full">
            <label for="birthday" class="leading-7 text-sm text-gray-600">作業時刻</label>
            <input-time name="birthday" :old-birthday="{{ Illuminate\Support\Js::from(old('birthday')) }}"></input-time>
            <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
          </div> --}}
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