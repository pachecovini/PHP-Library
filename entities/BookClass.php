<?php

require_once 'LibraryResource.php';
require_once 'Author.php';

class BookClass extends LibraryResource
{
    private $id;
    private $book_name;
    private $book_isbn;
    private $book_publisher;
    private $author;

    public function __construct($id = null, $book_name = null, $book_isbn = null, $book_publisher = null, $author = null)
    {
        $this->id = $id;
        $this->book_name = $book_name;
        $this->book_isbn = $book_isbn;
        $this->book_publisher = $book_publisher;
        $this->author = $author;
    }

    public function add($id, $book_name, $book_isbn, $book_publisher, $author_name, $author_id)
    {
        $this->id = $id;
        $this->book_name = $book_name;
        $this->book_isbn = $book_isbn;
        $this->book_publisher = $book_publisher;
        $this->author = new Author($author_name, $author_id);

        $book = [
            "book_id" => $this->id,
            "book_name" => $this->book_name,
            "isbn" => $this->book_isbn,
            "publisher" => $this->book_publisher,
        ];

        $json_data = file_get_contents("book.json");
        $books = json_decode($json_data, true);

        $books[] = $book;

        $json_data = json_encode($books, JSON_PRETTY_PRINT);

        file_put_contents("book.json", $json_data);

        echo "Book Added: " . $this->book_name . "\n";
    }

    public function deleteBook($id)
    {
        $json_data = file_get_contents("book.json");
        $books = json_decode($json_data, true);

        $found = false;

        foreach ($books as $key => $book) {
            if (strtolower($book['book_id']) == $id) {
                unset($books[$key]);
                $found = true;
                break;
            }
        }

        if ($found) {
            $json_data = json_encode(array_values($books), JSON_PRETTY_PRINT);
            file_put_contents("book.json", $json_data);
            echo "Book deleted! \n";
        } else {
            echo "Book not found! \n";
        }
    }

    public function bookList()
    {
        $file_path = "book.json";

        if (!file_exists($file_path)) {
            echo "No books added\n";
            return;
        }

        $json_data = file_get_contents($file_path);
        $books = json_decode($json_data, true);

        if (empty($books)) {
            echo "No books added\n";
        } else {
            foreach ($books as $book) {
                echo $this->getResourceInfo($book['book_name'], $book['book_id']) . "\n";
            }
        }
    }

    public function searchBook($search)
    {
        $is_true = false;
        $json_data = file_get_contents("book.json");
        $books = json_decode($json_data, true);
        $return_value = [];

        foreach ($books as $book) {
            if ($book["book_id"] == $search) {
                echo "Book name: " . $book['book_name'] . "\n";
                echo "Publisher: " . $book['publisher'] . "\n \n";
                $is_true = true;
                $return_value = $book;
            }
        }
        if (!$is_true) {
            echo "Book not found! \n";
        }

        return $return_value;
    }

    public function sortBook()
    {
        $json_data = file_get_contents("book.json");
        $books = json_decode($json_data, true);

        usort($books, function ($a, $b) {
            return strcasecmp($a["book_name"], $b["book_name"]);
        });

        foreach ($books as $book) {
            echo "Book name: " . $book['book_name'] . "\n";
        }
    }

    public function sortBookDecs()
    {
        $json_data = file_get_contents("book.json");
        $books = json_decode($json_data, true);

        usort($books, function ($a, $b) {
            return strcasecmp($b["book_name"], $a["book_name"]);
        });

        foreach ($books as $book) {
            echo "Book name: " . $book['book_name'] . "\n";
        }
    }

    public function getResourceInfo($book_name, $id)
    {
        return "Book name: " . $book_name . ", Book ID: " . $id;
    }
}
