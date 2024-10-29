<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        .profile-container {
            width: 100%;
            max-width: 800px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative; /* Adicionado para posicionar a imagem corretamente */
        }
        .banner {
            width: 100%;
            height: 200px;
            background-image: url('https://via.placeholder.com/800x200');
            background-size: cover;
            background-position: center;
        }
        .profile-image {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            position: absolute;
            top: 150px; /* Mudado para ficar acima do banner */
            left: 50%;
            transform: translateX(-50%);
            border: 4px solid #fff;
            z-index: 1; /* Garantindo que a imagem fique acima do banner. */
        }
        .content {
            padding: 80px 20px 20px;
            text-align: center;
        }
        h1 {
            font-size: 2rem;
            margin: 0;
        }
        p {
            font-size: 1rem;
            color: #666;
            margin: 10px 0 20px;
        }
        .links {
            margin-top: 30px;
        }
        .link-item {
            margin: 10px auto;
            padding: 10px;
            border-radius: 8px;
            width: 90%;
            transition: background-color 0.3s;
        }
        .link-item a {
            text-decoration: none;
            font-size: 1.1rem;
            color: inherit;
            font-weight: bold;
        }
        .link-item:hover {
            background-color: #f0f2f5;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="banner"></div>
        <img class="profile-image" src="https://via.placeholder.com/120" alt="Profile Image">
        <div class="content">
            <h1>{{ $title ?? 'John Doe' }}</h1>
            <p>{{ $description ?? 'Bem-vindo ao meu perfil! Aqui compartilho links úteis e informações sobre mim.' }}</p>

            @if($links->isNotEmpty())
                <div class="links">
                    <h2>Meus Links</h2>
                    @foreach($links as $link)
                        <div class="link-item" style="background-color: {{ $link->op_bg_color }}; color: {{ $link->op_text_color }};">
                            <a href="{{ $link->url }}" target="_blank">{{ $link->title }}</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html>
