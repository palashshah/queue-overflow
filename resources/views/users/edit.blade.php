@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a New Question</div>

                <div class="panel-body">
                	<form action="{{ route('users.update', $user) }}" method="PUT">
                		{{ csrf_field() }}
						<div class="form-group">
							<label>Name:</label>
							<input type="text" name="name" class="form-control" value="{{ $user->name }}">
						</div>
						<div class="form-group">
							<label>Email:</label>
							<input type="text" name="email" class="form-control" value="{{ $user->email }}">
						</div>
						<div class="form-group">
							<label>Password:</label>
							<input type="password" name="name" class="form-control" value="{{ $user->password }}">
						</div>
						<br/>
						<div class="form-group">
							<a href="{{ route('users.show', $user) }}" class="btn btn-danger">Cancel</a>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection