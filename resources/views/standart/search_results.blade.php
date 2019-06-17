<section class="listings">
    <div class="wrapper">
        @if($empty_apartments)
            <ul class="properties_list">
                @foreach($empty_apartments as $apartment)
                    <li>

                        <a href="/apart/{{ $apartment->alias }}">
                            <img src="{{ asset('apartments_img/'. $apartment->alias . '/' . $apartment->img[0]) }}"
                                 alt="" title="" class="property_img"/>
                        </a>
                        <span class="price">${{ $apartment->price }}</span>
                        <div class="property_details">
                            <h1>
                                <a href="{{ $apartment->alias }}">{{ $apartment->title }}</a>
                            </h1>
                            <h2>{{ $apartment->desc }}</h2>
                        </div>
                    </li>
                @endforeach
            </ul>
            {{--<div class="more_listing">--}}
                {{--<a href="#" class="more_listing_btn">View More Listings</a>--}}
            {{--</div>--}}
        @else
            <h1>Пусто ...</h1>
        @endif

    </div>
</section>