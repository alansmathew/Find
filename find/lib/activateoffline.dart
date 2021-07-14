
import 'package:find/globals.dart';

import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;

void main() {
  runApp(activateoffline());
}


class activateoffline extends StatefulWidget {
  @override
  _activateofflineState createState() => _activateofflineState();
}

class _activateofflineState extends State<activateoffline> {

  Future setListning()async{
    print("Setting listening mode...");

    SharedPreferences user = await SharedPreferences.getInstance();
    var deviceID = user.getString('device_id');
    final response = await http.post(apiUrl,
        body:{
          'type':'setListningmode',
          'deviceID':deviceID,
        });

    print("Parcing imei request");
    print(response.body);
    // var data = jsonDecode(response.body);
  }

  @override
  void initState() {
    setListning();
    super.initState();
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Text("Get closer to anther device \n Loading...",textAlign: TextAlign.center,),
      ),
    );
  }
}

