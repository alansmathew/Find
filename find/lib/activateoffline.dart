
import 'package:find/globals.dart';
import 'package:find/map.dart';

import 'package:flutter/material.dart';
import 'package:get/get.dart';
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

  void _goToMapView(){
    print('going to mapview');
    Get.to(Mapv());
  }

  @override
  void initState() {
    setListning();
    super.initState();
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body:Center(
          child: Container(
            child: Column(
              children: [
                Image.asset('images/paring.jpg',height:MediaQuery.of(context).size.height * 0.35),
                Spacer(),
                Spacer(),
                Container(
                  child: Container(
                    child: Column(
                      children: [
                        Spacer(),
                        Text("Get Closser..",style: TextStyle(color: Colors.white,fontSize: 25),),
                        Container(
                          width: MediaQuery.of(context).size.width*0.75,
                          child:Text("After seeing your device name on near by device, Click on proceed button to go to Map View",
                            style: TextStyle(color: Colors.white70,fontSize: 14),
                            textAlign: TextAlign.center,
                          ),
                          margin: const EdgeInsets.only(top: 7.0),
                        ),
                        Spacer(),
                        Container(
                          child: SizedBox(
                            width: 200,
                            height:40,
                            child:ElevatedButton(
                              child: Text(
                                "Proceed".toUpperCase(),
                                style: TextStyle(fontSize: 14,color: Colors.black),
                              ),
                              style: ButtonStyle(
                                  foregroundColor: MaterialStateProperty.all<Color>(Colors.white),
                                  backgroundColor: MaterialStateProperty.all<Color>(Colors.white),
                                  shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                                    RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(18.0),
                                      side: BorderSide(color: Colors.white54),
                                    ),
                                  )
                              ),
                              onPressed:_goToMapView,
                            ),
                          ),
                          margin: const EdgeInsets.only(bottom: 15.0),
                        ),
                        Spacer(),
                      ],
                    ),
                  ),
                  height:MediaQuery.of(context).size.height * 0.60,
                  width: MediaQuery.of(context).size.width*0.98,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.only(
                      topRight: Radius.circular(30.0),
                      topLeft: Radius.circular(30.0),
                    ),
                    color: Color.fromARGB(255,106,111,196),
                    boxShadow: [
                      BoxShadow(color: Colors.white, spreadRadius: 10),
                    ],
                  ),
                ),
                // Spacer()
              ],
            ),
            color:Colors.white,
          ),
        )
    );
    // return Scaffold(
    //   body: Center(
    //     child: Text("Get closer to anther device. After seeing your device name on nearby activating device, click Proceed",textAlign: TextAlign.center,),
    //   ),
    // );
  }
}

