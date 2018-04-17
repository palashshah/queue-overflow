<?php

namespace App\Http\Controllers;

use Purifier;
use App\Model\Answer;
use App\Model\Question;
use App\Model\User;
use Illuminate\Http\Request;
use App\Exceptions\UnauthorisedUser;
use App\Notifications\AnswerPosted;
use App\Notifications\AnswerUpvoted;
use App\Notifications\AnswerDownvoted;
use App\Notifications\AnswerCancelvoted;

class AnswerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Question $question){
        //
    }

    public function show(Answer $answer)
    {
        //
    }

    public function store(Request $request, Question $question)
    {
        $this->validate($request, array(
            'body' => 'required'
        ));

        $user = auth()->user();
        $answer = new Answer;
        $answer->body = Purifier::clean($request->body);
        $answer->question()->associate($question);
        $answer->user()->associate($user);

        $answer->save();

        // return 'Answer added.';
        if(request()->expectsJson()){
            return $answer->load('user');
        }
        
        $question->user->notify(new AnswerPosted($question));
        return redirect()->route('questions.show', $question);
    }

    public function edit(Question $question, Answer $answer){
        return view('answers.edit')->withQuestion($question)->withAnswer($answer);
    }

    public function update(Request $request, Question $question, Answer $answer)
    {
        if($this->checkUser($answer)){
            $answer->body = Purifier::clean($request->body);
            $answer->update();
            
            // return 'Answer updated';
            if(request()->expectsJson())
                return $answer->load('user');

            return redirect()->route('questions.show', $question->id);
        }
    }

    public function destroy(Question $question, Answer $answer)
    {
        if($this->checkUser($answer)){
            $answer->delete();
            // return 'Answer deleted.';
            if($question->accepted_answer == $answer->id){
                $question->accepted_answer = -1;
                $question->update();
            }
            if(request()->expectsJson())
                return $question->load('answers');
            return redirect()->route('questions.show', $question->id);
        }   
    }

    public function checkUser(Answer $answer)
    {
        // return response(['id' => auth()->id()], 100);
        if(auth()->id() != $answer->user_id && !auth()->user()->isAdmin()){
            throw new UnauthorisedUser;
            return false;
        }
        return true;
    }

    public function accept(Question $question, Answer $answer){
        $question->accepted_answer = $answer->id;
        $question->update();

        $answer->user()->increment('reputation', 20);

        if(request()->expectsJson())
            return $question->load('answers');
        return redirect()->route('questions.show', $question->id);
    }

    public function upvote(Question $question, Answer $answer){
        if(auth()->user()->hasDownVoted($answer))
            $answer->user()->increment('reputation', 2);

        auth()->user()->upVote($answer);
        $answer->user()->increment('reputation', 10);
        $answer->user->notify(new AnswerUpvoted($question));
        return redirect()->route('questions.show', $question);
    }

    public function downvote(Question $question, Answer $answer){
        if(auth()->user()->hasUpVoted($answer))
            $answer->user()->decrement('reputation', 10);

        auth()->user()->downVote($answer);
        $answer->user()->decrement('reputation', 2);
        $answer->user->notify(new AnswerDownvoted($question));
        return redirect()->route('questions.show', $question);
    }

    public function cancelvote(Question $question, Answer $answer){
        if(auth()->user()->hasUpVoted($answer))
            $answer->user()->decrement('reputation', 10);
        else if(auth()->user()->hasDownVoted($answer))
            $answer->user()->increment('reputation', 2);
        
        auth()->user()->cancelVote($answer);
        $answer->user->notify(new AnswerCancelvoted($question));
        return redirect()->route('questions.show', $question);
    }
}
