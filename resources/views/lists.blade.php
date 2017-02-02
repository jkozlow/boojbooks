@extends('main')
@section('results')
    <div class="container">
        <div class="row">
        <div class="wrapper">
		<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<td>List Name</td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<form action="/?mylists=1">
		<tr>
			<td><input type=text name="newlist"  placeholder="New List Name..."  /></td>
			<td><input type=submit name="newlistbutton" id="newlistbutton" value="create"></td>
		</tr>
		</form>
		<tbody>
			@foreach($search_results as $key => $value)
			<tr>
				<td>{{ $value->listname }}</td>
				<td><a href="/?dellist={{ $value->id }}">delete</a></td>
			</tr>
        	@endforeach
        </div>
        </div>
    </div><!-- /.container -->
@endsection