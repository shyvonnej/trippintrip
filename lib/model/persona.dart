class Persona{
  String? personaid;
  String? personaname;
  String? personatype;
  String? personadesc;
  String? personaimage;
  String? personaactivity;

  Persona(
    {
      required this.personaid,
      required this.personaname,
      required this.personatype,
      required this.personadesc,
      required this.personaimage,
      required this.personaactivity,
    }
  );

    Persona.fromJson(Map<String, dynamic> json){
    personaid = json['persona']['personaid'];
    personaname = json['persona']['personaname'];
    personatype = json['persona']['personatype'];
    personadesc = json['persona']['personadesc'];
    personaimage = json['persona']['personaimage'];
    personaactivity = json['persona']['personaactivity'];
  }
  
  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = <String, dynamic>{};
    data['personaid'] = personaid;
    data['personaname'] = personaname;
    data['personatype'] = personatype;
    data['personadesc'] = personadesc;
    data['personaimage'] = personaimage;
    data['personaactivity'] = personaactivity;
    return data;
  }
}