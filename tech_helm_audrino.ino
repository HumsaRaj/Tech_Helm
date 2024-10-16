#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_ADXL345_U.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <WiFiUdp.h>
#include <EEPROM.h>
#include <EEPROMVar.h>
#include <EEPROMType.h>
#include <EEPROMConfig.h>
#include <EEPROMUtil.h>
#include <EEPROMClass.h>
const char* ssid = "iot";
const char* password = "12345678";
const char* serverName = "http://iotcloud22.in/vellore_smart_helmet2/post_value.php";
WiFiClient client;
HTTPClient http;
String timeUp;
String nmea[15];
String labels[12] {"Time: ", "Status: ", "Latitude: ", "Hemisphere: ", "Longitude: ", "Hemisphere: ", "Speed: ", "Track Angle: ", "Date: "};

String ch;
String lat = "0.0000";
String lon = "0.0000";
int pos;
int stringplace = 0;
int updates;
int failedUpdates;
Adafruit_ADXL345_Unified accel = Adafruit_ADXL345_Unified();

int x, al, ir, eye, bt, mems;

void setup() {
  pinMode(D7, INPUT); //GAS SENSOR
  pinMode(D3, INPUT); //IR SENSOR
  pinMode(D4, INPUT); //eye blink SENSOR
  pinMode(D6, OUTPUT); //RELAY
  pinMode(D5, INPUT_PULLUP);// BUTTON
  Serial.begin(9600);
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  if (!accel.begin())

  {
    Serial.println("No valid sensor found");

    while (1);
  }


}

void loop() {
  al = digitalRead(D7);
  Serial.print("AL:"), Serial.println(al);
  ir = digitalRead(D3);
  Serial.print("IR:"), Serial.println(ir);
  eye = digitalRead(D4);
  Serial.print("eye:"), Serial.println(eye);
  bt = digitalRead(D5);
  Serial.print("bt:"), Serial.println(bt);
  sensors_event_t event;

  accel.getEvent(&event);

  Serial.print("X: "); Serial.print(event.acceleration.x); Serial.print("  ");
  mems = event.acceleration.x;
  //   Serial.print("Y: "); Serial.print(event.acceleration.y); Serial.print("  ");
  //
  //   Serial.print("Z: "); Serial.print(event.acceleration.z); Serial.print("  ");

  Serial.println("m/s^2 ");
  delay(200);
  if (ir == 0)
  {
    digitalWrite(D6, HIGH);
    Serial.println("ir relay On");
    Serial.println("");
  }
  else
  {
    digitalWrite(D6, LOW);
    Serial.println("ir relay Off");
    Serial.println("");
  }
  condition(  );
  sending_to_db() ;

}

void sending_to_db()
{
  if (WiFi.status() == WL_CONNECTED)
  {
    gps();
    http.begin(client, serverName);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String httpRequestData = "&value1=" + String(al) + "&value2=" + String(ir) + "&value3=" + String(eye) + "&value4=" + String(mems) + "&value5=" + String(bt) + "&value6=" + String(lat) + "&value7=" + String(lat) + "";
        Serial.print("httpRequestData: ");
        Serial.println(httpRequestData);
    int httpResponseCode = http.POST(httpRequestData);
    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }

  delay(500);


}
void gps()
{
  //  Serial.flush();
  Serial.read();
  if (Serial.find("$GPRMC,")) {
    String Msg = Serial.readStringUntil('\n');
    Serial.println(Msg);
    for (int i = 0; i < Msg.length(); i++) {
      if (Msg.substring(i, i + 1) == ",") {
        nmea[pos] = Msg.substring(stringplace, i);
        stringplace = i + 1;
        pos++;
      }
      if (i == Msg.length() - 1) {
        nmea[pos] = Msg.substring(stringplace, i);
      }
    }
    updates++;
    nmea[2] = ConvertLat();
    nmea[4] = ConvertLng();
    //for (int i = 0; i < 9; i++) {
    /*Serial.print(labels[0]);
      Serial.print(nmea[0]);
      Serial.print(labels[8]);
      Serial.println(nmea[8]);*/
    Serial.print("https://maps.google.com/maps?f=q&q=");
    Serial.print(nmea[2]);
    Serial.print(",");
    Serial.println(nmea[4]);

    int lat1 = nmea[2].toInt();
    if (lat1 > 0) {
      Serial.println("new data");
      lat = nmea[2];
      lon = nmea[4];
    }
    else {
      Serial.println("old data");

    }
    Serial.println("");
    //}

  }
  else {

    failedUpdates++;

  }
  stringplace = 0;
  pos = 0;
}

