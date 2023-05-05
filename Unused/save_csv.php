<?php
// Define the data to be stored in the CSV file
$data = array(
    array('John', 'Doe', 'johndoe@email.com'),
    array('Jane', 'Doe', 'janedoe@email.com'),
    array('Bob', 'Smith', 'bobsmith@email.com')
);

// Define the path and filename of the CSV file
$csvFilePath = 'data.csv';

// Open the CSV file in append mode
$fp = fopen($csvFilePath, 'a');

// Loop through the data and write each row to the CSV file
foreach ($data as $row) {
    fputcsv($fp, $row);
}

// Close the CSV file
fclose($fp);
