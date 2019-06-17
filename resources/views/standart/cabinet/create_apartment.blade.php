<form action="{{ route("apartment.store") }}" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label>Apartment Name</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="Apartment Name" value="{{ old("title") }}">
    </div>

    <div class="form-group">
        <label>Alias</label>
        <input type="text" class="form-control" name="alias" id="alias" placeholder="Alias" value="{{ old("alias") }}" readonly>
    </div>

    <div class="form-group">
        <label>Price</label>
        <input type="number" class="form-control" name="price" placeholder="Price" value="{{ old("price") }}">
    </div>

    <div class="form-group">
        <label>Description</label>
        <input type="text" class="form-control" name="description" placeholder="Description" value="{{ old("description") }}">
    </div>

    <div class="form-group">
        <label>Rooms</label>
        <select class="form-control" name="rooms">
                <option value="1">One room</option>
                <option value="2">Two rooms</option>
                <option value="3">Three rooms</option>
                <option value="4">Four rooms</option>
                <option value="5">Five rooms</option>
        </select>
    </div>

    <div class="form-group">
        <label>Images</label>
        <input type="file" class="form-control" id="images" name="img[]" placeholder="Images" multiple="multiple">
    </div>

    <ul id="image-list">

    </ul>

    {{ csrf_field() }}

    <button class="btn btn-success">Add</button>
</form>

<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>
    //    CKEDITOR.replace( 'apartmant-ckeditor' );
</script>