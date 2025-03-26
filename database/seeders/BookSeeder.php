<?php

// database/seeders/BookSeeder.php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Database\Factories\BookFactory;

class BookSeeder extends Seeder
{
    public function run()
    {
        // The number of requests you want to make to Google Books API
        $bookCount = 10;

        $bookFactory = new BookFactory();

        for ($i = 0; $i < $bookCount; $i++) {
            $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
                'q' => 'fiction',  // You can modify this search term as needed
                'startIndex' => $i * 10,
                'maxResults' => 10,
            ]);

            if ($response->successful()) {
                $books = $response->json()['items'] ?? [];
                if (empty($books)) {
                    \Log::warning('No books found in API response', ['startIndex' => $i * 10]);
                    continue;
                }

                foreach ($books as $bookData) {
                    $bookInfo = $bookData['volumeInfo'];

                    \Log::info('Inserting Book', ['title' => $bookInfo['title'] ?? 'No Title']);

                    // Use the factory to create a book from the API data
                    $isbn = $this->getIsbn($bookInfo);
                    if (!Book::where('isbn', $isbn)->exists()) {
                        // Create book from API data using the factory
                        $bookFactory->createFromApiData($bookInfo);
                    }
                }
            } else {
                \Log::error('Failed to fetch books from Google Books API', ['status' => $response->status()]);
            }
        }
    }

    private function getIsbn($bookInfo)
    {
        foreach ($bookInfo['industryIdentifiers'] ?? [] as $identifier) {
            if ($identifier['type'] === 'ISBN_13') {
                return $identifier['identifier'];
            }
        }
        return 'Unknown ISBN';
    }
}


