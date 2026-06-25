<?php
class NoticeModel extends Model {
    /**
     * Retrieve list of recent notices from the database.
     */
    public static function getRecentNotices() {
        $db = self::getDB();
        $schoolCode = isset($_SESSION['school_code']) ? $_SESSION['school_code'] : 'DHAKA100';
        
        if ($db) {
            $stmt = $db->prepare("SELECT id, title, date, file_name, file_size, uploader, category, icon, color FROM notices WHERE school_code = :school_code ORDER BY id DESC");
            $stmt->execute(['school_code' => $schoolCode]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
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
            ]
        ];
    }
}
