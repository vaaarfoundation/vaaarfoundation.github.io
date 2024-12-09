@extends('_layouts.main')

@section('body')
@include('_layouts.partials.header')
@include('_layouts.partials.after-header',['data'=>$page['pages']['events']])

<section class="py-16 bg-gray-50">
    <div class="flex flex-wrap justify-center">

    @php
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'api-key: bd6fd14194397655f420e7dcde9012524d8cec67de577f4e250b43843f49a224'
            )
        );
        $context = stream_context_create($options);
        $events = json_decode(file_get_contents('https://vaaar-backend.onrender.com/api/events', false, $context), true);
    @endphp
    @if(count($events) > 0)
        @foreach($events as $event)
            <div class="max-w-sm rounded-md overflow-hidden shadow-lg bg-white m-4 p-4">
                <img class="w-full h-48 object-cover" src="{{$event['image_url']}}" alt="{{ $event['title'] }}">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ $event['title'] }}</div>
                    <p class="text-gray-700 text-base">
                        {{ $event['description'] }}
                    </p>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center text-gray-700">
            There is no record.
        </div>
    @endif
</div>
</section>

@include('_layouts.partials.footer')
@endsection