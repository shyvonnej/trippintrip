import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/view/nav/mainfavpage.dart';
import 'package:flutter_trippintrip/view/nav/triplist.dart';
import 'package:flutter_trippintrip/view/nav/settingpage.dart';
import 'package:flutter_trippintrip/view/nav/attractionpage.dart';
import '../../model/user.dart';

class MainPage extends StatefulWidget {
  final User user;
  const MainPage({Key? key, required this.user}) : super(key: key);

  @override
  State<MainPage> createState() => _MainPageState();
}

class _MainPageState extends State<MainPage> {
   late List<Widget> tabchildren; 
      int _currentIndex = 0;
      String maintitle = "HomePage";

  @override
    void initState() {
      super.initState(); 
      tabchildren = [
        TabPage1(user: widget.user),
        TripListPage(user: widget.user),
        MainFavPage(user: widget.user),
        Setting(user: widget.user),
      ];
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: tabchildren[_currentIndex],
      bottomNavigationBar: 
            BottomNavigationBar(
              type: BottomNavigationBarType.shifting,
              backgroundColor: Colors.blueGrey,
              unselectedFontSize: 0,
              selectedFontSize: 0,
              selectedItemColor: Colors.black54,
              unselectedItemColor: Colors.grey.withOpacity(0.5),
              showUnselectedLabels: false,
              showSelectedLabels: false,
              elevation: 0,
              onTap: onTabTapped, 
              currentIndex: _currentIndex, 
              items: const [
                BottomNavigationBarItem(
                icon: Icon(
                  Icons.home, 
                  color: Colors.black), 
                  label: "HomePage"),
                  BottomNavigationBarItem(
                icon: Icon(
                  Icons.list, 
                  color: Colors.black), 
                  label: "Plan"),
                  BottomNavigationBarItem(
                icon: Icon(
                  Icons.star, 
                  color: Colors.black), 
                  label: "Favourite"),
                BottomNavigationBarItem(
                icon: Icon(
                  Icons.settings, 
                  color: Colors.black), 
                  label: "Settings"),
              ],
            ),
    );
  }

  void onTabTapped(int index) { 
    setState(() {
      _currentIndex = index; 
      
      if (_currentIndex == 0) {
        maintitle = "Homepage";
      }
      if (_currentIndex == 1) { 
        maintitle = "Plan Page";
      }
      if (_currentIndex == 2) { 
        maintitle = "Favourite Page";
      }
      if (_currentIndex == 3) { 
        maintitle = "Setting";
      }
    });
  }
}