<!DOCTYPE html>
<html>
<head>
    <style>
        #winnerwinner {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #winnerwinner td, #winnerwinner th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #winnerwinner tr:nth-child(even){background-color: #f2f2f2;}

        #winnerwinner tr:hover {background-color: #ddd;}

        #winnerwinner th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<?php
function array_to_table($matriz)
{
    echo "<table id='winnerwinner'>";
    echo "<th>image</th>";

    // Table header
    foreach ($matriz[0] as $clave=>$fila) {
        echo "<th>".$clave."</th>";
    }

    // Table body
    foreach ($matriz as $fila) {
        echo "<tr>";
        foreach ($fila as $elemento) {
            if (is_array($elemento)) {
                //echo $elemento['sourceURL'];
                if (isset($elemento['sourceURL'])) {
                    echo "<td><a href='" . $elemento['sourceURL'] . "' target='_blank'><img src='" . $elemento['imageUrl'] . "' alt='' border=3 height=100 width=100</img><a/></td>";
                }
                else {
                    $elemento['sourceURL'] = "example.com";
                    echo "<td><a href='" . $elemento['sourceURL'] . "' target='_blank'><img src='" . $elemento['imageUrl'] . "' alt='' border=3 height=100 width=100</img><a/></td>";

                }
                //var_dump($elemento['sourceURL']);
                echo "<td>" . $elemento['name'] . "</td>";
            } else {
                echo "<td>" . $elemento . "</td>";
            }
        }
        echo "</tr>";
    }
    echo "</table>";
}

$url = "https://api.app.winnerwinner.com/api/v1/Machines";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
    "Connection: keep-alive",
    "Accept: application/json, text/plain, */*",
    "User-Agent: WinnerWinner/2 CFNetwork/1325.0.1 Darwin/21.1.0",
    "Authorization: Bearer ",
    "request-origin: App",
    "Accept-Language: en-GB,en;q=0.9",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
//var_dump($resp);
if (strlen($resp) <= 0) {
    echo "No response from server";
} else {
    $jsonresp = json_decode($resp, true);
    //var_dump($jsonresp);
    array_to_table($jsonresp);
}
?>



