<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ url('assets/css/admin.login.css') }}">
    <title>Cadastro Admin</title>
</head>
<body>

<div class="login-wrapper">
    <div class="login-box">
        <h1>Cadastro</h1>

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

        <!-- Formulário de Registro -->
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Campo Nome -->
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <!-- Campo E-mail -->
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <!-- Campo Senha -->
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Campo Confirmar Senha -->
            <div class="form-group">
                <label for="password_confirmation">Confirme a Senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn">Cadastrar</button>
        </form>

        <!-- Seções de recuperação e cadastro com novo estilo -->
        <div class="form-footer">
            <a href="#" class="forgot-password">Esqueceu sua senha?</a>
            <p class="no-account">
                Já tem cadastro? <a href="{{ url('/admin/login') }}" class="register-link">Faça login</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
