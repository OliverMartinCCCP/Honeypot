
<?php
require_once 'core/init.php';
$user = new User();

include 'header.php';
?>

<div id="page">
    <?php
    $results = DB::getInstance()->getAllEvents();

    echo '<div id="allEvents">';
        echo '<h1 id="tableTitle">Tourdates</h1>';
        $resultaatstring = "<table>";
            $resultaatstring.= "<tr>";
                $resultaatstring.= "<th>date</th>";
                $resultaatstring.= "<th>time</th>";
                $resultaatstring.= "<th>city</th>";
                $resultaatstring.= "<th>event</th>";
            $resultaatstring.= "</tr>";

            foreach($results->results() as $event){
            $resultaatstring.= "<tr>";
                $resultaatstring.= "<td>".$event->date."</td>";
                $resultaatstring.= "<td>".$event->time."h</td>";
                $resultaatstring.= "<td>".$event->city."</td>";
                $resultaatstring.= "<td>".$event->event."</td>";
                $resultaatstring.= "</tr>";
            }
            $resultaatstring.= "</table>";

        echo $resultaatstring;
        echo '</div>';
        ?>
</div>


<?php
include 'footer.php';
?>

</body>


<!-- Mirrored from vercamers.happyvisocoders.be/webshop/reeks2.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 Oct 2016 14:02:30 GMT -->
