<?php
class Model {
    protected static $db = null;

    /**
     * Retrieve the database connection from the Singleton Database class.
     * 
     * @return PDO|null
     */
    protected static function getDB() {
        if (self::$db === null) {
            self::$db = Database::getInstance()->getConnection();
        }
        return self::$db;
    }

    /**
     * Return the count of rows matching a condition.
     * Similar to my_class::num_of_rows in class.php.
     * 
     * @param string $table
     * @param string $where_cond
     * @return int
     */
    public static function num_of_rows($table, $where_cond = '1') {
        $db = self::getDB();
        if (!$db) return 0;
        
        $sql = "SELECT count(*) as num FROM " . $table . " WHERE " . $where_cond;
        try {
            $q = $db->prepare($sql);
            $q->execute();
            $data = $q->fetch(PDO::FETCH_ASSOC);
            return isset($data['num']) ? (int)$data['num'] : 0;
        } catch (PDOException $e) {
            error_log("Database error in num_of_rows: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Insert raw or formatted data into a table.
     * Similar to my_class::Insert_Data in class.php.
     * 
     * @param string $table_name
     * @param array $form_data
     * @return string|false
     */
    public static function Insert_Data($table_name, $form_data) {
        $db = self::getDB();
        if (!$db) return false;
        
        $fields = array_keys($form_data);
        $placeholders = array_map(fn($field) => ":$field", $fields);
        
        $sql = "INSERT INTO " . $table_name . " 
                (`" . implode('`,`', $fields) . "`) 
                VALUES (" . implode(', ', $placeholders) . ")";
                
        try {
            $q = $db->prepare($sql);
            $q->execute($form_data);
            return $db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database error in Insert_Data: " . $e->getMessage());
            return false;
        }
    }

    /**
     * View all records from a table.
     * Similar to my_class::View_All in class.php.
     * 
     * @param string $table_name
     * @return array
     */
    public static function View_All($table_name) {
        $db = self::getDB();
        if (!$db) return [];
        
        $sql = "SELECT * FROM " . $table_name;
        try {
            $q = $db->prepare($sql);
            $q->execute();
            return $q->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in View_All: " . $e->getMessage());
            return [];
        }
    }

    /**
     * View all records matching a specific SQL WHERE condition string.
     * Similar to my_class::View_All_By_Cond in class.php.
     * 
     * @param string $table_name
     * @param string $where_cond
     * @return array
     */
    public static function View_All_By_Cond($table_name, $where_cond) {
        $db = self::getDB();
        if (!$db) return [];
        
        $sql = "SELECT * FROM " . $table_name . " WHERE " . $where_cond;
        try {
            $q = $db->prepare($sql);
            $q->execute();
            return $q->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in View_All_By_Cond: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch standard student list view along with attendance comments.
     * Ported from my_class::View_Student_List_atttd_with_comment in class.php.
     * 
     * @param string $where_cond
     * @return array
     */
    public static function View_Student_List_atttd_with_comment($where_cond) {
        $db = self::getDB();
        if (!$db) return [];

        $sql = "SELECT pf_std._id,
                       sc._id AS _section_id,
                       sc._name AS _section,
                       cl._id AS _class_id,
                       pf_std._uniq_id,
                       pf_std._class_roll,
                       pf_std._section_roll,
                       pf_std._full_name,
                       pf_std._nick_name,
                       pf_std._std_mobile,
                       pf_std._contact_email,
                       pf_std._current_guardian,
                       mot._mobile_no AS mother_phone,
                       fath._mobile_no AS father_phone,
                       gur._mobile_no AS guardian_phone,
                       hmc._atd_status,
                       hmc._late_time,
                       hmc._comments
                FROM ((((((((((._int_institute_setup br
                               left JOIN _int_institute_setup i ON (br._pid = i._id))
                              left JOIN _int_institute_setup sh ON (sh._pid = br._id))
                             left JOIN _int_institute_setup me ON (me._pid = sh._id))
                            left JOIN _int_institute_setup cl ON (cl._pid = me._id))
                           left JOIN _int_institute_setup dp ON (dp._pid = cl._id))
                          left JOIN _int_institute_setup st ON (st._pid = dp._id))
                         left JOIN _int_institute_setup sc ON (sc._pid = st._id))
                        left JOIN _pf_std_basic_info bsf ON (bsf._section_id = sc._id))
                       left JOIN _pf_std_personal_info pf_std ON (pf_std._id = bsf._pid))
                      left JOIN _int_common_setup bg ON (pf_std._blood_group_id = bg._id))
                     left JOIN _int_common_setup rg ON (pf_std._religion = rg._id)
                     left JOIN _atd_daily_by_class hmc ON (hmc._std_id = pf_std._id AND hmc._atd_status != 'P')
                     left JOIN _pf_guardian_spouse_info mot ON (pf_std._id = mot._pid AND mot._type = 'S' AND mot._info_type = 'F')
                     left JOIN _pf_guardian_spouse_info fath ON (pf_std._id = fath._pid AND fath._type = 'S' AND fath._info_type = 'M')
                     left JOIN _pf_guardian_spouse_info gur ON (pf_std._id = gur._pid AND gur._type = 'S' AND gur._info_type = 'O')
                WHERE " . $where_cond;

        try {
            $q = $db->prepare($sql);
            $q->execute();
            return $q->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in View_Student_List_atttd_with_comment: " . $e->getMessage());
            return [];
        }
    }
}
