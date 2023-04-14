// ignore_for_file: avoid_print, prefer_interpolation_to_compose_strings
import 'dart:convert';
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter_trippintrip/view/profiling/personapage.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:image_picker/image_picker.dart';
import 'package:image_cropper/image_cropper.dart';
import 'package:http/http.dart' as http;
import '../../model/config.dart';
import '../../model/user.dart';

class CompleteProfilePage extends StatefulWidget {
  final User user;
  const CompleteProfilePage({Key? key, required this.user}) : super(key: key);

  @override
  State<CompleteProfilePage> createState() => _CompleteProfilePageState();
}

class _CompleteProfilePageState extends State<CompleteProfilePage> {
  late double screenHeight, screenWidth, resWidth;
  final focus = FocusNode();
  final focus1 = FocusNode();
  final focus2 = FocusNode();
  final focus3 = FocusNode();

  final TextEditingController _nameeditingController = TextEditingController();
  final TextEditingController _phoneeditingController = TextEditingController();
  final TextEditingController _addresseditingController =
      TextEditingController();

  String _name = '';
  String _phone = '';
  String _address = '';

  File? _image;
  var pathAsset = "assets/images/camera.jpg";
  @override
  void initState() {
    super.initState();
    _name = widget.user.name.toString();
    _phone = widget.user.phone.toString();
    _address = widget.user.address.toString();

    _nameeditingController.text = _name;
    _phoneeditingController.text = _phone;
    _addresseditingController.text = _address;
  }

  void _onNameSubmitted(String newName) {
    setState(() {
      _name = newName;
    });
  }

  void _onPhoneSubmitted(String newPhone) {
    setState(() {
      _phone = newPhone;
    });
  }

  void _onAddressSubmitted(String newAddress) {
    setState(() {
      _address = newAddress;
    });
  }

