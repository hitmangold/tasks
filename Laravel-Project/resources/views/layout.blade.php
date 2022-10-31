<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laravel Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/main.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body style="background: #E0DDFA">
    <div class="container main_section">
        <div class="row">
            <div class="col-md-1">
                <img src="{{ URL::asset('images') }}/logo.png" width="40px">
            </div>
            <div class="col-md-11" style="text-align: right">
                <ul>
                    <li @if(request()->is('/') || request()->is('search') || request()->is('books')) class="active" @endif><a href="{{ route('books.index') }}">@if(auth('web')->user()->role == \App\Models\User::ROLE_AUTHOR) Իմ գրքերը @elseif(auth('web')->user()->role == \App\Models\User::ROLE_ADMIN || auth('web')->user()->role == \App\Models\User::ROLE_CUSTOMER) Բոլոր գրքերը @endif</a></li>
                    @if(auth('web')->user()->role == \App\Models\User::ROLE_ADMIN) <li @if(request()->is('authors') || request()->is('search_authors')) class="active" @endif><a href="{{ route('authors.index') }}">Բոլոր հաշիվները</a></li> @endif
                    <li @if(request()->is('orders')) class="active" @endif><a href="{{ route('order.index') }}">@if(auth('web')->user()->role == \App\Models\User::ROLE_CUSTOMER) Իմ պատվերները @elseif(auth('web')->user()->role == \App\Models\User::ROLE_AUTHOR) Պատվերներ @elseif(auth('web')->user()->role == \App\Models\User::ROLE_ADMIN) Բոլոր պատվերները @endif</a></li>
                    @if(auth('web')->user()->role != \App\Models\User::ROLE_CUSTOMER) <li @if(request()->is('books/create')) class="active" @endif><a href="{{ route('books.create') }}">Ստեղծել գիրք</a></li> @endif
                    @if(auth('web')->user()->role == \App\Models\User::ROLE_ADMIN) <li @if(request()->is('authors/create')) class="active" @endif><a href="{{ route('authors.create') }}">Ստեղծել հաշիվ</a></li> @endif
                    <li style="margin-left: 20px;"><img src="{{ URL::asset('images') }}/user.png" width="30px"></li>
                    <li><a href="">{{ auth('web')->user()->name }} {{ substr(auth('web')->user()->surname,0,1) }}.</a></li>
                    <li><a href="{{ route('logout') }}"><img src="{{ URL::asset('images') }}/exit.png" width="18px"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container content_section">
        <div class="row">
            @yield('content')
        </div>
    </div>
    @if(auth('web')->user()->role == \App\Models\User::ROLE_CUSTOMER && \Illuminate\Support\Facades\Session::get('cart'))
    <div class="cart_menu">
        <img src="{{ URL::asset('images') }}/cart.png" width="32px" style="margin-top: 7px; margin-left: 9px; cursor:pointer;">
    </div>
    <div class="cart">
        <table>
            <tr>
                <th>Անվանումը</th>
                <th>Քանակը</th>
                <th>Գինը</th>
            </tr>
            @php
            $count = 0;
            $total = 0;
            @endphp
            @foreach($cart['books'] as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $cart['qty'][$count] }}</td>
                    <td>{{ $book->price }}</td>
                </tr>
                @php
                    $total += $book->price * $cart['qty'][$count];
                    $count++;
                @endphp
            @endforeach
        </table>
        <div style="text-align: right; margin-right: 10px; margin-top: 10px;">
            <p style="font-size: 17px; font-weight: 500;">Ընդհանուր: {{ $total }} դրամ</p>
            <form action="{{ Route('order.create') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $total }}" name="total">
                <button type="submit" style="width: 250px;
        height: 35px;
        background-color: #17a2b8;
        border: none;
        outline: none!important;
        border-radius: 8px;
        cursor: pointer;
        color: white;
        font-weight: 500;
        margin-top: 15px;">Պատվիրել</button>
            </form>
        </div>
        </div>
    </div>
    @endif
    @if(session()->has('orderedMessage'))
        <div class="modal modal_order" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Պատվեր</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <img src="{{ URL::asset('images') }}/success.png" width="120px">
                        <p style="font-weight: bold; font-size: 15px;">{{ session()->get('orderedMessage') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function (){
                $('.modal_order').modal("show");
            })
        </script>
    @endif
    <script src="js/main.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>
