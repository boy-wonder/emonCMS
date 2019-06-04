<?php
    global $path, $session;
    $v = 5;
?>
<link href="<?php echo $path; ?>Modules/app/css/config.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="<?php echo $path; ?>Modules/app/css/dark.css?v=<?php echo $v; ?>" rel="stylesheet">

<script type="text/javascript" src="<?php echo $path; ?>Modules/app/lib/config.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="<?php echo $path; ?>Modules/app/lib/feed.js?v=<?php echo $v; ?>"></script>

<script type="text/javascript" src="<?php echo $path; ?>Lib/flot/jquery.flot.min.js?v=<?php echo $v; ?>"></script> 
<script type="text/javascript" src="<?php echo $path; ?>Lib/flot/jquery.flot.time.min.js?v=<?php echo $v; ?>"></script> 
<script type="text/javascript" src="<?php echo $path; ?>Lib/flot/jquery.flot.selection.min.js?v=<?php echo $v; ?>"></script> 
<script type="text/javascript" src="<?php echo $path; ?>Lib/flot/jquery.flot.stack.min.js?v=<?php echo $v; ?>"></script> 
<script type="text/javascript" src="<?php echo $path; ?>Lib/flot/date.format.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="<?php echo $path; ?>Modules/app/vis.helper.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="<?php echo $path; ?>Modules/app/lib/timeseries.js?v=<?php echo $v; ?>"></script> 

<style>
    BODY {
        background-color: #111;
    }

	.power-value-smaller {
	  font-weight:bold; 
	  font-size:70px; 
	  color:#0699fa; 
	  line-height: 1.1;
	}

	#wrapper {
		max-width: 4000px
	}

	.tooltip-item {
	}

	.tooltip-title {
	  color: #aaa;
	  font-weight:bold;
	  font-size:12px;
	}

	.tooltip-value {
	  color: #fff;
	  font-weight:bold;
	  font-size:14px;
	}

	.tooltip-units {
	  color: #fff;
	  font-weight:bold;
	  font-size:10px;
	}
	.visnav {
		min-width:14px;
	}
    .appbox-title {
        padding-bottom: 0.5em
    }
</style>

