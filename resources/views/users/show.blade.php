@extends('layouts.app')

@section('content')
<div class="row">

	<div class="col-md-12">
		<h3>{{ $user->name }} <small> ({{$user->email}}) | {{ $user->questions()->count() }} {{ str_plural('posts', $user->questions()->count()) }} | {{ $user->reputation }} {{ str_plural('points', $user->reputation) }}

		@if(auth()->check() && auth()->user()->isAdmin())
		<span style="float:right">
			<form action="{{ route('users.reward', $user) }}" method="POST">
				 {{ csrf_field() }}
				<input type="number" name="points" placeholder="Points">
				<input class="btn btn-primary" type="submit" value="Reward">
			</form>
		</span>
		@endif
		</small>
		</h3>
	</div>

</div>
<br />

<div class="row">
<div class="col-md-12">
	<div class="jumbotron">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Title</th>
				<th>Tags</th>
				@if(auth()->check() && (auth()->id() == $user->id || auth()->user()->isAdmin()))
					<th>Actions</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@forelse ($user->questions as $question)
			<tr>
				<th>{{ $question->id }}</th>
				<td><a href='{{ $question->path() }}'>{{ $question->title }}</a></td>
				<td>
					@foreach ($question->tags as $tag)
						<span class="label label-default"><a href='{{ $tag->path() }}'>{{ $tag->name }}</a></span>
					@endforeach
				</td>
				@if(auth()->check() && (auth()->id() == $user->id || auth()->user()->isAdmin()))
					<td>
						<a href="{{ route('questions.edit', $question->id) }}" class="btn btn-primary btn-sm">Edit</a>
						<a href="{{ route('questions.destroy', $question->id) }}" class="btn btn-danger btn-sm">Delete</a>	
					</td>
				@endif
			</tr>
			@empty
			<tr><td colspan="3" align="center">No questions asked yet.</td></tr>
			@endforelse
		</tbody>
	</table>
	</div>
	</div>
</div>

@if($user->questions->count() > 0)
<div class="modal fade" id="destroy" role="dialog">
	<div class="modal-dialog modal-sm">
    	<div class="modal-content">
    		<div class="modal-body">
				<center>Are you sure you want to delete this question? This step can't be undo!</center>
			</div>
			<div class="modal-footer">
				<center>
					<form action="{{ route('questions.destroy', $question->id) }}" method="DELETE">
						<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
						<input type="submit" value="Yes" class="btn btn-danger">
					</form>
				</center>
			</div>
		</div>
	</div>
</div>
@endif
@endsection