import 'package:find/StoryBoard.dart';
import 'package:find/addDevice.dart';
import 'package:find/map.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:get/get.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      title: 'Flutter Demo',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: MyHomePage(),
    );
  }
}

class MyHomePage extends StatefulWidget {
  @override
  _MyHomePageState createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {

  var userEmail;

  void checkUSER() async {
    print("checking User");
    SharedPreferences user = await SharedPreferences.getInstance();
    userEmail=user.getString("email");
    if (userEmail == null ) {
      Get.to(storyBoard());
      // Get.to(addDevice());
      print("go to log in screen");
    }
    else{
      Get.to(Mapv());
      print("go to map view");
    }
  }

  @override
  void initState() {
    checkUSER();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Image.asset('images/temp.jpg'),
          ],
        ),
      ),
      backgroundColor: Colors.white,
    );
  }
}
