<?php

include './entities/LibraryResource.php';
include './entities/Author.php';
include './entities/BookClass.php';
include './entities/OtherResource.php';

runApplication();

function Menu()
{
    echo "\nLibrary Management System\n";
    echo "1. Generate Book List\n";
    echo "2. Generate Resource List\n";
    echo "3. Add New Book\n";
    echo "4. Delete Book\n";
    echo "5. Add New Resource\n";
    echo "6. Delete Resource\n";
    echo "7. Search Book by ID\n";
    echo "8. Sort Books in Ascending Order\n";
    echo "9. Sort Books in Descending Order\n";
    echo "10. Exit\n";
    echo "Enter your choice: ";
}

function runApplication()
{
    while (true) {

        Menu();
        $input = readline();

        switch ($input) {
            case 1:
                $book = new BookClass();
                $book->BookList();
                break;

            case 2:
                $resource = new OtherResource();
                $resource->ResourceList();
                break;

            case 3:
                $id = readline("Book ID: ");
                $book_name = readline("Book name: ");
                $book_isbn = readline("ISBN: ");
                $book_publisher = readline("Publisher: ");
                $author_name = readline("Author Name: ");
                $author_id = readline("Author ID: ");

                $book = new BookClass();
                $book->Add($id, $book_name, $book_isbn,  $book_publisher, $author_name, $author_id);
                break;

            case 4:
                $id = readline("Enter Id to delete the book: ");
                $book = new BookClass();
                $book->deleteBook($id);
                break;
            case 5:
                $id = readline("Resource ID: ");
                $res_name = readline("Resource Name: ");
                $res_des = readline("Resource Description: ");
                $res_brand = readline("Resource Brand: ");

                $resource = new OtherResource();
                $resource->AddResource($id, $res_name, $res_des, $res_brand);
                break;

            case 6:
                $id = readline("Enter the Resource ID to delete: ");
                $resource = new OtherResource();
                $resource->DeleteResource($id);
                break;

            case 7:
                $search = readline("Insert the book Id: ");
                $book = new BookClass();
                $book->searchBook($search);
                break;

            case 8:
                $book = new BookClass();
                $book->SortBook();
                break;

            case 9:
                $book = new BookClass();
                $book->SortBookDecs();
                break;

            case 10:
                echo "Exiting...\n";
                exit;

            default:
                echo "Invalid choice! Please select a valid option.\n";
                break;
        }
    }
}
