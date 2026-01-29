# 🚀 Prueba Técnica: Fullstack E-commerce (Laravel + Vue.js)

Este proyecto es una aplicación de comercio electrónico desarrollada como parte de la evaluación técnica para Overskull. La solución integra un backend robusto en Laravel con un frontend dinámico y reactivo en Vue.js.

## 🛠️ Tecnologías Utilizadas

- Backend: Laravel (PHP)
- Frontend: Vue.js + Vite/Webpack
- Base de Datos: MySQL
- Gestión de Paquetes: Composer & NPM

## ⚙️ Instalación y Configuración

Sigue estos pasos para poner en marcha el entorno de desarrollo local.

### 1. Requisitos Previos
- PHP >= 8.x
- Composer
- Node.js & NPM
- Servidor MySQL (XAMPP, Laragon o Docker)

### 2. Configuración del Backend (Server)

```bash
# Acceder al directorio:
cd server
```

```bash
# Instalar dependencias:
composer install
```

```bash
# Configurar el entorno:
cp .env.example .env
php artisan key:generate
```

```bash
# Ejecutar migraciones:
php artisan migrate
```

```bash
# Iniciar servidor:
php artisan serve
```

### 3. Configuración del Frontend (Client)

```bash
# Acceder al directorio:
cd client
```

```bash
# Instalar dependencias:
npm install
```

```bash
# Iniciar modo desarrollo:
npm run dev
```

## 📁 Estructura del Proyecto

- /client: Interfaz de usuario construida con Vue.js, consumiendo los endpoints del backend.
- /server: API REST construida con Laravel, encargada de la lógica de negocio y persistencia.

### Nota: Asegúrate de que el servidor de Laravel esté corriendo en el puerto por defecto (http://127.0.0.1:8000) para que el frontend pueda comunicarse correctamente con la API.

### Puntos que faltan

- [ ] Agregarle Toast despues de cada accion
- [ ] Agregar seeders
- [ ] Mejorar el diseño