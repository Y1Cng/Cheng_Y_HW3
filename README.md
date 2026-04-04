# Author & Book Manager

A Vue.js frontend connected to a Laravel REST API. Browse authors and books, view details, delete entries, and add new ones.

**Partners:** Yi Cheng / Yi Cheng

---

## Backend Setup

The backend is a Laravel application located in the `backend/` folder.

### Requirements
- PHP 8.2+
- Composer
- MySQL

### Steps

1. Navigate to the backend folder:
   ```bash
   cd backend
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy the example environment file and configure it:
   ```bash
   cp .env.example .env
   ```

4. Open `.env` and update the database credentials to match your environment:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

The API will be available at `http://127.0.0.1:8000/api`.

---

## Frontend Setup

The frontend is a plain HTML/CSS/JavaScript application using Vue.js via CDN. It is located in the `frontend/` folder and requires no build steps.

### Requirements
- A modern browser (Chrome, Firefox, Safari, Edge)
- The backend server must be running

### Steps

1. Open `frontend/index.html` directly in your browser, or serve it with any static file server.

2. Ensure the backend is running at `http://127.0.0.1:8000` (the default API URL configured in the app).

---

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/authors` | List all authors (supports `search`) |
| POST | `/api/authors` | Create a new author |
| GET | `/api/authors/{id}` | Get a single author with their books |
| PATCH | `/api/authors/{id}` | Update an author |
| DELETE | `/api/authors/{id}` | Delete an author |
| GET | `/api/books` | List all books (supports `search`, `author_id`, `min_price`) |
| POST | `/api/books` | Create a new book |
| GET | `/api/books/{id}` | Get a single book with its author |
| PATCH | `/api/books/{id}` | Update a book |
| DELETE | `/api/books/{id}` | Delete a book |
