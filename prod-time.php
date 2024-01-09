                                <?php
                                session_start();
                                date_default_timezone_set("Asia/Bahrain");
                                $courtnumber = $_REQUEST["c"];
                                    try{
                                        require('connection.php');
                                        
                                        $dateres = $_REQUEST["d"];
                                        $cardid = $_SESSION['fieldNum'];
                                        $durHour = $_REQUEST["h"];
                                        $starttime = $_SESSION['start']; 
                                        $endtime = $_SESSION['end']; 
                                        
                                        $sql3 = "select * from reservation where fieldid = $cardid and court = $courtnumber and date = '".$dateres."' order by date";
                                        $stmt3=$db->query($sql3);
                                        $db=null;
                                        }
                                        catch(PDOException $e)
                                        {
                                            die($e->getMessage());
                                        }
                                $stime=explode(':',$starttime);
                                $etime=explode(':',$endtime);
                                $beginHour = $stime[0];
                                $endHour = $etime[0]; 
                                $arr = [];
                                $countChecked = 0;
                                $pastHours = date("G");
                                $make = mktime(0,0,0,date('m'),date("d"),date('Y')+1);
                                $dateToday = date("Y-h-d", $make);
                                foreach($stmt3 as $rows){
                                    $start=explode(':',$rows['starttime']);
                                        $end=explode(':',$rows['endtime']);
                                            $startre = $start[0];
                                            $dates[] = $rows['date'];
                                            $endre =  $end[0];
                                        $arr[]=$startre;
                                        $duration[] = $rows['duration'];
                                }
                                for($i=$beginHour;$i<$endHour;$i++){
                                    $print = 1;
                                    for($j=0;$j<count($arr);$j++){
                                        $difference = $arr[$j]-$i;
                                        $second = $arr[$j]+$duration[$j]-1;
                                        if($i==$arr[$j] || $i==$second || $durHour==2 && $difference == 1){
                                            $print = 0;
                                            break;
                                        }
                                    }
                                    $lastHour = $endHour-1;
                                    if(($durHour==2 && $i==$lastHour) || ($i<=$pastHours && $dateres == $dateToday)){
                                        $print = 0;
                                    }
                                    if($print == 1){
                                        
                                    ?>
                                    
                                    <input type="radio" id="<?php echo $i?>:00" name="time" value="<?php echo $i?>:00" <?php if($countChecked==0) echo"checked"?>>
                                    <label class="prod-select" for="<?php echo $i?>:00"><?php echo $i?>:00</label>
                                    
                                        <?php 
                                        $countChecked++;
                                    }
                    }
                    if($countChecked==0){
                        echo "No time slots available, Try to Reserve another day";
                    }
                                ?>