<div id="app-block" style="display:none" class="block">

  <div class="col1"><div class="col1-inner">

    <div style="height:20px; border-bottom:1px solid #333; padding-bottom:8px;">
        <div style="float:right;">
            <!--<span style="color:#fff; margin-right:10px" >Settings</span>-->
            <i class="openconfig icon-wrench icon-white" style="cursor:pointer; padding-right:5px"></i>
        </div>
    </div>

    <table style="width:100%">
    <tr>
        <td style="border:0; width:33%">
            <div class="electric-title" style="padding-top:5px">DEMAND</div>
            <div class="power-value-smaller"><span class="usenow">--</span><span style="font-size:50%">W</span></div>

            <div class="electric-title" style="padding-top:5px">GRID</div>
            <div class="power-value-smaller"><span class="balance">--</span></div>
        </td>
        <td style="text-align:center; border:0; width:33%">
            <div class="electric-title" style="padding-top:5px">HOUSE SOLAR</div>
            <div class="power-value-smaller" style="color:#dccc1f"><span class="solar1now">--</span><span style="font-size:50%">W</span></div>

            <div class="electric-title" style="padding-top:5px">BATTERY (<span class="battery1socnow" style="color:#ff00b7">--</span>%)</div>
            <div class="power-value-smaller" style="color:#99FF00"><span class="battery1now">--</span><span style="font-size:50%">W</span></div>
        </td>
        <td style="text-align:right; border:0; width:33%">
			<div class="electric-title" style="padding-top:5px">CABIN SOLAR</div>
            <div class="power-value-smaller" style="color:#dccc1f"><span class="solar2now">--</span><span style="font-size:50%">W</span></div>
			
            <div class="electric-title" style="padding-top:5px">BATTERY (<span class="battery2socnow" style="color:#ff851b">--</span>%)</div>
            <div class="power-value-smaller" style="color:#99FF00"><span class="battery2now">--</span><span style="font-size:50%">W</span></div>
		</td>
    </tr>
    </table>
    <br>
    
    <div class="visnavblock" style="height:28px; padding-bottom:5px;">
        <div class="powergraph-navigation">
            <span class="visnav time" time='1'>1h</span>
            <span class="visnav time" time='8'>8h</span>
            <span class="visnav time" time='24'>D</span>
            <span class="vistimeW visnav time" time='168'>W</span>
            <span class="vistimeM visnav time" time='720'>M</span>
            <span class="vistimeY visnav time" time='8760'>Y</span>
            <span id='zoomin' class='visnav' >+</span>
            <span id='zoomout' class='visnav' >-</span>
            <span id='left' class='visnav' ><</span>
            <span id='right' class='visnav' >></span>
        </div>
        
        <div class="bargraph-navigation" style="display:none">
            <span class="bargraph-viewall visnav" style="font-size:14px">VIEW ALL</span>
            <!--
            <span class="bargraph-viewdaily visnav" style="font-size:14px">DAILY</span>
            <span class="bargraph-viewmonthly visnav" style="font-size:14px">MONTHLY</span>
            <span class="bargraph-viewannually visnav" style="font-size:14px">ANNUALLY</span>
            -->
        </div>

        <span class="visnav batteryline" style="float:right; font-size:14px">BAT</span>
        <span class="visnav gridline" style="float:right; font-size:14px">GRID</span>

		<!--<span class="visnav viewhistory" style="float:right; font-size:14px">HIST</span>-->
    </div>

    <div id="placeholder_bound" style="width:100%; height:500px;">
        <div id="placeholder" style="height:500px"></div>
    </div>
    
    <table style="width:100%">
    <tr>
        <td class="appbox">
            <div class="appbox-title">USE</div>
            <div style="padding-bottom:5px"><span class="appbox-value total_use_kwh" style="color:#0699fa">0</span></div>
			<div><span class="appbox-units" style="color:#0699fa">kWh</span></div>
			<div><span class="appbox-units" style="color:#0699fa">£</span><span class="appbox-units total_use_cost" style="color:#0699fa">0.00</span><br>
			<span class="appbox-units" style="color:#0699fa"> + £</span><span class="appbox-units total_use_standing_cost" style="color:#0699fa">0.00</span></div>
        </td>
		
		<td class="appbox">
            <div class="appbox-title">SOLAR</div>
            <div style="padding-bottom:5px"><span class="appbox-value total_solar_prc" style="color:#dccc1f">0</span></div>
            <div><span class="appbox-units total_solar_kwh" style="color:#dccc1f"></span> <span class="appbox-units" style="color:#dccc1f">kWh</span></div>
			<!--<div><span class="appbox-units" style="color:#dccc1f">(-£</span><span class="appbox-units total_solar_cost" style="color:#dccc1f">0.00</span><span class="appbox-units" style="color:#dccc1f">)</span></div>-->
		</td>
		
		<td class="appbox">
            <div class="appbox-title">BATTERY</div>
            <div style="padding-bottom:5px"><span class="appbox-value total_battery_prc" style="color:#99FF00">0</span></div>
            <div><span class="appbox-units total_battery_kwh" style="color:#99FF00">0</span> <span class="appbox-units" style="color:#99FF00">kWh</span></div>
            <!--<div><span class="appbox-units" style="color:#99FF00">(-£</span><span class="appbox-units total_battery_cost" style="color:#99FF00">0.00</span><span class="appbox-units" style="color:#99FF00">)<span></span></div>-->
		</td>
        
		<td class="appbox">
            <div class="appbox-title">CHEAP</div>
            <div style="padding-bottom:5px"><span class="appbox-value total_import_cheap_prc" style="color:#ff9933">0</span></div>
            <div><span class="appbox-units total_import_cheap_kwh" style="color:#ff9933">0</span> <span class="appbox-units" style="color:#ff9933">kWh</span></div>
 		   <div><span class="appbox-units" style="color:#ff9933">£</span><span class="appbox-units total_import_cheap_cost" style="color:#ff9933">0.00</span></div>
		</td>
		
        <td class="appbox">
            <div class="appbox-title">NORMAL</div>
            <div style="padding-bottom:5px"><span class="appbox-value total_import_prc" style="color:#d52e2e">0</span></div>
            <div><span class="appbox-units total_import_kwh" style="color:#d52e2e">0</span> <span class="appbox-units" style="color:#d52e2e">kWh</span></div>
 		   <div><span class="appbox-units" style="color:#d52e2e">£</span><span class="appbox-units total_import_cost" style="color:#d52e2e">0.00</span></div>
		</td>
		
		<td class="appbox">
            <div class="appbox-title">EXPORT</div>
            <div style="padding-bottom:5px"><span class="appbox-value total_export_prc" style="color:#999">0</span></div>
            <div><span class="appbox-units total_export_kwh" style="color:#999">0</span> <span class="appbox-units" style="color:#999">kWh</span></div>
            <div><span class="appbox-units" style="color:#999">£</span><span class="appbox-units export_income" style="color:#999">0.00</span></div>
        </td>
    </tr>
    </table>

  </div></div>

</div>

<div id="app-setup" style="display:none; padding-top:50px" class="block">
    <h2 class="appconfig-title" style="color:#dccc1f">My Hybrid Solar</h2>

    <div class="appconfig-description">
      <div class="appconfig-description-inner">
        The My Solar app can be used to explore onsite solar generation, battery storage, self consumption, export and building consumption both in realtime with a moving power graph view and historically with a daily and monthly bargraph.
        <br><br>
        <b>Auto configure:</b> This app can auto-configure connecting to emoncms feeds with the names shown on the right, alternatively feeds can be selected by clicking on the edit button.
        <br><br>
        <b>Cumulative kWh</b> feeds can be generated from power feeds with the power_to_kwh input processor.
        <br><br>
        <img src="../Modules/app/images/mysolar_app.png" style="width:600px" class="img-rounded">
      </div>
    </div>
    <div class="app-config"></div>
</div>

<div class="ajax-loader"><img src="<?php echo $path; ?>Modules/app/images/ajax-loader.gif"/></div>

<script>

// ----------------------------------------------------------------------
// Globals
// ----------------------------------------------------------------------
var path = "<?php print $path; ?>";
var apikey = "<?php print $apikey; ?>";
var sessionwrite = <?php echo $session['write']; ?>;

apikeystr = ""; 
if (apikey!="") apikeystr = "&apikey="+apikey;

// ----------------------------------------------------------------------
// Display
// ----------------------------------------------------------------------

$(window).ready(function(){
    $("#footer").css('background-color','#181818');
    $("#footer").css('color','#999');
});
if (!sessionwrite) $(".openconfig").hide();

