<table class="table table-bordered">
    <thead>
    <tr>
        <th>Book start</th>
        <th>Book end</th>
        <th>Book username</th>
    </tr>
    </thead>
    <tbody>
    @if($books)
        @foreach($books as $book)
            <tr>
                <td>{{ date('d-m-Y', strtotime($book->book_start)) }}</td>
                <td>{{ date('d-m-Y', strtotime($book->book_end)) }}</td>
                <td>{{ $book->user['name'] ? $book->user['name'] : 'Null' }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3" style="text-align: center">Empty</td>
        </tr>
    @endif
    </tbody>
</table>