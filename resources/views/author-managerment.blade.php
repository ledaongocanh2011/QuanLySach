@extends('layouts.app')
@section('content')
    <style>
        .hidden {
            display: none;
        }
    </style>
    <div class="container">
        <div class="row">
            @include('layout.menu')
            <div class="col-9">
                <h4>Quản lý tác giả</h4>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAuthor">Tạo mới tác
                    giả
                </button>
                <div class="modal fade" id="addAuthor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                <form action="" method="post" id="fAuthor">
                                    <input type="hidden" class="form-control" name="id">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Tên tac gia</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name">
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
                <div id="list"></div>

            </div>
        </div>
    </div>
    @push('script')
        <script>
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var currentPage = 1;

                // load tac gia
                function loadAuthor(currentPage) {
                    $.ajax({
                        url: '/admin/authorList?page=' + currentPage,
                        method: 'get',
                        dataType: 'html',
                        success: function (response) {
                            if (response) {
                                $('#list').html(response);
                            }
                        }
                    })
                }

                loadAuthor(currentPage);
                $(document).on('click', '#submit', function (e) {
                    e.preventDefault();
                    //tao tac gia
                    $.ajax({
                        url: 'authors',
                        method: 'post',
                        dataType: 'json',
                        data: $('#fAuthor').serialize(),
                        success: function (response) {
                            alert('add new record successful!');
                            currentPage = 1
                            loadAuthor(currentPage);
                            $("#addAuthor").modal('hide')
                        },
                        error: function () {
                            alert("Điền hộ tuii thằng tác giả bạn eiiiiii :)))");
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
                        loadAuthor(currentPage);
                    } else if (page == "‹") {
                        currentPage = currentPage - 1;
                        loadAuthor(currentPage);
                    } else {
                        currentPage = page
                        loadAuthor(page);
                    }
                })

                $(document).on('click', '.edit', function (e) {
                    e.preventDefault();
                    let tr = $(this).closest("tr");
                    tr.find('input').toggleClass("hidden");
                    tr.find('.content').toggleClass("hidden");
                    $(this).siblings('.save').toggleClass('hidden');
                    $(this).siblings('.delete').toggleClass('hidden');
                    $(this).toggleClass('hidden');
                })
                $(document).on('click', '.save', function (e) {
                    e.preventDefault();
                    let id = $(this).attr('data-id');
                    let tr = $(this).closest("tr");
                    let editAuthor = tr.find('.data').val();
                    let data = {
                        id: id,
                        name: editAuthor,
                    }
                    $.ajax({
                        url: "/admin/author/update",
                        method: "post",
                        dataType: "json",
                        data: data,
                        success: function (response) {
                            alert("edit successsful!");
                            loadAuthor(currentPage)
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
                        url: 'author/' + id,
                        method: "DELETE",
                        success: function () {
                            alert('delete successfull');
                            loadAuthor(currentPage)
                        },
                        error: function () {
                            alert("ông này đang có sách cho mượn rồi. Xóa đến tết sang năm cũng không được đâu :))))")
                        }
                    })
                })
            })
        </script>
    @endpush

@endsection


