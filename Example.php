<form action="/Example.php" method=" GET " name="dfform">
<input style="font-size: 22px;" type="text" name="link_parse" value="Ссылка" />
<input style="font-size: 22px;" type="submit" name="parse_button" value="Парсить" /></form>

<?php
	require_once 'database.php';
	require_once 'SoundCloudParser.php';
	require_once 'SongSC.php';
	require_once 'ArtistSC.php';
	require_once 'E:/OpenServer/vendor/autoload.php';

	$link_for_parse = $_GET['link_parse'];
	$database = new Database();
	$db = $database->getConnection();
	$parse = new SoundCloudParser($database);
	$parse->parse_artist($link_for_parse . '/tracks');
	$result_parse = $parse->getStatementParse();
	if ($result_parse == 1){
		echo "<br/> Новый исполнитель был добавлен <br/>";
	} elseif ($result_parse == 2) {
		echo "<br/> Данные Вашего исполнителя были обновлены <br/>";
	}

	//наследование класса ArtistSC для переопредления конструктора.
	class ArtistView extends ArtistSC {
		public function __construct(){}
	}
	class SongsView extends SongSC {
		public function __construct(){}
	}


	$statement = $db->query('SELECT * FROM artistsc');
	$all_artist = $statement->fetchAll(PDO::FETCH_CLASS, 'ArtistView');
	foreach($all_artist as $artistsc_obj) {
	    echo "<br/>№" . $artistsc_obj->getId() . '<br/>Псеводоним:' . $artistsc_obj->getPseudonym(). '<br/>Имя: ' . $artistsc_obj->getArtName(). '<br/>Город: ' . $artistsc_obj->getCity(). '<br/>Кол-во подписчиков: ' . $artistsc_obj->getFollowers(). '<br/>Данные обновлялись:' . $artistsc_obj->getLast_up() . '<br/>Треки исполнителя:';
	    $id_art = $artistsc_obj->getId();
	    $statement2 = $db->query("SELECT * FROM songsc WHERE sings_artist = $id_art");
	    $artist_songs = $statement2->fetchAll(PDO::FETCH_CLASS, 'SongsView');
	    foreach($artist_songs as $artist_song){
	    	$durat_track = new DateTime($artist_song->getDuration());
	    	echo "<br/>" . $artist_song->getSongName() . " - " . $durat_track->format('i:s');
	    }
	   echo '<br/><br/>';
	}

?>