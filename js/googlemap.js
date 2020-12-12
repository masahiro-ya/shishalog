google.maps.event.addDomListener(window, 'load', function() {
    lat = $('.lat').val();
    lng = $('.lng').val();
    var mapdiv = document.getElementById('google-map'); //IDを入力
    var myOptions = {
        zoom: 19, //ズームのレベルを指定。数値が小さいほど、より広域に表示
        center: new google.maps.LatLng(lat,lng), //表示の基点となる緯度経度を入力
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scaleControl: true, //地図の縮尺（200mとかの目盛）。デフォルトは無効。
        scrollwheel: false //マウスホイールでの拡大・縮小を無効

    };
    var map = new google.maps.Map(mapdiv, myOptions);
    console.log(lat,lng);
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat,lng), //ピンの緯度経度を入力
            map: map,
            title: "皇居" //ピンにマウスカーソルを乗せたときに表示されるタイトルを入力
        });
});
