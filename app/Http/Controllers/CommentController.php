<?php

namespace App\Http\Controllers;

use Purifier;
use App\Model\Comment;
use App\Model\Question;
use App\Model\Answer;
use Illuminate\Http\Request;
use App\Exceptions\UnauthorisedUser;
use App\Notifications\CommentPosted;
use App\Notifications\CommentUpvoted;
use App\Notifications\CommentDownvoted;
use App\Notifications\CommentCancelvoted;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function show(Comment $comment)
    {
        //
    }

    public function create(Question $question, Answer $answer){
        return view('comments.create')->withQuestion($question)->withAnswer($answer);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question, Answer $answer)
    {
        $this->validate($request, array(
            'body' => 'required|max:100'
        ));

        $user = auth()->user();
        $comment = new Comment;
        $comment->body = Purifier::clean($request->body);
        $comment->answer_id = $answer->id;
        $comment->user_id = auth()->id();
        $comment->answer()->associate($answer);
        $comment->user()->associate($user);

        $comment->save();

        // return 'Answer added.';
        if(request()->expectsJson()){
            return $comment->load('answer');
        }
        
        $answer->user->notify(new CommentPosted($question));
        return redirect()->route('questions.show', $question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer, Comment $comment)
    {
        return view('comments.edit')->withQuestion($question)->withAnswer($answer)->withComment($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer, Comment $comment)
    {
        if($this->checkUser($comment)){
            $this->validate($request, array(
                'body' => 'required|max:100'
            ));
            
            $comment->body = Purifier::clean($request->body);
            $comment->update();
            
            // return 'Answer updated';
            if(request()->expectsJson())
                return $comment->load('answer');

            return redirect()->route('questions.show', $question->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer, Comment $comment)
    {
        if($this->checkUser($comment)){
            $comment->delete();
            // return 'Answer deleted.';
            if(request()->expectsJson())
                return $question->load('answers');
            return redirect()->route('questions.show', $question->id);
        }
    }

    public function checkUser(Comment $comment)
    {
        // return response(['id' => auth()->id()], 100);
        if(auth()->id() != $comment->user_id && !auth()->user()->isAdmin()){
            throw new UnauthorisedUser;
            return false;
        }
        return true;
    }

    public function upvote(Question $question, Answer $answer, Comment $comment){

        auth()->user()->upVote($comment);
        $comment->user->notify(new CommentUpvoted($question));

        return redirect()->route('questions.show', $question->id);
    }

    public function downvote(Question $question, Answer $answer, Comment $comment){

        auth()->user()->downVote($comment);
        $comment->user->notify(new CommentDownvoted($question));

        return redirect()->route('questions.show', $question->id);
    }

    public function cancelvote(Question $question, Answer $answer, Comment $comment){
        
        auth()->user()->cancelVote($comment);
        $comment->user->notify(new CommentCancelvoted($question));

        return redirect()->route('questions.show', $question->id);
    }
}
