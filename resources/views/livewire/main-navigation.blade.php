<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex-shrink-0 flex items-center ">
                <a href="/" class="text-xl font-bold text-gray-900">
                    {{ Str::ucfirst(config('app.name')) }}
                </a>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:space-x-8 flex items-center">
                @foreach($menuItems as $item)
                @if($item->children->count() > 0)
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a
                    href="{{ $item->url }}"
                    class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 hover:text-gray-700"
                    >
                    {{ $item->title }}
                    <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>

                <div
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute z-10 left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                style="display: none;"
                >
                <div class="py-1">
                    @foreach($item->children as $child)
                    @if($child->children->count() > 0)
                    <!-- Sub-menu with children -->
                    <div x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false" class="relative">
                        <button
                        type="button"
                        class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
                        >
                        <span>{{ $child->title }}</span>
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <!-- Third level menu -->
                    <div
                    x-show="subOpen"
                    x-transition
                    class="absolute left-full top-0 ml-1 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                    style="display: none;"
                    >
                    <div class="py-1">
                        <a
                        href="{{ $child->url }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-semibold border-b"
                        >
                        Voir tout {{ $child->title }}
                    </a>
                    @foreach($child->children as $subChild)
                    <a
                    href="{{ $subChild->url }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    >
                    {{ $subChild->title }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <!-- Simple child item -->
    <a
    href="{{ $child->url }}"
    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
    >
    {{ $child->title }}
</a>
@endif
@endforeach
</div>
</div>
</div>
@else
<a
href="{{ $item->url }}"
class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300"
>
{{ $item->title }}
</a>
@endif
@endforeach
</div>

<div class="flex items-center gap-4">

    <livewire:cart-badge />

</div>
</div>

<!-- Mobile menu -->
<div class="sm:hidden" x-data="{ mobileMenuOpen: false }">
    <button
    @click="mobileMenuOpen = !mobileMenuOpen"
    type="button"
    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 cursor-pointer focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
    >
    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<div x-show="mobileMenuOpen" class="pt-2 pb-3 space-y-1">
    @foreach($menuItems as $item)
    <div>
        <a
        href="{{ $item->url }}"
        class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50"
        >
        {{ $item->title }}
    </a>

    @if($item->children->count() > 0)
    <div class="pl-6">
        @foreach($item->children as $child)
        <a
        href="{{ $child->url }}"
        class="block pl-3 pr-4 py-2 text-sm text-gray-600 hover:bg-gray-50"
        >
        {{ $child->title }}
    </a>

    @if($child->children->count() > 0)
    <div class="pl-6">
        @foreach($child->children as $subChild)
        <a
        href="{{ $subChild->url }}"
        class="block pl-3 pr-4 py-2 text-xs text-gray-500 hover:bg-gray-50"
        >
        {{ $subChild->title }}
    </a>
    @endforeach
</div>
@endif
@endforeach
</div>
@endif
</div>
@endforeach
</div>
</div>
</div>
</nav>
