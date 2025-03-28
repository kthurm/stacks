Stacks Library App
Overview
The Stacks Library App is designed to help manage and keep track of books in a library.

Installation
Follow these steps to set up the Stacks Library App in your local development environment.

1. Clone the Repository
   Start by cloning the repository to your local machine:

Copy code
git clone https://github.com/kthurm/stacks
cd stacks

Install Dependencies
composer install
npm install

Set Up the Environment File
cp .env.example .env
Open the .env file and set the following configurations:

Database connection: SQLite

APP_URL: Set the application URL (usually http://stacks.test if running locally).

Migrate database
php artisan migrate

Seed Database
php artisan db:seed

Run Program
npm run dev

Either use Herb or run:
php artisan serve

To access site, register.

Librarian Dashboard
The Librarian Dashboard provides the following features:

View a list of all books in the library, including those checked out and available.

See a list of all users who have checked out books, along with the book details and due dates.

Manage books (edit, delete, add new books).

Manage checkouts and returns of books.