  @override
  Widget build(BuildContext context) {
    String base64Image = _image?.readAsBytesSync() != null
        ? base64Encode(_image!.readAsBytesSync())
        : '';

    screenHeight = MediaQuery.of(context).size.height;
    screenWidth = MediaQuery.of(context).size.width;
    if (screenWidth <= 600) {
      resWidth = screenWidth;
    } else {
      resWidth = screenWidth * 0.75;
    }

    return Scaffold(
        appBar: AppBar(
          leading: const CloseButton(),
          title: const Text("Complete Your Profile"),
          actions: [
            IconButton(
              icon: const Icon(Icons.check),
              onPressed: () {
                Navigator.of(context).pop();
                widget.user.isProfileComplete = true;
                http.post(
                    Uri.parse(
                        Config.server + "/trippintrip/php/updateprofile.php"),
                    body: {
                      "name": _nameeditingController.text,
                      "phone": _phoneeditingController.text,
                      "address": _addresseditingController.text,
                      "image": base64Image,
                      "userid": widget.user.id
                    }).then((response) {
                  var data = jsonDecode(response.body);
                  print(data);
                  if (response.statusCode == 200 &&
                      data['status'] == 'success') {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                          builder: (context) =>
                              PersonasPage(user: widget.user)),
                    );
                    Fluttertoast.showToast(
                        msg: "Success",
                        toastLength: Toast.LENGTH_SHORT,
                        gravity: ToastGravity.BOTTOM,
                        timeInSecForIosWeb: 1,
                        textColor: Colors.green,
                        fontSize: 14.0);
                    setState(() {
                      widget.user.name = _nameeditingController.text;
                      widget.user.phone = _phoneeditingController.text;
                      widget.user.address = _addresseditingController.text;
                      widget.user.isProfileComplete = true;
                    });
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
              },
            ),
          ],
        ),
        body: SingleChildScrollView(
            child: Column(children: [
          GestureDetector(
              onTap: _selectImageDialog,
              child: Card(
                elevation: 10,
                child: Padding(
                  padding: const EdgeInsets.only(top: 10.0),
                  child: Column(children: [
                    GestureDetector(
                      onTap: _selectImageDialog,
                      child: Card(
                        elevation: 8,
                        child: Container(
                          height: 250,
                          width: 250,
                          decoration: BoxDecoration(
                              image: DecorationImage(
                            image: _image == null
                                ? AssetImage(pathAsset)
                                : FileImage(_image!) as ImageProvider,
                            fit: BoxFit.cover,
                          )),
                        ),
                      ),
                    ),
                  ]),
                ),
              )),
          Container(
              padding: const EdgeInsets.only(left: 20, top: 25, right: 20),
              child: SingleChildScrollView(
                  child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                    const SizedBox(
                      height: 5,
                    ),
                    Text("Email: " + widget.user.email!,
                        style: const TextStyle(
                            fontSize: 15, fontWeight: FontWeight.w200)),
                    const SizedBox(
                      height: 10,
                    ),
                    TextField(
                      controller: _nameeditingController,
                      cursorColor: Colors.grey[90],
                      decoration: const InputDecoration(
                        labelStyle: TextStyle(
                          color: Colors.blueGrey,
                        ),
                        icon: Icon(
                          Icons.person,
                          color: Colors.blueGrey,
                        ),
                        focusedBorder: OutlineInputBorder(
                          borderSide: BorderSide(
                            width: 1.0,
                            color: Colors.grey,
                          ),
                        ),
                      ),
                      onSubmitted: _onNameSubmitted,
                    ),
                    const SizedBox(height: 20),
                    TextField(
                      controller: _phoneeditingController,
                      cursorColor: Colors.grey[90],
                      decoration: const InputDecoration(
                        labelStyle: TextStyle(
                          color: Colors.blueGrey,
                        ),
                        icon: Icon(
                          Icons.phone,
                          color: Colors.blueGrey,
                        ),
                        focusedBorder: OutlineInputBorder(
                          borderSide: BorderSide(
                            width: 1.0,
                            color: Colors.grey,
                          ),
                        ),
                      ),
                      onSubmitted: _onPhoneSubmitted,
                    ),
                    const SizedBox(height: 20),
                    TextField(
                      controller: _addresseditingController,
                      cursorColor: Colors.grey[90],
                      decoration: const InputDecoration(
                        labelStyle: TextStyle(
                          color: Colors.blueGrey,
                        ),
                        icon: Icon(
                          Icons.house,
                          color: Colors.blueGrey,
                        ),
                        focusedBorder: OutlineInputBorder(
                          borderSide: BorderSide(
                            width: 1.0,
                            color: Colors.grey,
                          ),
                        ),
                      ),
                      onSubmitted: _onAddressSubmitted,
                    ),
                    const SizedBox(height: 60),
                  ])))
        ])));
  }

  void _selectImageDialog() {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        // return object of type Dialog
        return AlertDialog(
            title: const Text(
              "Select picture from:",
              style: TextStyle(),
            ),
            content: Row(
              mainAxisAlignment: MainAxisAlignment.spaceAround,
              children: [
                IconButton(
                    iconSize: 64,
                    onPressed: _onCamera,
                    icon: const Icon(Icons.camera)),
                IconButton(
                    iconSize: 64,
                    onPressed: _onGallery,
                    icon: const Icon(Icons.browse_gallery)),
              ],
            ));
      },
    );
  }

  Future<void> _onCamera() async {
    Navigator.pop(context);
    final picker = ImagePicker();
    final pickedFile = await picker.pickImage(
      source: ImageSource.camera,
      maxHeight: 800,
      maxWidth: 800,
    );
    if (pickedFile != null) {
      _image = File(pickedFile.path);
      cropImage();
    } else {}
  }

  Future<void> _onGallery() async {
    Navigator.pop(context);
    final picker = ImagePicker();
    final pickedFile = await picker.pickImage(
      source: ImageSource.gallery,
      maxHeight: 800,
      maxWidth: 800,
    );
    if (pickedFile != null) {
      _image = File(pickedFile.path);
      cropImage();
      //setState(() {});
    } else {}
  }

  Future<void> cropImage() async {
    CroppedFile? croppedFile = await ImageCropper().cropImage(
      sourcePath: _image!.path,
      aspectRatioPresets: [
        CropAspectRatioPreset.square,
      ],
      uiSettings: [
        AndroidUiSettings(
            toolbarTitle: 'Cropper',
            toolbarColor: Colors.deepOrange,
            toolbarWidgetColor: Colors.white,
            initAspectRatio: CropAspectRatioPreset.original,
            lockAspectRatio: false),
        IOSUiSettings(
          title: 'Cropper',
        ),
      ],
    );
    if (croppedFile != null) {
      File imageFile = File(croppedFile.path);
      _image = imageFile;
      setState(() {});
    }
  }
}
