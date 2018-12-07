<?php
	public static function tokenizing($kalimat)
    {
        
        $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $kalimat);
        // Replaces multiple spasi with single spasi.
        $string = preg_replace('!\s+!', ' ', $string);
        // String to array
        $string_array = explode(" ", $string);
        return $string_array;
    }
?>