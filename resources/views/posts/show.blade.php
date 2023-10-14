<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>募集詳細</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <x-app-layout>
        <x-slot name="header">
            <div class="custom_header">
                <p style="font-size: 20px;">相乗りマッチング！</p>
                <p>ainori</p>
            </div>
        </x-slot>
        <body>
            <div class="content">
                <div class='mypost' onclick="location.href='/posts/{{ $post->id }}'">
                    <div style="margin-left: 20px; color: blue; display: flex;">
                        <span>投稿者：</span>
                        <span><a href="/users/{{ $post->user->id }}">{{ $post->user->name }}</a></span>
                    </div>
                    <div class='origin' style="margin:0 20px; display: inline;">
                        <span style="width: 70px;">出発地：</span>
                        <span id="origin" style="flex: 1;">{{ $post->origin }}</span>
                    </div>
                    <div class='destination' style="margin:0 20px; display: flex;">
                        <span style="width: 70px;">目的地：</span>
                        <span id="destination" style="flex: 1;">{{ $post->destination }}</span>
                    </div>
                    <div class='people' style="margin:0 20px; display: flex;">
                        <span style="width: 85px;">最大人数：</span>
                        <span style="flex: 1;">{{ $post->people }}</span>
                    </div>
                    <div class='time_zone' style="margin:0 20px; display: flex;">
                        <span style="width: 70px;">時間帯：</span>
                        <span style="flex: 1;">{{ $post->time_zone->format('Y年n月j日H時i分') }}</span>
                    </div>
                    <div class='comment' style="margin:0 20px; display: flex;">
                        <div style="width: 70px;">コメント：</div>
                        <div style="flex: 1;">{{ $post->comment }}</div>
                    </div>
                </div>
            </div>
            <div class="footer" style="margin-left: 60px">
                <a class="btn btn-link btn-sm" href="/">戻る</a>
            </div>
            <div style="display: flex; margin-top: 20px;">
                <div style="width: 40%; margin-top: 2%;">
                    <div style="margin-bottom: 5%; text-align: center">
                        <a class="btn btn-info" href="/posts/chats/{{ $post->id }}" id="up">チャットへ参加する</a>
                    </div>
                    <table class="fares_table">
                        <tbody>
                            <tr class="border_bottom">
                                <td>運賃</td>
                                <td>
                                    <span id="fare1" style="margin-left: 20px; font-size: 1.2rem; font-weight: bold;"></span>
                                    <div>
                                        <span id="distance"></span>
                                        <span id="duration"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border_bottom">
                                <td>2人乗車</td>
                                <td>
                                    <span id="fare2" style="margin-left: 20px;"></span>
                                </td>
                            </tr>
                            <tr class="border_bottom">
                                <td>3人乗車</td>
                                <td>
                                    <span id="fare3" style="margin-left: 20px;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>4人乗車</td>
                                <td>
                                    <span id="fare4" style="margin-left: 20px;"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="margin:10% 10%;">
                        <form action="/reports/{{ $post->id }}" id="form_{{ $post->id }}" method="POST">
                            @csrf
                            <div class="report">
                                <h2>この投稿を通報する</h2>
                                <textarea name="post[report]" placeholder="通報理由" style="height:90px; width:100%;">{{ old('report') }}</textarea>
                                <p class="report__error" style="color:red">{{ $errors->first('report') }}</p>
                            </div>
                            <input type="submit" class="text-white bg-red-600 rounded px-3 py-1" value="通報する" onClick="return reportPost()">
                        </form>
                    </div>
                </div>
                <div id="map" style="height:600px; width:50%; margin-bottom: 5%;"></div>
            </div>
            
            <script>
                var directionsDisplay;
                var directionsService;
                var mapObj;
                
                function initMap() {
                    directionsDisplay = new google.maps.DirectionsRenderer();
                    directionsService = new google.maps.DirectionsService();
                    var map = document.getElementById("map");
                    var opt = {
                        zoom: 13,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                    };
                    mapObj = new google.maps.Map(map, opt);
                    directionsDisplay.setMap(mapObj);
                    google.maps.event.addListener(directionsDisplay,'directions_changed', function(){})
                    
                    calcRoute();
                }
                
                function calcRoute() {
                    var origin = document.getElementById("origin").textContent;
                    var destination = document.getElementById("destination").textContent;
                    
                    var request = {
                        origin: origin,
                        destination: destination,
                        travelMode: google.maps.DirectionsTravelMode.DRIVING,
                        unitSystem: google.maps.DirectionsUnitSystem.METRIC,
                    }
                    directionsService.route(request,function(response,status){
                        if (status == google.maps.DirectionsStatus.OK){
                            directionsDisplay.setDirections(response);
                            directionsDisplay.setMap(mapObj);
                        }
                    })
                    
                    var service = new google.maps.DistanceMatrixService();
                    service.getDistanceMatrix({
                        origins: [origin],
                        destinations: [destination],
                        travelMode: 'DRIVING',
                    }, callback);
                }
                
                function callback(response, status) {
                    if (status == 'OK') {
                        const distance = response.rows[0].elements[0].distance.text;
                        const duration = response.rows[0].elements[0].duration.text;
                        const distanceNumber = parseFloat(distance); // "3.0" を数値に変換
                        let fares = [4];
                        for(let i=0; i<4; i++){
                            fares[i] = distanceNumber * 460 / (i+1);
                            fares[i] = fares[i].toLocaleString();
                        }
                        
                        document.getElementById('distance').innerHTML = '（' + distance;
                        document.getElementById('duration').innerHTML = '/' + duration + '）';
                        document.getElementById('fare1').innerHTML = '約' + fares[0] + '円';
                        document.getElementById('fare2').innerHTML = '約' + fares[1] + '円/人';
                        document.getElementById('fare3').innerHTML = '約' + fares[2] + '円/人';
                        document.getElementById('fare4').innerHTML = '約' + fares[3] + '円/人';
                    } 
                    else {
                        alert('ルートを取得できませんでした。');
                    }
                }
                function reportPost() {
                    'use strict'
                    
                    if (confirm('この投稿を通報しますか？')) {
                        alert("送信しました");
                        return true;
                    }
                    else {
                        alert("キャンセルしました");
                        return false;
                    }
                }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyAkvO9JcQ6p8vigP2_KDJbRJVe_POgmJK4&callback=initMap&libraries=places" async defer></script>
        </body>
    </x-app-layout>
</html>