// ----------------------------------------------------------------------
// Configuration
// ----------------------------------------------------------------------
config.app = {
    "use":{"type":"feed", "autoname":"use", "engine":"5", "description":"House or building use in watts"},
	"grid":{"type":"feed", "autoname":"grid_power", "engine":"5", "description":"Grid Reading in watts"},
    "solar1":{"type":"feed", "autoname":"solar_power_house", "engine":"5", "description":"Solar 1 PV generation in Watts"},
    "battery1":{"type":"feed", "autoname":"battery_power_house", "engine":"5", "description":"Battery 1 power in Watts"},
    "battery1_soc":{"type":"feed", "autoname":"battery_soc_house", "engine":5, "description":"Battery 1 State Of Charge in %"},
    "solar2":{"type":"feed", "autoname":"solar_power_cabin", "engine":"5", "description":"Solar 2 PV generation in Watts"},
    "battery2":{"type":"feed", "autoname":"battery_power_cabin", "engine":"5", "description":"Battery 2 power in Watts"},
    "battery2_soc":{"type":"feed", "autoname":"battery_soc_cabin", "engine":5, "description":"Battery 2 State Of Charge in %"},
    "use_kwh":{"type":"feed", "autoname":"use_kwh", "engine":5, "description":"Cumulative use in kWh"},
    "battery_kwh":{"type":"feed", "autoname":"battery_kwh_house", "engine":5, "description":"Cumulative battery power in kWh"},
    "solar_kwh":{"type":"feed", "autoname":"solar_kwh", "engine":5, "description":"Cumulative solar generation in kWh"},
	"import_kwh":{"type":"feed", "autoname":"import_kwh", "engine":5, "description":"Cumulative grid import in kWh"},
	"export_kwh":{"type":"feed", "autoname":"export_kwh", "engine":5, "description":"Cumulative grid export in kWh"},
	"import_unitcost":{"type":"value", "default":0.137, "name": "Import unit cost", "description":"Unit cost of imported grid electricity"},
	"import_cheap_unitcost":{"type":"value", "default":0.05, "name": "Import unit cost (cheap rate)", "description":"Unit cost of imported grid electricity at cheap rate"},
	"export_income":{"type":"value", "default":0.055, "name": "Export unit income", "description":"Unit income for exported electricity"},
	"standing_charge":{"type":"value", "default":0.25, "name": "Standing Charge", "description":"Standing charge per day"}
};
config.name = "<?php echo $name; ?>";
config.db = <?php echo json_encode($config); ?>;
config.feeds = feed.list();

config.initapp = function(){init()};
config.showapp = function(){show()};
config.hideapp = function(){hide()};

// ----------------------------------------------------------------------
// APPLICATION
// ----------------------------------------------------------------------
var feeds = {};

var live = false;
var show_battery_line = 0;
var show_grid_line = 0;
var reload = true;
var autoupdate = true;
var lastupdate = 0;
var viewmode = "powergraph";
var historyseries = [];
var latest_start_time = 0;
var panning = false;
var bargraph_initialized = false;

config.init();

// App start function
function init()
{        
    app_log("INFO","myhybridsolarpv init");

    var timeWindow = (3600000*6.0*1);
    view.end = +new Date;
    view.start = view.end - timeWindow;

    init_bargraph();
    $(".viewhistory").show();
    
    // The first view is the powergraph, we load the events for the power graph here.
    if (viewmode === "powergraph") powergraph_events();
    
    // The buttons for these powergraph events are hidden when in historic mode 
    // The events are loaded at the start here and dont need to be unbinded and binded again.
    $("#zoomout").click(function () {view.zoomout(); reload = true; autoupdate = false; draw();});
    $("#zoomin").click(function () {view.zoomin(); reload = true; autoupdate = false; draw();});
    $('#right').click(function () {view.panright(); reload = true; autoupdate = false; draw();});
    $('#left').click(function () {view.panleft(); reload = true; autoupdate = false; draw();});
    
    $('.time').click(function () {
        view.timewindow($(this).attr("time")/24.0); 
        reload = true; 
        autoupdate = true;
        draw();
    });
    
    $(".batteryline").click(function () { 
        if ($(this).html()=="BAT") {
            show_battery_line = 1;
            draw();
            $(this).html("-BAT");
        } else {
            show_battery_line = 0;
            draw();
            $(this).html("BAT");
        }
    });

    $(".gridline").click(function () {
        if ($(this).html()=="GRID") {
            show_grid_line = 1;
            draw();
            $(this).html("-GRID");
        } else {
            show_grid_line = 0;
            draw();
            $(this).html("GRID");
        }
    });

    $(".viewhistory").click(function () { 
        if ($(this).html()=="HIST") {
            viewmode = "bargraph";
            $(".batteryline").hide();
            $(".powergraph-navigation").hide();
            $(".bargraph-navigation").show();
            
            draw();
            setTimeout(function() { $(".viewhistory").html("POWER VIEW"); },80);
        } else {
            
            viewmode = "powergraph";
            $(".batteryline").show();
            $(".bargraph-navigation").hide();
            $(".powergraph-navigation").show();
            
            draw();
            powergraph_events();
            setTimeout(function() { $(".viewhistory").html("HIST"); },80);
        }
    });        
}

function show() 
{
    app_log("INFO","myhybridsolarpv show");
    if (!bargraph_initialized) init_bargraph();
    $(".viewhistory").show();
    
    resize();
    livefn();
    live = setInterval(livefn,5000);
}

