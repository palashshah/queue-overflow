<div class="container">
    <nav class="navbar navbar-expand-md navbar-light bg-light navbar-laravel">
        <div class="navbar-header">

            <!-- Branding Image -->
            @if(Auth()->check())
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'QueueOverflow') }}
                </a>
            @else
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'QueueOverflow') }}
                </a>
            @endif
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('questions.index') }}">Questions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tags.index') }}">Tags</a>
                </li>
                @if(Auth()->check() && auth()->user()->isActive())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('questions.create') }}">Ask Question</a>
                    </li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @if (!Auth()->check())
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown" onclick="markNotificationsAsRead();">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Notifications <span class="badge">({{count(auth()->user()->unreadNotifications)}})</span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <li class="nav-item">@include('notifications.'.snake_case(class_basename($notification->type)))
                                </li>
                            @empty
                                <li class="nav-item"><a href="#" class="nav-link">No unread notifications</a></li>
                            @endforelse
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a class="nav-link" href="{{ route('users.show', auth()->user()) }}">Profile</a></li>
                            <hr>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</div>

<br>