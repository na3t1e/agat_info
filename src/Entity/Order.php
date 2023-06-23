<?php
namespace App\Entity;

class Order {
    private string $fio;
    private string $phone;
    private string $email;
    private string $serviceType;
    private string $serviceTitle;

    /**
     * @param string $fio
     * @param string $phone
     * @param string $email
     * @param string $serviceType
     * @param string $serviceTitle
     */
    public function __construct(string $fio, string $phone, string $email, string $serviceType, string $serviceTitle)
    {
        $this->fio = $fio;
        $this->phone = $phone;
        $this->email = $email;
        $this->serviceType = $serviceType;
        $this->serviceTitle = $serviceTitle;
    }

    /**
     * @return string
     */
    public function getServiceTitle(): string
    {
        return $this->serviceTitle;
    }


    /**
     * @return string
     */
    public function getFio(): string
    {
        return $this->fio;
    }

    /**
     * @param string $fio
     */
    public function setFio(string $fio): void
    {
        $this->fio = $fio;
    }


    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getServiceType(): string
    {
        return $this->serviceType;
    }

    /**
     * @param string $serviceType
     */
    public function setServiceType(string $serviceType): void
    {
        $this->serviceType = $serviceType;
    }

    public function __toString(): string
    {
        return
            "<b>ФИО: </b>" . $this->getFio() . "\n\n" .
            "<b>Телефонный номер: </b>" . $this->getPhone() . "\n\n" .
            "<b>Почтовый адрес: </b>" . $this->getEmail() . "\n\n" .
            "<b>Тип услуги: </b>" . "<code>" . $this->getServiceType() . "</code>" . "\n\n" .
            "<b>Раздел услуг: </b>" . "<code>" . $this->getServiceTitle() . "</code>" . "\n\n"
            ;
    }
}