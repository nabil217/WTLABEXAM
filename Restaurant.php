<?php

class Restaurant {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllRestaurants() {

        $query = "SELECT * FROM restaurants";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchRestaurants($q, $location, $area) {

        $query = "SELECT * FROM restaurants
                  WHERE name LIKE :q
                  AND location LIKE :location
                  AND area LIKE :area";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':q', "%$q%");
        $stmt->bindValue(':location', "%$location%");
        $stmt->bindValue(':area', "%$area%");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}