@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            @forelse($questions as $question)
            <div class="panel panel-default bordered">
                <div class="panel-heading">
                    <div class='level'>
                        <h4 class='flex'>
                            <a href='{{ $question->path() }}'>{{ $question->title }}</a>
                        </h4>
                        <strong>
                            <a href={{ $question->path()}}>{{ $question->replies_count }} {{ str_plural('answer', $question->replies_count)}}</a> | 
                            <a href={{ $question->path()}}>{{ $question->views }} {{ str_plural('view', $question->view)}}</a> | 
                            <a href={{ $question->path()}}>{{ $question->countUpVoters() - $question->countDownVoters() }} {{ str_plural('vote', $question->countUpVoters() - $question->countDownVoters())}}
                            </a>
                        </strong>
                    </div>
                </div>

                <div class="panel-body">
                    <div class='body'>
                        @forelse($question->tags as $tag)
                            <u><a href="{{ route('tags.show', $tag) }}">{{ $tag->name }}</a></u>
                        @empty
                            <span>No tags to show.</span>
                        @endforelse
                    </div>
                </div>
            </div>
            <hr>
            @empty
            <p>There are no questions asked yet. <a href='/questions/create'>Create one!</a></p>
            @endforelse
        {{$questions->links()}}
        </div>
        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class='level'>
                        <h4 class='flex'>Tags</h4>
                    </div>
                </div>
                @forelse($tags as $tag)
                    <div class="panel-body">
                        <div class='body'>
                            <span class="label label-default"><a href='{{ $tag->path() }}'>{{ $tag->name }}</a></span>
                        </div>
                    </div>
                @empty
                    <p>There are no tags added yet. <a href='/questions/create'>Create one!</a></p>
                @endforelse
            </div>
        </div>    
        </div>
    </div>
</div>
@endsection