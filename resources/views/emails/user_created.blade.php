<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .header {
            background: #0ca789;
            color: white;
            padding: 15px;
            border-radius: 5px 5px 0 0;
            font-size: 22px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            color: #333;
            text-align: left;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            color: white;
            background: #0ca789;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        .button:hover {
            background: #33ccae;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('/public/images/Icons/logo.png') }}" class="logo" alt="Logo de Tu Aplicación">
        <div class="header">
            ¡Bienvenido, {{ $user->nombre }}!
        </div>
        <div class="content">
            <p>Tu cuenta ha sido creada exitosamente en nuestra plataforma. ¡Estamos felices de tenerte con nosotros! ❤️</p>
            <p><strong>Correo:</strong> {{ $user->correo }}</p>
            <p><strong>Contraseña temporal:</strong> {{ $plainPassword }}</p>
            <p>Te recomendamos cambiar tu contraseña la primera vez que ingreses.</p>
        </div>
        <div class="footer">
            Saludos,<br>
            <strong>El equipo de SOJAL</strong>
        </div>
    </div>
</body>
</html>
