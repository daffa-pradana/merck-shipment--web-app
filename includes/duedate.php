<?php
    function dueStatus($etaParam){
        $eta = strtotime($etaParam);
        $now = time();
        $between = $eta - $now;
        $due = round($between / (60*60*24));
        if ($due < 0) {
            $stat = "overdue";
            $dueStat = "Overdue by: " . abs($due) . " days";
        } elseif ($due >= 0 && $due <= 7){
            $stat = "dueweek";
            $dueStat = "Due date in: " . abs($due) . " days";
        } else {;
            $stat = "dueby";
            $dueStat = "Due date in: " . abs($due) . " days";
        }
        return array($stat,$dueStat);
    }
?>