@extends('layouts.app')

@section('content')
<div class="row">

	<div class="col-md-12">
		<div class="jumbotron">
			<h3>All Users</h3>
		
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Reputation</th>
						@if(auth()->check() && auth()->user()->isAdmin())
							<th>Action</th>
						@endif
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($users as $user)
						<tr>
							<th>{{ $user->name }}</th>
							<td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
							<td>{{ $user->reputation }}</td>
							@if(auth()->check() && auth()->user()->isAdmin())
								<td>
									@if(!$user->isAdmin())
										<a href="{{ route('users.makeadmin', $user->id) }}" class="btn btn-info btn-sm">Make Admin</a>
									@endif
									@if($user->isActive())
										<a href="{{ route('users.suspend', $user->id) }}" class="btn btn-warning btn-sm">Suspend</a>
									@else
										<a href="{{ route('users.activate', $user->id) }}" class="btn btn-success btn-sm">Activate</a>
									@endif
									@if(auth()->id() != $user->id)									
										<a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm">Delete</a>
									@endif
								</td>
							@endif
							<td>
								@if($user->isActive())
									Active
								@else
									Suspended
								@endif
							</td>
						</tr>
					@empty
						<tr><td colspan="4" align="center">There are no users.</td></tr>
					@endforelse
				{{$users->links()}}
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection