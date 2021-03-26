import 'dart:convert';

CheckImei checkImeiFromJson(String str) => CheckImei.fromJson(json.decode(str));

String checkImeiToJson(CheckImei data) => json.encode(data.toJson());

class CheckImei {
  CheckImei({
    this.value,
  });

  String value;

  factory CheckImei.fromJson(Map<String, dynamic> json) => CheckImei(
    value: json["value"],
  );

  Map<String, dynamic> toJson() => {
    "value": value,
  };
}
