<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechSolutions WMS · Iniciar sesión</title>
    <!-- FontAwesome para el ícono de GitHub -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;background:linear-gradient(135deg,#0f172a,#1e3a8a);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
        .card{background:#fff;border-radius:14px;padding:36px;width:100%;max-width:380px;box-shadow:0 20px 50px rgba(0,0,0,.35)}
        h1{font-size:22px;color:#0f172a;margin-bottom:4px}
        p.sub{color:#64748b;font-size:14px;margin-bottom:24px}
        label{display:block;font-size:13px;font-weight:600;color:#334155;margin-bottom:6px}
        input[type=email],input[type=password]{width:100%;padding:11px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:15px;margin-bottom:16px}
        input:focus{outline:2px solid #3b82f6;border-color:#3b82f6}
        .remember{display:flex;align-items:center;gap:8px;font-size:13px;color:#475569;margin-bottom:18px}
        button[type=submit]{width:100%;padding:12px;background:#2563eb;color:#fff;border:0;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer}
        button[type=submit]:hover{background:#1d4ed8}
        .error{background:#fee2e2;color:#991b1b;padding:10px 12px;border-radius:8px;font-size:13px;margin-bottom:16px}
        
        /* Estilos para el separador y botón de GitHub */
        .divider{display:flex;align-items:center;text-align:center;margin:20px 0;color:#94a3b8;font-size:12px}
        .divider::before, .divider::after{content:'';flex:1;border-bottom:1px solid #e2e8f0}
        .divider:not(:empty)::before{margin-right:.75em}
        .divider:not(:empty)::after{margin-left:.75em}
        .btn-github{display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:11px;background:#24292e;color:#fff;border:0;border-radius:8px;font-size:15px;font-weight:600;text-decoration:none;cursor:pointer;transition:background .2s}
        .btn-github:hover{background:#1b1f23}
    </style>
</head>
<body>
    <form class="card" method="POST" action="{{ route('login.post') }}">
        @csrf
        <h1>TechSolutions WMS</h1>
        <p class="sub">Inicia sesión para administrar el inventario</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <label for="email">Correo</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <label class="remember"><input type="checkbox" name="remember"> Recordarme</label>

        <button type="submit">Ingresar</button>

        <!-- Separador -->
        <div class="divider">o continúa con</div>

        <!-- Botón de Inicio de Sesión con GitHub -->
        <a href="{{ route('auth.github') }}" class="btn-github">
            <i class="fa-brands fa-github text-lg"></i> Iniciar sesión con GitHub
        </a>
    </form>
</body>
</html>