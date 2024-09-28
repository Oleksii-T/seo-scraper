<?php

namespace App\Services;

class CSVGenerator
{
    private $delimiter;
    private $enclosure;

    // Constructor to initialize delimiter and enclosure
    public function __construct($delimiter = ',', $enclosure = '"')
    {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }

    /**
     * Generates a CSV file from a 2D array.
     *
     * @param array  $data     The 2D array with data to be written to CSV.
     * @param string $filename The name of the file to save the CSV.
     * @return void
     */
    public function generate(array $data, array $headers, string $filename)
    {
        $filename = __DIR__ . "/../../outputs/$filename";

        echo $filename;

        // Open file for writing
        $file = fopen($filename, 'w');

        // Check if file is opened successfully
        if ($file === false) {
            throw new Exception("Unable to open file for writing.");
        }

        // add headers to data array
        $data = array_merge([$headers], $data);

        // Write each row of the array to the CSV file
        foreach ($data as $row) {
            fputcsv($file, $row, $this->delimiter, $this->enclosure);
        }

        // Close the file
        fclose($file);
    }
}
