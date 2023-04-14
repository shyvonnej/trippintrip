// ignore_for_file: non_constant_identifier_names

class Trips { 
  String? trip_id; 
  String? user_id;
  String? trip_name;
  String? trip_desc;
  String? trip_location;
  String? start_date; 
  String? end_date; 
  String? total_cost; 

Trips({
  required this.trip_id,
  required this.user_id,
  required this.trip_name,
  required this.trip_desc,
  required this.trip_location,
  required this.start_date, 
  required this.end_date,  
  required this.total_cost,  
});

Trips.fromJson(Map<String, dynamic> json) { 
  trip_id = json['trip_id'];
  trip_name = json['trip_name'];
  trip_desc = json['trip_desc'];
  trip_location = json['trip_location'];
  start_date = json['start_date']; 
  end_date = json['end_date'];
  total_cost = json['total_cost'];
  }

  Map<String, dynamic> toJson() { 
    final Map<String, dynamic> data = <String, dynamic>{};
    data['trip_id'] = trip_id;
    data['trip_name'] = trip_name;
    data['trip_desc'] = trip_desc;
    data['trip_location'] = trip_location;
    data['start_date'] = start_date;
    data['end_date'] = end_date;
    data['total_cost'] = total_cost;
    return data;
  }
}