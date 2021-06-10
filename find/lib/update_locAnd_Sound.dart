// import 'package:audioplayers/audioplayers.dart';
// import 'package:audioplayers/audio_cache.dart';
// import 'package:flutter_exoplayer/audio_notification.dart';
// import 'package:flutter_exoplayer/audioplayer.dart';



import 'dart:convert';

import 'package:find/LoginPage.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

import 'globals.dart';
import 'package:http/http.dart' as http;
import 'package:geolocator/geolocator.dart';


void alwaysRun() async{

      // AudioPlayer audioPlayer = AudioPlayer();
      // audioPlayer.play('assets/bel.wav');

  // AudioPlayer audioPlayer = AudioPlayer();
  // print("trying to play music");
  // int result = await audioPlayer.play('bel.wav',isLocal: true);

  while(WHILEVARIABLE) {

    Position position = await Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
    lat=position.latitude;
    lon=position.longitude;

    // final String apiUrl ="https://alansmathew.000webhostapp.com/php/find_api.php";
    final responsee = await http.post(apiUrl,
        body:{
          'type':"updateloc",
          'imei':IMEI,
          'login_id':LOGINID,
          'lon':lon.toString(),
          'lat':lat.toString(),
        });

    print("data sent");
    var responseedata = jsonDecode(responsee.body);
    print(responseedata['value']);
    final String alert=responseedata['value'];
    // print(alert);
    if(alert=='lost'){
      print('playsound failed because of audio player not compactable with shared prefference');

      // final player = AudioCache();
      // player.play('bel.wav');
    }
    else if(responseedata['value'] == null){
      WHILEVARIABLE = false ;
      print("User might have logged out !! ");
      SharedPreferences user = await SharedPreferences.getInstance();
      user.clear();
      Get.to(LoginPage());
    }
    else {
      print('Updating Device Location');
    }
    await new Future.delayed(const Duration(seconds : 10));
  }
}
