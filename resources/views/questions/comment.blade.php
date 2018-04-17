<div class="flex-container">
<div class="jumbotron">
<div class="panel panel-default" style="line-height: .4em;">
    <div class="panel-heading">
        <div class='level'>
            <h5 class='flex'>
                <a href="{{ $answer->user->path() }}">{{ $comment->user->name }}</a> <small>commented {{ $comment->created_at->diffForHumans() }}...</small>
                <span style="float:right">
                    {{ $comment->countUpVoters() - $comment->countDownVoters() }} {{ str_plural('vote', $comment->countUpVoters() - $comment->countDownVoters())}}
                </span>
            </h5>
        </div>
    </div>
    <div class="panel-body">
           
        <br>
        {!! $comment->body !!}
        <br><br><br>
        <span style="float: right;">
        @if(auth()->check() && (auth()->user()->isAdmin() || auth()->id() == $comment->user_id))
            <a class="btn btn-primary btn-sm" href="{{ route('comments.edit', ['question='=>$question, 'answer'=>$answer, 'comment'=>$comment]) }}">Edit</a>
            <a class="btn btn-warning btn-sm" href="{{ route('comments.destroy', ['question'=>$question, 'answer'=>$answer, 'comment'=>$comment]) }}">Delete</a>
        @endif
        @if(auth()->check() && auth()->id() != $comment->user_id && auth()->user()->isActive())
            @if(!auth()->user()->hasUpVoted($comment))
                <a class="btn btn-success btn-sm" href="{{ route('comments.upvote', ['question'=>$question, 'answer'=>$answer, 'comment'=>$comment]) }}">Upvote</a>
            @endif
            @if(!auth()->user()->hasDownVoted($comment))
                <a class="btn btn-danger btn-sm" href="{{ route('comments.downvote', ['question'=>$question, 'answer'=>$answer, 'comment'=>$comment]) }}">Downvote</a>
            @endif
            @if(auth()->user()->hasVoted($comment))
                <a class="btn btn-primary btn-sm" href="{{ route('comments.cancelvote', ['question'=>$question, 'answer'=>$answer, 'comment'=>$comment]) }}">Cancel Vote</a>
            @endif
        @endif
        </span>
    </div>
</div>
</div>
</div>