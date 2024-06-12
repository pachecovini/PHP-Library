<?php

require_once './entities/BookClass.php';

use PHPUnit\Framework\TestCase;

class BookClassTest extends TestCase
{
    private $bookFilePath = 'book.json';

    protected function setUp(): void
    {
        // Clean the contents of the book.json file
        file_put_contents($this->bookFilePath, "[]");
    }

    public function testAddBook()
    {
        // Predefined data for testing
        $id = "123";
        $book_name = "Test Book";
        $book_isbn = "9876543210";
        $book_publisher = "Test Publisher";
        $author_name = "Test Author";
        $author_id = "456";


        $book = new BookClass();
        $book->add($id, $book_name, $book_isbn, $book_publisher, $author_name, $author_id);

        // Read the contents of the test book file
        $jsonData = file_get_contents($this->bookFilePath);
        $books = json_decode($jsonData, true);

        // Assert that the book was added correctly
        $this->assertCount(1, $books);

        $expectedBook = [
            "book_id" => $id,
            "book_name" => $book_name,
            "isbn" => $book_isbn,
            "publisher" => $book_publisher
        ];

        // Check if the added book matches the expected book entry
        $this->assertEquals($expectedBook, $books[0]);
    }

    public function testSearchBook()
    {
        $id = "123";
        $book_name = "Test Book";
        $book_isbn = "9876543210";
        $book_publisher = "Test Publisher";
        $author_name = "Test Author";
        $author_id = "456";

        $book = new BookClass();

        // Add a book to the library
        $book->add($id, $book_name, $book_isbn, $book_publisher, $author_name, $author_id);

        // Search for the book by its ID
        $searchedBook = $book->searchBook($id);

        // Assert that the searched book is found and has correct details
        $this->assertNotEmpty($searchedBook);
        $this->assertEquals($id, $searchedBook['book_id']);
        $this->assertEquals($book_name, $searchedBook['book_name']);
        $this->assertEquals($book_isbn, $searchedBook['isbn']);
        $this->assertEquals($book_publisher, $searchedBook['publisher']);
    }
}

//To run the test use: .\\vendor\bin\phpunit .\BookClassTest.php