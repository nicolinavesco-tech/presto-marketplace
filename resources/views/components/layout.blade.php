<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presto.it</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    
    <x-navbar/>
    
    <div class="min-vh-100">

        {{$slot}}
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>