<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsualización de Perfil</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .banner {
            background: #41B2A2;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .banner h1 {
            margin: 0;
            font-size: 24px;
        }

        .profile-section {
            display: flex;
            padding: 20px;
            gap: 20px;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .profile-section img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        .profile-info {
            flex: 1;
        }

        .profile-info label {
            display: block;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .profile-info input {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f4f4f4;
            pointer-events: none;
        }

        .form-section {
            padding: 20px;
        }

        .form-section .form-group {
            display: flex;
            gap: 20px;
        }

        .form-section .form-group .input-container {
            flex: 1;
        }

        .form-section label {
            display: block;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .form-section input {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f4f4f4;
            pointer-events: none;
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .edit-btn {
            background-color: #28a745;
            color: #fff;
        }

        .edit-btn:hover {
            opacity: 0.9;
        }

        .home-btn {
            background-color: #007bff;
            color: #fff;
        }

        .home-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="banner">
            <h1>Configuración del Perfil</h1>
        </div>
        <div class="profile-section">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default_profile.png') }}" alt="Foto de Perfil">
            <div class="profile-info">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" value="{{ Auth::user()->nombre }}" disabled>
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" value="{{ Auth::user()->correo }}" disabled>
            </div>
        </div>
        <div class="form-section">
            <div class="form-group">
                <div class="input-container">
                    <label for="apellido-paterno">Apellido Paterno</label>
                    <input type="text" id="apellido-paterno" value="{{ Auth::user()->apellidos['paterno'] }}" disabled>
                </div>
                <div class="input-container">
                    <label for="apellido-materno">Apellido Materno</label>
                    <input type="text" id="apellido-materno" value="{{ Auth::user()->apellidos['materno'] }}" disabled>
                </div>
            </div>
            <div class="form-group">
                <div class="input-container">
                    <label for="curp">CURP</label>
                    <input type="text" id="curp" value="{{ Auth::user()->curp }}" disabled>
                </div>
                <div class="input-container">
                    <label for="rfc">RFC</label>
                    <input type="text" id="rfc" value="{{ Auth::user()->rfc }}" disabled>
                </div>
            </div>
        </div>
        <div class="buttons-container">
            <a href="{{ route('perfil.edit') }}" class="btn edit-btn">Editar Perfil</a>
            <a href="{{ route('admin.estadisticas.index') }}" class="btn home-btn">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
