<nav class="sticky top-0 z-50 w-full border-b border-gray-200 bg-white/90 px-6 py-3 shadow-lg backdrop-blur-sm">
  <div class="container mx-auto flex items-center justify-between">
    <a href="/" class="flex items-center text-2xl font-bold text-gray-800">
      <span class="mr-2 text-3xl">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-blue-600">
          <path d="M11.644 1.346a.75.75 0 0 1 .712 0L20.952 5a.75.75 0 0 1 .376.65l-2.402 12.016a.75.75 0 0 1-.582.632l-5.696 1.14a.75.75 0 0 1-.582 0l-5.696-1.14a.75.75 0 0 1-.582-.632L2.672 5.65a.75.75 0 0 1 .376-.65l8.59-3.654Z" />
          <path d="m11.644 1.346 8.59 3.654a.75.75 0 0 1 .376.65l-2.402 12.016a.75.75 0 0 1-.582.632l-5.696 1.14a.75.75 0 0 1-.582 0l-5.696-1.14a.75.75 0 0 1-.582-.632L2.672 5.65a.75.75 0 0 1 .376-.65l8.59-3.654Z" class="stroke-current text-gray-800 stroke-2"></path>
          <path d="M12 18.25a.75.75 0 0 1-1.5 0V7.5a.75.75 0 0 1 1.5 0v10.75Z"></path>
        </svg>
      </span>
      RyoPhone
    </a>

    <div class="flex items-center space-x-4">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="group flex items-center rounded-lg border border-red-500 bg-red-500 px-4 py-2 font-medium text-white shadow-sm transition-all duration-300 hover:border-red-600 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          <span>Đăng xuất</span>
        </button>
      </form>
    </div>
  </div>
</nav>