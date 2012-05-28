<?php 
/*
$randomPath = 
    ROOT . DS . 
        APP_DIR . DS . '42viral' . DS . 'View' . DS . 'Themed' . DS . 'Jasonsnider' . DS . 'Elements' . DS . 'home';

$homePages = array();

foreach(scandir($randomPath) as $homePage){
    if(is_file($randomPath . DS . $homePage)){
        $homePages[] = $homePage;
    }
}         

echo $this->element('home' . DS . str_replace('.ctp', '', $homePages[array_rand($homePages)])); 
*/
?>
<style type="text/css">
    #Main{
        background: #000;
        text-align: center;
        padding: 0;
        margin: 0 auto;
    }
    
    .tagline.home {
        width: 300px;
        top: 120px;
        left: 600px;
        text-align: left;
        position: absolute;
        padding: 12px;
        color: white;
        background: #9BAB02;
        -moz-border-radius: 8px;
        border-radius: 8px;
        -moz-box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.3);
        -khtml-box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 3px 3px 0 rgba(0, 0, 0, 0.3);
        opacity: .8;
        filter: alpha(opacity=80) -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
        border-top-left-radius: 4px 4px;
        border-top-right-radius: 4px 4px;
        border-bottom-right-radius: 4px 4px;
        border-bottom-left-radius: 4px 4px;
    }
    
    h1.home{
        position: absolute;
        display:inline;
        text-align: center;
        top:40px;
        left: 600px;
        color: #ff9900;
        font: 64px/1.231 "Reenie Beanie";
        text-shadow: rgba(0, 0, 0, 0.3) -1px 0,rgba(0, 0, 0, 0.3) 0 -1px,rgba(255, 255, 255, 0.3) 0 1px,rgba(0, 0, 0, 0.3) -1px -1px;
    
    }
    
    h2.home {
        font-size: 16px;
        font-weight: bold;
    }  
    
    img{
        border-radius: 2px;
    }
</style>
<div class="rows">
    <div class="sixteen columns">
        <h1 class="home">Jason D Snider</h1>
        <div class="tagline home">
            <div>
                <h2>Web Developer, Designer, Architect and Strategist</h2>
                <p>Striking the balance between open tools and proprietary 
                knowledge to drive change, foster innovation and increase 
                efficiency by building smarter enterprises that can prosper
                amidst competition.</p>
            </div>
        </div>
        <?php echo $this->Html->image("jason.jpg"); ?>  
    </div>
</div>
