<!DOCTYPE html>
<html>
    <head>
        <title>UPSILON 2000 data managment</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>
    </body>
</html>
<?php 
    include_once "../base.php";
    $connection = new mysqli($db_host, $db_user, $db_user_password, $db_name);
    $number = 0;
    
    while($myfile = fopen("../dataToLoad/$number.TXT", "r")) {
        //header go away
        for ($i = 0; $i < 4; $i++) fgets($myfile);
        $iterator = 0;
        $size_of_the_array = 500;
        $some_data = "";
        $date = array_fill(0, $size_of_the_array, $some_data);; 
        $time = array_fill(0, $size_of_the_array, $some_data);; 
        $inputV = array_fill(0, $size_of_the_array, $some_data);; 
        $outputV = array_fill(0, $size_of_the_array, $some_data);; 
        $frequency = array_fill(0, $size_of_the_array, $some_data);; 
        $load = array_fill(0, $size_of_the_array, $some_data);; 
        $capacity = array_fill(0, $size_of_the_array, $some_data);;

        while ($line = fgets($myfile)) {
            $idLength = 0;
            for ($i = 0; $i < strlen($line); $i++) {
                $idLength += 1;
                if ($line[$i] == ")") break; 
            }
            for ($i = 1+$idLength; $i < 11+$idLength; $i++) $date[$iterator] .= $line[$i];
            for ($i = 12+$idLength; $i < 23+$idLength; $i++) $time[$iterator] .= $line[$i];
            $lineData = ""; $boolSecond = false;
            for ($i = 23+$idLength; $i < strlen($line); $i++) {
                if ($line[$i] == "V") {
                    if ($boolSecond) {
                        $outputV[$iterator] = $lineData;
                        $boolSecond = false;
                    } else {
                        $inputV[$iterator] = $lineData;
                        $boolSecond = true;
                    }
                } else if ($line[$i] == "%") {
                    if ($boolSecond) {
                        $capacity[$iterator] = $lineData;
                        $boolSecond = false;
                    } else {
                        $load[$iterator] = $lineData;
                        $boolSecond = true;
                    }
                } else if ($line[$i] == "H") {
                    $frequency[$iterator] = $lineData;
                } else {
                    if ($line[$i] == "V" || $line[$i] == " " || $line[$i] == "z") {
                        continue;
                    } else {
                        $lineData .= $line[$i];
                    }
                    continue;
                }
                $lineData = "";
            }

            // echo "Data: ".$date[$iterator]."<br>";
            // echo "Time: ".$time[$iterator]." - ".Date("H:i:s", strtotime($time[$iterator]))."<br>";
            // echo "Input V: ".$inputV[$iterator]."<br>";
            // echo "Output V: ".$outputV[$iterator]."<br>";
            // echo "Frequency Hz: ".$frequency[$iterator]."<br>";
            // echo "Load %: ".$load[$iterator]."<br>";
            // echo "Capacity %: ".$capacity[$iterator]."<br>";

            $time[$iterator] = Date("H:i:s", strtotime($time[$iterator]));
            $iterator += 1;
        }
        $good = array_fill(0, $size_of_the_array, false);

        $sql = "SELECT * FROM data WHERE dateOfRecord = ? AND timeOfRecord = ?";
        $stmt = $connection -> prepare($sql);

        for ($i = 0; $i < $size_of_the_array; $i++) {
            if ($date[$i] == "") {
                $good[$i] = false;
                continue;
            }
            $stmt -> bind_param("ss", $date[$i], $time[$i]);
            $stmt -> execute();
            $stmt -> store_result();
            $rows = $stmt -> num_rows;
            if ($rows == 0) $good[$i] = true;
            
        }
        $sql = "INSERT INTO data (dateOfRecord, timeOfRecord, input_v, output_v, frequency, load_percent, capacity) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt -> prepare($sql);
        for ($i = 0; $i < $size_of_the_array; $i++) {
            if (!$good[$i]) continue;
            $inputV[$i] =    floatval($inputV[$i]);
            $outputV[$i] =   floatval($outputV[$i]);
            $frequency[$i] = floatval($frequency[$i]);
            $load[$i] =      floatval($load[$i]);
            $capacity[$i] =  floatval($capacity[$i]);

            $stmt -> bind_param("ssddddd", $date[$i], $time[$i], $inputV[$i], $outputV[$i], $frequency[$i], $load[$i], $capacity[$i]);
            $stmt -> execute();
            
        }
        $stmt -> close();
        $number += 1;
    }
    mysqli_close($connection);
?>