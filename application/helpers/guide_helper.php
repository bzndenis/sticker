<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('parse_guide_content')) {
    function parse_guide_content($content) {
        // Pisahkan konten berdasarkan baris
        $lines = explode("\n", trim($content));
        $html = '';
        $current_section = null;
        $in_list = false;
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Skip baris kosong
            if (empty($line)) {
                if ($in_list) {
                    $html .= "</ul>\n";
                    $in_list = false;
                }
                continue;
            }
            
            // Parsing heading dan sections
            if (preg_match('/^#{1,6}\s+(.*)$/', $line, $matches)) {
                if ($in_list) {
                    $html .= "</ul>\n";
                    $in_list = false;
                }
                
                $level = substr_count($line, '#');
                $title = $matches[1];
                
                // Tambahkan kelas khusus untuk styling
                switch ($level) {
                    case 1:
                        $html .= "<h1 class='guide-title'>{$title}</h1>\n";
                        break;
                    case 2:
                        $html .= "<h2 class='guide-section'>{$title}</h2>\n";
                        break;
                    case 3:
                        $html .= "<h3 class='guide-subsection'>{$title}</h3>\n";
                        break;
                    default:
                        $html .= "<h{$level}>{$title}</h{$level}>\n";
                }
                continue;
            }
            
            // Parsing list items
            if (preg_match('/^(-|\d+\.)\s+(.*)$/', $line, $matches)) {
                if (!$in_list) {
                    $html .= "<ul class='guide-list'>\n";
                    $in_list = true;
                }
                
                $item = $matches[2];
                
                // Parse formatting dalam list item
                $item = parse_inline_formatting($item);
                
                $html .= "<li>{$item}</li>\n";
                continue;
            }
            
            // Parse paragraf biasa dengan formatting
            if ($in_list) {
                $html .= "</ul>\n";
                $in_list = false;
            }
            
            $line = parse_inline_formatting($line);
            $html .= "<p class='guide-paragraph'>{$line}</p>\n";
        }
        
        if ($in_list) {
            $html .= "</ul>\n";
        }
        
        return $html;
    }
}

if (!function_exists('parse_inline_formatting')) {
    function parse_inline_formatting($text) {
        // Bold dengan **text** atau __text__
        $text = preg_replace('/\*\*(.*?)\*\*|__(.*?)__/', '<strong>$1$2</strong>', $text);
        
        // Italic dengan *text* atau _text_
        $text = preg_replace('/\*(.*?)\*|_(.*?)_/', '<em>$1$2</em>', $text);
        
        // Code dengan `text`
        $text = preg_replace('/`(.*?)`/', '<code>$1</code>', $text);
        
        // Link dengan [text](url)
        $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $text);
        
        // Highlight dengan ==text==
        $text = preg_replace('/==(.*?)==/', '<mark>$1</mark>', $text);
        
        return $text;
    }
} 