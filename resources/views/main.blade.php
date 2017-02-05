
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
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="boojbooks is a book information management system">
    <meta name="author" content="Josh Kozlowski <jkozlow@outlook.com>">

    <title>{{ $pagetitle }}</title>
<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ $base_url }}fancybox/source/jquery.fancybox.css?v=2.1.6" type="text/css" media="screen" />
    <!-- Custom styles for this template -->
    <link href="{{ $base_url }}css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">

    </style>    
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
                            <input type="text" class="form-control" id="query" name="query" placeholder="Search for a book..." value="" style="width:400px;"/>

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
      <p style="font-style: italic;">{{ $reading_queue_books_count }} books in your Reading Queue ( est {{ round((float)$reading_queue_books_pages_count * 2 / 60, 2) }} hrs )
      ( est {{ round(round((float)$reading_queue_books_pages_count * 2 / 60, 2) * 2, 0) }} days )</p>    
    @else
      <p style="font-style: italic;">0 books in your Reading Queue.</p>    

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
    <div class="alert alert-info"><img style="height:50px;width:70px;" src="https://openclipart.org/download/168880/owl-books.svg" />{{ Session::get('message') }}</div>
    </div>
  </div>    
  {{ Session::flash('message', null) }}
@endif

@section('results')
  @if($view == 'home')
    <div id="books_linksbar" style="{{ ($search_results ? '' : 'display:none;') }}">
        <a href="#" id="books_panel_show">Display Panel View</a>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="#" id="books_table_show">Display Table View</a>
    </div>  
    <div id="books_panel" class="container">
        <div class="row">
        <div class="wrapper">
        @foreach ($search_results as $item)
            <div class="panel animated slideInDown" onClick="window.location.replace('{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}');">
                <div class="panel_pages_displays"><span>{{ $item['page_count'] }}</span></div>
                <img src="{{ (isset($item['imageLinks']['thumbnail']) ? $item['imageLinks']['thumbnail'] : $item['imageurl']) }}" alt="" />
                  <p class="bookTitle"><a href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}">{{ (isset($item['title']) ? $item['title'] : $item['name']) }}</a></p>
                  <p class="bookAuthor">{{ $item['author'] }}</p>
                  <p class="bookTTR" style="font-size:12px">{{ (isset($item['pageCount']) ? $item['pageCount'] : $item['page_count']) }} pages<br/>est {{ round((isset($item['pageCount']) ? $item['pageCount'] : $item['page_count']) * 2 / 60, 2) }} hrs</p>
                  <p class="bookShortDescription" style="font-size:12px">{{ substr($item['description'], 0, 125) }}...</p>
                  <div class="slide"> 
                  <p>
                  <ul>
                  @if ($item['booklist_id'] != $reading_queue_listid)
                      <span><a href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}?add_to_queue=1&save_book=1"><img alt="Add to Reading Queue" style="height:60px;" src="{{ $base_url }}images/matt-icons_appointment-add.svg" /></a></span>
                  @else
                      <span><a title="Remove from Reading Queue" href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}?add_to_queue=-1&save_book=1"><img alt="Remove from Reading Queue" style="height:60px;" src="{{ $base_url }}images/worn_forbidden.svg" /></a></span>
                  @endif
                    @foreach ($booklists as $booklist) 
                      @if ($item['booklist_id'] != $booklist['id'])
                      <li><a title="Add book to {{ $booklist['listname'] }} list." href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}?save_book=1&booklist_id={{ $booklist['id'] }}"><img style="height:30px" src="{{ $base_url }}images/jean-victor-balin-add-blue.svg" alt="Add book to {{ $booklist['listname'] }} list." /></a></li>
                      @else
                      <li><a title="Remove book from {{ $booklist['listname'] }} list." href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}?save_book=1&booklist_id={{ $booklist['id'] }}"><img style="height:30px" src="{{ $base_url }}images/worn_forbidden.svg" alt="Remove book from {{ $booklist['listname'] }} list." /></a></li>
                      @endif
                    @endforeach
                  </ul>
                  </p>
                    <br />
                  </div>     
                               
            </div>
        @endforeach
        </div>
        </div>
    </div><!-- /.container -->

    <div id="books_table" class="container" style="display:none;">
        <div class="row">
        <div class="wrapper">
        <table id="bookDataTable" class="table table-striped table-bordered">
        <thead>
          <th>Title</th>
          <th>Author</th>
          <th>Description</th>
          <th>&nbsp;</th>
        </thead>
        <tbody>
        @foreach ($search_results as $item)    
          <tr class="table_row" onClick="window.location.replace('{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}');" {{ ((float) ($loop->index / 2) == ((int) ($loop->index / 2)) ? 'class=table_row_a' : 'class=table_row_b') }} id="{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}">
          <td><a href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}">{{ (isset($item['title']) ? $item['title'] : $item['name']) }}</a></td>
          <td>{{ $item['author'] }}</td>
          <td>{{ substr($item['description'], 0, 125) }}...</td>
          <td><a href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}?save_book=1&delete=1">delete</a></td>          
          </tr>
        @endforeach
        </tbody>
        </table>    
        </div>
        </div>
    </div>
  @endif
@show
<a href="#fancymessage" class="fancybox">t</a>
<div id="fancymessage" style="display:none"></div>

<div class="clearfix">&nbsp;</div>

@section('body_scripts')
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
    </script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>    
    <script type="text/javascript" src="{{ $base_url }}fancybox/source/jquery.fancybox.pack.js?v=2.1.6"></script>

    <script type="text/javascript" language="javascript" src="{{ $base_url }}js/app.js">
    </script> 
@show    
  </body>
</html>