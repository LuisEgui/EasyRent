<?php

namespace easyrent\includes\persistance\repository;

use easyrent\includes\persistance\entity\Advertisement;

class MysqlAdvertisementRepository extends AbstractMysqlRepository implements Repository {

    public function __construct(MysqlConnector $connector)
    {
        parent::__construct($connector);
    }

    public function count(): int
    {
        $sql = 'select count(a_id) as num_ads from Advertisement';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($num_ads);
        $stmt->fetch();
        $stmt->close();
        return $num_ads;
    }

    public function findById($id) : ?Advertisement
    {
        $advertisement = null;

        if (!isset($id))
            return null;

        $sql = sprintf("select a_id, banner, releaseDate, endDate, priority from Advertisement where a_id = %d", $id);
        $result = $this->db->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            $obj = $result->fetch_object();
            $advertisement = new Advertisement($obj->a_id, $obj->banner, $obj->releaseDate, $obj->endDate, $obj->priority);
        }

        $result->close();

        return $advertisement;
    }

    public function findAll(): array
    {
        $ads = [];

        $sql = sprintf("select a_id, banner, releaseDate, endDate, priority from Advertisement");
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $ad = new Advertisement($row['a_id'], $row['banner'], $row['releaseDate'], $row['endDate'], $row['priority']);
            $ads[] = $ad;
        }
        return $ads;
    }

    public function deleteById($id): bool
    {
        // Check if the ad already exists
        if ($this->findById($id) !== null) {
            $sql = sprintf("delete from Advertisement where a_id = %d", $id);
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute();
            $stmt->close();

            if (!$result)
                error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

            return $result;
        }

        return false;
    }

    public function delete($ad): bool
    {
        // Check entity type and we check first if the ad already exists
        $importedAd = $this->findById($ad->getId());
        if ($ad instanceof Advertisement && ($importedAd !== null))
            return $this->deleteById($importedAd->getId());
        return false;
    }

    public function save($ad)
    {
        if ($ad instanceof Advertisement) {
            /**
             * If the ad already exists, we do an update.
             * We retrive the ad's id from the database.
             */
            $importedAd = $this->findById($ad->getId());
            if ($importedAd !== null) {
                $ad->setId($importedAd->getId());
                $sql = sprintf("update Advertisement set banner = '%d', releaseDate = '%s', endDate = '%s', priority = '%d' where a_id = %d",
                    $ad->getBanner(),
                    $this->db->getConnection()->real_escape_string($ad->getReleaseDate()),
                    $this->db->getConnection()->real_escape_string($ad->getEndDate()),
                    $ad->getPriority(),
                    $ad->getId()
                );

                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result)
                    return $ad;
                else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");
                return null;
                // If the ad is not in the database, we insert it.
            } else {
                if ($ad->getBanner() != null) {
                    $sql = sprintf("insert into Advertisement (banner, releaseDate, endDate, priority) " .
                        "values ('%d', '%s', '%s', '%d')",
                        $ad->getBanner(),
                        $this->db->getConnection()->real_escape_string($ad->getReleaseDate()),
                        $this->db->getConnection()->real_escape_string($ad->getEndDate()),
                        $ad->getPriority()
                    );
                } else {
                    $sql = sprintf("insert into Advertisement (releaseDate, endDate, priority) " .
                        "values ('%s', '%s', '%d')",
                        $this->db->getConnection()->real_escape_string($ad->getReleaseDate()),
                        $this->db->getConnection()->real_escape_string($ad->getEndDate()),
                        $ad->getPriority()
                    );
                }

                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute();
                $stmt->close();

                if ($result) {
                    // We get the associated id to this ad
                    $ad->setId($this->db->getConnection()->insert_id);
                    return $ad;
                } else
                    error_log("Database error: ({$this->db->getConnection()->errno}) {$this->db->getConnection()->error}");

                return null;
            }
        }
        return null;
    }

}
