<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laravel Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body style="background: #E0DDFA">
    <div class="container main_section">
        <div class="row">
            <div class="col-md-4">
                <img src="images/logo.png" width="40px">
            </div>
            <div class="col-md-8" style="text-align: right">
                <ul>
                    <li @if(request()->is('/')) class="active" @endif><a href="{{ route('index') }}">Բոլոր գրքերը</a></li>
                    <li @if(request()->is('authors')) class="active" @endif><a href="{{ route('authors') }}">Բոլոր հեղինակները</a></li>
                    <li><a href="">Ստեղծել գիրք</a></li>
                    <li><a href="">Ստեղծել հեղինակ</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container content_section">
        <div class="row">
            @yield('content')
        </div>
    </div>
    <script src="js/main.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>
