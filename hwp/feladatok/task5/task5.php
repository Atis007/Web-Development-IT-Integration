<?php
function extractDigits($word){
    $digits = preg_replace("/\D/", "", $word);

    if ( $digits === '') return null;

    return (int)$digits;
}
 $input = "Students got grades 8, 10, 9, 7, 5, 8, 6, 10, 11 and 4 in the exam.";

 $words = explode(" ", $input);

 $extracted = array_map("extractDigits", $words);

 $numbers = array_filter($extracted, function($number) {
     return !is_null($number);
 });

 $grades = array_fill_keys(range(5,10), 0);

 foreach ($numbers as $number) {
     if($number>=5 && $number<=10){
         $grades[$number]++;
     }
 }
echo "<pre>";
echo "Original text: $input\n";
echo "Extracted numbers: " . implode(", ", $numbers) . "\n";
echo "Grade statistics (5–10):\n";

foreach ($grades as $grade => $count) {
    echo "Grade $grade: $count times\n";
}
echo "<pre>";