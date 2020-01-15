<table class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Tác giả</th>
        <th scope="col">Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach($authors as $author)
        <tr>
            <th scope="row">{{$author['id']}}</th>
            <td><input type="text" class="hidden data" value="{{$author['name']}}">
                <span
                    class="content">{{$author['name']}}
                            </span>
            </td>
            <td>
                <button type="button" class="btn btn-success edit" data-id="{{$author['id']}}">Sửa
                </button>
                <button type="button" class="btn btn-danger delete" data-id="{{$author['id']}}">Xóa
                </button>
                <button type="button" class="btn btn-danger save hidden" data-id="{{$author['id']}}">Lưu
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $authors->links() }}
