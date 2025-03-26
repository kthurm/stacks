<?php


namespace Database\Factories;

use App\Models\Book;

class BookFactory
{
    /**
     * Create a book from Google Books API data.
     *
     * @param array $bookInfo
     * @return \App\Models\Book
     */
    public function createFromApiData(array $bookInfo)
    {
        return Book::create([
            'title' => $bookInfo['title'] ?? 'No Title',
            'author' => implode(', ', $bookInfo['authors'] ?? ['Unknown Author']),
            'description' => $bookInfo['description'] ?? 'No description available.',
          'cover_image' => $bookInfo['imageLinks']['large'] ??
                $bookInfo['imageLinks']['medium'] ??
                $bookInfo['imageLinks']['thumbnail'] ??
                'https://picsum.photos/id/237/200/300',
            'publisher' => $bookInfo['publisher'] ?? 'Unknown Publisher',
            'published_year' => substr($bookInfo['publishedDate'], 0, 4) ?? 'Unknown Year',
            'publication_date' => $this->formatDate($bookInfo['publishedDate']),
            'category' => implode(', ', $bookInfo['categories'] ?? ['Unknown Category']),
            'isbn' => $this->getIsbn($bookInfo),
            'page_count' => $bookInfo['pageCount'] ?? rand(100, 500),
            'summary' => $bookInfo['description'] ?? 'No summary available.',
            'rating' => rand(1, 5),
            'stock' => 1,
            'isCheckedOut' => false,
            'available' => true,
            'isFeatured' => (bool)rand(0, 1),
        ]);
    }

    /**
     * Format the date.
     *
     * @param string|null $date
     * @return string|null
     */
    private function formatDate($date)
    {
        return $date ? date('Y-m-d', strtotime($date)) : null;
    }

    /**
     * Get the ISBN from the API response.
     *
     * @param array $bookInfo
     * @return string|null
     */
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

