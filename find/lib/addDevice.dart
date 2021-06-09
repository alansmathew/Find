import 'package:find/map.dart';
import 'package:get/get.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'globals.dart';


void main() {
  runApp(GetMaterialApp(home: addDevice()));
  // runApp(addDevice());
}

class addDevice extends StatefulWidget {
  @override
  _addDeviceState createState() => _addDeviceState();
}

class _addDeviceState extends State<addDevice> {
  void _goToMapView(){
    print('SKipped parring for now, going to mapview');
    Get.to(Mapv());
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
              Container(
                child: Container(
                  child: Column(
                    children: [
                      Spacer(),
                      Text("Offline Paring",style: TextStyle(color: Colors.white,fontSize: 25),),
                      Container(
                        width: MediaQuery.of(context).size.width*0.75,
                        child:Text("Inorder to activate offline finding feature across all platforms, get to an another device, go to profile > click on 'activate another device' button. Make sure both device are close enough and bluetooth enabled. You can also enable this feature by going into profile tab.",
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
                              "Start Paring".toUpperCase(),
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
                            onPressed: ()=>{
                              print('activate Paring ....')
                            },
                          ),
                        ),
                        margin: const EdgeInsets.only(bottom: 15.0),
                      ),
                      TextButton(
                        onPressed: _goToMapView,
                        child: Text("Skip for now",style: TextStyle(color: Colors.white54,fontSize: 14))),
                      Spacer(),
                      Spacer()
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
  }
}
