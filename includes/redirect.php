<?php

// Redirect to input page
function red_input() {
    echo("<script>location.href = 'input.php';</script>");
}
// Redirect to reports page
function red_reports() {
    echo("<script>location.href = 'reports.php';</script>");
}
// Redirect to graph page
function red_graph() {
    echo("<script>location.href = 'graph.php';</script>");
}
// Redirect to users page
function red_users() {
    echo("<script>location.href = 'users.php';</script>");
}
// Redirect to current page
function red_current() {
    echo("<script>location.href = '".$_SERVER['PHP_SELF']."';</script>"); 
}
// Redirect to selected report at report page
function red_selected($sector, $num) {
    echo("<script>location.href = 'input.php?select-".$sector."=".$num."';</script>");
}
// Redirect to add report state
function red_add($sector) {
    echo("<script>location.href = 'input.php?add-report=".$sector."';</script>");
}
// Redirect to custom path
function red_custom($path) {
    echo("<script>location.href = '".$path."';</script>");
}

?>
