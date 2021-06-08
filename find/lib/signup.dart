import 'dart:convert';
import 'package:find/addDevice.dart';
import 'package:device_info/device_info.dart';
import 'package:find/LoginPage.dart';
import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:geolocator/geolocator.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import "globals.dart";
import "addDevice.dart";
import 'package:get/get.dart';

void main() {
  runApp(SignupPage());
}

class SignupPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: MyHomePage(),
    );
  }
}

class MyHomePage extends StatefulWidget {
  @override
  _MyHomePageState createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {

  String invalid="";

  changeText(String text){
    setState(() {
      invalid= text ;
    });
  }

  void _getCurrentLocation()async{
    print("getting current location");
    Position position = await Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
    lat = position.latitude;
    lon = position.longitude;
    // this lattitude and longitude is stored inside globals.dart file and then imported to this file to get access !
    print("lattitued : ${lat}, longitude : ${lon}");
  }

  final TextEditingController registerNameController = TextEditingController();
  final TextEditingController registerEmailController = TextEditingController();
  final TextEditingController registerPasswordController = TextEditingController();

  Future registerImei(String imei,String devicename,String login_id) async {
    print("registering device");
    final response = await http.post(apiUrl,
        body:{
          'type':'registerdevice',
          'loginid':login_id,
          'imei':imei.toString(),
          'devicename':devicename,
          'devicetype':'mobile',
          'lat':lat.toString(),
          'lon':lon.toString(),
        });

    print("Parcing imei request");
    var data = jsonDecode(response.body);

    if (data['value']=='done'){
      print('saving user email');

      var device_id = data['device_id'].toString();
      print("device id : ${device_id}");
      SharedPreferences user = await SharedPreferences.getInstance();

      user.setString('email', EMAIL);
      user.setString('loginid', login_id);
      user.setString('imei', imei);
      user.setString('device_id', device_id);

      Get.to(addDevice());

      // print("testing user prefference email = ${user.get('email')}");
      // user.clear();
      // print("testing user prefference email after cleaning = ${user.get('email')}");

      print('save datas and redirect to bluetooth activation');
    }
    else{
      print('some error occured !');
    }
  }

  Future regUser(String regName, String regEmail, String regPass,String imei, String devicename) async{
    print("registering User...");

    final response = await http.post(apiUrl,
        body:{
          'type':"register",
          'name':regName,
          'email':regEmail,
          'password':regPass
        });

    print('parcing Response');

    var data = jsonDecode(response.body);

    if (data['value']=='valid'){
      print('Registration Sucessfull');
      logid=data['login_id'];
      EMAIL=regName;
      registerImei(imei,devicename,logid);
    }
    else{
      print('registraction Failed.');
      changeText(data['value']);
      registerPasswordController.clear();
      registerEmailController.clear();
    }

  }

  @override
  Widget build(BuildContext context) {
    return new Scaffold(
      resizeToAvoidBottomInset: true,
      body: SingleChildScrollView(
        child:Column(
          // mainAxisAlignment: MainAxisAlignment.center,
          // crossAxisAlignment: CrossAxisAlignment.start,
          children: <Widget>[
            Container(
              child:Column(
                children: <Widget>[
                  Spacer(),
                  Container(
                      padding:EdgeInsets.fromLTRB(20.0, 0, 20.0, 0.0),
                      child:Text(
                        'Get Started',
                        textAlign: TextAlign.left,
                        style: TextStyle(
                          fontSize: 80.0, fontWeight:FontWeight.bold,
                          height: 1,
                          color:Colors.white70,
                        ),
                      )
                  ),
                  Spacer()
                ],
              ),
              width: MediaQuery.of(context).size.width,
              height: MediaQuery.of(context).size.height*0.40,
              decoration: BoxDecoration(
                borderRadius: BorderRadius.only(
                  bottomRight: Radius.circular(90.0),
                ),
                gradient: LinearGradient(
                    begin: Alignment.bottomLeft,
                    end: Alignment.topRight,
                    colors: [Color.fromARGB(255,0, 118, 214),Colors.blue]
                ),
                // color: Color.fromARGB(255,252, 140, 3),
                boxShadow: [
                  BoxShadow(color: Colors.white, spreadRadius: 0),
                ],
              ),
            ),

            Container(
              margin:EdgeInsets.only(top: 20.0) ,
              // padding:EdgeInsets.fromLTRB(245.0,75.0, 0.0, 50.0),
                child:Center(
                  child: Text(
                    '$invalid',
                    style: TextStyle(
                      fontSize: 15.0, fontWeight:FontWeight.bold,
                      color: Colors.red,
                    ),
                  ),
                )
            ),

            Container(
                padding:EdgeInsets.only(top:15.0,left:40.0,right:40.0),
                child:Column(
                  children: <Widget>[
                    TextField(
                      controller: registerNameController,
                      onTap: (){
                        changeText('');
                      },
                      decoration:InputDecoration(
                          labelText: 'Name',
                          labelStyle: TextStyle(
                            fontWeight: FontWeight.bold,
                            color: Colors.grey,
                          ),
                          focusedBorder: UnderlineInputBorder(
                            borderSide: BorderSide(color:Colors.blue),
                          )
                      ),
                    )
                  ],
                )
            ),

            Container(
                padding:EdgeInsets.only(top:15.0,left:40.0,right:40.0),
                child:Column(
                  children: <Widget>[
                    TextField(
                      controller: registerEmailController,
                      onTap: (){
                        changeText('');
                      },
                      decoration:InputDecoration(
                          labelText: 'Email',
                          labelStyle: TextStyle(
                            fontWeight: FontWeight.bold,
                            color: Colors.grey,
                          ),
                          focusedBorder: UnderlineInputBorder(
                            borderSide: BorderSide(color:Colors.blue),
                          )
                      ),
                    )
                  ],
                )
            ),

            Container(
                padding:EdgeInsets.only(top:10.0,left:40.0,right:40.0),
                child:Column(
                  children: <Widget>[
                    TextField(
                      controller: registerPasswordController,
                      onTap: (){
                        changeText('');
                      },
                      decoration:InputDecoration(
                          labelText: 'Password',
                          labelStyle: TextStyle(
                            fontWeight: FontWeight.bold,
                            color: Colors.grey,
                          ),
                          focusedBorder: UnderlineInputBorder(
                            borderSide: BorderSide(color:Colors.blue),
                          )
                      ),
                      obscureText: true,
                    )
                  ],
                )
            ),

            Container(
              margin: EdgeInsets.fromLTRB(0.0, 40.0, 0.0, 14.0),
              child:InkWell(
                child: Container(
                  height:50.5 ,
                  width:MediaQuery.of(context).size.width*0.85,
                  child:Center(
                    child: Text(
                      'SIGN UP',
                      style: TextStyle(
                        color: Colors.white,
                        fontWeight: FontWeight.bold,
                        fontSize: 17,
                      ),
                    ),
                  ),
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.all(Radius.circular(50.0),),
                    gradient: LinearGradient(
                        begin: Alignment.bottomLeft,
                        end: Alignment.topRight,
                        colors: [Color.fromARGB(255,105, 188, 255), Color.fromARGB(255,0, 118, 214)]
                    ),
                  ),
                ),
                // splashColor: Color.fromARGB(255,252, 180, 3),
                onTap: () async {
                  final String regName = registerNameController.text;
                  final String regEmail = registerEmailController.text;
                  final String regPass = registerPasswordController.text;

                  print("Registration Button Pressed");

                  String imei,devicename;

                  try {

                    DeviceInfoPlugin deviceInfo = DeviceInfoPlugin();
                    AndroidDeviceInfo androidInfo = await deviceInfo.androidInfo;
                    imei = androidInfo.id;
                    devicename = androidInfo.manufacturer.toUpperCase() +' '+ androidInfo.device.toUpperCase();

                  } on Exception {

                    DeviceInfoPlugin deviceInfo = DeviceInfoPlugin();
                    IosDeviceInfo iosInfo = await deviceInfo.iosInfo;
                    imei = iosInfo.identifierForVendor.toString();
                    devicename = iosInfo.name ;

                  }

                  print('Imei : ${imei}');
                  print('device Name :${devicename}');

                  if (regName.length > 0 && regEmail.length>0 && regPass.length>0){
                    print("Registraction button pressed with valid content !");
                    _getCurrentLocation();
                    await regUser(regName, regEmail,regPass,imei,devicename);
                  }
                  else{
                    changeText("Fields cannot be empty !");
                    print("Registraction button pressed without valid content");
                    print("Api call dismissed");
                  }

                },
              ),
            ),

            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: <Widget>[
                Text(
                  "Already a user ?",
                ),
                SizedBox(width:10),
                InkWell(
                    onTap: (){
                      Get.to(LoginPage());
                      // Navigator.of(context).pushNamed('/signin');
                    },
                    child: Text(
                      'Login',
                      style:TextStyle(
                        color: Colors.blue,
                        fontWeight: FontWeight.bold,
                      ),
                    )
                )
              ],
            )
          ],
        ),
      )
    );
  }
}
