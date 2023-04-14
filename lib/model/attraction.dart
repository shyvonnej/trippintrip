// ignore_for_file: non_constant_identifier_names

class Attraction { 
  String? att_id; 
  String? att_name; 
  String? att_category; 
  String? att_location; 
  String? att_opening; 
  String? att_closing;
  String? att_price;
  String? att_desc;
   String? state_id; 

Attraction({
  required this.att_id,
  required this.att_name, 
  required this.att_category, 
  required this.att_location,  
  required this.att_opening, 
  required this.att_closing,
  required this.att_price,
  required this.att_desc,
  required this.state_id});

Attraction.fromJson(Map<String, dynamic> json) { 
  att_id = json['attractions']['att_id'];
  att_name = json['attractions']['att_name']; 
  att_category = json['attractions']['att_category'];
  att_location = json['attractions']['att_location'];
  att_opening = json['attractions']['att_opening'];
  att_closing = json['attractions']['att_closing'];
  att_price = json['attractions']['att_price'];
  att_desc = json['attractions']['att_desc'];
  state_id = json['attractions']['state_id'];
  }

  Map<String, dynamic> toJson() {
 final Map<String, dynamic> data = <String, dynamic>{};
    data['att_id'] = att_id;
    data['att_name'] = att_name;
    data['att_category'] = att_category;
    data['att_location'] = att_location;
    data['att_opening'] = att_opening;
    data['att_closing'] = att_closing;
    data['att_price'] = att_price;
    data['att_desc'] = att_desc;
    data['state_id'] = state_id;
    return data;
  }
}