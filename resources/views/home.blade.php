@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body" align="center">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    Welcome to Queue Overflow!

                    @if(!auth()->user()->isActive())
                    <div class="alert alert-danger">
                        Your account has been suspended. You are in read-only mode.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
