<?php
    $host= 'localhost';
    $port= '5432';
    $dbname = 'ciudadsalamanca';
    $user = 'postgres';
    $password = 'postgres';
    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
        if (!$conn) {
            echo "Not connected: " . pg_error();
            exit;
        } 
   
   //Consulta SELECT
    $sql = " SELECT row_to_json(fc)
    FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
        FROM (SELECT 'Feature' As type
            , ST_AsGeoJSON(lg.geom)::json As geometry
            , row_to_json(lp) As properties
            FROM public.monumentos As lg
                INNER JOIN (SELECT id, nombre, estilo, siglo FROM public.monumentos) As lp
                ON lg.id = lp.id ) As f ) As fc";
    $sql2 = " SELECT row_to_json(fc)
    FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
        FROM (SELECT 'Feature' As type
            , ST_AsGeoJSON(lg.geom)::json As geometry
            , row_to_json(lp) As properties
            FROM public.monumentos As lg
                INNER JOIN (SELECT id, nombre, estilo, siglo FROM public.monumentos where estilo ='Barroco') As lp
                ON lg.id = lp.id ) As f ) As fc";
   //Ejecución de la consulta 
    if (!$response = pg_query($conn, $sql)) {
        echo "Query failed";
        exit;
    }
    while ($row = pg_fetch_row($response)) {
        foreach ($row as $i => $attir) {
            echo "var geoJson=[" .$attir ."]";
        }
        echo ";";
    
    }
   
?>
