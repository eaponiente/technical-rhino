# Media CRUD

Created this simple application for my technical assesment in Rhino Group UK.

---

## Tech Stack Used

This project is built using the following technologies:

- **Laravel** - A robust PHP framework for building modern web applications.
- **Vue.js** - A progressive JavaScript framework for building user interfaces.
- **Tailwind CSS** - A utility-first CSS framework for rapidly building custom designs.
- **Inertia** - A library that allows you to create single-page applications using server-side rendering.

---

## Installation

Follow these steps to set up the project locally:

1. **Install PHP dependencies**:
   ```bash
   composer install
   
2. Generate the application key :
`php artisan key:generate`


3. Set up the .env file :
`cp .env.example .env`


4. Create the SQLite database file :
`touch database/database.sqlite`


5. Run migrations and seed the database :
`php artisan migrate:fresh --seed


6. Install Node.js dependencies :
`npm install`


7. Start the development server :
`composer run dev`

## Testing
To ensure the application is functioning correctly, run the test suite using the following command:
`php artisan test`

