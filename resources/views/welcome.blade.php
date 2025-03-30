<x-layout>
    <x-slot:title>
        {{ config('app.name') }}
    </x-slot>
    
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">Benvenuto su {{ config('app.name') }}</h1>
                <p class="text-center mb-4">Scopri i migliori articoli selezionati per te</p>
            </div>
        </div>

        @guest
        <div class="row mb-5">
            <div class="col-md-8 mx-auto">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h2 class="card-title mb-3">Vuoi diventare revisore?</h2>
                        <p class="card-text mb-4">Unisciti al nostro team di revisori e aiuta a mantenere alta la qualità dei contenuti pubblicati.</p>
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Registrati Ora</a>
                    </div>
                </div>
            </div>
        </div>
        @endguest
        
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-4">Ultimi Articoli</h2>
            </div>
        </div>
        
        <div class="row">
            @forelse($articles as $article)
                <div class="col-md-4 mb-4">
                    <x-card :article="$article" />
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Nessun articolo disponibile al momento.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>