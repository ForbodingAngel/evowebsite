<?php

function formatDate($inputDate, $outputDateFormat) {
    // Parse input date
    $dateTime = date_create_from_format('Y-m-d H:i:s', $inputDate);
    if (!$dateTime) {
        $dateTime = date_create_from_format('l F jS, Y', $inputDate);
    }
    if (!$dateTime) {
        $dateTime = date_create_from_format('m/d/Y', $inputDate);
    }
    
    if (!$dateTime) {
        // Handle other formats if needed
        return false;
    }
    
    // Output formatted date
    switch ($outputDateFormat) {
        case 'Y-m-d H:i:s':
            return $dateTime->format('Y-m-d H:i:s');
        case 'pretty':
            return $dateTime->format('l F jS, Y');
        default:
            return false;
    }
}

// Example usage:

/*
	$inputDate = "4/20/1930";
	$outputDateFormat1 = formatDate($inputDate, 'Y-m-d H:i:s');
	$outputDateFormat2 = formatDate($inputDate, 'pretty');

	echo "Output Date Format 1:" . $outputDateFormat1;
	echo "Output Date Format 2:" . $outputDateFormat2";
*/

?>