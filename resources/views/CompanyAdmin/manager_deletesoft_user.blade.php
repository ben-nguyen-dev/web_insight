 <table class="table table-bordered table-striped" >
        <thead class="thead-top">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Email</th>
                <th scope="col">Full Name</th>
                <th scope="col">Role</th>
                <th scope="col">Deleted At</th>
            </tr>
        </thead>
        <tbody class="thead-body">
            @if(isset($showUser) && count($showUser) > 0)
                @foreach ($showUser as $key => $user)
                    <tr>
                        <th scope="row">{{ ++$key }}</th>
                        <td>{{ $user->user_name }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                <p>{{ $role['name'] }}</p>
                            @endforeach
                        </td>
                        <td class="text-center">
                            {{ date('Y/m/d - H:s', strtotime($user->deleted_at)) }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6"> No result found</td>
                </tr>
            @endif
        </tbody>
    </table>
    @if(isset($users))
    {{ $showUser->links('pagination.default') }}
    @endif
