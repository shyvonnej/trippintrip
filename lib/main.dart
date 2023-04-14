import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/view/welcome/splashpage.dart';
import 'package:flutter_trippintrip/widget/colourswatch.dart';

void main() => runApp(const MyApp());

class MyApp extends StatefulWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  State<MyApp> createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  @override
  Widget build(BuildContext context) {
    final textTheme = Theme.of(context).textTheme.apply(
      fontFamily: 'Times New Roman',
    );
    return MaterialApp(
      title: 'TrippinTrip',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primarySwatch: darkBlue,
        textTheme: textTheme,
      ),
      home: const SplashPage()
    );
  }
}