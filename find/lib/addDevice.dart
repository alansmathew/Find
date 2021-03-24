import 'package:path/path.dart';

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:mysql1/mysql1.dart';
import 'package:http/http.dart' as http;
import 'check_imei_model.dart';
import 'globals.dart';
import 'map.dart';
import 'update_locAnd_Sound.dart';

void main() {
  runApp(addDevice());
}


class addDevice extends StatelessWidget {

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: MyHomePage(),
    );
  }
}

class MyHomePage extends StatefulWidget {

  @override
  _MyHomePageState createState() => _MyHomePageState();
}


final TextEditingController IMEIController = TextEditingController(text: "$IMEI");
final TextEditingController nmIController = TextEditingController();

Future upImei(String nm) async
{
  final String apiUrl ="https://alansmathew.000webhostapp.com/php/find_api.php";
  final response = await http.post(apiUrl,
      body:{
        'type':"updateIMEI",
        'login_id':logid,
        'name':nm,
        'imei':IMEI,
      }
  );
  print("data sent");
  final String res=checkImeiFromJson(response.body).value.toString();
  print(res);
  if(res=="done"){
    print('yes');
    alwaysRun();
    // Navigator.push(addDevice, MaterialPageRoute(builder: (context)=> Mapv()));
    // Navigator.of(contest).pushNamed('/adddevice');
  }
}

register(){
  String nm;
  nm=nmIController.text;
  IMEI=IMEIController.text;
  if(IMEI.length==15 && nm!=""){
    upImei(nm);
    print("imei passed");
  }
  else{
    IMEIController.clear();
  }
}

class _MyHomePageState extends State<MyHomePage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        resizeToAvoidBottomPadding: false,
        body: Center(
          child:Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: <Widget>[
              Container(
                child: Text(
                  "Register this device ? ",
                  style: TextStyle(fontSize: 22, fontWeight: FontWeight.w300),
                ),
              ),
              SizedBox(
                height: 15,
              ),
              Container(
                padding: EdgeInsets.fromLTRB(20, 10, 20, 0),
                child: Text(
                  '$Txt',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w200,
                  ),
                  textAlign: TextAlign.center,
                ),
              ),
              Container(
                padding: EdgeInsets.fromLTRB(0, 20, 0, 0),
                child: Text(
                  "",
                  style: TextStyle(
                    color: Colors.red,
                  ),
                ),
              ),
              Container(
                padding: EdgeInsets.only(top: 0, left: 60.0, right: 60.0),
                child: Column(
                  children: <Widget>[
                    TextField(
                      controller: nmIController,
                      decoration: InputDecoration(
                        labelText: 'Device Name',
                        labelStyle: TextStyle(
                          fontWeight: FontWeight.bold,
                          color: Colors.grey,
                        ),
                        focusedBorder: UnderlineInputBorder(
                          borderSide: BorderSide(color: Colors.blue),
                        ),
                      ),
                      style: TextStyle(
                        color: Colors.black,
                        // fontSize: 20,
                      ),
                    )
                  ],
                ),
              ),
              Container(
                padding: EdgeInsets.only(top: 0, left: 60.0, right: 60.0),
                child: Column(
                  children: <Widget>[
                    TextFormField(
                      controller: IMEIController,
                      decoration: InputDecoration(
                        labelText: 'IMEI',
                        labelStyle: TextStyle(
                          fontWeight: FontWeight.bold,
                          color: Colors.grey,
                        ),
                        focusedBorder: UnderlineInputBorder(
                          borderSide: BorderSide(color: Colors.blue),
                        ),
                      ),
                      style: TextStyle(
                        color: Colors.black,
                        // fontSize: 20,
                      ),
                    )
                  ],
                ),
              ),
              SizedBox(
                height: 15,
              ),

              ButtonBar(
                mainAxisSize:MainAxisSize.min,
                children: [
                  FlatButton(
                    textColor: Colors.blue,
                    disabledColor: Colors.grey,
                    disabledTextColor: Colors.black,
                    padding: EdgeInsets.all(10.0),
                    // splashColor: Colors.blueAccent,
                    onPressed: () {
                      print(logid);
                    },
                    child: Text(
                      "Cancel",
                      style: TextStyle(fontSize: 16.0,
                          fontWeight: FontWeight.w400),
                    ),
                  ),
                  SizedBox(
                    width: 3,
                  ),
                  FlatButton(
                    textColor: Colors.blue,
                    disabledColor: Colors.grey,
                    disabledTextColor: Colors.black,
                    padding: EdgeInsets.all(10.0),
                    splashColor: Colors.blueAccent,
                    onPressed: () {
                      register();
                      print("register pressed");
                    },
                    child: Text(
                      "Register",
                      style: TextStyle(fontSize: 18.0,
                      fontWeight: FontWeight.w500),
                    ),
                  ),
                ],
              )
            ],
          ),
          )
        );
  }
}
