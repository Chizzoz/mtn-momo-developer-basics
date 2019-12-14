<?php


class RequestPayBody implements JsonSerializable
{

    private $amount;
    private $currency;
    private $externalId;
    private $payer = [];
    private $payerMessage;
    private $payeeNote;
//todo add payer members directly to constructor

    /**
     * RequestPayBody constructor.
     * @param $partyIdType string the id type of the payer can be MSISDN,EMAIL...
     * @param $partyId string the payer id which correspond the the $partyIdType
     * @param $amount
     * @param $currency
     * @param $externalId
     * @param $payerMessage
     * @param $payeeNote
     */
    public function __construct($partyIdType, $partyId, $amount, $currency, $externalId, $payerMessage, $payeeNote)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->externalId = $externalId;
        $this->payerMessage = $payerMessage;
        $this->payeeNote = $payeeNote;
        $this->payer = [
            "partyIdType" => $partyIdType,
            "partyId" => $partyId,
        ];
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param mixed $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
    }

    /**
     * @return array
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @param $partyIdType
     * @param $partyId
     */
    public function setPayer($partyIdType, $partyId)
    {
        $this->payer = [
            "partyIdType" => $partyIdType,
            "partyId" => $partyId,
        ];
    }

    /**
     * @return mixed
     */
    public function getPayerMessage()
    {
        return $this->payerMessage;
    }

    /**
     * @param mixed $payerMessage
     */
    public function setPayerMessage($payerMessage)
    {
        $this->payerMessage = $payerMessage;
    }

    /**
     * @return mixed
     */
    public function getPayeeNote()
    {
        return $this->payeeNote;
    }

    /**
     * @param mixed $payeeNote
     */
    public function setPayeeNote($payeeNote)
    {
        $this->payeeNote = $payeeNote;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
