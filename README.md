# EduManage

EduManage is a mobile-first, role-based educational management system tailored specifically for the Bangladeshi school context. Built on a custom, lightweight Raw PHP Model-View-Controller (MVC) architecture, the system provides high-performance, responsive interfaces for both students and teachers, designed to be embedded seamlessly within a native Flutter WebView wrapper.

---

## 1. Project Overview & Features

EduManage simplifies school administration, scheduling, academic monitoring, and communication. The application features two distinct dashboards, serving student and teacher user roles respectively.

### Student Panel Features
*   **Classroom Dashboard:** Access tabs for real-time live class links (Google Meet, etc.) and cataloged recorded classes.
*   **Weekly Routine:** Interactively navigate weekly schedules (Saturday to Thursday workweek) with automatic selection of the current weekday.
*   **Attendance Tracker:** Monthly calendar visualizer indicating attendance status with intuitive color-coded indicators:
    *   🟢 **Green:** Present
    *   🔴 **Absent**
    *   🟡 **Leave**
*   **Results Summary:** Overview cards summarizing term-wise grades, drilling down to subject-wise grade distributions.
*   **Academic Calendar:** Interactive calendar highlighting public holidays, exam schedules, and key school events.
*   **Fees & Transactions:** Current due amount indicator with a "PAY NOW" trigger and complete transaction logs.
*   **Faculty Directory:** Directory of class teachers with a click-to-copy phone number functionality and toast confirmation.
*   **Student Profile:** Display of personal identifiers, parent/guardian info, roll number, class level, address, and NID.
*   **Notice Board:** View, search, and download PDF notices (exam guidelines, weather alerts, holiday news) published by the school administration in the past month.

### Teacher Panel Features
*   **Teacher Profile:** Banner view indicating department, section, contact info, blood group, NID, and employment details.
*   **Online Class Scheduler:** Form-driven tool to schedule, list, launch, and delete upcoming online classes.
*   **Hierarchical Mark Entry:** Step-by-step wizard (Category ➔ Term ➔ Test ➔ Class ➔ Section ➔ Subject) supporting:
    *   Steppers (`+` / `-`) for quick mark adjustment.
    *   Remarks input.
    *   Visual Auto-save indicators synchronizing in real-time.
*   **Student Attendance Register:** Form to mark daily attendance by Class and Section, featuring batch actions ("Present All", "Absent All") and remarks fields.
*   **Student Directory:** Section-wise search and overview of students with direct profile edit access.
*   **Teacher Routine:** 7-day routine tracker (Saturday to Friday) containing classes, staff meetings, and exam invigilation schedules.
*   **Personal Attendance Tracker:** Monthly calendar visualization showing the teacher's own attendance.
*   **Academic Calendar:** Shared calendar module indicating holidays and school exam schedules.
*   **Notice Board:** View, search, and download PDF notices, with a dedicated PDF upload portal for teachers.

---

## 2. Tech Stack

To ensure optimal performance and eliminate runtime dependencies, EduManage is built on a clean, modern, and dependency-free tech stack:

