<h1>Stacks Library App</h1>

    <h2>Overview</h2>
    <p>The <strong>Stacks Library App</strong> is designed to help manage and keep track of books in a library. It allows both users and librarians to manage books, checkouts, and returns with ease.</p>

    <h2>Installation</h2>
    <p>Follow these steps to set up the <strong>Stacks Library App</strong> in your local development environment.</p>

    <h3>1. Clone the Repository</h3>
    <p>Start by cloning the repository to your local machine:</p>
    <pre><code>git clone https://github.com/kthurm/stack

cd stacks</code></pre>

    <h3>2. Install Dependencies</h3>
    <p>Next, install the required dependencies:</p>
    <pre><code>composer install

npm install</code></pre>

    <h3>3. Set Up the Environment File</h3>
    <p>Copy the <code>.env.example</code> file to <code>.env</code>:</p>
    <pre><code>cp .env.example .env</code></pre>
    <p>Open the <code>.env</code> file and set the following configurations:</p>
    <ul>
        <li><strong>Database connection:</strong> Set to <code>SQLite</code>.</li>
        <li><strong>APP_URL:</strong> Set the application URL (e.g., <code>http://stacks.test</code> if running locally).</li>
    </ul>

    <h3>4. Migrate the Database</h3>
    <p>Run the following command to migrate the database:</p>
    <pre><code>php artisan migrate</code></pre>

    <h3>5. Seed the Database</h3>
    <p>Seed the database with sample data:</p>
    <pre><code>php artisan db:seed</code></pre>

    <h3>6. Run the Program</h3>
    <p>Start the development server by running:</p>
    <pre><code>npm run dev</code></pre>
    <p>Alternatively, you can run the application using:</p>
    <pre><code>php artisan serve</code></pre>
    <p>Once the server is running, you can access the app via <code>http://localhost:8000</code> (or the URL you have set in <code>.env</code>).</p>

    <h2>Access the App</h2>
    <p>To access the app, you will need to register as a user.</p>

    <h2>Librarian Dashboard</h2>
    <p>The <strong>Librarian Dashboard</strong> provides the following features:</p>
    <ul>
        <li><strong>View Books:</strong> See a list of all books in the library, including both checked-out and available books.</li>
        <li><strong>Manage Users:</strong> View a list of users who have checked out books, including the book details and due dates.</li>
        <li><strong>Manage Books:</strong> Edit, delete, or add new books to the library's catalog.</li>
        <li><strong>Manage Checkouts and Returns:</strong> Handle book checkouts and returns directly from the dashboard.</li>
    </ul>
