<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background: #f4f4f9;
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
            background: #f4f4f9;
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
            <h1>Editar Perfil</h1>
        </div>
        <div class="form-section">
            @if(session('success'))
                <div class="alert alert-success" style="text-align:center; color: green;">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('perfil.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <div class="input-container">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $user->nombre) }}">
                    </div>
                    <div class="input-container">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" class="form-control" value="{{ old('correo', $user->correo) }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-container">
                        <label for="apellido-paterno">Apellido Paterno</label>
                        <input type="text" name="apellidos[paterno]" id="apellido-paterno" class="form-control" value="{{ old('apellidos.paterno', $user->apellidos['paterno'] ?? '') }}">
                    </div>
                    <div class="input-container">
                        <label for="apellido-materno">Apellido Materno</label>
                        <input type="text" name="apellidos[materno]" id="apellido-materno" class="form-control" value="{{ old('apellidos.materno', $user->apellidos['materno'] ?? '') }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-container">
                        <label for="curp">CURP</label>
                        <input type="text" name="curp" id="curp" class="form-control" value="{{ old('curp', $user->curp) }}">
                    </div>
                    <div class="input-container">
                        <label for="rfc">RFC</label>
                        <input type="text" name="rfc" id="rfc" class="form-control" value="{{ old('rfc', $user->rfc) }}">
                    </div>
                </div>
                <div class="buttons-container">
                    <button type="submit" class="btn edit-btn">Guardar Cambios</button>
                    <a href="{{ route('admin.configuracion') }}" class="btn home-btn">Cancelar</a>

                </div>
            </form>
        </div>
    </div>
</body>
</html>


