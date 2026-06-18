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
    return MaterialApp(
      title: 'EduManage Mobile',
      theme: ThemeData(
        primaryColor: const Color(0x8E7CC300),
        useMaterial3: true,
      ),
      home: const WebPortalScreen(),
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
          try {
            final data = jsonDecode(response.payload!);
            if (data['action'] == 'open_inbox') {
              final role = data['role'];
              // Navigate the webview directly to the inbox section
              _controller.loadRequest(
                Uri.parse("$_pcServerUrl/index.php?controller=$role&action=inbox"),
              );
            }
          } catch (e) {
            print("Error handling notification payload: $e");
          }
        }
      },
    );

    // Request notification permission for Android 13+ (API 33)
    final AndroidFlutterLocalNotificationsPlugin? androidImplementation =
        _notificationsPlugin.resolvePlatformSpecificImplementation<
            AndroidFlutterLocalNotificationsPlugin>();
    if (androidImplementation != null) {
      await androidImplementation.requestNotificationsPermission();
    }
  }

  void _initWebViewController() {
    _controller = WebViewController()
      ..setJavaScriptMode(JavaScriptMode.unrestricted)
      ..setBackgroundColor(const Color(0xFFFFFFFF))
      // Register JavaScript Bridge Hook: window.FlutterBridge.postMessage(...)
      ..addJavaScriptChannel(
        'FlutterBridge',
        onMessageReceived: (JavaScriptMessage message) {
          try {
            final Map<String, dynamic> data = jsonDecode(message.message);
            if (data['action'] == 'push_notification') {
              _showLocalNotification(
                title: data['title'] ?? 'EduManage Alert 🔔',
                body: data['body'] ?? '',
                payload: data['payload'] ?? '',
              );
            } else if (data['action'] == 'copy_contact') {
              // Optionally handle contact copy action natively
              print("Bridge Request: Copying Contact - ${data['phone']}");
            }
          } catch (e) {
            print("Bridge Parsing Error: $e");
          }
        },
      )
      ..setNavigationDelegate(
        NavigationDelegate(
          onPageFinished: (String url) {
            // Enable native mode overrides inside CSS when load completes
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
