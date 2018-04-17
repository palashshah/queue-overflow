<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Model\Tag;
use Illuminate\Http\Request;
use App\Exceptions\UnauthorisedUser;

class TagController extends Controller
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
        $tags = Tag::paginate(15);
        if(request()->wantsJson())
            return $tags;

        return view('tags.index')->withTags($tags);
    }

    public function store(Request $request)
    {
        if($this->isAdmin()){
            $this->validate($request, array(
                'name' => 'required|max:50|unique:tags,name'
                ));

            $tag = new Tag;

            $tag->name = $request->name;
            $tag->save();

            $tags = Tag::paginate(15);
            if(request()->wantsJson())
                return $tags;

            Session::flash('success', 'New tag has been added successfully');
            return redirect()->route('tags.index')->withTags($tags);
        }
    }

    public function show(Tag $tag)
    {
        return view('tags.show')->withTag($tag);    
    }

    public function update(Request $request, Tag $tag)
    {
        if($this->isAdmin()){

            $this->validate($request, ['name' => 'required|max:50|unique:tags,name']);
            $tag->name = $request->name;
            $tag->update();
            // return 'Tag updated';

            if(request()->expectsJson())
                return $tag;

            return redirect()->route('tags.show', $tag->id);
        }
    }

    public function destroy($id)
    {
        if($this->isAdmin()){
            $tag = Tag::find($id);
            $tag->questions()->detach();
            $tag->delete();

            $tags = Tag::paginate(15);
            if(request()->wantsJson())
                return $tags;

            return redirect()->route('tags.index')->withTags($tags);
        }
    }

    public function edit(Request $request, Tag $tag){
        if($this->isAdmin())
            return view('tags.edit')->withTag($tag);
    }

    public function isAdmin(){
        $user = Auth::user();
        if($user->isAdmin())
            return true;
        throw new UnauthorisedUser;
        return false;
    }
}
