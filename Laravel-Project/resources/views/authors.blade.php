@extends('layout')

@section('content')
    <div class="col-md-12">
        <form action="{{ route('search_authors') }}" method="GET">
            <input type="text" name="key" placeholder="Փնտրել"
                   style="width: 250px; height: 35px; border-radius: 6px; padding-left: 5px; outline: none!important; border: 1px solid gray;">
            <button
                style="height: 35px; background: #4bb1b1; width: 60px; border-radius: 6px; outline: none!important; border: none; cursor:pointer;"
                type="submit"><img src="images/search.png" width="25"></button>
        </form>
    </div>
    @foreach($authors as $author)
        <div class="col-md-4" style="margin-top: 15px;">
            <div class="cnr">
                <img src="images/scenarist.jpeg" width="100%">
                <h6 style="margin-top: 10px; margin-bottom: 10px;">Անուն Ազգանուն: {{ $author->name }} {{ $author->surname }}</h6>
                <form class="edit_form" data-id="{{ $author->id }}" action="{{ Route('edit_author') }}" method="GET">
                    @csrf
                    <input type="hidden" value="{{ $author->id }}" name="edit_id">
                </form>
                <img src="images/edit.png" class="edit_action" data-id="{{ $author->id }}" width="22px" style="margin-bottom: 15px; cursor:pointer;">
                <img src="images/delete.png" class="delete_action" data-id="{{ $author->id }}" width="22px" style="margin-bottom: 15px; margin-left: 5px; cursor:pointer;">
                <div data-id="{{ $author->id }}" class="click_to_sec"
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
                <ul data-id="{{ $author->id }}" class="show_sec" style="font-weight: 500;  font-size: 17px; margin-top: 15px; display: none">
                    @foreach($author->books as $book)
                        <li>{{ $book->title }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
    @if( request()->is('search_authors') && empty($authors[0]) )
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
                    <p style="font-weight: 500;">Դուք ցանկանում հեռացնել այս հեղինակին?</p>
                    <form action="{{ Route('delete_author') }}" method="POST">
                        @csrf
                        <input type="hidden" value="" name="author_id" class="remove_value">
                        <button type="submit" class="modal_btn" style="background: #bd2130;">Հեռացնել</button>
                        <input type="button" class="modal_btn cancel_action" style="background: #6b7280;" value="Չեղարկել">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
