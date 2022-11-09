@extends('layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Հաշիվներ</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Հաշիվներ</a></li>
                            <li class="breadcrumb-item active">
                                Բոլոր հաշիվները
                            </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="GET">
                            <input type="text" name="search_name" placeholder="Անուն"
                                   style="width: 250px; height: 35px; border-radius: 6px; padding-left: 5px; outline: none!important; border: 1px solid gray;">
                            <input type="text" name="search_surname" placeholder="Ազգանուն"
                                   style="width: 250px; height: 35px; border-radius: 6px; padding-left: 5px; outline: none!important; border: 1px solid gray;">
                            <button
                                style="height: 35px; background: #4bb1b1; width: 60px; border-radius: 6px; outline: none!important; border: none; cursor:pointer;"
                                type="submit"><img src="images/search.png" width="25"></button>
                        </form>
                    </div>
                    @foreach($authors as $author)
                        <div class="col-md-4" style="margin-top: 15px;">
                            <div class="cnr">
                                <a href="{{ route('authors.show', $author->id) }}"><img src="images/scenarist.jpeg" width="100%"></a>
                                <h6 style="margin-top: 10px; margin-bottom: 10px;">Անուն Ազգանուն: {{ $author->name }} {{ $author->surname }}</h6>
                                @if(auth('web')->user()->role == \App\Models\User::ROLE_ADMIN)
                                    <form class="edit_form" data-id="{{ $author->id }}" action="{{ Route('authors.edit', $author->id) }}" method="GET">
                                        @csrf
                                    </form>
                                    <img src="images/edit.png" class="edit_action" data-id="{{ $author->id }}" width="22px" style="margin-bottom: 15px; cursor:pointer;">
                                    <img src="images/delete.png" class="delete_action" data-id="{{ $author->id }}" width="22px" style="margin-bottom: 15px; margin-left: 5px; cursor:pointer;">
                                @endif
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
                    <div class="col-md-12" style="margin-top: 25px;">
                        {{$authors->withQueryString()->onEachSide(1)->links()}}
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
                                    <p style="font-weight: 500;">Դուք ցանկանում հեռացնել այս հեղինակին?</p>
                                    <form class="form_change" action="" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="modal_btn" style="background: #bd2130;">Հեռացնել</button>
                                        <input type="button" class="modal_btn cancel_action" style="background: #6b7280;" value="Չեղարկել">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('navbar')
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('books.index') }}" class="nav-link">Գլխավոր</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('order.index') }}" class="nav-link">Պատվերներ</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline" action="{{ route('books.index') }}" method="GET">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" name="search_title" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ URL::asset('dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ URL::asset('dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ URL::asset('dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
@endsection

@section('sidebar')
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('books.index') }}" class="brand-link">
            <img src="{{ URL::asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ URL::asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth('web')->user()->name }} {{ auth('web')->user()->surname }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Գլխավոր
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('books.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @if(auth('web')->user()->role == \App\Models\User::ROLE_AUTHOR)
                                            Իմ գրքերը
                                        @elseif(auth('web')->user()->role == \App\Models\User::ROLE_ADMIN || auth('web')->user()->role == \App\Models\User::ROLE_CUSTOMER)
                                            Բոլոր գրքերը
                                        @endif
                                    </p>
                                </a>
                            </li>
                            @if(auth('web')->user()->role != \App\Models\User::ROLE_CUSTOMER)
                                <li class="nav-item">
                                    <a href="{{ route('books.create') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ավելացնել գիրք</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @if(auth('web')->user()->role == \App\Models\User::ROLE_ADMIN)
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-user-alt"></i>
                                <p>
                                    Հաշիվներ
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('authors.index') }}" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Բոլոր հաշիվները
                                        </p>
                                    </a>
                                </li>
                                @if(auth('web')->user()->role != \App\Models\User::ROLE_CUSTOMER)
                                    <li class="nav-item">
                                        <a href="{{ route('authors.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ավելացնել հաշիվ</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('order.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Պատվերներ
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt" aria-hidden="true"></i>
                            <p>
                                Ելք
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
@endsection

@section('footer')
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>
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

