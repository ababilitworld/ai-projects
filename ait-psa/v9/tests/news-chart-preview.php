<?php
// Isolated visual fixture: uses the production renderers without changing saved user data.
$page = file_get_contents(__DIR__ . '/../index.php');
$news = file_get_contents(__DIR__ . '/../assets/js/ait-news.js');
$core = substr($news, 0, strpos($news, '  if (!root.document) return;')) . '})(window);';
preg_match('/class CandleChart\{[\s\S]*?\n\}\nclass App/', $page, $candle);
$renderer = substr($candle[0], 0, -strlen("\nclass App"));
preg_match('/ function drawChart\(canvas,code\)\{[\s\S]*?\n function renderCharts/', $page, $multi);
$multiRenderer = substr($multi[0], 0, -strlen("\n function renderCharts"));
?>
<!doctype html><html><head><meta charset="utf-8"><title>News chart verification fixture</title>
<link rel="stylesheet" href="../assets/css/ait-news.css">
<style>:root{--v10-line:#e1e5eb;--v10-success:#538675;--v10-danger:#b27178;--v10-primary:#6282a0;--v10-primary-2:#9181a5;--v10-muted:#5a6674}body{margin:20px;font:14px system-ui;color:#384452;background:#f3f5f7}h1{font-size:22px}.chart-box{height:380px;background:white;border:1px solid #d2d9e2;border-radius:10px}.chart-box canvas{width:100%;height:100%}.v11-chart-slot{background:white}.v11-chart-slot canvas{width:100%;height:270px}button{border:1px solid #ccd4dd;background:white;border-radius:6px}article{margin-bottom:20px}#status{color:#538675}</style></head><body>
<h1>News overlay — visual test data</h1><p>Four news days: closes 110 → 120 → 100 → 100. Expected segments: green → red → dark gray. Symbols start 10% below each day’s low.</p>
<article><h2>Individual, 3M / 6M / 1Y galleries and ranked scanner charts</h2><div class="chart-box"><canvas id="single"></canvas></div></article>
<article><h2>Multi-chart workspace</h2><label><input id="v11Grid" type="checkbox" checked>Grid</label> <label><input id="v11Sma20" type="checkbox" checked>SMA 20</label> <label><input id="v11Sma50" type="checkbox" checked>SMA 50</label><div class="v11-chart-slot"><div class="v11-chart-label"></div><canvas id="multi"></canvas></div></article>
<p id="status"></p>
<script><?= $core ?>
<?= $renderer ?>
const bars=Array.from({length:60},(_,i)=>{const close=105+Math.sin(i/5)*8;return {date:new Date(Date.UTC(2026,6,i+1)).toISOString().slice(0,10),open:close-1,close,high:close+3,low:close-3,volume:1000+i*50}});
const fixture=[];
[10,25,40,55].forEach((index,i)=>{const close=[110,120,100,100][i];Object.assign(bars[index],{open:close-1,close,high:close+3,low:close-3});fixture.push({id:String(i),code:'TEST',date:bars[index].date,title:['Q1 Financial Results','Q2 Financial Results','Q3 Financial Results','General announcement'][i],body:''})});
fixture.push({...fixture[1],id:'board',title:'Board Meeting schedule'});fixture.push({...fixture[1],id:'rating',title:'Credit Rating'});
AITNews.forCode=()=>AITNews.mergeRows([],fixture);
const rowsFor=()=>bars,avg=values=>values.reduce((a,b)=>a+b,0)/values.length;
<?= $multiRenderer ?>
function redraw(){CandleChart.draw(document.getElementById('single'),bars,{code:'TEST'});drawChart(document.getElementById('multi'),'TEST');document.getElementById('status').textContent='Both production renderers completed. Four close points and six category markers per chart.';}
redraw();['v11Grid','v11Sma20','v11Sma50'].forEach(id=>document.getElementById(id).onchange=redraw);window.addEventListener('resize',redraw);
</script></body></html>
