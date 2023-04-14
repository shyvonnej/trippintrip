import 'dart:convert';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/model/config.dart';
import 'package:flutter_trippintrip/model/user.dart';
import 'package:http/http.dart' as http;

class ProfilePage extends StatefulWidget {
  final User user;
  const ProfilePage({Key? key, required this.user}) : super(key: key);

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  late List userData = [];

  @override
  void initState() {
    super.initState();
    fetchData();
  }

  fetchData() async {
    final response = await http.get(Uri.parse(
        '${Config.server}/trippintrip/php/mergedata.php?user=${widget.user.id}'));
    if (response.statusCode == 200) {
      setState(() {
        userData = jsonDecode(response.body);
      });
    } else {
      throw Exception('Failed to load data');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Profile Page'),
      ),
      body: userData.isEmpty
          ? const Center(child: CircularProgressIndicator())
          : ListView.builder(
              itemCount: userData.length,
              itemBuilder: (context, index) {
                final data = userData[index];
                return Padding(
                  padding: const EdgeInsets.all(24.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      const SizedBox(height: 16),
                      CachedNetworkImage(
                          height: 300,
                          width: 300,
                          fit: BoxFit.scaleDown,
                          imageUrl:
                              "${Config.server}/trippintrip/assets/user/${widget.user.id}.png",
                          placeholder: (context, url) =>
                              const LinearProgressIndicator(),
                          errorWidget: (context, url, error) =>
                              const Icon(Icons.error_outline_sharp)
                          ),
                      const SizedBox(height: 30),
                      Row(
                        children: const [
                          SizedBox(width: 10),
                          Text('Personal Profile',
                              style: TextStyle(
                                  fontSize: 20, fontWeight: FontWeight.w600)),
                        ],
                      ),
                      const SizedBox(height: 16),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.person, size: 20),
                          const SizedBox(width: 15),
                          Text('${data['name']}',
                              style: const TextStyle(fontSize: 15)),
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.email, size: 20),
                          const SizedBox(width: 15),
                          Text('${data['email']}',
                              style: const TextStyle(fontSize: 15)),
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.location_on, size: 20),
                          const SizedBox(width: 15),
                          Text('${data['address']}',
                              style: const TextStyle(fontSize: 15)),
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.phone, size: 20),
                          const SizedBox(width: 15),
                          Text('${data['phone_number']}',
                              style: const TextStyle(fontSize: 15)),
                        ],
                      ),
                      const SizedBox(height: 10),
                      const Divider(thickness: 2),
                      const SizedBox(height: 10),
                      Row(
                        children: const [
                          SizedBox(width: 10),
                          Text('Persona Preferences',
                              style: TextStyle(
                                  fontSize: 20, fontWeight: FontWeight.w600)),
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.face, size: 20),
                          const SizedBox(width: 15),
                          Text('${data['name_persona']}',
                              style: const TextStyle(fontSize: 15)),
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.emoji_people, size: 20),
                          const SizedBox(width: 15),
                          Text('${data['persona_type']}',
                              style: const TextStyle(fontSize: 15)),
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.checklist, size: 20),
                          const SizedBox(width: 15),
                          Expanded(
                            child: Text('${data['persona_activity']}',
                                style: const TextStyle(fontSize: 15)),
                          )
                        ],
                      ),
                      const SizedBox(height: 10),
                      const Divider(thickness: 2),
                      const SizedBox(height: 10),
                      Row(
                        children: const [
                          SizedBox(width: 10),
                          Text('Personal Preferences',
                              style: TextStyle(
                                  fontSize: 20, fontWeight: FontWeight.w600)),
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.favorite, size: 20),
                          const SizedBox(width: 15),
                          Expanded(
                            child: Text('${data['interest']}',
                                style: const TextStyle(fontSize: 15)),
                          )
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.cabin, size: 20),
                          const SizedBox(width: 15),
                          Expanded(
                            child: Text('${data['accommodation_style']}',
                                style: const TextStyle(fontSize: 15)),
                          )
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.luggage, size: 20),
                          const SizedBox(width: 15),
                          Expanded(
                            child: Text('${data['travel_style']}',
                                style: const TextStyle(fontSize: 15)),
                          )
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.money, size: 20),
                          const SizedBox(width: 15),
                          Expanded(
                            child: Text('${data['budget']}',
                                style: const TextStyle(fontSize: 15)),
                          )
                        ],
                      ),
                      const SizedBox(height: 10),
                      Row(
                        children: [
                          const SizedBox(width: 15),
                          const Icon(Icons.location_pin, size: 20),
                          const SizedBox(width: 15),
                          Expanded(
                            child: Text('${data['destination_preference']}',
                                style: const TextStyle(fontSize: 15)),
                          )
                        ],
                      ),
                    ],
                  ),
                );
              },
            ),
    );
  }
}
