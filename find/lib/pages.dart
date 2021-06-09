import 'package:find/LoginPage.dart';
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
  static LatLng _center = LatLng(9.520925, 76.728531);
  final Set<Marker> _markers = {};
  LatLng _lastMapPosition = _center;
  var _devicename,_deviceaddress;
  MapType _currentMapType = MapType.normal;

  @override
  void initState() {
    _getDeviceLocations();
    // TODO: implement initState
    super.initState();
  }

  Future _getDeviceLocations() async{
    SharedPreferences user = await SharedPreferences.getInstance();
    var loginid=user.getString('loginid');
    final response = await http.post(apiUrl,
        body:{
          'type':'listdevice',
          'loginId':loginid,
        });

    print("Parcing response request");
    // print(response.body);
    var data = jsonDecode(response.body);
    print(data);
    if(data['value'] == 'devices'){

      allDevices = data['devices']; // saving list off all device data to global variable
      print('saved all details abt devices to global variable');
      DeviceAddressList.clear();

      //checking if current device is logout out or not
      var isDeviceIdPresent = false ;
      SharedPreferences user = await SharedPreferences.getInstance();
      var deviceIdFromShPreffernece = user.getString("device_id");

      List<dynamic> devices = data['devices'];
      for(var i = 0; i < devices.length ; i++){
        _devicename = devices[i]['name'];
        var _lat = devices[i]['lat'];
        var _lon = devices[i]['lon'];
        var _time = devices[i]['time'];
        _lastMapPosition = LatLng(double.parse(_lat),double.parse( _lon));
        print(_lastMapPosition);

        var _apiurltemp = "https://maps.googleapis.com/maps/api/geocode/json?&key=AIzaSyDcGOfvXmG8VTv8qvjQ3-diHeOLh0HyDY8&latlng="+_lat+","+_lon;
        var _apiurl = Uri.parse(_apiurltemp);

        final googleresponse = await http.get(_apiurl);
        var googledata = jsonDecode(googleresponse.body);
        if (_time == 'Now'){
          _deviceaddress = "Last seen at - "+googledata['results'][0]['formatted_address']+" - " +_time ;
        }
        else{
          _deviceaddress = "Last seen at - "+googledata['results'][0]['formatted_address']+" - ${_time} ago." ;
        }
        DeviceAddressList.add(_deviceaddress);

        if(devices[i]['deviceID'] == deviceIdFromShPreffernece){
          isDeviceIdPresent = true;
        }

        setState(() {
          _center = _lastMapPosition;
        });
        _onAddMarkerButtonPressed();

      }
      if (isDeviceIdPresent == false){
        print('loging out user !!');
        WHILEVARIABLE = false ;
        user.clear();
        Get.to(LoginPage());
      }
    }
    else{
      print('user might have removed this device ! ');
      Get.to(LoginPage());
    }
  }

  _onMapCreated(GoogleMapController controller) {
    _controller.complete(controller);
  }

  // _onCameraMove(CameraPosition position) {
  //   _lastMapPosition = position.target;
  // }

  _onMapTypeButtonPressed() {
    setState(() {
      _currentMapType = _currentMapType == MapType.normal
          ? MapType.satellite
          : MapType.normal;
    });
  }

  _onAddMarkerButtonPressed() {
    // print(_lastMapPosition);
    setState(() {
      _markers.add(Marker(
        markerId: MarkerId(_lastMapPosition.toString()),
        position: _lastMapPosition,
        infoWindow: InfoWindow(
          title: _devicename,
          snippet: _deviceaddress,
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
            // onCameraMove: _onCameraMove,
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
          child: buildlistview(context),
        ));
  }

  ListView buildlistview(BuildContext context){
    return ListView.builder(
      itemCount: allDevices.length,
        itemBuilder: (_, index){

          var color=Colors.green;
        if(allDevices[index]['state'] != 'active'){
          color = Colors.red;
        }
            return Card(
              child: ListTile(
                title: Text(allDevices[index]['name']),
                leading: Icon(Icons.devices),
                subtitle: Text(DeviceAddressList[index]+"\n"+"Status : "+allDevices[index]['state']),
                trailing:
                  Icon(Icons.wifi_tethering,color: color,)
              ),
              margin: EdgeInsets.only(left: 14.0,right: 14.0, top: 15.0),
              elevation: 10.0,
            );
        },
    );
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

  var _email = EMAIL;
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
        // _email = user.getString('email');
      });
    }
    else{
      print('api error!!!');
    }

  }

  Future logoutFunction() async {
    print("loggout presssed");

    WHILEVARIABLE = false ;

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
