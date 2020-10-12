<?php
//fetch data from source csv
$file = fopen("source.csv","r");
$data = [];
while(! feof($file))
{
    $csv = fgetcsv($file, 0, ",", '"',"#");
    preg_match_all('/-?\\d+(?:\\.\\d+)?/m', $csv[1], $numbers);
    foreach ($numbers[0] as $number) {
        $data[intval($number)] = [$csv[0], $csv[2]];
    }
}
fclose($file);
//sorting the key
ksort($data);
$convertedCsv = [];
$pointer = []; //pointer to increment by the axis key
//build csv data amd ad prefix and sufix to the data
foreach ($data as $key => $ps) {
    array_push($convertedCsv, [$ps[0], $key, $ps[1], $pointer[$ps[0]]+=1]); 
}

print_r($convertedCsv);

//populate converted csv to the csv file
$fp = fopen('converted_number.csv', 'w');

foreach ($convertedCsv as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
