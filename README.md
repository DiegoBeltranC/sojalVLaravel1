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
cd sojalVLaravel1

# 📦 Instalar dependencias
composer install
npm install

# 🔑 Configurar variables de entorno
🔑 Configurar variables de entorno
PEDIR EL .ENV A DIEGO
php artisan key:generate

⚡ Configurar MongoDB Atlas
Edita el archivo .env y coloca los datos de tu conexión a MongoDB (.env)

✅ Comandos adicionales
Iniciar servidor:
php artisan serve

Limpiar caché:
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

