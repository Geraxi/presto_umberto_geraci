<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div class="container py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mb-4">Latest Articles</h1>
                </div>
            </div>
            <div class="row">
                @forelse($articles as $article)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($article->body, 100) }}</p>
                                <p class="card-text"><strong>Price: €{{ number_format($article->price, 2) }}</strong></p>
                                <p class="card-text"><small class="text-muted">Category: {{ $article->category->name }}</small></p>
                                <a href="{{ route('article.show', $article) }}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No articles found.</p>
                    </div>
                @endforelse
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>