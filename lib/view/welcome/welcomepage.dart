// ignore_for_file: prefer_interpolation_to_compose_strings, sized_box_for_whitespace

import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/view/login%20and%20reg/loginpage.dart';
import 'package:flutter_trippintrip/widget/app_largetext.dart';
import 'package:flutter_trippintrip/widget/app_text.dart';
import 'package:flutter_trippintrip/widget/responsive_button.dart';

import '../login and reg/registerpage.dart';

class WelcomePage extends StatefulWidget {
  const WelcomePage({super.key});

  @override
  State<WelcomePage> createState() => _WelcomePageState();
}

class _WelcomePageState extends State<WelcomePage> {
  List images = ["welcome_one.png", "welcome_two.png", "welcome_three.png"];

  List boldtext = ["Trippin'", "Get Ready", "Let's Start!"];

  List secondaryText = ["Trip", "Plan Your Trip Ahead", "Sign Up or Login"];

  List description = [
    "We help users to plan and organize their travel itinerary by providing personalized recommendations.",
    "We help by providing personalized recommendations for accommodations and activities based on your preferences!",
    "To start your journey by travelling!"
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: PageView.builder(
          scrollDirection: Axis.vertical,
          itemCount: images.length,
          itemBuilder: (_, index) {
            if (index == 2) {
              return Container(
                width: double.maxFinite,
                height: double.maxFinite,
                decoration: BoxDecoration(
                  image: DecorationImage(
                    image: AssetImage("assets/images/" + images[index]),
                    fit: BoxFit.cover,
                  ),
                ),
                child: Container(
                  margin: const EdgeInsets.only(top: 100, left: 40, right: 20),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      AppLargeText(
                        text: boldtext[index],
                        style: const TextStyle(fontFamily: "Times New Roman"),
                      ),
                      const SizedBox(height: 5),
                      AppText(
                        text: secondaryText[index],
                        size: 27,
                        style: const TextStyle(fontFamily: 'Times New Roman'),
                      ),
                      const SizedBox(height: 15),
                      Container(
                        width: 250,
                        child: AppText(
                          style: const TextStyle(fontFamily: 'Times New Roman'),
                          text: description[index],
                          color: Colors.blueGrey,
                          size: 16,
                        ),
                      ),
                      const SizedBox(height: 15),
                      GestureDetector(
                          onTap: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                  builder: (context) => const LoginPage()),
                            );
                          },
                          child: ResponsiveButton(width: 120, text: "Login")),
                      const SizedBox(height: 15),
                      GestureDetector(
                          onTap: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                  builder: (context) => const RegisterPage()),
                            );
                          },
                          child: ResponsiveButton(width: 120, text: "Register")),
                    ],
                  ),
                ),
              );
            } else {}
            return Container(
              width: double.maxFinite,
              height: double.maxFinite,
              decoration: BoxDecoration(
                  image: DecorationImage(
                      image: AssetImage("assets/images/" + images[index]),
                      fit: BoxFit.cover)),
              child: Container(
                  margin: const EdgeInsets.only(top: 100, left: 40, right: 20),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          AppLargeText(
                              text: boldtext[index],
                              style: const TextStyle(
                                  fontFamily: "Times New Roman")),
                          const SizedBox(height: 5),
                          AppText(
                            text: secondaryText[index],
                            size: 27,
                            style:
                                const TextStyle(fontFamily: 'Times New Roman'),
                          ),
                          const SizedBox(height: 15),
                          Container(
                              width: 250,
                              child: AppText(
                                style: const TextStyle(
                                    fontFamily: 'Times New Roman'),
                                text: description[index],
                                color: Colors.blueGrey,
                                size: 16,
                              )),
                        ],
                      ),
                      Column(
                        children: List.generate(3, (indexSlider) {
                          return Container(
                            width: 8,
                            height: index == indexSlider ? 25 : 8,
                            margin: const EdgeInsets.only(bottom: 2),
                            decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(8),
                              color: index == indexSlider
                                  ? Colors.blue
                                  : Colors.blueGrey,
                            ),
                          );
                        }),
                      )
                    ],
                  )),
            );
          }),
    );
  }
}
