<?php

class MenuItem {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getRestaurantMenu($restaurant_id) {

        $query = "SELECT * FROM menu_items WHERE restaurant_id = :restaurant_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':restaurant_id', $restaurant_id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSingleMenuItem($id) {

        $query = "SELECT * FROM menu_items WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}