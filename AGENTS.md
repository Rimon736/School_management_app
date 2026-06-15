# EduManage - Project Context & Rules

## 1. Project Overview & Architecture
EduManage is a mobile-first educational management system architected using a **Custom Raw PHP MVC (Model-View-Controller) Pattern**.
- **BANNED FRAMEWORKS:** Absolutely NO Laravel, CodeIgniter, React, Vue, HTMX, or Tailwind. Stick strictly to raw PHP (OOP), HTML, CSS, and Vanilla JS.
- **Routing:** All traffic routes through `index.php` using parameters: `?controller={name}&action={method}`. 
- **Separation of Concerns:** - **Controllers:** Handle logic, fetch data from Models, and load Views.
  - **Models:** Handle all data structures and business rules (return dummy arrays for now).
  - **Views:** Strictly HTML/UI presentation. No complex PHP logic here.

## 2. Strict Directory Structure
Do not deviate from this MVC file structure:
- `assets/css/style.css` (Centralized styling)
- `assets/js/main.js` (Centralized JS, including Flutter Bridge hooks)
- `core/Controller.php` (Base controller class handling view rendering and layout injection)
- `controllers/AuthController.php`, `StudentController.php`, `TeacherController.php`
- `models/AuthModel.php`, `StudentModel.php`, `TeacherModel.php`
- `views/layouts/header.php`, `footer.php`, `sidebar.php`
- `views/auth/login.php`
- `views/student/{feature}.php` (8 feature view files)
- `views/teacher/{feature}.php` (8 feature view files)
- `index.php` (The Front Controller/Router)

## 3. Design System & Theme
- **Theme:** Lavender (`#8E7CC3`) as the primary brand color, `#674EA7` for dark contrasts. Backgrounds are `#f7f7f7` and `#ffffff`.
- **Typography:** Roboto font family.
- **Icons:** Phosphor Icons (`.ph` for outline, `.ph-fill` for active states).
- **UI/UX Feel:** Strict mobile app aesthetic. Max-width is 400px. Touch feedback (`transform: scale(0.98)`) and smooth transitions.

## 4. Cultural Context (Strict)
All placeholder data (generated in the Models) must reflect a **Bangladeshi School Context**:
- **Currency:** Tk. or BDT.
- **Week/Routine:** Saturday to Thursday workweek. Friday is the weekend.
- **Names:** Common Bangladeshi names (e.g., Prof. Anisul Islam, Salma Begum, Rafiqul).
- **Locations & IDs:** Bangladeshi addresses, NID format.
- **Classes/Grades:** Class 6 to 10, Sections (Padma, Meghna, Jamuna), SSC/JSC style grading (GPA out of 5.00). Term structure: 1st Term, Mid Term, Final Term.

## 5. Feature Requirements: Student Panel (Routed via StudentController)
1. **Classroom:** Tabs for Online Classes (live links) and Recorded Classes.
2. **Routine:** Weekday pill-navigation (Sat-Thu). Auto-selects the current real-world day.
3. **Attendance:** Monthly calendar view. Color codes: Green (Present), Red (Absent), Yellow/Orange (Leave).
4. **Results:** Summary cards for terms -> clicks through to subject-wise details.
5. **Profile:** Image, ID, Class, Roll, Parents' info, Address, Mobile, Nationality, DOB.
6. **Fees:** Top Total Due card with "PAY NOW" button -> Transaction history list.
7. **Academic Calendar:** Interactive monthly calendar highlighting holidays/exams.
8. **Teachers List:** Faculty directory. Tapping the phone icon copies the number to the clipboard and shows a toast.

## 6. Feature Requirements: Teacher Panel (Routed via TeacherController)
1. **Profile:** Banner (Image/Name/Designation). Details: Dept, Section, Email, Contact, Office Phone, Blood Group, Joining Date, Address, DOB, NID.
2. **Online Class:** "Schedule Class" button/form -> List of scheduled upcoming classes.
3. **Mark Entry:** Hierarchical drill-down (Category -> Term -> Test List -> Class -> Section -> Subject). Edit mode shows student roll numbers, a mark input with `+` and `-` stepper icons, remarks input, and simulates "Auto-save" UI toasts.
4. **Student Attendance:** Select Date/Class/Section. Shows student list with Present/Absent/Late toggles. Must include "Present All" and "Absent All" batch action buttons, and a "Save" button.
5. **Student List:** Select Class -> Section -> Directory of students (Image, Name, ID, Phone) with Edit buttons.
6. **Routine:** 7-day horizontal pills (Sat-Fri). Includes classes, meetings, and exam guard duties.
7. **Personal Attendance:** Monthly calendar view of the teacher's own attendance.
8. **Academic Calendar:** Shared component with students.

## 7. Authentication & Connectivity
- **Auth Bypass:** `AuthController` -> `login` method loads `views/auth/login.php`. Replace email/password with two buttons: "Login as Student" and "Login as Teacher". These POST to the controller to set `$_SESSION['role']` and redirect.
- **Supabase:** Keep the vanilla JS Supabase initialization code in `assets/js/main.js` but comment out the actual API call logic.
- **Flutter Bridge:** Ensure `<body class="native-mode">` and `window.FlutterBridge.postMessage` JS hooks remain perfectly intact in the global assets so the native app wrapper does not break.