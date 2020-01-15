@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            @include('layout.menu')
            <div class="col-9">
                <h4>Mượn sách</h4>
                <div class="row justify-content-center mt-5">
                    <div class="col-7">
                        @if($errors->has('pay_day'))
                            <div class="text-danger text-uppercase mb-5 mt-5">{{ $errors->first() }}</div>
                        @endif
                        <form action="{{Route('borrow',['id'=>$bookDetail->id])}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="book-title" class="col-sm-3 col-form-label">Tên sách</label>
                                <span>{{$bookDetail['book_title']}}</span>
                            </div>
                            <div class="form-group row">
                                <label for="author" class="col-sm-3 col-form-label">Tác giả</label>
                                <span>{{$bookDetail->author->name}}</span>
                            </div>
                            <div class="form-group row">
                                <label for="pay-day" class="col-sm-2 col-form-label">Ngày trả </label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="pay-day" name="pay_day">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Mượn</button>
                                    <a class="btn btn-warning" href="{{route("books")}}">Hủy</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
    <script>
        $(function () {
            setTimeout(function () {
                alert("ban da het thoi gian xem, mot la muon hai la out nheee");
            }, 5000)
        })
    </script>

@endsection
