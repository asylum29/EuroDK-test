<?php

namespace App\Dto;

class VAT
{
    private $countryCode;

    private $vatNumber;

    private $requestDate;

    private $valid;

    private $name;

    private $address;

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     *
     * @return VAT
     */
    public function setCountryCode(string $countryCode): VAT
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    /**
     * @param string $vatNumber
     *
     * @return VAT
     */
    public function setVatNumber(string $vatNumber): VAT
    {
        $this->vatNumber = $vatNumber;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestDate()
    {
        return $this->requestDate;
    }

    /**
     * @param mixed $requestDate
     *
     * @return VAT
     */
    public function setRequestDate($requestDate): VAT
    {
        $this->requestDate = $requestDate;

        return $this;
    }

    /**
     * @return bool
     */
    public function getValid(): bool
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     *
     * @return VAT
     */
    public function setValid(bool $valid): VAT
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return VAT
     */
    public function setName(string $name): VAT
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return VAT
     */
    public function setAddress(string $address): VAT
    {
        $this->address = $address;

        return $this;
    }
}
