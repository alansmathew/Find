import 'dart:convert';
import 'package:find/addDevice.dart';
import 'package:find/signup.dart';
import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart';
import 'globals.dart';
import 'package:http/http.dart' as http;
import 'package:get/get.dart';
import 'package:device_info/device_info.dart';
import 'package:shared_preferences/shared_preferences.dart';

void main() {
  runApp(LoginPage());
}

class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  String invalid="";

  changeText(String text){
    setState(() {
      invalid= text ;
    });
  }

  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

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

  Future checkUser(String email, String password,String imei,String devicename) async {
    final response = await http.post(apiUrl,
        body:{
          'type':"signin",
          'email':email,
          'password':password
        }
    );
    print("parcing results");

    var data = jsonDecode(response.body);

    if (data['value']=='valid'){
      print('login valid');
      logid=data['login_id'];
      EMAIL=email;
      registerImei(imei,devicename,logid);
    }
    else{
      print('invalid username or password');
      // emailController.text="";
      changeText('Invalid username or password !');
      passwordController.clear();
    }

  }

  void _getCurrentLocation()async{
    print("getting current location");
    Position position = await Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
    lat = position.latitude;
    lon = position.longitude;
    // this lattitude and longitude is stored inside globals.dart file and then imported to this file to get access !
    print("lattitued : ${lat}, longitude : ${lon}");
  }
  @override
  Widget build(BuildContext context) {
    return new WillPopScope(
      onWillPop: () async => false,
      child: new Scaffold(
          resizeToAvoidBottomInset: true,
          body: SingleChildScrollView(
            child: Column(
              // mainAxisAlignment: MainAxisAlignment.center,
              // crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                Container(
                  child:Column(
                    children: <Widget>[
                      Spacer(),
                      Container(
                          padding:EdgeInsets.fromLTRB(0.0, 0, 20.0, 0.0),
                          child:Text(
                            'Hello There',
                            textAlign: TextAlign.right,
                            style: TextStyle(
                              fontSize: 80.0, fontWeight:FontWeight.bold,
                              height: 1,
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
                      bottomLeft: Radius.circular(90.0),
                    ),
                    gradient: LinearGradient(
                        begin: Alignment.bottomLeft,
                        end: Alignment.topRight,
                        colors: [Color.fromARGB(255,252, 180, 3), Color.fromARGB(255,255, 111,0)]
                    ),
                    // color: Color.fromARGB(255,252, 140, 3),
                    boxShadow: [
                      BoxShadow(color: Colors.white, spreadRadius: 0),
                    ],
                  ),
                ),

                Container(
                    padding:EdgeInsets.only(top:55.0),
                    child:Center(
                      child: Text(
                        // 'hello world',
                        '$invalid',
                        style: TextStyle(
                          fontSize: 15.0, fontWeight:FontWeight.bold,
                          color: Colors.red,
                        ),
                      ),
                    )
                ),

                Container(
                  padding:EdgeInsets.only(top:05.0,left:20.0,right:20.0),
                  child:Column(
                    children: <Widget>[
                      TextField(
                          controller: emailController,
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
                              borderSide: BorderSide(color:Colors.green),
                            ),
                          ),
                          style:TextStyle(
                            color:Colors.black,
                            // fontSize: 20,
                          )
                      )
                    ],
                  ),
                ),

                Container(
                    padding:EdgeInsets.only(top:20.0,left:20.0,right:20.0,bottom: 40.0),
                    child:Column(
                      children: <Widget>[
                        TextField(
                          onTap: (){
                            changeText('');
                          },
                          controller: passwordController,
                          decoration:InputDecoration(
                              labelText: 'Password',
                              labelStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                color: Colors.grey,
                              ),

                              focusedBorder: UnderlineInputBorder(
                                borderSide: BorderSide(color:Colors.green),
                              )
                          ),
                          style:TextStyle(
                            color:Colors.black,
                            // fontSize: 20,
                          ),
                          obscureText: true,
                        )
                      ],
                    )
                ),

                FlatButton(
                  child: Container(
                    margin: EdgeInsets.fromLTRB(0.0, 0.0, 0.0, 0.0),
                    height:50.5 ,
                    width:MediaQuery.of(context).size.width*0.85,
                    child:Center(
                      child: Text(
                        'LOGIN',
                        style: TextStyle(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                          fontSize: 20,
                        ),
                      ),
                    ),
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.all(Radius.circular(50.0),),
                      gradient: LinearGradient(
                          begin: Alignment.bottomLeft,
                          end: Alignment.topRight,
                          colors: [Color.fromARGB(255,252, 180, 3), Color.fromARGB(255,255, 111,0)]
                      ),
                    ),
                  ),
                  splashColor: Color.fromARGB(255,252, 180, 3),
                  onPressed: () async {

                    print("login pressed");
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

                    final String email=emailController.text;
                    final String password=passwordController.text;
                    if (email.length > 0 && password.length>0){
                      print("login button pressed with valid content !");
                      _getCurrentLocation();
                      await checkUser(email, password,imei,devicename);
                    }
                    else{
                      changeText("Fields cannot be empty !");
                      print("login button pressed without valid content");
                      print("Api call dismissed");
                    }

                  },
                ),

                Container(
                  margin: EdgeInsets.only(top: 20.0),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: <Widget>[
                      Text(
                        "New to Find ?",
                      ),
                      SizedBox(width:10),
                      InkWell(
                          onTap: () async{
                            Get.to(SignupPage());
                            // Get.to(Mapv());

                          },
                          child: Text(
                            'Register',
                            style:TextStyle(
                              color: Color.fromARGB(255,252, 180, 3),
                              fontWeight: FontWeight.bold,
                            ),
                          )
                      )
                    ],
                  ),
                ),
              ],
            ),
          )
      )
    );
  }
}
