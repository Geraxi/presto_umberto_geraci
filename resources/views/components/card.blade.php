@props(['article'])

<div class="card h-100">
    @if($article->images->count() > 0)
        <img src="{{ Storage::url($article->images->first()->path) }}" class="card-img-top img-cover" alt="{{ $article->title }}" style="height: 200px;">
    @endif
    <div class="card-body">
        <h5 class="card-title">{{ $article->title }}</h5>
        <p class="card-text text-truncate-2">{{ $article->body }}</p>
        <p class="card-text">
            <strong>Prezzo:</strong> €{{ number_format($article->price, 2) }}
        </p>
        <p class="card-text">
            <small class="text-muted">
                Categoria: {{ $article->category->name }}
            </small>
        </p>
        <a href="{{ route('article.show', $article) }}" class="btn btn-primary">Leggi di più</a>
    </div>
    <div class="card-footer text-muted">
        Pubblicato il {{ $article->created_at->format('d/m/Y') }} da {{ $article->user->name }}
    </div>
</div>