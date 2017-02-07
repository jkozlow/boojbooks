<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ $base_url }}images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ $base_url }}images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ $base_url }}images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ $base_url }}images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ $base_url }}images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ $base_url }}images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ $base_url }}images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ $base_url }}images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $base_url }}images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ $base_url }}images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $base_url }}images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ $base_url }}images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $base_url }}images/favicon-16x16.png">
    <link rel="manifest" href="{{ $base_url }}images/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ $base_url }}images/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="boojbooks is a book information management system">
    <meta name="author" content="Josh Kozlowski <jkozlow@outlook.com>">

    <title>{{ $pagetitle }}</title>

    <link rel="stylesheet" href="{{ $base_url }}css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ $base_url }}css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="{{ $base_url }}css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="{{ $base_url }}fancybox/source/jquery.fancybox.css?v=2.1.6">
    <link rel="stylesheet" href="{{ $base_url }}css/custom.css"> 
  </head>
<body>

@section('navbar')
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">boojbooks</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li {{ ($nav_class == "home" ? 'class=active' : '') }}><a href="{{ $base_url }}"><img alt="Home" style="height:30px" src="{{ $base_url }}images/1273179534.svg" /></a></li>
            <li {{ ($nav_class == "books" ? 'class=active' : '') }}><a href="{{ $base_url }}search"><img alt="Search for book" style="height:30px" src="{{ $base_url }}images/1276877947.svg" /></a></li>
            <li {{ ($nav_class == "lists" ? 'class=active' : '') }}><a title="Booklists" href="{{ $base_url }}booklists"><img alt="Booklists" style="height:30px" src="{{ $base_url }}images/bookstack.svg" /></a></li>
            <li {{ ($nav_class == "planner" ? 'class=active' : '') }}><a href="{{ $base_url }}bookplanner"><img alt="Reading Queue" style="height:30px" src="{{ $base_url }}images/semaine-12.svg" /></a></li>
            <li {{ ($nav_class == "about" ? 'class=active' : '') }}><a href="{{ $base_url }}about"><img alt="About" style="height:30px" src="{{ $base_url }}images/about.svg" /></a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li {{ ($nav_class == "settings" ? 'class=active' : '') }}><a title="Settings" href="{{ $base_url }}settings"><img alt="Settings" style="height:30px" src="{{ $base_url }}images/settings.svg" /></a></li>
          </ul>          
        </div><!--/.nav-collapse -->
      </div>
    </nav>
@show

@section('main')
    <div class="container">
        <div class="page-heading-template">
            <h1>welcome to boojbooks.</h1>
            <div class="container">
                <div class="row">
                    <form class="form-inline" action="{{ $base_url }}search" method="POST" >
                        <div class="form-group">
                            {{ csrf_field() }}
                            <input type="text" class="form-control" id="query" name="query" placeholder="Search for a book..." value="{{ Session::get('query') }}" style="width:400px;"/>

                            {{ Session::flash('query', null) }}

                            <button type="submit" id="query_submit" class="btn btn-default">Submit</button>
                            <input type="checkbox" name="query_api" class="btn btn-default" value="1"> Google API
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
@show

@section('submain')
    <div id="subnav" class="collapse navbar-collapse" style="margin-top: -30px;margin-left: 30%;">
    <p style="font-style: italic;">There are {{ $books_count }} books in the local database  ( est {{ round((float)$pages_count * 2 / 60, 2) }} hrs )</p>
    @if($reading_queue_books_count > 0)
      <p style="font-style: italic;"><a href="{{ $base_url }}/bookplanner" >{{ $reading_queue_books_count }} books in your Reading Queue ( est {{ round((float)$reading_queue_books_pages_count * 2 / 60, 2) }} hrs )
      ( est {{ round(round((float)$reading_queue_books_pages_count * 2 / 60, 2) * 2, 0) }} days )</a></p>    
    @else
      <p style="font-style: italic;"><a href="{{ $base_url }}/bookplanner" >0 books in your Reading Queue.</a></p>    

    @endif
      <ul class="nav navbar-nav">
        @if($nav_class == "books")
        <li {{ ($nav_class == "new_book" ? 'class=active' : '') }}><a href="{{ $base_url }}books">Create A New Book</a></li>
        @endif
      </ul>
    </div>
@show

<hr /><br />
@if (Session::has('message'))
  <div class="container" style="width:50%">
    <div class="row">
    <div class="alert alert-info"><img style="height:50px;width:70px;padding-right: 15px;" src="https://openclipart.org/download/168880/owl-books.svg" />{{ Session::get('message') }}</div>
    </div>
  </div>    
  {{ Session::flash('message', null) }}
@endif

@section('results')
@show

<div id="fancymessage" style="display:none"></div>
<div class="clearfix">&nbsp;</div>

@section('body_scripts')
    <script type="text/javascript" language="javascript" src="{{ $base_url }}js/jquery-1.12.4.js"></script>
    <script type="text/javascript" language="javascript" src="{{ $base_url }}js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="{{ $base_url }}js/datatables.min.js"></script>    
    <script type="text/javascript" language="javascript" src="{{ $base_url }}fancybox/source/jquery.fancybox.pack.js?v=2.1.6"></script>
    <script type="text/javascript" language="javascript" src="{{ $base_url }}js/app.js">
    </script> 
@show    
  </body>
</html>