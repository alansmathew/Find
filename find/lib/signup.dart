import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:imei_plugin/imei_plugin.dart';
import 'main.dart';
import 'package:find/user_model.dart';
import 'package:http/http.dart' as http;
import "globals.dart";
import "addDevice.dart";

void main() {
  runApp(SignupPage());
}

class SignupPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      routes: <String, WidgetBuilder> {
        '/signin' : (BuildContext context) => new MyApp()
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

  final TextEditingController registerNameController = TextEditingController();
  final TextEditingController registerEmailController = TextEditingController();
  final TextEditingController registerPasswordController = TextEditingController();

  Future regUser(String regName, String regEmail, String regPass,String imei) async{
    print("inside function");
    final String apiUrl ="https://alansmathew.000webhostapp.com/php/find_api.php";
    final response = await http.post(apiUrl,
        body:{
          'type':"register",
          'name':regName,
          'email':regEmail,
          'password':regPass
        });
    print('before json');
    final String val =userModelFromJson(response.body).value.toString();
    final String loginid =userModelFromJson(response.body).loginId;
    print('passed login');
    if (val=='valid'){
      print('yes');
      logid=loginid;
      Txt="By registering this device, you will be able to access all the services provided by FIND for free";
      if(imei==""){
        IMEI="";
        print("here goes the page to enter imei");
        Txt="By entering IMEI address you can register this device. If already registered click cancel.";
        Navigator.push(context, MaterialPageRoute(builder: (context)=> addDevice()));
        void dispose() {}
        // here goes the next page
      }
      else{
        IMEI=imei;
        Navigator.push(context, MaterialPageRoute(builder: (context)=> addDevice()));
        void dispose() {}
      }
    }
    else{
      print('nop');
      // emailController.text="";
      changeText(val);
      registerPasswordController.clear();
      registerEmailController.clear();
    }

  }


  @override
  Widget build(BuildContext context) {
    return new Scaffold(
      resizeToAvoidBottomPadding: false,
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.start,
        children: <Widget>[
          Container(
            child:Stack(
              children: <Widget>[
                Container(
                  padding:EdgeInsets.fromLTRB(15.0, 0, 40, 0.0),
                  child:Text(
                    'Get',
                    style: TextStyle(
                      fontSize: 80.0, fontWeight:FontWeight.bold,
                    ),
                  )
                ),
                Container(
                    padding:EdgeInsets.fromLTRB(15.0,75.0, 40, 0.0),
                    child:Text(
                      'Started',
                      style: TextStyle(
                        fontSize: 80.0, fontWeight:FontWeight.bold,
                      ),
                    )
                ),
                Container(
                    padding:EdgeInsets.fromLTRB(310.0,75.0, 0.0, 50.0),
                    child:Text(
                      '.',
                      style: TextStyle(
                        fontSize: 80.0, fontWeight:FontWeight.bold,
                        color: Colors.blue,
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
            height:55.0,
            margin: EdgeInsets.fromLTRB(50.0, 40.0, 50.0, 30.0),
            child: Material(
              borderRadius: BorderRadius.circular(30.0),
                shadowColor: Colors.blueAccent,
              color:Colors.blue,
              elevation: 10.0,
              child: GestureDetector(
                onTap:() async {
                  final String regName = registerNameController.text;
                  final String regEmail = registerEmailController.text;
                  final String regPass = registerPasswordController.text;

                  String imei='';
                  try{
                    imei = await ImeiPlugin.getImei(shouldShowRequestPermissionRationale: false);
                  }on Exception{
                    imei="123";
                  }

                  if(imei.length!=15){
                    imei="";
                  }

                  await regUser(regName, regEmail,regPass,imei);

                },
                child: Center(
                  child: Text(
                    'SIGN UP',
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
                "Already a user ?",
              ),
              SizedBox(width:10),
              InkWell(
               onTap: (){
                 Navigator.of(context).pushNamed('/signin');
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
      )
    );
  }
}
