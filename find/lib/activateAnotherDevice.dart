import 'dart:convert';

import 'package:find/globals.dart';
import 'package:find/pages.dart';
import 'package:find/update_locAnd_Sound.dart';
import 'package:flutter/material.dart';
import 'package:flutter_blue/flutter_blue.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;

void main() {
  runApp(activateAnotherDevice());
}
class activateAnotherDevice extends StatefulWidget {
  @override
  _activateAnotherDeviceState createState() => _activateAnotherDeviceState();
}

class _activateAnotherDeviceState extends State<activateAnotherDevice> {

  var current_rssid = -100 ;
  var bluethoothId ;
  var hashname = '' ;
  var Textdata = 'Activating another device\n';

  getbluetoothdevices()  {

    print('getting bluetooth devices');

    FlutterBlue flutterBlue = FlutterBlue.instance;
    flutterBlue.startScan(timeout: Duration(seconds: 4));

// Listen to scan results
    flutterBlue.scanResults.listen((results) async {
      // do something with scan results
      for (ScanResult r in results) {
        setState(() {
          if (r.rssi > current_rssid ){
            print(r.rssi);
            current_rssid = r.rssi ;
            bluethoothId = r.device.id ;
            hashname = r.device.name ;
          }
        });
      }
    });

// Stop scanning
    flutterBlue.stopScan();
  }

  Future sentOfflinedata() async{
    print("hashname="+hashname);
    print("bluethothid"+bluethoothId.toString());
    final responseBluetoothParing = await http.post(apiUrl,
        body:{
          'type':'Paringoffline',
          'hashcode':hashname,
          'offlineID':bluethoothId.toString(),
          'lat':lat.toString(),
          'lon':lon.toString(),
        });
    print("Parcing imei request");
    print(responseBluetoothParing.body);
    var dat = jsonDecode(responseBluetoothParing.body);
    if (dat['value'] == 'true'){
      setState(() {
        Textdata = Textdata + dat['device'] ;
      });
    }
    else{
      setState(() {
        Textdata = 'No Nearby device found !!' ;
      });
    }
  }


  void getbluetoothdevicesone() async {
    getbluetoothdevices() ;
    await new Future.delayed(const Duration(seconds : 7));
    print(current_rssid);
    sentOfflinedata();
  }

@override
  void initState() {
  getbluetoothdevicesone();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Text( Textdata,textAlign: TextAlign.center,
        ),
      ),
    );
  }
}
