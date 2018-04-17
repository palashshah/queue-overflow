<?php

namespace App\Http\Controllers;

use Purifier;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\Question\QuestionResource;
use App\Http\Resources\Question\QuestionCollection;
use App\Model\Question;
use App\Model\User;
use App\Model\Tag;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\UnauthorisedUser;
use Auth;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::orderBy('replies_count', 'desc')->paginate(10);
        $tags = Tag::all();

        if(request()->wantsJson())
            return $questions;

        return view('questions.index')->withQuestions($questions)->withTags($tags);
    }

    public function store(QuestionRequest $request)
    {

        $question = new Question;
        $question->title = $request->title;
        $question->body = Purifier::clean($request->body);
        $question->user()->associate(Auth::user());
        $question->save();

        if($question)
        {        
            $tagNames = explode(',', $request->get('tags'));
            $tagIds = [];
            foreach($tagNames as $tagName)
            {
                $tag = Tag::firstOrCreate(['name'=>$tagName]);
                if($tag)
                {
                  $tagIds[] = $tag->id;
                }

            }
            $question->tags()->sync($tagIds);
        }

        if(request()->expectsJson())
            return response([ 'data' => $question ], Response::HTTP_CREATED);

        return redirect()->route('questions.show', $question);
    }

    public function show(Question $question)
    {
        // return new QuestionResource($question);
        $question->increment('views');
        return view('questions.show')->withQuestion($question);
    }

    public function update(Request $request, Question $question)
    {
        if($this->checkUser($question)){
            $this->validate($request, array(
                'title' =>  'required',
                'body'  =>  'required',
            ));

            $question->title = $request->title;
            $question->body = Purifier::clean($request->body);
            $question->update();

            if(request()->expectsJson())
                return response(['data' => $question], Response::HTTP_CREATED);

            return redirect()->route('questions.show', $question->id);
        }
    }

    public function destroy(Question $question)
    {
        if($this->checkUser($question)){
            $question->delete();

            if(request()->expectsJson())
                return response(null, Response::HTTP_NO_CONTENT);

            $questions = Question::orderBy('views', 'desc')->paginate(10);
            $tags = Tag::all();

            return redirect()->route('questions.index')->withQuestions($questions)->withTags($tags);
        }
    }

    public function edit(Question $question){
        return view('questions.edit')->withQuestion($question);
    }

    public function create(){
        $tags = Tag::all();
        return view('questions.create')->withTags($tags);
    }

    public function checkUser(Question $question)
    {
        $user = Auth::user();
        // return response(['id' => Auth::id()], 100);
        if($user->id != $question->user_id && !$user->isAdmin()){
            throw new UnauthorisedUser;
            return false;
        }
        return true;
    }

    public function upvote(Question $question){
        if(auth()->user()->hasDownVoted($question))
            $question->user()->increment('reputation', 2);

        auth()->user()->upVote($question);
        $question->user()->increment('reputation', 10);
        return redirect()->route('questions.show', $question);
    }

    public function downvote(Question $question){
        if(auth()->user()->hasUpVoted($question))
            $question->user()->decrement('reputation', 10);

        auth()->user()->downVote($question);
        $question->user()->decrement('reputation', 2);
        return redirect()->route('questions.show', $question);
    }

    public function cancelvote(Question $question){
        if(auth()->user()->hasUpVoted($question))
            $question->user()->decrement('question', 10);
        else if(auth()->user()->hasDownVoted($answer))
            $question->user()->increment('reputation', 2);
        
        auth()->user()->cancelVote($question);
        return redirect()->route('questions.show', $question);
    }
}
