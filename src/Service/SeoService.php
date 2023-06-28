<?php

namespace App\Service;

use App\Entity\Seo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class SeoService
{
    private EntityManagerInterface $entityManager;
    private $appKernel;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, KernelInterface $appKernel)
    {
        $this->entityManager = $entityManager;
        $this->appKernel = $appKernel;
    }


    public function create(Seo $seo): void
    {
        $this->entityManager->persist($seo);
        $this->entityManager->flush();
    }

    public function delete(Seo $seo): void
    {
        $this->entityManager->remove($seo);
        $this->entityManager->flush();
    }

    public function findByPath(string $path): ?Seo
    {
        return $this->entityManager->getRepository(Seo::class)->findOneBy([
            'path' => $path
        ]);
    }

    public function getOpenGraphImage($text) {
        $image = imagecreatefromjpeg($this->appKernel->getProjectDir()."/public/opengraph/og-light.jpg");
        $image_width = imagesx($image);
        $image_height = imagesy($image);

        $font_size = 32;
        $angle = 0;
        $font = $this->appKernel->getProjectDir()."/public/opengraph/roboto-black.ttf";

        $text_bound = imageftbbox($font_size, 0, $font, $text);
        $lower_left_x =  $text_bound[0];
        $lower_left_y =  $text_bound[1];
        $lower_right_x = $text_bound[2];
        $lower_right_y = $text_bound[3];
        $upper_right_x = $text_bound[4];
        $upper_right_y = $text_bound[5];
        $upper_left_x =  $text_bound[6];
        $upper_left_y =  $text_bound[7];

        //Get Text Width and text height
        $text_width =  $lower_right_x - $lower_left_x; //or  $upper_right_x - $upper_left_x
        $text_height = $lower_right_y - $upper_right_y; //or  $lower_left_y - $upper_left_y

        //Get the starting position for centering
        $start_x_offset = ($image_width - $text_width) / 2;
        $start_y_offset = ($image_height - $text_height) - 20;

        $black = imagecolorallocate($image, 0, 0, 0);
        imagettftext($image, $font_size, $angle, $start_x_offset, $start_y_offset, $black, $font, $text);
        imagejpeg($image, $this->appKernel->getProjectDir()."/public/opengraph/og-light1.jpg");
        imagedestroy($image);
    }
}