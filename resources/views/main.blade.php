
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $browser_title or '' }}</title>
<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
ul{
    list-style:none;
    padding:0;
}
.wrapper {
  margin: 40px auto;
  width: 930px;
  height: 500px;
}
.wrapper::before, .wrapper::after {
  content: "";
  display: table;
  clear: both;
}
.wrapper .panel {
  position: relative;
  margin: 50px 20px;
  padding: 0 20px 20px;
  overflow: hidden;
  float: left;
  width: 270px;
  height: 450px;
  text-align: center;
  background: #F1F1F1;
  border: 1px solid #101010;
  box-sizing: border-box;
  transition: border 200ms ease;
  cursor: pointer;
}
.wrapper .panel img {
  display: block;
  margin: 20px auto;
  text-align: center;
}
.wrapper .panel h3 {
  display: block;
  margin-bottom: 15px;
  color: #101010;
  font-size: 18px;
  font-weight: 700;
  text-align: center;
  text-shadow: 0 2px 1px #FFF;
}
.wrapper .panel p {
  font-size: 14px;
  text-shadow: 0 1px 1px #FFF;
}
.wrapper .panel .slide {
  position: absolute;
  bottom: -450px;
  left: 0;
  z-index: 100;
  padding: 20px;
  height: 100%;
  width: 100%;
  text-align: left;
  background: rgba(210, 210, 210, 0.95);
  box-sizing: border-box;
  transition: all 300ms 500ms cubic-bezier(0.645, 0.045, 0.355, 1);
}
.wrapper .panel .slide h4 {
  margin-bottom: 20px;
  text-align: left;
  text-shadow: none;
  font-size: 18px;
  font-weight: 600;
  color: #39cc62;
}
.wrapper .panel .slide ul li {
  padding: 5px 5px 5px 8px;
  line-height: 24px;
  font-size: 13px;
  color: #F0F0F0;
  border-bottom: 1px solid #3e737b;
}
.wrapper .panel .slide ul li:last-child {
  border: 0;
}
.wrapper .panel .slide ul li .fa {
  padding-right: 5px;
  color: #39cc62;
}

.panel:hover {
  border: 1px solid #101010;
}
.panel:hover .slide {
  bottom: 0;
  cursor: pointer;
}

.animated {
  animation-duration: 500ms;
  animation-fill-mode: both;
  animation-delay: 1s;
}

.slideInDown {
  -webkit-animation-name: slideInDown;
  animation-name: slideInDown;
}

p.title {
  margin: 0 auto;
  padding: 0;
  font-size: 14px;
  line-height: 16px;
  font-weight: 400;
  height: 36px;
  width: 890px;
  background: #013d47;
  border: 1px solid #2ba74e;
  color: #FFF;
  text-align: center;
  border-radius: 5px;
}
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
            <li class="active"><a href="/">Home</a></li>
            <li><a href="/?mylists=1">The Lists</a></li>
            <li><a href="/?about=1">About</a></li>
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
                    <form class="form-inline" action="/" method="POST" >
                        <div class="form-group">
                            {{ csrf_field() }}
                            <input type="text" class="form-control" id="query" name="query" placeholder="Search for a book..." value="{{ $query }}" style="width:400px;"/>
                            <button type="submit" id="query_submit" class="btn btn-default">Submit</button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
@show

@section('results')
    <div class="container">
        <div class="row">
        <div class="wrapper">
        @foreach ($search_results as $item)
            <div class="panel animated slideInDown">
                <img src="{{ $item['imageLinks']['thumbnail'] }}" alt="" />
                  <h3>{{ $item['title'] }}</h3>
                  <p>&nbsp;</p>
                  <p>{{ $item['description'] }}</p>
                  <p></p>
                  <div class="slide"> 
                    Add to List
                  <ul> 
                    @foreach ($booklists as $booklist) 
                      <li {{ ($booklist['id'] == $item['booklist_id'] ? "style='background-color:yellow !important;'" : '') }}><a href="/?book_id={{ $item['book_id'] }}&booklist_id={{ $booklist['id'] }}&assign=1">{{ $booklist['listname'] }}</a></li>
                    @endforeach
                  </ul>
                    <br />
                  </div>                    
            </div>
        @endforeach
        </div>
        </div>
    </div><!-- /.container -->
@show


    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
    </script>
  </body>
</html>
