// ignore_for_file: depend_on_referenced_packages, no_leading_underscores_for_local_identifiers, prefer_interpolation_to_compose_strings, use_build_context_synchronously

import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/view/login%20and%20reg/changepassword.dart';
import 'package:flutter_trippintrip/view/profiling/completeprofile.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:http/http.dart' as http;
import 'package:ndialog/ndialog.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../../model/config.dart';
import '../../model/user.dart';
import '../nav/mainpage.dart';
import 'registerpage.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({Key? key}) : super(key: key);

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  late double screenHeight, screenWidth;
  final _formKey = GlobalKey<FormState>();
  bool _isChecked = false;

  final focus = FocusNode();
  final focus1 = FocusNode();
  final focus2 = FocusNode();

  final TextEditingController _emailEditingController = TextEditingController();
  final TextEditingController _passwordEditingController = TextEditingController();

  @override
  void initState() { 
    super.initState(); 
    loadPref();
  }

  @override
  Widget build(BuildContext context) {
    screenHeight = MediaQuery.of(context).size.height;
    screenWidth = MediaQuery.of(context).size.width;
    return Scaffold(
      body: Stack(
        children: [upperHalf(context), lowerHalf(context)],
      ),
    );
  }

  upperHalf(BuildContext context) {
    return SizedBox(
      height: screenHeight/1.8,
      width: screenWidth,
      child: Image.asset('assets/images/login.jpg', fit: BoxFit.cover),
      );
  }

  lowerHalf(BuildContext context) {
    return Container(
      height: 600,
      margin: EdgeInsets.only(top: screenHeight/3),
      padding: const EdgeInsets.only(left: 10, right: 10), 
      child: SingleChildScrollView(
        child:
        Column(children: [
          Card(elevation: 40,
          child: Form(
            key: _formKey,
            child: Container(
              padding: const EdgeInsets.fromLTRB(25, 10, 20, 25),
              child: Column(children:[
                const SizedBox(height: 20,),
                const Text("Login Account", style: TextStyle(color: Colors.black, fontSize: 22, fontWeight: FontWeight.w600,)),
                const SizedBox(height: 20,),

                TextFormField(
                  textInputAction: TextInputAction.next,
                  validator: (val) => val!.isEmpty || !val.contains("@") || !val.contains(".")
                    ? "enter a valid email"
                    : null,
                  onFieldSubmitted: (v){
                    FocusScope.of(context).requestFocus(focus);
                  },
                  controller: _emailEditingController,
                  keyboardType: TextInputType.emailAddress,
                  cursorColor: Colors.grey[50],
                  decoration: const
                    InputDecoration(labelStyle: TextStyle(color: Colors.blueGrey,),
                    labelText: 'Email',
                    icon: Icon(Icons.mail, color: Colors.blueGrey,),
                    focusedBorder: OutlineInputBorder(
                      borderSide: BorderSide(width: 1.0, color: Colors.grey,),
                ))),
                
                TextFormField(
                  textInputAction: TextInputAction.next,
                  validator: (val) => val!.isEmpty ? "enter a password." : null,
                  focusNode: focus,
                  onFieldSubmitted: (v){
                    FocusScope.of(context).requestFocus(focus1);
                  },
                  controller: _passwordEditingController,
                  cursorColor: Colors.grey[50],
                  decoration:
                    const InputDecoration(labelStyle: TextStyle(color: Colors.blueGrey,),
                    labelText: 'Password',
                    icon: Icon(Icons.vpn_key, color: Colors.blueGrey,),
                    focusedBorder: OutlineInputBorder(
                      borderSide: BorderSide(width: 1.0, color: Colors.grey,),
                ))),

                const SizedBox(height: 20,),
                
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly, 
                  children: [
                  Checkbox(
                  value: _isChecked, 
                  onChanged: (bool? value) {
                  _onRememberMeChanged(value!);
                },
                ),
              const Flexible(
                child: Text('Remember me', style: TextStyle( fontSize: 16,
                fontWeight: FontWeight.bold,
              )),
            ),
            const SizedBox(width: 15),
          ElevatedButton(
            style: ElevatedButton.styleFrom(
            fixedSize: Size(screenWidth/3, 50)),
            onPressed: _loginUser,
            child: const Text('Login'),
            ),
          ]),
        ])
      ),)),
      const SizedBox(height: 20,),

      Row(
        mainAxisAlignment: MainAxisAlignment.center, children: <Widget>[
        const Text("Register new account? ", style: TextStyle(fontSize: 16.0, )), 
        GestureDetector(
        onTap: () => { Navigator.pushReplacement(context,
          MaterialPageRoute(
          builder: (BuildContext context) => const RegisterPage()))
          },
          child: const Text("Click here", style: TextStyle(
          fontSize: 16.0,
          fontWeight: FontWeight.bold,),
        ),
      )],
    ),
    const SizedBox( height: 10),
    Row(
      mainAxisAlignment: MainAxisAlignment.center, children: <Widget>[
      const Text("Forgot password?", style: TextStyle(fontSize: 16.0, )), GestureDetector(
      onTap: () => { Navigator.pushReplacement(context,
          MaterialPageRoute(
          builder: (BuildContext context) => const ChangePasswordScreen()))
          },
      child: const Text("Click here", style: TextStyle(
      fontSize: 16.0,
      fontWeight: FontWeight.bold,),
      ),),],),
      ])
    ));
  }

  void _loginUser() {
    FocusScope.of(context).requestFocus(FocusNode());
    if(!_formKey.currentState!.validate()){
      Fluttertoast.showToast(
        msg: "Please fill in the login credentials",
        toastLength: Toast.LENGTH_SHORT,
        gravity: ToastGravity.BOTTOM,
        timeInSecForIosWeb: 1,
        fontSize: 14.0);
        return;
    }
    ProgressDialog progressDialog = ProgressDialog(context,
        message: const Text("Please wait.."), 
        title: const Text("Login user"));
    progressDialog.show();
    String _email = _emailEditingController.text;
    String _password = _passwordEditingController.text;
    http.post(Uri.parse(Config.server + "/trippintrip/php/login.php"),
    body: {"email": _email, "password": _password}).then((response) async {
      if (response.statusCode == 200 && response.body != "failed") {
        final jsonResponse = json.decode(response.body);
        User user = User.fromJson(jsonResponse);
        print("isProfileComplete: ${user.isProfileComplete}"); 
        Fluttertoast.showToast(
          msg: "Login Success",
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          fontSize: 14.0);
          progressDialog.dismiss();
          if (user.isProfileComplete == false || user.isProfileComplete == null) {
          Navigator.pushReplacement(context,
          MaterialPageRoute(builder: (context) => CompleteProfilePage(user: user)),
          );
        } else {
          Navigator.pushReplacement(context,
          MaterialPageRoute(builder: (context) => MainPage(user: user)),
        );
      }
      } else {
        Fluttertoast.showToast(
            msg: "Login Failed",
            toastLength: Toast.LENGTH_SHORT,
            gravity: ToastGravity.BOTTOM,
            timeInSecForIosWeb: 1,
            fontSize: 14.0);
      }
      progressDialog.dismiss();
    }
    );
  }

  void saveremovepref(bool value) async{
    if (!_formKey.currentState!.validate()) {
      Fluttertoast.showToast(
          msg: "Please fill in the login credentials",
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          fontSize: 14.0);
      _isChecked = false;
      return;
    }
    FocusScope.of(context).requestFocus(FocusNode());
    String email = _emailEditingController.text;
    String password = _passwordEditingController.text;
    SharedPreferences prefs = await SharedPreferences.getInstance();
    if(value){
      //save preference
      if(!_formKey.currentState!.validate()){
        Fluttertoast.showToast(
          msg: "Please fill in the login credentials",
          toastLength: Toast.LENGTH_SHORT,
          gravity: ToastGravity.BOTTOM,
          timeInSecForIosWeb: 1,
          fontSize: 14.0);
          _isChecked = false;
          return;
      }
      await prefs.setString('email', email); 
      await prefs.setString('password', password);
      Fluttertoast.showToast(
        msg: "Preference Stored",
        toastLength: Toast.LENGTH_SHORT,
        gravity: ToastGravity.BOTTOM,
        timeInSecForIosWeb: 1,
        fontSize: 14.0);
    } else {
      // delete preference
      await prefs.setString('email', '');
      await prefs.setString('password', '');
      setState(() {
        _emailEditingController.text = '';
        _passwordEditingController.text = '';
        _isChecked = false;
      });
      Fluttertoast.showToast(
        msg: "Preference Removed",
        toastLength: Toast.LENGTH_SHORT,
        gravity: ToastGravity.BOTTOM,
        timeInSecForIosWeb: 1,
        fontSize: 14.0);
    }
  }

  void _onRememberMeChanged(bool newValue) => setState(() {
    _isChecked = newValue; 
    if (_isChecked) {
      saveremovepref(true);
    } else { 
      saveremovepref(false);
    }
  }
  );

  Future<void> loadPref() async {
    SharedPreferences prefs = await SharedPreferences.getInstance(); 
    String email = (prefs.getString('email')) ?? '';
    String password = (prefs.getString('password')) ?? ''; 
    if (email.length > 1) {
      setState(() {
        _emailEditingController.text = email;
        _passwordEditingController.text = password;
        _isChecked = true;
      });
    }
  }
}
