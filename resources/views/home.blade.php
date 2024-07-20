<x-app-layout>
    <x-slot name="header">
        <div class="md:flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Article Hub') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl m-4 mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="mx-auto">

                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-5 mx-auto">
                        <div class="flex flex-wrap -m-4 text-center">
                            @foreach ($articles as $article)
                            @if($article->status == "published")
                            <div class="p-4 md:w-1/3 sm:w-1/2 w-full">
                                <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                                    <!-- <img src="{{$article->thumbnail_image_url}}" alt="{{ $article->title }}" class="w-full h-48 object-cover mb-4"> -->
                                    <img src="{{ asset($article->thumbnail_image_url) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover mb-4">
                                    <h2 class="title-font font-medium text-2xl text-gray-900">{{ $article->title }}</h2>
                                    <p class="leading-relaxed mt-4">{{ Str::limit($article->content, 100) }}</p>
                                    <a href="{{ route('articles.show', $article->id) }}" class="text-indigo-500 inline-flex items-center mt-4">Read More
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $articles->links() }}
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</x-app-layout>