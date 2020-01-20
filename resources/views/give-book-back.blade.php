@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            @include('layout.menu')
            <div class="col-9">
                <h4>Tra sách</h4>

                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên sách</th>
                        <th scope="col">Ngày mượn</th>
                        <th scope="col">Ngày trả</th>
                        <th scope="col">Trang thai</th>
                        <th scope="col">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($giveBookBacks as $item)
                        <tr>
                            <td>{{$item['id']}}</td>
                            <td>{{@$item->book->book_title}}</td>
                            <td>{{$item['created_at']}}</td>
                            <td>
                                @if($item['status'] == 0)
                                    {{$item['pay_day']}}
                                @else
                                    {{$item['updated_at']}}
                                @endif
                            </td>
                            <td>
                                @if($item['status'] == 0)
                                    dang muon
                                @else
                                    da tra
                                @endif
                            </td>
                            <td>
                                @if($item['status'] == 0)
                                    <a href="{{route('payBook',['id' =>$item['book_id'],'status_id' => $item['id']])}}"
                                       class="btn btn-success text-light text-decoration-none">tra sach</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$giveBookBacks->links()}}
            </div>
        </div>
    </div>
    @push('script')
    @endpush
@endsection
