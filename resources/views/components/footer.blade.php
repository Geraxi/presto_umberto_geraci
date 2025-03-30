<!-- Footer -->
<footer class="bg-light py-4 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>{{ config('app.name') }}</h5>
                <p class="mb-0">Il tuo marketplace di fiducia</p>
            </div>
            <div class="col-md-4">
                <h5>Link Utili</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('homepage') }}" class="text-decoration-none">Home</a></li>
                    <li><a href="{{ route('article.index') }}" class="text-decoration-none">Articoli</a></li>
                    @guest
                        <li><a href="{{ route('login') }}" class="text-decoration-none">Accedi</a></li>
                        <li><a href="{{ route('register') }}" class="text-decoration-none">Registrati</a></li>
                    @else
                        <li><a href="{{ route('create.article') }}" class="text-decoration-none">Crea Articolo</a></li>
                    @endguest
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contatti</h5>
                <ul class="list-unstyled">
                    <li>Email: info@presto.it</li>
                    <li>Tel: +39 123 456 7890</li>
                    <li>Indirizzo: Via Example 123, Milano</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. Tutti i diritti riservati.</p>
            </div>
        </div>
    </div>
</footer>
<!-- Footer -->