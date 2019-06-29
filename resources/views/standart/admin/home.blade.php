<div class="container">
    <div class="col-md-12" style="padding: 10px">

        {{--<a href="{{ route("apartment.create") }}" class="btn btn-primary">Create apartment</a>--}}

        <table class="table table-bordered" style="text-align: center;">
            <thead>
            <tr>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">Apart name</th>
                <th style="text-align: center;">User name
                    <form action="{{ route('admin.filter') }}">
                        <input type="text" name="username">
                        <button>search</button>
                    </form>
                </th>
                <th style="text-align: center;"><a href="/admin_area/filter?orderBy=price" data-sort="price">Price</a>
                </th>
                <th style="text-align: center;"><a href="/admin_area/filter?orderBy=rooms" data-sort="rooms">Rooms</a>
                </th>
                <th style="text-align: center;"><a href="/admin_area/filter?orderBy=allBooks" data-sort="allBooks">All books</a>
                </th>
                <th style="text-align: center;"><a href="/admin_area/filter?orderBy=actualBooks" data-sort="actualBooks">Actual books</a>
                </th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Action</th>
            </tr>
            </thead>
            <tbody>

            @if($apartments)
                @php ($i = 0)
                @foreach($apartments as $key => $apartment)
                    <tr>
                        <td>{{ $apartment->id }}</td>
                        <td>
                            {{ $apartment->title }}
                        </td>
                        <td>
                            {{ $apartment->user->name }}
                        </td>
                        <td>{{ $apartment->price }}</td>
                        <td>{{ $apartment->rooms }}</td>
                        <td>{{ count($apartment->book) }}</td>
                        <td>
                            @foreach($apartment->book as $book)
                                @if(Carbon\Carbon::now()->lte(Carbon\Carbon::parse($book->book_end)))
                                    @php ($i = $i + 1)
                                @endif
                            @endforeach
                            {{ $i }}
                            @php ($i = 0)
                        </td>
                        <td>
                            <div class="form-group">
                                <select class="form-control apartment-status" name="status"
                                        data-alias="{{ $apartment->alias }}">
                                    <option value="0" {{ $apartment->status == 0 ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ $apartment->status == 1 ? 'selected' : '' }}>Approved</option>
                                    <option value="2" {{ $apartment->status == 2 ? 'selected' : '' }}>Rejected</option>
                                    <option value="3" {{ $apartment->status == 3 ? 'selected' : '' }}>Postponed</option>
                                </select>
                            </div>
                        </td>
                        <td style="width: 255px;">
                            <a href="{{ route("admin.apartment.show", ['apartment' => $apartment->alias]) }}"
                               class="btn btn-primary" style="display: inline-block;">Show books</a>
                            <a href="{{ route("admin.apartment.edit", ['apartment' => $apartment->alias]) }}"
                               class="btn btn-success" style="display: inline-block;">Edit</a>
                            <form action="{{ route("admin.apartment.destroy", ['apartment' => $apartment->alias]) }}"
                                  method="post" style="display: inline-block;">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>

    </div>
    <div style="text-align: center">
        {{ $apartments->links() }}
    </div>
</div>

<script>
    $('.apartment-status').change(function () {
        var apart = $(this).attr('data-alias');
        var status = $(this).val();
        var select = $(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            async: true,
            beforeSend: function () {
                select.css('background-color', '#eee');
            },
            complete: function () {
                select.css('background-color', 'white');
            },
            url: '/admin_area/apartment/ups/' + apart,
            data: {status: status}
        });
    });

    var url = new URL(window.location.href);
    var urlOrderBy = url.searchParams.get("orderBy");

    $('th a').click(function () {

        var orderBy = $(this).data('sort');

        if (urlOrderBy) {
            if (urlOrderBy.indexOf("-") != 0) {
                orderBy = "-" + orderBy;
            } else {
                orderBy = orderBy.replace(/-/g, '');
            }
            document.location.href = "/admin_area/filter?orderBy=" + orderBy;
            return false;
        }
    });

    if (urlOrderBy) {
        var sort = $('th a');
        $.each(sort, function (idx, item) {
            if (urlOrderBy.replace(/-/g, '') == $(item).data('sort')) {
                $(item).addClass('bg-primary');
            }
        });
    }
</script>
