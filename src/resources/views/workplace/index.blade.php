@extends('layouts.app')

@section('title', '作業場所一覧 | ' . config('app.name'))

@section('content')
<div class="h-full ml-14 mt-20 mb-10 md:ml-64">
  <div class="flex mt-10 mx-4"> 
    <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">作業場所一覧</h2>
    <form method="GET"action="{{ route('workplace.index') }}">
    <div class="flex justify-around items-center">
        <input type="text" name="search_keyword" placeholder="住所から検索" class="text-sm bg-gray-100 h-8 border border-gray-500 outline-none w-full p-1 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 dark:bg-gray-600">
        <button class="bg-blue-800 text-white p-1    dark:bg-gray-800 dark:hover:bg-gray-600">
          <i class="fa-solid fa-magnifying-glass dark:text-gray-400"></i>  
        </button>
      </div>
    </form>
    <button onclick="location.href='{{ route("workplace.create") }}'" class="flex text-xs ml-auto text-white bg-blue-800 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-600">
      <span><i class="fa-solid fa-plus dark:text-gray-400 mr-2 text-center"></i></span>
      <span>新規登録</span>
    </button>
    
  </div>

  @include('components.flash-message')
  
  <div class="mt-4 mx-4">
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <div class="table table-auto w-full">
          <div class="table-row text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <div class="table-cell px-4 py-3">顧客名</div>
            <div class="table-cell px-4 py-3">支店名</div>
            <div class="table-cell px-4 py-3">住所</div>
          </div>
          @foreach($workplaces as $workplace)
            <a href="{{ route('workplace.edit', $workplace->id) }}" class="table-row border-current divide-y bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-400">
              <div class="table-cell px-4 py-3 text-sm border-t">{{ $workplace->clients->client_name }}</div>
              <div class="table-cell px-4 py-3 text-sm">{{ $workplace->name }}</div>
              <div class="table-cell px-4 py-3 text-sm">{{ $workplace->address }}</div>
            </a>
          @endforeach
        </div>
      </div>
      {{ $workplaces->links('vendor.pagination.custom') }}
    </div>
  </div>
</div>
@endsection