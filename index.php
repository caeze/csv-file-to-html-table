<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>fsi - Veranstaltungen SoSe 2020</title>
        <style type="text/css">
            table.gridtable {
                font-size:13px;
                color:#333333;
                border-width: 1px;
                border-color: #666666;
                border-collapse: collapse;
            }
            table.gridtable th {
                border-width: 1px;
                padding: 8px;
                border-style: solid;
                border-color: #666666;
                background-color: #dedede;
            }
            table.gridtable td {
                border-width: 1px;
                padding: 5px;
                margin: 0px;
                border-style: solid;
                border-color: #666666;
                background-color: #ffffff;
            }
            #search {
                height: 50px;
                width: 100%;
            }
        </style>
        <script>
            function searchTable() {
                var input, filter, found, table, tr, td, i, j;
                input = document.getElementById("search");
                filter = input.value.toUpperCase();
                table = document.getElementById("table");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td");
                    for (j = 0; j < td.length; j++) {
                        if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                        }
                    }
                    if (found || input == "" || i == 0) {
                        tr[i].style.display = "";
                        found = false;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        </script>
    </head>
    <body style="padding: 0px; margin: 0px; font-family: arial, sans-serif;">
        <div style="text-align: right; height: 80px; background-color: #000080; padding: 20px; margin: 0px; color: white; line-height: 80px; font-size: 40px;">
            Veranstaltungen SoSe 2020&nbsp;&nbsp;&nbsp;
        </div>
        <div style="position: absolute; top: 20px; left: 20px;">
            <img src="https://www.fsi.uni-tuebingen.de//img/logo.png">
        </div>
        <div style="padding: 40px; margin: 0px;">
            <input type="text" id="search" placeholder="&#128269;&nbsp;&nbsp;Suche" onkeyup="searchTable()"><br><br>
            <?php
                function read_csv_file_utf8($fileName) { 
                    if (($handle = fopen($fileName, "r")) === FALSE) {
                        echo "Error: Could not open file!";
                    }
                    $data = "";
                    while (!feof($handle)) {
                        $data .= fgets($handle, 50000);
                    }
                    $content = iconv("UTF-8", "UTF-8", $data);
                    fclose($handle);
                    $retArray = array();
                    $dataRows = str_getcsv($content, "\n");
                    foreach($dataRows as &$row) {
                        array_push($retArray, str_getcsv($row, ";"));
                    }
                    return $retArray;
                }
                $matches = glob('./*.csv');
                $data = read_csv_file_utf8($matches[0]);
                echo "<table id='table' class='gridtable' width='100%'>\n\n";
                for ($i = 0; $i < sizeof($data); $i++) {
                    // headers
                    if ($i == 1) {
                        echo "<tr width='100%'>";
                        for ($j = 0; $j < sizeof($data[$i]); $j++) {
                            echo "<th>" . htmlspecialchars($data[$i][$j]) . "</th>";
                        }
                        echo "</tr>";
                    }
                    // content
                    if ($i > 1) {
                        echo "<tr width='100%'>";
                        for ($j = 0; $j < sizeof($data[$i]); $j++) {
                            echo "<td>" . htmlspecialchars($data[$i][$j]) . "</td>";
                        }
                        echo "</tr>";
                    }
                }
                echo "</table>";
            ?>
        </div>
    </body>
</html>
