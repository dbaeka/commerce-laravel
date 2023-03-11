<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
        <title>Checkout</title>

        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        <link href="{{ mix('/css/plugins.css') }}" rel="stylesheet">
    </head>
    <body class="bg-gray-50">
        <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8" id="app">
            <checkout></checkout>
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
