<?php

namespace App\Entity\Admin;

use Symfony\Component\HttpFoundation\File\File;

interface PictureTraitInterface
{
    public function getImage(): ?string;

    public function setImage(?string $image): void;

    public function getImageFile(): ?File;

    public function setImageFile(?File $imageFile = null): void;

    public function getUpdatedAt(): ?\DateTime;
}