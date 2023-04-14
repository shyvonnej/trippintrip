import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/model/trips.dart';
import 'package:flutter_trippintrip/model/user.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

import 'package:intl/intl.dart';

class EditTripPage extends StatefulWidget {
  final Trips trips;
  final User user;
  const EditTripPage({super.key, required this.trips, required this.user});

  @override
  _EditTripPageState createState() => _EditTripPageState();
}

class _EditTripPageState extends State<EditTripPage> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  final TextEditingController _nameController = TextEditingController();
  final TextEditingController _descriptionController = TextEditingController();
  final TextEditingController _locationController = TextEditingController();
  final TextEditingController _startDateController = TextEditingController();
  final TextEditingController _endDateController = TextEditingController();
  late DateTime _startDate;
  late DateTime _endDate;

  @override
  void initState() {
    super.initState();
    _nameController.text = widget.trips.trip_name!;
    _descriptionController.text = widget.trips.trip_desc!;
    _locationController.text = widget.trips.trip_location!;
    _startDate = DateTime.parse(widget.trips.start_date!);
    _endDate = DateTime.parse(widget.trips.end_date!);
    _startDateController.text = DateFormat('yyyy-MM-dd').format(_startDate);
    _endDateController.text = DateFormat('yyyy-MM-dd').format(_endDate);
  }

  Future<void> _selectStartDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: _startDate,
      firstDate: DateTime(2000),
      lastDate: DateTime(2100),
    );
    if (picked != null && picked != _startDate) {
      setState(() {
        _startDate = picked;
        _startDateController.text = DateFormat('yyyy-MM-dd').format(_startDate);
      });
    }
  }

  Future<void> _selectEndDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: _endDate,
      firstDate: DateTime(2000),
      lastDate: DateTime(2100),
    );
    if (picked != null && picked != _endDate) {
      setState(() {
        _endDate = picked;
        _endDateController.text = DateFormat('yyyy-MM-dd').format(_endDate);
      });
    }
  }

  Future<bool> updateTrips(Trips trips) async {
    final url = Uri.parse('https://example.com/updatetrips.php');
    final response = await http.post(
      url,
      body: {
        'trip_id': trips.trip_id.toString(),
        'user_id': trips.user_id.toString(),
        'name': trips.trip_name,
        'description': trips.trip_desc,
        'location': trips.trip_location,
        'startDate': trips.start_date.toString(),
        'endDate': trips.end_date.toString(),
      },
    );
    final responseData = json.decode(response.body);
    if (responseData['status'] == 'success') {
      return true;
    } else {
      throw Exception('Failed to update trip');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Edit Trip'),
      ),
      body: Form(
        key: _formKey,
        child: SingleChildScrollView(
          child: Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                TextFormField(
                    controller: _nameController,
                    decoration: const InputDecoration(labelText: 'Name'),
                    validator: (value) {
                      if (value == null || value.isEmpty) {
                        return 'Please enter a trip name';
                      }
                      return null;
                    }),
                const SizedBox(height: 16.0),
                TextFormField(
                  controller: _descriptionController,
                  decoration: const InputDecoration(labelText: 'Description'),
                  maxLines: 3,
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please enter a trip description';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16.0),
                TextFormField(
                  controller: _locationController,
                  decoration: const InputDecoration(labelText: 'Location'),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please enter a trip location';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16.0),
                TextFormField(
                  controller: _startDateController,
                  decoration: const InputDecoration(
                    labelText: 'Start Date (yyyy-mm-dd)',
                    suffixIcon: Icon(Icons.calendar_today),
                  ),
                  onTap: () => _selectStartDate(context),
                  readOnly: true,
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please select a start date';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16.0),
                TextFormField(
                  controller: _endDateController,
                  decoration: const InputDecoration(
                    labelText: 'End Date (yyyy-mm-dd)',
                    suffixIcon: Icon(Icons.calendar_today),
                  ),
                  onTap: () => _selectEndDate(context),
                  readOnly: true,
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please select an end date';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 32.0),
                ElevatedButton(
                  onPressed: () {
                    if (_formKey.currentState!.validate()) {
                      final updatedTrip = Trips(
                        trip_id: widget.trips.trip_id,
                        user_id: widget.user.id,
                        trip_name: _nameController.text.trim(),
                        trip_desc: _descriptionController.text.trim(),
                        trip_location: _locationController.text.trim(),
                        start_date: _startDate.toString(),
                        end_date: _endDate.toString(),
                        total_cost: '',
                      );
                      updateTrips(updatedTrip).then((result) {
                        if (result) {
                          Fluttertoast.showToast(
                            msg: 'Trip updated successfully',
                            toastLength: Toast.LENGTH_SHORT,
                            gravity: ToastGravity.BOTTOM,
                            backgroundColor: Colors.green,
                            textColor: Colors.white,
                          );
                          Navigator.pop(context);
                        }
                      }).catchError((error) {
                        Fluttertoast.showToast(
                          msg: error.toString(),
                          toastLength: Toast.LENGTH_SHORT,
                          gravity: ToastGravity.BOTTOM,
                          backgroundColor: Colors.red,
                          textColor: Colors.white,
                        );
                      });
                    }
                  },
                  child: const Text('Update Trip'),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
