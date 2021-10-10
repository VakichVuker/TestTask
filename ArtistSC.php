<?php
class ArtistSC {
	protected $id_artist;
	protected $name;
	protected $pseudonym;
    protected $city;
    protected $followers;
    protected $last_up;

    public function __construct($name, $pseudonym, $city, $followers, $last_up = "", $id_artist=-1){
        $this->setId($id_artist);
        $this->setArtName($name);
        $this->setPseudonym($pseudonym);
        $this->setCity($city);
        $this->setFollowers($followers);
        $this->setLast_up($last_up);
    }

	 public function getId()
    {
        return $this->id_artist;
    }

    public function setId($id_artist)
    {
        $this->id_artist = $id_artist;
    }

    public function getArtName()
    {
        return $this->name;
    }

    public function setArtName($name)
    {
        $this->name = $name;
    }

        public function getPseudonym()
    {
        return $this->pseudonym;
    }

    public function setPseudonym($pseudonym)
    {
        $this->pseudonym = $pseudonym;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getFollowers()
    {
        return $this->followers;
    }

    public function setFollowers($followers)
    {
        $this->followers = $followers;
    }

    public function getLast_up()
    {
        return $this->last_up;
    }

    public function setLast_up($last_up)
    {
        $this->last_up = $last_up;
    }

}
?>