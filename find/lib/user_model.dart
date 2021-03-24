import 'dart:convert';

UserModel userModelFromJson(String str) => UserModel.fromJson(json.decode(str));

String userModelToJson(UserModel data) => json.encode(data.toJson());

class UserModel {
  UserModel({
    this.value,
    this.loginId,
  });

  String value;
  String loginId;

  factory UserModel.fromJson(Map<String, dynamic> json) => UserModel(
    value: json["value"],
    loginId: json["login_id"],
  );

  Map<String, dynamic> toJson() => {
    "value": value,
    "login_id": loginId,
  };
}

