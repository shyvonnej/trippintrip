// ignore_for_file: avoid_print, deprecated_member_use
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/model/config.dart';
import 'package:flutter_trippintrip/model/persona.dart';
import 'package:flutter_trippintrip/model/user.dart';
import 'package:flutter_trippintrip/view/profiling/travelpreference.dart';
import 'package:http/http.dart' as http;

class PersonaDetails extends StatefulWidget {
  final User user;
  final Persona persona;
  const PersonaDetails({Key? key, required this.persona, required this.user})
      : super(key: key);

  @override
  State<PersonaDetails> createState() => _PersonaDetailsState();
}

class _PersonaDetailsState extends State<PersonaDetails> {
  List personaList = [];
  int numPersona = 0;

  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    late double screenHeight, screenWidth, resWidth;

    screenHeight = MediaQuery.of(context).size.height;
    screenWidth = MediaQuery.of(context).size.width;

    if (screenWidth <= 600) {
      resWidth = screenWidth;
    } else {
      resWidth = screenWidth * 0.70;
    }

    return Scaffold(
        appBar: AppBar(
          title: const Text("PERSONA DETAILS"),
        ),
        body: Center(
            child: SizedBox(
                width: resWidth * 2,
                height: screenHeight,
                child: SingleChildScrollView(
                    child: Padding(
                        padding: const EdgeInsets.all(20.0),
                        child: Column(children: [
                          Padding(
                            padding: const EdgeInsets.all(20.0),
                            child: Text(
                              widget.persona.personaname!,
                              textAlign: TextAlign.center,
                              style: TextStyle(
                                fontSize: resWidth * 0.05,
                                fontWeight: FontWeight.bold,
                              ),
                            ),
                          ),
                          CachedNetworkImage(
                              height: 400,
                              width: 400,
                              fit: BoxFit.cover,
                              imageUrl: widget.persona.personaimage!,
                              placeholder: (context, url) =>
                                  const LinearProgressIndicator(),
                              errorWidget: (context, url, error) =>
                                  const Icon(Icons.error_outline_sharp)),
                          SizedBox(height: screenHeight * 0.03),
                          Row(
                            children: [
                              const Icon(Icons.person),
                              SizedBox(width: resWidth * 0.05),
                              Flexible(
                                child: Text(
                                  widget.persona.personatype!,
                                  style: TextStyle(
                                    fontSize: resWidth * 0.040,
                                  ),
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: screenHeight * 0.03),
                          Row(
                            children: [
                              const Icon(Icons.newspaper),
                              SizedBox(width: resWidth * 0.05),
                              Flexible(
                                child: Text(
                                  widget.persona.personadesc!,
                                  style: TextStyle(
                                    fontSize: resWidth * 0.040,
                                  ),
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: screenHeight * 0.03),
                          Row(
                            children: [
                              const Icon(Icons.theater_comedy_rounded),
                              SizedBox(width: resWidth * 0.05),
                              Flexible(
                                child: Text(
                                  widget.persona.personaactivity!,
                                  style: TextStyle(
                                    fontSize: resWidth * 0.040,
                                  ),
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: screenHeight * 0.04),
                          ElevatedButton(
                            onPressed: () {
                              showDialog(
                                context: context,
                                builder: (BuildContext context) {
                                  return AlertDialog(
                                    shape: const RoundedRectangleBorder(
                                        borderRadius: BorderRadius.all(
                                            Radius.circular(20.0))),
                                    title: const Text(
                                      "Select this persona?",
                                      style: TextStyle(
                                        color: Colors.black,
                                      ),
                                    ),
                                    content: const Text("Are you sure?",
                                        style:
                                            TextStyle(color: Colors.black54)),
                                    actions: <Widget>[
                                      TextButton(
                                        child: const Text(
                                          "Yes",
                                          style: TextStyle(
                                            color: Colors.teal,
                                          ),
                                        ),
                                        onPressed: () {
                                          updatePersonaForUser(
                                              widget.user.id.toString(),
                                              widget.persona.personaid
                                                  .toString());
                                          Navigator.of(context).pop();
                                          Navigator.push(
                                              context,
                                              MaterialPageRoute(
                                                builder: (context) =>
                                                    TravelPreferencesPage(
                                                        user: widget.user),
                                              ));
                                        },
                                      ),
                                      TextButton(
                                        child: const Text(
                                          "No",
                                          style: TextStyle(
                                            color: Colors.teal,
                                          ),
                                        ),
                                        onPressed: () {
                                          Navigator.of(context).pop();
                                        },
                                      ),
                                    ],
                                  );
                                },
                              );
                            },
                            style: ElevatedButton.styleFrom(
                              primary:
                                  Colors.blue[900], // Set the button color here
                            ),
                            child: Text(
                              'Select Persona',
                              style: TextStyle(
                                color: Colors.white,
                                fontSize: resWidth * 0.040,
                              ),
                            ),
                          ),
                        ]))))));
  }

  Future<void> updatePersonaForUser(String userId, String personaId) async {
    var url = Uri.parse('${Config.server}/trippintrip/php/updatepersona.php');
    var response = await http.post(url, body: {
      'user_id': userId.toString(),
      'persona_id': personaId.toString()
    }
    );

    if (response.statusCode == 200 && response.body != 'failed') {
      print('Persona preference updated successfully');
    } else {
      print('Error updating persona preference');
    }
  }
}
