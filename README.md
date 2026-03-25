# Esponsor Test

Desafío técnico desarrollado con Laravel, Vue 3 y Vite para la creación y edición de una página pública tipo builder.

## Tecnologías utilizadas

- PHP 8+
- Laravel 13
- Vue 3
- Vite
- TailwindCSS
- SQLite

## Requisitos previos

Antes de iniciar, asegúrate de tener instalado:

- PHP 8.2 o superior
- Composer
- Node.js y npm
- SQLite

## Instalación

### 1. Clonar el repositorio
git clone https://github.com/jaimelunalarcon/esponsor-test.git 
cd esponsor-test

##  Instalar dependencias de backend
composer install

## Instalar dependencias de frontend

npm install

## Configuración del entorno (Crear archivo .env)
cp .env.example .env

## Configurar variables de entorno (En el archivo .env, usa esta configuración para desarrollo local con SQLite:)
APP_NAME=Esponsor
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite

## Si no existe la base de datos, créala con:
touch database/database.sqlite

## Ejecutar migraciones
php artisan migrate

## Levantar el servidor de Laravel
php artisan serve

## Levantar Vite (frontend)
npm run dev

# Acceso local
http://127.0.0.1:8000

## Notas
- El proyecto utiliza una arquitectura basada en bloques (draft_payload / published_payload) para construir páginas dinámicas.
- El editor es schema-driven: cada tipo de bloque define sus campos y el formulario se renderiza dinámicamente.
- Para simplificar la instalación, se utiliza SQLite en desarrollo.

## Autor
Jaime Luna Alarcón