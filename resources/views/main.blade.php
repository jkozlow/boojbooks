
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
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
          <a class="navbar-brand" href="#">{{ $app_name or '' }}</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li {{ ($nav_class == "home" ? 'class=active' : '') }}><a href="{{ $base_url }}">Home</a></li>
            <li {{ ($nav_class == "books" ? 'class=active' : '') }}><a href="{{ $base_url }}search">Books</a></li>
            <li {{ ($nav_class == "lists" ? 'class=active' : '') }}><a href="{{ $base_url }}booklists">Lists</a></li>
            <li {{ ($nav_class == "about" ? 'class=active' : '') }}><a href="{{ $base_url }}about">About</a></li>
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
    <p style="font-style: italic;">There are currently {{ $books_count }} books and {{ $booklists_count }} booklists in the local database</p>
      <ul class="nav navbar-nav">
        @if($nav_class == "books")
        <li {{ ($nav_class == "new_book" ? 'class=active' : '') }}><a href="{{ $base_url }}books">Create A New Book</a></li>
        @endif
      </ul>
    </div>
@show
<hr /><br />
@section('results')
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
                <img src="{{ (isset($item['imageLinks']['thumbnail']) ? $item['imageLinks']['thumbnail'] : $item['imageurl']) }}" alt="" />
                  <p class="bookTitle"><a href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}">{{ (isset($item['title']) ? $item['title'] : $item['name']) }}</a></p>
                  <p class="bookAuthor">{{ $item['author'] }}</p>
                  <p class="bookShortDescription">{{ substr($item['description'], 0, 175) }}...</p>
        
                  <div class="slide"> 
                  <p>
                  <a href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}">Open Book Details</a><br />
                
                  </p>
                  <p>
                  <ul>
                  @if ($item['booklist_id'] )
                    <li><a href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}?save_book=1&booklist_id=0 }}">- Remove from Lists -</a></li>
                  @endif
                      <span>Add to List</span>
                    @foreach ($booklists as $booklist) 
                      <li {{ ($booklist['id'] == $item['booklist_id'] ? "style=color:green;" : '') }}><a {{ ($booklist['id'] == $item['booklist_id'] ? "style=color:green;" : '') }} href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}?save_book=1&booklist_id={{ $booklist['id'] }}">{{ $booklist['listname'] }} {{ ($booklist['id'] == $item['booklist_id'] ? " *** Currently In List " : '') }}</a></li>
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
          <td>{{ substr($item['description'], 0, 175) }}...</td>
          <td><a href="{{ $base_url }}books/{{ (isset($item['book_id']) ? $item['book_id'] : $item['id']) }}?save_book=1&delete=1">delete</a></td>          
          </tr>
        @endforeach
        </tbody>
        </table>    
        </div>
        </div>
    </div>
@show

<div class="clearfix">&nbsp;</div>

@section('body_scripts')
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
    </script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>    
    <script type="text/javascript" language="javascript" src="{{ $base_url }}js/app.js">
    </script> 
@show    
  </body>
</html>