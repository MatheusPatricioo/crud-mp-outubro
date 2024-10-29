<!-- resources/views/page.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            
            font-family: Arial, sans-serif;
            background: {{ $bg }};
            color: {{ $font_color }};
            padding: 20px;
            text-align: center;
        }
        .profile-image {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .links {
            margin-top: 30px;
        }
        .link-item {
            margin-bottom: 10px;
        }
        .link-item a {
            text-decoration: none;
            color: #007bff;
            font-size: 1.1rem;
        }
        .link-item a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <img class="profile-image" src="{{ $profile_image }}" alt="Profile Image">
    <h1>{{ $title }}</h1>
    <p>{{ $description }}</p>

    @if($links->isNotEmpty())
        <div class="links">
            <h2>Links</h2>
            @foreach($links as $link)
                <div class="link-item">
                    <a href="{{ $link->url }}" target="_blank">{{ $link->title }}</a>
                </div>
            @endforeach
        </div>
    @endif
</body>
</html>
