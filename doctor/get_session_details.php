<?php
// Enable error reporting (for debugging purposes - make sure to disable it in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include '../includes/db.php';

// Function to sanitize inputs
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if(isset($_GET['pat_id']) && isset($_GET['session_id']) && is_numeric($_GET['pat_id']) && is_numeric($_GET['session_id'])){
    
    $pat_id = (int)test_input($_GET['pat_id']);
    $session_id = (int)test_input($_GET['session_id']);

    // Fetch session data
    $stmtSession = $conn->prepare("SELECT * FROM `session` WHERE pat_id = ? AND id_session = ?");
    if(!$stmtSession){
        echo "<div class='alert alert-danger'>Failed to prepare session query: " . $conn->error . "</div>";
        exit();
    }
    $stmtSession->bind_param("ii", $pat_id, $session_id);
    if(!$stmtSession->execute()){
        echo "<div class='alert alert-danger'>Failed to execute session query: " . $stmtSession->error . "</div>";
        exit();
    }
    $resultSession = $stmtSession->get_result();

    if($rowSession = $resultSession->fetch_assoc()){
        echo "<h5>Session Details:</h5>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead><tr><th>Field</th><th>Value</th></tr></thead><tbody>";
        
        // List of fields with labels
        $fields = [
            'pat_id' => 'Patient ID',
            'date_now' => 'Current Session Date',
            'date_pev' => 'Previous Session Date',
            'date_next' => 'Next Session Date',
            'main_com' => 'Main Complaint',
            'period_ill' => 'Illness Period',
            'curr_hist' => 'Current Illness History',
            'last_hist' => 'Previous History',
            'fam_hist' => 'Family History',
            'work_hist' => 'Occupational History',
            'sex_hist' => 'Sexual History',
            'person_hist' => 'Personal History',
            'appear' => 'Appearance',
            'behav' => 'Behavior',
            'speech' => 'Speech',
            'mood' => 'Mood/Affect',
            'killer' => 'Suicidal/Homicidal Thoughts/Plans',
            'thin_shep' => 'Thought Form',
            'thin_con' => 'Thought Content',
            'percep' => 'Perception',
            'memory' => 'Memory',
            'ability' => 'Judgment',
            'insight' => 'Insight',
            'fores' => 'Cognitive Perception',
            'degree' => 'Fullton Degree',
            'basic_dig' => 'Preliminary Diagnosis',
            'diff_dig' => 'Differential Diagnosis',
            'id_session' => 'Session ID'
        ];
        
        foreach($fields as $field => $label){
            // Get the value from the row
            $value = isset($rowSession[$field]) ? $rowSession[$field] : '';

            // Check if the value is not empty
            if($value !== null && trim($value) !== ''){
                // Process the value based on the field type
                if(in_array($field, ['date_now', 'date_pev', 'date_next'])){
                    // Format the date
                    $displayValue = date("d-m-Y", strtotime($value));
                } elseif(in_array($field, ['main_com', 'period_ill', 'sex_hist', 'person_hist', 'curr_hist', 'last_hist', 'fam_hist', 'work_hist', 'basic_dig', 'diff_dig', 'appear', 'behav', 'mood', 'killer', 'thin_shep', 'thin_con', 'percep', 'memory', 'ability', 'insight', 'fores'])){
                    // Convert line breaks to <br> for long text fields
                    $displayValue = nl2br(htmlspecialchars($value));
                } else {
                    // Sanitize short text values
                    $displayValue = htmlspecialchars($value);
                }
                echo "<tr><th style='width: 200px;'>$label</th><td>$displayValue</td></tr>";
            }
        }
        
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-danger'>No data found for the specified session.</div>";
    }

} else {
    echo "<div class='alert alert-danger'>Invalid inputs provided.</div>";
}
?>
