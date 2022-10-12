@extends('layout')

@section('content')
    @foreach($books as $book)
        <div class="col-md-4">
            <div class="cnr">
                <img src="images/book.jpg" width="100%">
                <h4>Վերնագիր: {{ $book['title'] }}</h4>
                <p>Գինը: {{ $book['price'] }}դր</p>
                <div
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
                <ul data-id="{{ $book->id }}" class="show_books" style="font-weight: 500; font-size: 17px; margin-top: 15px">
                    @foreach($book->authors as $author)
                        <li>{{ $author->name }} {{ $author->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
@endsection
