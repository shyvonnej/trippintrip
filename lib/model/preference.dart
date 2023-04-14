// ignore_for_file: non_constant_identifier_names

class Preferences{ 
  String? interest; 
  String? accommodation; 
  double? budget; 
  String? travel_style; 
  String? destination_preferences; 

Preferences({
  required this.interest,
  required this.accommodation, 
  required this.budget, 
  required this.travel_style, 
  required this.destination_preferences,});

Preferences.fromJson(Map<String, dynamic> json) { 
  interest = json['interest'];
  accommodation = json['accommodation']; 
  budget = json['budget']; 
  travel_style = json['travel_style'];
  destination_preferences = json['destination_preferences'];
  }
}