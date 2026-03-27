<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Super Admin') — Alumni КазГАСА</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('images/AV-logotip-2.svg') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F6F2EA]">

  <aside class="fixed top-0 left-0 h-full w-64 bg-[#5E0F14] z-20 flex flex-col">
    <div class="px-6 py-5 border-b border-[#8F161C]">
      <img src="{{ asset('images/AV-logotip-2.svg') }}" class="h-8 mb-2" style="filter: brightness(0) invert(1)">
      <p class="text-white font-bold text-sm">Alumni КазГАСА</p>
      <span class="inline-block mt-1 bg-[#E5C68D] text-[#5E0F14] text-xs font-bold px-2 py-0.5 rounded-full">
        Super Admin
      </span>
    </div>

    <nav class="flex-1 p-4 space-y-1">
      @php
        $links = [
          ['route' => 'super-admin.dashboard',          'icon' => '🏠', 'label' => 'Главная'],
          ['route' => 'super-admin.users.index',        'icon' => '👥', 'label' => 'Пользователи'],
          ['route' => 'super-admin.applications.index', 'icon' => '📋', 'label' => 'Заявки'],
          ['route' => 'super-admin.project-applications.index', 'icon' => '🧾', 'label' => 'Заявки на проекты'],
          ['route' => 'super-admin.projects.index',     'icon' => '🧩', 'label' => 'Проекты'],
          ['route' => 'super-admin.stats',              'icon' => '📊', 'label' => 'Статистика'],
        ];
      @endphp
      @foreach($links as $link)
        <a href="{{ route($link['route']) }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#F6F2EA] hover:bg-[#8F161C] transition
                  {{ request()->routeIs($link['route']) ? 'bg-[#8F161C] border-l-4 border-[#E5C68D]' : 'opacity-80' }}">
          <span>{{ $link['icon'] }}</span>
          <span class="text-sm font-medium">{{ $link['label'] }}</span>
        </a>
      @endforeach
    </nav>

    <div class="p-4 border-t border-[#8F161C]">
      <p class="text-[#E5C68D] text-xs mb-2 px-4">
        {{ auth()->user()->name }}
      </p>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="w-full flex items-center gap-3 px-4 py-3 text-[#F6F2EA] hover:bg-[#8F161C] rounded-lg transition text-sm">
          🚪 Выйти
        </button>
      </form>
    </div>
  </aside>

  <header class="fixed top-0 left-64 right-0 h-16 bg-[#8F161C] flex items-center justify-between px-8 z-10 shadow-md">
    <h1 class="text-white font-semibold text-lg">
      @yield('title', 'Super Admin')
    </h1>
    <span class="text-[#E5C68D] text-sm font-medium">
      {{ auth()->user()->name }}
    </span>
  </header>

  <main class="ml-64 mt-16 p-8 min-h-screen">
    @if(session('success'))
      <div class="mb-6 p-4 bg-green-50 text-green-800 border border-green-200 rounded-xl">
        ✅ {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="mb-6 p-4 bg-red-50 text-[#8F161C] border border-red-200 rounded-xl">
        ❌ {{ session('error') }}
      </div>
    @endif
    @yield('content')
  </main>

</body>
</html>

