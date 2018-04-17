@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2><strong>Create a New Comment</strong></h2></div>
                <br>
                <div class="panel-body">
                    <form method="POST" action="{{ route('comments.store', ['question'=>$question, 'answer'=>$answer]) }}">
                        {{ csrf_field() }}

                        <div class='form-group'>
                            <label for='body'>Body:</label>
                            <textarea name='body' id='body' class='form-control' rows='5'></textarea>
                        </div>

                        <div class='form-group'>
                            <button type='submit' class='btn btn-success'>Publish</button>
                        </div>
                    
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection