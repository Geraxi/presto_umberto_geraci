<nav class="navbar navbar-expand-lg bg-white border-bottom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('homepage') }}">{{ config('app.name', 'Laravel') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('article.index') }}">{{ __('Articles') }}</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('create.article') }}">{{ __('Create Article') }}</a>
                    </li>
                @endauth
            </ul>

            <form class="d-flex me-3" role="search" action="{{ route('article.search') }}" method="GET">
                <input class="form-control me-2" type="search" name="q" placeholder="{{ __('Search articles...') }}" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">{{ __('Search') }}</button>
            </form>

            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(Auth::user()->is_revisor)
                                <li>
                                    <a class="dropdown-item" href="{{ route('revisor.index') }}">
                                        {{ __('Revisor Dashboard') }}
                                        @if(App\Models\Article::toBeRevisedCount() > 0)
                                            <span class="badge bg-danger">{{ App\Models\Article::toBeRevisedCount() }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ __('Logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav> 