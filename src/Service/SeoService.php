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

    public function getOpenGraphImage($text, $path) {
        $image = imagecreatefromjpeg($this->appKernel->getProjectDir()."/public/opengraph/og-light.jpg");
        $image_width = imagesx($image);
        $image_height = imagesy($image);

        $font = $this->appKernel->getProjectDir()."/public/opengraph/roboto-black.ttf";
        $angle = 0;
        $font_size = 32;

        $text_bound = $this->getTextBox($font_size, $text, $font);

        $lower_left_x =  $text_bound[0];
        $lower_right_x = $text_bound[2];
        $lower_right_y = $text_bound[3];
        $upper_right_y = $text_bound[5];
        $text_width =  $lower_right_x - $lower_left_x;
        $text_height = $lower_right_y - $upper_right_y;
        while ($text_width > $image_width) {
            $font_size --;
            $text_bound = $this->getTextBox($font_size, $text, $font);

            $lower_left_x =  $text_bound[0];
            $lower_right_x = $text_bound[2];
            $lower_right_y = $text_bound[3];
            $upper_right_y = $text_bound[5];
            $text_width =  $lower_right_x - $lower_left_x;
            $text_height = $lower_right_y - $upper_right_y;
        }


        $start_x_offset = ($image_width - $text_width) / 2;
        $start_y_offset = ($image_height - $text_height) - 20;

        $black = imagecolorallocate($image, 0, 0, 0);
        imagettftext($image, $font_size, $angle, $start_x_offset, $start_y_offset, $black, $font, $text);
        $kebab = $this->translatePathToKebabCase($path);
        imagejpeg($image, $this->appKernel->getProjectDir()."/public/opengraph/og-$kebab.jpg");
        imagedestroy($image);
    }

    private function getTextBox($font_size, $text, $font): array {

        return imageftbbox($font_size, 0, $font, $text);
    }

    public function translatePathToKebabCase($path) {
        if ($path == "/") {
            return "main";
        }
        return lcfirst(str_replace("/", '-', strtolower(mb_substr($path, 1, null))));
    }
}