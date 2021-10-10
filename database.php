<?php
class DataBase {

    private $host = "localhost";
    private $db_name = "soundcloud";
    private $username = "root";
    private $password = "";
    public $conn;

    // получение соединения с базой данных
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch(PDOException $exception) {
            echo "Ошибка соединения: " . $exception->getMessage();
        }

        return $this->conn;
    }

    public function addArtist($artist_obj) {
        $insert_query = $this->conn->prepare('INSERT INTO artistsc(name, pseudonym, city, followers, last_up) VALUES( :name, :pseudonym, :city, :followers, :date_update)');
        $insert_query->execute([
            ':name' => $artist_obj->getArtName(),
            ':pseudonym' => $artist_obj->getPseudonym(),
            ':city' => $artist_obj->getCity(),
            ':followers' => $artist_obj->getFollowers(),
            ':date_update' => $artist_obj->getLast_up()
        ]);
        $new_created_id = $this->getArtistId_fromDB($artist_obj);
        return $new_created_id;
    }

    public function updateArtist($artist_obj) {
        $update_query = $this->conn->prepare('UPDATE artistsc SET followers=:followers, last_up=:date_update WHERE pseudonym=:pseudonym');
        $update_query->execute([
            ':followers' => $artist_obj->getFollowers(),
            ':date_update' => $artist_obj->getLast_up(),
            ':pseudonym' => $artist_obj->getPseudonym()
        ]);
    }

    public function getArtistId_fromDB($artist_obj){
        $selectId_query = $this->conn->prepare('SELECT id_artist FROM `artistsc` WHERE pseudonym = :pseudonym');
        $selectId_query->execute([
            ':pseudonym' => $artist_obj->getPseudonym()
        ]);
        $results = $selectId_query->fetch(PDO::FETCH_ASSOC);
        if (is_array($results)) {
            $result = $results['id_artist'];
        } else {
            $result = -1;
        }
        return $result;
    }

    public function addSong($song_obj) {
        $insert_query = $this->conn->prepare('INSERT INTO songsc(song_name, sings_artist, duration) VALUES(:song_name, :sings_artist, :duration)');
        $insert_query->execute([
            ':song_name' => $song_obj->getSongName(),
            ':sings_artist' => $song_obj->getArtist(),
            ':duration' => $song_obj->getDuration()
        ]);
    }

}
?>