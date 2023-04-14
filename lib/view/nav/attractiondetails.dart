// ignore_for_file: avoid_print, deprecated_member_use
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/model/attraction.dart';
import 'package:flutter_trippintrip/model/config.dart';
import 'package:flutter_trippintrip/model/user.dart';
import 'package:url_launcher/url_launcher.dart';

class AttractionDetails extends StatefulWidget {
  final Attraction attraction;
  final User user;
  const AttractionDetails(
      {Key? key, required this.attraction, required this.user})
      : super(key: key);

  @override
  State<AttractionDetails> createState() => _AttractionDetailsState();
}

class _AttractionDetailsState extends State<AttractionDetails> {
  List attractionList = [];
  int attNum = 0;
  List _trips = [];
  final Uri _url = Uri.parse(
      'https://www.klook.com/en-MY/search/result/?query=habitat%20penang&spm=SearchResult.SearchSuggest_LIST&clickId=d8ab27c843');

  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text(widget.attraction.att_name!.toUpperCase()),
        ),
        body: LayoutBuilder(
          builder: (BuildContext context, BoxConstraints constraints) {
            final resWidth = constraints.maxWidth * 0.70;
            final screenHeight = constraints.maxHeight;
            return Center(
              child: SingleChildScrollView(
                child: Padding(
                  padding: const EdgeInsets.all(20.0),
                  child: Column(
                    children: [
                      SizedBox(
                        width: resWidth * 2,
                        height: screenHeight * 0.6,
                        child: ListView.builder(
                          scrollDirection: Axis.horizontal,
                          itemCount: 5,
                          itemBuilder: (BuildContext context, int index) {
                            return Container(
                              width: 300,
                              height: 300,
                              margin: const EdgeInsets.all(10),
                              child: CachedNetworkImage(
                                fit: BoxFit.cover,
                                imageUrl:
                                    "${Config.server}/trippintrip/assets/attraction/${widget.attraction.att_id!}_${index + 1}.png",
                                placeholder: (context, url) =>
                                    const LinearProgressIndicator(),
                                errorWidget: (context, url, error) =>
                                    const Icon(Icons.error_outline_sharp),
                              ),
                            );
                          },
                        ),
                      ),
                      SizedBox(height: screenHeight * 0.03),
                      Row(
                        children: [
                          const Icon(Icons.money_rounded, size: 25),
                          SizedBox(width: resWidth * 0.05),
                          Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                "Estimated Price:",
                                style: TextStyle(
                                  fontSize: resWidth * 0.05,
                                ),
                              ),
                              Text(
                                widget.attraction.att_price!,
                                style: TextStyle(
                                  fontSize: resWidth * 0.05,
                                ),
                              ),
                            ],
                          ),
                        ],
                      ),
                      SizedBox(height: screenHeight * 0.03),
                      Row(
                        children: [
                          const Icon(Icons.category),
                          SizedBox(width: resWidth * 0.05),
                          Flexible(
                            child: Text(
                              widget.attraction.att_category!,
                              style: TextStyle(
                                fontSize: resWidth * 0.05,
                              ),
                            ),
                          ),
                        ],
                      ),
                      SizedBox(height: screenHeight * 0.03),
                      Row(
                        children: [
                          const Icon(Icons.location_city),
                          SizedBox(width: resWidth * 0.05),
                          Flexible(
                            child: Text(
                              widget.attraction.att_location!,
                              style: TextStyle(
                                fontSize: resWidth * 0.05,
                              ),
                            ),
                          ),
                        ],
                      ),
                      SizedBox(height: screenHeight * 0.03),
                      Row(
                        children: [
                          const Icon(Icons.access_time),
                          SizedBox(width: resWidth * 0.05),
                          Flexible(
                            child: Text(
                              "Time: ${widget.attraction.att_opening!} - ${widget.attraction.att_closing!}",
                              style: TextStyle(
                                fontSize: resWidth * 0.05,
                              ),
                            ),
                          ),
                        ],
                      ),
                      SizedBox(height: screenHeight * 0.03),
                      Row(
                        children: [
                          const Icon(Icons.description),
                          SizedBox(width: resWidth * 0.05),
                          Flexible(
                            child: Text(
                              widget.attraction.att_desc!,
                              style: TextStyle(
                                fontSize: resWidth * 0.05,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
            );
          },
        ),
        bottomNavigationBar: BottomNavigationBar(
          type: BottomNavigationBarType.fixed,
          backgroundColor: Colors.white,
          unselectedFontSize: 14,
          selectedFontSize: 14,
          selectedItemColor: Colors.black54,
          unselectedItemColor: Colors.black54,
          showUnselectedLabels: true,
          showSelectedLabels: true,
          elevation: 0,
          items: const [
            BottomNavigationBarItem(
                icon: Icon(Icons.calendar_month, color: Colors.black),
                label: "Book Now"),
            BottomNavigationBarItem(
                icon: Icon(Icons.add, color: Colors.black),
                label: "Add to Plan"),
          ],
          onTap: (int index) {
            switch (index) {
              case 0:
                _launchUrl;
                break;
              case 1:
                showDialog(
                  context: context,
                  builder: (BuildContext context) {
                    return AlertDialog(
                      title: const Text("Add to Plan"),
                      content: const Text(
                          "Do you want to add this attraction to your plan?"),
                      actions: <Widget>[
                        TextButton(
                          child: const Text("CANCEL"),
                          onPressed: () {
                            Navigator.of(context).pop();
                          },
                        ),
                        TextButton(
                          child: const Text("ADD"),
                          onPressed: () {
                            // Show dialog to select trip plan
                            showDialog(
                              context: context,
                              builder: (BuildContext context) {
                                return AlertDialog(
                                  title: const Text('Select a Trip Plan'),
                                  content: SingleChildScrollView(
                                    child: ListBody(
                                      children: _trips.map((trip) {
                                        return GestureDetector(
                                          child: Text(trip['trip_name']),
                                          onTap: () {
                                            // Add attraction to selected trip plan
                                            _addAttractionToPlan(
                                                trip['trip_id']);
                                            Navigator.of(context).pop();
                                          },
                                        );
                                      }).toList(),
                                    ),
                                  ),
                                );
                              },
                            );
                          },
                        ),
                      ],
                    );
                  },
                );
                break;
            }
          },
        ));
  }

  Future<void> _launchUrl() async {
    if (!await launchUrl(_url)) {
      throw Exception('Could not launch $_url');
    }
  }

  void _addAttractionToPlan(trip) {}
}
