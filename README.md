# E-napló próbafeladat - Sági Dániel

Projekt Dokumentáció (Laravel API Backend & Vue 3 Frontend Tailwinddel)

Ez a projekt egy Laravel API backendet tartalmaz, valamint egy Vue 3 alapú frontend alkalmazást, amely Tailwind CSS-t használ a stílushoz. Az API lehetővé teszi osztályok, diákok és jegyek kezelését. A frontend Axios és Pinia használatával kommunikál az API-val.

## Telepítési Útmutató

### Backend Telepítése (Laravel)

A backend egy Laravel alkalmazás, amely PHP-t és MySQL-t igényel.

Szükséges eszközök:

- PHP >= 8.0
- Composer
- MySQL vagy MariaDB
- Node.js

### Lépések:

1. **Klónozd a projektet:**

```
git clone https://github.com/sagi-daniel/done-feladat.git
```

2. **Telepítsd a szükséges csomagokat:**

```
cd backend
composer install
```

Másold az `.env.example` fájlt `.env`-re:

```
cp .env.example .env
```

3. **Generálj egy új alkalmazás kulcsot:**

```
php artisan key:generate
```

4. **Adatbázis Beállítása:**

Nyisd meg a `.env` fájlt, és állítsd be a MySQL kapcsolatot:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

```

Az adatbázis migrációhoz és a Fejlesztői szerver elindításahoz futtasd az alábbi script parancsot.

```
npm run start
```

## 2. Frontend Telepítése (Vue 3, Vite, Tailwind CSS)

Szükséges eszközök:

- Node.js >= 16.x
- NPM vagy Yarn

## Lépések:

Frontend telepítése:

Lépj be a frontend mappába:

```
cd frontend
```

1. **Telepítsd a szükséges csomagokat:**

```
npm install
```

2. **Fejlesztői szerver indítása Vite segítségével:**

```
npm run dev
```

## Adatbázis Sémák

A projekt adatbázisa négy táblát tartalmaz: `classes`, `students`, `grades` és `subjects`.

### API Végpontok

Az API az alábbi végpontokat kínálja osztályok, diákok és jegyek kezelésére:

**Class Végpontok:**

- GET /api/classes: Összes osztály listázása.
- POST /api/classes: Új osztály létrehozása.
- GET /api/classes/{id}: Egy adott osztály részletei.
- PUT /api/classes/{id}: Egy adott osztály frissítése.
- DELETE /api/classes/{id}: Egy adott osztály törlése.

**Student Végpontok:**

- GET /api/students: Összes diák listázása.
- POST /api/students: Új diák hozzáadása.
- GET /api/students/{id}: Egy adott diák részletei.
- PUT /api/students/{id}: Egy adott diák frissítése.
- DELETE /api/students/{id}: Egy adott diák törlése.
- GET /api/students/{id}/grades: Egy adott diák érdemjegyeinek listázása.

**Grade Végpontok:**

- GET /api/grades: Összes jegy listázása.
- POST /api/grades: Új jegy hozzáadása.
- GET /api/grades/{id}: Egy adott jegy részletei.
- PUT /api/grades/{id}: Egy adott jegy frissítése.
- DELETE /api/grades/{id}: Egy adott jegy törlése.
