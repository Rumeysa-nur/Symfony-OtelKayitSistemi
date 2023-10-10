<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="musteri")
 */
class ClientEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $isim;

    /**
     * @ORM\Column(type="text")
     */
    private $soyisim;

    /**
     * @ORM\Column(type="integer")
     */
    private $oda_no;

    /**
     * @ORM\Column(type="text")
     */
    private $ek_bilgiler;

    /**
     * @ORM\Column(type="integer")
     */
    private $kayit_tarihi;

    // Diğer özellikler ve getter/setter'lar

    public function getId()
    {
        return $this->id;
    }

    public function getIsim()
    {
        return $this->isim;
    }

    public function setIsim($isim)
    {
        $this->isim = $isim;
    }

    public function getSoyisim()
    {
        return $this->soyisim;
    }

    public function setSoyisim($soyisim)
    {
        $this->soyisim = $soyisim;
    }

    public function getOdaNo()
    {
        return $this->oda_no;
    }

    public function setOdaNo($oda_no)
    {
        $this->oda_no = $oda_no;
    }

    public function getEkBilgiler()
    {
        return $this->ek_bilgiler;
    }

    public function setEkBilgiler($ek_bilgiler)
    {
        $this->ek_bilgiler = $ek_bilgiler;
    }

    public function getKayitTarihi()
    {
        return $this->kayit_tarihi;
    }

    public function setKayitTarihi($kayit_tarihi)
    {
        $this->kayit_tarihi = $kayit_tarihi;
    }
}
