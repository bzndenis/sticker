<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImageHash {
    
    protected $size = 8;
    
    public function hash($image_path) {
        // Load gambar
        $image = $this->loadImage($image_path);
        if (!$image) {
            return FALSE;
        }
        
        // Resize ke ukuran kecil
        $resized = imagecreatetruecolor($this->size, $this->size);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $this->size, $this->size, imagesx($image), imagesy($image));
        
        // Convert ke grayscale
        $total = 0;
        $values = array();
        
        for ($y = 0; $y < $this->size; $y++) {
            for ($x = 0; $x < $this->size; $x++) {
                $rgb = imagecolorat($resized, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                
                $value = floor(($r + $g + $b) / 3);
                $values[] = $value;
                $total += $value;
            }
        }
        
        // Hitung rata-rata
        $avg = floor($total / count($values));
        
        // Generate hash
        $hash = '';
        foreach ($values as $value) {
            $hash .= ($value > $avg) ? '1' : '0';
        }
        
        // Cleanup
        imagedestroy($resized);
        imagedestroy($image);
        
        return $hash;
    }
    
    protected function loadImage($path) {
        $type = exif_imagetype($path);
        switch ($type) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($path);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($path);
            case IMAGETYPE_GIF:
                return imagecreatefromgif($path);
            default:
                return FALSE;
        }
    }
    
    public function distance($hash1, $hash2) {
        if (strlen($hash1) !== strlen($hash2)) {
            return -1;
        }
        
        $count = 0;
        $len = strlen($hash1);
        
        for ($i = 0; $i < $len; $i++) {
            if ($hash1[$i] !== $hash2[$i]) {
                $count++;
            }
        }
        
        return $count;
    }
} 