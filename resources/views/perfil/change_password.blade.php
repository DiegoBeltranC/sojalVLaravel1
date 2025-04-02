<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
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
            max-width: 600px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .banner {
            background: #41B2A2;
            color: #fff;
            text-align: center;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .banner h1 {
            margin: 0;
            font-size: 24px;
        }
        form {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 95%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 38px;
            cursor: pointer;
            color: #007bff;
            font-size: 14px;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .buttons-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
        }
        .save-btn {
            background-color: #28a745;
        }
        .cancel-btn {
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="banner">
            <h1>Cambiar Contraseña</h1>
        </div>
        <form action="{{ route('perfil.updatePassword') }}" method="POST" onsubmit="return validarContrasenas()">
            @csrf

            <!-- Contraseña actual -->
            <div class="form-group">
                <label for="current_password">Contraseña actual:</label>
                <input type="password" id="current_password" name="current_password" required>
                <button type="button" class="toggle-password" onclick="togglePassword('current_password', this)">
                    <i class="fas fa-eye"></i>
                </button>
                @error('current_password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nueva contraseña -->
            <div class="form-group">
                <label for="new_password">Nueva contraseña:</label>
                <input type="password" id="new_password" name="new_password" required>
                <button type="button" class="toggle-password" onclick="togglePassword('new_password', this)">
                    <i class="fas fa-eye"></i>
                </button>
                @error('new_password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar nueva contraseña -->
            <div class="form-group">
                <label for="new_password_confirmation">Confirmar nueva contraseña:</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                <button type="button" class="toggle-password" onclick="togglePassword('new_password_confirmation', this)">
                    <i class="fas fa-eye"></i>
                </button>
                @error('new_password_confirmation')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                <p id="password-error" class="error-message" style="display: none;">Las contraseñas no coinciden.</p>
            </div>
            <div class="buttons-container">
                <button type="submit" class="btn save-btn">Actualizar Contraseña</button>
                <a href="{{ route('perfil.edit') }}" class="btn cancel-btn">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(id, btn) {
                let input = document.getElementById(id);
                let icon = btn.querySelector("i");
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    input.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            }


        function validarContrasenas() {
            let newPassword = document.getElementById("new_password").value;
            let confirmPassword = document.getElementById("new_password_confirmation").value;
            let errorMessage = document.getElementById("password-error");

            if (newPassword !== confirmPassword) {
                errorMessage.style.display = "block";
                return false; // Evita el envío del formulario
            } else {
                errorMessage.style.display = "none";
                return true; // Permite el envío del formulario
            }
        }
    </script>
</body>
</html>
