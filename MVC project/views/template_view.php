<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="views/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="scripts/main.js"></script>
    <title>MySQL project</title>
</head>
<body>
<div class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Products</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item <?php if ($content_view == 'main_view.php') { ?> active <?php } ?>">
                            <a class="nav-link" href="index">Գլխավոր <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item <?php if ($content_view == 'add_view.php') { ?> active <?php } ?>">
                            <a class="nav-link" href="add">Ավելացնել ապրանք</a>
                        </li>
                        <li class="nav-item <?php if ($content_view == 'orders_view.php') { ?> active <?php } ?>">
                            <a class="nav-link" href="orders">Բոլոր գնված ապրանքները</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
<?php require_once('views/'.$content_view.''); ?>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
        crossorigin="anonymous"></script>
</body>
</html>