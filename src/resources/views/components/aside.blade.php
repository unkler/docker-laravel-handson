<aside class="fixed flex flex-col top-14 left-0 w-14 hover:w-64 md:w-64 bg-slate-800 dark:bg-gray-900 h-full text-white transition-all duration-300 border-none z-10 sidebar">
  <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
    <ul class="flex flex-col py-4 space-y-1">
      <li class="px-5 hidden md:block">
        <div class="flex flex-row items-center mt-5 h-8">
          <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Main</div>
        </div>
      </li>
      <li>
        <a href="{{ route('task_assign.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
          <span class="inline-flex justify-center items-center ml-4">
            <i class="text-lg pr-1 fa-solid fa-house"></i>
          </span>
          <span class="ml-2 text-sm tracking-wide truncate">作業</span>
        </a>
      </li>
      <li>
        <a href="{{ route('employee.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
          <span class="inline-flex justify-center items-center ml-4">
            <i class="text-lg pr-1 fa-solid fa-users"></i>
          </span>
          <span class="ml-2 text-sm tracking-wide truncate">社員</span>
        </a>
      </li>
      </li>
      <li>
        <a href="{{ route('client.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
          <span class="inline-flex justify-center items-center ml-4">
            <i class="text-lg pr-3 fa-solid fa-building"></i>
          </span>
          <span class="ml-2 text-sm tracking-wide truncate">取引先</span>
        </a>
      </li>
      <li>
        <a href="{{ route('workplace.index') }}" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
          <span class="inline-flex justify-center items-center ml-4">
            <i class="text-lg pr-3 fa-solid fa-location-dot"></i>
          </span>
          <span class="ml-2 text-sm tracking-wide truncate">現場</span>
        </a>
      </li>
      <li class="px-5 hidden md:block">
        <div class="flex flex-row items-center mt-5 h-8">
          <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Settings</div>
        </div>
      </li>
      <li>
        <a href="#" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
          <span class="inline-flex justify-center items-center ml-4">
            <i class="text-lg pr-2 fa-solid fa-user"></i>
          </span>
          <span class="ml-2 text-sm tracking-wide truncate">プロフィール</span>
        </a>
      </li>
      <li>
        <a href="#" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-800 dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6">
          <span class="inline-flex justify-center items-center ml-4">
            <i class="text-lg pr-2 fa-solid fa-gear"></i>
          </span>
          <span class="ml-2 text-sm tracking-wide truncate">設定</span>
        </a>
      </li>
    </ul>
  </div>
</aside>