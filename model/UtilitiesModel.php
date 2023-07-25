<?php

class UtilitiesModel 
{

    private $database;
    public function __construct($database) {
        $this->database = $database;
    }
    public function getCategories(){
        $sql = "SELECT * FROM Categories";
        $stmt = $this->database->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $success = $stmt->execute();
        if (!$success) {
            return null;
        }
    
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            // No se encontró ningún dato
            return null;
        }
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    
        $stmt->close();
    
        return $categories;
    }
    public function getCategorie($categoryId){
        $sql = "SELECT * FROM Categories WHERE CategoryID = ?";
        $stmt = $this->database->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("i", $categoryId);
        $success = $stmt->execute();
        if (!$success) {
            return null;
        }
    
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            // No se encontró ningún dato
            return null;
        }
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    
        $stmt->close();
    
        return $categories;
    }
    public function getLastCategorie(){
        $sql = "SELECT * FROM Categories  ORDER BY CategoryID DESC LIMIT 1";
        $stmt = $this->database->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $success = $stmt->execute();
        if (!$success) {
            return null;
        }
    
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            // No se encontró ningún dato
            return null;
        }
    
        // No es necesario usar un bucle while, ya que esperamos obtener un solo registro
        $row = $result->fetch_assoc();
        $stmt->close();
    
        return $row;
    }
    public function createCategory($categoryName, $categoryColor)
    {
        $sql = "INSERT INTO Categories (CategoryName, CategoryColor) VALUES (?, ?)";
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param("ss", $categoryName, $categoryColor);
        
        $success = $stmt->execute();
        
        $stmt->close();
        
        return $success;
    }
    
    public function updateCategory($categoryId, $categoryName, $categoryColor)
    {
        $sql = "UPDATE Categories SET CategoryName = ?, CategoryColor = ? WHERE CategoryID = ?";

        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param("ssi", $categoryName, $categoryColor, $categoryId);
        
        $success = $stmt->execute();
        
        $stmt->close();
        
        return $success;
    }
    
    public function deleteCategory($categoryId)
    {
        $sql = "DELETE FROM Categories WHERE CategoryID = ?";
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param("i", $categoryId);
        
        $success = $stmt->execute();
        
        $stmt->close();
        
        return $success;
    }
    public function getStates(){
        $sql = "SELECT * FROM States";
        $stmt = $this->database->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $success = $stmt->execute();
        if (!$success) {
            return null;
        }
    
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            // No se encontró ningún dato
            return null;
        }
        $states = [];
        while ($row = $result->fetch_assoc()) {
            $states[] = $row;
        }
    
        $stmt->close();
    
        return $states;
    }
}
