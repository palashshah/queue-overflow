@extends('layouts.app')

@section('content')

	<form action="{{ route('tags.update', $tag) }}" method="POST">
		 {{ csrf_field() }}
		<div class="form-group">
			<label>Name:</label>
			<input type="text" name="name" class="form-control" value="{{ $tag->name }}">
		</div>
		<br />
		<a href="{{ route('tags.show', $tag) }}" class="btn btn-danger">Cancel</a>

		<button type="submit" class="btn btn-primary">Save</button>

	</form>

@endsection