function resize() 
{
    app_log("INFO","myhybridsolarpv resize");
    
    var top_offset = 0;
    var placeholder_bound = $('#placeholder_bound');
    var placeholder = $('#placeholder');

    var width = placeholder_bound.width();
    var height = $(window).height()*0.55;

    if (height>width) height = width;

    placeholder.width(width);
	
    placeholder_bound.height(height);
    placeholder.height(height-top_offset);
    
    if (width<=500) {
        $(".electric-title").css("font-size","12px");
        $(".power-value").css("font-size","32px");
		$(".power-value-smaller").css("font-size","24px");
		$(".appbox-title").css("font-size","12px");
		$(".appbox-units").css("font-size","12px");
		$(".appbox-value").css("font-size","22px");
        $(".batteryline").show();
        $(".vistimeW").hide();
        $(".vistimeM").hide();
        $(".vistimeY").hide();
    } else if (width<=700) {
        $(".electric-title").css("font-size","16px");
        $(".power-value").css("font-size","52px");
		$(".power-value-smaller").css("font-size","36px");
		$(".appbox-title").css("font-size","16px");
		$(".appbox-units").css("font-size","16px");
		$(".appbox-value").css("font-size","30px");
        $(".batteryline").show();
        $(".vistimeW").show();
        $(".vistimeM").show();
        $(".vistimeY").show();
    } else {
        $(".electric-title").css("font-size","24px");
        $(".power-value").css("font-size","85px");
		$(".power-value-smaller").css("font-size","65px");
		$(".appbox-title").css("font-size","18px");
		$(".appbox-units").css("font-size","18px");
		$(".appbox-value").css("font-size","36px");
        $(".batteryline").show();
        $(".vistimeW").show();
        $(".vistimeM").show();
        $(".vistimeY").show();
    }
    draw();
}

function hide() 
{
    clearInterval(live);
}

function livefn()
{
    // Check if the updater ran in the last 60s if it did not the app was sleeping
    // and so the data needs a full reload.
    var now = +new Date();
    if ((now-lastupdate)>60000) reload = true;
    lastupdate = now;
    
    var feeds = feed.listbyid();
    var solar1_now = parseInt(feeds[config.app.solar1.value].value);
    var battery1_now = parseInt(feeds[config.app.battery1.value].value);
    var battery1_soc_now = parseInt(feeds[config.app.battery1_soc.value].value);
    var solar2_now = parseInt(feeds[config.app.solar2.value].value);
    var battery2_now = parseInt(feeds[config.app.battery2.value].value);
    var battery2_soc_now = parseInt(feeds[config.app.battery2_soc.value].value);
    var use_now = parseInt(feeds[config.app.use.value].value);
	var grid_now = parseInt(feeds[config.app.grid.value].value);

    if (grid_now > 0)
    {
        $(".balance").html("<span style='color:#d52e2e'>" + grid_now + "<span style='font-size:50%'>W</span></span>");
    }
    else
    {
        $(".balance").html("<span style='color:#999'>" + grid_now + "<span style='font-size:50%'>W</span></span>");
    }

    if (autoupdate) {
        var updatetime = feeds[config.app.grid.value].time;

        timeseries.append("solar1",updatetime, solar1_now);
        timeseries.trim_start("solar1",view.start*0.001);
		timeseries.append("battery1",updatetime,battery1_now);
        timeseries.trim_start("battery1",view.start*0.001);
		timeseries.append("battery1_soc",updatetime,battery1_soc_now);
        timeseries.trim_start("battery1_soc",view.start*0.001);
        timeseries.append("solar2",updatetime, solar2_now);
        timeseries.trim_start("solar2",view.start*0.001);
		timeseries.append("battery2",updatetime,battery2_now);
        timeseries.trim_start("battery2",view.start*0.001);
		timeseries.append("battery2_soc",updatetime,battery2_soc_now);
        timeseries.trim_start("battery2_soc",view.start*0.001);
        timeseries.append("use",updatetime,use_now);
        timeseries.trim_start("use",view.start*0.001);
		timeseries.append("grid",updatetime,grid_now);
        timeseries.trim_start("grid",view.start*0.001);

        // Advance view
        var timerange = view.end - view.start;
        view.end = now;
        view.start = view.end - timerange;
    }

    $(".usenow").html(use_now);

    $(".solar1now").html(solar1_now);
	$(".battery1now").html(battery1_now);
	$(".battery1socnow").html(battery1_soc_now > 0 ? battery1_soc_now : "--");

	$(".solar2now").html(solar2_now);
	$(".battery2now").html(battery2_now);
    $(".battery2socnow").html(battery2_soc_now > 0 ? battery2_soc_now : "--");
    
    // Only redraw the graph if its the power graph and auto update is turned on
    if (viewmode=="powergraph" && autoupdate) draw();
}

function draw()
{
    if (viewmode=="powergraph") draw_powergraph();
    if (viewmode=="bargraph") draw_bargraph();
}

