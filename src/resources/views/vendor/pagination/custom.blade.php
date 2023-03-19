@if ($paginator->hasPages())
  <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
    <span class="flex items-center col-span-3">
      <p class="text-xs leading-5">
        <span class="text-sm">{{ $paginator->total() }}</span>
          件中
          @if ($paginator->firstItem())
              <span class="text-sm">{{ $paginator->firstItem() }}</span>
              件～
              <span class="text-sm">{{ $paginator->lastItem() }}</span>
          @else
              {{ $paginator->count() }}
          @endif
          件を表示
      </p>
    </span>
    <span class="col-span-2"></span>
    
    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
        <ul class="inline-flex items-center">
          @if (!$paginator->onFirstPage())
            <li>
              <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                <i class="fa-solid fa-angle-left"></i>
              </a>
            </li>
          @endif
          @foreach ($elements as $element)
            @if (is_array($element))
              @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                  <span aria-current="page">
                    <span class="px-3 py-1 text-white dark:text-gray-800 transition-colors duration-150 bg-blue-800 dark:bg-gray-100 border border-r-0 border-blue-800 dark:border-gray-100 rounded-md focus:outline-none focus:shadow-outline-purple">{{ $page }}</span>
                  </span>
                @else
                  <a href="{{ $url }}" class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                      {{ $page }}
                  </a>
                @endif
              @endforeach
            @endif
          @endforeach
          @if ($paginator->hasMorePages())
            <li>
              <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-label="Next">
                <i class="fa-solid fa-angle-right"></i>
              </a>
            </li>
          @endif
        </ul>
    </span>
  </div>
@endif