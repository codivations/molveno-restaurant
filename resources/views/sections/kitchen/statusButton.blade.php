<?php
$buttonContent;

if ($orderedItem->status = "to do") {
    $buttonContent = "&#x2610";
} elseif ($orderedItem->status = "in progress") {
    $buttonContent = "-";
} elseif ($orderedItem->status = "done") {
    $buttonContent = "&#x2714;";
}

?>
