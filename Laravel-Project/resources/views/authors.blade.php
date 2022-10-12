@extends('layout')

@section('content')
    @foreach($authors as $author)
        <div class="col-md-4">
            <div class="cnr">
                <img src="images/scenarist.jpeg" width="100%">
                <h5 style="margin-top: 10px; margin-bottom: 10px;">Անուն Ազգանուն: {{ $author['name'] }} {{ $author['surname'] }}</h5>
                <div data-id="{{ $author->id }}" class="click_books"
                    style="width: 100%; height: 25px; border-radius: 8px; background: #b0adc5; color: black; font-weight: 500; padding-right: 5px; padding-left: 5px; cursor:pointer;">
                    <div class="row">
                        <div class="col-md-8">
                            <p>Հեղինակային գրքեր</p>
                        </div>
                        <div class="col-md-4" align="right">
                            <img src="images/upload.png" width="12px">
                        </div>
                    </div>
                </div>
                <ul data-id="{{ $author->id }}" class="show_books" style="font-weight: 500; font-size: 17px; margin-top: 15px; display: none">
                    @foreach($author->books as $book)
                        <li>{{ $book->title }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
@endsection
