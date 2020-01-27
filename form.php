<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Starter map</title>
        <meta name="viewport" content="initial-scale=1,maximumscale=1,user-scalable=no" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" />
        <style>
            html {
            height:100%; }
            #map {
            width: 100%;
            height: 600px; }
            aside {
            background-color:powderblue;
            float:left;
            border-radius:2px;
            font-family: "helvetica";
            height: 100%;
            width: 220px;
            position: relative;
            }
        </style>
    </head>
    <body>
        <aside>
            <label>Elegir un Estilo arquitectónico :
                <select id="estilo" name="estilo">
                    <option value="">Todos</option>
                    <option value="Barroco">Barroco</option>
                    <option value="Románico">Románico</option>
                    <option value="Plateresco">Plateresco</option>
                    <option value="Renacimiento">Renacimiento</option>
                </select>
            </label>
        </aside>
        <div id="map"></div>
        <script
        src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
        
        <script>
        <?php include 'getCiudadsalamanca.php'; ?>
        
        
        //Creamos el mapa de Leaflet
        var map = L.map('map').setView([40.96,-5.6661], 14);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

       
        var estilo= L.geoJson(geoJson).addTo(map);
        var markersLayer = new L.LayerGroup();
        markersLayer.addLayer(estilo);

        document.addEventListener('DOMContentLoaded',function() {
            document.querySelector('select[name="estilo"]').onchange=changeEventHandler;
        },false);
        function changeEventHandler(event) {
            markersLayer.clearLayers();
            if(!event.target.value) {
                var todos= L.geoJson(geoJson).addTo(map);
                markersLayer.addLayer(todos);
            }else {
                var p1 = L.geoJson(geoJson,{filter: function(feature) {return
                feature.properties.estilo == event.target.value}});
                markersLayer.addLayer(p1);
            }
        }
            markersLayer.addTo(map);
        </script>
    </body>
</html>


