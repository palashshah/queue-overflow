@extends('layouts.app')

@section('content')
<div class="row">
	@if(auth()->check() && auth()->user()->isAdmin())
	<div class="col-md-8">
	@else
	<div class="col-md-12">
	@endif
		<div class="jumbotron">
			<h3>All Tags</h3>
		
			<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($tags as $tag)
					<tr>
						<th>{{ $tag->id }}</th>
						<td><a href="{{ route('tags.show', $tag->id) }}">{{ $tag->name }}</a></td>
					</tr>
					@empty
					<tr><td colspan="2" align="center">There are no tags.</td></tr>
					@endforelse
					{{$tags->links()}}
				</tbody>
			</table>
		</div>
	</div>
	@if(auth()->check() && auth()->user()->isAdmin())
	<div class="col-md-4">
		<div class="jumbotron">
			<form action="{{ route('tags.store') }}" method="POST">
				 {{ csrf_field() }}
				<h3>Add New Tag</h3>
				<br />
				<input type="text" name="name" class="form-control" placeholder="Name" required="">
				<br />
				<input type="submit" value="Add" class="btn btn-primary btn-block">
			</form>
		</div>
	</div>
	@endif
</div>
@endsection