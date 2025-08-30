<aside class="fixed top-16 left-0 h-full w-56 flex flex-col bg-white p-3">
  <nav class="flex-1 space-y-1">
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center rounded-lg px-3 py-1.5 transition-colors duration-200 hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'text-gray-600' }} text-sm">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="7" height="9"></rect>
        <rect x="14" y="3" width="7" height="5"></rect>
        <rect x="14" y="12" width="7" height="9"></rect>
        <rect x="3" y="16" width="7" height="5"></rect>
      </svg>
      <span>Dashboard</span>
    </a>

    <a href="{{ route('admin.products.index') }}"
       class="flex items-center rounded-lg px-3 py-1.5 transition-colors duration-200 hover:bg-gray-100 {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'text-gray-600' }} text-sm">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12.68 12.68a2 2 0 0 1-2.83-2.83l-3.2-3.2a2 2 0 0 1 2.83-2.83l.89.89"></path>
        <path d="m14 7 2-2"></path>
        <path d="M12.68 12.68a2 2 0 0 0 2.83 2.83l3.2 3.2a2 2 0 0 0-2.83 2.83l-.89-.89"></path>
        <path d="M10 17l-2 2"></path>
        <path d="M7 14l-2-2"></path>
        <path d="M12 12 7 7"></path>
        <path d="M15.5 15.5 20 20"></path>
      </svg>
      <span>Quản lý sản phẩm</span>
    </a>

    <a href="{{ route('admin.categories.index') }}"
       class="flex items-center rounded-lg px-3 py-1.5 transition-colors duration-200 hover:bg-gray-100 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'text-gray-600' }} text-sm">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path>
        <path d="M12 21v-8.5"></path>
        <path d="M12 21a2 2 0 0 1-2-2"></path>
        <path d="M12 21a2 2 0 0 1 2-2"></path>
        <path d="M22 17H2"></path>
        <path d="M12 17V3"></path>
      </svg>
      <span>Quản lý danh mục</span>
    </a>

    <a href="{{ route('admin.users.index') }}"
       class="flex items-center rounded-lg px-3 py-1.5 transition-colors duration-200 hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'text-gray-600' }} text-sm">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
      </svg>
      <span>Quản lý người dùng</span>
    </a>

    <a href="{{ route('admin.customers.index') }}"
       class="flex items-center rounded-lg px-3 py-1.5 transition-colors duration-200 hover:bg-gray-100 {{ request()->routeIs('admin.customers.*') ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'text-gray-600' }} text-sm">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
      </svg>
      <span>Quản lý khách hàng</span>
    </a>

    <a href="{{ route('admin.banners.index') }}"
       class="flex items-center rounded-lg px-3 py-1.5 transition-colors duration-200 hover:bg-gray-100 {{ request()->routeIs('admin.banners.*') ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'text-gray-600' }} text-sm">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
        <circle cx="8.5" cy="8.5" r="1.5"></circle>
        <path d="M21 15l-5-5L6 21"></path>
      </svg>
      <span>Quản lý banner</span>
    </a>

    <a href="{{ route('admin.posts.index') }}"
       class="flex items-center rounded-lg px-3 py-1.5 transition-colors duration-200 hover:bg-gray-100 {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'text-gray-600' }} text-sm">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2z"></path>
        <line x1="16" y1="2" x2="8" y2="2"></line>
        <line x1="12" y1="12" x2="12" y2="21"></line>
        <line x1="12" y1="2" x2="12" y2="21"></line>
      </svg>
      <span>Quản lý bài viết</span>
    </a>

    <a href="{{ route('admin.contacts.index') }}"
       class="flex items-center rounded-lg px-3 py-1.5 transition-colors duration-200 hover:bg-gray-100 {{ request()->routeIs('admin.contacts.*') ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'text-gray-600' }} text-sm">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M2 18V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2z"></path>
        <path d="M22 6L12 13 2 6"></path>
      </svg>
      <span>Quản lý liên hệ</span>
    </a>

    <a href="{{ route('admin.reviews.index') }}"
       class="flex items-center rounded-lg px-3 py-1.5 transition-colors duration-200 hover:bg-gray-100 {{ request()->routeIs('admin.reviews.*') ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'text-gray-600' }} text-sm">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
      </svg>
      <span>Quản lý đánh giá</span>
    </a>

    <a href="{{ route('admin.recycle-bin.index') }}"
       class="flex items-center rounded-lg px-3 py-1.5 transition-colors duration-200 hover:bg-gray-100 {{ request()->routeIs('admin.recycle-bin.*') ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'text-gray-600' }} text-sm">
      <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        <line x1="10" y1="11" x2="10" y2="17"></line>
        <line x1="14" y1="11" x2="14" y2="17"></line>
      </svg>
      <span>Thùng rác</span>
    </a>
  </nav>
</aside>