import 'package:find/addDevice.dart';
import 'package:find/check_imei_model.dart';
import 'package:flutter/material.dart';
import 'package:find/user_model.dart';
import 'package:geolocator/geolocator.dart';
import 'package:http/http.dart' as http;
import 'package:imei_plugin/imei_plugin.dart';
import 'package:geolocator/geolocator.dart';
import 'update_locAnd_Sound.dart';
import 'map.dart';

import 'signup.dart';
import 'addDevice.dart';

import "globals.dart";


void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      routes: <String, WidgetBuilder> {
        '/signup' : (BuildContext context) => new SignupPage(),
        '/adddevice' :(BuildContext context)=> new addDevice(),
      },
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

  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  Future checImei(String imei,String login_id) async
  {
    final String apiUrl ="https://alansmathew.000webhostapp.com/php/find_api.php";
    final response = await http.post(apiUrl,
        body:{
          'type':"imeicheck",
          'imei':imei,
          'login_id':login_id
        });
    final String imeiresult=checkImeiFromJson(response.body).value.toString();
    logid=login_id;
    IMEI=imei;

    if(imeiresult=="not_in_use")
    {
      Returnval="not_in_use";
      Txt="By registering this device, you will be able to access all the services provided by FIND for free";
      print("not in use");
        Navigator.pushReplacement(context, MaterialPageRoute(builder: (context)=> addDevice()));
        void dispose() {}
      // Navigator.of(context).pushNamed('/adddevice');
    }
    else{
      print("already in use");
      alwaysRun();
      Navigator.push(context, MaterialPageRoute(builder: (context)=> Mapv()));
      void dispose() {}
      // details.imei_check="alre";
      // here goes stright to map view page------------------>
    }
  }

  Future checkUser(String email, String password,String imei) async
  {
    final String apiUrl ="https://alansmathew.000webhostapp.com/php/find_api.php";
    final response = await http.post(apiUrl,
        body:{
          'type':"signin",
          'email':email,
          'password':password
        }
        );

    final String val =userModelFromJson(response.body).value.toString();
    final String loginid =userModelFromJson(response.body).loginId;

    if (val=='valid'){
      print('login valid');
      if(imei==""){
        print("here goes the page to enter imei");
        logid=loginid;
        Txt="By entering IMEI address you can register this device. If already registered click cancel.";
        Navigator.of(context).pushNamed('/adddevice');
        void dispose() {}
          // here goes the next page
      }
      else{
        checImei(imei,loginid);
      }

    }
    else{
      print('invalid username or password');
      // emailController.text="";
      changeText('Invalid username or password !');
      passwordController.clear();
    }
  }

 void _getCurrentLocation()async{
   Position position = await Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
   lat=position.latitude;
   lon=position.longitude;
   // print(lat);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        resizeToAvoidBottomPadding: false,
        body: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: <Widget>[
            Container(
              child:Stack(
                children: <Widget>[
                  Container(
                      padding:EdgeInsets.fromLTRB(15.0, 0, 0.0, 0.0),
                      child:Text(
                        'Hello',
                        style: TextStyle(
                          fontSize: 80.0, fontWeight:FontWeight.bold,
                        ),
                      )
                  ),
                  Container(
                      padding:EdgeInsets.fromLTRB(15.0,75.0, 0.0, 0.0),
                      child:Text(
                        'There',
                        style: TextStyle(
                          fontSize: 80.0, fontWeight:FontWeight.bold,
                        ),
                      )
                  ),
                  Container(
                      padding:EdgeInsets.fromLTRB(245.0,75.0, 0.0, 50.0),
                      child:Text(
                        '.',
                        style: TextStyle(
                          fontSize: 80.0, fontWeight:FontWeight.bold,
                          color: Colors.green,
                        ),
                      )
                  )
                ],
              ),
            ),

            Container(
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
              padding:EdgeInsets.only(top:35.0,left:20.0,right:20.0),
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
                padding:EdgeInsets.only(top:20.0,left:20.0,right:20.0),
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
            Container(
                height:55.0,
                margin: EdgeInsets.fromLTRB(30.0, 50.0, 30.0, 30.0),
                child: Material(
                    borderRadius: BorderRadius.circular(30.0),
                    shadowColor: Colors.greenAccent,
                    color:Colors.green,
                    elevation: 10.0,
                    child: GestureDetector(
                      onTap:() async {
                        String imei='';
                        try{
                          imei = await ImeiPlugin.getImei(shouldShowRequestPermissionRationale: false);
                        }on Exception{
                          imei="123";
                        }

                        if(imei.length!=15){
                          imei="";
                        }
                        print(imei);
                        final String email=emailController.text;
                        final String password=passwordController.text;
                        print("good thill here");
                        _getCurrentLocation();
                        await checkUser(email, password,imei);
                      },
                      child: Center(
                        child: Text(
                          'LOGIN',
                          style: TextStyle(
                            color: Colors.white,
                            fontWeight: FontWeight.bold,
                            fontSize: 22,
                          ),
                        ),
                      ),
                    )
                )
            ),
            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: <Widget>[
                Text(
                  "New to Find ?",
                ),
                SizedBox(width:10),
                InkWell(
                    onTap: () {
                      // alwaysRun();
                      Navigator.of(context).pushNamed('/signup');
                      // Navigator.of(context).pushNamed('/adddevice');
                      void dispose() {};
                    },
                    child: Text(
                      'Register',
                      style:TextStyle(
                        color: Colors.green,
                        fontWeight: FontWeight.bold,
                      ),
                    )
                )
              ],
            )
          ],
        )
    );
  }
}

