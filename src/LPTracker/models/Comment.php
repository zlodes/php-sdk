<?php

namespace LPTracker\models;

use LPTracker\exceptions\LPTrackerSDKException;

class Comment extends Model
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var integer
     */
    protected $ownerId;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    public function __construct(array $commentData = [])
    {
        if (!empty($commentData['id'])) {
            $this->id = (int) $commentData['id'];
        }
        if (!empty($commentData['text'])) {
            $this->text = $commentData['text'];
        }
        if (!empty($commentData['author'])) {
            if ($commentData['author']['type'] === 'main') {
                $this->ownerId = 0;
            } else {
                $this->ownerId = (int) $commentData['author']['id'];
            }
        }
        if (!empty($commentData['created_at'])) {
            $this->setCreatedAt($commentData['created_at']);
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'text' => $this->getText(),
            'owner' => $this->getOwnerId(),
            'created_at' => $this->getCreatedAt()->format('d.m.Y H:i:s'),
        ];
    }

    /**
     * @return bool
     * @throws LPTrackerSDKException
     */
    public function validate()
    {
        if (empty($this->text)) {
            throw new LPTrackerSDKException('Text is required');
        }

        return true;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        if (!$createdAt instanceof \DateTime) {
            $createdAt = \DateTime::createFromFormat('d.m.Y H:i:s', $createdAt);
        }
        $this->createdAt = $createdAt;
        return $this;
    }
}
