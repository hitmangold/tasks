@extends('layout')

@section('content')
    @if(auth('web')->user()->role != \App\Models\User::ROLE_AUTHOR)
    <table style="margin-right: 10px; margin-left: 10px;">
        <tr>
            <th>Պատվերի համարը</th>
            <th>Պատվերի գինը</th>
            @if(auth('web')->user()->role == \App\Models\User::ROLE_ADMIN) <th>Պատվիրատու</th> @endif
            <th>Պատվերի ամսաթիվը</th>
            <th>Գործողություն</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->sum }}</td>
                @if(auth('web')->user()->role == \App\Models\User::ROLE_ADMIN) <td>{{ $order->user->name }} {{ substr($order->user->surname,0,1) }}</td> @endif
                <td>{{ $order->created_at }}</td>
                <td><a href="" data-id="{{ $order->id }}" class="show_ordered_list">Տեսնել պատվիրված գրքերը</a></td>
            </tr>
            <div class="modal_content" data-id="{{ $order->id }}" style="display:none;">
                @foreach($order->orderBook as $book)
                    <div class="col-md-4">
                        <img src="{{ URL::asset('images') }}/book.jpg" width="120px"><br>
                        <span>Գրքի համարը: {{ $book->id }}</span><br>
                        <span>Գրքի անունը: {{ $book->title }}</span><br>
                        <span>Գրքի գինը: {{ $book->price }}</span><br>
                        <span>Քանակը: {{ $book->pivot->qty }}</span><br>
                    </div>
                @endforeach
            </div>
        @endforeach
    </table>
    @else
        <div class="col-md-12">
            <h3>Իմ գրքի պատվերները</h3>
        </div>
        @foreach($books as $book)
        <div class="col-md-4" style="margin-top: 15px;">
            <div class="cnr">
                <img src="images/book.jpg" width="100%">
                <h4>Վերնագիր: {{ $book->title }}</h4>
                <p style="margin-bottom: 10px; font-size: 15px; font-weight: 500;">Գինը: {{ $book->price }}դր, @if($book->qty != 0) Քանակը: {{ $book->qty }} @else <span style="color: red;">Առկա չէ</span> @endif</p>
                @if(!empty($book->orders[0]))
                    @foreach($book->orders as $order)
                        <div class="row">
                            <div class="col-md-6">
                                <p style="font-weight: 500; margin-bottom: 0px;">Պատվիրատու:</p>
                                <p style="font-weight: 500; font-size: 15px;">{{ $order->user->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p style="font-weight: 500; margin-bottom: 0px">Քանակը:</p>
                                <p style="font-weight: 500; font-size: 15px;">{{ $order->pivot->qty }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Պատվերներ դեռ չկան</p>
                @endif
            </div>
        </div>
        @endforeach
    @endif
    <div class="modal fade bd-example-modal-lg modal_orderbooks" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="padding-top: 20px; padding-bottom: 20px;">
                <div class="container-fluid">
                    <div class="row modal_oderbooks_body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
