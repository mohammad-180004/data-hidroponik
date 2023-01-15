#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <NTPClient.h>
#include <WiFiUdp.h>
#include <DHT.h>

// Atur SSID dan Password dari jaringan WiFi
const char *ssid     = "Redmi Note 5";
const char *password = "e492f32c7772";

// Atur alamat situs web untuk menerima data yang dikirimkan
const char* serverName = "http://data-hidroponik.domcloud.io/receive-nodemcu-data.php";

// Atur API Key untuk mencocokkan dengan halaman web
String apiKeyValue = "ZVgXDxg38a";

// Konfigurasi pin DHT11 dan deklarasi variabel untuk temp (suhu) dan humid (kelembaban)
#define DHTPIN 2 // Pin D4
#define DHTTYPE DHT11
DHT dht (DHTPIN, DHTTYPE);
float temperature = 0.0;
float humidity = 0.0;

// Get time from NTP Server
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP, "pool.ntp.org");

void setup() {
  Serial.begin(115200);
  
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(1000);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  // Memulai untuk mendapatkan data dari DHT11
  dht.begin();

  // Memulai untuk mendapatkan waktu dari NTP server dan atur zona waktu ke UTC+07.00
  timeClient.begin();
  timeClient.setTimeOffset(25200); // Set time to UTC+7

  // Atur pin GPIO sebagai OUTPUT untuk mengatur Relay
  pinMode(14, OUTPUT); // Pin D5
}

void loop() {
  // Mendapatkan waktu sekarang dari NTP server
  timeClient.update(); 
  int Hour = timeClient.getHours();
  int Minute = timeClient.getMinutes();
  int Second = timeClient.getSeconds();
  String Time = String(Hour) + ":" + String(Minute) + ":" + String(Second);
  Serial.println(Time);
  delay (1000);

  // Setel waktu untuk mengaktifkan relay
  if (Hour == 7 || Hour == 8 || Hour == 9  || Hour == 10 || Hour == 11 || Hour == 12 || Hour == 13 || Hour == 14 || Hour == 15) {
    digitalWrite(14, LOW);
    // Setel waktu untuk mengirimkan data DHT11 ke halaman web tujuan
    if ((Hour == 8 && Minute == 0 && Second == 0) ||  (Hour == 11 && Minute == 30 && Second == 0) || (Hour == 14 && Minute == 0 && Second == 0)) {
      if (WiFi.status() == WL_CONNECTED) {
          // Mendapatkan data suhu dan kelemabapan dari DHT11
          float newTemp = dht.readTemperature();
          temp = newTemp;
          Serial.println(temp);
          float newHumid = dht.readHumidity();
          humid = newHumid;
          Serial.println(humid);

        // Membuat koneksi dan mengirimkan data ke web server
        WiFiClient client;
        HTTPClient http;
        http.begin(client, serverName);
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        String httpRequestData = "api_key=" + apiKeyValue + "&temperature=" + temp + "&humidity=" + humid;

        // Cek error dalam pengiriman data
        Serial.print("httpRequestData: ");
        Serial.println(httpRequestData);
        int httpResponseCode = http.POST(httpRequestData);
        if (httpResponseCode > 0) {
          Serial.print("HTTP Response code: ");
          Serial.println(httpResponseCode);
        } else {
          Serial.print("Error code: ");
          Serial.println(httpResponseCode);
        }
        http.end();
      }
    }

  // Setel waktu untuk mematikan relay
  } else if (Hour == 16 || Hour == 17 || Hour == 18 || Hour == 19 || Hour == 20 || Hour == 21 || Hour == 22 || Hour == 23) {
    digitalWrite(12, HIGH);
    digitalWrite(13, HIGH);
    digitalWrite(14, HIGH);
  } else if (Hour == 0 || Hour == 1 || Hour == 2 || Hour == 3 || Hour == 4 || Hour == 5 || Hour == 6) {
    digitalWrite(12, HIGH);
    digitalWrite(13, HIGH);
    digitalWrite(14, HIGH);
  }
}
