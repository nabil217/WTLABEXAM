<?php

class Review {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getReviewsByMenuItem($menu_item_id) {

        $query = "SELECT reviews.*, users.name
                  FROM reviews
                  JOIN users ON reviews.user_id = users.id
                  WHERE menu_item_id = :menu_item_id
                  ORDER BY reviews.id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':menu_item_id', $menu_item_id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addReview($menu_item_id, $user_id, $comment) {

        $query = "INSERT INTO reviews(menu_item_id,user_id,comment)
                  VALUES(:menu_item_id,:user_id,:comment)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':menu_item_id', $menu_item_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':comment', $comment);

        return $stmt->execute();
    }

    public function deleteReview($review_id, $user_id) {

        $query = "DELETE FROM reviews
                  WHERE id = :review_id
                  AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':review_id', $review_id);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }
}