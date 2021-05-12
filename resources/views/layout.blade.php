<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="favicon.ico">
        <title>@yield('title')</title>

        <!-- Bootstrap core CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="d-flex flex-column h-100">
        <section class="flex-shrink-0">
            <header>
                <div class="navbar navbar-dark bg-dark shadow-sm">
                    <div class="container">
                        <a href="/" class="navbar-brand d-flex align-items-center">
                            <i class="bi bi-bookmark-heart-fill me-1"></i>
                            <strong>{{ config('app.name') }}</strong>
                        </a>
                    </div>
                </div>
            </header>
            <main>

                @yield('content')

            </main>
        </section>

        <footer class="footer mt-auto py-3 bg-dark">
            <div class="container text-center">
                <span class="text-muted">© Book Service 2021</span>
            </div>
        </footer>

        <script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/vue@next"></script>

        @stack('scripts')
    </body>
</html>
