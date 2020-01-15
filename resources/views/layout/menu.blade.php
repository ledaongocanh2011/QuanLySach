<div class="col-3">
    <h4>Menu</h4>
    <ul class="list-group">
        @if(Auth::check())
            <li class="list-group-item"><a href="{{route('books')}}" class="text-decoration-none">Sách</a></li>
            <li class="list-group-item"><a href="{{route('giveBookBack')}}" class="text-decoration-none">Tra sach</a>
            </li>
            @if(Auth::User()->role == 1)
                <li class="list-group-item"><a href="{{route('authors')}}" class="text-decoration-none">Tác giả</a>
                <li class="list-group-item"><a href="{{route('restoreAuthor')}}" class="text-decoration-none">Phục hồi
                        tác
                        giả</a>
                <li class="list-group-item"><a href="{{route('restoreBook')}}" class="text-decoration-none">Phục hồi
                        sách</a>
                </li>
                <li class="list-group-item"><a href="{{route('users')}}" class="text-decoration-none">Tai khoan</a>
                </li>

            @endif
        @endif
    </ul>
</div>

