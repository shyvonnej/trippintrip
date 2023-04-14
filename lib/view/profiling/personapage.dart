import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/model/config.dart';
import 'package:flutter_trippintrip/model/persona.dart';
import 'package:flutter_trippintrip/model/user.dart';
import 'package:flutter_trippintrip/view/nav/personadetails.dart';
import 'package:http/http.dart' as http;
import 'package:cached_network_image/cached_network_image.dart';

class PersonasPage extends StatefulWidget {
  final User user;
  const PersonasPage({Key? key, required this.user}) : super(key: key);

  @override
  State<PersonasPage> createState() => _PersonasPageState();
}

class _PersonasPageState extends State<PersonasPage> {
  List personaList = [];
  int numPersona = 0;

  @override
  void initState() {
    super.initState();
    _loadPersona();
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
        title: const Text('CHOOSE YOUR PERSONA'),
        automaticallyImplyLeading: false,
      ),
      body: Center(
        child: personaList.isEmpty
            ? const CircularProgressIndicator()
            : ListView.builder(
                shrinkWrap: true,
                scrollDirection: Axis.horizontal,
                itemCount: personaList.length,
                itemBuilder: (BuildContext context, int index) {
                  final persona = personaList[index];
                  return Padding(
                    padding: const EdgeInsets.fromLTRB(20, 30, 20, 10),
                    child: GestureDetector(
                      onTap: () {
                        _personaDetails(index);
                      },
                      child: Column(
                        children: [
                          ClipRRect(
                            borderRadius: BorderRadius.circular(8.0),
                            child: CachedNetworkImage(
                              imageUrl: persona['personaimage'] ??
                                  'https://via.placeholder.com/150',
                              width: 350,
                              height: 550,
                              fit: BoxFit.cover,
                            ),
                          ),
                          const SizedBox(height: 15.0),
                          Text(
                            persona['personaname'] ?? "error",
                            style: const TextStyle(
                                fontSize: 20.0,
                                fontWeight: FontWeight.w600,
                                color: Color.fromRGBO(0, 0, 0, 100)),
                          ),
                        ],
                      ),
                    ),
                  );
                },
              ),
      ),
    );
  }

  _loadPersona() {
    http
        .post(Uri.parse("${Config.server}/trippintrip/php/selectpersona.php"))
        .then((response) {
      if (response.statusCode == 200 && response.body != "failed") {
        var parsedJson = json.decode(response.body);
        personaList = parsedJson['data']['persona'];
        setState(() {
          numPersona = personaList.length;
        });
      }
    });
  }

  _personaDetails(int index) async {
    Persona persona = Persona(
      personaid: personaList[index]['personaid'],
      personaname: personaList[index]['personaname'],
      personatype: personaList[index]['personatype'],
      personadesc: personaList[index]['personadesc'],
      personaimage: personaList[index]['personaimage'],
      personaactivity: personaList[index]['personaactivity'],
    );

    Navigator.push(
        context,
        MaterialPageRoute(
            builder: (BuildContext context) =>
                PersonaDetails(user: widget.user, persona: persona)));
  }
}
