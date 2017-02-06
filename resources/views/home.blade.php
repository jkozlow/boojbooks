@extends('layouts.main')
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
@endsection