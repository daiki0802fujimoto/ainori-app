<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Posts</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <x-app-layout>
        <x-slot name="header">
            <div class="custom_header">
                相乗りマッチング！
            </div>
        </x-slot>
        <body>
            <div class="content">
                <div class="post">
                    <span style="margin-left: 20px; color: blue;">投稿者：<a href="/user/{{ $post->user_id }}">{{ $post->user->name }}</a></span>
                    <span id='origin' style="margin-left: 20px;">出発地：{{ $post->origin }}</span>
                    <span id='destination' style="margin-left: 20px;">目的地：{{ $post->destination }}</span>
                    <span class='people' style="margin-left: 20px;">最大人数：{{ $post->people }}</span>
                    <span class='time_zone' style="margin-left: 20px;">時間帯：{{ $post->time_zone->format('Y年n月j日H時i分') }}</span>
                    <div class='comment' style="margin-left: 20px;">コメント：{{ $post->comment }}</div>   
                </div>
            </div>
            <div class="footer" style="margin-left: 20px">
                <a class="btn btn-link btn-sm" href="/">戻る</a>
            </div>
            <div style="margin-left: 20px; text-align: center">
                <button id="number">{{ $post->people }}</button>
                <a class="btn btn-info" href="/posts/chats/{{ $post->id }}" id="up">チャットへ参加する</a>
            </div>
            <div style="display: flex; margin-top: 20px;">
                <div>
                    <span id="distance" style="margin-left: 20px;"></span>
                    <span id="duration" style="margin-left: 20px;"></span>
                    <div id="fare1" style="margin-left: 20px;"></div>
                    <div id="fare2" style="margin-left: 20px;"></div>
                    <div id="fare3" style="margin-left: 20px;"></div>
                    <div id="fare4" style="margin-left: 20px;"></div>
                </div>
                <div id="map" style="margin-left: 10%; height:700px; width:50%;"></div>
            </div>
            <div style="margin-left: 30%;">
                <form action="/reports/{{ $post->id }}" id="form_{{ $post->id }}" method="POST">
                    @csrf
                    <div class="report">
                        <h2>この投稿を通報する</h2>
                        <textarea name="post[report]" placeholder="通報理由" style="height:50px; width:50%;">{{ old('report') }}</textarea>
                        <p class="report__error" style="color:red">{{ $errors->first('report') }}</p>
                    </div>
                    <button class="btn btn-danger btn-sm" type=“button” onclick="reportPost({{ $post->id }})">通報する</button> 
                </form>
            </div>
            
            <script>
                var rendererOptions = {
                    draggable: true,
                    suppressMarkers: false, 
                    preserveViewport:false
                }
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
                    origin = origin.replace("出発地：", "");
                    destination = destination.replace("目的地：", "");
                    
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
                        
                        document.getElementById('distance').innerHTML = '距離: ' + distance;
                        document.getElementById('duration').innerHTML = '所要時間: ' + duration;
                        document.getElementById('fare1').innerHTML = '概算料金: ' + fares[0] + '円';
                        document.getElementById('fare2').innerHTML = '概算料金（2人乗車）: ' + fares[1] + '円';
                        document.getElementById('fare3').innerHTML = '概算料金（3人乗車）: ' + fares[2] + '円';
                        document.getElementById('fare4').innerHTML = '概算料金（4人乗車）: ' + fares[3] + '円';
                    } 
                    else {
                        alert('ルートを取得できませんでした。');
                    }
                }
                function reportPost(id) {
                    'use strict'
            
                    if (confirm('この投稿を通報しますか？')) {
                        document.getElementById(`form_${id}`).submit();
                    }
                }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyAkvO9JcQ6p8vigP2_KDJbRJVe_POgmJK4&callback=initMap&libraries=places" async defer></script>
            
            <script>
                const number = document.getElementById('number');
                const upbutton = document.getElementById('number');
                const post = @json($post);
                
                let count = 0;
                
                upbutton.addEventListener('click', () => {
                    if(post.people - count){
                        console.log(post)
                        count ++; 
                        number.innerHTML = post.people - count;
                    }
                });
            </script>
        </body>
    </x-app-layout>
</html>