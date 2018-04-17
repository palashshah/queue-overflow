@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Question</div>

                <div class="panel-body">
                	<form method="POST" action="{{ route('questions.update', $question->id) }}">
				        {{ csrf_field() }}

				        <div class='form-group'>
				            <label for='title'>Title:</label>
				            <input type='text' class='form-control' name='title' value="{{ $question->title }}" required>
				        </div>

				        <div class='form-group'>
				            <label for='body'>Body:</label>
				            <textarea name='body' id='body' class='form-control' rows='8'>{!! $question->body !!}</textarea>
				        </div>

				        <div class='form-group'>
				        	<a href="{{ route('questions.show', $question) }}" class="btn btn-danger">Cancel</a>
				            <button type='submit' class='btn btn-primary'>Edit</button>
				        </div>
				    
				    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection