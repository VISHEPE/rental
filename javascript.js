
var mymap = L.map('mapid').setView([-1.2921562, 36.8450486], 16);


	L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 18,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
	}).addTo(mymap);
    coords = [[ -1.2904735, 36.8444237],[ -1.2925708, 36.8455714],[-1.2922064, 36.8471098],[ -1.2949048, 36.8433760],[ -1.2939078, 36.8458580],[-1.2924993, 36.8488624]];
 rent = ['850$','851$','852$','853$','854$','855$'];
 areas = ["60 m2","40 m2","90 m2","50 m2","50 m2","40 m2"];
 image = ["app/uploads/city.png","app/uploads/kenya.png","app/uploads/keny.png","app/uploads/city.png","app/uploads/kenya.png","app/uploads/city.png"];

rooms = [2,4,3,8,7,3];
    let l = coords.length;
    var appart1 = document.querySelector('#appart1');
    var appart2 = document.querySelector('#appart2');
    var appart3 = document.querySelector('#appart3');
    var appart4 = document.querySelector('#appart4');
    var appart5 = document.querySelector('#appart5');
    var appart6 = document.querySelector('#appart6');
    aparts = [appart1,appart2,appart3,appart4,appart5,appart6];
 for(let i=0;i < l ; ++i){

    var pop = L.popup({
        closeOnClick:true
    }

    ).setContent('<h4>Area:' + areas[i] +' Rooms: '+ rooms[i] +'</h4><img src=' + image[i] + ' style=" height:100px">');


    var marker = L.marker(coords[i]).addTo(mymap).bindPopup(pop);
    var toollip = L.tooltip({
        permanent:true
    }

    ).setContent(rent[i]);
    marker.bindTooltip(toollip);

    aparts[i].addEventListener("hover", ()=> {
  mymap.flyTo(coords[i], 16);
    })
 }