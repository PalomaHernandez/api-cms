# API CMS – Slim 4 + PostgreSQL

Este proyecto implementa una API RESTful para la gestión de **usuarios**, **categorías** y **artículos**, siguiendo el patrón **ADR (Action–Domain–Responder)**.

## Requisitos 

- **PHP >= 8.3**
- **Composer**
- **PostgreSQL**

---

## Instalación

1. **Clonar el repositorio**
2. **Instalar dependencias** con composer install
3. **Crear y ajustar .env siguiendo .env.example**
4. **Crear base de datos con tablas:**
```sql
CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  password_hash TEXT NOT NULL,
  role TEXT NOT NULL CHECK (role IN ('admin','editor')),
  is_active BOOLEAN NOT NULL DEFAULT true
);

CREATE TABLE categories (
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL UNIQUE,
  description TEXT,
  is_active BOOLEAN NOT NULL DEFAULT true,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now(),
  updated_at TIMESTAMP WITH TIME ZONE DEFAULT now(),
);

CREATE TABLE articles (
  id SERIAL PRIMARY KEY,
  title TEXT NOT NULL,
  content TEXT NOT NULL,
  slug TEXT NOT NULL UNIQUE,
  status TEXT NOT NULL CHECK (status IN ('draft','published')),
  published_at TIMESTAMP WITH TIME ZONE,
  author_id INTEGER NOT NULL REFERENCES users(id) ON DELETE RESTRICT,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now(),
  updated_at TIMESTAMP WITH TIME ZONE DEFAULT now()
);

CREATE TABLE article_categories (
  article_id INTEGER REFERENCES articles(id) ON DELETE CASCADE,
  category_id INTEGER REFERENCES categories(id) ON DELETE RESTRICT,
  PRIMARY KEY(article_id, category_id)
);
```
5. **Levantar servidor local** con php -S localhost:8080 -t public
