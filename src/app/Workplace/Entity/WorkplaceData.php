<?php
namespace App\Workplace\Entity;

final class WorkplaceData
{
    public function __construct(
        private ?int $id,
        private int $client_id,
        private string $name,
        private int $post_code,
        private int $prefecture_id,
        private string $address,
        private string $phone_number,
    ) {
        $this->id = $id;
        $this->client_id = $client_id;
        $this->name = $name;
        $this->post_code = $post_code;
        $this->prefecture_id = $prefecture_id;
        $this->address = $address;
        $this->phone_number = $phone_number;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPostCode()
    {
        return $this->post_code;
    }

    public function getPrefectureId()
    {
        return $this->prefecture_id;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
}