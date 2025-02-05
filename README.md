# SOJAL Laravel Project

## 🚀 Instalación y Configuración

Sigue estos pasos para configurar el proyecto en tu máquina local.

### 📌 Requisitos previos

Asegúrate de tener instalado:

- PHP (>= 8.0)

- Composer

- Node.js y npm

- Una cuenta en MongoDB Atlas

### 📥 Clonar el repositorio

```bash

git clone https://github.com/DiegoBeltranC/sojalVLaravel1.git

```

```bash

cd sojalVLaravel1

```

### 📦 Instalar dependencias

```bash

composer install

```

```bash

npm install

```

### 🔑 Configurar variables de entorno

*PEDIR EL .ENV A DIEGO*

```bash

php artisan key:generate

```

### ⚡ Configurar MongoDB Atlas

Edita el archivo `.env` y coloca los datos de tu conexión a MongoDB.

### ✅ Comandos adicionales

Iniciar servidor:

```bash

php artisan serve

```

Limpiar caché:

```bash

php artisan cache:clear

```

```bash

php artisan config:clear

```

```bash

php artisan view:clear

```

```bash

php artisan route:clear

```

