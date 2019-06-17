<section class="listings">
    <div class="col-md-2 filter">
        <h4>Filter</h4>
        <form action="{{ route('filter') }}">

            <div class="form-check form-check-inline">
                <label for="rooms">Rooms</label> <br>
                <label class="checkbox-inline"><input type="checkbox" name="rooms[]" value="1">1</label>
                <label class="checkbox-inline"><input type="checkbox" name="rooms[]" value="2">2</label>
                <label class="checkbox-inline"><input type="checkbox" name="rooms[]" value="3">3</label>
                <label class="checkbox-inline"><input type="checkbox" name="rooms[]" value="4">4</label>
            </div>

            <div class="form-group square">
                <label for="square">Square</label>
                <input type="text" class="form-control" name="square[]">
                <input type="text" class="form-control" name="square[]">
            </div>

            <div class="form-group">
                Filter by price interval: <b>€ 10</b>
                <input id="ex2" type="text" class="span2" value="" name="price" data-slider-min="10"
                       data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]"/> <b>€ 1000</b>
            </div>

            <button class="btn btn-primary">Filter</button>

        </form>
    </div>
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
<script>
    $("#ex2").slider({});
</script>