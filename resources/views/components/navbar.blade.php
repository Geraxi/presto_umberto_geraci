<nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('homepage') }}">Presto.it</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      < class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('homepage') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{ route('article.index') }}">Tutti gli articoli</a>
        </li>
        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Ciao, {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('create.article') }}">Crea</a></li>
            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.querySelector('#form-logout').submit();">Logout</a></li>
            <form action="{{ route('logout') }}" method="post" class="d-none" id="form-logout"@csrf></form>
          </ul>
        </li>
        


        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categorie
          </a>
          <ul class="dropdown-menu">
            @foreach ($categories as $category)
            <li><a class="dropdown-item text-capitalize" href="{{ $category->name }}">{{ $category->name }}</a></li>
            @if (!$loop->last)
            <hr class="dropdown-divider">
            @endif
            @endforeach
            
            
          </ul>
        </li>
        
          
         @else
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Ciao, utente!
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('login') }}">Accedi</a></li>
            <li><a class="dropdown-item" href="{{ route('register') }}">Registrati</a></li>
            
          </ul>
        </li>
        @endauth
    </div>
  </div>
</nav>