function draw_powergraph() {
    var dp = 1;
    var units = "C";
    var fill = false;
    var plotColour = 0;
    
    var options = {
        lines: { fill: fill },
        xaxis: { mode: "time", timezone: "browser", min: view.start, max: view.end},
        yaxes: [{ min: -3000, max: 5000}, { position: "right", tickDecimals: 0, min: 0, max: 100}],
        grid: {hoverable: true, clickable: true},
        selection: { mode: "x" },
		legend: { show: false }
    }
    
    var npoints = 1500;
    interval = Math.round(((view.end - view.start)/npoints)/1000);
    interval = view.round_interval(interval);
    if (interval<10) interval = 10;
    var intervalms = interval * 1000;

    view.start = Math.ceil(view.start/intervalms)*intervalms;
    view.end = Math.ceil(view.end/intervalms)*intervalms;

    var npoints = parseInt((view.end-view.start)/(interval*1000));
    
    // -------------------------------------------------------------------------------------------------------
    // LOAD DATA ON INIT OR RELOAD
    // -------------------------------------------------------------------------------------------------------
    if (reload) {
        reload = false;
        view.start = 1000*Math.floor((view.start/1000)/interval)*interval;
        view.end = 1000*Math.ceil((view.end/1000)/interval)*interval;
        timeseries.load("solar1",feed.getdata(config.app.solar1.value,view.start,view.end,interval,0,0));
        timeseries.load("battery1",feed.getdata(config.app.battery1.value,view.start,view.end,interval,0,0));
		timeseries.load("battery1_soc",feed.getdata(config.app.battery1_soc.value,view.start,view.end,interval,0,0));
		timeseries.load("solar2",feed.getdata(config.app.solar2.value,view.start,view.end,interval,0,0));
        timeseries.load("battery2",feed.getdata(config.app.battery2.value,view.start,view.end,interval,0,0));
		timeseries.load("battery2_soc",feed.getdata(config.app.battery2_soc.value,view.start,view.end,interval,0,0));
        timeseries.load("use",feed.getdata(config.app.use.value,view.start,view.end,interval,0,0));
		timeseries.load("grid",feed.getdata(config.app.grid.value,view.start,view.end,interval,0,0));
    }
    // -------------------------------------------------------------------------------------------------------

    var use_data = [];
	var grid_data = [];
    var solar_data = [];
	var battery_data = [];
	var battery1_soc_data = [];
	var battery2_soc_data = [];
	var export_data = [];
	var battery1_data = [];
	var battery2_data = [];
	var solar1_data = [];
	var solar2_data = [];

    var t = 0;
    var use_now = 0;
    var grid_now = 0;
	var export_now = 0;
    var gen_now = 0;
    var solar1_now = 0;
    var battery1_now = 0;
	var battery1_soc_now = 0;
    var solar2_now = 0;
    var battery2_now = 0;
	var battery2_soc_now = 0;

    var total_battery_now = 0;
    var total_solar_now = 0;
    var battery_now_display = 0;
    var export_now_display = 0;

    var total_solar_kwh = 0;
	var total_battery_kwh = 0;
    var total_use_kwh = 0;
	var total_import_cheap_kwh = 0;
	var total_export_kwh = 0;
	var total_export_income_kwh = 0;
	var total_import_kwh = 0;
	var total_solar_use_kwh = 0;
    
    var datastart = timeseries.start_time("grid");
    
    /* console.log(timeseries.length("solar"));
	console.log(timeseries.length("battery"));
    console.log(timeseries.length("use")); */
    
    for (var z=0; z<timeseries.length("grid"); z++) {

        // -------------------------------------------------------------------------------------------------------
        // Get solar or use values
        // -------------------------------------------------------------------------------------------------------
        if (timeseries.value("solar1",z)!=null) solar1_now = timeseries.value("solar1",z);
        if (timeseries.value("battery1",z)!=null) battery1_now = timeseries.value("battery1",z);
        if (timeseries.value("battery1_soc",z)!=null) battery1_soc_now = timeseries.value("battery1_soc",z);
        if (timeseries.value("solar2",z)!=null) solar2_now = timeseries.value("solar2",z);
        if (timeseries.value("battery2",z)!=null) battery2_now = timeseries.value("battery2",z);
        if (timeseries.value("battery2_soc",z)!=null) battery2_soc_now = timeseries.value("battery2_soc",z);
        if (timeseries.value("use",z)!=null) use_now = timeseries.value("use",z);
		if (timeseries.value("grid",z)!=null) grid_now = timeseries.value("grid",z);

        
        // -------------------------------------------------------------------------------------------------------
        // Supply / demand balance calculation
        // -------------------------------------------------------------------------------------------------------

        total_battery_now = battery1_now + battery2_now;
        total_solar_now = solar1_now + solar2_now;

        if (total_battery_now > 0)
        {
            total_battery_kwh += (total_battery_now*interval)/(1000*3600);

            // adding battery and solar together purely for presentational effect, this shouldn't affect other figures
            battery_now_display = total_battery_now + total_solar_now;
        }
        else
        {
            battery_now_display = total_battery_now;
        }

        var direct_solar_use = total_solar_now - export_now + total_battery_now;

        if (direct_solar_use > 0) {
            total_solar_use_kwh += (direct_solar_use*interval)/(1000*3600);
        }

        export_now = grid_now < 0 ? -grid_now : 0;

        if (total_battery_now < 0)
        {
            // adding battery and export together purely for presentational effect, this shouldn't affect other figures
            export_now_display = export_now - total_battery_now;
        }
        else
        {
            export_now_display = export_now;
        }

        gen_now = grid_now < 0 ? use_now : use_now - grid_now;
        
        var time = datastart + (1000 * interval * z);
		
		var date = new Date(time);
		var hours = date.getHours();
        var mins = date.getMinutes();
		//console.log(hours);

        var is_cheap_rate = (hours === 0 && mins >= 30) || (hours > 0 && hours < 4) || (hours === 4 && mins <= 30);
		
        if (is_cheap_rate)
		{
			total_import_cheap_kwh += (grid_now *interval)/(1000*3600);
		}
		else if (grid_now > 0)
		{
			total_import_kwh += (grid_now *interval)/(1000*3600);
		}

        // export income began on 24/05/2019 -note: months are indexed from 0 in JS
        if (date > new Date('2019-05-22')) {
            total_export_income_kwh += (export_now*interval)/(1000*3600);
        }
		
		total_use_kwh += (use_now*interval)/(1000*3600);
		total_export_kwh += (export_now*interval)/(1000*3600);
        total_solar_kwh += (total_solar_now*interval)/(1000*3600);
		
        use_data.push([time,use_now]);
        grid_data.push([time,grid_now]);
        solar_data.push([time,total_solar_now]);
		battery_data.push([time,battery_now_display]);
		battery1_soc_data.push([time,battery1_soc_now]);
		battery2_soc_data.push([time,battery2_soc_now]);
		export_data.push([time,-export_now_display]);

        solar1_data.push([time,solar1_now]);
        solar2_data.push([time,solar2_now]);
        battery1_data.push([time,battery1_now]);
        battery2_data.push([time,battery2_now]);

        t += interval;
    }
    var total_energy_kwh = total_solar_kwh + total_battery_kwh + total_import_cheap_kwh + total_import_kwh;

    $(".total_solar_prc").html(Math.round(100*total_solar_kwh/total_energy_kwh)+"%");
	$(".total_solar_kwh").html(total_solar_kwh.toFixed(1));

	var solar_cost = total_solar_kwh * config.app.import_unitcost.value;
	$(".total_solar_cost").html(solar_cost.toFixed(2));
	
	$(".total_battery_prc").html(Math.round(100*total_battery_kwh/total_energy_kwh)+"%");
	$(".total_battery_kwh").html(total_battery_kwh.toFixed(1));

    var battery_cost = total_battery_kwh * config.app.import_unitcost.value;
    $(".total_battery_cost").html(battery_cost.toFixed(2));
            
    $(".total_import_cheap_prc").html(Math.round(100*(total_import_cheap_kwh/total_energy_kwh))+"%");
    $(".total_import_cheap_kwh").html(total_import_cheap_kwh.toFixed(1));
	
	var import_cheap_cost = total_import_cheap_kwh * config.app.import_cheap_unitcost.value;
	$(".total_import_cheap_cost").html(import_cheap_cost.toFixed(2));

	$(".total_import_prc").html(Math.round(100*(total_import_kwh/total_energy_kwh))+"%");
    $(".total_import_kwh").html(total_import_kwh.toFixed(1));
	
	var import_cost = total_import_kwh * config.app.import_unitcost.value;
	$(".total_import_cost").html(import_cost.toFixed(2));
	
	if (total_export_kwh > 0) 
	{
		$(".total_export_prc").html(((total_export_kwh/total_energy_kwh)*100).toFixed(0)+"%");
	} 
	else 
	{
		$(".total_export_prc").html("0%");
	}
	
    $(".total_export_kwh").html((total_export_kwh).toFixed(1));

    var export_income = total_export_income_kwh * config.app.export_income.value;
    $(".export_income").html(export_income.toFixed(2));
	
	$(".total_use_kwh").html(total_use_kwh.toFixed(1));
	$(".total_use_cost").html((import_cheap_cost + import_cost - export_income).toFixed(2));
	$(".total_use_standing_cost").html((config.app.standing_charge.value * (t / 86460)).toFixed(2));
	
    options.xaxis.min = view.start;
    options.xaxis.max = view.end;

    var series = [
        {data:export_data, label: "Export", color: "#999", lines:{lineWidth:0, fill:1}},
        {data:battery_data, label: "Battery", color: "#99FF00", lines:{lineWidth:0, fill:1}},
        {data:solar_data, label: "Solar", color: "#dccc1f", lines:{lineWidth:0, fill:1}},
        {data:use_data, label: "Use", color: "#0699ff", lines:{lineWidth:0, fill:0.6}}
    ];
	
	//console.log(series);
    
    if (show_battery_line) {
        series.push(
            {data:battery1_soc_data, yaxis:2, color: "#ff00b7", lines:{lineWidth:1}},
            {data:battery2_soc_data, yaxis:2, color: "#ff851b", lines:{lineWidth:1}}
        );
    }

    if (show_grid_line) {
        series.push(
            {data:grid_data, yaxis:1, color: "#FFF", lines:{lineWidth:1}}
        );
    }
	
	tipseries = [
		{data:use_data, label: "Use", unit: "W"},
		{data:grid_data, label: "Grid", unit: "W"},
		{data:solar1_data, label: "Solar 1", unit: "W"},
		{data:battery1_data, label: "Battery 1", unit: "W"},
		{data:battery1_soc_data, label: "- SOC", unit: "%"},
        {data:solar2_data, label: "Solar 2", unit: "W"},
		{data:battery2_data, label: "Battery 2", unit: "W"},
		{data:battery2_soc_data, label: "- SOC", unit: "%"}
	];
    
    $.plot($('#placeholder'),series,options);
    $(".ajax-loader").hide();
}

