<?php
    echo "Universitas Sebelas Maret<br>";
    Echo "Universitas Sebelas Maret<br>";
    ecHo "Universitas Sebelas Maret<br><br>";

    $prodi = "informatika";
    echo "Prodi saya $prodi <br>";
    echo "Prodi teman saya di " . $prodi . "<br>";

    $x = 100;
    $y = 92;

    function pertambahan(){
        $GLOBALS['a'] = $GLOBALS['x']+$GLOBALS['y'];
    }

    pertambahan();
    echo $a;
?>
