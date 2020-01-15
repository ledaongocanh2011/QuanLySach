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
                        <th scope="col">Tên tac gia</th>
                        <th scope="col">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($authors as $author)
                        <tr>
                            <th scope="row">{{$author['id']}}</th>
                            <td>
                                {{$author['name']}}
                            </td>
                            <td>
                                <a class="btn btn-danger" href="{{route('restoreAuthorById',$author['id'])}}">Phục hồi
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$authors->links()}}
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
@endsection


