<table class="table table-bordered">
    <thead>
    <tr>
        <th>Book start</th>
        <th>Book end</th>
        <th>Apartment</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if($books)
        @foreach($books as $book)
            <tr>
                <td>{{ date('d-m-Y', strtotime($book->book_start)) }}</td>
                <td>{{ date('d-m-Y', strtotime($book->book_end)) }}</td>
                @if($book->apartment)
                    <td>
                        <a href="{{ route('show.apart', ['alias' => $book->apartment['alias']]) }}">{{ $book->apartment['title'] }}</a>
                    </td>
                @else
                    <td>Null</td>
                @endif
                <td>
                    <form action="{{ route("book.destroy", ['book' => $book->id]) }}" method="post" style="display: inline-block;">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4" style="text-align: center">Empty!</td>
        </tr>
    @endif
    </tbody>
</table>