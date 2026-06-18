# Flutter WebView & Push Notification Integration Guide

This guide explains how to connect your physical phone to your local PHP server over Wi-Fi and test the native push notification bridge for the **Inbox Section** of EduManage. 

> [!IMPORTANT]
> The **complete Flutter codebase** is pre-configured and written directly inside the [mobile_app/](file:///E:/Leotech/school_management_app/mobile_app) directory of this workspace. You can run it directly on your device.

---

## 1. Network Setup & Server Configuration

To access the raw PHP application from your physical phone, both the development computer and the phone **must be connected to the same Wi-Fi network**.

### Step 1: Find Your Computer's Local IP Address
1.  Open **Command Prompt** or **PowerShell** on your computer.
2.  Run the following command:
    ```cmd
    ipconfig
    ```
3.  Look for your active connection (e.g., *Wireless LAN adapter Wi-Fi*).
4.  Note down the **IPv4 Address** (typically in the format `192.168.x.x` or `10.0.x.x`, e.g., `192.168.1.100`).

### Step 2: Bind the PHP Development Server
By default, running `php -S localhost:8000` only listens to requests from your local machine. To listen to all incoming network requests (including those from your phone), bind the server to `0.0.0.0`:

```bash
cd E:/Leotech/school_management_app
php -S 0.0.0.0:8000
```
*   Your app will now be accessible on your local network at: `http://<your-pc-ip>:8000`
*   Verify this by entering `http://<your-pc-ip>:8000` in your phone's browser.

---

## 2. Wireless Flutter Debugging Setup

To run your Flutter app on your phone wirelessly from your computer:

### Option A: Android Wireless Debugging (Android 11+)
1.  On your phone, enable **Developer Options** (Settings ➔ About Phone ➔ Tap *Build Number* 7 times).
2.  Go to **Developer Options** and enable **USB Debugging** and **Wireless Debugging**.
3.  Tap on **Wireless Debugging** and select **Pair device with pairing code**. Note the IP, Port, and Pairing Code.
4.  Open a terminal on your computer and run:
    ```bash
    adb pair <phone-ip>:<pairing-port>
    ```
    *Input the pairing code when prompted.*
5.  After successful pairing, connect using:
    ```bash
    adb connect <phone-ip>:<connection-port>
    ```
6.  Run `flutter devices` to verify your phone is detected. Run:
    ```bash
    flutter run
    ```

### Option B: USB Initial Run (All OS)
1.  Connect your phone via USB cable and enable **USB Debugging**.
2.  Run `flutter run` to launch the app on your phone.
3.  Once running, you can disconnect the USB cable if you have set up Wireless ADB or wireless debugging hooks in your IDE (VS Code / Android Studio).

---

## 3. Flutter Webview JavaScript Bridge Setup (Dart)

To make push notifications work, the Flutter app must catch the `postMessage` calls sent from the web app's inbox section and trigger local notifications on the phone.

### Step 1: Add Flutter Dependencies
In your Flutter project's `pubspec.yaml`, add:
```yaml
dependencies:
  flutter:
    sdk: flutter
  webview_flutter: ^4.4.2
  flutter_local_notifications: ^16.3.1
```

### Step 2: Implement Webview Listener & Local Notifications
Below is the clean Dart implementation to set up the WebView receiver and local notification triggers in your Flutter app:

```dart
import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:webview_flutter/webview_flutter.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);
  @override
  Widget build(BuildContext context) {
    return const MaterialApp(
      home: WebPortalScreen(),
      debugShowCheckedModeBanner: false,
    );
  }
}

class WebPortalScreen extends StatefulWidget {
  const WebPortalScreen({Key? key}) : super(key: key);
  @override
  State<WebPortalScreen> createState() => _WebPortalScreenState();
}

class _WebPortalScreenState extends State<WebPortalScreen> {
  late final WebViewController _controller;
  final FlutterLocalNotificationsPlugin _notificationsPlugin = FlutterLocalNotificationsPlugin();

  // Live Render deployment server URL
  final String _pcServerUrl = "https://edu-manage-awuv.onrender.com"; 

  @override
  void initState() {
    super.initState();
    _initNotifications();
    _initWebViewController();
  }

  void _initNotifications() async {
    const AndroidInitializationSettings initializationSettingsAndroid =
        AndroidInitializationSettings('@mipmap/ic_launcher');
    const InitializationSettings initializationSettings =
        InitializationSettings(android: initializationSettingsAndroid);
    
    await _notificationsPlugin.initialize(
      initializationSettings,
      onDidReceiveNotificationResponse: (NotificationResponse response) {
        if (response.payload != null) {
          final data = jsonDecode(response.payload!);
          if (data['action'] == 'open_inbox') {
            final role = data['role'];
            // Navigate the webview to the inbox section
            _controller.loadRequest(
              Uri.parse("$_pcServerUrl/index.php?controller=$role&action=inbox"),
            );
          }
        }
      },
    );
  }

  void _initWebViewController() {
    _controller = WebViewController()
      ..setJavaScriptMode(JavaScriptMode.unrestricted)
      ..setBackgroundColor(const Color(0x00000000))
      // JavaScript Bridge Hook
      ..addJavaScriptChannel(
        'FlutterBridge',
        onMessageReceived: (JavaScriptMessage message) {
          try {
            final Map<String, dynamic> data = jsonDecode(message.message);
            if (data['action'] == 'push_notification') {
              _showLocalNotification(
                title: data['title'] ?? 'Notification',
                body: data['body'] ?? '',
                payload: data['payload'] ?? '',
              );
            }
          } catch (e) {
            print("Bridge Parsing Error: $e");
          }
        },
      )
      ..setNavigationDelegate(
        NavigationDelegate(
          onPageFinished: (String url) {
            // Enable native mode modifications inside CSS
            _controller.runJavaScript("enableNativeMode();");
          },
        ),
      )
      ..loadRequest(Uri.parse(_pcServerUrl));
  }

  Future<void> _showLocalNotification({
    required String title,
    required String body,
    required String payload,
  }) async {
    const AndroidNotificationDetails androidDetails = AndroidNotificationDetails(
      'edumanage_channel',
      'School Notifications',
      channelDescription: 'Urgent updates for students and teachers',
      importance: Importance.max,
      priority: Priority.high,
      playSound: true,
    );
    const NotificationDetails platformDetails = NotificationDetails(android: androidDetails);

    await _notificationsPlugin.show(
      DateTime.now().millisecond,
      title,
      body,
      platformDetails,
      payload: payload,
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: WebViewWidget(controller: _controller),
      ),
    );
  }
}
```

---

## 4. How to Test the Setup

1.  Start your PHP server: `php -S 0.0.0.0:8000`.
2.  Update the `_pcServerUrl` string in your Flutter code with your computer's actual IPv4 address.
3.  Deploy the Flutter app to your phone: `flutter run`.
4.  Once the app loads, navigate to the **Inbox** section.
5.  In the inbox, click **Test Notification**:
    *   *Web Simulator Mode:* If opened in a desktop browser, it displays a mock sliding HTML notification banner.
    *   *Native Mode:* If running inside the Flutter WebView on your phone, it sends a JSON payload over the bridge, triggering a physical push/local notification at the top of your phone's screen.
6.  Click **In 5 Seconds** to test delayed triggers:
    *   Minimize the app on your phone immediately.
    *   After 5 seconds, a physical notification banner will pop up on your phone.
    *   Tapping the notification will launch/maximize the app and automatically navigate to the **Inbox** section!
