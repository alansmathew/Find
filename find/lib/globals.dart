import 'package:shared_preferences/shared_preferences.dart';

var apiUrl = Uri.parse("https://alansmathew.000webhostapp.com/php/find_api.php");
// var apiUrl = Uri.parse("http://localhost/php/find_api.php");

String LOGINID;
String IMEI;
String Returnval;
String Txt;
String EMAIL;


var PARRED = false;

var lat;
var lon;

List<dynamic> allDevices ;
List DeviceAddressList =[];

var WHILEVARIABLE = true ;

