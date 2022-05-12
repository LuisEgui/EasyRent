<?php

namespace easyrent\includes\persistance\entity;

/**
 * Class for advertisement
 */
class Advertisement {

    /**
     * @var string Unique ad identifier
     */
    private $a_id;

    /**
     * @var string Ad image banner's id
     */
    private $banner;

    /**
     * @var string Ad's release date. Format: YYYY-MM-dd hh:mm:ss
     */
    private $releaseDate;

    /**
     * @var string Ad's end date. Format: YYYY-MM-dd hh:mm:ss
     */
    private $endDate;

    /**
     * @var string Ad priority's id.
     */
    private $priority;

    /**
     * Creates an Advertisement object
     * @param string $a_id Unique ad identifier
     * @param string $banner Ad image banner's id
     * @param string $releaseDate Ad's release date. Format: YYYY-MM-dd hh:mm:ss
     * @param string $endDate Ad's end date. Format: YYYY-MM-dd hh:mm:ss
     * @param string $priority Ad priority's id.
     * @return void
     */
    public function __construct($a_id = null, $banner, $releaseDate, $endDate, $priority)
    {
        $this->a_id = $a_id;
        $this->banner = $banner;
        $this->releaseDate = $releaseDate;
        $this->endDate = $endDate;
        $this->priority = $priority;
    }

    /**
     * Returns ad's id.
     * @return string
     */
    public function getId(): ?string
    {
        return $this->a_id;
    }

    /**
     * Returns ad banner's id
     * @return string
     */
    public function getBanner(): ?string
    {
        return $this->banner;
    }

    /**
     * Returns ad's release date
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * Returuns ad's end date
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * Returns ad priority's id
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * Sets ad's id
     * @param string $a_id
     */
    public function setId(?string $a_id): void
    {
        $this->a_id = $a_id;
    }

    /**
     * Sets ad banner's id
     * @param string $banner
     */
    public function setBanner(?string $banner): void
    {
        $this->banner = $banner;
    }

    /**
     * Sets ad's release date
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * Sets ad's end date
     * @param string $endDate
     */
    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * Sets ad priority's id
     * @param string $priority
     */
    public function setPriority(string $priority): void
    {
        $this->priority = $priority;
    }

}
