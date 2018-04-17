<div class="panel panel-default">
    <div class="panel-heading">
        <div class='level'>
            <h5 class='flex'>
                <a href="{{ $answer->user->path() }}">{{ $answer->user->name }}</a> <small>answered {{ $answer->created_at->diffForHumans() }}...</small>
                <span style="float:right">
                    {{ $answer->countUpVoters() - $answer->countDownVoters() }} {{ str_plural('vote', $answer->countUpVoters() - $answer->countDownVoters())}}
                    @if(auth()->check() && auth()->id() == $question->user_id && !$question->hasAcceptedAnswer())
                            | <a class="btn btn-success btn-sm" href="{{ route('answers.accept', ['question'=>$question, 'answer'=>$answer]) }}">Accept</a>
                    @else
                        @if($question->accepted_answer == $answer->id)
                            | <span class="label label-success">[Accepted]</span>
                        @endif
                    @endif 
                </span>
            </h5>
        </div>
    </div>
    <div class="panel-body">
           
        <br>
        {!! $answer->body !!}
    </div>
    <div class="panel-footer">
        <br>
        <span style="float:left;">
            @if(auth()->check() && auth()->user()->isActive())
                <a href="{{route('comments.create', ['question'=>$question, 'answer'=>$answer])}}" class="btn btn-info btn-sm"><i class="fas fa-reply"></i> Reply</a>
            @endif
        </span>
        <span style="float:right;">
            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->id() == $answer->user_id))
                <a class="btn btn-primary btn-sm" href="{{ route('answers.edit', ['question='=>$question, 'answer'=>$answer]) }}">Edit</a>
                <a class="btn btn-warning btn-sm" href="{{ route('answers.destroy', ['question'=>$question, 'answer'=>$answer]) }}">Delete</a>
            @endif
            @if(auth()->check() && auth()->id() != $answer->user_id && auth()->user()->isActive())
                @if(!auth()->user()->hasUpVoted($answer))
                    <a class="btn btn-success btn-sm" href="{{ route('answers.upvote', ['question'=>$question, 'answer'=>$answer]) }}">Upvote</a>
                @endif
                @if(!auth()->user()->hasDownVoted($answer))
                    <a class="btn btn-danger btn-sm" href="{{ route('answers.downvote', ['question'=>$question, 'answer'=>$answer]) }}">Downvote</a>
                @endif
                @if(auth()->user()->hasVoted($answer))
                    <a class="btn btn-primary btn-sm" href="{{ route('answers.cancelvote', ['question'=>$question, 'answer'=>$answer]) }}">Cancel Vote</a>
                @endif
            @endif
        </span>
    </div>
    <br>
</div>
