<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechSolutions WMS · Registrarse</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;background:linear-gradient(135deg,#0f172a,#1e3a8a);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
        .card{background:#fff;border-radius:14px;padding:36px;width:100%;max-width:380px;box-shadow:0 20px 50px rgba(0,0,0,.35)}
        h1{font-size:22px;color:#0f172a;margin-bottom:4px}
        p.sub{color:#64748b;font-size:14px;margin-bottom:24px}
        label{display:block;font-size:13px;font-weight:600;color:#334155;margin-bottom:6px}
        input[type=text],input[type=email],input[type=password]{width:100%;padding:11px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:15px;margin-bottom:16px}
        input:focus{outline:2px solid #3b82f6;border-color:#3b82f6}
        button[type=submit]{width:100%;padding:12px;background:#2563eb;color:#fff;border:0;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer}
        button[type=submit]:hover{background:#1d4ed8}
        .error{background:#fee2e2;color:#991b1b;padding:10px 12px;border-radius:8px;font-size:13px;margin-bottom:16px}
        .login-link{text-align:center;margin-top:20px;font-size:13px;color:#64748b}
        .login-link a{color:#2563eb;font-weight:600;text-decoration:none}
        .login-link a:hover{text-decoration:underline}
    </style>
</head>
<body>
    <form class="card" method="POST" action="{{ route('register.post') }}">
        @csrf
        <h1>Crear Cuenta</h1>
        <p class="sub">Regístrate para acceder a TechSolutions WMS</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <label for="name">Nombre Completo</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>

        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Confirmar Contraseña</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <button type="submit">Registrarse</button>

        <div class="login-link">
            ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
        </div>
    </form>
</body>
</html>