<x-layout>
    <div class="container pt-5">
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
               <h1 class="display-4 pt-5">
                Pubblica un articolo
               </h1>
            </div>
        </div>
        <div class="row justify-content-center align-items-center height-custom">
            <div class="col-12 col-md-6">
                <livewire:create-article-form />
            </div>
        
    </div>
</x-layout>