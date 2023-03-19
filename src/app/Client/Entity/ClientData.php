<?php
namespace App\Client\Entity;

final class ClientData
{
    public function __construct(
        private ?int $id,
        private string $name,
        private int $post_code,
        private int $prefecture_id,
        private string $address,
        private string $phone_number,
        private string $email,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->post_code = $post_code;
        $this->prefecture_id = $prefecture_id;
        $this->address = $address;
        $this->phone_number = $phone_number;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
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

    public function getEmail()
    {
        return $this->email;
    }
}