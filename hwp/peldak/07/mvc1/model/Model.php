<?php

include_once "model/Book.php";

class Model
{
    public function getBookList()
    {
    // here goes some hardcoded values to simulate the database
        return [
            "Jungle Book" => new Book("Jungle Book", "R. Kipling", "A classic book."),
            "The Lord of The Rings" => new Book("The Lord of The Rings", "	J. R. R. Tolkien", "An epic high-fantasy novel."),
            "PHP for Dummies" => new Book("PHP for Dummies", "Some Smart Guy", "Guide for absolute beginners.")
        ];
    }

    public function getBook($title)
    {
        // we use the previous function to get all the books and then we return the requested one.
        // in a real life scenario this will be done through a db select command
        $allBooks = $this->getBookList();
        if(isset($allBooks[$title])) {
            return $allBooks[$title];
        }
        else {
            return null;
        }

    }

}
