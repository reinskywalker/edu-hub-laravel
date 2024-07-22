<x-app-layout>
    <x-slot name="header">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <div class="md:flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Need Your Approval') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl m-4 mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="mx-auto p-6">

                @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
                @endif

                <section class="text-gray-600 body-font">
                    <div class="container px-5 py-5 mx-auto">
                        @if($articles->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Thumbnail</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Title</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Content</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Status</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Date Posted</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($articles as $article)
                                    <tr>
                                        <td class="px-6 py-4 border-b border-gray-500">
                                            <img src="{{ asset($article->thumbnail_image_url) }}" alt="{{ $article->title }}" class="w-24 h-24 object-cover">
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-500">
                                            {{ $article->title }}
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-500">
                                            {{ Str::limit($article->content, 100) }}
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-500">
                                            {{ $article->status }}
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-500">
                                            {{ $article->created_at->format('d M Y') }}
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="p-4 w-full">
                            <div class="border-2 border-gray-200 px-4 py-6 rounded-lg bg-white">
                                <h2 class="title-font font-medium text-2xl text-gray-900">No articles available</h2>
                            </div>
                        </div>
                        @endif
                        <div class="mt-4">
                            {{ $articles->links() }}
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const approveButtons = document.querySelectorAll('.approve-btn');
            const reviseButtons = document.querySelectorAll('.revise-btn');
            const deleteButtons = document.querySelectorAll('.delete-btn');

            approveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const articleId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to approve this article?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, approve it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`approve-form-${articleId}`).submit();
                        }
                    });
                });
            });

            reviseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const articleId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to request revision for this article?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, request revision!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`revise-form-${articleId}`).submit();
                        }
                    });
                });
            });

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const articleId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${articleId}`).submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>