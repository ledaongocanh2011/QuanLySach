<style>
    .hidden {
        display: none;
    }

    .filter-active {
        font-weight: bold;
        background: dodgerblue;
        color: #fff;
    }
</style>

<div class="float-right">
    <button class="btn btn-default filter-active" btn-filter="3">tat ca</button>
    <button class="btn btn-default" btn-filter="1">dang xem</button>
    <button class="btn btn-default" btn-filter="2">da muon</button>
    <button class="btn btn-default" btn-filter="0">chua muon</button>
</div>
<table class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Tên sách</th>
        <th scope="col">Tác giả</th>
        <th scope="col">Trạng thái</th>
        <th scope="col">Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach($books as $book)
        <tr>
            <th scope="row">{{$book['id']}}</th>
            <td><input type="text" class="hidden dataBook" value="{{$book['book_title']}}">
                <span
                    class="content">{{$book['book_title']}}
                </span>
            </td>
            <td>
                 <span
                     class="content">{{@$book->Author->name}}
                </span>
                <select class="form-control hidden newName" name="author_id">
                    @foreach($authors as $author)
                        <option value="{{$author['id']}}" @if($author['id'] == $book['author_id'])
                        selected @endif>{{$author['name']}}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                @if($book['status'] == 0)
                    có thể mượn sách
                @elseif($book['status'] == 1)
                    đang xem sách
                @else
                    đã mượn sách
                @endif
            </td>
            <td>
                @if(Auth::user()->role == 1)
                    <button type="button" class="btn btn-success edit" data-id="{{$book['id']}}">Sửa
                    </button>
                    <button type="button" class="btn btn-danger delete" data-id="{{$book['id']}}">Xóa
                    </button>
                    <button type="button" class="btn btn-danger save hidden" data-id="{{$book['id']}}">Lưu
                    </button>
                @else
                    <a type="button" class="btn btn-danger borrow" href="{{route('bookDetail',$book['id'])}}">Mượn
                    </a>
                @endif

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $books->links() }}
