<?php
// inc/functions.php

/**
 * دالة لتنظيف البيانات
 */
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * جلب بيانات المريض
 */
function fetch_patient_details($conn, $pat_id) {
    $stmt = $conn->prepare("SELECT fname, age, phone, soc_sts, chel_num FROM patinte WHERE pat_id=?");
    $stmt->bind_param("i", $pat_id);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * جلب آخر جلسة (تاريخ سابق) للمريض
 */
function fetch_previous_session_date($conn, $pat_id) {
    $stmt = $conn->prepare("SELECT MAX(date_now) AS previous_date FROM session WHERE pat_id=?");
    $stmt->bind_param("i", $pat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result && $result->num_rows > 0){
       $row = $result->fetch_assoc();
       return $row['previous_date'];
    }
    return "";
}

/**
 * إضافة جلسة جديدة
 */
function add_new_session($conn, $params) {
    $stmt = $conn->prepare("INSERT INTO session (
            pat_id, date_now, date_pev, date_next, main_com, period_ill, sex_hist, person_hist, curr_hist, last_hist, 
            fam_hist, work_hist, basic_dig, diff_dig, appear, behav, mood, killer, thin_shep, thin_con, percep, 
            memory, ability, insight, fores, degree, speech
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // بناء سلسلة الأنواع مع ترتيب الأعمدة (i = رقم صحيح | s = سلسلة)
    $typeString = "i" . str_repeat("s", 24) . "is";
    $stmt->bind_param(
        $typeString,
        $params['pat_id'],
        $params['date_now'],
        $params['date_pev'],
        $params['date_next'],
        $params['main_com'],
        $params['period_ill'],
        $params['sex_hist'],
        $params['person_hist'],
        $params['curr_hist'],
        $params['last_hist'],
        $params['fam_hist'],
        $params['work_hist'],
        $params['basic_dig'],
        $params['diff_dig'],
        $params['appear'],
        $params['behav'],
        $params['mood'],
        $params['killer'],
        $params['thin_shep'],
        $params['thin_con'],
        $params['percep'],
        $params['memory'],
        $params['ability'],
        $params['insight'],
        $params['fores'],
        $params['degree'],
        $params['speech']
    );
    
    return $stmt->execute();
}
