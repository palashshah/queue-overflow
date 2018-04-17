@extends('layouts.app')

@section('content')
<div class="row">

	<div class="col-md-8">
		<h3>{{ $tag->name }} Tag <small>{{ $tag->questions()->count() }} posts</small></h3>
	</div>
	@if(auth()->check() && auth()->user()->isAdmin())
	<div class="col-md-2">
		<a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-primary btn-block" style="margin-top: 20px">Edit Tag</a>
	</div>
	<div class="col-md-2">
		<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#destroy" style="margin-top: 20px;">Delete</button>
	</div>
	@endif
</div>
<br />

<div class="row">
<div class="col-md-12">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Title</th>
				<th>Tags</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($tag->questions as $question)
			<tr>
				<th>{{ $question->id }}</th>
				<td><a href='{{ $question->path() }}'>{{ $question->title }}</a></td>
				<td>
					@foreach ($question->tags as $tag)
						<span class="label label-default"><a href='{{ $tag->path() }}'>{{ $tag->name }}</a></span>
					@endforeach
				</td>
			</tr>
			@empty
			<tr><td colspan="3" align="center">There no questions asked under this tag.	</td></tr>
			@endforelse
		</tbody>
	</table>
	</div>
</div>

<div class="modal fade" id="destroy" role="dialog">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
    		<div class="modal-body">
				<center>Are you sure you want to delete this tag? This step can't be undo!</center>
			</div>
			<div class="modal-footer">
				<center>
					<form action="{{ route('tags.destroy', $tag->id) }}" method="DELETE">
						<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
						<input type="submit" value="Yes" class="btn btn-danger">
					</form>
				</center>
			</div>
		</div>
	</div>
</div>

@endsection