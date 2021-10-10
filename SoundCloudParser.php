<?php
class SoundCloudParser {
private $using_db;
protected $statement_parse=0;

public function __construct($db) {
    $this->using_db = $db;
}

public function getStatementParse(){
    return $this->statement_parse;
}

public function parse_artist($artist_link)
{
    $xpath = $this->getXPATHdoc($artist_link);

    $pseudonym_DOM = $xpath->evaluate('//header//h1/a[@itemprop="url"]');   //извлечение псевдонима исполнителя
    $additional_things_DOM = $xpath->evaluate('//header/p');    //извлечение имени и города
    $count_followers_DOM = $xpath->query('//meta[@property="soundcloud:follower_count"]/@content'); //извлечение количества подписчиков
    $songs_DOM = $xpath->evaluate('//section//article//h2/a[@itemprop="url"]'); //извлечение имен песен исполнителя
    $songs_duration_DOM = $xpath->query('*//meta[@itemprop="duration"]/@content');  //извлечение продолжительности песен

    //заведение данных парсинга артиста в переменные
    $pseudonym = $pseudonym_DOM[0]->textContent;
    $name = $additional_things_DOM[0]->textContent;
    $city = $additional_things_DOM[1]->textContent;
    $count_followers = $count_followers_DOM[0]->textContent;

    $artist_obj = new ArtistSC($name,$pseudonym,$city,$count_followers,date('Y-m-d H:i:s')); //создание экземпляра класса артиста
    $artist_obj->setId($this->using_db->getArtistId_fromDB($artist_obj));   //определение наличия исполнителя в бд

    //принятие решения обновления существующего артиста или запись нового
    if ($artist_obj->getID() == -1) {
        $artist_obj->setId($this->using_db->addArtist($artist_obj));//добавление нового артиста в бд и присвоение его id свойству класса
        foreach ($songs_DOM as $key => $song) {
            $dur_time = new DateInterval($songs_duration_DOM[$key]->textContent);   //приведение формата продолжительности треков к формату DateInterval()
            $new_song_obj = new SongSC($song->textContent, $artist_obj->getID(), $dur_time->format('%H:%I:%S')); //создание экземпляра класса SongSC на основе данных
            $this->using_db->addSong($new_song_obj);    //внос новой песни в бд
            $this->statement_parse = 1;     //изменение статуса
        }
    } else {
        $this->using_db->updateArtist($artist_obj); //обновление данных артиста
        $this->statement_parse = 2; //изменение статуса
    }
}

//функция, возвращающая DOM по ссылке исполнителя
protected function getXPATHdoc($artist_link){
    $httpClient = new \GuzzleHttp\Client(['verify' => false]);
    $response = $httpClient->get($artist_link . '/tracks');
    $htmlString = (string) $response->getBody();
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($htmlString);
    $xpath = new DOMXPath($doc);
    return($xpath);
}

}
?>