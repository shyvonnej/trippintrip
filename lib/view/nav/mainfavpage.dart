import 'package:flutter/material.dart';
import '../../model/user.dart';

class MainFavPage extends StatefulWidget {
  final User user;
  const MainFavPage({Key? key, required this.user}) : super(key: key);

  @override
  State<MainFavPage> createState() => _MainFavPageState();
}

class _MainFavPageState extends State<MainFavPage> {
  late double screenHeight, screenWidth;

  @override
  Widget build(BuildContext context) {
    screenHeight = MediaQuery.of(context).size.height;
    screenWidth = MediaQuery.of(context).size.width;
    return Scaffold(
      appBar: AppBar(
        title: const Text('TrippinTrip'),
      ));
  }
}