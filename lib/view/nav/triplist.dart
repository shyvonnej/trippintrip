import 'dart:convert';
import 'package:flutter_trippintrip/model/trips.dart';
import 'package:flutter_trippintrip/view/nav/addtrip.dart';
import 'package:flutter_trippintrip/view/nav/edittrip.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/model/config.dart';
import '../../model/user.dart';

class TripListPage extends StatefulWidget {
  final User user;

  const TripListPage({Key? key, required this.user}) : super(key: key);

  @override
  State<TripListPage> createState() => _TripListPageState();
}

class _TripListPageState extends State<TripListPage> {
  late double screenHeight, screenWidth;
  List _trips = [];
  int tripsNum = 0;

  @override
  void initState() {
    super.initState();
    getPlansForUser(widget.user.id!);
  }

  @override
  Widget build(BuildContext context) {
    screenHeight = MediaQuery.of(context).size.height;
    screenWidth = MediaQuery.of(context).size.width;
    return Scaffold(
      appBar: AppBar(title: const Text('Your Trip Plan')),
      body: SizedBox(
        height: screenHeight,
        child: ListView.builder(
  itemCount: _trips.length,
  itemBuilder: (BuildContext context, int index) {
    var trips = _trips[index];
    return Column(
      children: [
        SizedBox(
          height: 80,
          child: GestureDetector(
            onTap: () {
              _tripDetails(index);
            },
            child: ListTile(
              leading: const Icon(Icons.flight),
              title: Text(
                trips['trip_name'],
                style: const TextStyle(fontWeight: FontWeight.bold),
              ),
              subtitle: Text(trips['trip_desc']),
              trailing: IconButton(
                icon: const Icon(Icons.delete),
                onPressed: () => _deletePlan(trips['trip_id']),
              ),
            ),
          ),
        ),
        if (index != _trips.length - 1) const Divider(thickness: 2),
      ],
    );
  },
),

      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () => _addNewPlan(),
        child: const Icon(Icons.add),
      ),
    );
  }

  getPlansForUser(String userId) {
    http
        .post(Uri.parse(
            "${Config.server}/trippintrip/php/loadtripplans.php?user_id=$userId"))
        .then((response) {
      if (response.statusCode == 200 && response.body != "failed") {
        var parsedJson = json.decode(response.body);
        _trips = parsedJson['data']['trips'];
        setState(() {
          tripsNum = _trips.length;
        });
      }
    });
  }

  void _addNewPlan() {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => AddTripPage(user: widget.user),
      ),
    ).then((_) => _reloadPlans());
  }

  void _deletePlan(String trip_id) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Delete Plan'),
        content: const Text('Are you sure you want to delete this plan?'),
        actions: [
          TextButton(
            onPressed: () {
              Navigator.pop(context);
            },
            child: const Text('Cancel'),
          ),
          TextButton(
            onPressed: () {
              _doDeletePlan(trip_id);
              Navigator.pop(context);
            },
            child: const Text('Delete'),
          ),
        ],
      ),
    );
  }

  void _doDeletePlan(String trip_id) {
    http.post(Uri.parse('${Config.server}/trippintrip/php/deleteplan.php'),
        body: {
          'trip_id': trip_id,
        }).then((response) {
      if (response.statusCode == 200 && response.body == 'success') {
        Fluttertoast.showToast(
          msg: 'Plan deleted successfully',
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          fontSize: 14.0,
        );
        _reloadPlans();
      } else {
        Fluttertoast.showToast(
          msg: 'Failed to delete plan',
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          fontSize: 14.0,
        );
      }
    }).catchError((error) {
      Fluttertoast.showToast(
        msg: 'Failed to delete plan',
        toastLength: Toast.LENGTH_SHORT,
        gravity: ToastGravity.BOTTOM,
        timeInSecForIosWeb: 1,
        fontSize: 14.0,
      );
    });
  }

  Future<void> _reloadPlans() async {
    List<Map> trips = await getPlansForUser(widget.user.id!);
    setState(() {
      _trips = trips;
    });
  }

  void _tripDetails(int index) {
    Trips trips = Trips(
      trip_id: _trips[index]['trip_id'],
      user_id: _trips[index]['user_id'],
      trip_name: _trips[index]['trip_name'],
      trip_desc: _trips[index]['trip_desc'],
      trip_location: _trips[index]['trip_location'],
      start_date: _trips[index]['start_date'],
      end_date: _trips[index]['end_date'],
      total_cost: _trips[index]['total_cost'],
    );

    Navigator.push(
        context,
        MaterialPageRoute(
            builder: (BuildContext context) =>
                EditTripPage(trips: trips, user: widget.user)));
  }
}
