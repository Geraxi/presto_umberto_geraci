<x-layout>
    <div class="container-fluid">
        <div class="row height-custom justify-content-center align-items-center text-center">
            <div class="col-12">
                <h1 class="display-1">
                    Tutti gli articoli
                </h1>
            </div>
        </div>

        <div class="container-fluid pt-5">
        <div class="row height-custom justify-content-center align-items-center">
            @forelse ($articles as $article)
            <div class="col-12 col-md-3 text-center">
                <x-card :article="$article" />
            </div>
            @empty
            <div class="col-12">
                <h3 class="text-center">
                    Non sono acora stati creati articoli
                </h3>
            </div>
            @endforelse
            </div>
        
    </div>
      <div class="d-flex justify-content-center">
        <div>
            {{ $articles->links() }}
        </div>
      </div>

    </div>

</x-layout>