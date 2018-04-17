@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2><strong>Edit Comment</strong></h2></div>

                <div class="panel-body">
                	<form method="POST" action="{{ route('comments.update', ['question'=>$question, 'answer'=>$answer, 'comment'=>$comment]) }}">
				        {{ csrf_field() }}

				        <div class='form-group'>
				            <label for='body'>Comment:</label>
				            <textarea name='body' id='body' class='form-control' rows='8'>{{ $comment->body }}</textarea>
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