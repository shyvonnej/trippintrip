import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/model/config.dart';
import 'package:flutter_trippintrip/model/user.dart';
import 'package:flutter_trippintrip/view/nav/mainpage.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:intl/intl.dart';
import 'package:http/http.dart' as http;

class AddTripPage extends StatefulWidget {
  final User user;
  const AddTripPage({Key? key, required this.user}) : super(key: key);

  @override
  State<AddTripPage> createState() => _AddTripPageState();
}

class _AddTripPageState extends State<AddTripPage> {
  final _formKey = GlobalKey<FormState>();
  final TextEditingController _nameController = TextEditingController();
  final TextEditingController _descriptionController = TextEditingController();
  final TextEditingController _locationController = TextEditingController();
  final TextEditingController _startDateController = TextEditingController();
  final TextEditingController _endDateController = TextEditingController();

  DateTime _startDate = DateTime.now();
  DateTime _endDate = DateTime.now();

  Future<void> _selectStartDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: _startDate,
      firstDate: DateTime(2015, 8),
      lastDate: DateTime(2101),
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
      firstDate: DateTime(2015, 8),
      lastDate: DateTime(2101),
    );
    if (picked != null && picked != _endDate) {
      setState(() {
        _endDate = picked;
        _endDateController.text = DateFormat('yyyy-MM-dd').format(_endDate);
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Add New Trip Plan'),
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
                      return 'Please enter a name';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16.0),
                TextFormField(
                  controller: _descriptionController,
                  decoration: const InputDecoration(labelText: 'Description'),
                  validator: (value) {
                    if (value == null || value.isEmpty) {
                      return 'Please enter a description';
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
                      return 'Please enter a location';
                    }
                    return null;
                  },
                ),
                const SizedBox(height: 16.0),
                InkWell(
                  onTap: () => _selectStartDate(context),
                  child: IgnorePointer(
                    child: TextFormField(
                      controller: _startDateController,
                      decoration:
                          const InputDecoration(labelText: 'Start Date'),
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Please select a start date';
                        }
                        return null;
                      },
                    ),
                  ),
                ),
                const SizedBox(height: 16.0),
                InkWell(
                  onTap: () => _selectEndDate(context),
                  child: IgnorePointer(
                    child: TextFormField(
                      controller: _endDateController,
                      decoration: const InputDecoration(labelText: 'End Date'),
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Please select an end date';
                        }
                        return null;
                      },
                    ),
                  ),
                ),
                const SizedBox(height: 16.0),
                ElevatedButton(
                  onPressed: () {
                    if (_formKey.currentState!.validate()) {
// TODO: Save the trip plan
                      Navigator.pop(context);
                      http.post(
                          Uri.parse(
                              "${Config.server}/trippintrip/php/addtripplan.php"),
                          body: {
                            "user_id": widget.user.id,
                            "trip_name": _nameController.text,
                            "trip_desc": _descriptionController.text,
                            "trip_location": _locationController.text,
                            "start_date": _startDate.toString(),
                            "end_date": _endDate.toString(),
                          }).then((response) {
                        var data = jsonDecode(response.body);
                        print(data);
                        if (response.statusCode == 200 &&
                            data['status'] == 'success') {
                          Navigator.push(
                              context,
                              MaterialPageRoute(
                                  builder: (context) =>
                                      MainPage(user: widget.user)));
                          Fluttertoast.showToast(
                              msg: "Success",
                              toastLength: Toast.LENGTH_SHORT,
                              gravity: ToastGravity.BOTTOM,
                              timeInSecForIosWeb: 1,
                              textColor: Colors.green,
                              fontSize: 14.0);
                          // setState(() {
                          //   widget.user.name = _nameController.text;
                          //   widget.user.phone = _descriptionController.text;
                          //   widget.user.address = _locationController.text;
                          //   widget.trips.start_date = _startDateController;
                          //   widget.trips.end_date = _endDateController;
                          // });
                        } else {
                          Fluttertoast.showToast(
                              msg: "Failed",
                              toastLength: Toast.LENGTH_SHORT,
                              gravity: ToastGravity.BOTTOM,
                              timeInSecForIosWeb: 1,
                              textColor: Colors.red,
                              fontSize: 14.0);
                        }
                      });
                    }
                  },
                  child: const Text('Save'),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
