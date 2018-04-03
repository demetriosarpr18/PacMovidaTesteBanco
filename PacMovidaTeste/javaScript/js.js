/**
 * Created by Lucas on 10/27/2017.
 */
window.onload =  getLocation;

function getLocation()
{
    if(navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(displayLocation);
    }
    else
    {
        alert("Your browser doesn't have the geolocation");
    }
}

function displayLocation(position)
{
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    showMap(position.coords);
}

function showMap(coords)
{

    var LatLng = new google.maps.LatLng(coords.latitude, coords.longitude);

    var options = {
        center: LatLng,
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };


    var mapDivEsquerda = document.getElementById("map-esquerda");
    var mapDivDireita = document.getElementById("map-direita");

    var mapEsquerda = new google.maps.Map(mapDivEsquerda, options);
    var mapDireita = new google.maps.Map(mapDivDireita, options);
}
