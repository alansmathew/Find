import 'package:flutter/material.dart';
import 'globals.dart';
import 'package:http/http.dart' as http;
import 'package:find/check_imei_model.dart';
import 'package:geolocator/geolocator.dart';
import 'package:audioplayers/audio_cache.dart';

void alwaysRun() async{
  var i = 1;
  while(i<10) {

    Position position = await Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
    lat=position.latitude;
    lon=position.longitude;


    final String apiUrl ="https://alansmathew.000webhostapp.com/php/find_api.php";
    final responsee = await http.post(apiUrl,
        body:{
          'type':"updateloc",
          'imei':'123456789101234',
          'login_id':'11',
          'lon':lon.toString(),
          'lat':lat.toString(),
        });
    print("data sent");
    final String alert=checkImeiFromJson(responsee.body).value.toString();
    // print(alert);
    if(alert=='lost'){
      print('playsound');
      final player = AudioCache();
      player.play('bel.wav');
    }
    else {
      print('done');
    }
    await new Future.delayed(const Duration(seconds : 10));
    // i++;
  }
}
