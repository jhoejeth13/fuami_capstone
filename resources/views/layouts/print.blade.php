<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @yield('styles')
</head>
<body>
    @yield('content')
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
                window.close();
            }, 200);
        };
    </script>
</body>
</html>