// ignore_for_file: depend_on_referenced_packages

import 'dart:async';
import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:flutter_trippintrip/view/welcome/welcomepage.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;
import '../../model/config.dart';
import '../../model/user.dart';
import '../nav/mainpage.dart';

class SplashPage extends StatefulWidget {
  const SplashPage({Key? key}) : super(key: key);

  @override
  State<SplashPage> createState() => _SplashPageState();
}

class _SplashPageState extends State<SplashPage> {
  @override
  void initState() {
    super.initState();
    checkAndLogin();
  }

  @override
  Widget build(BuildContext context) {
    return Stack(
      alignment: Alignment.center,
      children: [
        Container(
            decoration: const BoxDecoration(
                image: DecorationImage(
                    image: AssetImage('assets/images/splash.png'),
                    fit: BoxFit.cover))),
        Padding(
          padding: const EdgeInsets.fromLTRB(0, 50, 0, 20),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: const [
              SizedBox(height: 350),
              SpinKitFadingCircle(
                color: Colors.white,
                size: 50.0,
              ),
              SizedBox(height: 200),
              Text("Final Year Project © 2023 Shyvonne Ho Yue Lynn",
                  style: TextStyle(
                      fontSize: 10,
                      fontWeight: FontWeight.bold,
                      fontStyle: FontStyle.italic,
                      color: Colors.white)),
            ],
          ),
        )
      ],
    );
  }

  checkAndLogin() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String email = (prefs.getString('email')) ?? '';
    String pass = (prefs.getString('pass')) ?? '';
    late User user;
    if (email.length > 1 && pass.length > 1) {
      http.post(Uri.parse("${Config.server}/trippintrip/php/login.php"),
          body: {"email": email, "password": pass}).then((response) {
        if (response.statusCode == 200 && response.body != "failed") {
          final jsonResponse = json.decode(response.body);
          user = User.fromJson(jsonResponse);
          Timer(
              const Duration(seconds: 3),
              () => Navigator.pushReplacement(
                  context,
                  MaterialPageRoute(
                      builder: (content) => MainPage(user: user))));
        } else {
          // create dummy data to pass to main page
          user = User(
              id: "na",
              name: "na",
              email: "na",
              phone: "na",
              address: "na",
              regdate: "na",
              otp: "na",
              isProfileComplete: false);
          Timer(
              const Duration(seconds: 3),
              () => Navigator.pushReplacement(
                  context,
                  MaterialPageRoute(
                      builder: (content) => MainPage(user: user))));
        }
      }).timeout(const Duration(seconds: 5));
    } else {
      user = User(
          id: "na",
          name: "na",
          email: "na",
          phone: "na",
          address: "na",
          regdate: "na",
          otp: "na",
          isProfileComplete: false);
      Timer(
          const Duration(seconds: 8),
          () => Navigator.pushReplacement(context,
              MaterialPageRoute(builder: (content) => const WelcomePage())));
    }
  }
}