// ------------------------------------------------------------------------------------------
// POWER GRAPH EVENTS
// ------------------------------------------------------------------------------------------
function powergraph_events() {

    $('#placeholder').unbind("plotclick");
    $('#placeholder').unbind("plothover");
    $('#placeholder').unbind("plotselected");

    $('#placeholder').bind("plothover", function (event, pos, item)
    {
        if (item) {
            // Show tooltip
            var tooltip_items = [];

            var date = new Date(item.datapoint[0]);
            tooltip_items.push(["TIME", dateFormat(date, 'HH:MM:ss'), ""]);

            for (i = 0; i < tipseries.length; i++) {
                var series = tipseries[i];
                tooltip_items.push([series.label.toUpperCase(), series.data[item.dataIndex][1].toFixed(0), series.unit]);
            }
            show_tooltip(pos.pageX-150, pos.pageY+5, tooltip_items);
        } else {
            // Hide tooltip
            hide_tooltip();
        }
    });

    $('#placeholder').bind("plotselected", function (event, ranges) {
        view.start = ranges.xaxis.from;
        view.end = ranges.xaxis.to;

        autoupdate = false;
        reload = true; 
        
        var now = +new Date();
        if (Math.abs(view.end-now)<30000) {
            autoupdate = true;
        }

        draw();
    });
}

