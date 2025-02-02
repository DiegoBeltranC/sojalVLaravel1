<div x-data="{ showPassword: false }">
    <div class="body">
        <div id="loginForm">
            <form wire:submit.prevent="login" id="formsesion" class="formulario">
                <div class="container">
                    <a id="btnCancelar" >
                        <img src="{{ asset('images/cancelar.png') }}" width="6%" alt="Cancelar">
                    </a>
                </div>
                <h1 class="titulo">Hola, Bienvenido!</h1>
                <hr class="hr-login">

                <label class="label" for="gmail">Correo:</label><br>
                <input
                    type="email"
                    id="gmail"
                    wire:model.defer="correo"
                    placeholder="ejemplo@gmail.com"
                    required
                    aria-label="Correo electrónico"><br><br>

                <label class="label" for="password">Contraseña:</label><br>
                <!-- Usamos x-bind para cambiar el tipo de campo de password a text basado en el estado -->
                <input
                    :type="showPassword ? 'text' : 'password'"
                    id="password"
                    wire:model.defer="password"
                    placeholder="Contraseña"
                    required
                    aria-label="Contraseña">

                <label class="checkbox-container">
                    <!-- Usamos x-model para alternar el estado de showPassword -->
                    <input type="checkbox" x-model="showPassword" aria-label="Mostrar contraseña">
                    <span class="checkbox-custom"></span>
                    Mostrar Contraseña
                </label><br><br>

                <button type="submit" id="entrarSistema">Iniciar Sesión</button>
                <a class="RecoverPassword" href="/sojal/views/RecoverPassword/ViewRecoverPassword.html">Olvidé mi contraseña</a>
            </form>
        </div>
    </div>
</div>






