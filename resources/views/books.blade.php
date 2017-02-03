@extends('main')

@section('results')
    <div class="container">
        <div class="row">
        	<div class="wrapper">
        		<h3>Edit book information</h2>
	        	<form action="{{ $base_url }}books/{{ $book['id'] }}" method="POST">
	        	{{ csrf_field() }}
	        	<input type="hidden" name="save_book" value="1" />
	        	<input type="hidden" name="book_id" value="{{ $book['id'] }}" />
	        	<div id="bookdetail">
					<div class="row bookdetail_item">
					        <div class="col-sm-2 bookdetail_item_question rightalign">Title</div>
					        <div class="col-sm-10 bookdetail_item_answer leftalign"><input type="text" name="name" class="form-control" value="{{ $book['name'] }}" /></div>
					</div>
					<div class="row bookdetail_item">
					        <div class="col-sm-2 bookdetail_item_question rightalign">Category</div>
					        <div class="col-sm-10 bookdetail_item_answer leftalign"><input type="text" name="author" class="form-control" value="{{ $book['category'] }}" /></div>
					</div>	
					<div class="row bookdetail_item">
					        <div class="col-sm-2 bookdetail_item_question rightalign">Author</div>
					        <div class="col-sm-10 bookdetail_item_answer leftalign"><input type="text" name="author" class="form-control" value="{{ $book['author'] }}" /></div>
					</div>						
					<div class="row bookdetail_item">
					    <div class="col-sm-2 bookdetail_item_question rightalign">Booklist:</div>
					    <div class="col-sm-10 bookdetail_item_answer leftalign">
       					<select name='booklist_id'>
						<option {{ ($book['booklist_id'] == 0 ? 'SELECTED' : '') }} value="0">- Select -</option>
       					@foreach ($booklists as $item) 
        					<option {{ ($book['booklist_id'] == $item['id'] ? 'SELECTED' : '') }} value=" {{ $item->id }} "'>{{ $item->listname }}</option>
        				@endforeach
        				</select>
					    </div>
					</div>				
					<div class="row bookdetail_item">
					        <div class="col-sm-2 rightalign">Image</div>
					        <div class="col-sm-10 leftalign"><img src="{{ $book['imageurl'] }}" /></div>
					</div>	
					<div class="row bookdetail_item">
					        <div class="col-sm-2 rightalign">Description:</div>
					        <div class="col-sm-10 leftalign"><textarea cols="80" rows="20" name="description">{{ $book['description'] }}</textarea></div>
					</div>
					<div class="row bookdetail_item">
					        <div class="col-sm-2 rightalign">Total Page Count:</div>
					        <div class="col-sm-10 leftalign">{{ $book['page_count'] }}</div>
					</div>						
					<hr /><br />
					<h3>My information</h3>
					<div class="row bookdetail_item">
					        <div class="col-sm-2 rightalign">Current Page Number:</div>
					        <div class="col-sm-10 leftalign"><input type="text" name="pagenum" class="form-control" value="{{ $book['pagenum'] }}" /></div>
					</div>										
					<div class="row bookdetail_item">
					        <div class="col-sm-2 rightalign">My Notes:</div>
					        <div class="col-sm-10 leftalign"><textarea cols="80" rows="20" name="notes">{{ $book['notes'] }}</textarea></div>
					</div>					
					<div class="row bookdetail_item">
					        <div class="col-sm-2 rightalign">&nbsp;</div>
					        <div class="col-sm-10 leftalign">
					        	<input type="submit" name="submit" value="Save" />
					        	<input type="submit" name="delete" value="Delete" />
								<input type="button" id="btnCancel" name="btnCancel" value="Cancel" />					        	
					        </div>
					</div>						
				</div>
				</form>
        	</div>
        </div>
    </div><!-- /.container -->

<script type="text/javascript">
	$('#btnCancel').click(function(event) {
    	window.location.replace('{{ $base_url }}');
    });   
</script>  
@endsection