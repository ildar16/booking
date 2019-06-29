<div class="container">
    <div class="col-md-12" style="padding: 10px">

        <p><a href="{{ route("apartment.create") }}" class="btn btn-primary">Create apartment</a></p>

        <table class="table table-bordered" style="text-align: center;">
            <thead>
            <tr>
                <th style="text-align: center;">№</th>
                <th style="text-align: center;">Apart name</th>
                <th style="text-align: center;">Price</th>
                <th style="text-align: center;">Rooms</th>
                <th style="text-align: center;">All books</th>
                <th style="text-align: center;">Actual books</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Action</th>
            </tr>
            </thead>
            <tbody>
            @if(!$apartments->isEmpty())
                @php ($i = 0)
                @foreach($apartments as $key => $apartment)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            {{ $apartment->title }}
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
                            @if($apartment->status == 0)
                                <span class="label label-primary">Pending</span>
                            @elseif($apartment->status == 1)
                                <span class="label label-success">Approved</span>
                            @elseif($apartment->status == 2)
                                <span class="label label-danger">Rejected</span>
                            @else
                                <span class="label label-info">Postponed</span>
                            @endif
                        </td>
                        <td style="width: 255px;">
                            <a href="{{ route("apartment.show", ['apartment' => $apartment->alias]) }}" class="btn btn-primary" style="display: inline-block;">Show books</a>
                            <a href="{{ route("apartment.edit", ['apartment' => $apartment->alias]) }}" class="btn btn-success" style="display: inline-block;">Edit</a>
                            <form action="{{ route("apartment.destroy", ['apartment' => $apartment->alias]) }}" method="post" style="display: inline-block;">
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
</div>
