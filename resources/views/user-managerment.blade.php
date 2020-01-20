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
                <h4>Quản lý khach hang</h4>
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
                function loadUser(currentPage) {
                    $.ajax({
                        url: '/admin/userList?page=' + currentPage,
                        method: 'get',
                        dataType: 'html',
                        success: function (response) {
                            if (response) {
                                $('#list').html(response);
                            }
                        }
                    })
                }

                loadUser(currentPage);
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
                        loadUser(currentPage);
                    } else if (page == "‹") {
                        currentPage = currentPage - 1;
                        loadUser(currentPage);
                    } else {
                        currentPage = page
                        loadUser(page);
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
                    let editUser = tr.find('.data').val();
                    let editEmail = tr.find('.email').val();
                    let data = {
                        id: id,
                        name: editUser,
                        email: editEmail,
                    }
                    $.ajax({
                        url: "update",
                        method: "post",
                        dataType: "json",
                        data: data,
                        success: function (response) {
                            alert("edit successsful!");
                            loadUser(currentPage)
                        },
                        error: function () {
                            alert("Có thanh niên nào đó đã sử dụng mail này:)) sửa thành mail khác đi chế ơiiiii");
                        }
                    })
                })
                $(document).on('click', '.delete', function () {
                    if (!confirm("ban co thuc su muon xoa?")) {
                        return;
                    }
                    let id = $(this).attr('data-id');
                    $.ajax({
                        url: 'user/' + id,
                        method: "DELETE",
                        success: function () {
                            alert('delete successfull');
                            loadUser(currentPage)
                        }
                    })
                })
            })
        </script>
    @endpush

@endsection


