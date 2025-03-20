<x-layout>
<div class="container-fluid text-center bg-body-tertiary">
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-12">
            <h1 class="display-4">
                
                Presto.it
            </h1>
            <div class="my-3">
                @auth
                <a  class="btn btn-dark" href="{{ route('create.article') }}">Pubblica un articolo</a>
                @endauth
        </div>
    </div>

    @if (session()->has('errorMessage'))
    <div class="alert alert-danger text-center shadow rounded w-50">
        {{ session('errorMessage') }}
    </div>
    @endif
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success text-center shadow rounded w-50">
            {{ session('message') }}
        </div>
    
    @endif
</div>
</x-layout>