@extends('layout')

@section('content')
    <div class="col-md-12">
        <form action="{{ route('books.index') }}" method="GET">
            <input type="text" name="search_title" placeholder="Անուն"
                   style="width: 250px; height: 35px; border-radius: 6px; padding-left: 5px; outline: none!important; border: 1px solid gray;">
            {{--<input type="text" name="search_surname" placeholder="Ազգանուն"
                   style="width: 250px; height: 35px; border-radius: 6px; padding-left: 5px; outline: none!important; border: 1px solid gray;">--}}
            <button
                style="height: 35px; background: #4bb1b1; width: 60px; border-radius: 6px; outline: none!important; border: none; cursor:pointer;"
                type="submit"><img src="images/search.png" width="25"></button>
        </form>
    </div>
    @if(empty($books[0]) && !isset($count))
        <div class="col-md-12" style="margin-top: 10px;">
            <p style="font-weight: 500;">Դեռ չկան հրապարակված գրքեր</p>
        </div>
    @endif
    @foreach($books as $book)
        <div class="col-md-4" style="margin-top: 15px;">
            <div class="cnr">
                <a href="{{ route('books.show', $book->id) }}"><img src="images/book.jpg" width="100%"></a>
                <h4>Վերնագիր: {{ $book->title }}</h4>
                <p style="margin-bottom: 10px; font-size: 15px; font-weight: 500;">Գինը: {{ $book->price }}դր, @if($book->qty != 0) Քանակը: {{ $book->qty }} @else <span style="color: red;">Առկա չէ</span> @endif</p>
                @if(auth('web')->user()->role != \App\Models\User::ROLE_CUSTOMER)
                    <form class="edit_form" data-id="{{ $book->id }}" action="{{ Route('books.edit', $book->id) }}" method="GET">
                        @csrf
                    </form>
                    <img src="images/edit.png" class="edit_action" data-id="{{ $book->id }}" width="22px" style="margin-bottom: 15px; cursor:pointer;">
                    <img src="images/delete.png" class="delete_book_action" data-id="{{ $book->id }}" width="22px" style="margin-bottom: 15px; margin-left: 5px; cursor:pointer;">
                @endif
                <div class="click_to_sec" data-id="{{ $book->id }}"
                     style="width: 100%; height: 25px; border-radius: 8px; background: #b0adc5; color: black; font-weight: 500; padding-right: 5px; padding-left: 5px; cursor:pointer;">
                    <div class="row">
                        <div class="col-md-8">
                            <p>Հեղինակներ</p>
                        </div>
                        <div class="col-md-4" align="right">
                            <img src="images/upload.png" width="12px">
                        </div>
                    </div>
                </div>
                <ul data-id="{{ $book->id }}" class="show_sec"
                    style="font-weight: 500; font-size: 17px; margin-top: 15px; display: none;">
                    @foreach($book->authors as $author)
                        <li>{{ $author->name }} {{ $author->surname }}</li>
                    @endforeach
                </ul>
                @if(auth('web')->user()->role == \App\Models\User::ROLE_CUSTOMER && $book->qty != 0)
                    <form action="{{ Route('add.cart') }}" method="POST">
                        @csrf
                        <input type="text" value="1" class="qty_product" data-id="{{ $book->id }}" name="qty" style="width: 40px; border: 1px solid gray; height: 35px; border-radius: 8px;">
                        <input type="hidden" value="{{ $book->id }}" name="book_id">
                        <img src="{{ URL::asset('images/plus.png') }}" class="add_value" data-id="{{ $book->id }}" data-qty="{{ $book->qty }}" style="width: 16px; cursor:pointer;">
                        <img src="{{ URL::asset('images/minus.png') }}" class="minus_value" data-id="{{ $book->id }}" style="width: 16px; cursor:pointer;">
                        <button type="submit" class="btn_cart">Ավելացնել զամբյուղում</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
    <div class="col-md-12" style="margin-top: 25px;">
            {{$books->withQueryString()->onEachSide(1)->links()}}
    </div>
    @if( isset($count) && $count == 0 )
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="alert alert-danger" role="alert">
                Տվյալներ չեն գտնվել
            </div>
        </div>
    @endif
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Գործողություն</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" align="center">
                    <p style="font-weight: 500;">Դուք ցանկանում հեռացնել այս գիրքը?</p>
                    <form class="form_change" action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="modal_btn" style="background: #bd2130;">Հեռացնել</button>
                        <input type="button" class="modal_btn cancel_action" style="background: #6b7280;" value="Չեղարկել">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
