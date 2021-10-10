<?php
class SongSC {
	protected $id_song;
	protected $song_name;
	protected $sings_artist;
	protected $duration;

	public function __construct($song_name,$sings_artist,$duration, $id_song=-1){
		$this->setId($id_song);
		$this->setSongName($song_name);
		$this->setArtist($sings_artist);
		$this->setDuration($duration);
	}

	 public function getId()
    {
        return $this->id_song;
    }

    public function setId($id_song)
    {
        $this->id_song = $id_song;
    }

	 public function getSongName()
    {
        return $this->song_name;
    }

    public function setSongName($song_name)
    {
        $this->song_name = $song_name;
    }

    public function getArtist()
    {
        return $this->sings_artist;
    }

    public function setArtist($sings_artist)
    {
        $this->sings_artist = $sings_artist;
    }

        public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
}
?>