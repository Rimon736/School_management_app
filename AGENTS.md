# EduManage - Project Context & Rules

## 1. Project Overview & Architecture
EduManage is a mobile-first educational management system built strictly with **Vanilla HTML, CSS, and JavaScript**. 
- It functions as a Single Page Application (SPA) using DOM manipulation to switch views (adding/removing `.active` classes).
- It is designed to run in a browser and as a WebView inside a native Flutter app. 
- **BANNED FRAMEWORKS:** Do not use React, Vue, Tailwind, or backend frameworks. Stick strictly to vanilla web technologies.

## 2. Design System & Theme
- **Theme:** Lavender (`#8E7CC3`) as primary, `#674EA7` for dark contrasts. Backgrounds are `#f7f7f7` and `#ffffff`.
- **Typography:** Roboto font family.
- **Icons:** Phosphor Icons (`.ph` for outline, `.ph-fill` for active states).
- **UI/UX Feel:** Container max-width is 400px. Interactions must have native-like touch feedback (e.g., `transform: scale(0.98)`) and smooth transitions.

## 3. Cultural Context (Strict)
All placeholder data must reflect a **Bangladeshi School Context**:
- **Currency:** Tk. or BDT.
- **Week/Routine:** The workweek is Saturday to Thursday. Friday is the weekend.
- **Names:** Common Bangladeshi names (e.g., Prof. Anisul Islam, Dr. Shirin Akter).
- **Locations & IDs:** Bangladeshi addresses, NID (National ID) format.
- **Classes/Sections:** Class 6 to 10, Sections like Padma, Meghna, Jamuna, or A, B, C.

## 4. Required Teacher Features & Views (NEW)
1. **Teacher Profile (`teacherProfileView`):** Banner with Image, Name, Designation. List details: Department Name, Section/Level, Email, Contact No, Office Phone, Blood Group, Joining Date, Address, DOB, and NID.
2. **Online Class (`teacherOnlineClassView`):** A "Schedule Class" button (prompts for Date, Time, Link). Below it, a list of scheduled classes.
3. **Mark Entry (`teacherMarkEntryView`):** Hierarchical flow:
   - *Categories:* Class Test, Model Test, Term Exam.
   - *Flow:* Select Category -> Select Term/Session -> View List of Tests (with "Add New" button) -> Select Level (Class) -> Select Section -> Select Subject (shows View/Edit buttons).
   - *Edit Mode:* Shows Student Roll Numbers, Mark Input box with `+` and `-` stepper icons, and a Remarks input. Includes simulated "Auto-save" UI feedback.
4. **Student Attendance (`teacherStudentAttendanceView`):** Select Date, Class, Section to reveal student list. Each student has Present/Absent/Late toggles and Remarks. Top buttons for "Present All" and "Absent All". Bottom "Save" button.
5. **Student List (`teacherStudentListView`):** Flow: Select Class -> Select Section -> List of Students (Image, Name, ID, Phone). Include an "Edit" button for each student.
6. **Teacher Routine (`teacherRoutineView`):** 7-day week (Sat to Fri) horizontal pills. Includes regular classes, staff meetings, and exam guard duties.
7. **Personal Attendance (`teacherPersonalAttendanceView`):** Monthly calendar view of the teacher's own attendance, identical in function to the student version.
8. **Academic Calendar (`acadCalendarView`):** Shared with students; interactive monthly view highlighting holidays, exams, and class days.

## 5. Authentication (Temporary Bypass)
- **DO NOT DELETE** the Supabase initialization or the body of the `handleLogin()` function.
- **DO Modify** the `#loginView` UI: Replace email/password inputs with two clear buttons: "Login as Student" and "Login as Teacher".
- Update the click handlers to simply call `loginAs('student')` and `loginAs('teacher')` directly, bypassing the Supabase API call temporarily for development purposes. Keep the Supabase code commented out or unreachable within `handleLogin()`.# EduManage - Project Context & Rules

## 1. Project Overview & Architecture
EduManage is a mobile-first educational management system built strictly with **Vanilla HTML, CSS, and JavaScript**. 
- It functions as a Single Page Application (SPA) using DOM manipulation to switch views (adding/removing `.active` classes).
- It is designed to run in a browser and as a WebView inside a native Flutter app. 
- **BANNED FRAMEWORKS:** Do not use React, Vue, Tailwind, or backend frameworks. Stick strictly to vanilla web technologies.

## 2. Design System & Theme
- **Theme:** Lavender (`#8E7CC3`) as primary, `#674EA7` for dark contrasts. Backgrounds are `#f7f7f7` and `#ffffff`.
- **Typography:** Roboto font family.
- **Icons:** Phosphor Icons (`.ph` for outline, `.ph-fill` for active states).
- **UI/UX Feel:** Container max-width is 400px. Interactions must have native-like touch feedback (e.g., `transform: scale(0.98)`) and smooth transitions.

## 3. Cultural Context (Strict)
All placeholder data must reflect a **Bangladeshi School Context**:
- **Currency:** Tk. or BDT.
- **Week/Routine:** The workweek is Saturday to Thursday. Friday is the weekend.
- **Names:** Common Bangladeshi names (e.g., Prof. Anisul Islam, Dr. Shirin Akter).
- **Locations & IDs:** Bangladeshi addresses, NID (National ID) format.
- **Classes/Sections:** Class 6 to 10, Sections like Padma, Meghna, Jamuna, or A, B, C.

## 4. Required Teacher Features & Views (NEW)
1. **Teacher Profile (`teacherProfileView`):** Banner with Image, Name, Designation. List details: Department Name, Section/Level, Email, Contact No, Office Phone, Blood Group, Joining Date, Address, DOB, and NID.
2. **Online Class (`teacherOnlineClassView`):** A "Schedule Class" button (prompts for Date, Time, Link). Below it, a list of scheduled classes.
3. **Mark Entry (`teacherMarkEntryView`):** Hierarchical flow:
   - *Categories:* Class Test, Model Test, Term Exam.
   - *Flow:* Select Category -> Select Term/Session -> View List of Tests (with "Add New" button) -> Select Level (Class) -> Select Section -> Select Subject (shows View/Edit buttons).
   - *Edit Mode:* Shows Student Roll Numbers, Mark Input box with `+` and `-` stepper icons, and a Remarks input. Includes simulated "Auto-save" UI feedback.
4. **Student Attendance (`teacherStudentAttendanceView`):** Select Date, Class, Section to reveal student list. Each student has Present/Absent/Late toggles and Remarks. Top buttons for "Present All" and "Absent All". Bottom "Save" button.
5. **Student List (`teacherStudentListView`):** Flow: Select Class -> Select Section -> List of Students (Image, Name, ID, Phone). Include an "Edit" button for each student.
6. **Teacher Routine (`teacherRoutineView`):** 7-day week (Sat to Fri) horizontal pills. Includes regular classes, staff meetings, and exam guard duties.
7. **Personal Attendance (`teacherPersonalAttendanceView`):** Monthly calendar view of the teacher's own attendance, identical in function to the student version.
8. **Academic Calendar (`acadCalendarView`):** Shared with students; interactive monthly view highlighting holidays, exams, and class days.

## 5. Authentication (Temporary Bypass)
- **DO NOT DELETE** the Supabase initialization or the body of the `handleLogin()` function.
- **DO Modify** the `#loginView` UI: Replace email/password inputs with two clear buttons: "Login as Student" and "Login as Teacher".
- Update the click handlers to simply call `loginAs('student')` and `loginAs('teacher')` directly, bypassing the Supabase API call temporarily for development purposes. Keep the Supabase code commented out or unreachable within `handleLogin()`.