import 'package:find/pages.dart';
import 'package:flutter/material.dart';

void main() {
  runApp(Mapv());
}

class Mapv extends StatefulWidget {
  @override
  _MapvState createState() => _MapvState();
}

class _MapvState extends State<Mapv> {

  int _currentIndex = 0;
  final tabs =[Firstpage(),Secondpage(),Thirdpage()];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: tabs[_currentIndex],
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _currentIndex,
        // type: BottomNavigationBarType.shifting,
        items: [
          BottomNavigationBarItem(
              icon: Icon(Icons.map_rounded),
              title: Text("Map"),
              backgroundColor: Colors.white
          ),
          BottomNavigationBarItem(
              icon: Icon(Icons.devices),
              title: Text("Devices"),
              backgroundColor: Colors.yellow
          ),
          BottomNavigationBarItem(
              icon: Icon(Icons.person),
              title: Text("User"),
              backgroundColor: Colors.purple
          ),
        ],
        onTap: (index){
          setState(() {
            _currentIndex = index ;
          });
        },
      ),
    );
  }

}

