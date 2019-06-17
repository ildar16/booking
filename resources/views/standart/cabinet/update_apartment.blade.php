<form action="{{ route("apartment.update", ['cabinet' => $apartment->alias]) }}" method="post"
      enctype="multipart/form-data">

    <div class="form-group">
        <label>Apartment Name</label>
        <input type="text" class="form-control" name="title" placeholder="Apartment Name"
               value="{{ $apartment->title }}">
    </div>

    <div class="form-group">
        <label>Alias</label>
        <input type="text" class="form-control" name="alias" id="alias" placeholder="Alias"
               value="{{ $apartment->alias }}" readonly>
    </div>

    <div class="form-group">
        <label>Price</label>
        <input type="number" class="form-control" name="price" placeholder="Price" value="{{ $apartment->price }}">
    </div>

    <div class="form-group">
        <label>Description</label>
        <input type="text" class="form-control" name="description" placeholder="Description"
               value="{{ $apartment->description }}">
    </div>

    <div class="form-group">
        <label>Rooms</label>
        <select class="form-control" name="rooms">
            <option value="1" {{ $apartment->rooms == 1 ? "selected" : '' }}>One room</option>
            <option value="2" {{ $apartment->rooms == 2 ? "selected" : '' }}>Two rooms</option>
            <option value="3" {{ $apartment->rooms == 3 ? "selected" : '' }}>Three rooms</option>
            <option value="4" {{ $apartment->rooms == 4 ? "selected" : '' }}>Four rooms</option>
            <option value="5" {{ $apartment->rooms == 5 ? "selected" : '' }}>Five rooms</option>
        </select>
    </div>

    <div class="form-group">
        <label>Images</label>
        <input type="file" class="form-control" id="images" name="img[]" placeholder="Images" multiple="multiple">
    </div>

    <ul id="image-list">
        @if($apartment->img)
            @foreach($apartment->img as $img)
                <li data-name="{{ $img }}" class="list-group-item">
                    <span class="close"></span>
                    <img src="{{ asset('apartments_img/' . $apartment->alias . '/' . $img) }}" alt="">
                </li>
            @endforeach
        @endif
    </ul>

    <input type="text" name="comforts" id="comforts" placeholder="Tags">

    <input type="hidden" name="id" value="{{ $apartment->id }}">
    <input type="hidden" name="delete" id="delete">
    <input type="hidden" name="_method" value="PUT">

    {{ csrf_field() }}

    <button class="btn btn-success">Save</button>
</form>

<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>
    //    CKEDITOR.replace( 'apartmant-ckeditor' );

    var tagsdata = [];
    tagsdata.push({id: 1, name: "Free parking", value: "fdsg"});
    tagsdata.push({id: 2, name: "Free Wi-Fi"});
    tagsdata.push({id: 3, name: "Family rooms"});
    tagsdata.push({id: 4, name: "Pets allowed"});
    tagsdata.push({id: 5, name: "Non-smoking rooms"});
    tagsdata.push({id: 6, name: "Restaurant"});
    tagsdata.push({id: 7, name: "Bar"});

    $("#comforts").sTags({
        data: tagsdata,
        defaultData: [{{ $apartment->comforts }}],
    });
</script>