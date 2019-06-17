<div class="container">
    <div class="col-md-12" style="padding: 10px">

        {{--<a href="{{ route("apartment.create") }}" class="btn btn-primary">Create apartment</a>--}}

        <table class="table table-bordered" style="text-align: center;">
            <thead>
            <tr>
                <th style="text-align: center;">ID</th>
                <th style="text-align: center;">User name</th>
                <th style="text-align: center;">Email</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Action</th>
            </tr>
            </thead>
            <tbody>
            @if(!$users->isEmpty())
                @foreach($users as $key => $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>{{ $user->email }}</td>

                        <td>
                            <div class="form-group">
                                <select class="form-control user-status" name="status" data-id="{{ $user->id }}">
                                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Banned</option>
                                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
                        </td>

                        <td style="width: 255px;">
                            <form action="{{ route("admin.apartment.destroy", ['apartment' => $user->id]) }}"
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
</div>
