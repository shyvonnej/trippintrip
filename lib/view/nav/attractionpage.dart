import 'dart:convert';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/model/attraction.dart';
import 'package:flutter_trippintrip/model/config.dart';
import 'package:flutter_trippintrip/view/nav/attractiondetails.dart';
import 'package:http/http.dart' as http;
import '../../model/user.dart';

class TabPage1 extends StatefulWidget {
  final User user;
  const TabPage1({Key? key, required this.user}) : super(key: key);

  @override
  State<TabPage1> createState() => _TabPage1State();
}

class _TabPage1State extends State<TabPage1> {
  List attractionList = [];
  int attNum = 0;
  late ScrollController _scrollController;
  int scrollcount = 5;
  TextEditingController searchController = TextEditingController();
  String search = "all";

  //for pagination
  @override
  void initState() {
    super.initState();
    _scrollController = ScrollController();
    _scrollController.addListener(_scrollListener);
    _loadAttraction("all");
  }

  @override
  Widget build(BuildContext context) {
    late double screenHeight, screenWidth, resWidth;

    screenHeight = MediaQuery.of(context).size.height;
    screenWidth = MediaQuery.of(context).size.width;

    if (screenWidth <= 700) {
      resWidth = screenWidth;
    } else {
      resWidth = screenWidth * 0.75;
    }
    return Scaffold(
        appBar: AppBar(
          title: const Text(
            'TrippinTrip',
            style: TextStyle(
              fontSize: 20.0,
              fontWeight: FontWeight.bold,
              color: Colors.white,
            ),
          ),
          leading: Container(), // Remove the default back button
          actions: [
            IconButton(
              icon: const Icon(
                Icons.search,
                size: 24.0,
                color: Colors.white,
              ),
              onPressed: () {
                _loadSearchDialog();
              },
            ),
          ],
        ),
        body: Center(
            child: SizedBox(
                width: resWidth * 2,
                height: screenHeight,
                child: Padding(
                    padding: const EdgeInsets.all(20.0),
                    child: Column(children: [
                      Text(
                        "Attractions",
                        style: TextStyle(
                          fontSize: resWidth * 0.05,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      SizedBox(height: screenHeight * 0.035),
                      Expanded(
                        child: GridView.count(
                          crossAxisSpacing: 5,
                          mainAxisSpacing: 5,
                          crossAxisCount: 2,
                          children: List.generate(attNum, (index) {
                            return InkWell(
                              onTap: (() => {
                                    _showDetails(index),
                                  }),
                              child: Stack(
                                children: [
                                  SizedBox(
                                    height: 200,
                                    width: 200,
                                    child: CachedNetworkImage(
                                      fit: BoxFit.cover,
                                      imageUrl:
                                          "${Config.server + "/trippintrip/assets/attraction/" + attractionList[index]['att_id']+ "_1"}.png",
                                      placeholder: (context, url) =>
                                          const LinearProgressIndicator(),
                                      errorWidget: (context, url, error) =>
                                          const Icon(Icons.error_outline_sharp),
                                    ),
                                  ),
                                  Positioned(
                                    top: 0,
                                    left: 0,
                                    child: Container(
                                      width: 200,
                                      color: Colors.black54,
                                      padding: const EdgeInsets.all(10),
                                      child: Text(
                                        attractionList[index]['att_name'],
                                        style: const TextStyle(
                                          fontSize: 13,
                                          color: Colors.white,
                                        ),
                                        maxLines: 2,
                                        overflow: TextOverflow.ellipsis,
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                            );
                          }),
                        ),
                      )
                    ])))));
  }

  _loadAttraction(String search) {
    http
        .post(Uri.parse(
            "${Config.server}/trippintrip/php/loadattraction.php?search=$search"))
        .then((response) {
      if (response.statusCode == 200 && response.body != "failed") {
        var parsedJson = json.decode(response.body);
        attractionList = parsedJson['data']['attractions'];
        setState(() {
          attNum = attractionList.length;
        });
      }
    });
  }

  _showDetails(int index) async {
    Attraction attraction = Attraction(
      att_id: attractionList[index]['att_id'],
      att_name: attractionList[index]['att_name'],
      att_category: attractionList[index]['att_category'],
      att_location: attractionList[index]['att_location'],
      att_opening: attractionList[index]['att_opening'],
      att_closing: attractionList[index]['att_closing'],
      att_price: attractionList[index]['att_price'],
      att_desc: attractionList[index]['att_desc'],
      state_id: attractionList[index]['state_id'],
    );

    Navigator.push(
        context,
        MaterialPageRoute(
            builder: (BuildContext context) =>
                AttractionDetails(attraction: attraction, user: widget.user)));
  }

  void _scrollListener() {
    if (_scrollController.offset >=
            _scrollController.position.maxScrollExtent &&
        !_scrollController.position.outOfRange) {
      setState(() {
        if (attractionList.length > scrollcount) {
          scrollcount = scrollcount + 5;
          if (scrollcount > attractionList.length) {
            scrollcount = attractionList.length;
          }
        }
      });
    }
  }

  void _loadSearchDialog() {
    searchController.text = "";
    showDialog(
        context: context,
        builder: (BuildContext context) {
          // return object of type Dialog
          return StatefulBuilder(
            builder: (context, StateSetter setState) {
              return AlertDialog(
                title: const Text(
                  "Search ",
                ),
                content: SizedBox(
                  //height: screenHeight / 4,
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      TextField(
                        controller: searchController,
                        decoration: InputDecoration(
                            labelText: 'Search',
                            border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(5.0))),
                      ),
                      const SizedBox(height: 5),
                    ],
                  ),
                ),
                actions: [
                  ElevatedButton(
                    onPressed: () {
                      search = searchController.text;
                      Navigator.of(context).pop();
                      _loadAttraction(search);
                    },
                    child: const Text("Search"),
                  )
                ],
              );
            },
          );
        });
  }
}
