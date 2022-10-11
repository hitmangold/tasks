@extends('layout')

@section('content')
    @foreach($books as $book)
        <div class="col-md-4">
            <div class="cnr">
                <img src="images/book.jpg" width="100%">
                <h4>Վերնագիր: {{ $book['name'] }}</h4>
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
            </div>
        </div>
    @endforeach
@endsection
