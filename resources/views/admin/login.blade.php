<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ url('assets/css/admin.login.css') }}">
    <title>Login</title>
</head>
<body>

<div class="login-wrapper">
    <div class="login-box">
        <h1>Login</h1>

        <!-- Exibir erros de validação -->
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Exibir mensagem de erro do login -->
        @if (session('error'))
            <div class="error">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Formulário de Login -->
        <form action="{{ route('login') }}" method="POST">
            @csrf  <!-- validando que é um forms -->

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn">Entrar</button>
        </form>

        <!-- Seções de recuperação e cadastro com novo estilo -->
        <div class="form-footer">
            <a href="#" class="forgot-password">Esqueceu sua senha?</a>
            <p class="no-account">
                Ainda não tem uma conta? <a href="{{ url('/admin/register') }}" class="register-link">Cadastre-se</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
