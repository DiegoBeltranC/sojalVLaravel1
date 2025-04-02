<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Rechazado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef5fc; /* Azul claro suave */
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logo {
            width: 120px; /* Ajusta el tamaño del logo */
            margin-bottom: 20px;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #3498db; /* Azul principal */
            margin-bottom: 10px;
        }
        .content {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .motivo {
            background-color: #fff1fe;
            border-left: 5px solid red;
            padding: 10px;
            font-style: italic;
            color: red;
            margin: 10px auto;
            width: 80%;
        }
        .footer {
            font-size: 14px;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <img src="cid:logo.png" alt="Logo" class="logo">
        <div class="header">Reporte Rechazado</div>
        <div class="content">
            <p>El reporte con <strong>ID: {{ $reporte->id }}</strong> ha sido rechazado.</p>
            <p class="motivo"><strong>Motivo:</strong> {{ $motivo }}</p>
        </div>
        <div class="footer">
            <p>Si tienes alguna duda, contáctanos.</p>
            <p>&copy; {{ date('Y') }} Sojal - Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
