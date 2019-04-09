<div class="home-sidebar-item sidebar-item">
<div class="home-item-title">
        <h2>HET WEER</h2>
        <a href="" class="item-close">&nbsp;</a>
</div>

<div class="sidebar-item-body sidebar-weather">
        <ul>
        <?php

    $zipcode = 'NLXX0012';

$result = file_get_contents('http://weather.yahooapis.com/forecastrss?p=' . $zipcode . '&u=c');
$xml = simplexml_load_string($result);

 $monthDutch=array('Mon'=>'Maandag','Tue'=>'Dinsdag','Wed'=>'Woensdag ','Thu'=>'Donderdag','Fri'=>'Vrijdag','Sat'=>'Zaterdag','Sun'=>'Zondag');
//echo htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
 
$xml->registerXPathNamespace('yweather', 'http://xml.weather.yahoo.com/ns/rss/1.0');
$location = $xml->channel->xpath('yweather:location');
 $value["day"]=new stdClass();
if(!empty($location)){
    foreach($xml->channel->item as $item){
        
        $current = $item->xpath('yweather:condition');
        $forecast = $item->xpath('yweather:forecast');
        $current = $current[0];
        //$i=0;
        foreach($forecast as $forecastIrems=>$value)
        {
            
            $month=json_decode( json_encode($value["day"]) , 1);
           if($forecastIrems==0)
           {
            ?>
            <li class="active">
                        <a href="" class="sidebar-item-header">
                                <h3><?php echo $monthDutch[$month[0]]; ?></h3>
                                <div class="daily-weather">
                                        <i class="icon-scloudy"><img src="http://l.yimg.com/a/i/us/we/52/<?php echo $current['code']; ?>.gif" style="vertical-align: middle;"/></i>
                                        <span class="temp"><?php echo $current['temp']; ?> °C</span>
                                </div>
                        </a>

                        <div class="sidebar-item-content">
                                <div class="date">
                                        <?php echo $current['date'];?>
                                </div>
                                <div class="daily-weather-lg">
                                        <div class="temperatuer">
                                                <h4>LEEUWARDEN</h4>
                                                <span><?php echo $current['temp']; ?>°C</span>
                                                <p> <?php echo $value["text"]; ?></p>
                                        </div>
                                        <div class="weather-icon-wrapper">
                                                <i class="icon-scloudy-lg"><img src="http://l.yimg.com/a/i/us/we/52/<?php echo $current['code']; ?>.gif" style="vertical-align: middle;"/></i>
                                        </div>
                                </div>
                                <div class="day-weather-property">
                                        <div class="temp">
                                                <p><i class="icon-weather icon-temp-down"></i><?php echo $value["low"];?></p> 
                                                <p><i class="icon-weather icon-temp-up"></i><?php echo $value["high"];?></p> 
                                        </div>
                                        
                                </div>
                               
                        </div>
                </li>
            <?php
           }
            else
            {
           ?>
                  <li>
                        <a href="" class="sidebar-item-header">
                                <h3><?php echo $monthDutch[$month[0]]; ?></h3>
                                <div class="daily-weather">
                                        <i class="icon-scloudy"><img src="http://l.yimg.com/a/i/us/we/52/<?php echo $value["code"]; ?>.gif" style="vertical-align: middle;"/></i>
                                        <span class="temp"><?php echo $value["low"];?>-<?php echo $value["high"];?></span>
                                </div>
                        </a>

                        <div class="sidebar-item-content">
                                <div class="date">
                                        <?php echo $value["date"];?>
                                </div>
                                <div class="daily-weather-lg">
                                        <div class="temperatuer">
                                                <h4>LEEUWARDEN</h4>
                                                <span>Min. Temp(C): <?php echo $value["low"];?> - Max. Temp(C): <?php echo $value["high"];?></span>
                                                <p> <?php echo $value["text"]; ?></p>
                                        </div>
                                        <div class="weather-icon-wrapper">
                                                <i class="icon-scloudy-lg"><img src="http://l.yimg.com/a/i/us/we/52/<?php echo $value["code"]; ?>.gif" style="vertical-align: middle;"/></i>
                                        </div>
                                </div>
                                <div class="day-weather-property">
                                        <div class="temp">
                                                <p><i class="icon-weather icon-temp-down"></i><?php echo $value["low"];?></p> 
                                                <p><i class="icon-weather icon-temp-up"></i><?php echo $value["high"];?></p> 
                                        </div>
                                       
                                </div>
                                
                        </div>
                </li>
           <?php
           }
            
        }
        
       // $output = <<<END
       
       
             
            }
        }
        ?>
        </ul>
</div>
</div>	