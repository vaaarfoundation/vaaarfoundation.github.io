@extends('_layouts.main')

@section('body')
@include('_layouts.partials.header')
@include('_layouts.partials.after-header',['data'=>$page['pages']['gallery']])

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        @php
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'api-key: bd6fd14194397655f420e7dcde9012524d8cec67de577f4e250b43843f49a224'
            )
        );
        $context = stream_context_create($options);
        $galleries = json_decode(file_get_contents('https://vaaar-backend.vercel.app/api/galleries', false, $context), true);
        $galleries = array_reverse($galleries);
        $uniqueTitles = array_unique(array_column($galleries, 'title'));
    @endphp
        <!-- Filter Controls -->
        <div class="flex justify-center mb-8">
            <ul class="flex flex-wrap gap-4">
                <li>
                    <button class="filter-btn active px-6 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition duration-300" data-filter="all">
                        All
                    </button>
                </li>
                @foreach ($uniqueTitles as $title)
                <li>
                    <button class="filter-btn px-6 py-2 rounded-full bg-gray-200 text-gray-800 hover:bg-gray-300 transition duration-300" data-filter="{{$title}}">
                        {{ $title }}
                    </button>
                </li>
            @endforeach
            </ul>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="gallery-container">
            

            @if(count($galleries) > 0)
            @foreach($galleries as $gallery)
            <div class="gallery-item {{ $gallery['title'] }} transform hover:scale-105 transition duration-300">
                <a href="{{$gallery['image_url']}}" class="block rounded-lg overflow-hidden shadow-lg">
                    <img src="{{$gallery['image_url']}}" alt="{{ $gallery['title'] }}" class="w-full h-64 object-cover">
                </a>
            </div>
            @endforeach
            @else
                <div class="text-center text-gray-700">
                    There is no record.
                </div>
            @endif

          
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active', 'bg-blue-600', 'text-white'));
            filterBtns.forEach(b => b.classList.add('bg-gray-200', 'text-gray-700'));
            
            // Add active class to clicked button
            btn.classList.add('active', 'bg-blue-600', 'text-white');
            btn.classList.remove('bg-gray-200', 'text-gray-700');

            const filterValue = btn.getAttribute('data-filter');

            galleryItems.forEach(item => {
                if (filterValue === 'all' || item.classList.contains(filterValue)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>


@include('_layouts.partials.footer')
@endsection
