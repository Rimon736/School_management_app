<?php
class NoticeModel {
    public static function getRecentNotices() {
        return [
            [
                'id' => 1,
                'title' => 'SSC Exam Registration 2026 Guidelines',
                'date' => '10 June 2026',
                'file_name' => 'ssc_registration_guidelines_2026.pdf',
                'file_size' => '324 KB',
                'uploader' => 'Headmaster Kazi Hasan',
                'category' => 'Exam',
                'icon' => 'ph-megaphone',
                'color' => '#e74c3c'
            ],
            [
                'id' => 2,
                'title' => 'Mid-Term Syllabus & Exam Routine (Class 6-10)',
                'date' => '05 June 2026',
                'file_name' => 'midterm_routine_syllabus_2026.pdf',
                'file_size' => '450 KB',
                'uploader' => 'Salma Begum (Asst. Headmaster)',
                'category' => 'Routine',
                'icon' => 'ph-megaphone',
                'color' => '#8E7CC3'
            ],
            [
                'id' => 3,
                'title' => 'Government Holiday Notice - Buddha Purnima',
                'date' => '26 May 2026',
                'file_name' => 'holiday_notice_buddha_purnima.pdf',
                'file_size' => '120 KB',
                'uploader' => 'General Admin',
                'category' => 'Holiday',
                'icon' => 'ph-megaphone',
                'color' => '#f39c12'
            ],
            [
                'id' => 4,
                'title' => 'Rain Warning & Special Class Rescheduling',
                'date' => '20 May 2026',
                'file_name' => 'special_notice_weather_reschedule.pdf',
                'file_size' => '180 KB',
                'uploader' => 'Principal Prof. Anisul Islam',
                'category' => 'Emergency',
                'icon' => 'ph-megaphone',
                'color' => '#e74c3c'
            ],
            [
                'id' => 5,
                'title' => 'Inter-Class Sports & Cultural Week 2026 Schedule',
                'date' => '15 May 2026',
                'file_name' => 'cultural_sports_week_schedule.pdf',
                'file_size' => '520 KB',
                'uploader' => 'Physical Ed. Dept.',
                'category' => 'Event',
                'icon' => 'ph-megaphone',
                'color' => '#2ecc71'
            ]
        ];
    }
}
