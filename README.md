# Library Management System
## Project Overview
This project is a Library Management System designed to allow users to browse books, search for specific titles, borrow and return books and view their borrowed books. It includes pagination for browsing books and supports various book attributes and operations.

## Assumptions
1. Database is configured and connected properly with Laravel's default settings and tables books and borrowings exist with the appropriate schema.
2. Authentication is implemented using laravel/UI package and users must register and log in to borrow or return books.
3. Pagination for books is set to 10 books per page.
4. API routes are accessible at the specified endpoints and methods for borrowing, returning and searching books are function and handle requests properly.

Locate the SQL export file in the repository, named librarydb.sql.
