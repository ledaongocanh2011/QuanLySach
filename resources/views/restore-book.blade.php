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
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên sách</th>
                        <th scope="col">Tác giả</th>
                        <th scope="col">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books as $book)
                        <tr>
                            <th scope="row">{{$book['id']}}</th>
                            <td>
                                {{$book['book_title']}}
                            </td>
                            <td>
                                {{$book->Author->name}}
                            </td>
                            <td>
                                <a class="btn btn-danger" href="{{route('restoreById',$book['id'])}}">Phục hồi
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $books->links() }}
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
@endsection


