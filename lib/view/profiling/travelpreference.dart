import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/model/config.dart';
import 'package:flutter_trippintrip/view/nav/mainpage.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:http/http.dart' as http;
import 'package:flutter_trippintrip/model/user.dart';

class TravelPreferencesPage extends StatefulWidget {
  final User user;
  const TravelPreferencesPage({Key? key, required this.user}) : super(key: key);

  @override
  State<TravelPreferencesPage> createState() => _TravelPreferencesPageState();
}

class _TravelPreferencesPageState extends State<TravelPreferencesPage> {
  // Define variables to store user preferences
  String? _interest;
  String? _accommodationStyle;
  double _budget = 0;
  String? _travelStyle;
  String? _destinationPreferences;

  // Define lists for dropdown menus
  final List<String> _interestOptions = [
    'Adventure',
    'Beaches',
    'Culture',
    'Nature',
    'Relaxation',
    'Shopping',
    'Sightseeing'
  ];
  final List<String> _accommodationStyleOptions = [
    'Hotel',
    'Hostel',
    'Resort',
    'Vacation Rental',
    'Camping',
    'Glamping'
  ];
  final List<String> _travelStyleOptions = [
    'Backpacking',
    'Luxury',
    'Solo',
    'Group',
    'Family',
    'Couples'
  ];
  final List<String> _destinationPreferencesOptions = [
    'Penang',
    'Kedah',
    'Perlis',
    'Pahang',
    'Kelantan',
    'Johor',
    'Kuala Lumpur',
    'Negeri Sembilan',
    'Terengganu',
    'Sabah',
    'Sarawak',
    'Perak',
    'Melaka',
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Travel Preferences'),
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Text(
                'Select your interests:',
                style: TextStyle(fontSize: 18.0, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 8.0),
              DropdownButtonFormField<String>(
                value: _interest,
                items: _interestOptions.map((interest) {
                  return DropdownMenuItem<String>(
                    value: interest,
                    child: Text(interest),
                  );
                }).toList(),
                onChanged: (value) {
                  setState(() {
                    _interest = value!;
                  });
                },
              ),
              const SizedBox(height: 16.0),
              const Text(
                'Select your preferred accommodation style:',
                style: TextStyle(fontSize: 18.0, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 8.0),
              DropdownButtonFormField<String>(
                value: _accommodationStyle,
                items: _accommodationStyleOptions.map((accommodationStyle) {
                  return DropdownMenuItem<String>(
                    value: accommodationStyle,
                    child: Text(accommodationStyle),
                  );
                }).toList(),
                onChanged: (value) {
                  setState(() {
                    _accommodationStyle = value!;
                  });
                },
              ),
              const SizedBox(height: 16.0),
              const Text(
                'Select your budget:',
                style: TextStyle(fontSize: 18.0, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 8.0),
              Slider(
                value: _budget,
                activeColor: Colors.purple,
                inactiveColor: Colors.purple.shade100,
                thumbColor: Colors.blue.shade900,
                min: 0,
                max: 10000,
                divisions: 100,
                onChanged: (value) {
                  setState(() {
                    _budget = value;
                  });
                },
                label: _budget.toStringAsFixed(2),
              ),
              const SizedBox(height: 16.0),
              const Text(
                'Select your preferred travel style:',
                style: TextStyle(fontSize: 18.0, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 8.0),
              DropdownButtonFormField<String>(
                value: _travelStyle,
                items: _travelStyleOptions.map((travelStyle) {
                  return DropdownMenuItem<String>(
                    value: travelStyle,
                    child: Text(travelStyle),
                  );
                }).toList(),
                onChanged: (value) {
                  setState(() {
                    _travelStyle = value!;
                  });
                },
              ),
              const SizedBox(height: 16.0),
              const Text(
                'Select your destination preferences:',
                style: TextStyle(fontSize: 18.0, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 8.0),
              DropdownButtonFormField<String>(
                value: _destinationPreferences,
                items: _destinationPreferencesOptions.map((destination) {
                  return DropdownMenuItem<String>(
                    value: destination,
                    child: Text(destination),
                  );
                }).toList(),
                onChanged: (value) {
                  setState(() {
                    _destinationPreferences = value!;
                  });
                },
              ),
              const SizedBox(height: 32.0),
              Center(
                child: ElevatedButton(
                  child: const Text('Save'),
                  onPressed: () {
                    _savePreferences(
                        widget.user.id.toString(),
                        _interest!,
                        _accommodationStyle!,
                        _budget.toString(),
                        _travelStyle!,
                        _destinationPreferences!);
                    Navigator.of(context).pop();
                    Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) =>
                              MainPage(user: widget.user),
                        ));
                  },
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Future<void> _savePreferences(
      String userId,
      String interest,
      String accommodation,
      String budget,
      String travelstyle,
      String destinationpreferences) async {
    // Define the URL of the PHP file
    final url =
        Uri.parse('${Config.server}/trippintrip/php/travelpreferences.php');
    // Make the HTTP POST request with the user preferences data
    final response = await http.post(
      url,
      body: {
        'user_id': userId.toString(),
        'interests': interest.toString(),
        'accommodation': accommodation.toString(),
        'budget': budget.toString(),
        'travel_style': travelstyle.toString(),
        'destination_preferences': destinationpreferences.toString(),
      },
    );

    // Check the response status code
    if (response.statusCode == 200) {
      // Data saved successfully
      print('Travelling preference updated successfully');
      Fluttertoast.showToast(
              msg: "Travelling preferences successfully updated.",
              toastLength: Toast.LENGTH_LONG, 
              gravity: ToastGravity.BOTTOM,
              timeInSecForIosWeb: 1, 
              textColor: Colors.green[200],
              fontSize: 14);
    } else {
      // Data save failed
      print('Error updating travelling preference');
      Fluttertoast.showToast(
          msg: "Travelling preferences fail to update. Please try again.",
          toastLength: Toast.LENGTH_LONG, 
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1, 
          textColor: Colors.red[800],
          fontSize: 14);
    }
  }
}
