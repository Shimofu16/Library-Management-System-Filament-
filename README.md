## Library Management System

This is a Laravel-based library management system that allows users to manage books, borrowers, and borrowings. The system includes features such as:

* Book management: Add, edit, and delete books from the system.
* Borrower management: Add, edit, and delete borrowers from the system.
* Borrowing management: Create, edit, and delete borrowings from the system.
* Reports: Generate reports on books, borrowers, and borrowings.

The system is designed to be user-friendly and easy to use. It is also scalable and can be used to manage large libraries.

This system was developed as a personal project to learn more about Laravel and library management systems.

### How to install

1. Clone the repository:

```bash
git clone https://github.com/Shimofu16/Library-Management-System-Filament-.git
```

2. Install Composer dependencies:

```bash
composer install
```

3. Create a `.env` file and copy the contents of `.env.example` into it.

4. Update the database connection information in the `.env` file.

5. Create a database for the system.

6. Run the following command to migrate the database:

```bash
php artisan migrate
```

7. Run the following command to seed the database with some sample data:

```bash
php artisan db:seed
```

8. Start the development server:

```bash
php artisan serve
```

9. Visit `http://localhost:8000` in your web browser.

You should now be able to use the library management system.