// ======================================================================================
// PART 2: BAR GRAPH PAGE
// ======================================================================================

// --------------------------------------------------------------------------------------
// INIT BAR GRAPH
// - load cumulative kWh feeds
// - calculate used solar, solar, used and exported kwh/d
// --------------------------------------------------------------------------------------
function init_bargraph() {
    bargraph_initialized = true;
    // Fetch the start_time covering all kwh feeds - this is used for the 'all time' button
    latest_start_time = 0;
    var solar_meta = feed.getmeta(config.app.solar_kwh.value);
    var use_meta = feed.getmeta(config.app.use_kwh.value);
    var import_meta = feed.getmeta(config.app.import_kwh.value);
    if (solar_meta.start_time > latest_start_time) latest_start_time = solar_meta.start_time;
    if (use_meta.start_time > latest_start_time) latest_start_time = use_meta.start_time;
    if (import_meta.start_time > latest_start_time) latest_start_time = import_meta.start_time;

    var earliest_start_time = solar_meta.start_time;
    earliest_start_time = Math.min(use_meta.start_time, earliest_start_time);
    earliest_start_time = Math.min(import_meta.start_time, earliest_start_time);
    view.first_data = earliest_start_time * 1000;

    var timeWindow = (3600000*24.0*40);
    var end = +new Date;
    var start = end - timeWindow;
    load_bargraph(start,end);
}

function load_bargraph(start,end) {

    var interval = 3600*24;
    var intervalms = interval * 1000;
    end = Math.ceil(end/intervalms)*intervalms;
    start = Math.floor(start/intervalms)*intervalms;
    
    // Load kWh data
    var solar_kwh_data = feed.getdataDMY(config.app.solar_kwh.value,start,end,"daily");
    var use_kwh_data = feed.getdataDMY(config.app.use_kwh.value,start,end,"daily");
	var battery_kwh_data = feed.getdataDMY(config.app.battery_kwh.value,start,end,"daily");
    var import_kwh_data = feed.getdataDMY(config.app.import_kwh.value,start,end,"daily");
	var export_kwh_data = feed.getdataDMY(config.app.export_kwh.value,start,end,"daily");
    
   // console.log(solar_kwh_data);
   // console.log(use_kwh_data);
    
    solarused_kwhd_data = [];
    solar_kwhd_data = [];
    use_kwhd_data = [];
	battery_kwhd_data = [];
    import_kwhd_data = [];
	export_kwhd_data = [];
    
    if (solar_kwh_data.length>1) {
    
    for (var day=1; day<solar_kwh_data.length; day++)
    {
        var solar_kwh = solar_kwh_data[day][1] - solar_kwh_data[day-1][1];
        if (solar_kwh_data[day][1]==null || solar_kwh_data[day-1][1]==null) solar_kwh = null;
        
        var use_kwh = use_kwh_data[day][1] - use_kwh_data[day-1][1];
        if (use_kwh_data[day][1]==null || use_kwh_data[day-1][1]==null) use_kwh = null;
		
		var battery_kwh = battery_kwh_data[day][1] - battery_kwh_data[day-1][1];
        if (battery_kwh_data[day][1]==null || battery_kwh_data[day-1][1]==null) battery_kwh = null;
        
        var import_kwh = import_kwh_data[day][1] - import_kwh_data[day-1][1];
        if (import_kwh_data[day][1]==null || import_kwh_data[day-1][1]==null) import_kwh = null;

        var export_kwh = export_kwh_data[day][1] - export_kwh_data[day-1][1];
        if (export_kwh_data[day][1]==null || export_kwh_data[day-1][1]==null) export_kwh = null;
        
        if (solar_kwh!=null && use_kwh!=null & export_kwh!=null) {
            solarused_kwhd_data.push([solar_kwh_data[day-1][0],use_kwh - import_kwh]);
            solar_kwhd_data.push([solar_kwh_data[day-1][0],solar_kwh]);
            use_kwhd_data.push([use_kwh_data[day-1][0],use_kwh]);
			export_kwhd_data.push([export_kwh_data[day-1][0],export_kwh]);
			import_kwhd_data.push([import_kwh_data[day-1][0],import_kwh]);
			battery_kwhd_data.push([battery_kwh_data[day-1][0],battery_kwh]);
        }
    }
    
    }
    
    var series = [];

    series.push({
        data: use_kwhd_data,
        color: "#0699fa",
        bars: { show: true, align: "center", barWidth: 0.75*3600*24*1000, fill: 0.8, lineWidth:0}
    });

    series.push({
        data: solarused_kwhd_data,
        color: "#dccc1f",
        bars: { show: true, align: "center", barWidth: 0.75*3600*24*1000, fill: 0.6, lineWidth:0}
    });
    
	series.push({
        data: export_kwhd_data,
        color: "#dccc1f",
        bars: { show: true, align: "center", barWidth: 0.75*3600*24*1000, fill: 0.8, lineWidth:0}
    });
	
    historyseries = series;
}

