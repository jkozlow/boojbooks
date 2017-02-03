@extends('main')
@section('results')
    <div class="container">
        <div class="row">
        <div class="wrapper">
        <div>
        <form action="{{ $base_url }}booklists">
		<table>
		<tr>
		<td><input type=text name="newlist"  placeholder="New List Name..."  /></td>
		<td><input type=submit name="newlistbutton" id="newlistbutton" value="create"></td>
		</tr>
		</table>
		</form>
		</div>
		<table id="bookDataTable" class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>List Name</td>
				<td>Books</td>				
				<td>&nbsp;</td>
			</tr>
		</thead>
		@foreach($search_results as $key => $value)
		<tr>
			<td><a href="{{ $base_url }}booksinlist/{{ $value->id }}">{{ $value->listname }}</a></td>
			<td><a href="{{ $base_url }}booksinlist/{{ $value->id }}">View</a></td>
			<td><a href="{{ $base_url }}booklists/{{ $value->id }}?delete=1">delete</a></td>
		</tr>
    	@endforeach
        </table>
        </div>
        </div>
    </div><!-- /.container -->
@endsection