@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            @include('layout.menu')
            <div class="col-9">
                <h4>Quản lý sách</h4>
                @if(Auth::user()->role == 1)
                    <button type="button" class="btn btn-success mt-5 mb-3" data-toggle="modal" data-target="#addBook">
                        Tạo mới sách
                    </button>
                    <div class="modal fade" id="addBook" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tạo mới </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" id="fBooks">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="bookName" class="col-sm-2 col-form-label">Tên sách</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control data" id="bookName"
                                                       name="book_title">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="author" class="col-sm-2 col-form-label">Tác giả</label>
                                            <div class="col-sm-10">
                                                <select id="author" class="form-control" name="author_id">
                                                    @foreach($authors as $author)
                                                        <option
                                                            value="{{$author['id']}}">{{$author['name']}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div id="listBooks"></div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var currentPage = 1;
            var type = 0;

            // load tac gia - chỗ này e đã truyền nó lên trên sv đâu
            function loadBook(currentPage) {
                //http://laravel-project-3.local/admin/getUthor
                return new Promise(function(res, rej) {
                    $.ajax({
                        url: 'http://laravel-project-3.local/admin/bookList?page=' + currentPage + '&type=' + type,
                        method: 'get',
                        dataType: 'html',
                        success: function (response) {
                            if (response) {
                                $('#listBooks').html(response);

                                res()
                            } else {
                                rej()
                            }
                        }
                    })
                })
            }

            loadBook(currentPage);
            $(document).on('click', '#submit', function (e) {
                e.preventDefault();
                //tao tac gia
                $.ajax({
                    url: 'books',
                    method: 'post',
                    dataType: 'json',
                    data: $('#fBooks').serialize(),
                    success: function (response) {
                        alert('add new record successful!');
                        currentPage = 1
                        loadBook(currentPage);
                        $("#addBook").modal('hide')
                    },
                    error: function () {
                        alert("Bạn thêm sách mà không ghi sách :(( , Đỡ thế nào được đây :)))");
                    }
                })
            })
// disable paginate()
            $(document).on('click', '.page-item', function (e) {
                e.preventDefault();
                let paginate = $(this)
                if (paginate.hasClass('disabled')) {
                    // alert("khong chay duoc dau he");
                    return false
                }
                let page = paginate.find('.page-link').text();
                console.log(page);
                if (page == "›") {
                    currentPage = currentPage + 1;
                    loadBook(currentPage);
                } else if (page == "‹") {
                    currentPage = currentPage - 1;
                    loadBook(currentPage);
                } else {
                    currentPage = page
                    loadBook(page);
                }
            })

            $(document).on('click', '.edit', function (e) {
                e.preventDefault();
                let tr = $(this).closest("tr");
                tr.find('input').toggleClass("hidden");
                tr.find('select').toggleClass("hidden")
                tr.find('.content').toggleClass("hidden");
                $(this).siblings('.save').toggleClass('hidden');
                $(this).siblings('.delete').toggleClass('hidden');
                $(this).toggleClass('hidden');
            })
            $(document).on('click', '.save', function (e) {
                e.preventDefault();
                let bookIid = $(this).attr('data-id');
                let tr = $(this).closest("tr");
                let newNameBook = tr.find('.dataBook').val()
                let newAuthor = tr.find('.newName').val();
                let data = {
                    id: bookIid,
                    book_title: newNameBook,
                    author_id: newAuthor,
                }
                $.ajax({
                    url: "updateBook",
                    method: "post",
                    dataType: "json",
                    data: data,
                    success: function (response) {
                        alert("edit successsful!");
                        loadBook(currentPage)
                    },
                    error: function () {
                    }
                })
            })
            $(document).on('click', '.delete', function () {
                if (!confirm("ban co thuc su muon xoa?")) {
                    return;
                }
                let id = $(this).attr('data-id');
                $.ajax({
                    url: 'books/' + id,
                    method: "DELETE",
                    success: function () {
                        alert('delete successfull');
                        loadBook(currentPage)
                    },
                    error: function () {
                        alert("Rất tiếc, lỗi mất tiu, thử lại nhé :))))");
                    }
                })
            })

            // em dang dung 2 hàm khác nhau mà. Nên e phải gom vào 1 hàm ntn
            $(document).on('click', '[btn-filter]', function (e) {
                e.preventDefault();
                let value = $(this).attr('btn-filter');

                // set type
                type = value
                currentPage = 1
                loadBook(1).then(function(res) {
                    $('.filter-active').removeClass('filter-active');
                    $('[btn-filter=' +value+ ']').addClass('filter-active')
                }).catch(err => {
                    console.log(err)
                })
            });
        });


    </script>
@endpush


