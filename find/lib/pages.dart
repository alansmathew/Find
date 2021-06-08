import 'package:find/LoginPage.dart';
import 'package:find/main.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:get/get.dart';
import 'dart:async';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import 'globals.dart';


// first page
class Firstpage extends StatefulWidget {
  @override
  _FirstpageState createState() => _FirstpageState();
}
class _FirstpageState extends State<Firstpage> {

  Completer<GoogleMapController> _controller = Completer();
  static LatLng _center = const LatLng(45.521563, -122.677433);
  final Set<Marker> _markers = {};
  LatLng _lastMapPosition = _center;
  MapType _currentMapType = MapType.normal;

  _onMapCreated(GoogleMapController controller) {
    _controller.complete(controller);
  }

  _onCameraMove(CameraPosition position) {
    _lastMapPosition = position.target;
  }

  _onMapTypeButtonPressed() {
    setState(() {
      _currentMapType = _currentMapType == MapType.normal
          ? MapType.satellite
          : MapType.normal;
    });
  }

  _onAddMarkerButtonPressed() {
    setState(() {
      _markers.add(Marker(
        markerId: MarkerId(_lastMapPosition.toString()),
        position: _lastMapPosition,
        infoWindow: InfoWindow(
          title: 'This is the title',
          snippet: "this is the snippent",
        ),
        icon: BitmapDescriptor.defaultMarker,
      ));
    });
  }

  Widget button(Function function, IconData icon) {
    return FloatingActionButton(
        onPressed: function,
        materialTapTargetSize: MaterialTapTargetSize.padded,
        backgroundColor: Colors.blue,
        child: Icon(
          icon,
          size: 36,
        ));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          GoogleMap(
            onMapCreated: _onMapCreated,
            initialCameraPosition: CameraPosition(
              target: _center,
              zoom: 11.0,
            ),
            mapType: _currentMapType,
            markers: _markers,
            onCameraMove: _onCameraMove,
          ),
          Padding(
            padding: EdgeInsets.only(right: 16.0, top: 60.0),
            child: Align(
              alignment: Alignment.topRight,
              child: Column(
                children: [
                  button(_onMapTypeButtonPressed, Icons.map),

                  SizedBox(
                    height: 16.0,
                  ),
                  // button(_onAddMarkerButtonPressed, Icons.add_location),
                ],
              ),
            ),
          )
        ],
      ),
    );
  }
}

//second page
class Secondpage extends StatefulWidget {
  @override
  _SecondpageState createState() => _SecondpageState();
}
class _SecondpageState extends State<Secondpage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text(
            "List of devices",
            style: TextStyle(color: Colors.white),
          ),
          backgroundColor: Colors.teal,
        ),
        body: SafeArea(
          child: Center(
            child: Text("Second page"),
          ),
        ));
  }
}

//third page
class Thirdpage extends StatefulWidget {
  @override
  _ThirdpageState createState() => _ThirdpageState();
}
class _ThirdpageState extends State<Thirdpage> {

  @override
  void initState() {
    _getUserDetails();
    // TODO: implement initState
    super.initState();
  }

  var _email = "";
  var _username ='';
  var _image = "https://alansmathew.000webhostapp.com/images/user.png";

  Future _getUserDetails() async{
    SharedPreferences user = await SharedPreferences.getInstance();
    var loginid=user.getString('loginid');
    final response = await http.post(apiUrl,
        body:{
          'type':'userdetails',
          'login_id':loginid,
        });

    print("Parcing response request");
    print(response.body);
    var data = jsonDecode(response.body);
    if(data['value']=="true"){
      setState(() {
        _username=data['name'];
        _image= "https://alansmathew.000webhostapp.com/images/${data['image']}";
        _email = user.getString('email');
      });
    }
    else{
      print('api error!!!');
    }

  }

  Future logoutFunction() async {
    print("loggout presssed");

    SharedPreferences user = await SharedPreferences.getInstance();
    var deviceid = user.getString('device_id');

    final response = await http.post(apiUrl,
        body:{
          'type':'deleteDevice',
          'deviceId':deviceid,
        });

    print("Parcing response request");
    print(response.body);

    var data = jsonDecode(response.body);

    print(data['value']);
    if(data['value']=='deleted'){
      print('device deleted from db , going back to login');
      user.clear();
      Get.to(LoginPage());
    }
    else{
      print('some error occured');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.teal,
      body: SafeArea(
          child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          CircleAvatar(
            radius: 50.0,
            backgroundImage: NetworkImage(_image),
            // backgroundImage: AssetImage('images/angela.jpg'),
          ),
          Text(
            _username,
            style: TextStyle(
              fontFamily: 'Pacifico',
              fontSize: 40.0,
              color: Colors.white,
              fontWeight: FontWeight.bold,
            ),
          ),
          SizedBox(
            height: 20.0,
            width: 150.0,
            child: Divider(
              color: Colors.teal.shade100,
            ),
          ),
          Card(
              margin: EdgeInsets.symmetric(vertical: 10.0, horizontal: 25.0),
              child: ListTile(
                leading: Icon(
                  Icons.email,
                  color: Colors.teal,
                ),
                title: Text(
                  _email,
                  style: TextStyle(
                      fontSize: 20.0,
                      color: Colors.teal.shade900,
                      fontFamily: 'Source Sans Pro'),
                ),
              )),
          Card(
              margin: EdgeInsets.symmetric(vertical: 10.0, horizontal: 25.0),
              child: ListTile(
                onTap: logoutFunction,
                leading: Icon(
                  Icons.logout,
                  color: Colors.teal,
                ),
                title: Text(
                  'Logout',
                  textAlign: TextAlign.left,
                  style: TextStyle(
                    color: Colors.teal.shade900,
                    fontFamily: 'Source Sans Pro',
                    fontSize: 20.0,
                  ),
                ),
              )),
        ],
      )),
    );
  }
}
