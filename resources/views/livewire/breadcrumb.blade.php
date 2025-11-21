<nav class="mb-6 text-sm">
    <ol class="flex items-center space-x-2 text-gray-600">
        <!-- Accueil -->
        <li>
            <a href="/" class="hover:text-gray-900 transition-colors">Accueil</a>
        </li>

        <!-- Items dynamiques -->
        @foreach($items as $item)
            <li class="flex items-center">
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="hover:text-gray-900 transition-colors">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="font-semibold text-gray-900">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
