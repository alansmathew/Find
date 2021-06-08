import 'package:find/LoginPage.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

void main() {
  runApp(GetMaterialApp(home: storyBoard()));
}

class storyBoard extends StatefulWidget {
  @override
  _storyBoardState createState() => _storyBoardState();
}

class _storyBoardState extends State<storyBoard> {

  void move_to_login(){
    print("moving to login page");
    Get.to(() => LoginPage());
    // Get.to(() => mapview());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: PageView(
        children: [
          Container(
            child: Column(
              children: [
                Spacer(),
                Spacer(),
                Image.asset('images/location.jpg'),
                Spacer(),
                Container(
                  child: Container(
                    child: Column(
                      children: [
                        Spacer(),
                        Text("Welcome to Find",style: TextStyle(color: Colors.white,fontSize: 22),),
                        Container(
                          width: MediaQuery.of(context).size.width*0.65,
                          child:Text("By using this application you will be able to securely find your devices even if there is no connection.",
                            style: TextStyle(color: Colors.white70,fontSize: 13),
                            textAlign: TextAlign.center,
                          ),
                          margin: const EdgeInsets.only(top: 7.0),
                        ),
                        Spacer(),
                        Text("Swipe left",style: TextStyle(color: Colors.white54,fontSize: 14),),
                        Spacer(),
                      ],
                    ),
                  ),
                  height:MediaQuery.of(context).size.height * 0.35,
                  width: MediaQuery.of(context).size.width,
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
          Container(
            child: Column(
              children: [
                Spacer(),
                Spacer(),
                Image.asset('images/security.jpg'),
                Spacer(),
                Container(
                  child: Container(
                    child: Column(
                      children: [
                        Spacer(),
                        Text("Secure transmission",style: TextStyle(color: Colors.white,fontSize: 22),),
                        Container(
                          width: MediaQuery.of(context).size.width*0.65,
                          child:Text("We made sure all your data is transferred in a secure way using different hash algorithm and no one will be able to intercept you data.",
                            style: TextStyle(color: Colors.white70,fontSize: 13),
                            textAlign: TextAlign.center,
                          ),
                          margin: const EdgeInsets.only(top: 7.0),
                        ),
                        Spacer(),
                        Text("Swipe left",style: TextStyle(color: Colors.white54,fontSize: 14),),
                        Spacer(),
                      ],
                    ),
                  ),
                  height:MediaQuery.of(context).size.height * 0.35,
                  width: MediaQuery.of(context).size.width,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.only(
                      topRight: Radius.circular(30.0),
                      topLeft: Radius.circular(30.0),
                    ),
                    color: Color.fromARGB(255,106,111,196),
                    boxShadow: [
                      BoxShadow(color: Colors.white, spreadRadius: 0),
                    ],
                  ),
                ),
                // Spacer()
              ],
            ),
            color:Colors.white,
          ),
          Container(
            child: Column(
              children: [
                Spacer(),
                Spacer(),
                Image.asset('images/bluetooth.jpg'),
                Spacer(),
                Container(
                  child: Container(
                    child: Column(
                      children: [
                        Spacer(),
                        Text("Low Power Bluetooth",style: TextStyle(color: Colors.white,fontSize: 22),),
                        Container(
                          width: MediaQuery.of(context).size.width*0.65,
                          child:Text("In order for you device to update location while offline, we use low power bluetooth signal across devices.",
                            style: TextStyle(color: Colors.white70,fontSize: 13),
                            textAlign: TextAlign.center,
                          ),
                          margin: const EdgeInsets.only(top: 7.0),
                        ),
                        // Spacer(),
                        Container(
                          child: SizedBox(
                            width: 200,
                            height:40,
                            child:ElevatedButton(
                              child: Text(
                                "Login".toUpperCase(),
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
                              onPressed: move_to_login,
                            ),
                          ),
                          margin: const EdgeInsets.only(top: 20.0),
                        ),
                        Spacer(),
                      ],
                    ),
                  ),
                  height:MediaQuery.of(context).size.height * 0.35,
                  width: MediaQuery.of(context).size.width,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.only(
                      topRight: Radius.circular(30.0),
                      topLeft: Radius.circular(30.0),
                    ),
                    color: Color.fromARGB(255,106,111,196),
                    boxShadow: [
                      BoxShadow(color: Colors.white, spreadRadius: 0),
                    ],
                  ),
                ),
              ],
            ),
            color:Colors.white,
          ),
        ],
      ),
    );
  }

}
