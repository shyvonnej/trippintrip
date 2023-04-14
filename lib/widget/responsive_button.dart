// ignore_for_file: must_be_immutable

import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/widget/colourswatch.dart';

class ResponsiveButton extends StatelessWidget {
  bool? isResponsive;
  double? width;
  String? text;
  ResponsiveButton({this.width, this.text, this.isResponsive = false, super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      width: width,
      height: 50,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(10),
        color: darkBlue
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Text(
            text!,
            style: const TextStyle(
              color: Colors.white,
              fontFamily: "Times New Roman",
              fontSize: 15,
              fontWeight: FontWeight.bold,
            )),
            const SizedBox(width: 5),
          const Icon(
            Icons.arrow_right,
            size: 20,
            color: Colors.white,
            semanticLabel: 'Proceed to next step',
          ),
        ],
      ),
    );
  }
}