# Stacks Library App

## Overview

The **Stacks Library App** is designed to help manage and keep track of books in a library. It allows both users and librarians to manage books, checkouts, and returns with ease.

## Installation

Follow these steps to set up the Stacks Library App in your local development environment.

### 1. Clone the Repository

Start by cloning the repository to your local machine:

```bash
git clone https://github.com/kthurm/stack
cd stacks
2. Install Dependencies
Next, install the required dependencies:

bash
Copy code
composer install
npm install
3. Set Up the Environment File
Copy the .env.example file to .env:

bash
Copy code
cp .env.example .env
Open the .env file and set the following configurations:

Database connection: Set to SQLite.

APP_URL: Set the application URL (e.g., http://stacks.test if running locally).

4. Migrate the Database
Run the following command to migrate the database:

bash
Copy code
php artisan migrate
5. Seed the Database
Seed the database with sample data:

bash
Copy code
php artisan db:seed
6. Run the Program
Start the development server by running:

bash
Copy code
npm run dev
Access the App
To access the app, you will need to register as a user.

Librarian Dashboard
The Librarian Dashboard provides the following features:

View Books: See a list of all books in the library, including both checked-out and available books.

Manage Users: View a list of users who have checked out books, including the book details and due dates.

Manage Books: Edit, delete, or add new books to the library's catalog.

Manage Checkouts and Returns: Handle book checkouts and returns directly from the dashboard.


```
