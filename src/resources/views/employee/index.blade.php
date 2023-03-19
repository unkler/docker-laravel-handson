@extends('layouts.app')

@section('title', '社員一覧 | ' . config('app.name'))

@section('content')
<div class="h-full ml-14 mt-20 mb-10 md:ml-64">
  <div class="flex mt-10 mx-4"> 
    <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">社員一覧</h2>
    <form method="GET"action="{{ route('employee.index') }}">
    <div class="flex justify-around items-center">
        <input type="text" name="search_keyword" placeholder="氏名検索" class="text-sm bg-gray-100 h-8 border border-gray-500 outline-none w-full p-1 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 dark:bg-gray-600">
        <button class="bg-blue-800 text-white p-1    dark:bg-gray-800 dark:hover:bg-gray-600">
          <i class="fa-solid fa-magnifying-glass dark:text-gray-400"></i>  
        </button>
      </div>
    </form>
    <button onclick="location.href='{{ route("employee.create") }}'" class="flex text-xs ml-auto text-white bg-blue-800 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-600">
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
            <div class="table-cell px-4 py-3">氏名</div>
            <div class="table-cell px-4 py-3">フリガナ</div>
            <div class="table-cell px-4 py-3">雇用区分</div>
            <div class="table-cell px-4 py-3">郵便番号</div>
            <div class="table-cell px-4 py-3">住所</div>
            <div class="table-cell px-4 py-3">電話番号</div>
            <div class="table-cell px-4 py-3">メールアドレス</div>
            <div class="table-cell px-4 py-3">生年月日</div>
          </div>
          @foreach($employees as $employee)
            <a href="{{ route('employee.edit', $employee->id) }}" class="table-row border-current divide-y bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-400">
              <div class="table-cell px-4 py-3 border-t">
                <div class="flex items-center text-sm">
                  <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                    <img class="object-cover w-full h-full rounded-full" src="https://images.unsplash.com/photo-1502720705749-871143f0e671?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=200&amp;fit=max&amp;s=b8377ca9f985d80264279f277f3a67f5" alt="" loading="lazy" />
                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                  </div>
                  <div>
                    <p class="font-semibold">{{ $employee->fullName }}</p>
                  </div>
                </div>
              </div>
              <div class="table-cell px-4 py-3 text-sm">{{ $employee->fullNameKana }}</div>
              <div class="table-cell px-4 py-3 text-sm">{{ $employee->contractTypes->name }}</div>
              <div class="table-cell px-4 py-3 text-xs">{{ $employee->post_code }}</div>
              <div class="table-cell px-4 py-3 text-sm">{{ $employee->address }}</div>
              <div class="table-cell px-4 py-3 text-sm">{{ $employee->phone_number }}</div>
              <div class="table-cell px-4 py-3 text-sm">{{ $employee->email }}</div>
              <div class="table-cell px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($employee->birthday)->format('Y年m月d日') }}</div>
            </a>
          @endforeach
        </div>
      </div>
      {{ $employees->links('vendor.pagination.custom') }}
    </div>
  </div>
</div>
@endsection