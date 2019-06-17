<section class="listings">
    <div class="wrapper">
        @if($apartments)
            <ul class="properties_list" id="post-data">
                @include('standart.elements.data')
            </ul>

            <div class="more_listing">
                <span style="cursor: pointer;" class="more_listing_btn">View More Listings</span>
            </div>

            <div class="ajax-load text-center" style="display:none">
                <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
            </div>
        @endif

    </div>
</section>
