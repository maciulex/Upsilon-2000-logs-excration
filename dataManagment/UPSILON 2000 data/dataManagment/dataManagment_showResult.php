<?php 
    $allLogsAmount; $allDaysAmount; 
    $daysIndex = array(); $daysDate = array(); $daysNumOfLogs = array();
    $batteryGeneralData = array(); $mainsCurrentGeneralData = array();

    include_once "../base.php";
    $connection = new mysqli($db_host, $db_user, $db_user_password, $db_name);

    $sql = "SELECT id FROM data WHERE 1";
    $result = $connection -> query($sql);
    $allLogsAmount = $result -> num_rows;
    $sql = "SELECT dateOfRecord, COUNT(id) as 'Times' FROM `data` WHERE 1 GROUP BY dateOfRecord;";
    $result = $connection -> query($sql);
    $allDaysAmount = $result -> num_rows;
    $i = 0;
    while ($row = $result -> fetch_object()) {
        $daysIndex[] = $i;
        $daysDate[] = $row -> dateOfRecord;
        $daysNumOfLogs[] = $row -> Times;
        $i+=1;
    }

    $votageLimit = "> 70";
    $sql = "SELECT 
        CAST(AVG(input_v) as DECIMAL(10,2)) as 'avg_input', 
        CAST(AVG(output_v) as DECIMAL(10,2)) as 'avg_output',  
        CAST(MAX(input_v) as DECIMAL(10,2)) as 'max_input_v',  
        CAST(MAX(output_v) as DECIMAL(10,2)) as 'max_output_v',  
        CAST(MIN(input_v) as DECIMAL(10,2)) as 'min_input_v',  
        CAST(MIN(output_v) as DECIMAL(10,2)) as 'min_output_v',  
        CAST(AVG(frequency) as DECIMAL(10,2)) as 'avg_frequency',  
        CAST(MAX(frequency) as DECIMAL(10,2)) as 'max_frequency',  
        CAST(MIN(frequency) as DECIMAL(10,2)) as 'min_frequency',  
        CAST(AVG(capacity) as DECIMAL(10,2)) as 'avg_capacity',  
        CAST(MAX(capacity) as DECIMAL(10,2)) as 'max_capacity',  
        CAST(MIN(capacity) as DECIMAL(10,2)) as 'min_capacity',  
        CAST(AVG(load_percent) as DECIMAL(10,2)) as 'avg_load_percent',  
        CAST(MAX(load_percent) as DECIMAL(10,2)) as 'max_load_percent',  
        CAST(MIN(load_percent) as DECIMAL(10,2)) as 'min_load_percent' 
        FROM data WHERE input_v $votageLimit";
    $result = $connection -> query($sql);
    $result = $result -> fetch_object();
    $mainsCurrentGeneralData[] = $result -> avg_input;    //0
    $mainsCurrentGeneralData[] = $result -> avg_output;   //1
    $mainsCurrentGeneralData[] = $result -> max_input_v;  //2
    $mainsCurrentGeneralData[] = $result -> max_output_v; //3
    $mainsCurrentGeneralData[] = $result -> min_input_v;  //4
    $mainsCurrentGeneralData[] = $result -> min_output_v; //5
    $mainsCurrentGeneralData[] = $result -> avg_frequency;//6
    $mainsCurrentGeneralData[] = $result -> max_frequency;//7
    $mainsCurrentGeneralData[] = $result -> min_frequency;//8
    $mainsCurrentGeneralData[] = $result -> avg_capacity;//9
    $mainsCurrentGeneralData[] = $result -> max_capacity;//10
    $mainsCurrentGeneralData[] = $result -> min_capacity;//11
    $mainsCurrentGeneralData[] = $result -> avg_load_percent;//12
    $mainsCurrentGeneralData[] = $result -> max_load_percent;//13
    $mainsCurrentGeneralData[] = $result -> min_load_percent;//14

    $votageLimit = "< 70";
    $sql = "SELECT 
        CAST(AVG(input_v) as DECIMAL(10,2)) as 'avg_input', 
        CAST(AVG(output_v) as DECIMAL(10,2)) as 'avg_output',  
        CAST(MAX(input_v) as DECIMAL(10,2)) as 'max_input_v',  
        CAST(MAX(output_v) as DECIMAL(10,2)) as 'max_output_v',  
        CAST(MIN(input_v) as DECIMAL(10,2)) as 'min_input_v',  
        CAST(MIN(output_v) as DECIMAL(10,2)) as 'min_output_v',  
        CAST(AVG(frequency) as DECIMAL(10,2)) as 'avg_frequency',  
        CAST(MAX(frequency) as DECIMAL(10,2)) as 'max_frequency',  
        CAST(MIN(frequency) as DECIMAL(10,2)) as 'min_frequency',  
        CAST(AVG(capacity) as DECIMAL(10,2)) as 'avg_capacity',  
        CAST(MAX(capacity) as DECIMAL(10,2)) as 'max_capacity',  
        CAST(MIN(capacity) as DECIMAL(10,2)) as 'min_capacity',  
        CAST(AVG(load_percent) as DECIMAL(10,2)) as 'avg_load_percent',  
        CAST(MAX(load_percent) as DECIMAL(10,2)) as 'max_load_percent',  
        CAST(MIN(load_percent) as DECIMAL(10,2)) as 'min_load_percent' 
        FROM data WHERE input_v $votageLimit";
    $result = $connection -> query($sql);
    $result = $result -> fetch_object();
    $batteryGeneralData[] = $result -> avg_input;    //0
    $batteryGeneralData[] = $result -> avg_output;   //1
    $batteryGeneralData[] = $result -> max_input_v;  //2
    $batteryGeneralData[] = $result -> max_output_v; //3
    $batteryGeneralData[] = $result -> min_input_v;  //4
    $batteryGeneralData[] = $result -> min_output_v; //5
    $batteryGeneralData[] = $result -> avg_frequency;//6
    $batteryGeneralData[] = $result -> max_frequency;//7
    $batteryGeneralData[] = $result -> min_frequency;//8
    $batteryGeneralData[] = $result -> avg_capacity;//9
    $batteryGeneralData[] = $result -> max_capacity;//10
    $batteryGeneralData[] = $result -> min_capacity;//11
    $batteryGeneralData[] = $result -> avg_load_percent;//12
    $batteryGeneralData[] = $result -> max_load_percent;//13
    $batteryGeneralData[] = $result -> min_load_percent;//14
    
    unset($i);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>UPSILON 2000 data managment</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../styles/style_dataShowResult.css">
    </head>
    <body>
        <main>
            <h3>UPSILON 2000 LOGS Managment</h3>
            <hr>
            <table>
                <tbody>
                    <tr><th>Logs Amount:</th><td><?php echo $allLogsAmount;?></td></tr>
                    <tr><th>Days Amount:</th><td><?php echo $allDaysAmount;?></td></tr>
                </tbody>
            </table>
            <br><br>
            <h1>General Data</h1>
            <br><br>
            <h2>Mains Current</h2>
            <br>
            <table class="dateTable">
                <tbody>
                    <tr><th>Avarage input V:</th><td><?php echo $mainsCurrentGeneralData[0];?></td></tr>
                    <tr><th>Max input V:</th><td><?php echo $mainsCurrentGeneralData[2];?></td></tr>
                    <tr><th>Min input V:</th><td><?php echo $mainsCurrentGeneralData[4];?></td></tr>
                </tbody>
            </table>
            <table class="dateTable">
                <tbody>
                    <tr><th>Avarage output V:</th><td><?php echo $mainsCurrentGeneralData[1];?></td></tr>
                    <tr><th>Max output V:</th><td><?php echo $mainsCurrentGeneralData[3];?></td></tr>
                    <tr><th>Min output V:</th><td><?php echo $mainsCurrentGeneralData[5];?></td></tr>
                </tbody>
            </table>
            <table class="dateTable">
                <tbody>
                    <tr><th>Avarage frequency:</th><td><?php echo $mainsCurrentGeneralData[6];?></td></tr>
                    <tr><th>Max frequency:</th><td><?php echo $mainsCurrentGeneralData[7];?></td></tr>
                    <tr><th>Min frequency:</th><td><?php echo $mainsCurrentGeneralData[8];?></td></tr>
                </tbody>
            </table>
            <table class="dateTable">
                <tbody>
                    <tr><th>Avarage Capacity:</th><td><?php echo $mainsCurrentGeneralData[9];?></td></tr>
                    <tr><th>Max Capacity:</th><td><?php echo $mainsCurrentGeneralData[10];?></td></tr>
                    <tr><th>Min Capacity:</th><td><?php echo $mainsCurrentGeneralData[11];?></td></tr>
                </tbody>
            </table>
            <table class="dateTable">
                <tbody>
                    <tr><th>Avarage Load:</th><td><?php echo $mainsCurrentGeneralData[12];?></td></tr>
                    <tr><th>Max Load:</th><td><?php echo $mainsCurrentGeneralData[13];?></td></tr>
                    <tr><th>Min Load:</th><td><?php echo $mainsCurrentGeneralData[14];?></td></tr>
                </tbody>
            </table>
            <br><br>
            <h2>Battery Current</h2>
            <br>
            <table class="dateTable">
                <tbody>
                    <tr><th>Avarage input V:</th><td><?php echo $batteryGeneralData[0];?></td></tr>
                    <tr><th>Max input V:</th><td><?php echo $batteryGeneralData[2];?></td></tr>
                    <tr><th>Min input V:</th><td><?php echo $batteryGeneralData[4];?></td></tr>
                </tbody>
            </table>
            <table class="dateTable">
                <tbody>
                    <tr><th>Avarage output V:</th><td><?php echo $batteryGeneralData[1];?></td></tr>
                    <tr><th>Max output V:</th><td><?php echo $batteryGeneralData[3];?></td></tr>
                    <tr><th>Min output V:</th><td><?php echo $batteryGeneralData[5];?></td></tr>
                </tbody>
            </table>
            <table class="dateTable">
                <tbody>
                    <tr><th>Avarage frequency:</th><td><?php echo $batteryGeneralData[6];?></td></tr>
                    <tr><th>Max frequency:</th><td><?php echo $batteryGeneralData[7];?></td></tr>
                    <tr><th>Min frequency:</th><td><?php echo $batteryGeneralData[8];?></td></tr>
                </tbody>
            </table>
            <table class="dateTable">
                <tbody>
                    <tr><th>Avarage Capacity:</th><td><?php echo $batteryGeneralData[9];?></td></tr>
                    <tr><th>Max Capacity:</th><td><?php echo $batteryGeneralData[10];?></td></tr>
                    <tr><th>Min Capacity:</th><td><?php echo $batteryGeneralData[11];?></td></tr>
                </tbody>
            </table>
            <table class="dateTable">
                <tbody>
                    <tr><th>Avarage Load:</th><td><?php echo $batteryGeneralData[12];?></td></tr>
                    <tr><th>Max Load:</th><td><?php echo $batteryGeneralData[13];?></td></tr>
                    <tr><th>Min Load:</th><td><?php echo $batteryGeneralData[14];?></td></tr>
                </tbody>
            </table>

            <br><br>
            <h1>Days Header/Days Menu</h1>
            <br>
            <table class="dateTable">
                <tbody>
                    <tr><th>Days Date:</th><td>Day Amount Of Logs</td></tr>
                    <?php
                        foreach ($daysIndex as $index) {
                            echo '<tr><th>'.$daysDate[$index].':</th><td>'.$daysNumOfLogs[$index].'</td></tr>';
                        }

                    ?>
                </tbody>
            </table>
        </main>
    </body>
</html>
<?php
    mysqli_close($connection);
?>