/* Map By Jay 15/09/2015*/

var geocoder; // กำหนดตัวแปรสำหรับ เก็บ Geocoder Object ใช้แปลงชื่อสถานที่เป็นพิกัด
var map; // กำหนดตัวแปร map ไว้ด้านนอกฟังก์ชัน เพื่อให้สามารถเรียกใช้งาน จากส่วนอื่นได้
var Marker; // กำหนดตัวแปรสำหรับเก็บตัว marker
var GGM; // กำหนดตัวแปร GGM ไว้เก็บ google.maps Object จะได้เรียกใช้งานได้ง่ายขึ้น
var input_search; // กำหนดตัวแปร สำหรับ อ้างอิง input สำหรับพิมพ์ค้นหา
var infowindow;// กำหนดตัวแปร สำหรับใช้แสดง popup สถานที่ ที่ค้นหาเจอ
var autocomplete; // กำหนดตัวแปร สำหรับเก็บค่า การใช้งาน places Autocomplete
function initialize() { // ฟังก์ชันแสดงแผนที่
    GGM = new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM
    geocoder = new GGM.Geocoder(); // เก็บตัวแปร google.maps.Geocoder Object
    // กำหนดจุดเริ่มต้นของแผนที่
    var lat_lng = new GGM.LatLng($('#customer_lat').val(), $('#customer_lon').val());
    var maptypeid = GGM.MapTypeId.ROADMAP; // กำหนดรูปแบบแผนที่ที่แสดง

    // กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=map_canvas
    var Obj = $("#map_canvas")[0];

    // กำหนด Option ของแผนที่
    var Option = {
        zoom: 17, // กำหนดขนาดการ zoom
        center: lat_lng, // กำหนดจุดกึ่งกลาง จากตัวแปร lat_lng
        mapTypeId: maptypeid // กำหนดรูปแบบแผนที่ จากตัวแปร maptypeid
    };
    map = new GGM.Map(Obj, Option); // สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map

    input_search = $("#news_location")[0]; // เก็บตัวแปร dom object โดยใช้ jQuery

    // จัดตำแหน่ง input สำหรับการค้นหา ด้วย คำสั่งของ google map
    map.controls[GGM.ControlPosition.TOP_LEFT].push(input_search);

    // เรียกใช้งาน Autocomplete โดยส่งค่าจากข้อมูล input ชื่อ input_search
    autocomplete = new GGM.places.Autocomplete(input_search);
    autocomplete.bindTo('bounds', map);

    infowindow = new GGM.InfoWindow();// เก็บ InfoWindow object ไว้ในตัวแปร infowindow

    // เก็บ Marker object พร้อมกำหนดรูปแบบ ไว้ในตัวแปร Marker
    Marker = new GGM.Marker({
        position: lat_lng,
        map: map,
        anchorPoint: new GGM.Point(0, 0),
        draggable: true,
        title: "คลิกลากเพื่อหาตำแหน่งจุดที่ต้องการ!" // แสดง title เมื่อเอาเมาส์มาอยู่เหนือ  
    });

    // เรียกใช้คุณสมบัติ ระบุตำแหน่ง ของ html 5 ถ้ามี  
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var set_lat = position.coords.latitude; // เก็บค่าตำแหน่ง latitude  ปัจจุบัน
            var set_lon = position.coords.longitude;  // เก็บค่าตำแหน่ง  longitude ปัจจุบัน
            // สรัาง LatLng ตำแหน่ง สำหรับ google map
            var pos = new GGM.LatLng(position.coords.latitude, position.coords.longitude);
            $.post("", {// ส่งค่าตำแหน่งปัจจุบัน บันทึกลงฐานข้อมูล
                myPosition_lat: set_lat, // ส่งค่า latitude
                myPosition_lon: set_lon  // ส่งค่า longitude
            }, function () {
                map.panTo(pos); // เลื่อนแผนที่ไปตำแหน่งปัจจุบัน
                map.setCenter(pos);  // กำหนดจุดกลางของแผนที่เป็น ตำแหน่งปัจจุบัน	
                map.setZoom(17);
                Marker.setPosition(pos);
                $('#customer_lat').val(set_lat);
                $('#customer_lon').val(set_lon);
                $('#customer_lat').val(set_lat);
                $('#customer_lon').val(set_lon);
                geocoder.geocode({'latLng': Marker.getPosition()}, function (results, status) {
                    $('#news_location_default').val(results[0].formatted_address);
                });
            });
        }, function () {
            // คำสั่งทำงาน ถ้า ระบบระบุตำแหน่ง geolocation ผิดพลาด หรือไม่ทำงาน  
        });
    } else {
        // คำสั่งทำงาน ถ้า บราวเซอร์ ไม่สนับสนุน ระบุตำแหน่ง  
    }

    // เมื่อแผนที่มีการเปลี่ยนสถานที่ จากการค้นหา
    GGM.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();// เก็บค่าสถานที่จากการใช้งาน autocomplete ไว้ในตัวแปร place
        if (!place.geometry) {// ถ้าไม่มีข้อมูลสถานที่ 
            return;
        }

        // ถ้ามีข้อมูลสถานที่  และรูปแบบการแสดง  ให้แสดงในแผนที่
        map.setCenter(place.geometry.location);
        map.setZoom(17);  // แผนที่ขยายที่ขนาด 17 ถือว่าเหมาะสม

        // ปักหมุด (marker) ตำแหน่ง สถานที่ที่เลือก
        Marker.setPosition(place.geometry.location);
        $('#customer_lat').val(place.geometry.location.lat());
        $('#customer_lon').val(place.geometry.location.lng());

        geocoder.geocode({'latLng': Marker.getPosition()}, function (results, status) {
            $('#news_location').val(place.name + ',' + results[0].formatted_address);
        });

    });

    // กำหนด event ให้กับตัว marker เมื่อสิ้นสุดการลากตัว marker ให้ทำงานอะไร  
    GGM.event.addListener(Marker, 'dragend', function () {
        geocoder.geocode({'latLng': Marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#news_location').val(results[0].formatted_address);
                    $('#customer_lat').val(Marker.getPosition().lat());
                    $('#customer_lon').val(Marker.getPosition().lng());
                }
            }
        });
    });
}