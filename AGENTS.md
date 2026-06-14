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
- **UI/UX Feel:** Container max-width is 400px. Interactions must have native-like touch feedback (e.g., `transform: scale(0.98)`) and smooth transitions (`fadeIn` animations).

## 3. Cultural Context (Strict)
All placeholder data must reflect a **Bangladeshi School Context**:
- **Currency:** Tk. or BDT (e.g., Tk. 2,500).
- **Week/Routine:** The workweek is Saturday to Thursday. Friday is a weekend.
- **Names:** Common Bangladeshi names (e.g., Kazi Hasan, Salma Begum, Rafiqul Islam).
- **Locations:** Bangladeshi addresses (e.g., Mirpur 10, Dhaka).
- **Grades/Terms:** 1st Term, Mid Term, Final Term. Use SSC/JSC style grading (GPA out of 5.00) where applicable.

## 4. Required Student Features & Views
1. **My Classroom (`classroomView`):** Tabs for "Online Classes" (live links) and "Recorded Classes" (video list).
2. **My Routine (`routineView`):** Weekday pill-buttons (Sat to Thu). Script must auto-detect the current day and show that routine by default.
3. **Attendance (`attendanceView`):** Monthly calendar grid. Color codes: Green (Present), Red (Absent), Yellow/Orange (Leave). Include summary stats.
4. **Results (`resultView`):** Summary cards for 1st, Mid, and Final Terms. Clicking a term reveals a detailed subject-wise breakdown.
5. **Profile (`profileView`):** Display Avatar, Student Name, Student ID, Class, Roll Number, Father's Name, Mother's Name, Address, Mobile No, Nationality, and Date of Birth.
6. **Fees (`feesView`):** Top card showing Total Due with an eye-catching "PAY NOW" button, followed by transaction history.
7. **Academic Calendar (`acadCalendarView`):** Monthly interactive calendar with forward/backward navigation. Highlight Class Days, Exams, and National Holidays (e.g., Victory Day, Eid-ul-Fitr).
8. **Teachers List (`teachersView`):** List of faculty (image, name, designation). Tapping the phone icon triggers a JS clipboard copy and `showToast('Number copied!')`.

## 5. CRITICAL: Authentication Protection
- **DO NOT TOUCH** the `#loginView` HTML structure.
- **DO NOT TOUCH** the Supabase initialization code (`supabase.createClient`).
- **DO NOT TOUCH** the `handleLogin()` JavaScript function.
- The app uses `document.getElementById('mainContainer').classList.remove('login-mode')` to transition into the app. This flow must remain perfectly intact.