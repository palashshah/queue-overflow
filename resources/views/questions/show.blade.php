@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
    <div class="row">
         <div class="col-md-12 col-md-offset-2">
             <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>{{ $question->title }}</h4>
                    Posted by <a href="{{ $question->user->path() }}">{{ $question->user->name }}</a> | {{ $question->created_at->diffForHumans() }}
                    <span style="float:right">
                        {{ $question->countUpVoters() - $question->countDownVoters() }} {{ str_plural('vote', $question->countUpVoters() - $question->countDownVoters())}} | {{ $question->views }} {{ str_plural('view', $question->views)}}
                    </span>
                    <br>
                    Tags:
                    @foreach($question->tags as $tag)
                        <span class="label label-default"><a href="{{$tag->path()}}">{{$tag->name}}</a></span>
                    @endforeach
                </div>
 
                <div class="panel-body">
                    {!! $question->body !!}
                </div>
                <div class="panel-footer">
                    @if(auth()->check() && auth()->user()->isActive())
                        <br><br>
                        @if(auth()->user()->isAdmin() || auth()->id() == $question->user_id)
                            <a class="btn btn-primary btn-sm" href="{{ route('questions.edit', ['question' => $question]) }}">Edit</a>&nbsp;
                            <a class="btn btn-warning btn-sm" href="{{ route('questions.destroy', ['question' => $question]) }}">Delete</a>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->id() != $question->user_id)
                            @if(!auth()->user()->hasUpVoted($question))
                                <a class="btn btn-success btn-sm" href="{{ route('questions.upvote', ['question'=>$question]) }}">Upvote</a>
                            @endif
                            @if(!auth()->user()->hasDownVoted($question))
                                <a class="btn btn-danger btn-sm" href="{{ route('questions.downvote', ['question'=>$question]) }}">Downvote</a>
                            @endif
                            @if(auth()->user()->hasVoted($question))
                                <a class="btn btn-primary btn-sm" href="{{ route('questions.cancelvote', ['question'=>$question]) }}">Cancel Vote</a>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    <hr>
    <br>
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
        @foreach($question->answers as $answer)
            @include('questions.answer')
                @foreach($answer->comments as $comment)
                <br><br>
                <div class="row">
                    <div class="col-md-4">
                        <br>
                        <hr>
                    </div>
                    <div class="col-md-8">
                        @include('questions.comment')
                    </div>
                </div>
                @endforeach
                <hr>
        @endforeach
        </div>
    </div>

    <div class='row'>
        <div class="col-md-12 col-md-offset-2">
        @if(auth()->check())
            @if(auth()->user()->isActive())
            <form method='POST' action='{{ $question->path() . "/answers" }}'>
                {{ csrf_field() }}

                <div class='form-group'>
                    <h3><label><strong>Your Answer:</strong></label></h3>
                    <textarea name='body' id='body' class='form-control' placeholder='Write your answer here' rows='5'></textarea>
                </div>

                <button type='submit' class='btn btn-success'>Post</button>
            </form>
            @else
            <p>You have been suspended by the admin.</p>
            @endif
        @else
            <p>Please <a href='{{ route("login") }}'>sign in</a> to post an answer.</p>
        @endif
        </div>
    </div>
</div>
@endsection