String ConvertLat() {
  String posneg = "";
  if (nmea[3] == "S") {
    posneg = "-";
  }
  String latfirst;
  float latsecond;
  for (int i = 0; i < nmea[2].length(); i++) {
    if (nmea[2].substring(i, i + 1) == ".") {
      latfirst = nmea[2].substring(0, i - 2);
      latsecond = nmea[2].substring(i - 2).toFloat();
    }
  }
  latsecond = latsecond / 60;
  String CalcLat = "";

  char charVal[9];
  dtostrf(latsecond, 4, 6, charVal);
  for (int i = 0; i < sizeof(charVal); i++)
  {
    CalcLat += charVal[i];
  }
  latfirst += CalcLat.substring(1);
  latfirst = posneg += latfirst;
  return latfirst;
}

String ConvertLng()
{
  String posneg = "";
  if (nmea[5] == "W") {
    posneg = "-";
  }
  String lngfirst;
  float lngsecond;
  for (int i = 0; i < nmea[4].length(); i++) {
    if (nmea[4].substring(i, i + 1) == ".") {
      lngfirst = nmea[4].substring(0, i - 2);
      //Serial.println(lngfirst);
      lngsecond = nmea[4].substring(i - 2).toFloat();
      //Serial.println(lngsecond);
    }
  }
  lngsecond = lngsecond / 60;
  String CalcLng = "";
  char charVal[9];
  dtostrf(lngsecond, 4, 6, charVal);
  for (int i = 0; i < sizeof(charVal); i++)
  {
    CalcLng += charVal[i];
  }
  lngfirst += CalcLng.substring(1);
  lngfirst = posneg += lngfirst;
  return lngfirst;
}
void condition()
{
  if (bt == 0)
  {
    digitalWrite(D6, LOW);//RELAY
    Serial.println("bt relay Off");
    Serial.println("");
    delay(1000);
    Serial.println("AT\r");
    delay(1000);
    Serial.println("AT+CMGF=1\r");
    delay(1000);
    Serial.println("AT+CMGS=\"+918098076074\"\r");
    delay(3000);
    Serial.println("EMERGENCY:");
    Serial.print(lat);
    Serial.print(",");
    Serial.println(lon);
    delay(3000);
    Serial.println((char)26);
    delay(1000);
  }
  else if (al == 0)
  {
    digitalWrite(D6, LOW);//RELAY
    
     delay(1000);
    Serial.println("AT\r");
    delay(1000);
    Serial.println("AT+CMGF=1\r");
    delay(1000);
    Serial.println("AT+CMGS=\"+918098076074\"\r");
    delay(3000);
    Serial.println("ALCOHOL DETECTED:");
    Serial.println((char)26);
    delay(1000);
  }
  else if (eye == 0)
  {
    digitalWrite(D6, LOW);//RELAY
    Serial.println("eye relay Off");
    Serial.println("");
  }
  else if (mems >= 5 || mems <= -5)
  {
    digitalWrite(D6, LOW);//RELAY
     delay(1000);
    Serial.println("AT\r");
    delay(1000);
    Serial.println("AT+CMGF=1\r");
    delay(1000);
    Serial.println("AT+CMGS=\"+918098076074\"\r");
    delay(3000);
    Serial.println("ACCIDENT DETECTED:");
    Serial.println((char)26);
    delay(1000);
  }

}