*   **Backend:** Raw PHP (PHP 7.4+ object-oriented)
*   **Frontend Structure:** Semantic HTML5
*   **Frontend Styling:** Custom Vanilla CSS (No Tailwind, Bootstrap, or utility frameworks)
*   **Frontend Logic:** Vanilla JavaScript (No React, Vue, jQuery, or HTMX)
*   **Icons:** [Phosphor Icons](https://phosphoricons.com/) (using `.ph` for outline and `.ph-fill` for active states)
*   **Charts:** Chart.js (for student grade distributions and attendance reports)
*   **Database/Auth:** [Supabase](https://supabase.com/) (Vanilla JavaScript SDK loaded in assets, currently mocked for UI development but prepared for direct integration)

---

## 3. Architecture (The Custom MVC Pattern)

EduManage uses a custom, lightweight implementation of the **Model-View-Controller (MVC)** design pattern. All operations strictly adhere to the Separation of Concerns (SoC) principle.

```
                          ┌──────────────────────────┐
                          │     HTTP Request         │
                          └─────────────┬────────────┘
                                        │
                                        ▼
                          ┌──────────────────────────┐
                          │        index.php         │ (Front Controller)
                          └─────────────┬────────────┘
                                        │ (Route Dispatch)
                                        ▼
                          ┌──────────────────────────┐
                          │  Controllers (Logic)     │ ◄───► [Models (Data)]
                          └─────────────┬────────────┘
                                        │ (Render View)
                                        ▼
                          ┌──────────────────────────┐
                          │     Views (HTML/UI)      │
                          └──────────────────────────┘
```

### The Front Controller Pattern
All incoming web requests route through the main entry point: [index.php](file:///E:/Leotech/school_management_app/index.php). This file acts as the application router (Front Controller), handling session initialization, autoloader imports, global authentication enforcement, and route dispatching.

### Routing Mechanics
Routing is driven by HTTP `GET` parameters:
```
http://localhost:8000/index.php?controller={name}&action={method}
```
*   `controller` maps directly to a class in the `controllers/` directory (e.g., `student` targets `StudentController`).
*   `action` maps to a public method within that controller (e.g., `dashboard` invokes `StudentController::dashboard()`).
*   **Auth Middleware:** If no active session is detected, [index.php](file:///E:/Leotech/school_management_app/index.php) overrides the controller parameter and forces redirection to `AuthController::login()`.

### Separation of Concerns
1.  **Controllers:** Classes extending the base [Controller](file:///E:/Leotech/school_management_app/core/Controller.php) class. They handle validation, inspect request variables, call models, and invoke `$this->render('view_path', $data)` to load layouts.
2.  **Models:** Classes representing entities and handling business logic, data persistence, and SQL operations. In the mock phase, they return structured arrays simulating database results.
3.  **Views:** Raw HTML snippets representing the screen layouts. Views receive variables extracted from controller arrays and must contain minimal inline PHP (only loops and variable echoes).

---

## 4. Directory Structure

Developers joining the team must follow this folder hierarchy. Do not create ad-hoc root folders or mix logic inside view templates.

```
school_management_app/
│
├── index.php                      # Application Front Controller & Routers
├── README.md                      # Developer onboarding documentation
│
├── assets/                        # Public assets
│   ├── css/
│   │   └── style.css              # Centralized stylesheet (themes, layouts, components)
│   ├── js/
│   │   └── main.js                # Centralized scripts (state, calendars, bridge hooks)
│   └── images/                    # Application images and media assets
│
├── core/                          # Framework foundation files
│   └── Controller.php             # Base controller handling rendering and layouts
│
├── controllers/                   # Application controllers (Request & business flow)
│   ├── AuthController.php         # Authentication and session switches
│   ├── StudentController.php      # Student feature routing
│   └── TeacherController.php      # Teacher feature routing
│
├── models/                        # Data models (Database interactions & mock structures)
│   ├── AuthModel.php              # Credentials validation
│   ├── StudentModel.php           # Student records & grades data
│   └── TeacherModel.php           # Teacher profiles & routines data
│
└── views/                         # Presentation layer (Pure HTML/UI templates)
    ├── auth/
    │   └── login.php              # Mock role-based login gateway
    ├── layouts/                   # Global page wrappers
    │   ├── header.php             # Core HTML header, stylesheets, and native detection
    │   ├── sidebar.php            # Left/side drawer navigation
    │   └── footer.php             # Core HTML script attachments and footers
    ├── student/                   # Student view files (9 features)
    │   ├── classroom.php          # Online/Recorded class lists
    │   ├── routine.php            # Sat-Thu routine navigator
    │   ├── attendance.php         # Interactive attendance calendar
    │   ├── results.php            # Term report cards
    │   ├── profile.php            # Personal student records
    │   ├── fees.php               # Dues and history overview
    │   ├── calendar.php           # School academic events
    │   ├── teachers.php           # Faculty list
    │   └── notices.php            # Recent PDF notices list
    └── teacher/                   # Teacher view files (9 features)
        ├── profile.php            # Teacher bio and information
        ├── classroom.php          # Live class schedule panel
        ├── mark_entry.php         # Grade book and stepper interfaces
        ├── attendance.php         # Class register and batch toggles
        ├── student_list.php       # Class list viewer and editor
        ├── routine.php            # Sat-Fri schedule tracker
        ├── personal_attendance.php# Personal check-in history
        ├── calendar.php           # School academic events
        └── notices.php            # Recent PDF notices and uploader panel
```

---

## 5. Setup & Installation

Follow these instructions to spin up the project locally on your machine.

### Method 1: Using the PHP Built-in Server (Recommended)
This is the fastest method, requiring only a local PHP installation:
1.  Verify PHP is installed and added to your system environment path:
    ```bash
    php -v
    ```
2.  Open a terminal (e.g., PowerShell, Git Bash) and navigate to the project root directory:
    ```bash
    cd E:/Leotech/school_management_app
    ```
3.  Start the built-in development server:
    ```bash
    php -S localhost:8000
    ```
4.  Open your browser and navigate to: [http://localhost:8000](http://localhost:8000)

### Method 2: Using XAMPP / WampServer (Apache)
1.  Download and install [XAMPP](https://www.apachefriends.org/).
2.  Clone or move the `school_management_app` folder into the XAMPP web root directory:
    *   On Windows: `C:\xampp\htdocs\school_management_app`
    *   On macOS: `/Applications/XAMPP/htdocs/school_management_app`
3.  Open the **XAMPP Control Panel** and start the **Apache** server.
4.  Launch your browser and navigate to: `http://localhost/school_management_app`

---

## 6. Native App (Flutter) Integration

EduManage is designed to function inside a native mobile wrapper utilizing Flutter's WebView. Special considerations are baked into the codebase to facilitate bidirectional communication and layout adaptation:

### The Native Mode Class (`.native-mode`)
When the web application is loaded inside the Flutter WebView, the mobile wrapper injects a call invoking `window.enableNativeMode()`.
*   This adds the CSS class `.native-mode` directly to the `<body>` element.
*   The stylesheet [assets/css/style.css](file:///E:/Leotech/school_management_app/assets/css/style.css) utilizes `.native-mode` to hide browser headers, custom navigation sidebars, and native scrollbars, fitting the UI perfectly to the mobile viewport.

### The Flutter Bridge Object (`window.FlutterBridge`)
JavaScript events communicate with the host Flutter app through a message-passing channel:
*   Ensure that any click actions, clipboard copy feedback, or auth redirects check for the existence of `window.FlutterBridge`.
*   Example call payload:
    ```javascript
    if (window.FlutterBridge) {
        window.FlutterBridge.postMessage(JSON.stringify({
            action: 'copy_contact',
            phone: phoneNum
        }));
    }
    ```
> [!WARNING]
> **Do not remove or alter** the `window.FlutterBridge` detection script blocks in [assets/js/main.js](file:///E:/Leotech/school_management_app/assets/js/main.js) or the `<body class="native-mode">` overrides in layout files. Doing so will break layout styling and command relays on physical mobile devices.

---

## 7. Contribution Guidelines

When creating features or writing patches for EduManage, you must adhere to these strict development standards:

### 🚫 The "No Frameworks" Rule
EduManage is built to run with maximum efficiency on lower-end mobile devices.
*   **Banned Technologies:** TailwindCSS, Bootstrap, React, Vue, Svelte, Angular, HTMX, Laravel, CodeIgniter.
*   **CSS Standard:** All styles must be declared inside [assets/css/style.css](file:///E:/Leotech/school_management_app/assets/css/style.css) using vanilla CSS variables, transitions, and flex/grid systems.
*   **JS Standard:** Dynamic updates must be written in vanilla JavaScript in [assets/js/main.js](file:///E:/Leotech/school_management_app/assets/js/main.js).

### 🎨 Theme & Layout Constraints
*   **Primary Brand Color:** Lavender (`#8E7CC3`)
*   **Dark Contrasts:** Deep Lavender (`#674EA7`)
*   **Backgrounds:** Off-white (`#f7f7f7`) and pure white (`#ffffff`)
*   **Typography:** Roboto font family (loaded globally via Google Fonts)
*   **Viewport Restriction:** Layouts must conform to a strict mobile viewport feel. The main content container is locked to a maximum width of `400px` (`max-width: 400px; margin: 0 auto;`).
*   **Feedback:** Touch interactions must feature rapid scale transitions:
    ```css
    .clickable-element:active {
        transform: scale(0.98);
        transition: transform 0.1s ease;
    }
    ```

### 🇧🇩 Bangladeshi Cultural Context (Mock Data)
All placeholder models, seed files, and dummy data must respect the context of Bangladeshi educational institutions:
*   **Currency:** Formatted as Taka (e.g., `৳ 12,500.00`, `Tk.`, or `BDT`).
*   **Names:** Use common names native to Bangladesh (e.g., `Prof. Anisul Islam`, `Salma Begum`, `Rafiqul`, `Fatema Khatun`).
*   **Grades/Classes:** Model class levels after Class 6 to Class 10 (secondary schooling), divided into Sections named after local rivers (e.g., `Padma`, `Meghna`, `Jamuna`).
*   **Academic Workweek:** Saturday to Thursday workweek. **Friday is the weekend** and must be styled as a calendar holiday.
*   **Grading System:** Align results/transcripts with JSC/SSC standards (GPA scale out of `5.00`).
*   **Terms:** Use Bangladeshi academic term structures: `1st Term`, `Mid Term`, and `Final Term`.
