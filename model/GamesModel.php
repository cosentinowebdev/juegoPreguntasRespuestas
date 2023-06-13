<?php

class GamesModel {

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

public function initGame($userID) {
        // Verificar si hay un juego inconcluso
        $gameID = $this->getUnfinishedGameId($userID);

        if ($gameID !== null) {
            // Obtener los datos del juego inconcluso
            $gameData = $this->getGameById($gameID);

            if ($gameData === false) {
                // Error al obtener los datos del juego
                return false;
            }

            // Devolver los datos del juego inconcluso
            return $gameData;
        } else {
            // Crear una nueva partida
            $result = $this->createUserGame($userID);

            if ($result === false) {
                // Error al crear una nueva partida
                return false;
            }

            // Obtener los datos de la nueva partida
            $newGameID = $this->getUnfinishedGameId($userID);

            if ($newGameID === null) {
                // Error al obtener los datos de la nueva partida
                return false;
            }

            $newGameData = $this->getGameById($newGameID);

            if ($newGameData === false) {
                // Error al obtener los datos de la nueva partida
                return false;
            }

            // Devolver los datos de la nueva partida
            return $newGameData;
        }
    }

    public function getGameById($gameID) {
        // Generar una consulta SQL para obtener los datos de un juego por su ID
        $sql = "SELECT * FROM UserGames WHERE GameID = ?";

        // Preparar la consulta
        $stmt = $this->database->prepare($sql);

        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }

        // Vincular el parámetro de la consulta
        $stmt->bind_param("i", $gameID);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Obtener los datos del juego, si existe
        if ($result->num_rows > 0) {
            $gameData = $result->fetch_assoc();
        } else {
            $gameData = false;
        }

        // Cerrar la consulta
        $stmt->close();

        // Devolver los datos del juego o false si no se encontró
        return $gameData;
    }
    private function createUserGame($userID) {
        // Obtener la fecha y hora actual
        $timestamp = date('Y-m-d H:i:s');
        $result = 'incomplete';
        $numQuestions = 0;
        $score = 0;
        // Generar una consulta SQL para insertar el nuevo registro en la tabla UserGames
        $sql = "INSERT INTO UserGames (UserID, Score, Result, Timestamp, NumQuestions)
                VALUES (?, ?, ?, ?, ?)";

        // Preparar la consulta
        $stmt = $this->database->prepare($sql);

        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }

        // Vincular los parámetros de la consulta
        $stmt->bind_param("iissi", $userID, $score, $result, $timestamp, $numQuestions);

        // Ejecutar la consulta
        $result = $stmt->execute();

        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            return false;
        }

        // Cerrar la consulta y devolver el resultado
        $stmt->close();
        return true;
    }

    private function getUnfinishedGameId($userID) {
        // Generar una consulta SQL para obtener el ID de un juego inconcluso para el usuario especificado
        $sql = "SELECT GameID FROM UserGames WHERE UserID = ? AND Result = 'incomplete' LIMIT 1";

        // Preparar la consulta
        $stmt = $this->database->prepare($sql);

        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }

        // Vincular el parámetro de la consulta
        $stmt->bind_param("i", $userID);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Obtener el ID del juego inconcluso, si existe
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $gameID = $row['GameID'];
        } else {
            $gameID = null;
        }

        // Cerrar la consulta
        $stmt->close();

        // Devolver el ID del juego inconcluso o null si no hay juegos inconclusos
        return $gameID;
    }

    public function updateScoreAndNumQuestions($gameID, $scoreToAdd, $numQuestionsToAdd, $Result) {
        // Generar una consulta SQL para actualizar el Score y NumQuestions del juego especificado
        $sql = "UPDATE UserGames SET Score = Score + ?, NumQuestions = NumQuestions + ?, Result = + ? WHERE GameID = ?";

        // Preparar la consulta
        $stmt = $this->database->prepare($sql);

        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return null;
        }

        // Vincular los parámetros de la consulta
        $stmt->bind_param("iisi", $scoreToAdd, $numQuestionsToAdd,$Result, $gameID);

        // Ejecutar la consulta
        $result = $stmt->execute();

        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            return null;
        }

        // Cerrar la consulta
        $stmt->close();
        return $this->getGameById($gameID);
    }
}