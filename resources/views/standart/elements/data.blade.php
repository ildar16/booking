@foreach($apartments as $apartment)
    <li style="cursor: pointer;">
        @if($apartment->img)
            <a href="/apart/{{ $apartment->alias }}">
                <img src="{{ asset('apartments_img/'. $apartment->alias . '/' . $apartment->img[0]) }}"
                     alt="" class="property_img"/>
            </a>
            @else
            <a href="/apart/{{ $apartment->alias }}">
                <img src="/{{ config('settings.theme') . "/img/no_image.png" }}"
                     alt="" class="property_img"/>
            </a>
        @endif
        <span class="price">${{ $apartment->price }}</span>
            <div class="property_details">
                <h1>
                    <a href="{{ $apartment->alias }}">{{ $apartment->title }}</a>
                </h1>
                <h2>Square: {{ $apartment->square }} м2</h2>
                <h2>Room: {{ $apartment->rooms }}</h2>
            </div>
    </li>
@endforeach

