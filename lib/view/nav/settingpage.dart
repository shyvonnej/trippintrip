// ignore_for_file: use_build_context_synchronously

import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/model/config.dart';
import 'package:flutter_trippintrip/view/login%20and%20reg/loginpage.dart';
import 'package:flutter_trippintrip/view/nav/profilepage.dart';
import 'package:fluttertoast/fluttertoast.dart';
import '../../model/user.dart';

class Setting extends StatefulWidget {
  final User user;
  const Setting({Key? key, required this.user}) : super(key: key);

  @override
  State<Setting> createState() => _SettingState();
}

class _SettingState extends State<Setting> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: const Text('TrippinTrip'),
        ),
        body: Center(
            child: Column(
          children: [
            Flexible(flex: 5, child: Container(color: Colors.blueGrey[900])),
            Flexible(
                flex: 5,
                child: Column(
                  children: [
                    Container(
                        color: Colors.tealAccent,
                        child: const Center(
                            child: Text(
                          "SETTINGS",
                          style: TextStyle(
                              fontSize: 24,
                              fontWeight: FontWeight.bold,
                              color: Colors.black87),
                        ))),
                    Expanded(
                        child: ListView(
                            padding: const EdgeInsets.fromLTRB(10, 5, 10, 5),
                            shrinkWrap: true,
                            children: [
                          MaterialButton(
                            onPressed: _profilepage,
                            child: const Text("PROFILE"),
                          ),
                          const Divider(
                            height: 2,
                            color: Colors.tealAccent,
                          ),
                          // ignore: prefer_const_constructors
                          MaterialButton(
                            onPressed: null,
                            child: const Text("NEW PLAN"),
                          ),
                          const Divider(
                            height: 2,
                            color: Colors.tealAccent,
                          ),
                          const MaterialButton(
                            onPressed: null,
                            child: Text("REPORT BUG"),
                          ),
                          const Divider(
                            height: 2,
                            color: Colors.tealAccent,
                          ),
                          const MaterialButton(
                            onPressed: null,
                            child: Text("DELETE ACCOUNT"),
                          ),
                          const Divider(
                            height: 2,
                            color: Colors.tealAccent,
                          ),
                          MaterialButton(
                            onPressed: () async {
                              // Perform logout actions here (e.g. clear user session)
                              await clearUserSession();
                              Navigator.pushReplacement(
                                context,
                                MaterialPageRoute(
                                    builder: (context) => const LoginPage()),
                              );
                            },
                            child: const Text("LOG OUT"),
                          ),
                          const Divider(
                            height: 2,
                            color: Colors.tealAccent,
                          ),
                        ]))
                  ],
                ))
          ],
        )));
  }

  void _profilepage() {
    if (widget.user.email == "na") {
      Fluttertoast.showToast(
          msg: "Can be access after login.",
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          textColor: Colors.red,
          fontSize: 14.0);
      return;
    }
    Navigator.push(
        context,
        MaterialPageRoute(
            builder: (BuildContext context) => ProfilePage(user: widget.user)));
  }

  Future<void> clearUserSession() async {
    // Define the URL of the PHP file
    final url = 
        Uri.parse('${Config.server}/trippintrip/php/logout.php');
  }

  // void _deleteaccount(){
  //   showDialog(context: context, builder: (BuildContext context){
  //     return AlertDialog(
  //       shape: const RoundedRectangleBorder(
  //         borderRadius: BorderRadius.all(Radius.circular(20.0))
  //       ),
  //       title: const Text("Delete Account", style: TextStyle(color: Colors.white)),
  //       content: const Text("Are you sure?", style: TextStyle(color: Colors.white)),
  //       actions: <Widget>[TextButton(
  //         onPressed: _confirmdelete,
  //         child: const Text("Yes", style: TextStyle(color: Colors.tealAccent))),
  //         TextButton(
  //           child: const Text("No", style: TextStyle(color: Colors.tealAccent)),
  //           onPressed:(){
  //             Navigator.of(context).pop();
  //           }
  //         )]
  //     );
  //   });
  // }

  // void _confirmdelete(){
  //   ProgressDialog progressDialog = ProgressDialog(context,
  //   message: const Text("Deleting in progress.."),
  //   title: const Text("Delete Account..."));
  //   progressDialog.show();

  //   http.post(Uri.parse(Config.server + "/trippintrip/php/deleteaccount.php"),
  //   body: {}).then((response)
  //   {
  //     var data = jsonDecode(response.body);
  //     if(response.statusCode == 200 && data['status'] == 'success'){
  //       Fluttertoast.showToast(
  //         msg: "Delete Success",
  //         toastLength: Toast.LENGTH_SHORT,
  //         gravity: ToastGravity.BOTTOM,
  //         timeInSecForIosWeb: 1,
  //         fontSize: 14.0);
  //         progressDialog.dismiss();
  //         Navigator.push(context, MaterialPageRoute(builder: (context) => const RegisterPage()));
  //         return;
  //     } else {
  //       Fluttertoast.showToast(
  //         msg: "Registration Failed",
  //         toastLength: Toast.LENGTH_SHORT,
  //         gravity: ToastGravity.BOTTOM,
  //         timeInSecForIosWeb: 1,
  //         fontSize: 14.0);
  //         progressDialog.dismiss();
  //         return;
  //     }
  //   });
  // }
}
