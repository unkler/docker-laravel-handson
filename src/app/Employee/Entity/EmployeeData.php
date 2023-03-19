<?php
namespace App\Employee\Entity;

final class EmployeeData
{
    public function __construct(
        private ?int $id,
        private int $contract_type_id,
        private string $last_name,
        private string $first_name,
        private string $last_name_kana,
        private string $first_name_kana,
        private int $post_code,
        private int $prefecture_id,
        private string $address,
        private string $phone_number,
        private string $email,
        private string $birthday
    ) {
        $this->id = $id;
        $this->contract_type_id = $contract_type_id;
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->last_name_kana = $last_name_kana;
        $this->first_name_kana = $first_name_kana;
        $this->post_code = $post_code;
        $this->prefecture_id = $prefecture_id;
        $this->address = $address;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->birthday = $birthday;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContractTypeId()
    {
        return $this->contract_type_id;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastNameKana()
    {
        return $this->last_name_kana;
    }

    public function getFirstNameKana()
    {
        return $this->first_name_kana;
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

    public function getBirthday()
    {
        return $this->birthday;
    }
}