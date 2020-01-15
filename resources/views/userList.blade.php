<table class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Ten khach hang</th>
        <th scope="col">Email</th>
        <th scope="col">Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <th scope="row">{{$user['id']}}</th>
            <td>
                <input type="text" class="hidden data" value="{{$user['name']}}">
                <span
                    class="content">{{$user['name']}}
                </span>
            </td>
            <td>
                <input type="text" class="hidden email" value="{{$user['email']}}">
                <span
                    class="content">{{$user['email']}}
                </span>
            </td>
            <td>
                <button type="button" class="btn btn-success edit" data-id="{{$user['id']}}">Sửa
                </button>
                <button type="button" class="btn btn-danger delete" data-id="{{$user['id']}}">Xóa
                </button>
                <button type="button" class="btn btn-danger save hidden" data-id="{{$user['id']}}">Lưu
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $users->links() }}