// ------------------------------------------------------------------------------------------
// DRAW BAR GRAPH
// Because the data for the bargraph only needs to be loaded once at the start we seperate out
// the data loading part to init and the draw part here just draws the bargraph to the flot
// placeholder overwritting the power graph as the view is changed.
// ------------------------------------------------------------------------------------------    
function draw_bargraph() 
{
    var markings = [];
    markings.push({ color: "#ccc", lineWidth: 1, yaxis: { from: 0, to: 0 } });
    
    var options = {
        xaxis: { mode: "time", timezone: "browser"},
        grid: {hoverable: true, clickable: true, markings:markings},
        selection: { mode: "x" }
    }
    
    var plot = $.plot($('#placeholder'),historyseries,options);
    
    $('#placeholder').append("<div style='position:absolute;left:50px;top:30px;color:#666;font-size:12px'><b>Above:</b> Solar Used on Total Used</div>");
    $('#placeholder').append("<div style='position:absolute;left:50px;bottom:50px;color:#666;font-size:12px'><b>Below:</b> Exported solar</div>");

    // Because the bargraph is only drawn once when the view is changed we attach the events at this point
    bargraph_events();
}

// ------------------------------------------------------------------------------------------
// BAR GRAPH EVENTS
// - show bar values on hover
// - click through to power graph
// ------------------------------------------------------------------------------------------
function bargraph_events(){

    $('#placeholder').unbind("plotclick");
    $('#placeholder').unbind("plothover");
    $('#placeholder').unbind("plotselected");
    $('.bargraph-viewall').unbind("click");
    
    // Show day's figures on the bottom of the page
    $('#placeholder').bind("plothover", function (event, pos, item)
    {
        if (item) {
            // console.log(item.datapoint[0]+" "+item.dataIndex);
            var z = item.dataIndex;
            
            var solar_kwhd = solar_kwhd_data[z][1];
            var solarused_kwhd = solarused_kwhd_data[z][1];
            var use_kwhd = use_kwhd_data[z][1];
			var battery_kwhd = battery_kwhd_data[z][1];
            var export_kwhd = export_kwhd_data[z][1];
            var import_kwhd = import_kwhd_data[z][1];
            
            $(".total_solar_kwh").html((solar_kwhd).toFixed(1));
            $(".total_use_kwh").html((use_kwhd).toFixed(1));
            
            $(".total_use_free_kwh").html((solarused_kwhd).toFixed(1));
            
            $(".total_export_kwh").html((export_kwhd*-1).toFixed(1));
			
			$(".total_battery_kwh").html((battery_kwhd*-1).toFixed(1));
            
            $(".total_import_prc").html(((import_kwhd/use_kwhd)*100).toFixed(0)+"%");
            $(".total_import_kwh").html((import_kwhd).toFixed(1));
    
            if (solar_kwhd > 0) {
                $(".total_use_direct_prc").html(((solarused_kwhd/use_kwhd)*100).toFixed(0)+"%");
                $(".total_export_prc").html(((export_kwhd/solar_kwhd)*100*-1).toFixed(0)+"%");
            } else {
                $(".total_use_direct_prc").html("-- %");
                $(".total_export_prc").html("-- %");
            }
            
        }
    });

    // Auto click through to power graph
    $('#placeholder').bind("plotclick", function (event, pos, item)
    {
        if (item && !panning) {
            // console.log(item.datapoint[0]+" "+item.dataIndex);
            var z = item.dataIndex;
            
            view.start = solar_kwhd_data[z][0];
            view.end = view.start + 86400*1000;

            $(".bargraph-navigation").hide();
            $(".powergraph-navigation").show();
            $(".viewhistory").html("HIST");
            $('#placeholder').unbind("plotclick");
            $('#placeholder').unbind("plothover");
            $('#placeholder').unbind("plotselected");
            
            reload = true; 
            autoupdate = false;
            viewmode = "powergraph";
            
            draw();
            powergraph_events();
        }
    });
    
    $('#placeholder').bind("plotselected", function (event, ranges) {
        var start = ranges.xaxis.from;
        var end = ranges.xaxis.to;
        load_bargraph(start,end);
        draw();
        panning = true; setTimeout(function() {panning = false; }, 100);
    });
    
    $('.bargraph-viewall').click(function () {
        var start = latest_start_time * 1000;
        var end = +new Date;
        load_bargraph(start,end);
        draw();
    });
}

// ------------------------------------------------------------------------------------------
// TOOLTIP HANDLING
// Show & hide the tooltip
// ------------------------------------------------------------------------------------------
function show_tooltip(x, y, values) {
    var tooltip = $('#tooltip');
    if (!tooltip[0]) {
        tooltip = $('<div id="tooltip"></div>')
            .css({
                position: "absolute",
                display: "none",
                border: "1px solid #545454",
                padding: "8px",
                "background-color": "#333",
            })
            .appendTo("body");
    }

    tooltip.html('');
    var table = $('<table/>').appendTo(tooltip);

    for (i = 0; i < values.length; i++) {
        var value = values[i];
        var row = $('<tr class="tooltip-item"/>').appendTo(table);
        $('<td style="padding-right: 8px"><span class="tooltip-title">'+value[0]+'</span></td>').appendTo(row);
        $('<td><span class="tooltip-value">'+value[1]+'</span> <span class="tooltip-units">'+value[2]+'</span></td>').appendTo(row);
    }

    tooltip
        .css({
            left: x,
            top: y
        })
        .show();
}

function hide_tooltip() {
    $('#tooltip').hide();
}

$(window).resize(function(){
    resize();
});

// ----------------------------------------------------------------------
// App log
// ----------------------------------------------------------------------
function app_log (level, message) {
    if (level=="ERROR") alert(level+": "+message);
    console.log(level+": "+message);
}
</script>

