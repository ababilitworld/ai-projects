<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Ababil DSE Market Intelligence Terminal v11.26</title>
<link rel="stylesheet" href="assets/css/ait-sortable-filterable-table.css">
<script defer src="assets/js/ait-scanner-universe.js"></script>
<script defer src="assets/js/ait-watchlist-download-cache.js"></script>
<script defer src="assets/js/ait-news.js"></script>
<link rel="stylesheet" href="assets/css/ait-news.css">
<style>
:root{--bg:#edf3f8;--card:#fff;--ink:#172033;--muted:#64748b;--line:#dce5ee;--primary:#087f75;--blue:#2563eb;--red:#dc2626;--green:#15803d;--orange:#d97706;--shadow:0 15px 40px rgba(15,23,42,.1)}
*{box-sizing:border-box}body{margin:0;font-family:Inter,system-ui,sans-serif;color:var(--ink);background:var(--bg)}
button,input,select,textarea{font:inherit}button{cursor:pointer}.app{width:min(1540px,calc(100% - 20px));margin:12px auto 28px}
header{display:flex;justify-content:space-between;gap:18px;align-items:center;padding:24px;border-radius:22px;color:#fff;background:linear-gradient(135deg,#0f172a,#087f75 58%,#2563eb);box-shadow:var(--shadow)}
header h1{margin:0 0 6px;font-size:clamp(1.7rem,4vw,2.8rem)}header p{margin:0;opacity:.82}.badge{padding:12px 16px;border:1px solid rgba(255,255,255,.25);border-radius:14px;background:rgba(255,255,255,.1);text-align:center}.badge strong{display:block;font-size:1.4rem}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:13px;margin-top:16px}.card{background:var(--card);border:1px solid var(--line);border-radius:17px;box-shadow:var(--shadow)}
.stat{padding:17px}.stat label{color:var(--muted);font-size:.82rem}.stat strong{display:block;margin-top:5px;font-size:1.8rem}.layout{display:grid;grid-template-columns:290px 1fr;gap:16px;margin-top:16px}
.sidebar{padding:16px;align-self:start;position:sticky;top:10px}.row{display:flex;justify-content:space-between;align-items:center;gap:9px}.row h2,.row h3{margin:0}.small{color:var(--muted);font-size:.8rem}
.btn{border:0;border-radius:10px;min-height:39px;padding:8px 12px;font-weight:800}.primary{background:var(--primary);color:#fff}.blue{background:var(--blue);color:#fff}.red{background:var(--red);color:#fff}.soft{background:#eef2f7;color:var(--ink);border:1px solid var(--line)}.icon{width:39px;padding:0}
.lists{display:grid;gap:8px;margin-top:13px}.list{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:6px;align-items:center;padding:9px;border:1px solid var(--line);border-radius:11px}.list.active{background:var(--ait-active-bg);border-color:var(--ait-active-border);color:var(--ait-text)}.select-list{border:0;background:none;text-align:left;min-width:0}.list-name{font-weight:900;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block}.actions{display:flex;gap:5px;flex-wrap:wrap}
.main{display:grid;gap:16px;min-width:0}.toolbar{display:flex;gap:9px;flex-wrap:wrap;padding:14px}.input,.select,.textarea{border:1px solid var(--line);border-radius:10px;background:#fff;color:var(--ink)}.input,.select{min-height:42px;padding:8px 10px}.search{flex:1;min-width:220px}.textarea{width:100%;min-height:180px;padding:10px;resize:vertical}
.panels{display:grid;grid-template-columns:1.05fr .95fr;gap:16px}.panel{padding:16px;min-width:0}.panel h2{margin:0;font-size:1.15rem}.head{display:flex;justify-content:space-between;align-items:flex-start;gap:9px}.scroll{display:grid;gap:7px;margin-top:12px;max-height:620px;overflow:auto;padding-right:3px}
.code-row{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:8px;align-items:center;padding:10px;border:1px solid var(--line);border-radius:10px}.code{font-weight:950;color:#115e59}.meta{display:block;color:var(--muted);font-size:.73rem;margin-top:2px}.empty{padding:38px 10px;text-align:center;color:var(--muted)}
.activity{display:grid;gap:7px;margin-top:12px}.activity div{padding:9px;border-left:3px solid var(--primary);border-radius:7px;background:#f8fafc}.activity strong{display:block;font-size:.83rem}.activity span{font-size:.7rem;color:var(--muted)}
.modal{position:fixed;inset:0;z-index:100;display:none;place-items:center;padding:14px;background:rgba(15,23,42,.68)}.modal.open{display:grid}.dialog{width:min(720px,100%);max-height:calc(100vh - 28px);overflow:auto;padding:19px;border-radius:18px;background:#fff}.wide{width:min(1180px,100%)}.modal-head{display:flex;justify-content:space-between;gap:10px;align-items:center;margin-bottom:13px}.modal-head h2{margin:0}.form{display:grid;gap:12px}.field label{display:block;margin-bottom:5px;font-weight:850}.form-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:12px}.tabs{display:flex;gap:7px;flex-wrap:wrap;margin-bottom:12px}.tab{border:1px solid var(--line);border-radius:999px;padding:7px 11px;background:#f8fafc;font-weight:800}.tab.active{color:#fff;background:var(--primary)}.tab-panel{display:none}.tab-panel.active{display:block}.note{padding:10px;border-radius:9px;background:#fff7ed;color:#9a3412;font-size:.8rem;line-height:1.45}.success-note{background:#ecfdf5;color:#166534}.link-btn{text-decoration:none;display:inline-flex;align-items:center;justify-content:center}
.chart-toolbar{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:10px}.chart-toolbar .select{min-width:170px}.chart-box{height:520px;border:1px solid var(--line);border-radius:12px;background:#fff;position:relative;overflow:hidden}.chart-box canvas{width:100%;height:100%;display:block}.chart-info{display:flex;gap:14px;flex-wrap:wrap;padding:9px 0;font-size:.8rem;color:var(--muted)}
.gallery{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:13px}.mini-card{border:1px solid var(--line);border-radius:12px;padding:10px}.mini-card h3{margin:0 0 7px}.mini-chart{height:300px}table th,table td{padding:8px 10px;border-bottom:1px solid var(--line);text-align:right;white-space:nowrap}table th:first-child,table td:first-child,table th:nth-child(2),table td:nth-child(2){text-align:left}.toast-wrap{position:fixed;right:15px;top:15px;z-index:200;display:grid;gap:7px}.toast{padding:12px 14px;border-radius:9px;color:#fff;background:var(--green);box-shadow:var(--shadow)}.toast.error{background:var(--red)}
@media(max-width:1050px){.stats{grid-template-columns:repeat(2,1fr)}.layout{grid-template-columns:1fr}.sidebar{position:static}.panels{grid-template-columns:1fr}}
@media(max-width:700px){.gallery{grid-template-columns:1fr}.chart-box{height:420px}}
@media(max-width:560px){.app{width:calc(100% - 10px);margin:5px auto}.stats{grid-template-columns:1fr}header{align-items:flex-start;flex-direction:column}.toolbar{flex-direction:column;align-items:stretch}.form-actions{flex-direction:column-reverse}.form-actions .btn{width:100%}.code-row{grid-template-columns:1fr}}

/* =========================
   V9 PREMIUM TERMINAL THEME
   ========================= */
:root{
 --bg:#07111f;
 --bg2:#0b1728;
 --panel:rgba(13,27,46,.86);
 --panel2:rgba(17,35,58,.92);
 --glass:rgba(255,255,255,.055);
 --glass2:rgba(255,255,255,.085);
 --line:rgba(148,163,184,.17);
 --line2:rgba(96,165,250,.28);
 --text:#edf6ff;
 --muted:#8fa6bd;
 --primary:#38bdf8;
 --primary2:#2563eb;
 --accent:#a78bfa;
 --success:#22c55e;
 --danger:#f43f5e;
 --warning:#f59e0b;
 --shadow:0 24px 70px rgba(0,0,0,.34);
 --soft-shadow:0 10px 30px rgba(0,0,0,.22);
}

*{scrollbar-width:thin;scrollbar-color:#29415d transparent}
*::-webkit-scrollbar{width:9px;height:9px}
*::-webkit-scrollbar-thumb{background:#29415d;border-radius:999px}
*::-webkit-scrollbar-track{background:transparent}

html{background:
 radial-gradient(circle at 10% 0%,rgba(56,189,248,.15),transparent 30%),
 radial-gradient(circle at 100% 15%,rgba(167,139,250,.12),transparent 26%),
 linear-gradient(145deg,var(--bg),var(--bg2) 55%,#081522);
 min-height:100%;
}
body{
 color:var(--text)!important;
 background:transparent!important;
 font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif!important;
 letter-spacing:.005em;
}
body:before{
 content:"";
 position:fixed;inset:0;pointer-events:none;z-index:-1;
 background-image:
 linear-gradient(rgba(255,255,255,.018) 1px,transparent 1px),
 linear-gradient(90deg,rgba(255,255,255,.018) 1px,transparent 1px);
 background-size:34px 34px;
 mask-image:linear-gradient(to bottom,black,transparent 80%);
}

.app-shell,.wrap,.container{max-width:1500px!important;margin:auto!important}
header,.hero{
 border:1px solid var(--line)!important;
 background:linear-gradient(135deg,rgba(14,31,52,.94),rgba(9,23,40,.82))!important;
 box-shadow:var(--shadow)!important;
 backdrop-filter:blur(20px);
 border-radius:26px!important;
 position:relative;
 overflow:hidden;
}
header:after,.hero:after{
 content:"";
 position:absolute;right:-80px;top:-100px;width:330px;height:330px;border-radius:50%;
 background:radial-gradient(circle,rgba(56,189,248,.18),transparent 68%);
 pointer-events:none;
}
h1,h2,h3,strong{color:var(--text)}
.small,.muted,p{color:var(--muted)}

.card{
 background:linear-gradient(145deg,var(--panel),rgba(11,25,43,.9))!important;
 border:1px solid var(--line)!important;
 box-shadow:var(--soft-shadow)!important;
 backdrop-filter:blur(18px);
 border-radius:22px!important;
 transition:border-color .2s ease,transform .2s ease,box-shadow .2s ease;
}
.card:hover{border-color:var(--line2)!important;box-shadow:0 16px 40px rgba(0,0,0,.27)!important}
.toolbar{position:sticky!important;top:12px!important;z-index:30!important}

.btn,button{
 border-radius:13px!important;
 min-height:42px;
 font-weight:700!important;
 letter-spacing:.01em;
 transition:transform .18s ease,filter .18s ease,box-shadow .18s ease,border-color .18s ease!important;
}
.btn:hover,button:hover{transform:translateY(-1px);filter:brightness(1.07)}
.btn:active,button:active{transform:translateY(0) scale(.985)}
.btn.primary,.primary{
 background:linear-gradient(135deg,var(--primary),var(--primary2))!important;
 color:#fff!important;
 border-color:rgba(125,211,252,.38)!important;
 box-shadow:0 10px 24px rgba(37,99,235,.28)!important;
}
.btn.soft,.soft{
 color:#dceeff!important;
 background:rgba(255,255,255,.065)!important;
 border:1px solid var(--line)!important;
}
.btn.danger,.danger{background:rgba(244,63,94,.13)!important;color:#fecdd3!important;border-color:rgba(244,63,94,.3)!important}

input,select,textarea{
 color:var(--text)!important;
 background:rgba(5,15,28,.75)!important;
 border:1px solid rgba(148,163,184,.22)!important;
 border-radius:13px!important;
 min-height:42px;
 box-shadow:inset 0 1px 0 rgba(255,255,255,.025);
 transition:border-color .18s ease,box-shadow .18s ease!important;
}
input:focus,select:focus,textarea:focus{
 outline:none!important;border-color:var(--primary)!important;
 box-shadow:0 0 0 4px rgba(56,189,248,.12)!important;
}
option{background:#0b1728;color:#fff}

.pill,.badge,.chip{
 border:1px solid rgba(125,211,252,.19)!important;
 color:#cbeeff!important;
 background:rgba(56,189,248,.09)!important;
 border-radius:999px!important;
}

table{border-collapse:separate!important;border-spacing:0!important}
thead th{
 position:sticky;top:0;z-index:2;
 color:#cfe8ff!important;
 background:#10233b!important;
 border-bottom:1px solid var(--line2)!important;
}
tbody td{border-bottom:1px solid rgba(148,163,184,.1)!important;color:#dce9f6!important}
tbody tr{transition:background .15s ease}
tbody tr:hover{background:rgba(56,189,248,.055)!important}

.modal,.modal-card,.dialog,.dialog-card{
 background:linear-gradient(145deg,#0d1c30,#091626)!important;
 color:var(--text)!important;
 border:1px solid var(--line2)!important;
 border-radius:24px!important;
 box-shadow:0 34px 100px rgba(0,0,0,.58)!important;
}
.modal-backdrop,.overlay{backdrop-filter:blur(9px)!important;background:rgba(1,8,17,.75)!important}

canvas{border-radius:16px;background:linear-gradient(180deg,rgba(7,17,31,.8),rgba(5,13,24,.96))!important}
.chart-card,.chart-box{
 border:1px solid var(--line)!important;
 border-radius:20px!important;
 background:rgba(7,18,32,.72)!important;
 box-shadow:0 12px 30px rgba(0,0,0,.22)!important;
 overflow:hidden;
 transition:transform .2s ease,border-color .2s ease;
}
.chart-card:hover,.chart-box:hover{transform:translateY(-2px);border-color:var(--line2)!important}

#downloadStatusCard{
 position:relative;overflow:hidden;
 border-color:rgba(56,189,248,.35)!important;
 background:linear-gradient(135deg,rgba(13,40,65,.95),rgba(16,30,53,.95))!important;
}
#downloadStatusCard:before{
 content:"";position:absolute;inset:0;pointer-events:none;
 background:linear-gradient(90deg,transparent,rgba(255,255,255,.045),transparent);
 transform:translateX(-100%);animation:statusSweep 2.4s infinite;
}
#downloadStatusBar{
 background:linear-gradient(90deg,#38bdf8,#2563eb,#8b5cf6)!important;
 box-shadow:0 0 18px rgba(56,189,248,.6);
}
@keyframes statusSweep{to{transform:translateX(100%)}}

.v9-command{
 display:grid;grid-template-columns:minmax(0,1fr) auto;gap:14px;align-items:center;
 padding:18px 20px;margin-bottom:16px;border:1px solid var(--line);
 border-radius:22px;background:linear-gradient(135deg,rgba(17,38,62,.88),rgba(8,23,40,.88));
 box-shadow:var(--soft-shadow);backdrop-filter:blur(18px)
}
.v9-brand{display:flex;gap:14px;align-items:center}
.v9-logo{
 width:48px;height:48px;border-radius:15px;display:grid;place-items:center;font-weight:900;
 background:linear-gradient(135deg,#38bdf8,#2563eb 58%,#8b5cf6);
 color:white;box-shadow:0 10px 25px rgba(37,99,235,.35)
}
.v9-title{font-size:clamp(1.12rem,2vw,1.55rem);font-weight:850;line-height:1.15}
.v9-sub{font-size:.86rem;color:var(--muted);margin-top:4px}
.v9-state{
 display:flex;align-items:center;gap:8px;padding:9px 13px;border-radius:999px;
 color:#bbf7d0;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.26);
 font-size:.84rem;font-weight:800
}
.v9-dot{width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 0 5px rgba(34,197,94,.11)}

.v9-quick-grid{
 display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-bottom:16px
}
.v9-stat{
 padding:14px 16px;border:1px solid var(--line);border-radius:18px;
 background:rgba(255,255,255,.045);backdrop-filter:blur(12px)
}
.v9-stat span{display:block;color:var(--muted);font-size:.78rem;margin-bottom:6px}
.v9-stat strong{font-size:1.08rem}

.section-title{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px}
.section-title h2,.section-title h3{margin:0}
.section-kicker{color:var(--primary);font-size:.72rem;letter-spacing:.14em;text-transform:uppercase;font-weight:800}

@media(max-width:900px){
 .v9-quick-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
 .v9-command{grid-template-columns:1fr}
 .v9-state{width:max-content}
 .toolbar{position:relative!important;top:auto!important}
}
@media(max-width:560px){
 .v9-quick-grid{grid-template-columns:1fr}
 .v9-command{padding:15px}
 .v9-logo{width:42px;height:42px}
 .btn,button{width:100%}
 .row{align-items:stretch!important}
}


/* =========================================================
   V10 — MOBILE-FIRST WORKSPACE, COLLAPSIBLES & 9 THEMES
   ========================================================= */
:root{
 --v10-bg:#07111f;
 --v10-bg-soft:#0b1728;
 --v10-panel:rgba(13,27,46,.88);
 --v10-panel-solid:#102038;
 --v10-card:rgba(255,255,255,.055);
 --v10-text:#edf6ff;
 --v10-muted:#91a7bd;
 --v10-line:rgba(148,163,184,.18);
 --v10-primary:#38bdf8;
 --v10-primary-2:#2563eb;
 --v10-success:#22c55e;
 --v10-danger:#f43f5e;
 --v10-warning:#f59e0b;
 --v10-shadow:0 18px 55px rgba(0,0,0,.32);
 --v10-radius:18px;
 --v10-glass:blur(18px);
 --v10-grid:rgba(255,255,255,.018);
}

/* 1 — Premium Dark Glass */
html[data-theme="dark-glass"]{
 --v10-bg:#07111f;--v10-bg-soft:#0b1728;--v10-panel:rgba(13,27,46,.88);
 --v10-panel-solid:#102038;--v10-card:rgba(255,255,255,.055);--v10-text:#edf6ff;
 --v10-muted:#91a7bd;--v10-line:rgba(148,163,184,.18);--v10-primary:#38bdf8;
 --v10-primary-2:#2563eb;--v10-grid:rgba(255,255,255,.018);
}
/* 2 — Previous / Classic */
html[data-theme="classic-light"]{
 --v10-bg:#edf3f8;--v10-bg-soft:#f7fafc;--v10-panel:rgba(255,255,255,.96);
 --v10-panel-solid:#ffffff;--v10-card:#ffffff;--v10-text:#172033;--v10-muted:#64748b;
 --v10-line:#dce5ee;--v10-primary:#087f75;--v10-primary-2:#2563eb;
 --v10-shadow:0 15px 40px rgba(15,23,42,.1);--v10-grid:rgba(15,23,42,.025);
}
/* 3 — Sapphire */
html[data-theme="sapphire"]{
 --v10-bg:#06152b;--v10-bg-soft:#0a2242;--v10-panel:rgba(10,34,66,.9);
 --v10-panel-solid:#0d2b52;--v10-card:rgba(96,165,250,.07);--v10-text:#eff8ff;
 --v10-muted:#9eb8d5;--v10-line:rgba(96,165,250,.22);--v10-primary:#60a5fa;
 --v10-primary-2:#1d4ed8;--v10-grid:rgba(96,165,250,.025);
}
/* 4 — Emerald */
html[data-theme="emerald"]{
 --v10-bg:#061a17;--v10-bg-soft:#0a2923;--v10-panel:rgba(8,42,35,.9);
 --v10-panel-solid:#0d382f;--v10-card:rgba(52,211,153,.07);--v10-text:#ecfff8;
 --v10-muted:#99bdb1;--v10-line:rgba(52,211,153,.2);--v10-primary:#34d399;
 --v10-primary-2:#047857;--v10-grid:rgba(52,211,153,.025);
}
/* 5 — Royal Purple */
html[data-theme="royal-purple"]{
 --v10-bg:#160b2a;--v10-bg-soft:#24103e;--v10-panel:rgba(39,18,67,.9);
 --v10-panel-solid:#321757;--v10-card:rgba(196,181,253,.07);--v10-text:#faf5ff;
 --v10-muted:#b9a6cc;--v10-line:rgba(196,181,253,.2);--v10-primary:#c4b5fd;
 --v10-primary-2:#7c3aed;--v10-grid:rgba(196,181,253,.022);
}
/* 6 — Carbon OLED */
html[data-theme="carbon-oled"]{
 --v10-bg:#000000;--v10-bg-soft:#080808;--v10-panel:rgba(13,13,13,.96);
 --v10-panel-solid:#111111;--v10-card:#121212;--v10-text:#f5f5f5;
 --v10-muted:#999999;--v10-line:#252525;--v10-primary:#f4f4f5;
 --v10-primary-2:#52525b;--v10-grid:rgba(255,255,255,.014);
}
/* 7 — Crimson */
html[data-theme="crimson"]{
 --v10-bg:#21070d;--v10-bg-soft:#350b14;--v10-panel:rgba(56,13,24,.9);
 --v10-panel-solid:#471120;--v10-card:rgba(251,113,133,.07);--v10-text:#fff1f3;
 --v10-muted:#c7a0a9;--v10-line:rgba(251,113,133,.2);--v10-primary:#fb7185;
 --v10-primary-2:#be123c;--v10-grid:rgba(251,113,133,.022);
}
/* 8 — Coffee */
html[data-theme="coffee"]{
 --v10-bg:#1a100b;--v10-bg-soft:#2a1b12;--v10-panel:rgba(48,31,21,.91);
 --v10-panel-solid:#3b281b;--v10-card:rgba(217,169,111,.075);--v10-text:#fff8ed;
 --v10-muted:#baa995;--v10-line:rgba(217,169,111,.22);--v10-primary:#d9a96f;
 --v10-primary-2:#9a5b27;--v10-grid:rgba(217,169,111,.022);
}
/* 9 — Aurora */
html[data-theme="aurora"]{
 --v10-bg:#071824;--v10-bg-soft:#10233a;--v10-panel:rgba(13,31,51,.88);
 --v10-panel-solid:#142a46;--v10-card:rgba(94,234,212,.065);--v10-text:#f0fffd;
 --v10-muted:#99b9c1;--v10-line:rgba(94,234,212,.19);--v10-primary:#5eead4;
 --v10-primary-2:#8b5cf6;--v10-grid:rgba(94,234,212,.02);
}

html{
 background:
 radial-gradient(circle at 8% 0%,color-mix(in srgb,var(--v10-primary) 17%,transparent),transparent 31%),
 radial-gradient(circle at 100% 12%,color-mix(in srgb,var(--v10-primary-2) 13%,transparent),transparent 28%),
 linear-gradient(145deg,var(--v10-bg),var(--v10-bg-soft));
 min-height:100%;
}
body{
 color:var(--v10-text)!important;background:transparent!important;
 overflow-x:hidden;
}
body:before{
 background-image:
 linear-gradient(var(--v10-grid) 1px,transparent 1px),
 linear-gradient(90deg,var(--v10-grid) 1px,transparent 1px)!important;
}

.v10-mobile-bar{
 position:sticky;top:0;z-index:90;display:flex;align-items:center;gap:9px;
 padding:9px 10px;margin:0 0 10px;background:color-mix(in srgb,var(--v10-panel-solid) 90%,transparent);
 border-bottom:1px solid var(--v10-line);backdrop-filter:var(--v10-glass);
}
.v10-mobile-bar button{width:42px!important;min-width:42px;padding:0!important}
.v10-mobile-title{min-width:0;flex:1}
.v10-mobile-title strong{display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.v10-mobile-title span{display:block;color:var(--v10-muted);font-size:.72rem}
.v10-theme-quick{max-width:132px;min-height:38px!important}

.v10-control-deck{
 display:grid;grid-template-columns:1fr;gap:10px;margin:0 10px 12px;padding:12px;
 border:1px solid var(--v10-line);border-radius:var(--v10-radius);
 background:var(--v10-panel);box-shadow:var(--v10-shadow);backdrop-filter:var(--v10-glass);
}
.v10-control-group{display:flex;gap:8px;flex-wrap:wrap}
.v10-control-group .v10-menu{flex:1 1 140px}

.v10-menu{position:relative}
.v10-menu-trigger{
 width:100%;display:flex;align-items:center;justify-content:space-between;gap:10px;
 color:var(--v10-text)!important;background:var(--v10-card)!important;
 border:1px solid var(--v10-line)!important;
}
.v10-menu-trigger.primary-menu{
 background:linear-gradient(135deg,var(--v10-primary),var(--v10-primary-2))!important;
 color:#fff!important;
}
.v10-menu-panel{
 position:absolute;z-index:100;top:calc(100% + 7px);left:0;min-width:220px;width:max-content;max-width:90vw;
 padding:7px;border-radius:15px;border:1px solid var(--v10-line);
 background:var(--v10-panel-solid);box-shadow:0 22px 65px rgba(0,0,0,.45);
 opacity:0;visibility:hidden;transform:translateY(-5px);transition:.17s ease;
}
.v10-menu.align-right .v10-menu-panel{left:auto;right:0}
.v10-menu.open .v10-menu-panel{opacity:1;visibility:visible;transform:none}
.v10-menu-panel button{
 width:100%!important;display:flex;justify-content:flex-start;text-align:left;
 color:var(--v10-text)!important;background:transparent!important;border:0!important;
 min-height:40px!important;padding:8px 10px!important;
}
.v10-menu-panel button:hover{background:color-mix(in srgb,var(--v10-primary) 12%,transparent)!important}
.v10-menu-separator{height:1px;background:var(--v10-line);margin:5px}

.v10-theme-grid{
 display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8px;padding:4px;
}
.v10-theme-option{
 min-height:64px!important;display:flex!important;flex-direction:column;align-items:flex-start!important;
 justify-content:center!important;gap:4px!important;border:1px solid var(--v10-line)!important;
 background:var(--v10-card)!important;
}
.v10-theme-option.active{outline:2px solid var(--v10-primary);outline-offset:1px}
.v10-theme-option small{color:var(--v10-muted)}
.v10-swatch{width:28px;height:8px;border-radius:999px;background:linear-gradient(90deg,var(--sw1),var(--sw2))}

.v10-collapse{
 margin-bottom:12px;border:1px solid var(--v10-line);border-radius:var(--v10-radius);
 background:var(--v10-panel);box-shadow:var(--v10-shadow);overflow:hidden;
 backdrop-filter:var(--v10-glass);
}
.v10-collapse-head{
 width:100%!important;display:flex;justify-content:space-between;align-items:center;gap:12px;
 min-height:52px!important;padding:10px 13px!important;border:0!important;border-radius:0!important;
 color:var(--v10-text)!important;background:color-mix(in srgb,var(--v10-card) 70%,transparent)!important;
 text-align:left;
}
.v10-collapse-head:hover{transform:none!important}
.v10-collapse-copy strong{display:block}
.v10-collapse-copy span{display:block;margin-top:2px;font-size:.75rem;color:var(--v10-muted)}
.v10-collapse-icon{font-size:1.15rem;transition:transform .2s ease}
.v10-collapse.closed .v10-collapse-icon{transform:rotate(-90deg)}
.v10-collapse-body{padding:10px;max-height:5000px;opacity:1;transition:max-height .3s ease,opacity .2s ease,padding .3s ease}
.v10-collapse.closed .v10-collapse-body{max-height:0;opacity:0;padding-top:0;padding-bottom:0;overflow:hidden}

.v10-drawer-backdrop{
 position:fixed;inset:0;z-index:109;background:rgba(1,8,17,.66);backdrop-filter:blur(5px);
 opacity:0;visibility:hidden;transition:.2s ease;
}
.v10-drawer-backdrop.open{opacity:1;visibility:visible}
.v10-drawer{
 position:fixed!important;z-index:110!important;inset:0 auto 0 0;width:min(88vw,330px)!important;
 margin:0!important;border-radius:0 22px 22px 0!important;overflow:auto;
 transform:translateX(-105%);transition:transform .25s ease;
}
.v10-drawer.open{transform:none}

.v10-bottom-nav{
 position:fixed;z-index:80;left:8px;right:8px;bottom:8px;display:grid;grid-template-columns:repeat(4,1fr);
 gap:5px;padding:6px;border:1px solid var(--v10-line);border-radius:17px;
 background:color-mix(in srgb,var(--v10-panel-solid) 92%,transparent);
 box-shadow:0 18px 55px rgba(0,0,0,.4);backdrop-filter:var(--v10-glass);
}
.v10-bottom-nav button{
 width:100%!important;min-height:48px!important;padding:5px!important;border:0!important;
 color:var(--v10-muted)!important;background:transparent!important;font-size:.72rem!important;
}
.v10-bottom-nav button span{display:block;font-size:1.05rem;margin-bottom:2px}
.v10-bottom-nav button.active{color:var(--v10-primary)!important;background:color-mix(in srgb,var(--v10-primary) 10%,transparent)!important}

.v9-command,.v9-quick-grid,.app{width:auto!important;max-width:none!important;margin-left:10px!important;margin-right:10px!important}
.v9-command,.v9-stat,.card,header,.hero{
 color:var(--v10-text)!important;background:var(--v10-panel)!important;
 border-color:var(--v10-line)!important;box-shadow:var(--v10-shadow)!important;
}
.v9-stat{background:var(--v10-card)!important}
.v9-sub,.small,.muted,p,.stat label{color:var(--v10-muted)!important}
.v9-logo,.btn.primary,.primary{
 background:linear-gradient(135deg,var(--v10-primary),var(--v10-primary-2))!important;
}
.btn.soft,.soft{
 color:var(--v10-text)!important;background:var(--v10-card)!important;border-color:var(--v10-line)!important;
}
input,select,textarea{
 color:var(--v10-text)!important;background:color-mix(in srgb,var(--v10-bg) 72%,transparent)!important;
 border-color:var(--v10-line)!important;
}
.modal,.dialog,.modal-card,.dialog-card{
 color:var(--v10-text)!important;background:var(--v10-panel-solid)!important;border-color:var(--v10-line)!important;
}
thead th{background:var(--v10-panel-solid)!important;color:var(--v10-text)!important}
tbody td{color:var(--v10-text)!important}
.chart-box,canvas{background:color-mix(in srgb,var(--v10-bg) 88%,black)!important}

.toolbar.v10-original-toolbar{display:none!important}
body{padding-bottom:76px}
.layout{display:block!important}
.main{min-width:0}
.panels{grid-template-columns:1fr!important}
.stats,.v9-quick-grid{grid-template-columns:repeat(2,minmax(0,1fr))!important}
header{display:grid!important;grid-template-columns:1fr!important;padding:17px!important}
header h1{font-size:1.55rem!important}
.badge{justify-self:stretch}

@media(min-width:680px){
 .v10-control-deck{grid-template-columns:1fr auto;margin-left:14px;margin-right:14px}
 .v10-theme-grid{grid-template-columns:repeat(3,minmax(130px,1fr))}
 .v9-command,.v9-quick-grid,.app{margin-left:14px!important;margin-right:14px!important}
 .stats,.v9-quick-grid{grid-template-columns:repeat(4,minmax(0,1fr))!important}
 header{grid-template-columns:1fr auto!important}
 .badge{justify-self:auto}
 .panels{grid-template-columns:repeat(2,minmax(0,1fr))!important}
}
@media(min-width:980px){
 body{padding-bottom:24px}
 .v10-mobile-bar,.v10-bottom-nav{display:none}
 .v10-control-deck{margin:14px auto;max-width:1500px;grid-template-columns:1fr auto}
 .v9-command,.v9-quick-grid,.app{max-width:1500px!important;margin-left:auto!important;margin-right:auto!important}
 .layout{display:grid!important;grid-template-columns:290px minmax(0,1fr)!important}
 .sidebar{
  position:sticky!important;top:12px!important;transform:none!important;width:auto!important;
  inset:auto!important;border-radius:22px!important;max-height:calc(100vh - 24px);overflow:auto;
 }
 .v10-drawer-backdrop{display:none}
 .toolbar.v10-original-toolbar{display:none!important}
}
@media(min-width:1250px){
 .v10-control-deck{padding:14px 16px}
}


/* =========================================================
   V10.5 — PROFESSIONAL DASHBOARD & PRODUCTIVITY LAYER
   ========================================================= */
.v105-top-actions{
 display:flex;align-items:center;gap:8px;flex-wrap:wrap;
}
.v105-icon-btn{
 position:relative;width:42px!important;min-width:42px!important;padding:0!important;
 display:grid!important;place-items:center!important;
}
.v105-count{
 position:absolute;right:-4px;top:-5px;min-width:18px;height:18px;padding:0 5px;
 display:grid;place-items:center;border-radius:999px;
 background:var(--v10-danger);color:#fff;font-size:.66rem;font-weight:900;
 border:2px solid var(--v10-panel-solid);
}
.v105-dashboard{
 display:grid;grid-template-columns:1fr;gap:12px;margin:0 10px 12px;
}
.v105-hero{
 padding:16px;border:1px solid var(--v10-line);border-radius:var(--v10-radius);
 background:
 linear-gradient(135deg,color-mix(in srgb,var(--v10-primary) 12%,var(--v10-panel)),var(--v10-panel));
 box-shadow:var(--v10-shadow);position:relative;overflow:hidden;
}
.v105-hero:after{
 content:"";position:absolute;right:-65px;top:-75px;width:230px;height:230px;border-radius:50%;
 background:radial-gradient(circle,color-mix(in srgb,var(--v10-primary) 20%,transparent),transparent 68%);
 pointer-events:none;
}
.v105-hero-grid{
 display:grid;grid-template-columns:1fr;gap:15px;position:relative;z-index:1;
}
.v105-eyebrow{
 color:var(--v10-primary);font-size:.72rem;font-weight:900;letter-spacing:.14em;text-transform:uppercase;
}
.v105-hero h2{margin:6px 0 5px;font-size:clamp(1.25rem,4vw,2rem)}
.v105-hero p{margin:0;max-width:780px}
.v105-hero-actions{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px}
.v105-health{
 display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;
}
.v105-health-item{
 padding:11px;border:1px solid var(--v10-line);border-radius:14px;background:var(--v10-card);
}
.v105-health-item span{display:block;color:var(--v10-muted);font-size:.72rem}
.v105-health-item strong{display:block;margin-top:4px;font-size:.98rem}
.v105-dashboard-grid{
 display:grid;grid-template-columns:1fr;gap:12px;
}
.v105-panel{
 border:1px solid var(--v10-line);border-radius:var(--v10-radius);
 background:var(--v10-panel);box-shadow:var(--v10-shadow);overflow:hidden;
}
.v105-panel-head{
 display:flex;justify-content:space-between;align-items:center;gap:10px;
 padding:12px 14px;border-bottom:1px solid var(--v10-line);
 background:color-mix(in srgb,var(--v10-card) 70%,transparent);
}
.v105-panel-head h3{margin:0;font-size:1rem}
.v105-panel-head small{color:var(--v10-muted)}
.v105-panel-body{padding:12px}
.v105-metric-grid{
 display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px;
}
.v105-metric{
 padding:12px;border:1px solid var(--v10-line);border-radius:15px;background:var(--v10-card);
}
.v105-metric span{display:block;color:var(--v10-muted);font-size:.72rem}
.v105-metric strong{display:block;margin-top:5px;font-size:1.12rem}
.v105-metric em{display:block;margin-top:4px;color:var(--v10-muted);font-size:.7rem;font-style:normal}
.v105-list{
 display:flex;flex-direction:column;gap:8px;
}
.v105-list-item{
 display:grid;grid-template-columns:auto 1fr auto;gap:10px;align-items:start;
 padding:10px;border:1px solid var(--v10-line);border-radius:14px;background:var(--v10-card);
}
.v105-status-dot{
 width:10px;height:10px;border-radius:50%;margin-top:5px;background:var(--v10-primary);
 box-shadow:0 0 0 5px color-mix(in srgb,var(--v10-primary) 11%,transparent);
}
.v105-status-dot.success{background:var(--v10-success);box-shadow:0 0 0 5px color-mix(in srgb,var(--v10-success) 11%,transparent)}
.v105-status-dot.error{background:var(--v10-danger);box-shadow:0 0 0 5px color-mix(in srgb,var(--v10-danger) 11%,transparent)}
.v105-status-dot.warning{background:var(--v10-warning);box-shadow:0 0 0 5px color-mix(in srgb,var(--v10-warning) 11%,transparent)}
.v105-list-item strong{font-size:.86rem}
.v105-list-item p{font-size:.76rem;margin:2px 0 0}
.v105-list-item time{font-size:.68rem;color:var(--v10-muted);white-space:nowrap}
.v105-empty{
 padding:18px;text-align:center;color:var(--v10-muted);border:1px dashed var(--v10-line);
 border-radius:14px;
}
.v105-progress-row{
 display:grid;grid-template-columns:1fr auto;gap:8px;align-items:center;
 padding:10px;border:1px solid var(--v10-line);border-radius:14px;background:var(--v10-card);
}
.v105-progress-copy strong{display:block;font-size:.84rem}
.v105-progress-copy span{display:block;color:var(--v10-muted);font-size:.72rem;margin-top:2px}
.v105-mini-progress{
 grid-column:1/-1;height:8px;border-radius:999px;background:color-mix(in srgb,var(--v10-line) 60%,transparent);overflow:hidden;
}
.v105-mini-progress i{
 display:block;height:100%;width:0;border-radius:inherit;
 background:linear-gradient(90deg,var(--v10-primary),var(--v10-primary-2));transition:width .25s ease;
}
.v105-queue-badge{
 padding:5px 8px;border-radius:999px;background:color-mix(in srgb,var(--v10-primary) 11%,transparent);
 color:var(--v10-primary);font-size:.68rem;font-weight:900;
}
.v105-command{
 position:fixed;z-index:200;inset:0;display:grid;align-items:start;justify-items:center;
 padding:8vh 12px 20px;background:rgba(1,8,17,.72);backdrop-filter:blur(8px);
 opacity:0;visibility:hidden;transition:.18s ease;
}
.v105-command.open{opacity:1;visibility:visible}
.v105-command-card{
 width:min(680px,100%);border:1px solid var(--v10-line);border-radius:22px;
 background:var(--v10-panel-solid);box-shadow:0 35px 100px rgba(0,0,0,.6);overflow:hidden;
 transform:translateY(-10px);transition:.18s ease;
}
.v105-command.open .v105-command-card{transform:none}
.v105-command-search{
 width:100%;border:0!important;border-bottom:1px solid var(--v10-line)!important;border-radius:0!important;
 min-height:58px!important;font-size:1rem;padding:0 16px!important;
}
.v105-command-results{max-height:55vh;overflow:auto;padding:8px}
.v105-command-item{
 width:100%!important;display:grid!important;grid-template-columns:auto 1fr auto;gap:12px;align-items:center;
 text-align:left!important;padding:10px 12px!important;border:0!important;background:transparent!important;color:var(--v10-text)!important;
}
.v105-command-item:hover,.v105-command-item.active{
 background:color-mix(in srgb,var(--v10-primary) 12%,transparent)!important;
}
.v105-command-item b{font-size:1rem}
.v105-command-item strong{display:block;font-size:.86rem}
.v105-command-item small{display:block;color:var(--v10-muted);margin-top:2px}
.v105-command-item kbd{
 padding:3px 6px;border:1px solid var(--v10-line);border-radius:7px;color:var(--v10-muted);
 background:var(--v10-card);font-size:.67rem;
}
.v105-drawer{
 position:fixed;z-index:190;top:0;right:0;bottom:0;width:min(92vw,390px);
 background:var(--v10-panel-solid);border-left:1px solid var(--v10-line);
 box-shadow:-24px 0 70px rgba(0,0,0,.42);transform:translateX(105%);transition:.24s ease;
 display:flex;flex-direction:column;
}
.v105-drawer.open{transform:none}
.v105-drawer-head{
 display:flex;justify-content:space-between;align-items:center;gap:10px;
 padding:13px;border-bottom:1px solid var(--v10-line);
}
.v105-drawer-body{padding:12px;overflow:auto;flex:1}
.v105-drawer-tabs{display:grid;grid-template-columns:repeat(2,1fr);gap:7px;margin-bottom:10px}
.v105-drawer-tabs button.active{
 color:#fff!important;background:linear-gradient(135deg,var(--v10-primary),var(--v10-primary-2))!important;
}
.v105-drawer-backdrop{
 position:fixed;inset:0;z-index:189;background:rgba(1,8,17,.58);backdrop-filter:blur(5px);
 opacity:0;visibility:hidden;transition:.2s ease;
}
.v105-drawer-backdrop.open{opacity:1;visibility:visible}
.v105-workspaces{
 display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;
}
.v105-workspace-btn{
 display:flex!important;flex-direction:column;align-items:flex-start!important;justify-content:center!important;
 min-height:70px!important;text-align:left!important;background:var(--v10-card)!important;color:var(--v10-text)!important;
 border:1px solid var(--v10-line)!important;
}
.v105-workspace-btn.active{
 outline:2px solid var(--v10-primary);outline-offset:1px;
}
.v105-workspace-btn small{color:var(--v10-muted);margin-top:3px}
.v105-toast{
 position:fixed;z-index:220;right:12px;top:78px;width:min(350px,calc(100vw - 24px));
 padding:12px;border:1px solid var(--v10-line);border-radius:16px;background:var(--v10-panel-solid);
 box-shadow:0 24px 75px rgba(0,0,0,.45);transform:translateX(120%);opacity:0;transition:.25s ease;
}
.v105-toast.show{transform:none;opacity:1}
.v105-toast.success{border-color:color-mix(in srgb,var(--v10-success) 42%,var(--v10-line))}
.v105-toast.error{border-color:color-mix(in srgb,var(--v10-danger) 42%,var(--v10-line))}
.v105-toast strong{display:block}
.v105-toast p{margin:3px 0 0;font-size:.78rem}
.v105-shortcuts{
 display:grid;grid-template-columns:1fr auto;gap:8px;padding:8px 0;border-bottom:1px solid var(--v10-line);
}
.v105-shortcuts:last-child{border-bottom:0}
.v105-shortcuts span{color:var(--v10-muted);font-size:.8rem}
.v105-shortcuts kbd{
 padding:3px 7px;border:1px solid var(--v10-line);border-radius:7px;background:var(--v10-card);font-size:.7rem;
}

@media(min-width:680px){
 .v105-dashboard{margin-left:14px;margin-right:14px}
 .v105-hero-grid{grid-template-columns:minmax(0,1.5fr) minmax(260px,.7fr);align-items:center}
 .v105-dashboard-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
 .v105-metric-grid{grid-template-columns:repeat(4,minmax(0,1fr))}
}
@media(min-width:980px){
 .v105-dashboard{max-width:1500px;margin-left:auto;margin-right:auto}
 .v105-dashboard-grid{grid-template-columns:1.2fr .8fr .8fr}
 .v105-panel.span-2{grid-column:span 2}
}


/* =========================================================
   V11 — TRADING TERMINAL WORKSPACES
   ========================================================= */
.v11-shell{
 display:grid;grid-template-columns:1fr;gap:12px;margin:0 10px 14px;
}
.v11-tabs{
 display:flex;gap:7px;overflow-x:auto;padding:6px;border:1px solid var(--v10-line);
 border-radius:16px;background:var(--v10-panel);box-shadow:var(--v10-shadow);
 scrollbar-width:thin;
}
.v11-tab{
 flex:0 0 auto;width:auto!important;min-height:42px!important;padding:8px 13px!important;
 color:var(--v10-muted)!important;background:transparent!important;border:0!important;
}
.v11-tab.active{
 color:#fff!important;background:linear-gradient(135deg,var(--v10-primary),var(--v10-primary-2))!important;
}

/* V11.21 — hierarchical Trading Workspace navigation */
.v11-workspace-menu{
 align-items:flex-start;
 overflow:visible;
 flex-wrap:wrap;
 gap:8px;
}
.v11-menu-primary,
.v11-menu-group > summary{
 display:inline-flex;
 align-items:center;
 gap:8px;
 min-height:42px;
 padding:8px 13px;
 border:1px solid transparent;
 border-radius:12px;
 color:var(--v10-muted);
 background:transparent;
 font-weight:800;
 cursor:pointer;
 list-style:none;
 user-select:none;
 transition:background .18s ease,border-color .18s ease,color .18s ease,transform .18s ease;
}
.v11-menu-group > summary::-webkit-details-marker{display:none}
.v11-menu-group > summary:hover,
.v11-menu-primary:hover{
 color:var(--v10-text)!important;
 border-color:var(--v10-line)!important;
 background:color-mix(in srgb,var(--v10-primary) 8%,var(--v10-card))!important;
}
.v11-menu-icon{
 display:grid;
 width:22px;
 height:22px;
 place-items:center;
 border-radius:7px;
 color:var(--v10-primary);
 background:color-mix(in srgb,var(--v10-primary) 12%,transparent);
 font-size:.78rem;
 line-height:1;
}
.v11-menu-chevron{margin-left:3px;transition:transform .18s ease}
.v11-menu-group[open] > summary .v11-menu-chevron{transform:rotate(180deg)}
.v11-menu-group{
 position:relative;
 flex:0 0 auto;
}
.v11-menu-group.active-group > summary{
 color:var(--v10-text);
 border-color:color-mix(in srgb,var(--v10-primary) 44%,var(--v10-line));
 background:color-mix(in srgb,var(--v10-primary) 10%,var(--v10-card));
}
.v11-submenu{
 position:absolute;
 z-index:80;
 top:calc(100% + 8px);
 left:0;
 display:grid;
 min-width:190px;
 gap:5px;
 padding:7px;
 border:1px solid var(--v10-line);
 border-radius:14px;
 background:var(--v10-panel);
 box-shadow:var(--v10-shadow);
}
.v11-submenu .v11-tab{
 width:100%!important;
 min-height:38px!important;
 padding:8px 11px!important;
 border-radius:10px!important;
 text-align:left;
}
.v11-menu-primary.active{
 color:#fff!important;
 border-color:transparent!important;
 background:linear-gradient(135deg,var(--v10-primary),var(--v10-primary-2))!important;
}
.v11-menu-primary.active .v11-menu-icon{
 color:#fff;
 background:rgba(255,255,255,.16);
}
@media(max-width:640px){
 .v11-workspace-menu{display:grid;grid-template-columns:1fr;overflow:visible}
 .v11-menu-primary,.v11-menu-group,.v11-menu-group > summary{width:100%}
 .v11-menu-group > summary{justify-content:flex-start}
 .v11-menu-chevron{margin-left:auto}
 .v11-submenu{position:static;margin-top:6px;min-width:0;box-shadow:none;background:color-mix(in srgb,var(--v10-card) 82%,transparent)}
}
/* V11.22 — modal-first Trading navigation */
#aitPsaTradingModal .v11-workspace-menu{display:none!important}
#aitPsaTradingModal .v11-shell{margin:0}
.ait-psa-trading-launcher-grid{grid-template-columns:minmax(0,520px);justify-content:start}
.ait-psa-trading-tool-grid{grid-template-columns:repeat(auto-fit,minmax(210px,1fr))}
.ait-psa-trading-tool-grid .ait-psa-terminal-command{min-height:150px}
@media(max-width:760px){
 .ait-psa-trading-launcher-grid{grid-template-columns:1fr}
}
.v11-workspace{display:none}
.v11-workspace.active{display:block}
.v11-grid{display:grid;grid-template-columns:1fr;gap:12px}
.v11-card{
 border:1px solid var(--v10-line);border-radius:var(--v10-radius);
 background:var(--v10-panel);box-shadow:var(--v10-shadow);overflow:hidden;
}
.v11-card-head{
 display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;
 padding:12px 14px;border-bottom:1px solid var(--v10-line);
 background:color-mix(in srgb,var(--v10-card) 70%,transparent);
}
.v11-card-head h3{margin:0;font-size:1rem}
.v11-card-head small{display:block;color:var(--v10-muted);margin-top:2px}
.v11-card-body{padding:12px}
.v11-controls{
 display:grid;grid-template-columns:1fr;gap:9px;margin-bottom:12px
}
.v11-controls label{display:grid;gap:5px;color:var(--v10-muted);font-size:.78rem}
.v11-inline{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
.v11-chart-layout{
 display:grid;grid-template-columns:1fr;gap:10px;
}
.v11-chart-slot{
 min-height:270px;border:1px solid var(--v10-line);border-radius:16px;
 background:color-mix(in srgb,var(--v10-bg) 90%,black);overflow:hidden;position:relative;
}
.v11-chart-slot canvas{width:100%;height:270px;display:block}
.v11-chart-label{
 position:absolute;left:10px;top:9px;z-index:2;padding:5px 8px;border-radius:999px;
 background:color-mix(in srgb,var(--v10-panel-solid) 85%,transparent);
 border:1px solid var(--v10-line);font-size:.72rem;color:var(--v10-text)
}
.v11-indicator-list{
 display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px
}
.v11-check{
 display:flex;gap:8px;align-items:center;padding:9px;border:1px solid var(--v10-line);
 border-radius:13px;background:var(--v10-card);color:var(--v10-text)
}
.v11-table-wrap{overflow:auto;border:1px solid var(--v10-line);border-radius:14px}
.v11-table{width:100%;min-width:720px}
.v11-table th,.v11-table td{padding:9px 10px;text-align:left}
.v11-score{
 display:inline-grid;place-items:center;min-width:48px;padding:5px 8px;border-radius:999px;
 font-weight:900;background:color-mix(in srgb,var(--v10-primary) 12%,transparent);color:var(--v10-primary)
}
.v11-signal{
 display:inline-flex;padding:5px 8px;border-radius:999px;font-size:.72rem;font-weight:900
}
.v11-signal.buy,.v11-signal.strong-buy{background:color-mix(in srgb,var(--v10-success) 14%,transparent);color:var(--v10-success)}
.v11-signal.watch{background:color-mix(in srgb,var(--v10-warning) 14%,transparent);color:var(--v10-warning)}
.v11-signal.avoid{background:color-mix(in srgb,var(--v10-danger) 14%,transparent);color:var(--v10-danger)}

.v11-signal.strongest{background:color-mix(in srgb,var(--v10-success) 16%,transparent);color:var(--v10-success)}
.v11-strength{display:flex;align-items:center;gap:8px;min-width:150px}
.v11-strength-track{width:105px;height:8px;border-radius:999px;overflow:hidden;background:color-mix(in srgb,var(--v10-muted) 18%,transparent)}
.v11-strength-fill{display:block;height:100%;width:var(--v11-strength,0%);border-radius:inherit;background:linear-gradient(90deg,var(--v10-danger),var(--v10-warning),var(--v10-success))}
.v11-strength-value{min-width:34px;font-size:.74rem;font-weight:900;color:var(--v10-text)}
.v11-potential-table{min-width:850px}

/* V11.27 — relative scanner header and structured scanner controls */
.v11-scanner-card{overflow:visible}
.v11-scanner-card>.v11-card-head{position:relative;top:auto;z-index:1;backdrop-filter:none;box-shadow:none}
.v11-scanner-card .v11-card-body{overflow:visible}
.v11-scanner-guideline{order:1;margin:0}
.v11-scanner-guideline .v11-potential-guide strong{letter-spacing:.01em}
.v11-scanner-guideline .v11-potential-guideline-grid{grid-template-columns:repeat(auto-fit,minmax(230px,1fr));align-items:stretch}
.v11-scanner-control-row{order:2;display:flex;justify-content:flex-end;align-items:center;gap:8px;flex-wrap:wrap;margin:12px 0}
.v11-scanner-control-row .v11-potential-actions{display:flex;justify-content:flex-end;align-items:center;gap:8px;flex-wrap:wrap;margin-left:auto;width:auto}
.v11-scanner-control-row .btn{white-space:nowrap}
.v11-scanner-table-region{min-width:0}
.v11-table-scrollbar{height:16px;overflow-x:auto;overflow-y:hidden;margin:0 0 6px;border:1px solid var(--v10-line);border-radius:999px;background:color-mix(in srgb,var(--v10-card) 82%,transparent)}
.v11-table-scrollbar>div{height:1px}
.v11-scanner-table-wrap{max-height:min(58vh,620px);overflow:auto;position:relative}
.v11-scanner-table-wrap .v11-table thead th{position:sticky;top:0;z-index:8;background:var(--v10-panel-solid);box-shadow:0 1px 0 var(--v10-line),0 8px 12px color-mix(in srgb,var(--v10-bg) 12%,transparent);white-space:nowrap}
.v11-scanner-table-wrap .v11-table tbody tr:nth-child(even){background:color-mix(in srgb,var(--v10-card) 48%,transparent)}
@media(max-width:760px){.v11-scanner-control-row,.v11-scanner-control-row .v11-potential-actions{width:100%;justify-content:flex-end}.v11-scanner-table-wrap{max-height:62vh}}


.v11-potential-actions{display:flex;align-items:center;justify-content:flex-end;gap:8px;flex-wrap:wrap}
.v11-potential-chart-gallery{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
.v11-potential-chart-card{padding:13px;border:1px solid var(--v10-line);border-radius:16px;background:var(--v10-card)}
.v11-potential-chart-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:9px}
.v11-potential-chart-identity{display:flex;align-items:center;gap:9px;min-width:0}
.v11-potential-rank{display:grid;place-items:center;width:32px;height:32px;flex:0 0 32px;border-radius:10px;background:color-mix(in srgb,var(--v10-primary) 14%,transparent);color:var(--v10-primary);font-size:.75rem;font-weight:950}
.v11-potential-chart-identity strong{display:block;font-size:.94rem}
.v11-potential-chart-identity small{display:block;margin-top:2px;color:var(--v10-muted);font-size:.7rem}
.v11-potential-chart-score{text-align:right}
.v11-potential-chart-score strong{display:block;font-size:1rem}
.v11-potential-chart-score small{display:block;color:var(--v10-muted);font-size:.68rem}
.v11-potential-chart-box{height:260px;overflow:hidden;border:1px solid var(--v10-line);border-radius:13px;background:color-mix(in srgb,var(--v10-bg) 90%,black)}
.v11-potential-chart-box canvas{width:100%;height:260px;display:block}
.v11-potential-chart-foot{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:9px;color:var(--v10-muted);font-size:.7rem}
@media(max-width:820px){.v11-potential-chart-gallery{grid-template-columns:1fr}}
@media(max-width:560px){.v11-potential-actions{width:100%;justify-content:stretch}.v11-potential-actions .btn{flex:1}.v11-potential-chart-box{height:225px}.v11-potential-chart-box canvas{height:225px}}



.ait-fund-report-modal{position:fixed;inset:0;z-index:10080;display:none;align-items:stretch;justify-content:center;padding:18px;background:rgba(2,6,23,.72)}.ait-fund-report-modal.open{display:flex}.ait-fund-report-panel{width:min(1500px,100%);height:100%;overflow:hidden;border:1px solid var(--v10-line,var(--line));border-radius:18px;background:var(--v10-panel-solid,var(--panel));color:var(--v10-text,var(--text));box-shadow:0 24px 80px rgba(0,0,0,.35);display:flex;flex-direction:column}.ait-fund-report-head{display:flex;gap:16px;align-items:flex-start;justify-content:space-between;padding:18px 20px;border-bottom:1px solid var(--v10-line,var(--line));background:var(--v10-card,var(--card))}.ait-fund-report-head h2{margin:2px 0 4px}.ait-fund-report-body{padding:16px 20px 20px;overflow:auto}.ait-fund-report-search{display:grid;grid-template-columns:auto minmax(220px,1fr) auto auto;gap:10px;align-items:center;padding:12px;border:1px solid var(--v10-line,var(--line));border-radius:14px;background:var(--v10-card,var(--card));margin-bottom:12px}.ait-fund-report-search input{width:100%;min-width:0}.ait-fund-report-table-wrap{overflow:auto;border:1px solid var(--v10-line,var(--line));border-radius:14px}.ait-fund-report-table{width:100%;min-width:1250px;border-collapse:collapse}.ait-fund-report-table th,.ait-fund-report-table td{padding:10px 12px;border-bottom:1px solid var(--v10-line,var(--line));text-align:left;vertical-align:top}.ait-fund-report-table th{position:sticky;top:0;z-index:2;background:var(--v10-card,var(--card))}.ait-fund-report-empty{text-align:center;padding:28px;color:var(--v10-muted,var(--muted))}@media(max-width:700px){.ait-fund-report-search{grid-template-columns:1fr}.ait-fund-report-head{padding:14px}.ait-fund-report-body{padding:12px}}
.ait-fundamental-strip{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:6px;margin:8px 0 10px}.ait-fundamental-item{min-width:0;padding:7px 8px;border:1px solid var(--v10-line,var(--line));border-radius:10px;background:color-mix(in srgb,var(--v10-card,var(--card)) 78%,transparent)}.ait-fundamental-item small{display:block;color:var(--v10-muted,var(--muted));font-size:.62rem;text-transform:uppercase;letter-spacing:.04em}.ait-fundamental-item b{display:block;margin-top:2px;font-size:.75rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.ait-fundamental-strip--empty{grid-template-columns:1fr}.ait-fundamental-strip--empty .ait-fundamental-item{text-align:center}@media(max-width:560px){.ait-fundamental-strip{grid-template-columns:repeat(2,minmax(0,1fr))}}
/* V11 ranked charts — aligned with the Watch List 3M gallery */
.v11-ranked-chart-modal .dialog{
 width:min(1180px,calc(100vw - 28px));
 background:var(--v10-bg);
 border:1px solid var(--v10-line);
 box-shadow:0 28px 80px rgba(2,6,23,.42);
}
.v11-ranked-chart-modal .modal-head{
 position:sticky;
 top:0;
 z-index:8;
 align-items:center;
 padding:16px 18px;
 margin:-1px -1px 16px;
 border-radius:inherit;
 border-bottom:1px solid color-mix(in srgb,var(--v10-primary) 28%,var(--v10-line));
 background:color-mix(in srgb,var(--v10-card) 94%,var(--v10-primary) 6%);
 box-shadow:0 8px 24px rgba(2,6,23,.12);
 backdrop-filter:blur(16px);
 -webkit-backdrop-filter:blur(16px);
}
.v11-ranked-chart-modal .modal-head>div{min-width:0}
.v11-ranked-chart-modal .modal-head h2{
 margin:0;
 color:var(--v10-text);
 font-size:clamp(1.05rem,2vw,1.35rem);
 line-height:1.25;
 letter-spacing:-.02em;
 text-shadow:none;
}
.v11-ranked-chart-modal .modal-head .small{
 display:block;
 margin-top:5px;
 color:var(--v10-muted);
 font-size:.78rem;
 line-height:1.45;
}
.v11-ranked-chart-modal .modal-head .icon{
 flex:0 0 auto;
 width:38px;
 height:38px;
 border-radius:12px;
 color:var(--v10-text);
 background:color-mix(in srgb,var(--v10-card) 84%,var(--v10-primary) 16%);
 border:1px solid var(--v10-line);
 font-size:1.35rem;
 line-height:1;
}
.v11-ranked-chart-modal .modal-head .icon:hover{
 border-color:var(--v10-primary);
 transform:translateY(-1px);
}
.v11-ranked-chart-modal .v11-potential-chart-gallery{
 display:grid;
 grid-template-columns:repeat(2,minmax(0,1fr));
 gap:14px;
}
.v11-ranked-chart-modal .mini-card.v11-ranked-mini-card{
 min-width:0;
 padding:14px;
 border:1px solid var(--v10-line);
 border-radius:16px;
 background:var(--v10-card);
 box-shadow:0 10px 28px rgba(2,6,23,.08);
}
.v11-ranked-chart-modal .mini-card.v11-ranked-mini-card:hover{
 border-color:color-mix(in srgb,var(--v10-primary) 50%,var(--v10-line));
 box-shadow:0 16px 34px rgba(2,6,23,.13);
}
.v11-ranked-chart-head{
 display:flex;
 align-items:center;
 justify-content:space-between;
 gap:12px;
 margin-bottom:10px;
}
.v11-ranked-chart-title{
 display:flex;
 align-items:center;
 gap:10px;
 min-width:0;
}

.v11-ranked-ranking-badge{display:inline-flex;align-items:center;gap:4px;margin-left:5px;padding:3px 7px;border-radius:999px;font-size:.63rem;font-weight:900;line-height:1;letter-spacing:.01em;border:1px solid var(--v10-line);white-space:nowrap;vertical-align:middle}.v11-ranked-ranking-badge--signal{background:color-mix(in srgb,var(--v10-primary) 12%,var(--v10-card));border-color:color-mix(in srgb,var(--v10-primary) 34%,var(--v10-line));color:var(--v10-primary)}.v11-ranked-ranking-badge--overall{background:color-mix(in srgb,#7c3aed 10%,var(--v10-card));border-color:color-mix(in srgb,#7c3aed 30%,var(--v10-line));color:#6d28d9}
.v11-ranked-priority-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 8px;border-radius:999px;font-size:.66rem;font-weight:800;line-height:1;letter-spacing:.02em;border:1px solid var(--v10-line);background:var(--v10-bg);color:var(--v10-text);white-space:nowrap;margin-left:6px;vertical-align:middle}.v11-ranked-priority-badge--elite-priority,.v11-ranked-priority-badge--high-priority,.v11-ranked-priority-badge--high{background:color-mix(in srgb,#16a34a 14%,var(--v10-bg));border-color:color-mix(in srgb,#16a34a 35%,var(--v10-line));color:#166534}.v11-ranked-priority-badge--candidate,.v11-ranked-priority-badge--medium,.v11-ranked-priority-badge--confirmation{background:color-mix(in srgb,#d97706 14%,var(--v10-bg));border-color:color-mix(in srgb,#d97706 35%,var(--v10-line));color:#92400e}.v11-ranked-priority-badge--watch,.v11-ranked-priority-badge--low{background:color-mix(in srgb,#64748b 12%,var(--v10-bg));border-color:color-mix(in srgb,#64748b 30%,var(--v10-line));color:#475569}.v11-ranked-priority-badge--avoid{background:color-mix(in srgb,#dc2626 12%,var(--v10-bg));border-color:color-mix(in srgb,#dc2626 30%,var(--v10-line));color:#991b1b}
.v11-ranked-chart-title h3{
 margin:0;
 color:var(--v10-text);
 font-size:1rem;
 line-height:1.25;
 letter-spacing:.01em;
}
.v11-ranked-chart-title .small{
 display:block;
 margin-top:3px;
 color:var(--v10-muted);
 font-size:.72rem;
}
.v11-ranked-chart-meta{
 display:flex;
 flex-wrap:wrap;
 align-items:center;
 gap:7px;
 margin-top:10px;
 color:var(--v10-muted);
 font-size:.72rem;
 line-height:1.4;
}
.v11-ranked-chart-score-pill{
 display:inline-flex;
 align-items:center;
 gap:5px;
 padding:5px 8px;
 border-radius:999px;
 color:var(--v10-text);
 background:color-mix(in srgb,var(--v10-primary) 12%,var(--v10-card));
 border:1px solid color-mix(in srgb,var(--v10-primary) 28%,var(--v10-line));
 font-weight:800;
 white-space:nowrap;
}
.v11-ranked-chart-modal .chart-box.mini-chart{
 height:280px;
 overflow:hidden;
 border:1px solid var(--v10-line);
 border-radius:14px;
 background:color-mix(in srgb,var(--v10-bg) 94%,var(--v10-card));
}
.v11-ranked-chart-modal .chart-box.mini-chart canvas{
 width:100%;
 height:280px;
 display:block;
}
.v11-ranked-chart-modal .v11-signal{white-space:nowrap}
@media(max-width:820px){
 .v11-ranked-chart-modal .v11-potential-chart-gallery{grid-template-columns:1fr}
}
@media(max-width:560px){
 .v11-ranked-chart-modal .dialog{width:100vw;max-height:100vh!important;border-radius:0}
 .v11-ranked-chart-modal .modal-head{padding:13px 14px;margin:-1px -1px 12px}
 .v11-ranked-chart-modal .mini-card.v11-ranked-mini-card{padding:11px;border-radius:13px}
 .v11-ranked-chart-modal .chart-box.mini-chart,.v11-ranked-chart-modal .chart-box.mini-chart canvas{height:235px}
 .v11-ranked-chart-head{align-items:flex-start}
}

.v11-ranked-chart-modal{z-index:2147483646!important}
.v11-ranked-chart-modal.open{display:flex!important;visibility:visible!important;opacity:1!important;pointer-events:auto!important}
.v11-ranked-chart-modal>.dialog{max-height:calc(100vh - 28px);overflow:auto}
body.v11-ranked-modal-open{overflow:hidden}


.v11-potential-guideline{margin-bottom:14px;padding:14px;border:1px solid var(--v10-line);border-radius:16px;background:color-mix(in srgb,var(--v10-card) 78%,transparent)}
.v11-potential-guideline-head{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:11px}
.v11-potential-guideline-head h4{margin:0;font-size:1rem}
.v11-potential-guideline-head p{margin:3px 0 0;font-size:.78rem;color:var(--v10-muted)}
.v11-potential-guideline-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:9px}
.v11-potential-guide{padding:11px;border:1px solid var(--v10-line);border-radius:13px;background:color-mix(in srgb,var(--v10-bg) 55%,transparent)}
.v11-potential-guide strong{display:block;margin-bottom:4px;font-size:.82rem}
.v11-potential-guide span{display:block;color:var(--v10-muted);font-size:.73rem;line-height:1.45}
.v11-potential-guide--strongest{border-top:3px solid var(--v10-success)}
.v11-potential-guide--watch{border-top:3px solid var(--v10-warning)}
.v11-potential-guide--avoid{border-top:3px solid var(--v10-danger)}
.v11-potential-guide--formula{border-top:3px solid var(--v10-primary)}
@media(max-width:900px){.v11-potential-guideline-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:560px){.v11-potential-guideline-grid{grid-template-columns:1fr}.v11-potential-guideline-head{display:block}}

.v11-summary-grid{
 display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px
}
.v11-summary{
 padding:12px;border:1px solid var(--v10-line);border-radius:15px;background:var(--v10-card)
}
.v11-summary span{display:block;color:var(--v10-muted);font-size:.72rem}
.v11-summary strong{display:block;margin-top:5px;font-size:1.12rem}
.v11-explorer{
 display:grid;grid-template-columns:1fr;gap:12px
}
.v11-search-results{
 display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px
}
.v11-symbol-card{
 padding:11px;border:1px solid var(--v10-line);border-radius:14px;background:var(--v10-card)
}
.v11-symbol-card strong{display:block}
.v11-symbol-card small{display:block;color:var(--v10-muted);margin-top:3px}
.v11-symbol-card button{margin-top:8px;width:100%!important}
.v11-report-list{
 display:grid;grid-template-columns:1fr;gap:9px
}
.v11-report-item{
 display:grid;grid-template-columns:auto 1fr auto;gap:10px;align-items:center;
 padding:11px;border:1px solid var(--v10-line);border-radius:14px;background:var(--v10-card)
}
.v11-report-icon{
 width:38px;height:38px;border-radius:12px;display:grid;place-items:center;
 background:color-mix(in srgb,var(--v10-primary) 12%,transparent);color:var(--v10-primary)
}
.v11-report-item p{margin:2px 0 0;font-size:.76rem}
.v11-portfolio-layout{
 display:grid;
 grid-template-columns:minmax(0,1fr);
 gap:12px;
}
.v11-portfolio-summary-card,
.v11-portfolio-workspace-card{
 width:100%;
 min-width:0;
}
.v11-portfolio-form{
 display:grid;grid-template-columns:1fr;gap:8px;margin-bottom:10px
}
.v11-chip-row{display:flex;gap:7px;flex-wrap:wrap;margin-top:8px}
.v11-chip{
 padding:6px 9px;border-radius:999px;background:var(--v10-card);
 border:1px solid var(--v10-line);font-size:.72rem;color:var(--v10-muted)
}
.v11-note{
 padding:10px 12px;border-left:3px solid var(--v10-primary);
 background:color-mix(in srgb,var(--v10-primary) 8%,transparent);
 border-radius:10px;color:var(--v10-muted);font-size:.78rem
}
.v11-empty{
 padding:18px;text-align:center;color:var(--v10-muted);border:1px dashed var(--v10-line);
 border-radius:14px
}


.v11-portfolio-form-actions,.v11-portfolio-row-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.v11-portfolio-form-actions{align-self:end}
.v11-portfolio-row-actions{justify-content:flex-end;flex-wrap:nowrap}
.v11-portfolio-row-actions .btn{white-space:nowrap}
@media(min-width:680px){
 .v11-shell{margin-left:14px;margin-right:14px}
 .v11-controls{grid-template-columns:repeat(3,minmax(0,1fr))}
 .v11-chart-layout.layout-2{grid-template-columns:repeat(2,minmax(0,1fr))}
 .v11-chart-layout.layout-4{grid-template-columns:repeat(2,minmax(0,1fr))}
 .v11-summary-grid{grid-template-columns:repeat(4,minmax(0,1fr))}
 .v11-portfolio-form{grid-template-columns:repeat(4,minmax(0,1fr))}
 .v11-search-results{grid-template-columns:repeat(3,minmax(0,1fr))}
 .v11-report-list{grid-template-columns:repeat(2,minmax(0,1fr))}
}
@media(min-width:980px){
 .v11-shell{max-width:1500px;margin-left:auto;margin-right:auto}
 .v11-grid.two{grid-template-columns:1.2fr .8fr}
 .v11-grid.three{grid-template-columns:1.3fr .7fr .7fr}
 .v11-explorer{grid-template-columns:300px minmax(0,1fr)}
 .v11-chart-layout.layout-4{grid-template-columns:repeat(2,minmax(0,1fr))}
}


/* =========================================================
   V11.1 — TOP-LAYER CHART VIEWER
   ========================================================= */
body.v111-chart-open{overflow:hidden!important}

.v111-chart-backdrop{
 position:fixed!important;inset:0!important;z-index:99990!important;
 background:rgba(0,5,14,.76)!important;backdrop-filter:blur(8px)!important;
 opacity:0;visibility:hidden;transition:.2s ease;
}
.v111-chart-backdrop.open{opacity:1;visibility:visible}

.v111-chart-modal{
 position:fixed!important;z-index:99999!important;
 inset:10px!important;width:auto!important;max-width:none!important;height:auto!important;
 max-height:calc(100vh - 20px)!important;margin:0!important;
 display:flex!important;flex-direction:column!important;
 border:1px solid var(--v10-line)!important;border-radius:22px!important;
 background:var(--v10-panel-solid)!important;
 box-shadow:0 36px 110px rgba(0,0,0,.7)!important;
 overflow:hidden!important;
 opacity:0;visibility:hidden;transform:translateY(14px) scale(.985);
 transition:opacity .2s ease,transform .2s ease,visibility .2s ease;
}
.v111-chart-modal.open{
 opacity:1;visibility:visible;transform:none;
}
.v111-chart-modal.fullscreen{
 inset:0!important;max-height:100vh!important;border-radius:0!important;border:0!important;
}
.v111-chart-modal-head{
 flex:0 0 auto;display:flex;align-items:center;justify-content:space-between;gap:12px;
 padding:10px 12px;border-bottom:1px solid var(--v10-line);
 background:color-mix(in srgb,var(--v10-card) 82%,var(--v10-panel-solid));
}
.v111-chart-modal-title{min-width:0}
.v111-chart-modal-title strong{display:block}
.v111-chart-modal-title span{
 display:block;color:var(--v10-muted);font-size:.72rem;
 white-space:nowrap;overflow:hidden;text-overflow:ellipsis
}
.v111-chart-modal-actions{display:flex;gap:7px;align-items:center}
.v111-chart-modal-actions button{
 width:auto!important;min-width:42px!important;min-height:40px!important;padding:7px 11px!important
}
.v111-chart-close{
 color:#fff!important;background:linear-gradient(135deg,var(--v10-danger),#be123c)!important;
 border-color:transparent!important;font-weight:900!important;
}
.v111-chart-modal-body{
 flex:1 1 auto;min-height:0;overflow:auto;padding:12px;
}
.v111-chart-host{
 min-height:100%;width:100%;
}
.v111-chart-host > *{margin-top:0!important}
.v111-chart-modal .modal,
.v111-chart-modal .dialog,
.v111-chart-modal .modal-card,
.v111-chart-modal .dialog-card{
 position:static!important;inset:auto!important;display:block!important;
 width:100%!important;max-width:none!important;height:auto!important;max-height:none!important;
 margin:0!important;transform:none!important;opacity:1!important;visibility:visible!important;
 box-shadow:none!important;border:0!important;background:transparent!important;
}
.v111-chart-modal .modal-backdrop,
.v111-chart-modal .dialog-backdrop{
 display:none!important;
}
.v111-chart-modal canvas{max-width:100%!important}

.v111-chart-help{
 display:none;padding:9px 12px;border-bottom:1px solid var(--v10-line);
 color:var(--v10-muted);font-size:.75rem;background:var(--v10-card)
}
.v111-chart-help.show{display:block}

@media(min-width:760px){
 .v111-chart-modal{inset:24px!important;max-height:calc(100vh - 48px)!important}
 .v111-chart-modal-body{padding:16px}
}
@media(max-width:679px){
 .v111-chart-modal{inset:0!important;max-height:100vh!important;border-radius:0!important;border:0!important}
 .v111-chart-modal-head{padding:8px}
 .v111-chart-modal-title span{max-width:44vw}
 .v111-chart-modal-actions button{padding:6px 8px!important}
}


/* =========================================================
   V11.2 — TRUE DASHBOARD / CHART WORKSPACE SWITCHING
   ========================================================= */
html.v112-chart-mode,
body.v112-chart-mode{
 overflow:hidden!important;
 height:100%!important;
}

body.v112-chart-mode > *:not(#v112ChartWorkspace):not(script):not(style){
 display:none!important;
}

#v112ChartWorkspace{
 display:none;
 position:fixed;
 inset:0;
 z-index:2147483646;
 background:var(--v10-bg);
 color:var(--v10-text);
 overflow:hidden;
}

body.v112-chart-mode #v112ChartWorkspace{
 display:flex!important;
 flex-direction:column;
}

.v112-chart-toolbar{
 flex:0 0 auto;
 display:flex;
 align-items:center;
 justify-content:space-between;
 gap:10px;
 padding:10px 12px;
 border-bottom:1px solid var(--v10-line);
 background:var(--v10-panel-solid);
 box-shadow:0 8px 30px rgba(0,0,0,.2);
}

.v112-chart-toolbar-left,
.v112-chart-toolbar-right{
 display:flex;
 align-items:center;
 gap:8px;
 flex-wrap:wrap;
}

.v112-chart-heading{
 min-width:0;
}

.v112-chart-heading strong{
 display:block;
 font-size:1rem;
}

.v112-chart-heading span{
 display:block;
 max-width:45vw;
 color:var(--v10-muted);
 font-size:.72rem;
 white-space:nowrap;
 overflow:hidden;
 text-overflow:ellipsis;
}

.v112-back-btn{
 color:#fff!important;
 background:linear-gradient(135deg,var(--v10-primary),var(--v10-primary-2))!important;
 border-color:transparent!important;
 font-weight:900!important;
}

.v112-chart-toolbar button,
.v112-chart-toolbar select{
 min-height:40px!important;
}

.v112-chart-stage{
 flex:1 1 auto;
 min-height:0;
 overflow:auto;
 padding:12px;
 background:
 radial-gradient(circle at 20% 0%,color-mix(in srgb,var(--v10-primary) 8%,transparent),transparent 32%),
 var(--v10-bg);
}

.v112-chart-host{
 width:100%;
 min-height:100%;
}

.v112-chart-host > *{
 margin-top:0!important;
}

.v112-chart-workspace-panel{
 width:100%!important;
 max-width:none!important;
 margin:0!important;
 position:static!important;
 inset:auto!important;
 transform:none!important;
 opacity:1!important;
 visibility:visible!important;
 display:block!important;
 box-shadow:none!important;
 border:0!important;
 background:transparent!important;
}

.v112-chart-workspace-panel .modal-backdrop,
.v112-chart-workspace-panel .dialog-backdrop,
.v112-chart-workspace-panel [class*="backdrop"]{
 display:none!important;
}

.v112-chart-workspace-panel .modal-card,
.v112-chart-workspace-panel .dialog-card,
.v112-chart-workspace-panel > .card{
 width:100%!important;
 max-width:none!important;
 max-height:none!important;
 margin:0!important;
}

.v112-chart-help{
 display:none;
 padding:9px 12px;
 border-bottom:1px solid var(--v10-line);
 background:var(--v10-card);
 color:var(--v10-muted);
 font-size:.76rem;
}

.v112-chart-help.show{
 display:block;
}

#v112NoChart[hidden]{display:none!important}
.v112-no-chart{
 display:grid;
 place-items:center;
 min-height:55vh;
 padding:28px;
 border:1px dashed var(--v10-line);
 border-radius:18px;
 background:var(--v10-panel);
 color:var(--v10-muted);
 text-align:center;
}

.v112-fullscreen #v112ChartWorkspace{
 position:fixed!important;
 inset:0!important;
}

@media(max-width:720px){
 .v112-chart-toolbar{
  align-items:flex-start;
  padding:8px;
 }
 .v112-chart-toolbar-left,
 .v112-chart-toolbar-right{
  gap:6px;
 }
 .v112-chart-heading{
  width:100%;
  order:3;
 }
 .v112-chart-heading span{
  max-width:90vw;
 }
 .v112-chart-toolbar button{
  padding:7px 9px!important;
 }
 .v112-chart-stage{
  padding:8px;
 }
}


/* =========================================================
   V11.3 — 3M CHART MODAL / WATCH-LIST LAYERING FIX
   ========================================================= */

/* Watch-list area must never create a higher stacking layer than charts. */
#marketWorkspace,
.sidebar,
[class*="watch-list" i],
[class*="watchlist" i],
[data-section="watchlists"],
[data-panel="watchlists"],
.v105-dashboard,
.v11-shell{
 position:relative!important;
 z-index:1!important;
 isolation:auto!important;
}

/* Any 3M/chart modal must stay above the complete application UI. */
#chartModal,
#chartsModal,
#listChartsModal,
#viewChartsModal,
#threeMonthChartsModal,
#threeMonthsChartsModal,
#threeMonthChartModal,
#chartGalleryModal,
[id*="3m"][class*="modal" i],
[id*="three"][id*="month"][class*="modal" i],
[id*="chart"][class*="modal" i],
[class*="3m"][class*="modal" i],
[class*="three-month"][class*="modal" i],
[class*="chart"][class*="modal" i],
.modal:has(canvas),
.modal:has(svg),
.dialog:has(canvas),
.dialog:has(svg){
 position:fixed!important;
 z-index:2147483645!important;
 isolation:isolate!important;
}

/* Modal backdrop belongs directly below the modal but above Watch Lists. */
.modal-backdrop,
.dialog-backdrop,
[class*="modal-backdrop" i],
[class*="dialog-backdrop" i],
[id*="chart"][class*="backdrop" i]{
 position:fixed!important;
 z-index:2147483644!important;
}

/* Disable sticky/fixed behavior of the Watch Lists panel while chart UI is active. */
body.v113-chart-overlay-open #marketWorkspace,
body.v113-chart-overlay-open .sidebar,
body.v113-chart-overlay-open [class*="watch-list" i],
body.v113-chart-overlay-open [class*="watchlist" i],
body.v113-chart-overlay-open [data-section="watchlists"],
body.v113-chart-overlay-open [data-panel="watchlists"]{
 visibility:hidden!important;
 pointer-events:none!important;
 transform:none!important;
 z-index:-1!important;
}

/* Preserve the dedicated v11.2 chart workspace when used. */
body.v112-chart-mode #v112ChartWorkspace{
 display:flex!important;
 z-index:2147483646!important;
}



/* =========================================================
   V11.5 — PER-WATCH-LIST PREMIUM TOOLTIP
   ========================================================= */
.v115-watch-tooltip{
 position:fixed;
 z-index:2147483643;
 width:min(360px,calc(100vw - 24px));
 max-height:min(70vh,560px);
 overflow:auto;
 padding:0;
 border:1px solid color-mix(in srgb,var(--v10-primary) 42%,var(--v10-line));
 border-radius:18px;
 background:
  linear-gradient(155deg,
   color-mix(in srgb,var(--v10-panel-solid) 96%,transparent),
   color-mix(in srgb,var(--v10-card) 96%,transparent));
 backdrop-filter:blur(18px) saturate(145%);
 box-shadow:
  0 24px 70px rgba(0,0,0,.48),
  inset 0 1px 0 rgba(255,255,255,.12);
 opacity:0;
 visibility:hidden;
 transform:translateY(8px) scale(.98);
 transform-origin:top left;
 transition:opacity .16s ease,transform .16s ease,visibility .16s ease;
 pointer-events:none;
}

.v115-watch-tooltip.open{
 opacity:1;
 visibility:visible;
 transform:none;
}

.v115-watch-tooltip.interactive{
 pointer-events:auto;
}

.v115-watch-tooltip::before{
 content:"";
 position:absolute;
 inset:0 0 auto;
 height:4px;
 background:linear-gradient(90deg,var(--v10-primary),var(--v10-accent),var(--v10-success));
}

.v115-watch-tooltip-head{
 display:flex;
 align-items:flex-start;
 justify-content:space-between;
 gap:12px;
 padding:16px 16px 13px;
 border-bottom:1px solid var(--v10-line);
 background:color-mix(in srgb,var(--v10-panel-solid) 93%,transparent);
}

.v115-watch-title{
 display:flex;
 gap:10px;
 min-width:0;
}

.v115-watch-icon{
 flex:0 0 auto;
 display:grid;
 place-items:center;
 width:40px;
 height:40px;
 border-radius:13px;
 background:linear-gradient(145deg,
  color-mix(in srgb,var(--v10-primary) 24%,var(--v10-card)),
  color-mix(in srgb,var(--v10-accent) 18%,var(--v10-panel-solid)));
 box-shadow:inset 0 1px 0 rgba(255,255,255,.16),0 9px 22px rgba(0,0,0,.2);
}

.v115-watch-title strong{
 display:block;
 font-size:.96rem;
 white-space:nowrap;
 overflow:hidden;
 text-overflow:ellipsis;
 max-width:230px;
}

.v115-watch-title span{
 display:block;
 margin-top:3px;
 color:var(--v10-muted);
 font-size:.72rem;
}

.v115-watch-close{
 display:grid;
 place-items:center;
 width:32px!important;
 min-width:32px!important;
 height:32px!important;
 min-height:32px!important;
 padding:0!important;
 border-radius:10px!important;
}

.v115-watch-tooltip-body{
 padding:14px 16px 16px;
}

.v115-watch-stats{
 display:grid;
 grid-template-columns:repeat(2,minmax(0,1fr));
 gap:9px;
}

.v115-watch-stat{
 padding:11px 12px;
 border:1px solid var(--v10-line);
 border-radius:13px;
 background:color-mix(in srgb,var(--v10-card) 82%,transparent);
}

.v115-watch-stat span{
 display:block;
 color:var(--v10-muted);
 font-size:.66rem;
 text-transform:uppercase;
 letter-spacing:.05em;
}

.v115-watch-stat strong{
 display:block;
 margin-top:4px;
 font-size:.92rem;
}

.v115-watch-preview-title{
 margin-top:13px;
 margin-bottom:7px;
 display:flex;
 align-items:center;
 justify-content:space-between;
 gap:8px;
 font-size:.75rem;
 font-weight:800;
}

.v115-watch-preview-title span{
 color:var(--v10-muted);
 font-weight:500;
 font-size:.67rem;
}

.v115-watch-code-list{
 display:flex;
 flex-wrap:wrap;
 gap:6px;
}

.v115-watch-code{
 display:inline-flex;
 align-items:center;
 padding:5px 8px;
 border:1px solid var(--v10-line);
 border-radius:999px;
 background:color-mix(in srgb,var(--v10-bg) 68%,var(--v10-card));
 font-family:ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;
 font-size:.67rem;
 font-weight:700;
}

.v115-watch-empty{
 padding:12px;
 border:1px dashed var(--v10-line);
 border-radius:12px;
 color:var(--v10-muted);
 text-align:center;
 font-size:.72rem;
}

.v115-watch-more{
 color:var(--v10-primary);
 font-size:.68rem;
 font-weight:800;
}

.v115-watch-actions{
 display:flex;
 gap:8px;
 margin-top:14px;
 padding-top:12px;
 border-top:1px solid var(--v10-line);
}

.v115-watch-actions button{
 flex:1 1 0;
 min-height:36px!important;
 padding:7px 9px!important;
 font-size:.7rem!important;
}

.v115-watch-tooltip-arrow{
 position:fixed;
 width:12px;
 height:12px;
 z-index:2147483642;
 background:var(--v10-panel-solid);
 border-left:1px solid var(--v10-line);
 border-top:1px solid var(--v10-line);
 transform:rotate(45deg);
 opacity:0;
 visibility:hidden;
 transition:.16s ease;
 pointer-events:none;
}

.v115-watch-tooltip-arrow.open{
 opacity:1;
 visibility:visible;
}

.v115-watch-item{
 position:relative;
}

.v115-watch-item::after{
 content:"";
 position:absolute;
 right:6px;
 top:50%;
 width:6px;
 height:6px;
 border-radius:50%;
 background:var(--v10-primary);
 transform:translateY(-50%) scale(.7);
 opacity:.25;
 transition:.16s ease;
}

.v115-watch-item:hover::after,
.v115-watch-item:focus-within::after{
 opacity:.8;
 transform:translateY(-50%) scale(1);
 box-shadow:0 0 0 4px color-mix(in srgb,var(--v10-primary) 12%,transparent);
}

@media(max-width:620px){
 .v115-watch-tooltip{
  left:12px!important;
  right:12px!important;
  bottom:12px!important;
  top:auto!important;
  width:auto;
  max-height:72vh;
  transform-origin:bottom center;
  border-radius:18px;
 }
 .v115-watch-tooltip-arrow{
  display:none!important;
 }
 .v115-watch-title strong{
  max-width:190px;
 }
}


/* =========================================================
   v11.7 — LIGHT-GRAY HIGH-CONTRAST CHART THEME
   ========================================================= */

:root{
 --v116-chart-bg:#f3f4f6;
 --v116-chart-plot:#f8fafc;
 --v116-chart-grid:#d1d5db;
 --v116-chart-grid-soft:#e5e7eb;
 --v116-chart-axis:#374151;
 --v116-chart-border:#cbd5e1;
 --v116-bull:#16a34a;
 --v116-bull-dark:#15803d;
 --v116-bear:#dc2626;
 --v116-bear-dark:#b91c1c;
}

/* Apply the neutral chart palette only to real plot containers.
   Do not use broad [id*=chart] or [class*=chart-] selectors here: those
   also match the ranked gallery modal, its header, title and controls. */
.chart-container,
.chart-wrap,
.chart-panel,
.chart-box,
.chart-area,
.chart-canvas-wrap,
.modal .chart-container,
.modal .chart-wrap,
.modal .chart-panel,
.modal .chart-box,
.modal .chart-area,
.modal .chart-canvas-wrap,
canvas#chart,
canvas#charts,
svg#chart,
svg#charts{
 background:var(--v116-chart-bg)!important;
 border-color:var(--v116-chart-border)!important;
}

.chart-container canvas,
.chart-wrap canvas,
.chart-panel canvas,
.chart-box canvas,
.chart-area canvas,
.chart-canvas-wrap canvas,
.modal .chart-container canvas,
.modal .chart-wrap canvas,
.modal .chart-panel canvas,
.modal .chart-box canvas,
.modal .chart-area canvas,
.modal .chart-canvas-wrap canvas,
canvas[id*="chart" i],
canvas[class~="chart"]{
 background:var(--v116-chart-plot)!important;
 border-radius:10px;
}

/* SVG backgrounds are limited to SVGs inside an actual plot container.
   This deliberately excludes modal header/close icons. */
.chart-container > svg,
.chart-wrap > svg,
.chart-panel > svg,
.chart-box > svg,
.chart-area > svg,
.chart-canvas-wrap > svg{
 background:var(--v116-chart-plot)!important;
}

/* Keep labels readable if the chart library renders DOM overlays */
.chart-container,
.chart-wrap,
.chart-panel,
.chart-box,
.chart-area,
.chart-container *,
.chart-wrap *,
.chart-panel *,
.chart-box *,
.chart-area *{
 --chart-text-color:var(--v116-chart-axis);
}

/* Lightweight Charts / TradingView canvas host */
.tv-lightweight-charts,
.lightweight-chart,
.lightweight-charts,
.chart-host,
.kline-chart{
 background:var(--v116-chart-plot)!important;
}

/* Plotly */
.js-plotly-plot .plotly,
.js-plotly-plot .svg-container,
.js-plotly-plot .main-svg{
 background:var(--v116-chart-plot)!important;
}

/* ECharts */
.echarts-for-react,
.echarts-container{
 background:var(--v116-chart-plot)!important;
}

/* Chart modal/workspace should also stay light */
#chartWorkspace,
.chart-workspace,
.v112-chart-workspace,
.v113-chart-workspace,
.chart-modal-content,
.modal-content:has(canvas),
.modal-content:has(svg){
 background:var(--v116-chart-bg)!important;
}

/* Optional legend contrast */
.chart-legend,
.chart-title,
.chart-subtitle,
.chart-toolbar,
.chart-meta{
 color:var(--v116-chart-axis)!important;
}


/* V11.9 responsive upper-right terminal menu */
.v119-terminal-menu{position:fixed;top:14px;right:14px;z-index:2147483600}
.v119-menu-toggle{display:inline-flex;align-items:center;gap:8px;min-height:42px!important;padding:9px 14px!important;border-radius:14px!important;box-shadow:0 12px 34px rgba(0,0,0,.22);backdrop-filter:blur(14px)}
.v119-menu-toggle .dots{display:grid;grid-template-columns:repeat(2,5px);gap:3px}
.v119-menu-toggle .dots i{width:5px;height:5px;border-radius:2px;background:currentColor}
.v119-menu-panel{position:absolute;top:50px;right:0;width:min(340px,calc(100vw - 28px));max-height:min(76vh,720px);overflow:auto;padding:10px;border:1px solid var(--v10-line,rgba(148,163,184,.35));border-radius:18px;background:linear-gradient(155deg,color-mix(in srgb,var(--v10-panel-solid,#111827) 96%,transparent),color-mix(in srgb,var(--v10-card,#1f2937) 96%,transparent));backdrop-filter:blur(18px);box-shadow:0 24px 72px rgba(0,0,0,.42);opacity:0;visibility:hidden;transform:translateY(-8px) scale(.98);transform-origin:top right;transition:.18s ease}
.v119-terminal-menu.open .v119-menu-panel{opacity:1;visibility:visible;transform:none}
.v119-menu-head{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:8px 8px 10px;border-bottom:1px solid var(--v10-line,rgba(148,163,184,.25));margin-bottom:8px}
.v119-menu-head small{display:block;color:var(--v10-muted,#94a3b8);margin-top:2px}
.v119-menu-close{width:32px!important;min-width:32px!important;height:32px!important;min-height:32px!important;padding:0!important}
.v119-menu-groups{display:grid;gap:9px}
.v119-menu-group{border:1px solid var(--v10-line,rgba(148,163,184,.25));border-radius:14px;overflow:hidden;background:color-mix(in srgb,var(--v10-card,#1f2937) 82%,transparent)}
.v119-menu-group-title{display:flex;align-items:center;gap:8px;width:100%;padding:10px 12px;border:0;background:transparent;color:inherit;cursor:pointer;text-align:left;font:inherit;font-weight:800}
.v119-menu-group-title:hover{background:color-mix(in srgb,var(--v10-primary,#2563eb) 8%,transparent)}
.v119-menu-group-title .count{margin-left:auto;color:var(--v10-muted,#94a3b8);font-size:.65rem}
.v119-menu-group-body{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:7px;padding:0 9px 9px}
.v119-menu-group.collapsed .v119-menu-group-body{display:none}
.v119-menu-action{width:100%!important;min-width:0!important;min-height:38px!important;padding:8px 9px!important;justify-content:flex-start!important;text-align:left!important;white-space:normal!important;border-radius:10px!important}
.v119-menu-backdrop{position:fixed;inset:0;z-index:2147483599;background:rgba(15,23,42,.28);backdrop-filter:blur(2px);opacity:0;visibility:hidden;transition:.18s ease}
.v119-menu-backdrop.open{opacity:1;visibility:visible}
.v119-menu-source-hidden{display:none!important}
body.v119-menu-open{overflow:hidden}
@media(max-width:720px){
 .v119-terminal-menu{top:8px;right:8px}
 .v119-menu-toggle .label{display:none}
 .v119-menu-panel{position:fixed;top:auto;right:8px;left:8px;bottom:8px;width:auto;max-height:78vh;transform-origin:bottom center}
 .v119-menu-group-body{grid-template-columns:1fr}
}


/* =========================================================
   V11.10 — FULL-WIDTH TERMINAL MENU FIX
   ========================================================= */
.v119-terminal-menu{
 position:fixed!important;
 inset:0!important;
 top:0!important;
 right:0!important;
 width:100%!important;
 height:0!important;
 z-index:2147483600!important;
 pointer-events:none!important;
}

.v119-menu-toggle{
 position:fixed!important;
 top:14px!important;
 right:14px!important;
 z-index:2147483602!important;
 pointer-events:auto!important;
}

.v119-menu-panel{
 position:fixed!important;
 inset:0!important;
 top:0!important;
 right:0!important;
 left:0!important;
 bottom:0!important;
 width:100vw!important;
 height:100vh!important;
 max-width:none!important;
 max-height:none!important;
 overflow:hidden!important;
 padding:0!important;
 border:0!important;
 border-radius:0!important;
 transform:translateY(-16px)!important;
 transform-origin:top center!important;
 display:flex!important;
 flex-direction:column!important;
 background:
  linear-gradient(155deg,
   color-mix(in srgb,var(--v10-panel-solid,#111827) 98%,transparent),
   color-mix(in srgb,var(--v10-card,#1f2937) 98%,transparent))!important;
 pointer-events:auto!important;
}

.v119-terminal-menu.open .v119-menu-panel{
 transform:none!important;
}

.v119-menu-head{
 position:sticky!important;
 top:0!important;
 z-index:4!important;
 flex:0 0 auto!important;
 margin:0!important;
 padding:16px 22px!important;
 min-height:68px!important;
 border-bottom:1px solid var(--v10-line,rgba(148,163,184,.25))!important;
 background:color-mix(in srgb,var(--v10-panel-solid,#111827) 96%,transparent)!important;
 backdrop-filter:blur(18px)!important;
}

.v119-menu-head strong{
 font-size:1.05rem!important;
}

.v119-menu-head small{
 font-size:.74rem!important;
}

.v119-menu-close{
 display:inline-grid!important;
 place-items:center!important;
 position:relative!important;
 z-index:5!important;
 width:42px!important;
 min-width:42px!important;
 height:42px!important;
 min-height:42px!important;
 padding:0!important;
 border-radius:12px!important;
 font-size:1.05rem!important;
 box-shadow:0 8px 24px rgba(0,0,0,.22)!important;
}

.v119-menu-groups{
 flex:1 1 auto!important;
 min-height:0!important;
 overflow:auto!important;
 display:grid!important;
 grid-template-columns:repeat(auto-fit,minmax(280px,1fr))!important;
 align-content:start!important;
 gap:14px!important;
 padding:18px 22px 28px!important;
}

.v119-menu-group{
 display:block!important;
 min-width:0!important;
 overflow:visible!important;
 border-radius:16px!important;
}

.v119-menu-group-title{
 position:sticky!important;
 top:0!important;
 z-index:2!important;
 min-height:44px!important;
 background:color-mix(in srgb,var(--v10-card,#1f2937) 96%,transparent)!important;
 border-bottom:1px solid var(--v10-line,rgba(148,163,184,.22))!important;
}

.v119-menu-group-body{
 display:grid!important;
 grid-template-columns:repeat(2,minmax(0,1fr))!important;
 gap:8px!important;
 padding:10px!important;
 max-height:none!important;
 overflow:visible!important;
}

.v119-menu-group.collapsed .v119-menu-group-body{
 display:none!important;
}

.v119-menu-panel .v119-menu-action{
 display:flex!important;
 align-items:center!important;
 width:100%!important;
 min-width:0!important;
 min-height:42px!important;
 padding:9px 10px!important;
 overflow:visible!important;
 opacity:1!important;
 visibility:visible!important;
 transform:none!important;
}

.v119-menu-backdrop{
 display:none!important;
}

body.v119-menu-open{
 overflow:hidden!important;
}

body.v119-menu-open .v119-menu-toggle{
 display:none!important;
}

@media(max-width:900px){
 .v119-menu-groups{
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
 }
}

@media(max-width:640px){
 .v119-menu-toggle{
  top:8px!important;
  right:8px!important;
 }
 .v119-menu-panel{
  border-radius:0!important;
 }
 .v119-menu-head{
  padding:12px 14px!important;
  min-height:60px!important;
 }
 .v119-menu-groups{
  grid-template-columns:1fr!important;
  gap:10px!important;
  padding:12px 12px 20px!important;
 }
 .v119-menu-group-body{
  grid-template-columns:1fr!important;
 }
 .v119-menu-close{
  width:40px!important;
  min-width:40px!important;
  height:40px!important;
  min-height:40px!important;
 }
}


/* =========================================================
   V11.11 — STABLE OPAQUE TERMINAL MENU
   ========================================================= */

/* Keep the launcher permanently visible in the upper-right corner. */
.v119-terminal-menu{
 position:fixed!important;
 inset:0!important;
 width:0!important;
 height:0!important;
 z-index:2147483600!important;
 pointer-events:none!important;
}

.v119-menu-toggle{
 position:fixed!important;
 top:12px!important;
 right:12px!important;
 z-index:2147483605!important;
 display:inline-flex!important;
 pointer-events:auto!important;
 opacity:1!important;
 visibility:visible!important;
 transform:none!important;
}

/* The launcher remains visible even while the menu is open. */
body.v119-menu-open .v119-menu-toggle{
 display:inline-flex!important;
}

/* Use a solid, high-contrast background instead of transparent glass. */
.v119-menu-panel{
 position:fixed!important;
 inset:0!important;
 width:100vw!important;
 height:100dvh!important;
 max-width:none!important;
 max-height:none!important;
 padding:0!important;
 overflow:hidden!important;
 border:0!important;
 border-radius:0!important;
 background:#0b1220!important;
 background-image:
  radial-gradient(circle at 15% 0%,rgba(37,99,235,.18),transparent 30%),
  radial-gradient(circle at 85% 10%,rgba(14,165,233,.12),transparent 28%)!important;
 color:#e5edf8!important;
 opacity:0!important;
 visibility:hidden!important;
 transform:translateY(-12px)!important;
 pointer-events:none!important;
 display:flex!important;
 flex-direction:column!important;
 transition:opacity .18s ease,transform .18s ease,visibility .18s ease!important;
}

.v119-terminal-menu.open .v119-menu-panel{
 opacity:1!important;
 visibility:visible!important;
 transform:none!important;
 pointer-events:auto!important;
}

/* Dark header remains readable and does not overlap the fixed launcher. */
.v119-menu-head{
 position:relative!important;
 top:auto!important;
 z-index:3!important;
 flex:0 0 auto!important;
 min-height:72px!important;
 margin:0!important;
 padding:15px 82px 15px 20px!important;
 border-bottom:1px solid #263449!important;
 background:#101a2b!important;
 color:#f8fafc!important;
 backdrop-filter:none!important;
}

.v119-menu-head strong{
 color:#f8fafc!important;
 font-size:1.08rem!important;
}

.v119-menu-head small{
 color:#aebdd0!important;
}

/* Dedicated close button stays clearly visible below/left of launcher. */
.v119-menu-close{
 position:fixed!important;
 top:14px!important;
 right:66px!important;
 z-index:2147483606!important;
 display:none!important;
 place-items:center!important;
 width:42px!important;
 min-width:42px!important;
 height:42px!important;
 min-height:42px!important;
 padding:0!important;
 border:1px solid #52657e!important;
 border-radius:12px!important;
 background:#18263a!important;
 color:#fff!important;
 box-shadow:0 10px 28px rgba(0,0,0,.35)!important;
 pointer-events:auto!important;
}

.v119-terminal-menu.open .v119-menu-close{
 display:grid!important;
}

/* The scrollable area is opaque and spacious. */
.v119-menu-groups{
 flex:1 1 auto!important;
 min-height:0!important;
 overflow-y:auto!important;
 overflow-x:hidden!important;
 display:grid!important;
 grid-template-columns:repeat(auto-fit,minmax(290px,1fr))!important;
 align-content:start!important;
 gap:14px!important;
 padding:18px 20px 32px!important;
 background:#0b1220!important;
}

/* Menu cards and submenu items use strong separation. */
.v119-menu-group{
 display:block!important;
 min-width:0!important;
 overflow:hidden!important;
 border:1px solid #2a3a50!important;
 border-radius:16px!important;
 background:#121d2e!important;
 box-shadow:0 10px 26px rgba(0,0,0,.18)!important;
}

.v119-menu-group-title{
 position:relative!important;
 top:auto!important;
 z-index:1!important;
 display:flex!important;
 align-items:center!important;
 width:100%!important;
 min-height:48px!important;
 padding:11px 13px!important;
 border:0!important;
 border-bottom:1px solid #2a3a50!important;
 background:#172438!important;
 color:#f3f7fc!important;
 cursor:pointer!important;
}

.v119-menu-group-title:hover{
 background:#1d2d45!important;
}

.v119-menu-group-title .count{
 margin-left:auto!important;
 color:#aebdd0!important;
}

.v119-menu-group-title .v1111-caret{
 margin-left:4px!important;
 transition:transform .16s ease!important;
}

.v119-menu-group.collapsed .v119-menu-group-title .v1111-caret{
 transform:rotate(-90deg)!important;
}

/* Collapse is enforced through the hidden attribute and class fallback. */
.v119-menu-group-body{
 display:grid!important;
 grid-template-columns:repeat(2,minmax(0,1fr))!important;
 gap:8px!important;
 padding:10px!important;
 background:#121d2e!important;
}

.v119-menu-group-body[hidden],
.v119-menu-group.collapsed .v119-menu-group-body{
 display:none!important;
}

.v119-menu-panel .v119-menu-action{
 display:flex!important;
 align-items:center!important;
 justify-content:flex-start!important;
 width:100%!important;
 min-width:0!important;
 min-height:42px!important;
 padding:9px 10px!important;
 border:1px solid #30425a!important;
 border-radius:10px!important;
 background:#18263a!important;
 color:#ecf3fb!important;
 opacity:1!important;
 visibility:visible!important;
 white-space:normal!important;
 text-align:left!important;
 pointer-events:auto!important;
}

.v119-menu-panel .v119-menu-action:hover{
 background:#21334d!important;
 border-color:#527096!important;
}

/* Real modal backdrop prevents visual confusion with the terminal underneath. */
.v119-menu-backdrop{
 position:fixed!important;
 inset:0!important;
 z-index:2147483599!important;
 display:block!important;
 background:rgba(2,6,14,.88)!important;
 opacity:0!important;
 visibility:hidden!important;
 pointer-events:none!important;
 transition:opacity .18s ease,visibility .18s ease!important;
}

.v119-menu-backdrop.open{
 opacity:1!important;
 visibility:visible!important;
 pointer-events:auto!important;
}

body.v119-menu-open{
 overflow:hidden!important;
}

/* Only designated source command controls are hidden, never Trading Workspace controls. */
.v119-menu-source-hidden{
 display:none!important;
}

@media(max-width:820px){
 .v119-menu-groups{
  grid-template-columns:repeat(2,minmax(0,1fr))!important;
 }
}

@media(max-width:620px){
 .v119-menu-toggle{
  top:8px!important;
  right:8px!important;
 }
 .v119-menu-close{
  top:8px!important;
  right:58px!important;
  width:40px!important;
  min-width:40px!important;
  height:40px!important;
  min-height:40px!important;
 }
 .v119-menu-head{
  min-height:62px!important;
  padding:12px 108px 12px 13px!important;
 }
 .v119-menu-groups{
  grid-template-columns:1fr!important;
  gap:10px!important;
  padding:12px 10px 22px!important;
 }
 .v119-menu-group-body{
  grid-template-columns:1fr!important;
 }
}


/* V11.12 Watch List workspace trading-code search */
.v1112-watch-search{
 display:grid;
 grid-template-columns:minmax(180px,.75fr) minmax(280px,1.25fr);
 gap:10px 14px;
 align-items:end;
 padding:12px 14px;
 border-top:1px solid var(--line,rgba(148,163,184,.25));
 border-bottom:1px solid var(--line,rgba(148,163,184,.25));
 background:color-mix(in srgb,var(--card,#111827) 94%,transparent);
}
.v1112-watch-search-copy{display:grid;gap:3px}
.v1112-watch-search-copy label{font-weight:800}
.v1112-watch-search-copy small,
.v1112-watch-search-status{color:var(--muted,#94a3b8);font-size:.72rem;line-height:1.35}
.v1112-watch-search-controls{display:flex;gap:8px;min-width:0}
.v1112-watch-search-controls .input{flex:1 1 auto;width:100%;min-width:0}
.v1112-watch-search-status{grid-column:1/-1;min-height:1em}
.v1112-search-match{
 box-shadow:inset 3px 0 0 var(--primary,#2563eb);
 background:color-mix(in srgb,var(--primary,#2563eb) 7%,transparent);
}
@media(max-width:720px){
 .v1112-watch-search{grid-template-columns:1fr;padding:10px}
 .v1112-watch-search-status{grid-column:auto}
}
@media(max-width:430px){
 .v1112-watch-search-controls{display:grid;grid-template-columns:1fr auto}
}


/* V11.13 shared search above DSE and active watch-list panels */
.v1113-shared-code-search-panel{
 margin-bottom:16px;
 overflow:hidden;
}
.v1113-shared-code-search-panel .v1112-watch-search{
 border:0;
 border-radius:inherit;
}
@media(max-width:720px){
 .v1113-shared-code-search-panel{margin-bottom:12px}
}


/* =========================================================
   V11.14 — THEME-AWARE PREMIUM TRADING-CODE SEARCH
   ========================================================= */
.v1113-shared-code-search-panel{
 display:none!important;
}

.v1114-trading-code-workspace-search{
 margin:0 0 16px;
}

.v1114-workspace-label{
 display:flex;
 align-items:flex-end;
 justify-content:space-between;
 margin-bottom:10px;
}

.v1114-workspace-kicker,
.v1114-search-kicker{
 display:block;
 margin-bottom:3px;
 color:var(--v10-primary,var(--primary,#2563eb));
 font-size:.64rem;
 font-weight:900;
 letter-spacing:.14em;
 text-transform:uppercase;
}

.v1114-workspace-label h2{
 margin:0;
}

.v1114-code-search-shell{
 position:relative;
 display:grid;
 grid-template-columns:auto minmax(190px,.65fr) minmax(300px,1.35fr) auto;
 grid-template-areas:
  "orb copy field clear"
  "orb status status status";
 gap:9px 14px;
 align-items:center;
 overflow:hidden;
 padding:16px;
 border:1px solid var(--v10-line,var(--line,rgba(148,163,184,.30)));
 border-radius:20px;
 background:
  linear-gradient(
   135deg,
   color-mix(in srgb,var(--v10-card,var(--card,#111827)) 96%,transparent),
   color-mix(in srgb,var(--v10-panel-solid,var(--panel,#0f172a)) 94%,transparent)
  );
 color:var(--v10-text,var(--text,#e5edf8));
 box-shadow:
  0 18px 42px color-mix(in srgb,var(--v10-shadow,rgba(0,0,0,.32)) 80%,transparent),
  inset 0 1px 0 color-mix(in srgb,#fff 10%,transparent);
 isolation:isolate;
}

.v1114-code-search-shell::before{
 content:"";
 position:absolute;
 inset:-1px;
 z-index:-2;
 border-radius:inherit;
 background:
  radial-gradient(
   circle at 12% 10%,
   color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 28%,transparent),
   transparent 32%
  ),
  radial-gradient(
   circle at 88% 100%,
   color-mix(in srgb,var(--v10-accent,var(--accent,#06b6d4)) 20%,transparent),
   transparent 34%
  );
 pointer-events:none;
}

.v1114-code-search-shell::after{
 content:"";
 position:absolute;
 top:0;
 left:9%;
 right:9%;
 height:1px;
 background:linear-gradient(
  90deg,
  transparent,
  color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 78%,#fff),
  transparent
 );
 opacity:.85;
 pointer-events:none;
}

.v1114-search-orb{
 grid-area:orb;
 display:grid;
 place-items:center;
 width:54px;
 height:54px;
 border:1px solid color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 44%,var(--v10-line,var(--line,#334155)));
 border-radius:17px;
 background:
  linear-gradient(
   145deg,
   color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 24%,var(--v10-card,var(--card,#111827))),
   color-mix(in srgb,var(--v10-card,var(--card,#111827)) 96%,transparent)
  );
 color:var(--v10-primary,var(--primary,#60a5fa));
 font-size:1.75rem;
 font-weight:900;
 box-shadow:
  0 10px 28px color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 22%,transparent),
  inset 0 1px 0 rgba(255,255,255,.11);
}

.v1114-search-copy{
 grid-area:copy;
 min-width:0;
}

.v1114-search-copy label{
 display:block;
 color:var(--v10-text,var(--text,#f8fafc));
 font-size:1rem;
 font-weight:900;
 letter-spacing:-.01em;
}

.v1114-search-copy small{
 display:block;
 margin-top:3px;
 color:var(--v10-muted,var(--muted,#94a3b8));
 font-size:.72rem;
 line-height:1.35;
}

.v1114-search-field-wrap{
 grid-area:field;
 position:relative;
 min-width:0;
}

.v1114-search-icon{
 position:absolute;
 left:14px;
 top:50%;
 z-index:2;
 transform:translateY(-50%);
 color:var(--v10-primary,var(--primary,#60a5fa));
 font-size:1.15rem;
 pointer-events:none;
}

.v1114-search-input{
 width:100%!important;
 min-height:50px!important;
 padding:11px 46px 11px 42px!important;
 border:1px solid color-mix(in srgb,var(--v10-line,var(--line,#334155)) 90%,transparent)!important;
 border-radius:15px!important;
 outline:0!important;
 background:
  color-mix(in srgb,var(--v10-input,var(--v10-panel-solid,var(--panel,#0f172a))) 96%,transparent)!important;
 color:var(--v10-text,var(--text,#f8fafc))!important;
 font-size:.92rem!important;
 font-weight:750!important;
 box-shadow:
  inset 0 1px 0 rgba(255,255,255,.04),
  0 8px 22px rgba(0,0,0,.12)!important;
 transition:
  border-color .18s ease,
  box-shadow .18s ease,
  transform .18s ease,
  background .18s ease!important;
}

.v1114-search-input::placeholder{
 color:color-mix(in srgb,var(--v10-muted,var(--muted,#94a3b8)) 84%,transparent);
 font-weight:600;
}

.v1114-search-input:hover{
 border-color:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 52%,var(--v10-line,var(--line,#334155)))!important;
}

.v1114-search-input:focus{
 border-color:var(--v10-primary,var(--primary,#2563eb))!important;
 background:color-mix(in srgb,var(--v10-card,var(--card,#111827)) 97%,transparent)!important;
 box-shadow:
  0 0 0 4px color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 18%,transparent),
  0 14px 34px color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 16%,transparent)!important;
 transform:translateY(-1px);
}

.v1114-search-key{
 position:absolute;
 right:12px;
 top:50%;
 transform:translateY(-50%);
 min-width:25px;
 padding:3px 7px;
 border:1px solid var(--v10-line,var(--line,#334155));
 border-bottom-width:2px;
 border-radius:7px;
 background:color-mix(in srgb,var(--v10-card,var(--card,#111827)) 90%,transparent);
 color:var(--v10-muted,var(--muted,#94a3b8));
 font:700 .7rem/1 system-ui,sans-serif;
 text-align:center;
 pointer-events:none;
}

.v1114-search-clear{
 grid-area:clear;
 min-height:48px!important;
 padding-inline:17px!important;
 border-radius:14px!important;
}

.v1114-watch-search-status{
 grid-area:status;
 min-height:18px;
 color:var(--v10-muted,var(--muted,#94a3b8));
 font-size:.72rem;
 font-weight:650;
}

.v1112-search-match{
 border-color:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 46%,var(--v10-line,var(--line,#334155)))!important;
 box-shadow:
  inset 3px 0 0 var(--v10-primary,var(--primary,#2563eb)),
  0 8px 22px color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 8%,transparent)!important;
 background:
  linear-gradient(
   90deg,
   color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 11%,transparent),
   transparent 42%
  )!important;
}

@media(max-width:940px){
 .v1114-code-search-shell{
  grid-template-columns:auto minmax(0,1fr) auto;
  grid-template-areas:
   "orb copy clear"
   "field field field"
   "status status status";
 }
}

@media(max-width:620px){
 .v1114-code-search-shell{
  grid-template-columns:auto minmax(0,1fr);
  grid-template-areas:
   "orb copy"
   "field field"
   "clear clear"
   "status status";
  padding:13px;
  border-radius:17px;
 }
 .v1114-search-orb{
  width:46px;
  height:46px;
  border-radius:14px;
  font-size:1.45rem;
 }
 .v1114-search-clear{
  width:100%!important;
 }
}

@media(max-width:420px){
 .v1114-search-copy small{
  font-size:.68rem;
 }
 .v1114-search-input{
  min-height:48px!important;
  padding-right:40px!important;
 }
}


/* =========================================================
   V11.16 — CORRECT COLLAPSIBLE SEARCH + COMPLETE DOWNLOAD CENTER
   ========================================================= */

/* Search is an actual first child/row of #marketWorkspace. */
#marketWorkspace > .v1116-search-first-row{
 grid-column:1/-1!important;
 width:100%!important;
 min-width:0!important;
 order:-1000!important;
 margin:0!important;
}

#marketWorkspace > .v1116-search-first-row .v1114-code-search-shell{
 width:100%!important;
 margin:0!important;
}

/* Remove styling intended for the former external wrapper. */
.v1114-trading-code-workspace-search{
 display:none!important;
}

/* Complete Download Center */
.v1116-download-workspace{
 display:grid;
 gap:14px;
 min-width:0;
}

.v1116-download-actions{
 position:relative;
 overflow:hidden;
 padding:16px;
 border:1px solid var(--v10-line,var(--line,#dce5ee));
 border-radius:19px;
 background:
  linear-gradient(
   145deg,
   color-mix(in srgb,var(--v10-card,var(--card,#fff)) 97%,transparent),
   color-mix(in srgb,var(--v10-panel-solid,var(--card,#fff)) 93%,transparent)
  );
 box-shadow:
  0 16px 40px color-mix(in srgb,var(--v10-shadow,rgba(15,23,42,.14)) 78%,transparent),
  inset 0 1px 0 rgba(255,255,255,.10);
}

.v1116-download-actions::before{
 content:"";
 position:absolute;
 inset:0;
 pointer-events:none;
 background:
  radial-gradient(circle at 5% 0%,
   color-mix(in srgb,var(--v10-primary,var(--primary,#087f75)) 18%,transparent),
   transparent 32%),
  radial-gradient(circle at 100% 100%,
   color-mix(in srgb,var(--v10-accent,var(--blue,#2563eb)) 14%,transparent),
   transparent 34%);
}

.v1116-download-intro{
 position:relative;
 z-index:1;
 margin-bottom:13px;
}

.v1116-download-kicker{
 display:block;
 margin-bottom:3px;
 color:var(--v10-primary,var(--primary,#087f75));
 font-size:.64rem;
 font-weight:950;
 letter-spacing:.15em;
}

.v1116-download-intro h3{
 margin:0;
 color:var(--v10-text,var(--ink,#172033));
 font-size:1.12rem;
}

.v1116-download-intro p{
 margin:4px 0 0;
 color:var(--v10-muted,var(--muted,#64748b));
 font-size:.76rem;
}

.v1116-download-action-grid{
 position:relative;
 z-index:1;
 display:grid;
 grid-template-columns:repeat(4,minmax(0,1fr));
 gap:10px;
}

.v1116-action-card{
 display:grid;
 grid-template-columns:auto minmax(0,1fr);
 gap:10px;
 align-items:center;
 min-width:0;
 min-height:78px;
 padding:11px;
 border:1px solid var(--v10-line,var(--line,#dce5ee));
 border-radius:14px;
 background:color-mix(in srgb,var(--v10-card,var(--card,#fff)) 94%,transparent);
 color:var(--v10-text,var(--ink,#172033));
 text-align:left;
 box-shadow:0 8px 20px rgba(0,0,0,.07);
 transition:transform .17s ease,border-color .17s ease,box-shadow .17s ease,background .17s ease;
}

.v1116-action-card:hover{
 transform:translateY(-2px);
 border-color:color-mix(in srgb,var(--v10-primary,var(--primary,#087f75)) 55%,var(--v10-line,var(--line,#dce5ee)));
 background:color-mix(in srgb,var(--v10-primary,var(--primary,#087f75)) 8%,var(--v10-card,var(--card,#fff)));
 box-shadow:0 13px 28px color-mix(in srgb,var(--v10-primary,var(--primary,#087f75)) 14%,transparent);
}

.v1116-action-icon{
 display:grid;
 place-items:center;
 width:42px;
 height:42px;
 padding:3px;
 border:1px solid color-mix(in srgb,var(--v10-primary,var(--primary,#087f75)) 38%,var(--v10-line,var(--line,#dce5ee)));
 border-radius:12px;
 background:linear-gradient(
  145deg,
  color-mix(in srgb,var(--v10-primary,var(--primary,#087f75)) 19%,var(--v10-card,var(--card,#fff))),
  color-mix(in srgb,var(--v10-card,var(--card,#fff)) 96%,transparent)
 );
 color:var(--v10-primary,var(--primary,#087f75));
 font-size:.68rem;
 font-weight:950;
}

.v1116-action-card strong{
 display:block;
 overflow:hidden;
 color:inherit;
 font-size:.79rem;
 line-height:1.25;
 text-overflow:ellipsis;
}

.v1116-action-card small{
 display:block;
 margin-top:3px;
 color:var(--v10-muted,var(--muted,#64748b));
 font-size:.66rem;
 line-height:1.3;
}

/* Status card is integrated below actions, not isolated elsewhere. */
.v1116-download-workspace #downloadStatusCard{
 margin:0!important;
 width:100%!important;
}

@media(max-width:1180px){
 .v1116-download-action-grid{
  grid-template-columns:repeat(2,minmax(0,1fr));
 }
}

@media(max-width:650px){
 #marketWorkspace > .v1116-search-first-row{
  margin-bottom:0!important;
 }
 .v1116-download-actions{
  padding:12px;
  border-radius:16px;
 }
 .v1116-download-action-grid{
  grid-template-columns:1fr;
  gap:8px;
 }
 .v1116-action-card{
  min-height:68px;
 }
}


/* =========================================================
   V11.17 — THEME SELECTION IN TERMINAL MENU
   ========================================================= */
.v1117-terminal-menu-only{
 position:absolute!important;
 width:1px!important;
 height:1px!important;
 margin:-1px!important;
 padding:0!important;
 overflow:hidden!important;
 clip:rect(0 0 0 0)!important;
 clip-path:inset(50%)!important;
 white-space:nowrap!important;
 border:0!important;
}

/* Generated menu clones/proxies must remain visible. */
#v119TerminalMenu .v1117-terminal-menu-only,
.v119-terminal-menu .v1117-terminal-menu-only,
.v111-terminal-menu .v1117-terminal-menu-only{
 position:static!important;
 width:auto!important;
 height:auto!important;
 margin:0!important;
 padding:inherit!important;
 overflow:visible!important;
 clip:auto!important;
 clip-path:none!important;
 white-space:normal!important;
 border:inherit!important;
}


/* V11.18 reliable Theme Selection item */
#v119TerminalMenu .v119-menu-action[aria-label="Theme Selection"],
#v119TerminalMenu .v119-menu-action[title="Choose terminal theme"]{
 position:relative;
 display:flex!important;
 align-items:center!important;
 justify-content:flex-start!important;
 width:100%!important;
 min-height:48px!important;
 padding:10px 12px 10px 44px!important;
 border-color:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 48%,var(--v10-line,var(--line,#334155)))!important;
 background:linear-gradient(
  135deg,
  color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 15%,var(--v10-card,var(--card,#111827))),
  color-mix(in srgb,var(--v10-card,var(--card,#111827)) 96%,transparent)
 )!important;
 color:var(--v10-text,var(--text,#f8fafc))!important;
 font-weight:850!important;
 text-align:left!important;
}
#v119TerminalMenu .v119-menu-action[aria-label="Theme Selection"]::before,
#v119TerminalMenu .v119-menu-action[title="Choose terminal theme"]::before{
 content:"◐";
 position:absolute;
 left:12px;
 top:50%;
 display:grid;
 place-items:center;
 width:25px;
 height:25px;
 transform:translateY(-50%);
 border-radius:8px;
 background:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 20%,transparent);
 color:var(--v10-primary,var(--primary,#60a5fa));
}


/* =========================================================
   V11.20 — RESTORED GROUPED TERMINAL MENU
   ========================================================= */

/* Keep source commands in the DOM for menu cloning, but remove the old
   header button-group interface from the visible terminal. */
.v10-control-deck,
section.card.toolbar.v10-original-toolbar{
 display:none!important;
}

/* Every menu section starts collapsed. */
#v119TerminalMenu .v119-menu-group.collapsed .v119-menu-group-body,
#v119TerminalMenu .v119-menu-group-body[hidden]{
 display:none!important;
}

#v119TerminalMenu .v119-menu-group-title[aria-expanded="false"] .v1111-caret{
 transform:rotate(-90deg);
}

#v119TerminalMenu .v119-menu-group-title[aria-expanded="true"] .v1111-caret{
 transform:rotate(0deg);
}

#v119TerminalMenu .v1111-caret{
 transition:transform .18s ease;
}

/* Give Appearance a clear, dedicated visual identity. */
#v119TerminalMenu [data-menu-group="Appearance"]{
 border-color:color-mix(
  in srgb,
  var(--v10-primary,var(--primary,#2563eb)) 42%,
  var(--v10-line,var(--line,#334155))
 )!important;
}

#v119TerminalMenu [data-menu-group="Appearance"] > .v119-menu-group-title{
 background:linear-gradient(
  135deg,
  color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 13%,var(--v10-card,var(--card,#111827))),
  color-mix(in srgb,var(--v10-card,var(--card,#111827)) 97%,transparent)
 )!important;
}


/* =========================================================
   V11.21 — RELIABLE THEME PICKER
   ========================================================= */
.v1124-theme-dialog[hidden]{
 display:none!important;
}

.v1124-theme-dialog{
 position:fixed;
 inset:0;
 z-index:2147483000;
 display:grid;
 place-items:center;
 padding:18px;
}

.v1124-theme-dialog-backdrop{
 position:absolute;
 inset:0;
 background:rgba(2,6,23,.72);
 backdrop-filter:blur(8px);
}

.v1124-theme-dialog-panel{
 position:relative;
 z-index:1;
 width:min(760px,100%);
 max-height:min(82vh,760px);
 overflow:auto;
 border:1px solid var(--v10-line,var(--line,#334155));
 border-radius:22px;
 background:
  linear-gradient(
   145deg,
   color-mix(in srgb,var(--v10-card,var(--card,#111827)) 98%,transparent),
   color-mix(in srgb,var(--v10-panel-solid,var(--panel,#0f172a)) 96%,transparent)
  );
 box-shadow:0 28px 80px rgba(0,0,0,.45);
 color:var(--v10-text,var(--text,#f8fafc));
}

.v1124-theme-dialog-header{
 position:sticky;
 top:0;
 z-index:2;
 display:flex;
 align-items:center;
 justify-content:space-between;
 gap:14px;
 padding:17px 18px;
 border-bottom:1px solid var(--v10-line,var(--line,#334155));
 background:color-mix(in srgb,var(--v10-card,var(--card,#111827)) 96%,transparent);
 backdrop-filter:blur(16px);
}

.v1124-theme-dialog-header span{
 display:block;
 margin-bottom:3px;
 color:var(--v10-primary,var(--primary,#60a5fa));
 font-size:.62rem;
 font-weight:950;
 letter-spacing:.16em;
}

.v1124-theme-dialog-header h3{
 margin:0;
 font-size:1.08rem;
}

.v1124-theme-dialog-close{
 display:grid;
 place-items:center;
 width:38px;
 height:38px;
 border:1px solid var(--v10-line,var(--line,#334155));
 border-radius:11px;
 background:var(--v10-card,var(--card,#111827));
 color:var(--v10-text,var(--text,#f8fafc));
 font-size:1.3rem;
 cursor:pointer;
}

.v1124-theme-options{
 display:grid;
 grid-template-columns:repeat(2,minmax(0,1fr));
 gap:11px;
 padding:16px;
}

.v1124-theme-option{
 display:grid;
 grid-template-columns:auto minmax(0,1fr);
 align-items:center;
 gap:12px;
 min-height:78px;
 padding:12px;
 border:1px solid var(--v10-line,var(--line,#334155));
 border-radius:15px;
 background:color-mix(in srgb,var(--v10-card,var(--card,#111827)) 96%,transparent);
 color:var(--v10-text,var(--text,#f8fafc));
 text-align:left;
 cursor:pointer;
 transition:.18s ease;
}

.v1124-theme-option:hover,
.v1124-theme-option.active{
 transform:translateY(-1px);
 border-color:var(--v10-primary,var(--primary,#60a5fa));
 box-shadow:0 12px 28px color-mix(in srgb,var(--v10-primary,var(--primary,#60a5fa)) 15%,transparent);
}

.v1124-theme-option strong,
.v1124-theme-option small{
 display:block;
}

.v1124-theme-option strong{
 font-size:.82rem;
}

.v1124-theme-option small{
 margin-top:4px;
 color:var(--v10-muted,var(--muted,#94a3b8));
 font-size:.67rem;
}

.v1124-theme-preview{
 display:flex;
 gap:3px;
 align-items:flex-end;
 justify-content:center;
 width:50px;
 height:45px;
 padding:8px;
 border-radius:12px;
 background:linear-gradient(
  145deg,
  color-mix(in srgb,var(--v10-primary,var(--primary,#60a5fa)) 20%,var(--v10-card,var(--card,#111827))),
  var(--v10-card,var(--card,#111827))
 );
}

.v1124-theme-preview i{
 display:block;
 width:8px;
 border-radius:4px;
 background:var(--v10-primary,var(--primary,#60a5fa));
}

.v1124-theme-preview i:nth-child(1){height:15px}
.v1124-theme-preview i:nth-child(2){height:27px}
.v1124-theme-preview i:nth-child(3){height:20px}

@media(max-width:620px){
 .v1124-theme-options{
  grid-template-columns:1fr;
  padding:12px;
 }
 .v1124-theme-dialog{
  padding:10px;
 }
}


/* V11.22 direct Theme Selection dialog fix */
.v1124-theme-dialog{
 z-index:2147483647!important;
 pointer-events:auto!important;
}
.v1124-theme-dialog-panel,
.v1124-theme-dialog-backdrop{
 pointer-events:auto!important;
}


/* =========================================================
   V11.24 — NATIVE MENU CLOSE + ACCESSIBLE THEME MODAL
   ========================================================= */

/* Closed menu panel and backdrop must release all pointer interaction,
   while the Terminal Menu launcher remains visible. */
#v119TerminalMenu:not(.open) .v119-menu-panel{
 pointer-events:none!important;
 visibility:hidden!important;
 opacity:0!important;
}

#v119MenuBackdrop:not(.open){
 pointer-events:none!important;
 visibility:hidden!important;
 opacity:0!important;
}

/* Theme dialog sits above every terminal layer and accepts interaction. */
.v1124-theme-dialog{
 position:fixed!important;
 inset:0!important;
 z-index:2147483647!important;
 display:grid!important;
 place-items:center!important;
 pointer-events:auto!important;
 isolation:isolate!important;
}

.v1124-theme-dialog[hidden]{
 display:none!important;
}

.v1124-theme-dialog-backdrop{
 z-index:0!important;
 pointer-events:auto!important;
}

.v1124-theme-dialog-panel{
 position:relative!important;
 z-index:1!important;
 pointer-events:auto!important;
}

.v1124-theme-option,
.v1124-theme-dialog-close{
 pointer-events:auto!important;
}

body.v1124-theme-dialog-open{
 overflow:hidden;
}


/* =========================================================
   V11.25 — COMPLETE THEME SURFACE BRIDGE
   ========================================================= */

:root{
 --v1125-surface:var(--v10-card,var(--card,#111827));
 --v1125-surface-2:var(--v10-panel-solid,var(--panel,#0f172a));
 --v1125-surface-soft:color-mix(
  in srgb,
  var(--v10-card,var(--card,#111827)) 92%,
  var(--v10-primary,var(--primary,#60a5fa)) 8%
 );
 --v1125-border:var(--v10-line,var(--line,#334155));
 --v1125-text:var(--v10-text,var(--text,#f8fafc));
 --v1125-muted:var(--v10-muted,var(--muted,#94a3b8));
 --v1125-accent:var(--v10-primary,var(--primary,#60a5fa));
 --v1125-shadow:0 16px 40px color-mix(
  in srgb,
  var(--v10-primary,var(--primary,#60a5fa)) 10%,
  rgba(0,0,0,.34)
 );
}

/* Main application surfaces */
body,
.app,
.shell,
.dashboard,
.dashboard-shell,
.terminal-shell,
main,
.main-content,
.content-area{
 color:var(--v1125-text);
}

.card,
.panel,
.widget,
.workspace,
.workspace-panel,
.market-workspace,
.watchlist-workspace,
.watch-list-workspace,
.report-card,
.chart-card,
.stat-card,
.metric-card,
.summary-card,
.table-card,
.modal-content,
.dialog-content,
.drawer-content,
.dropdown-menu,
.popover,
.menu-panel,
.v119-menu-panel,
.v119-menu-group,
.v10-card{
 border-color:var(--v1125-border)!important;
 background:var(--v1125-surface)!important;
 color:var(--v1125-text)!important;
 box-shadow:var(--v1125-shadow);
}

/* Secondary/inner surfaces */
.card-header,
.card-footer,
.panel-header,
.panel-footer,
.workspace-header,
.workspace-footer,
.table-toolbar,
.form-section,
.control-section,
.chart-toolbar,
.watchlist-header,
.watch-list-header,
.v119-menu-group-title,
.v119-menu-group-body,
details,
summary{
 border-color:var(--v1125-border)!important;
 background:var(--v1125-surface-soft)!important;
 color:var(--v1125-text)!important;
}

/* Form controls */
input,
select,
textarea,
button,
.btn,
.button,
.control,
.form-control,
.form-select,
.search-input,
.filter-input{
 border-color:var(--v1125-border)!important;
 color:var(--v1125-text)!important;
}

input,
select,
textarea,
.form-control,
.form-select,
.search-input,
.filter-input{
 background:var(--v1125-surface-2)!important;
}

input::placeholder,
textarea::placeholder{
 color:var(--v1125-muted)!important;
 opacity:.9;
}

button:not(.danger):not(.btn-danger),
.btn:not(.danger):not(.btn-danger),
.button:not(.danger):not(.btn-danger){
 background:color-mix(
  in srgb,
  var(--v1125-surface) 84%,
  var(--v1125-accent) 16%
 )!important;
}

/* Tables and lists */
table,
thead,
tbody,
tfoot,
tr,
th,
td,
.data-table,
.watchlist-table,
.watch-list-table{
 border-color:var(--v1125-border)!important;
 color:var(--v1125-text)!important;
}

thead,
th{
 background:var(--v1125-surface-soft)!important;
}

tbody tr,
.list-item,
.watchlist-item,
.watch-list-item,
.code-item,
.symbol-item{
 background:var(--v1125-surface)!important;
 color:var(--v1125-text)!important;
 border-color:var(--v1125-border)!important;
}

tbody tr:hover,
.list-item:hover,
.watchlist-item:hover,
.watch-list-item:hover,
.code-item:hover,
.symbol-item:hover{
 background:color-mix(
  in srgb,
  var(--v1125-surface) 78%,
  var(--v1125-accent) 22%
 )!important;
}

/* Text hierarchy */
.muted,
.text-muted,
.subtext,
.helper,
.hint,
small,
.meta,
.secondary-text{
 color:var(--v1125-muted)!important;
}

a,
.link,
.accent,
.active,
.is-active{
 color:var(--v1125-accent);
}

/* Chips, badges and tabs */
.badge,
.chip,
.tag,
.pill,
.tab,
.nav-tab,
.status-badge{
 border-color:var(--v1125-border)!important;
 background:var(--v1125-surface-soft)!important;
 color:var(--v1125-text)!important;
}

.tab.active,
.nav-tab.active,
.chip.active,
.badge.active{
 border-color:var(--v1125-accent)!important;
 color:var(--v1125-accent)!important;
}

/* Modals, drawers and overlays */
.modal,
.dialog,
.drawer,
.offcanvas{
 color:var(--v1125-text)!important;
}

.modal-backdrop,
.dialog-backdrop,
.drawer-backdrop,
.overlay{
 background:color-mix(in srgb,var(--v1125-surface-2) 72%,transparent)!important;
}

/* Charts and canvases should be visually integrated even though their
   drawing colors remain controlled by their own chart renderer. */
canvas,
.chart-container,
.chart-area,
.chart-panel{
 border-color:var(--v1125-border)!important;
 background:var(--v1125-surface-2)!important;
}

/* =========================================================
   V11.25 — WATCH-LIST TOOLTIP
   ========================================================= */
[data-v1126-watch-tooltip]{
 position:relative!important;
}

[data-v1126-watch-tooltip]::before,
[data-v1126-watch-tooltip]::after{
 position:absolute;
 left:50%;
 z-index:2147483000;
 pointer-events:none;
 opacity:0;
 visibility:hidden;
 transition:opacity .16s ease,transform .16s ease,visibility .16s ease;
}

[data-v1126-watch-tooltip]::before{
 content:attr(data-v1126-watch-tooltip);
 bottom:calc(100% + 10px);
 transform:translate(-50%,6px);
 width:max-content;
 max-width:min(300px,80vw);
 padding:8px 10px;
 border:1px solid var(--v1125-border);
 border-radius:9px;
 background:var(--v1125-surface-2);
 color:var(--v1125-text);
 box-shadow:0 14px 32px rgba(0,0,0,.34);
 font-size:.72rem;
 font-weight:800;
 line-height:1.35;
 text-align:center;
 white-space:normal;
}

[data-v1126-watch-tooltip]::after{
 content:"";
 bottom:calc(100% + 4px);
 transform:translate(-50%,6px);
 border:6px solid transparent;
 border-top-color:var(--v1125-border);
}

[data-v1126-watch-tooltip]:hover::before,
[data-v1126-watch-tooltip]:hover::after,
[data-v1126-watch-tooltip]:focus-visible::before,
[data-v1126-watch-tooltip]:focus-visible::after,
[data-v1126-watch-tooltip]:focus-within::before,
[data-v1126-watch-tooltip]:focus-within::after{
 opacity:1;
 visibility:visible;
 transform:translate(-50%,0);
}


/* V11.26 — tooltips only for Watch Lists > Manage stock groups */
[data-v1126-watch-lists-section="true"] [data-v1126-watch-tooltip]{
 cursor:help;
}

[data-v1126-watch-lists-section="true"] [data-v1126-watch-tooltip]:hover{
 border-color:var(--v1125-accent)!important;
}


/* AIT PSA compact brand heading */
.v9-command{grid-template-columns:1fr!important}
.v9-brand-heading{display:flex;align-items:center;gap:12px;flex-wrap:wrap;min-width:0}
.v9-brand-heading .v9-title{white-space:nowrap}
.v9-brand-heading .v9-state{padding:7px 11px}
.v105-brand-line{display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.v105-brand-line h2{margin:0!important}
.v105-inline-ready{display:inline-flex;align-items:center;gap:7px;padding:7px 11px;border-radius:999px;border:1px solid rgba(34,197,94,.28);background:rgba(34,197,94,.10);font-size:.78rem;font-weight:800;color:#16a34a;white-space:nowrap}
.v105-inline-ready i{width:8px;height:8px;border-radius:999px;background:#22c55e;box-shadow:0 0 0 4px rgba(34,197,94,.12)}
@media(max-width:640px){.v9-brand-heading,.v105-brand-line{gap:8px}.v9-brand-heading .v9-state,.v105-inline-ready{font-size:.72rem;padding:6px 9px}}

/* V11.10 ranked galleries: Watch List structure with active-theme surfaces */
#v11RankedChartModal{background:color-mix(in srgb,var(--v10-bg) 78%,transparent)!important;backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px)}
#v11RankedChartModal>.dialog{width:min(1180px,calc(100vw - 28px))!important;max-height:calc(100vh - 28px)!important;padding:0 16px 18px!important;overflow:auto!important;border:1px solid var(--v10-line)!important;border-radius:18px!important;background:linear-gradient(145deg,var(--v10-bg-soft),var(--v10-panel-solid))!important;color:var(--v10-text)!important;box-shadow:var(--v10-shadow)!important}
#v11RankedChartModal .modal-head{position:sticky!important;top:0!important;z-index:20!important;display:flex!important;align-items:center!important;justify-content:space-between!important;gap:14px!important;margin:0 -16px 16px!important;padding:16px 18px!important;border:0!important;border-bottom:1px solid var(--v10-line)!important;border-radius:18px 18px 0 0!important;background:linear-gradient(135deg,var(--v10-panel-solid),color-mix(in srgb,var(--v10-primary) 12%,var(--v10-panel-solid)))!important;color:var(--v10-text)!important;box-shadow:0 7px 22px color-mix(in srgb,var(--v10-bg) 55%,transparent)!important}
#v11RankedChartModal .modal-head h2{margin:0!important;color:var(--v10-text)!important;font-size:1.28rem!important;font-weight:900!important;line-height:1.25!important;text-shadow:none!important;opacity:1!important}
#v11RankedChartModal .modal-head .small{display:block!important;margin-top:4px!important;color:var(--v10-muted)!important;font-size:.78rem!important;font-weight:650!important;line-height:1.4!important;opacity:1!important}
#v11RankedChartModal .modal-head .icon{display:inline-flex!important;align-items:center!important;justify-content:center!important;min-width:40px!important;width:40px!important;height:40px!important;padding:0!important;border:1px solid var(--v10-line)!important;border-radius:11px!important;background:color-mix(in srgb,var(--v10-card) 82%,var(--v10-panel-solid))!important;color:var(--v10-text)!important;font-size:1.35rem!important;font-weight:800!important;opacity:1!important}
#v11RankedChartModal .modal-head .icon:hover{border-color:color-mix(in srgb,var(--v10-primary) 55%,var(--v10-line))!important;background:color-mix(in srgb,var(--v10-primary) 14%,var(--v10-panel-solid))!important}
#v11RankedChartModal #v11RankedChartGallery.gallery{display:grid!important;grid-template-columns:repeat(2,minmax(0,1fr))!important;gap:13px!important}
#v11RankedChartModal .mini-card.v11-ranked-mini-card{min-width:0!important;padding:10px!important;border:1px solid var(--v10-line)!important;border-radius:12px!important;background:linear-gradient(145deg,color-mix(in srgb,var(--v10-card) 88%,var(--v10-panel-solid)),var(--v10-panel-solid))!important;color:var(--v10-text)!important;box-shadow:0 7px 20px color-mix(in srgb,var(--v10-bg) 42%,transparent)!important}
#v11RankedChartModal .mini-card.v11-ranked-mini-card:hover{border-color:color-mix(in srgb,var(--v10-primary) 48%,var(--v10-line))!important;box-shadow:0 10px 28px color-mix(in srgb,var(--v10-primary) 11%,transparent)!important}
#v11RankedChartModal .mini-card .row{display:flex!important;align-items:center!important;justify-content:space-between!important;gap:10px!important;margin-bottom:7px!important}
#v11RankedChartModal .mini-card h3{margin:0!important;color:var(--v10-text)!important;font-size:1rem!important;font-weight:900!important;line-height:1.3!important;opacity:1!important;text-shadow:none!important}
#v11RankedChartModal .v11-ranked-number{color:var(--v10-primary)!important;font-size:.76rem!important;font-weight:900!important}
#v11RankedChartModal .v11-ranked-summary-line{display:flex!important;align-items:center!important;flex-wrap:wrap!important;gap:7px 12px!important;margin:0 0 8px!important;color:var(--v10-muted)!important;font-size:.74rem!important;font-weight:650!important;line-height:1.35!important}
#v11RankedChartModal .v11-ranked-summary-line b{color:var(--v10-text)!important;font-weight:900!important}
#v11RankedChartModal .chart-box.mini-chart{height:300px!important;overflow:hidden!important;border:1px solid var(--v10-line)!important;border-radius:10px!important;background:color-mix(in srgb,var(--v10-bg-soft) 72%,var(--v10-panel-solid))!important}
#v11RankedChartModal .chart-box.mini-chart canvas{display:block!important;width:100%!important;height:300px!important}
#v11RankedChartModal .small.v11-ranked-coverage{display:block!important;margin-top:7px!important;color:var(--v10-muted)!important;font-size:.72rem!important;font-weight:650!important;line-height:1.4!important;opacity:1!important}
#v11RankedChartModal .v11-signal{display:inline-flex!important;align-items:center!important;padding:4px 8px!important;border-radius:999px!important;font-size:.68rem!important;font-weight:900!important;line-height:1!important}
#v11RankedChartModal .v11-signal.strongest,#v11RankedChartModal .v11-signal.buy{background:#dcfce7!important;color:#166534!important;border:1px solid #86efac!important}
#v11RankedChartModal .v11-signal.watch{background:#fef3c7!important;color:#92400e!important;border:1px solid #fcd34d!important}
#v11RankedChartModal .v11-signal.avoid,#v11RankedChartModal .v11-signal.sell{background:#fee2e2!important;color:#991b1b!important;border:1px solid #fca5a5!important}
@media(max-width:820px){#v11RankedChartModal #v11RankedChartGallery.gallery{grid-template-columns:1fr!important}}
@media(max-width:560px){#v11RankedChartModal>.dialog{width:100vw!important;max-height:100vh!important;border-radius:0!important}#v11RankedChartModal .modal-head{border-radius:0!important}#v11RankedChartModal .chart-box.mini-chart,#v11RankedChartModal .chart-box.mini-chart canvas{height:245px!important}}

/* V11.11 — ranked galleries retain the exact scoped terminal palette after promotion */
#v11RankedChartModal{
 background:color-mix(in srgb,var(--v1125-surface-2,var(--v10-bg)) 78%,transparent)!important;
}
#v11RankedChartModal>.dialog{
 border-color:var(--v1125-border,var(--v10-line))!important;
 background:var(--v1125-surface-1,var(--v10-panel-solid))!important;
 color:var(--v1125-text,var(--v10-text))!important;
}
#v11RankedChartModal .modal-head{
 border-bottom-color:var(--v1125-border,var(--v10-line))!important;
 background:linear-gradient(135deg,var(--v1125-surface-2,var(--v10-panel-solid)),color-mix(in srgb,var(--v1125-accent,var(--v10-primary)) 10%,var(--v1125-surface-2,var(--v10-panel-solid))))!important;
 color:var(--v1125-text,var(--v10-text))!important;
}
#v11RankedChartModal .modal-head h2,
#v11RankedChartModal .mini-card h3,
#v11RankedChartModal .v11-ranked-summary-line b{color:var(--v1125-text,var(--v10-text))!important}
#v11RankedChartModal .modal-head .small,
#v11RankedChartModal .v11-ranked-summary-line,
#v11RankedChartModal .small.v11-ranked-coverage{color:var(--v1125-muted,var(--v10-muted))!important}
#v11RankedChartModal .modal-head .icon,
#v11RankedChartModal .mini-card.v11-ranked-mini-card{
 border-color:var(--v1125-border,var(--v10-line))!important;
 background:var(--v1125-surface-2,var(--v10-card))!important;
 color:var(--v1125-text,var(--v10-text))!important;
}
#v11RankedChartModal .chart-box.mini-chart{
 border-color:var(--v1125-border,var(--v10-line))!important;
 background:var(--v1125-surface-soft,var(--v10-bg-soft))!important;
}
#v11RankedChartModal .v11-ranked-number{color:var(--v1125-accent,var(--v10-primary))!important}

/* V11.12 — exact themed gallery shell, header and canvas background */
#v11RankedChartModal{
 background:var(--v1125-overlay,rgba(2,6,23,.72))!important;
}
#v11RankedChartModal>.dialog{
 background:var(--v1125-surface-1,var(--v10-panel-solid))!important;
}
#v11RankedChartModal .modal-head{
 background:var(--v1125-surface-1,var(--v10-panel-solid))!important;
 border-bottom:1px solid var(--v1125-border,var(--v10-line))!important;
 box-shadow:0 8px 22px var(--v1125-shadow,rgba(2,6,23,.18))!important;
}
#v11RankedChartModal .modal-head>div:first-child{
 min-width:0!important;
 padding:0!important;
 border:0!important;
 border-radius:0!important;
 background:transparent!important;
 box-shadow:none!important;
}
#v11RankedChartModal #v11RankedChartGallery{
 margin:0!important;
 padding:2px!important;
 border-radius:14px!important;
 background:var(--v1125-surface-1,var(--v10-panel-solid))!important;
}
#v11RankedChartModal .modal-head h2{color:var(--v1125-text,var(--v10-text))!important}
#v11RankedChartModal .modal-head .small{color:var(--v1125-muted,var(--v10-muted))!important}

.v11-portfolio-position-modal .dialog{width:min(620px,100%)}
.v11-portfolio-position-modal .v11-portfolio-form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-top:8px}
.v11-portfolio-position-modal .v11-portfolio-form label{display:grid;gap:6px;font-weight:800;color:var(--text)}
.v11-portfolio-position-modal .v11-portfolio-form input,.v11-portfolio-position-modal .v11-portfolio-form select{width:100%;min-height:44px;border:1px solid var(--line);border-radius:11px;background:var(--card);color:var(--text);padding:9px 11px}
.v11-portfolio-position-modal .v11-portfolio-form input:focus,.v11-portfolio-position-modal .v11-portfolio-form select:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 3px color-mix(in srgb,var(--primary) 18%,transparent)}
@media(max-width:640px){.v11-portfolio-position-modal .v11-portfolio-form{grid-template-columns:1fr}}
</style>

<script>
try{
 const saved=JSON.parse(localStorage.getItem("ababil-dse-v10-theme"));
 document.documentElement.dataset.theme=saved||"dark-glass";
}catch{document.documentElement.dataset.theme="dark-glass"}
</script>


<style id="aitPsaPhaTerminalStyles">
/* AIT PSA v10041 — PHA-style full-width terminal architecture */
#v119TerminalMenu,#v119MenuBackdrop{display:none!important}
body.ait-psa-terminal-open{overflow:hidden}
.ait-psa-terminal-launcher{position:fixed;top:14px;right:14px;z-index:2147483600;display:flex;align-items:center;gap:9px;min-height:44px;padding:9px 14px;border:1px solid color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 62%,#fff 22%);border-radius:14px;background:linear-gradient(135deg,var(--v10-primary,var(--primary,#2563eb)),var(--v10-accent,var(--blue,#06b6d4)));color:#fff;font-weight:900;box-shadow:0 16px 38px rgba(0,0,0,.35);cursor:pointer}
.ait-psa-terminal-launcher__icon{display:grid;place-items:center;width:27px;height:27px;border-radius:8px;background:rgba(0,0,0,.2);font:900 12px/1 ui-monospace,Consolas,monospace}
.ait-psa-terminal-dock-backdrop,.ait-psa-terminal-modal-backdrop{position:fixed;inset:0;z-index:2147483601;display:none;border:0;background:rgba(2,6,23,.72);backdrop-filter:blur(9px)}
.ait-psa-terminal-dock-backdrop.open,.ait-psa-terminal-modal-shell.open .ait-psa-terminal-modal-backdrop{display:block}
.ait-psa-terminal-dock{position:fixed;top:0;right:0;z-index:2147483602;width:min(430px,100vw);height:100dvh;padding:18px;transform:translateX(105%);transition:transform .22s ease;background:linear-gradient(165deg,color-mix(in srgb,var(--v10-card,var(--card,#111827)) 98%,#07111f),color-mix(in srgb,var(--v10-panel-solid,var(--panel,#0f172a)) 97%,#020617));color:var(--v10-text,var(--text,#f8fafc));box-shadow:-24px 0 64px rgba(0,0,0,.42);overflow:auto}
.ait-psa-terminal-dock.open{transform:none}
.ait-psa-terminal-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding-bottom:15px;border-bottom:1px solid var(--v10-line,var(--line,#334155))}
.ait-psa-terminal-head strong{display:block;font-size:1.05rem}.ait-psa-terminal-head small{display:block;margin-top:3px;color:var(--v10-muted,var(--muted,#94a3b8))}
.ait-psa-terminal-close{display:grid;place-items:center;width:40px;height:40px;border:1px solid var(--v10-line,var(--line,#334155));border-radius:12px;background:var(--v10-card,var(--card,#111827));color:inherit;font-size:1.25rem;cursor:pointer}
.ait-psa-terminal-groups{display:grid;gap:10px;margin-top:15px}
.ait-psa-terminal-group{display:grid;grid-template-columns:44px minmax(0,1fr) auto;gap:11px;align-items:center;width:100%;padding:13px;border:1px solid var(--v10-line,var(--line,#334155));border-radius:15px;background:color-mix(in srgb,var(--v10-card,var(--card,#111827)) 94%,transparent);color:inherit;text-align:left;cursor:pointer;transition:.16s ease}
.ait-psa-terminal-group:hover{transform:translateY(-1px);border-color:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 60%,var(--v10-line,var(--line,#334155)));background:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 10%,var(--v10-card,var(--card,#111827)))}
.ait-psa-terminal-group__icon{display:grid;place-items:center;width:44px;height:44px;border-radius:13px;background:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 18%,transparent);font-size:1.2rem}.ait-psa-terminal-group b,.ait-psa-terminal-group small{display:block}.ait-psa-terminal-group small{margin-top:3px;color:var(--v10-muted,var(--muted,#94a3b8));line-height:1.35}
.ait-psa-terminal-modal-shell{position:fixed;inset:0;z-index:2147483603;display:none}.ait-psa-terminal-modal-shell.open{display:block}
.ait-psa-terminal-modal{position:fixed;inset:10px;z-index:2147483604;display:grid;grid-template-rows:auto minmax(0,1fr);overflow:hidden;border:1px solid var(--v10-line,var(--line,#334155));border-radius:22px;background:linear-gradient(150deg,var(--v10-bg,var(--bg,#07111f)),var(--v10-panel-solid,var(--panel,#0f172a)));color:var(--v10-text,var(--text,#f8fafc));box-shadow:0 34px 100px rgba(0,0,0,.55)}
.ait-psa-terminal-modal[hidden]{display:none!important}
.ait-psa-terminal-modal__head{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:15px 18px;border-bottom:1px solid var(--v10-line,var(--line,#334155));background:color-mix(in srgb,var(--v10-card,var(--card,#111827)) 96%,transparent)}
.ait-psa-terminal-modal__eyebrow{display:block;color:var(--v10-primary,var(--primary,#60a5fa));font-size:.62rem;font-weight:950;letter-spacing:.15em}.ait-psa-terminal-modal__head h2{margin:3px 0 0;font-size:1.25rem}.ait-psa-terminal-modal__head p{margin:3px 0 0;color:var(--v10-muted,var(--muted,#94a3b8));font-size:.76rem}
.ait-psa-terminal-modal__body{min-height:0;overflow:auto;padding:16px}
.ait-psa-terminal-command-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
.ait-psa-download-scope{display:grid;grid-template-columns:minmax(220px,.72fr) minmax(0,1.28fr);gap:14px;align-items:center;margin:0 0 14px;padding:14px;border:1px solid color-mix(in srgb,var(--v10-primary,var(--primary,#60a5fa)) 36%,var(--v10-line,var(--line,#334155)));border-radius:16px;background:color-mix(in srgb,var(--v10-primary,var(--primary,#60a5fa)) 8%,var(--v10-card,var(--card,#111827)))}
.ait-psa-download-scope__identity span,.ait-psa-download-scope__identity strong,.ait-psa-download-scope__identity small{display:block}.ait-psa-download-scope__identity span{color:var(--v10-primary,var(--primary,#60a5fa));font-size:.62rem;font-weight:950;letter-spacing:.14em}.ait-psa-download-scope__identity strong{margin-top:4px;font-size:1.02rem}.ait-psa-download-scope__identity small{margin-top:4px;color:var(--v10-muted,var(--muted,#94a3b8));line-height:1.45}
.ait-psa-download-scope__metrics{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:7px}.ait-psa-download-scope__metrics>span{padding:8px;border:1px solid var(--v10-line,var(--line,#334155));border-radius:10px;background:color-mix(in srgb,var(--v10-card,var(--card,#111827)) 92%,transparent);color:var(--v10-muted,var(--muted,#94a3b8));font-size:.7rem}.ait-psa-download-scope__metrics>span b{display:block;color:var(--v10-text,var(--text,#f8fafc));font-size:.86rem}.ait-psa-download-scope__metrics>small{grid-column:1/-1;color:var(--v10-muted,var(--muted,#94a3b8));font-size:.7rem;line-height:1.4}
.ait-signal-priority-menu-grid{grid-template-columns:repeat(2,minmax(280px,1fr))!important;align-content:start}.ait-signal-priority-menu-grid .ait-psa-terminal-command{min-height:140px}.ait-signal-priority-menu-grid .ait-psa-terminal-command b{font-size:1rem}.ait-signal-priority-menu-grid .ait-psa-terminal-command:nth-child(3),.ait-signal-priority-menu-grid .ait-psa-terminal-command:nth-child(4){border-color:color-mix(in srgb,var(--v10-primary,var(--primary,#60a5fa)) 55%,var(--v10-line,var(--line,#334155)));box-shadow:inset 0 0 0 1px color-mix(in srgb,var(--v10-primary,var(--primary,#60a5fa)) 14%,transparent)}
@media(max-width:800px){.ait-signal-priority-menu-grid{grid-template-columns:1fr!important}}.ait-psa-terminal-command{min-height:112px;padding:15px;border:1px solid var(--v10-line,var(--line,#334155));border-radius:16px;background:var(--v10-card,var(--card,#111827));color:inherit;text-align:left;cursor:pointer}.ait-psa-terminal-command:hover{border-color:var(--v10-primary,var(--primary,#60a5fa))}.ait-psa-terminal-command span,.ait-psa-terminal-command b,.ait-psa-terminal-command small{display:block}.ait-psa-terminal-command span{font-size:1.35rem}.ait-psa-terminal-command b{margin-top:10px}.ait-psa-terminal-command small{margin-top:4px;color:var(--v10-muted,var(--muted,#94a3b8));line-height:1.4}
.ait-psa-terminal-head-actions{display:flex;align-items:center;gap:8px}.ait-psa-terminal-back{min-height:40px;padding:8px 12px;border:1px solid var(--v10-line,var(--line,#334155));border-radius:12px;background:var(--v10-card,var(--card,#111827));color:inherit;font-weight:850;cursor:pointer}.ait-psa-terminal-back:hover{border-color:var(--v10-primary,var(--primary,#60a5fa))}
.ait-psa-workspace-host{min-width:0}.ait-psa-watchlist-menu-grid{grid-template-columns:repeat(2,minmax(0,1fr));align-content:start}.ait-psa-watchlist-layout{display:grid;grid-template-columns:minmax(260px,340px) minmax(0,1fr);gap:14px;align-items:start}.ait-psa-watchlist-layout>.sidebar{position:static!important;width:auto!important;display:block!important}.ait-psa-watchlist-layout>#marketWorkspace{display:grid!important;min-width:0}.ait-psa-workspace-host>#v11Terminal{display:block!important}.ait-psa-workspace-host>#downloadWorkspace{display:block!important}
.ait-psa-workspace-host>#downloadWorkspace>.v1116-download-actions{display:none!important}
.ait-psa-workspace-host>#downloadWorkspace{padding-top:0!important}
.ait-psa-workspace-host>#downloadWorkspace>#downloadStatusCard{margin-top:0!important}
.ait-psa-theme-host .v10-theme-grid{display:grid!important;grid-template-columns:repeat(3,minmax(0,1fr))!important;gap:12px!important}.ait-psa-theme-host .v10-theme-option{display:grid!important;min-height:110px!important}
.ait-psa-home-notifications{max-width:1500px;margin:14px auto;padding:0 14px}.ait-psa-home-notifications .v105-panel{margin:0}.ait-psa-index-only .v10-mobile-bar,.ait-psa-index-only .v10-control-deck,.ait-psa-index-only .app>.layout{display:none!important}.ait-psa-index-only .app{max-width:1500px!important}.ait-psa-index-only .app>header,.ait-psa-index-only .app>#overviewWorkspace{display:flex}.ait-psa-index-only #overviewWorkspace{display:grid}
@media(max-width:800px){.ait-psa-terminal-modal{inset:0;border:0;border-radius:0}.ait-psa-terminal-command-grid,.ait-psa-watchlist-menu-grid,.ait-psa-theme-host .v10-theme-grid{grid-template-columns:1fr!important}.ait-psa-terminal-launcher{top:8px;right:8px}.ait-psa-terminal-modal__body{padding:11px}.ait-psa-watchlist-layout,.ait-psa-download-scope{grid-template-columns:1fr!important}.ait-psa-download-scope__metrics{grid-template-columns:repeat(2,minmax(0,1fr))}}
/* Functional dialogs opened from a terminal workspace must sit above the full-width terminal. */
body.ait-psa-terminal-open > .modal.open,
body.ait-psa-terminal-open .modal.open,
body.ait-psa-terminal-open > .overlay.open,
body.ait-psa-terminal-open .v111-chart-modal.open,
body.ait-psa-terminal-open [role="dialog"].open:not(.ait-psa-terminal-modal){
 z-index:2147483646!important;
 pointer-events:auto!important;
}
.ait-psa-terminal-modal-shell.open{pointer-events:auto}
.ait-psa-terminal-modal-shell.open .ait-psa-terminal-modal:not([hidden]){display:grid!important;pointer-events:auto}
.ait-psa-terminal-modal-shell.open #aitPsaTradingModal:not([hidden]) #v11Terminal{display:block!important}
.ait-psa-terminal-modal-shell.open #aitPsaDownloadModal:not([hidden]) #downloadWorkspace{display:block!important}
.ait-psa-terminal-modal-shell.open #aitPsaWatchlistManagerModal:not([hidden]) .ait-psa-watchlist-layout{display:grid!important}

/* AIT PSA terminal isolated stacking fix: keep backdrop below every interactive terminal panel. */
#aitPsaTerminalModalShell{z-index:2147483603!important;isolation:isolate!important;pointer-events:none!important}
#aitPsaTerminalModalShell.open{display:block!important;pointer-events:auto!important}
#aitPsaTerminalModalBackdrop{z-index:0!important;pointer-events:auto!important}
#aitPsaTerminalModalShell .ait-psa-terminal-modal{z-index:1!important;pointer-events:auto!important}
#aitPsaTerminalModalShell .ait-psa-terminal-modal[hidden]{display:none!important;pointer-events:none!important}
#aitPsaTerminalModalShell .ait-psa-terminal-modal:not([hidden]){display:grid!important}
@media print{.ait-psa-terminal-launcher,.ait-psa-terminal-dock,.ait-psa-terminal-dock-backdrop,.ait-psa-terminal-modal-shell{display:none!important}}


/* =========================================================
   AIT PSA — COMPACT PROFESSIONAL INDEX DASHBOARD
   Dashboard-only visual refinement. Terminal functionality unchanged.
   ========================================================= */
body.ait-psa-index-only{
 --ait-psa-dash-gap:10px;
 --ait-psa-dash-radius:14px;
 --ait-psa-dash-border:color-mix(in srgb,var(--v10-line) 88%,transparent);
 --ait-psa-dash-surface:color-mix(in srgb,var(--v10-panel-solid) 96%,var(--v10-bg));
 --ait-psa-dash-card:color-mix(in srgb,var(--v10-card) 94%,var(--v10-panel));
 background:
  linear-gradient(180deg,color-mix(in srgb,var(--v10-primary) 4%,var(--v10-bg)) 0,var(--v10-bg) 420px)!important;
}
body.ait-psa-index-only .v105-dashboard{
 width:min(1460px,calc(100% - 24px));
 margin:12px auto 10px!important;
 gap:var(--ait-psa-dash-gap);
}
body.ait-psa-index-only .v105-hero{
 padding:14px 16px;
 border-radius:var(--ait-psa-dash-radius);
 border-color:var(--ait-psa-dash-border);
 background:var(--ait-psa-dash-surface);
 box-shadow:0 8px 24px rgba(0,0,0,.14);
}
body.ait-psa-index-only .v105-hero:after{
 width:170px;height:170px;right:-58px;top:-78px;
 opacity:.55;
}
body.ait-psa-index-only .v105-hero-grid{
 grid-template-columns:minmax(0,1.5fr) minmax(330px,.75fr);
 gap:18px;
}
body.ait-psa-index-only .v105-eyebrow{
 font-size:.64rem;letter-spacing:.16em;
}
body.ait-psa-index-only .v105-hero h2{
 margin:4px 0 3px;
 font-size:clamp(1.2rem,2vw,1.72rem);
 line-height:1.18;
 letter-spacing:-.025em;
}
body.ait-psa-index-only .v105-hero p{
 max-width:720px;
 font-size:.78rem;
 line-height:1.48;
 color:var(--v10-muted);
}
body.ait-psa-index-only .v105-hero-actions{margin-top:10px;gap:7px}
body.ait-psa-index-only .v105-hero-actions .btn{
 min-height:36px!important;padding:7px 11px!important;border-radius:10px!important;font-size:.75rem!important;
}
body.ait-psa-index-only .v105-health{
 grid-template-columns:repeat(2,minmax(0,1fr));gap:7px;
}
body.ait-psa-index-only .v105-health-item{
 min-height:58px;padding:9px 10px;border-radius:11px;
 border-color:var(--ait-psa-dash-border);background:var(--ait-psa-dash-card);
}
body.ait-psa-index-only .v105-health-item span{font-size:.64rem;text-transform:uppercase;letter-spacing:.055em}
body.ait-psa-index-only .v105-health-item strong{margin-top:3px;font-size:.86rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
body.ait-psa-index-only .v105-dashboard-grid{
 grid-template-columns:minmax(0,1.25fr) minmax(250px,.78fr) minmax(250px,.78fr);
 gap:var(--ait-psa-dash-gap);
}
body.ait-psa-index-only .v105-panel{
 border-radius:var(--ait-psa-dash-radius);
 border-color:var(--ait-psa-dash-border);
 background:var(--ait-psa-dash-surface);
 box-shadow:0 7px 20px rgba(0,0,0,.11);
}
body.ait-psa-index-only .v105-panel-head{
 min-height:49px;padding:9px 11px;
 background:color-mix(in srgb,var(--ait-psa-dash-card) 84%,transparent);
 border-color:var(--ait-psa-dash-border);
}
body.ait-psa-index-only .v105-panel-head h3{font-size:.86rem;letter-spacing:-.01em}
body.ait-psa-index-only .v105-panel-head small{font-size:.65rem}
body.ait-psa-index-only .v105-panel-head .btn{min-height:31px!important;padding:5px 9px!important;border-radius:9px!important;font-size:.68rem!important}
body.ait-psa-index-only .v105-panel-body{padding:10px}
body.ait-psa-index-only .v105-metric-grid{grid-template-columns:repeat(4,minmax(0,1fr));gap:7px}
body.ait-psa-index-only .v105-metric{
 min-height:84px;padding:9px;border-radius:11px;
 border-color:var(--ait-psa-dash-border);background:var(--ait-psa-dash-card);
 position:relative;overflow:hidden;
}
body.ait-psa-index-only .v105-metric:before{
 content:"";position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--v10-primary);
}
body.ait-psa-index-only .v105-metric span{font-size:.64rem;text-transform:uppercase;letter-spacing:.045em}
body.ait-psa-index-only .v105-metric strong{margin-top:5px;font-size:1.18rem;line-height:1}
body.ait-psa-index-only .v105-metric em{margin-top:5px;font-size:.62rem;line-height:1.25}
body.ait-psa-index-only .v105-list{gap:6px}
body.ait-psa-index-only .v105-list-item{
 grid-template-columns:auto minmax(0,1fr) auto;gap:8px;
 padding:8px 9px;border-radius:10px;border-color:var(--ait-psa-dash-border);background:var(--ait-psa-dash-card);
}
body.ait-psa-index-only .v105-list-item strong{font-size:.75rem}
body.ait-psa-index-only .v105-list-item p{font-size:.67rem;line-height:1.35}
body.ait-psa-index-only .v105-list-item time{font-size:.61rem}
body.ait-psa-index-only .v105-status-dot{width:8px;height:8px;margin-top:4px;box-shadow:none}
body.ait-psa-index-only .v105-empty{padding:15px 10px;border-radius:10px;font-size:.72rem;background:var(--ait-psa-dash-card)}
body.ait-psa-index-only .v105-queue-badge{padding:4px 7px;font-size:.59rem;letter-spacing:.05em}

/* Compact summaries: remove the large duplicate marketing header treatment. */
body.ait-psa-index-only .app{
 width:min(1460px,calc(100% - 24px));margin:0 auto!important;
}
body.ait-psa-index-only .app>header{
 min-height:auto!important;padding:10px 12px!important;margin:0 0 8px!important;
 display:flex!important;align-items:center;justify-content:space-between;gap:12px;
 border:1px solid var(--ait-psa-dash-border);border-radius:var(--ait-psa-dash-radius);
 background:var(--ait-psa-dash-surface);box-shadow:0 7px 20px rgba(0,0,0,.10);
}
body.ait-psa-index-only .app>header h1{margin:0!important;font-size:.98rem!important;line-height:1.2}
body.ait-psa-index-only .app>header p{margin:2px 0 0!important;font-size:.66rem!important;color:var(--v10-muted);max-width:720px}
body.ait-psa-index-only .app>header .badge{
 min-width:150px!important;padding:7px 10px!important;border-radius:10px!important;
 box-shadow:none!important;border:1px solid var(--ait-psa-dash-border)!important;background:var(--ait-psa-dash-card)!important;
}
body.ait-psa-index-only .app>header .badge strong{font-size:.76rem!important}
body.ait-psa-index-only .app>header .badge span{font-size:.59rem!important}
body.ait-psa-index-only #overviewWorkspace{
 display:grid!important;grid-template-columns:repeat(4,minmax(0,1fr))!important;gap:8px!important;margin:0!important;
}
body.ait-psa-index-only #overviewWorkspace .stat{
 min-height:76px!important;padding:10px 11px!important;border-radius:12px!important;
 border-color:var(--ait-psa-dash-border)!important;background:var(--ait-psa-dash-card)!important;
 box-shadow:0 6px 16px rgba(0,0,0,.09)!important;position:relative;overflow:hidden;
}
body.ait-psa-index-only #overviewWorkspace .stat:after{
 content:"";position:absolute;right:-18px;bottom:-28px;width:70px;height:70px;border-radius:50%;
 background:color-mix(in srgb,var(--v10-primary) 9%,transparent);
}
body.ait-psa-index-only #overviewWorkspace .stat label{
 font-size:.62rem!important;text-transform:uppercase;letter-spacing:.055em;color:var(--v10-muted)!important;
}
body.ait-psa-index-only #overviewWorkspace .stat strong{margin-top:5px!important;font-size:1.28rem!important;line-height:1!important}
body.ait-psa-index-only .ait-psa-home-notifications{
 width:min(1460px,calc(100% - 24px));margin:10px auto 28px!important;padding:0!important;
}
body.ait-psa-index-only .ait-psa-home-notifications .v105-panel-body{max-height:260px;overflow:auto}

@media(max-width:1050px){
 body.ait-psa-index-only .v105-hero-grid{grid-template-columns:1fr}
 body.ait-psa-index-only .v105-dashboard-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
 body.ait-psa-index-only .v105-dashboard-grid .v105-panel:first-child{grid-column:1/-1}
}
@media(max-width:700px){
 body.ait-psa-index-only .v105-dashboard,
 body.ait-psa-index-only .app,
 body.ait-psa-index-only .ait-psa-home-notifications{width:calc(100% - 16px)}
 body.ait-psa-index-only .v105-hero{padding:12px}
 body.ait-psa-index-only .v105-health,
 body.ait-psa-index-only .v105-metric-grid,
 body.ait-psa-index-only #overviewWorkspace{grid-template-columns:repeat(2,minmax(0,1fr))!important}
 body.ait-psa-index-only .v105-dashboard-grid{grid-template-columns:1fr}
 body.ait-psa-index-only .v105-dashboard-grid .v105-panel:first-child{grid-column:auto}
 body.ait-psa-index-only .app>header{align-items:flex-start;flex-direction:column}
 body.ait-psa-index-only .app>header .badge{width:100%;min-width:0!important}
}
@media(max-width:430px){
 body.ait-psa-index-only .v105-health,
 body.ait-psa-index-only .v105-metric-grid,
 body.ait-psa-index-only #overviewWorkspace{grid-template-columns:1fr!important}
 body.ait-psa-index-only .v105-metric{min-height:70px}
}

.ait-psa-activity-toolbar{position:sticky;top:-16px;z-index:3;display:flex;align-items:center;justify-content:space-between;gap:14px;margin:-16px -16px 14px;padding:14px 16px;border-bottom:1px solid var(--v10-line,var(--line,#334155));background:color-mix(in srgb,var(--v10-card,var(--card,#111827)) 97%,transparent)}
.ait-psa-activity-toolbar strong,.ait-psa-activity-toolbar small{display:block}.ait-psa-activity-toolbar small{margin-top:3px;color:var(--v10-muted,var(--muted,#94a3b8));font-size:.72rem}
.ait-psa-activity-list{display:grid;gap:9px;max-width:1100px;margin:0 auto}.ait-psa-activity-list .v105-list-item{min-height:72px;padding:13px 15px;border:1px solid var(--v10-line,var(--line,#334155));border-radius:14px;background:var(--v10-card,var(--card,#111827))}
@media(max-width:600px){.ait-psa-activity-toolbar{top:-11px;margin:-11px -11px 11px;padding:11px;align-items:flex-start}.ait-psa-activity-toolbar .ait-psa-terminal-back{min-height:36px;padding:7px 10px}}
@media print{.ait-psa-terminal-launcher,.ait-psa-terminal-dock,.ait-psa-terminal-dock-backdrop,.ait-psa-terminal-modal-shell{display:none!important}}


/* =========================================================
   AIT PSA — COMPACT PROFESSIONAL INDEX DASHBOARD
   Dashboard-only visual refinement. Terminal functionality unchanged.
   ========================================================= */
body.ait-psa-index-only{
 --ait-psa-dash-gap:10px;
 --ait-psa-dash-radius:14px;
 --ait-psa-dash-border:color-mix(in srgb,var(--v10-line) 88%,transparent);
 --ait-psa-dash-surface:color-mix(in srgb,var(--v10-panel-solid) 96%,var(--v10-bg));
 --ait-psa-dash-card:color-mix(in srgb,var(--v10-card) 94%,var(--v10-panel));
 background:
  linear-gradient(180deg,color-mix(in srgb,var(--v10-primary) 4%,var(--v10-bg)) 0,var(--v10-bg) 420px)!important;
}
body.ait-psa-index-only .v105-dashboard{
 width:min(1460px,calc(100% - 24px));
 margin:12px auto 10px!important;
 gap:var(--ait-psa-dash-gap);
}
body.ait-psa-index-only .v105-hero{
 padding:14px 16px;
 border-radius:var(--ait-psa-dash-radius);
 border-color:var(--ait-psa-dash-border);
 background:var(--ait-psa-dash-surface);
 box-shadow:0 8px 24px rgba(0,0,0,.14);
}
body.ait-psa-index-only .v105-hero:after{
 width:170px;height:170px;right:-58px;top:-78px;
 opacity:.55;
}
body.ait-psa-index-only .v105-hero-grid{
 grid-template-columns:minmax(0,1.5fr) minmax(330px,.75fr);
 gap:18px;
}
body.ait-psa-index-only .v105-eyebrow{
 font-size:.64rem;letter-spacing:.16em;
}
body.ait-psa-index-only .v105-hero h2{
 margin:4px 0 3px;
 font-size:clamp(1.2rem,2vw,1.72rem);
 line-height:1.18;
 letter-spacing:-.025em;
}
body.ait-psa-index-only .v105-hero p{
 max-width:720px;
 font-size:.78rem;
 line-height:1.48;
 color:var(--v10-muted);
}
body.ait-psa-index-only .v105-hero-actions{margin-top:10px;gap:7px}
body.ait-psa-index-only .v105-hero-actions .btn{
 min-height:36px!important;padding:7px 11px!important;border-radius:10px!important;font-size:.75rem!important;
}
body.ait-psa-index-only .v105-health{
 grid-template-columns:repeat(2,minmax(0,1fr));gap:7px;
}
body.ait-psa-index-only .v105-health-item{
 min-height:58px;padding:9px 10px;border-radius:11px;
 border-color:var(--ait-psa-dash-border);background:var(--ait-psa-dash-card);
}
body.ait-psa-index-only .v105-health-item span{font-size:.64rem;text-transform:uppercase;letter-spacing:.055em}
body.ait-psa-index-only .v105-health-item strong{margin-top:3px;font-size:.86rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
body.ait-psa-index-only .v105-dashboard-grid{
 grid-template-columns:minmax(0,1.25fr) minmax(250px,.78fr) minmax(250px,.78fr);
 gap:var(--ait-psa-dash-gap);
}
body.ait-psa-index-only .v105-panel{
 border-radius:var(--ait-psa-dash-radius);
 border-color:var(--ait-psa-dash-border);
 background:var(--ait-psa-dash-surface);
 box-shadow:0 7px 20px rgba(0,0,0,.11);
}
body.ait-psa-index-only .v105-panel-head{
 min-height:49px;padding:9px 11px;
 background:color-mix(in srgb,var(--ait-psa-dash-card) 84%,transparent);
 border-color:var(--ait-psa-dash-border);
}
body.ait-psa-index-only .v105-panel-head h3{font-size:.86rem;letter-spacing:-.01em}
body.ait-psa-index-only .v105-panel-head small{font-size:.65rem}
body.ait-psa-index-only .v105-panel-head .btn{min-height:31px!important;padding:5px 9px!important;border-radius:9px!important;font-size:.68rem!important}
body.ait-psa-index-only .v105-panel-body{padding:10px}
body.ait-psa-index-only .v105-metric-grid{grid-template-columns:repeat(4,minmax(0,1fr));gap:7px}
body.ait-psa-index-only .v105-metric{
 min-height:84px;padding:9px;border-radius:11px;
 border-color:var(--ait-psa-dash-border);background:var(--ait-psa-dash-card);
 position:relative;overflow:hidden;
}
body.ait-psa-index-only .v105-metric:before{
 content:"";position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--v10-primary);
}
body.ait-psa-index-only .v105-metric span{font-size:.64rem;text-transform:uppercase;letter-spacing:.045em}
body.ait-psa-index-only .v105-metric strong{margin-top:5px;font-size:1.18rem;line-height:1}
body.ait-psa-index-only .v105-metric em{margin-top:5px;font-size:.62rem;line-height:1.25}
body.ait-psa-index-only .v105-list{gap:6px}
body.ait-psa-index-only .v105-list-item{
 grid-template-columns:auto minmax(0,1fr) auto;gap:8px;
 padding:8px 9px;border-radius:10px;border-color:var(--ait-psa-dash-border);background:var(--ait-psa-dash-card);
}
body.ait-psa-index-only .v105-list-item strong{font-size:.75rem}
body.ait-psa-index-only .v105-list-item p{font-size:.67rem;line-height:1.35}
body.ait-psa-index-only .v105-list-item time{font-size:.61rem}
body.ait-psa-index-only .v105-status-dot{width:8px;height:8px;margin-top:4px;box-shadow:none}
body.ait-psa-index-only .v105-empty{padding:15px 10px;border-radius:10px;font-size:.72rem;background:var(--ait-psa-dash-card)}
body.ait-psa-index-only .v105-queue-badge{padding:4px 7px;font-size:.59rem;letter-spacing:.05em}

/* Compact summaries: remove the large duplicate marketing header treatment. */
body.ait-psa-index-only .app{
 width:min(1460px,calc(100% - 24px));margin:0 auto!important;
}
body.ait-psa-index-only .app>header{
 min-height:auto!important;padding:10px 12px!important;margin:0 0 8px!important;
 display:flex!important;align-items:center;justify-content:space-between;gap:12px;
 border:1px solid var(--ait-psa-dash-border);border-radius:var(--ait-psa-dash-radius);
 background:var(--ait-psa-dash-surface);box-shadow:0 7px 20px rgba(0,0,0,.10);
}
body.ait-psa-index-only .app>header h1{margin:0!important;font-size:.98rem!important;line-height:1.2}
body.ait-psa-index-only .app>header p{margin:2px 0 0!important;font-size:.66rem!important;color:var(--v10-muted);max-width:720px}
body.ait-psa-index-only .app>header .badge{
 min-width:150px!important;padding:7px 10px!important;border-radius:10px!important;
 box-shadow:none!important;border:1px solid var(--ait-psa-dash-border)!important;background:var(--ait-psa-dash-card)!important;
}
body.ait-psa-index-only .app>header .badge strong{font-size:.76rem!important}
body.ait-psa-index-only .app>header .badge span{font-size:.59rem!important}
body.ait-psa-index-only #overviewWorkspace{
 display:grid!important;grid-template-columns:repeat(4,minmax(0,1fr))!important;gap:8px!important;margin:0!important;
}
body.ait-psa-index-only #overviewWorkspace .stat{
 min-height:76px!important;padding:10px 11px!important;border-radius:12px!important;
 border-color:var(--ait-psa-dash-border)!important;background:var(--ait-psa-dash-card)!important;
 box-shadow:0 6px 16px rgba(0,0,0,.09)!important;position:relative;overflow:hidden;
}
body.ait-psa-index-only #overviewWorkspace .stat:after{
 content:"";position:absolute;right:-18px;bottom:-28px;width:70px;height:70px;border-radius:50%;
 background:color-mix(in srgb,var(--v10-primary) 9%,transparent);
}
body.ait-psa-index-only #overviewWorkspace .stat label{
 font-size:.62rem!important;text-transform:uppercase;letter-spacing:.055em;color:var(--v10-muted)!important;
}
body.ait-psa-index-only #overviewWorkspace .stat strong{margin-top:5px!important;font-size:1.28rem!important;line-height:1!important}
body.ait-psa-index-only .ait-psa-home-notifications{
 width:min(1460px,calc(100% - 24px));margin:10px auto 28px!important;padding:0!important;
}
body.ait-psa-index-only .ait-psa-home-notifications .v105-panel-body{max-height:260px;overflow:auto}

@media(max-width:1050px){
 body.ait-psa-index-only .v105-hero-grid{grid-template-columns:1fr}
 body.ait-psa-index-only .v105-dashboard-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
 body.ait-psa-index-only .v105-dashboard-grid .v105-panel:first-child{grid-column:1/-1}
}
@media(max-width:700px){
 body.ait-psa-index-only .v105-dashboard,
 body.ait-psa-index-only .app,
 body.ait-psa-index-only .ait-psa-home-notifications{width:calc(100% - 16px)}
 body.ait-psa-index-only .v105-hero{padding:12px}
 body.ait-psa-index-only .v105-health,
 body.ait-psa-index-only .v105-metric-grid,
 body.ait-psa-index-only #overviewWorkspace{grid-template-columns:repeat(2,minmax(0,1fr))!important}
 body.ait-psa-index-only .v105-dashboard-grid{grid-template-columns:1fr}
 body.ait-psa-index-only .v105-dashboard-grid .v105-panel:first-child{grid-column:auto}
 body.ait-psa-index-only .app>header{align-items:flex-start;flex-direction:column}
 body.ait-psa-index-only .app>header .badge{width:100%;min-width:0!important}
}
@media(max-width:430px){
 body.ait-psa-index-only .v105-health,
 body.ait-psa-index-only .v105-metric-grid,
 body.ait-psa-index-only #overviewWorkspace{grid-template-columns:1fr!important}
 body.ait-psa-index-only .v105-metric{min-height:70px}
}


</style>


<style id="ait-psa-premium-redesign-v1">
/* Index-only premium redesign. All terminal components remain untouched. */
body.ait-psa-index-only{
 --ait-px-bg:#080d18;
 --ait-px-panel:color-mix(in srgb,var(--v10-panel-solid) 97%,#0b1220);
 --ait-px-card:color-mix(in srgb,var(--v10-card) 96%,#111a2b);
 --ait-px-line:color-mix(in srgb,var(--v10-line) 78%,transparent);
 --ait-px-soft:color-mix(in srgb,var(--v10-primary) 7%,transparent);
 --ait-px-glow:color-mix(in srgb,var(--v10-primary) 18%,transparent);
 background:
  radial-gradient(circle at 12% -10%,var(--ait-px-glow),transparent 30rem),
  radial-gradient(circle at 90% 4%,color-mix(in srgb,var(--v10-secondary) 10%,transparent),transparent 24rem),
  var(--v10-bg)!important;
 min-height:100vh;
}
body.ait-psa-index-only:before{
 content:"";position:fixed;inset:0;pointer-events:none;z-index:-1;opacity:.18;
 background-image:linear-gradient(color-mix(in srgb,var(--v10-line) 20%,transparent) 1px,transparent 1px),linear-gradient(90deg,color-mix(in srgb,var(--v10-line) 20%,transparent) 1px,transparent 1px);
 background-size:48px 48px;
 mask-image:linear-gradient(to bottom,black,transparent 70%);
}
body.ait-psa-index-only .v105-dashboard,
body.ait-psa-index-only .app,
body.ait-psa-index-only .ait-psa-home-notifications{width:min(1380px,calc(100% - 40px));}
body.ait-psa-index-only .v105-dashboard{margin:24px auto 14px!important;gap:14px}
body.ait-psa-index-only .v105-hero{
 position:relative;padding:26px 28px;border:1px solid var(--ait-px-line);border-radius:20px;
 background:linear-gradient(135deg,var(--ait-px-panel),color-mix(in srgb,var(--ait-px-panel) 88%,var(--v10-primary)));
 box-shadow:0 20px 60px rgba(0,0,0,.24);overflow:hidden;
}
body.ait-psa-index-only .v105-hero:before{
 content:"";position:absolute;inset:0;border-radius:inherit;pointer-events:none;
 background:linear-gradient(115deg,color-mix(in srgb,var(--v10-primary) 8%,transparent),transparent 35%,color-mix(in srgb,var(--v10-secondary) 5%,transparent));
}
body.ait-psa-index-only .v105-hero:after{width:320px;height:320px;right:-110px;top:-185px;opacity:.65;filter:blur(2px)}
body.ait-psa-index-only .v105-hero-grid{grid-template-columns:minmax(0,1.35fr) minmax(420px,.8fr);gap:32px;position:relative;z-index:1}
body.ait-psa-index-only .v105-eyebrow{font-size:.65rem;font-weight:800;letter-spacing:.22em;color:var(--v10-primary);opacity:1}
body.ait-psa-index-only .v105-hero h2{font-size:clamp(1.9rem,3.3vw,3.15rem);letter-spacing:-.055em;line-height:1;margin:10px 0 12px;max-width:750px}
body.ait-psa-index-only .v105-hero p{font-size:.86rem;line-height:1.65;max-width:680px;color:var(--v10-muted)}
body.ait-psa-index-only .ait-psa-market-line{display:flex;flex-wrap:wrap;align-items:center;gap:9px;margin-top:20px}
body.ait-psa-index-only .ait-psa-market-line span{display:inline-flex;align-items:center;gap:7px;padding:7px 10px;border:1px solid var(--ait-px-line);border-radius:999px;background:color-mix(in srgb,var(--ait-px-card) 84%,transparent);font-size:.65rem;font-weight:700;color:var(--v10-muted);letter-spacing:.02em}
body.ait-psa-index-only .ait-psa-market-line i{width:7px;height:7px;border-radius:50%;background:#38d996;box-shadow:0 0 0 4px rgba(56,217,150,.12)}
body.ait-psa-index-only .v105-health{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}
body.ait-psa-index-only .v105-health-item{min-height:84px;padding:14px 15px;border:1px solid var(--ait-px-line);border-radius:15px;background:color-mix(in srgb,var(--ait-px-card) 88%,transparent);box-shadow:inset 0 1px rgba(255,255,255,.025)}
body.ait-psa-index-only .v105-health-item span{font-size:.59rem;letter-spacing:.12em;font-weight:800;color:var(--v10-muted)}
body.ait-psa-index-only .v105-health-item strong{font-size:.95rem;margin-top:10px;letter-spacing:-.02em}
body.ait-psa-index-only .v105-dashboard-grid{grid-template-columns:minmax(0,1.45fr) repeat(2,minmax(250px,.72fr));gap:14px}
body.ait-psa-index-only .v105-panel{border:1px solid var(--ait-px-line);border-radius:18px;background:var(--ait-px-panel);box-shadow:0 14px 40px rgba(0,0,0,.18);overflow:hidden}
body.ait-psa-index-only .v105-panel-head{min-height:64px;padding:14px 17px;background:linear-gradient(180deg,color-mix(in srgb,var(--ait-px-card) 72%,transparent),transparent);border-bottom:1px solid var(--ait-px-line)}
body.ait-psa-index-only .v105-panel-head h3{font-size:.9rem;letter-spacing:-.02em}
body.ait-psa-index-only .v105-panel-head small{font-size:.63rem;margin-top:3px}
body.ait-psa-index-only .ait-psa-panel-meta,.v105-queue-badge{padding:5px 8px;border-radius:999px;border:1px solid var(--ait-px-line);background:var(--ait-px-soft);font-size:.56rem;font-weight:850;letter-spacing:.12em;color:var(--v10-primary)}
body.ait-psa-index-only .v105-panel-body{padding:14px}
body.ait-psa-index-only .v105-metric-grid{grid-template-columns:repeat(4,minmax(0,1fr));gap:9px}
body.ait-psa-index-only .v105-metric{min-height:116px;padding:14px;border:1px solid var(--ait-px-line);border-radius:14px;background:var(--ait-px-card)}
body.ait-psa-index-only .v105-metric:before{top:auto;bottom:0;left:0;right:0;width:auto;height:3px;background:linear-gradient(90deg,var(--v10-primary),var(--v10-secondary))}
body.ait-psa-index-only .v105-metric span{font-size:.6rem;font-weight:800;letter-spacing:.09em}
body.ait-psa-index-only .v105-metric strong{font-size:1.72rem;margin-top:14px;letter-spacing:-.045em}
body.ait-psa-index-only .v105-metric em{font-size:.61rem;margin-top:9px;color:var(--v10-muted)}
body.ait-psa-index-only .v105-list{gap:8px}
body.ait-psa-index-only .v105-list-item{padding:10px 11px;border:1px solid var(--ait-px-line);border-radius:12px;background:var(--ait-px-card);transition:transform .18s ease,border-color .18s ease}
body.ait-psa-index-only .v105-list-item:hover{transform:translateY(-1px);border-color:color-mix(in srgb,var(--v10-primary) 40%,var(--ait-px-line))}
body.ait-psa-index-only .v105-list-item strong{font-size:.75rem}
body.ait-psa-index-only .v105-list-item p{font-size:.65rem;line-height:1.45}
body.ait-psa-index-only .v105-empty{min-height:86px;display:grid;place-items:center;padding:16px;border:1px dashed var(--ait-px-line);border-radius:12px;background:color-mix(in srgb,var(--ait-px-card) 70%,transparent);font-size:.69rem;color:var(--v10-muted)}
body.ait-psa-index-only .app{margin:0 auto!important}
body.ait-psa-index-only .app>header{padding:17px 19px!important;margin:0 0 10px!important;border:1px solid var(--ait-px-line);border-radius:18px;background:var(--ait-px-panel);box-shadow:0 14px 40px rgba(0,0,0,.16)}
body.ait-psa-index-only .ait-psa-section-kicker{display:block;margin-bottom:5px;font-size:.56rem;font-weight:850;letter-spacing:.16em;color:var(--v10-primary)}
body.ait-psa-index-only .app>header h1{font-size:1.12rem!important;letter-spacing:-.03em}
body.ait-psa-index-only .app>header p{font-size:.66rem!important;line-height:1.5}
body.ait-psa-index-only .app>header .badge{min-width:175px!important;padding:10px 13px!important;border:1px solid var(--ait-px-line)!important;border-radius:12px!important;background:var(--ait-px-card)!important}
body.ait-psa-index-only #overviewWorkspace{grid-template-columns:repeat(4,minmax(0,1fr))!important;gap:10px!important}
body.ait-psa-index-only #overviewWorkspace .stat{min-height:112px!important;padding:16px!important;border:1px solid var(--ait-px-line)!important;border-radius:16px!important;background:var(--ait-px-card)!important;box-shadow:0 12px 32px rgba(0,0,0,.14)!important}
body.ait-psa-index-only #overviewWorkspace .stat:after{width:100px;height:100px;right:-35px;bottom:-50px;background:color-mix(in srgb,var(--v10-primary) 12%,transparent)}
body.ait-psa-index-only #overviewWorkspace .stat label{font-size:.61rem!important;font-weight:800;letter-spacing:.09em!important}
body.ait-psa-index-only #overviewWorkspace .stat strong{font-size:1.9rem!important;margin-top:18px!important;letter-spacing:-.05em}
body.ait-psa-index-only .ait-psa-home-notifications{margin:14px auto 34px!important}
body.ait-psa-index-only .ait-psa-home-notifications .v105-panel-body{max-height:300px;overflow:auto}
/* No duplicated page actions: operational actions live in Terminal. */
body.ait-psa-index-only .v105-hero-actions,
body.ait-psa-index-only #v105ClearQueue,
body.ait-psa-index-only #v105ClearActivity,
body.ait-psa-index-only #aitPsaOpenNotifications{display:none!important}
@media(max-width:1080px){
 body.ait-psa-index-only .v105-hero-grid{grid-template-columns:1fr}
 body.ait-psa-index-only .v105-dashboard-grid{grid-template-columns:1fr 1fr}
 body.ait-psa-index-only .v105-dashboard-grid .v105-panel:first-child{grid-column:1/-1}
}
@media(max-width:760px){
 body.ait-psa-index-only .v105-dashboard,body.ait-psa-index-only .app,body.ait-psa-index-only .ait-psa-home-notifications{width:calc(100% - 20px)}
 body.ait-psa-index-only .v105-dashboard{margin-top:12px!important}
 body.ait-psa-index-only .v105-hero{padding:20px}
 body.ait-psa-index-only .v105-hero h2{font-size:2rem}
 body.ait-psa-index-only .v105-metric-grid,body.ait-psa-index-only #overviewWorkspace{grid-template-columns:repeat(2,minmax(0,1fr))!important}
 body.ait-psa-index-only .v105-dashboard-grid{grid-template-columns:1fr}
 body.ait-psa-index-only .v105-dashboard-grid .v105-panel:first-child{grid-column:auto}
}
@media(max-width:460px){
 body.ait-psa-index-only .v105-health,body.ait-psa-index-only .v105-metric-grid,body.ait-psa-index-only #overviewWorkspace{grid-template-columns:1fr!important}
 body.ait-psa-index-only .v105-hero h2{font-size:1.68rem}
 body.ait-psa-index-only .v105-metric,body.ait-psa-index-only #overviewWorkspace .stat{min-height:94px!important}
}
</style>


<style id="ait-uniform-theme-v10005">
/* =========================================================
   AIT UNIFORM THEME LAYER
   One semantic palette for legacy and modern components.
   This block intentionally comes last in <head>.
   ========================================================= */
:root,
body,
.ait-psa-terminal-shell,
.v10-shell,
.v119-menu-panel,
.modal,
.v1124-theme-dialog,
#v11RankedChartModal {
  --ait-bg: var(--v10-bg, var(--bg, #0b1220));
  --ait-bg-soft: var(--v10-bg-soft, color-mix(in srgb, var(--ait-bg) 88%, var(--v10-primary, var(--primary, #2563eb)) 12%));
  --ait-panel: var(--v10-panel-solid, var(--v10-panel, var(--panel, #111827)));
  --ait-surface: var(--v10-card, var(--card, #172033));
  --ait-surface-soft: color-mix(in srgb, var(--ait-surface) 92%, var(--v10-primary, var(--primary, #2563eb)) 8%);
  --ait-surface-hover: color-mix(in srgb, var(--ait-surface) 86%, var(--v10-primary, var(--primary, #2563eb)) 14%);
  --ait-text: var(--v10-text, var(--ink, var(--text, #f8fafc)));
  --ait-muted: var(--v10-muted, var(--muted, #94a3b8));
  --ait-border: var(--v10-line, var(--line, #334155));
  --ait-accent: var(--v10-primary, var(--primary, #2563eb));
  --ait-accent-2: var(--v10-secondary, var(--blue, #06b6d4));
  --ait-success: var(--v10-success, var(--green, #16a34a));
  --ait-danger: var(--v10-danger, var(--red, #dc2626));
  --ait-warning: var(--v10-warning, var(--orange, #d97706));
  --ait-active-bg: color-mix(in srgb, var(--ait-surface) 80%, var(--ait-accent) 20%);
  --ait-active-border: color-mix(in srgb, var(--ait-accent) 76%, var(--ait-border));
  --ait-overlay: color-mix(in srgb, var(--ait-bg) 76%, transparent);
  --ait-shadow: 0 16px 42px color-mix(in srgb, #000 34%, var(--ait-accent) 6%);
}

/* Base text and form controls */
body,
.app,
main,
.main,
.content,
.workspace,
[class*="workspace" i] {
  color: var(--ait-text);
}

input,
select,
textarea,
.input,
.select,
.field input,
.field select,
.field textarea {
  background: var(--ait-surface-soft) !important;
  border-color: var(--ait-border) !important;
  color: var(--ait-text) !important;
}
input::placeholder,
textarea::placeholder { color: var(--ait-muted) !important; opacity: .82; }
input:focus,
select:focus,
textarea:focus {
  border-color: var(--ait-accent) !important;
  box-shadow: 0 0 0 3px color-mix(in srgb, var(--ait-accent) 18%, transparent) !important;
}

/* Uniform surfaces */
.card,
.panel,
.stat,
.metric,
.widget,
.list,
.theme-list-item,
.activity > div,
.table-wrap,
.table-card,
.tabs,
.tab-panel,
.note,
.dropdown-menu,
.popover,
.menu-panel,
.v119-menu-panel,
.v119-menu-group,
.v105-panel,
.v105-metric,
.v105-list-item,
.dialog,
.modal-content,
.v1124-theme-dialog-panel,
.ait-psa-terminal-modal__dialog {
  background: var(--ait-surface) !important;
  border-color: var(--ait-border) !important;
  color: var(--ait-text) !important;
}

/* Watch lists */
.lists { gap: 8px; }
.list,
.theme-list-item {
  border: 1px solid var(--ait-border) !important;
  background: var(--ait-surface) !important;
  color: var(--ait-text) !important;
  box-shadow: none !important;
  transition: background .18s ease, border-color .18s ease, box-shadow .18s ease, transform .18s ease;
}
.list:hover,
.theme-list-item:hover {
  background: var(--ait-surface-hover) !important;
  border-color: color-mix(in srgb, var(--ait-accent) 44%, var(--ait-border)) !important;
  transform: translateY(-1px);
}
.list.active,
.theme-list-item.active {
  background: var(--ait-active-bg) !important;
  border-color: var(--ait-active-border) !important;
  color: var(--ait-text) !important;
  box-shadow:
    inset 3px 0 0 var(--ait-accent),
    0 8px 22px color-mix(in srgb, var(--ait-accent) 12%, transparent) !important;
}
.list.active .list-name,
.list.active .small,
.theme-list-item.active .list-name,
.theme-list-item.active .small { color: var(--ait-text) !important; }
.list .small,
.theme-list-item .small { color: var(--ait-muted) !important; }
.select-list { color: inherit !important; }

/* Buttons */
.btn,
button.btn,
.button,
.tab,
.ait-psa-terminal-back,
.ait-psa-terminal-command {
  border-color: var(--ait-border) !important;
}
.btn.soft,
.soft,
.tab,
.ait-psa-terminal-back {
  background: var(--ait-surface-soft) !important;
  color: var(--ait-text) !important;
}
.btn.soft:hover,
.soft:hover,
.tab:hover,
.ait-psa-terminal-back:hover {
  background: var(--ait-surface-hover) !important;
  border-color: color-mix(in srgb, var(--ait-accent) 52%, var(--ait-border)) !important;
}
.btn.primary,
.primary,
.tab.active {
  background: var(--ait-accent) !important;
  border-color: var(--ait-accent) !important;
  color: #fff !important;
}
.btn.blue,
.blue { background: var(--ait-accent-2) !important; color: #fff !important; }
.btn.red,
.red { background: var(--ait-danger) !important; color: #fff !important; }

/* Tables */
table,
thead,
tbody,
tr,
th,
td { border-color: var(--ait-border) !important; }
thead,
th { background: var(--ait-surface-soft) !important; color: var(--ait-text) !important; }
tbody tr { background: var(--ait-surface) !important; color: var(--ait-text) !important; }
tbody tr:hover { background: var(--ait-surface-hover) !important; }
td,
.small,
.muted,
.help,
.subtitle { color: var(--ait-muted); }

/* Activity and notices */
.activity > div {
  border-left-color: var(--ait-accent) !important;
  background: var(--ait-surface-soft) !important;
}
.note {
  background: color-mix(in srgb, var(--ait-surface) 82%, var(--ait-warning) 18%) !important;
  color: var(--ait-text) !important;
}
.success-note {
  background: color-mix(in srgb, var(--ait-surface) 82%, var(--ait-success) 18%) !important;
  color: var(--ait-text) !important;
}

/* Modals and drawers */
.modal,
.v1124-theme-dialog,
.ait-psa-terminal-modal {
  background: var(--ait-overlay) !important;
  color: var(--ait-text) !important;
}
.dialog,
.modal-content,
.v1124-theme-dialog-panel,
.ait-psa-terminal-modal__dialog {
  box-shadow: var(--ait-shadow) !important;
}
.modal-head,
.modal-header,
.v11-ranked-chart-head,
.v11-ranked-chart-header,
#v11RankedChartModal .modal-head {
  background: var(--ait-panel) !important;
  border-color: var(--ait-border) !important;
  color: var(--ait-text) !important;
}
.modal-head h1,
.modal-head h2,
.modal-header h1,
.modal-header h2,
.v11-ranked-chart-title,
#v11RankedChartModal h1,
#v11RankedChartModal h2 { color: var(--ait-text) !important; }
.modal-head p,
.modal-header p,
.v11-ranked-chart-subtitle,
#v11RankedChartModal p { color: var(--ait-muted) !important; }

/* Menus */
.v119-menu-panel,
.v119-menu-group,
.ait-psa-terminal-menu,
.ait-psa-terminal-drawer {
  background: var(--ait-panel) !important;
  border-color: var(--ait-border) !important;
  color: var(--ait-text) !important;
}
.v119-menu-group:hover,
.ait-psa-terminal-group:hover {
  background: var(--ait-surface-hover) !important;
  border-color: color-mix(in srgb, var(--ait-accent) 46%, var(--ait-border)) !important;
}

/* Chart rule: only actual plot surfaces, never modal/header names containing chart. */
.chart-container,
.chart-wrap,
.chart-panel,
.chart-box,
.chart-area,
.chart-canvas-wrap,
.mini-chart,
.highcharts-container,
.highcharts-root,
canvas[data-chart],
svg[data-chart] {
  background: var(--v116-chart-bg, var(--ait-surface-soft)) !important;
  border-color: var(--v116-chart-border, var(--ait-border)) !important;
}
#v11RankedChartModal,
#v11RankedChartModal .dialog,
#v11RankedChartModal .gallery,
#v11RankedChartModal .modal-head,
#v11RankedChartModal [class*="header" i],
#v11RankedChartModal [class*="title" i] {
  background: var(--ait-panel) !important;
  border-color: var(--ait-border) !important;
}
#v11RankedChartModal .gallery { background: var(--ait-bg-soft) !important; }
#v11RankedChartModal .mini-card { background: var(--ait-surface) !important; border-color: var(--ait-border) !important; color: var(--ait-text) !important; }

/* Scrollbars */
* { scrollbar-color: color-mix(in srgb, var(--ait-accent) 48%, var(--ait-border)) var(--ait-bg-soft); }
*::-webkit-scrollbar-track { background: var(--ait-bg-soft); }
*::-webkit-scrollbar-thumb {
  background: color-mix(in srgb, var(--ait-accent) 48%, var(--ait-border));
  border: 3px solid var(--ait-bg-soft);
}
</style>


<style id="ait-history-priority-style">
.ait-history-modal .ait-psa-terminal-modal__body{display:grid;gap:14px}.ait-history-scanner-body{align-content:start}.ait-history-guideline-section{margin:0!important}.ait-history-method{display:grid;grid-template-columns:repeat(3,minmax(220px,1fr));gap:10px}.ait-history-method>div{display:grid;gap:5px;padding:14px 16px;border:1px solid var(--v10-line,var(--line));border-radius:14px;background:var(--v10-card,var(--card));color:var(--v10-text,var(--text))}.ait-history-method span{color:var(--v10-muted,var(--muted));line-height:1.5}.ait-history-control-row{display:flex;justify-content:flex-end;align-items:center;margin:0}.ait-history-primary-actions{display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap}.ait-history-secondary-actions{display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap}.ait-history-summary{display:grid;grid-template-columns:repeat(4,minmax(150px,1fr));gap:10px}.ait-history-stat{padding:12px 14px;border:1px solid var(--v10-line,var(--line));border-radius:12px;background:var(--v10-card,var(--card));color:var(--v10-text,var(--text))}.ait-history-stat small{display:block;color:var(--v10-muted,var(--muted));margin-bottom:4px}.ait-history-stat strong{font-size:1.15rem}.ait-history-searchbar{margin:0}.ait-history-top-scroll{height:16px;overflow-x:auto;overflow-y:hidden;border:1px solid var(--v10-line,var(--line));border-radius:9px;background:var(--v10-bg-soft,var(--card));}.ait-history-top-scroll>div{height:1px}.ait-history-table-wrap{max-height:58vh;overflow:auto}.ait-history-table-wrap thead th{position:sticky;top:0;z-index:3;background:var(--v10-card,var(--card));color:var(--v10-text,var(--text));white-space:nowrap}.ait-history-table-wrap td{white-space:nowrap}.ait-history-delta.positive{color:var(--success,#16a34a);font-weight:700}.ait-history-delta.negative{color:var(--danger,#dc2626);font-weight:700}.ait-history-delta.neutral{color:var(--v10-muted,var(--muted))}@media(max-width:920px){.ait-history-method{grid-template-columns:1fr}.ait-history-summary{grid-template-columns:repeat(2,minmax(130px,1fr))}}@media(max-width:620px){.ait-history-control-row,.ait-history-secondary-actions{justify-content:stretch}.ait-history-primary-actions,.ait-history-secondary-actions{width:100%}.ait-history-primary-actions .btn,.ait-history-secondary-actions .btn{flex:1 1 auto}}
</style>

<style id="ait-psa-instant-time-fields-style">
.ait-psa-instant-time-fields{display:block!important;margin-top:14px;padding:16px;border:1px solid var(--line,#cbd5e1);border-radius:14px;background:var(--panel,#fff);box-shadow:inset 0 1px 0 rgba(255,255,255,.05)}
.ait-psa-instant-time-fields[hidden]{display:none!important}
.ait-psa-instant-time-fields input[type="time"]{display:block!important;width:100%;min-height:44px;opacity:1!important;visibility:visible!important;color:var(--ink,#111827);background:var(--input-bg,var(--panel,#fff));border:1px solid var(--line,#cbd5e1);border-radius:10px;padding:9px 11px;color-scheme:light dark}
@media(max-width:640px){.ait-psa-instant-time-fields>div:nth-child(2){grid-template-columns:1fr!important}}
</style>

<style id="ait-elite-fundamental-card-layout-v10089">
#aitElitePriorityModal .ait-elite-summary-block,
#aitEliteDecisionDetailModal .ait-elite-detail-card{width:min(100%,1160px);margin-inline:auto}
#aitElitePriorityModal .ait-elite-summary-block .ait-fundamental-strip,
#aitEliteDecisionDetailModal .ait-fundamental-strip{margin-top:0;margin-bottom:12px}
#aitEliteDecisionDetailModal .ait-elite-detail-card{background:transparent;border:0;box-shadow:none}
#aitEliteDecisionDetailModal .ait-fundamental-item b{white-space:normal;overflow:visible;text-overflow:clip;line-height:1.35}
</style>

<style id="ait-elite-calculation-cursor-v10092">
.ait-elite-calc-layer{
  position:fixed;inset:0;z-index:2147483000;display:none;
  place-items:center;pointer-events:all;
  background:color-mix(in srgb,var(--panel,#101827) 48%,transparent);
  backdrop-filter:blur(7px) saturate(1.15);
  -webkit-backdrop-filter:blur(7px) saturate(1.15);
  cursor:progress;
}
.ait-elite-calc-layer.is-active{display:grid}
.ait-elite-calc-card{
  width:min(430px,calc(100vw - 32px));padding:24px 24px 20px;
  border:1px solid color-mix(in srgb,var(--accent,#38bdf8) 35%,var(--border,#475569));
  border-radius:22px;
  background:color-mix(in srgb,var(--panel,#111827) 94%,transparent);
  box-shadow:0 24px 80px rgba(0,0,0,.34),inset 0 1px 0 rgba(255,255,255,.08);
  text-align:center;color:var(--text,#e5e7eb);
}
.ait-elite-calc-orbit{
  position:relative;width:92px;height:92px;margin:0 auto 18px;
}
.ait-elite-calc-orbit::before,
.ait-elite-calc-orbit::after{
  content:"";position:absolute;border-radius:50%;inset:0;
  border:2px solid color-mix(in srgb,var(--accent,#38bdf8) 24%,transparent);
}
.ait-elite-calc-orbit::before{
  border-top-color:var(--accent,#38bdf8);
  border-right-color:var(--accent-2,#8b5cf6);
  animation:aitEliteOrbit 1.05s linear infinite;
}
.ait-elite-calc-orbit::after{
  inset:12px;border-left-color:var(--accent,#38bdf8);
  border-bottom-color:var(--accent-2,#8b5cf6);
  animation:aitEliteOrbitReverse .78s linear infinite;
}
.ait-elite-calc-core{
  position:absolute;inset:28px;border-radius:50%;display:grid;place-items:center;
  font-weight:900;font-size:17px;letter-spacing:.04em;
  background:color-mix(in srgb,var(--accent,#38bdf8) 16%,var(--panel,#111827));
  border:1px solid color-mix(in srgb,var(--accent,#38bdf8) 52%,transparent);
  box-shadow:0 0 28px color-mix(in srgb,var(--accent,#38bdf8) 28%,transparent);
}
.ait-elite-calc-kicker{
  font-size:11px;font-weight:800;letter-spacing:.16em;text-transform:uppercase;
  color:var(--accent,#38bdf8);margin-bottom:5px;
}
.ait-elite-calc-title{font-size:20px;font-weight:850;line-height:1.2;margin:0}
.ait-elite-calc-text{font-size:13px;line-height:1.55;opacity:.78;margin:8px 0 15px}
.ait-elite-calc-track{
  height:6px;border-radius:999px;overflow:hidden;
  background:color-mix(in srgb,var(--text,#e5e7eb) 10%,transparent);
}
.ait-elite-calc-bar{
  width:42%;height:100%;border-radius:inherit;
  background:linear-gradient(90deg,var(--accent,#38bdf8),var(--accent-2,#8b5cf6),var(--accent,#38bdf8));
  animation:aitEliteScan 1.15s ease-in-out infinite;
}
body.ait-elite-is-calculating,
body.ait-elite-is-calculating *{cursor:progress!important}
@keyframes aitEliteOrbit{to{transform:rotate(360deg)}}
@keyframes aitEliteOrbitReverse{to{transform:rotate(-360deg)}}
@keyframes aitEliteScan{
  0%{transform:translateX(-110%);width:38%}
  50%{width:62%}
  100%{transform:translateX(270%);width:38%}
}
@media (prefers-reduced-motion:reduce){
 .ait-elite-calc-orbit::before,.ait-elite-calc-orbit::after,.ait-elite-calc-bar{animation-duration:2.5s}
}
</style>

<style id="ait-amarstock-details-v10094">
#gallery .mini-card .row > .actions,
#v11RankedChartGallery .mini-card .row > .actions{
  display:flex;
  align-items:center;
  justify-content:flex-end;
  gap:8px;
  flex-wrap:wrap;
}
#gallery .mini-card a.btn,
#v11RankedChartGallery .mini-card a.btn{
  text-decoration:none;
  white-space:nowrap;
}
</style>
<style id="ait-terminal-danger-style-v10095">
.ait-psa-terminal-command--danger{
  border-color:color-mix(in srgb,#ef4444 52%,var(--v10-line,var(--line,#334155)))!important;
  background:color-mix(in srgb,#ef4444 9%,var(--v10-card,var(--card,#0f172a)))!important;
}
.ait-psa-terminal-command--danger:hover{
  border-color:#ef4444!important;
  box-shadow:0 14px 34px rgba(239,68,68,.16)!important;
}
.ait-psa-terminal-command--danger span{
  color:#ef4444!important;
}
</style>

<style id="ait-download-timer-v10096">
#downloadStatusCard .ait-download-timing{
  display:grid;
  grid-template-columns:repeat(2,minmax(0,1fr));
  gap:10px;
  margin-top:10px;
}
#downloadStatusCard .ait-download-time-card{
  min-width:0;
  padding:10px 12px;
  border:1px solid var(--v10-line,var(--line,#334155));
  border-radius:12px;
  background:color-mix(in srgb,var(--v10-card,var(--card,#0f172a)) 92%,var(--v10-primary,var(--primary,#2563eb)) 8%);
}
#downloadStatusCard .ait-download-time-card span,
#downloadStatusCard .ait-download-time-card small{
  display:block;
  color:var(--v10-muted,var(--muted,#64748b));
}
#downloadStatusCard .ait-download-time-card span{
  font-size:11px;
  font-weight:700;
  letter-spacing:.04em;
  text-transform:uppercase;
}
#downloadStatusCard .ait-download-time-card strong{
  display:block;
  margin-top:3px;
  font-size:18px;
  line-height:1.2;
  color:var(--v10-text,var(--text,#e2e8f0));
}
#downloadStatusCard .ait-download-time-card small{
  margin-top:3px;
  font-size:11px;
}
@media (max-width:640px){
  #downloadStatusCard .ait-download-timing{grid-template-columns:1fr}
}
</style>

<style id="ait-download-status-premium-v10098">
#downloadStatusCard.ait-download-status-panel{
  position:relative;
  overflow:hidden;
  border:1px solid color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 28%,var(--v10-line,var(--line,#334155)));
  border-radius:20px;
  background:
    radial-gradient(circle at 0 0,color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 13%,transparent),transparent 36%),
    color-mix(in srgb,var(--v10-card,var(--card,#0f172a)) 96%,transparent);
  box-shadow:0 20px 54px rgba(15,23,42,.14);
}
#downloadStatusCard .ait-download-status-layout{
  display:grid;
  grid-template-columns:auto minmax(0,1fr) auto;
  gap:16px;
  align-items:center;
  padding:4px;
}
#downloadStatusCard .ait-download-status-orb{
  width:54px;height:54px;border-radius:16px;display:grid;place-items:center;
  border:1px solid color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 35%,var(--v10-line,var(--line,#334155)));
  background:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 12%,var(--v10-card,var(--card,#0f172a)));
  color:var(--v10-primary,var(--primary,#2563eb));
  font-size:24px;font-weight:800;
}
#downloadStatusCard .ait-download-status-main{min-width:0}
#downloadStatusCard .ait-download-status-head{
  display:flex;justify-content:space-between;gap:14px;align-items:flex-start;
}
#downloadStatusCard .ait-download-status-head > div{min-width:0}
#downloadStatusCard .ait-download-status-kicker{
  display:block;margin-bottom:3px;font-size:10px;font-weight:800;letter-spacing:.13em;
  color:var(--v10-primary,var(--primary,#2563eb));
}
#downloadStatusCard #downloadStatusTitle{
  display:block;font-size:16px;line-height:1.3;overflow-wrap:anywhere;
}
#downloadStatusCard .ait-download-status-percent{
  flex:0 0 auto;padding:5px 9px;border-radius:999px;font-weight:800;
  border:1px solid var(--v10-line,var(--line,#334155));
  background:color-mix(in srgb,var(--v10-card,var(--card,#0f172a)) 88%,var(--v10-primary,var(--primary,#2563eb)) 12%);
}
#downloadStatusCard .ait-download-status-track{
  height:11px;margin-top:10px;overflow:hidden;border-radius:999px;
  background:color-mix(in srgb,var(--v10-line,var(--line,#334155)) 48%,transparent);
  box-shadow:inset 0 1px 3px rgba(15,23,42,.12);
}
#downloadStatusCard .ait-download-status-bar{
  height:100%;border-radius:inherit;
  transition:width .3s ease,background .25s ease;
  box-shadow:0 0 18px color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 25%,transparent);
}
#downloadStatusCard .ait-download-status-text{
  margin-top:8px;line-height:1.5;overflow-wrap:anywhere;
}
#downloadStatusCard .ait-download-timing{
  grid-template-columns:repeat(2,minmax(0,1fr));
}
#downloadStatusCard .ait-download-time-card{
  position:relative;overflow:hidden;
  border-radius:14px;padding:11px 12px;
}
#downloadStatusCard #hideDownloadStatus{
  align-self:start;white-space:nowrap;
}
@media (max-width:760px){
 #downloadStatusCard .ait-download-status-layout{
   grid-template-columns:1fr;
   gap:12px;
 }
 #downloadStatusCard .ait-download-status-orb{width:46px;height:46px;border-radius:14px}
 #downloadStatusCard #hideDownloadStatus{justify-self:end;grid-row:1;grid-column:1}
 #downloadStatusCard .ait-download-status-orb{grid-row:1;grid-column:1}
 #downloadStatusCard .ait-download-status-main{grid-row:2;grid-column:1}
}
@media (max-width:520px){
 #downloadStatusCard .ait-download-status-head{align-items:flex-start}
 #downloadStatusCard .ait-download-timing{grid-template-columns:1fr}
 #downloadStatusCard #downloadStatusTitle{font-size:15px}
}
</style>

<style id="ait-watch-header-dropdown-v10099">
#marketWorkspace .panel .head{gap:14px}
#marketWorkspace .ait-watch-header-actions{
 display:flex;align-items:center;justify-content:flex-end;gap:8px;flex-wrap:wrap;
}
#marketWorkspace .ait-watch-action-menu{flex:0 1 170px;min-width:150px}
#marketWorkspace .ait-watch-action-menu .v10-menu-trigger{min-height:40px;border-radius:11px}
#marketWorkspace .ait-watch-action-menu .v10-menu-panel{min-width:220px}
#marketWorkspace .ait-watch-action-menu .v10-menu-panel button{
 min-height:42px!important;white-space:nowrap;
}
#marketWorkspace .code-row .actions{flex:0 0 auto}
@media (max-width:760px){
 #marketWorkspace .panel .head{align-items:flex-start;flex-direction:column}
 #marketWorkspace .ait-watch-header-actions{width:100%;justify-content:stretch}
 #marketWorkspace .ait-watch-action-menu{flex:1 1 calc(50% - 4px);min-width:0}
 #marketWorkspace .ait-watch-action-menu .v10-menu-panel{
   width:min(280px,calc(100vw - 36px));max-width:calc(100vw - 36px);
 }
}
@media (max-width:480px){
 #marketWorkspace .ait-watch-header-actions{display:grid;grid-template-columns:1fr 1fr}
 #marketWorkspace .ait-watch-action-menu{width:100%}
}
</style>


<style id="ait-scanner-chart-dropdown-v10102">
.ait-scanner-toolbar{
 display:flex!important;align-items:center!important;justify-content:flex-end!important;
 gap:8px!important;flex-wrap:wrap!important;overflow:visible!important;
}
.ait-scanner-toolbar .ait-scanner-run{min-width:96px}
.ait-scanner-charts{position:relative;min-width:132px;overflow:visible}
.ait-scanner-charts-trigger{
 width:100%;min-height:40px;display:flex!important;align-items:center;
 justify-content:space-between;gap:10px;
}
.ait-scanner-charts-caret{transition:transform .16s ease}
.ait-scanner-charts.is-open .ait-scanner-charts-caret{transform:rotate(180deg)}
.ait-scanner-charts-menu{
 position:absolute;top:calc(100% + 7px);right:0;z-index:10000;
 width:150px;padding:7px;border:1px solid var(--v10-line,var(--line,#334155));
 border-radius:14px;background:var(--v10-panel-solid,var(--card,#0f172a));
 box-shadow:0 20px 55px rgba(0,0,0,.34);
}
.ait-scanner-charts-menu:not([hidden]){display:grid;gap:4px}
.ait-scanner-charts-menu button{
 width:100%!important;min-height:40px!important;justify-content:center!important;
 text-align:center!important;font-weight:800!important;
}
.v11-card-head,.v11-potential-actions{overflow:visible!important}
@media (max-width:640px){
 .ait-scanner-toolbar{
  width:100%;display:grid!important;
  grid-template-columns:minmax(0,1fr) minmax(0,1fr);
 }
 .ait-scanner-toolbar .ait-scanner-run,.ait-scanner-charts{width:100%;min-width:0}
 .ait-scanner-charts-menu{left:0;right:auto;width:100%;min-width:130px}
}
</style>

<style id="ait-elite-details-groups-v10104">
#aitEliteRegimeDetailModal .ait-elite-detail-card{width:min(100%,1160px);margin-inline:auto;background:transparent;border:0;box-shadow:none}
#aitEliteRegimeDetailModal .ait-elite-detail-group{padding:14px;border:1px solid var(--v10-line,var(--line,#334155));border-radius:14px;margin-bottom:12px;background:color-mix(in srgb,var(--v10-card,#0f172a) 96%,transparent)}
#aitEliteRegimeDetailModal .ait-elite-detail-group-head{margin-bottom:10px}
#aitEliteRegimeDetailModal .ait-elite-detail-group-head h3{margin:0;font-size:.95rem;line-height:1.3;color:var(--v10-text,var(--text,#e2e8f0))}
#aitEliteRegimeDetailModal .ait-elite-detail-group-head p{margin:4px 0 0;font-size:.75rem;line-height:1.45;color:var(--v10-muted,var(--muted,#94a3b8))}
#aitEliteRegimeDetailModal .ait-elite-detail-group .ait-fundamental-strip{margin:0;grid-template-columns:repeat(3,minmax(0,1fr))}
#aitEliteRegimeDetailModal .ait-fundamental-item b{white-space:normal;overflow:visible;text-overflow:clip;line-height:1.35}
@media(max-width:820px){#aitEliteRegimeDetailModal .ait-elite-detail-group .ait-fundamental-strip{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:520px){#aitEliteRegimeDetailModal .ait-elite-detail-group .ait-fundamental-strip{grid-template-columns:1fr}}

#aitEliteDecisionDetailModal .ait-elite-detail-group{
 width:min(100%,1160px);margin:0 auto 14px;padding:14px;
 border:1px solid var(--v10-line,var(--line,#334155));border-radius:16px;
 background:color-mix(in srgb,var(--v10-card,var(--card,#0f172a)) 94%,transparent);
}
#aitEliteDecisionDetailModal .ait-elite-detail-group-head{margin-bottom:10px}
#aitEliteDecisionDetailModal .ait-elite-detail-group-head h3{margin:0;font-size:.95rem;line-height:1.3;color:var(--v10-text,var(--text,#e2e8f0))}
#aitEliteDecisionDetailModal .ait-elite-detail-group-head p{margin:4px 0 0;font-size:.75rem;line-height:1.45;color:var(--v10-muted,var(--muted,#94a3b8))}
#aitEliteDecisionDetailModal .ait-elite-detail-group .ait-fundamental-strip{margin:0;grid-template-columns:repeat(3,minmax(0,1fr))}
#aitEliteDecisionDetailModal .ait-fundamental-item em{display:block;margin-top:4px;font-size:.66rem;font-style:normal;line-height:1.4;color:var(--v10-muted,var(--muted,#94a3b8))}
#aitEliteDecisionDetailModal .ait-elite-detail-group--decision{
 border-color:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 42%,var(--v10-line,var(--line,#334155)));
 background:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 7%,var(--v10-card,var(--card,#0f172a)));
}
#aitEliteDecisionDetailModal .ait-elite-detail-group--decision .ait-fundamental-item:first-child b{font-size:.92rem;color:var(--v10-primary,var(--primary,#2563eb))}
@media(max-width:820px){#aitEliteDecisionDetailModal .ait-elite-detail-group .ait-fundamental-strip{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:520px){#aitEliteDecisionDetailModal .ait-elite-detail-group{padding:11px}#aitEliteDecisionDetailModal .ait-elite-detail-group .ait-fundamental-strip{grid-template-columns:1fr}}
</style>

<style id="ait-scanner-download-dropdown-v10108">
.ait-scanner-download{position:relative;min-width:148px;overflow:visible}
.ait-scanner-download-trigger{width:100%;min-height:40px;display:flex!important;align-items:center;justify-content:space-between;gap:10px}
.ait-scanner-download-caret{transition:transform .16s ease}
.ait-scanner-download.is-open .ait-scanner-download-caret{transform:rotate(180deg)}
.ait-scanner-download-menu{position:absolute;top:calc(100% + 7px);right:0;z-index:10000;width:160px;padding:7px;border:1px solid var(--v10-line,var(--line,#334155));border-radius:14px;background:var(--v10-panel-solid,var(--card,#0f172a));box-shadow:0 20px 55px rgba(0,0,0,.34)}
.ait-scanner-download-menu:not([hidden]){display:grid;gap:4px}
.ait-scanner-download-menu button{width:100%!important;min-height:40px!important;justify-content:center!important;text-align:center!important;font-weight:800!important}
@media (max-width:640px){.ait-scanner-toolbar{grid-template-columns:minmax(0,1fr) minmax(0,1fr) minmax(0,1fr)!important}.ait-scanner-download{width:100%;min-width:0}.ait-scanner-download-menu{left:0;right:auto;width:100%;min-width:140px}}
@media (max-width:480px){.ait-scanner-toolbar{grid-template-columns:1fr 1fr!important}.ait-scanner-run{grid-column:1/-1}}
</style>

<style id="ait-elite-final-decision-v10110">
#aitElitePriorityModal .ait-elite-decision-cell{
  min-width:230px;
  border-left:4px solid transparent;
}
#aitElitePriorityModal .ait-elite-decision-cell strong{
  display:block;
  font-size:13px;
  line-height:1.25;
  letter-spacing:.01em;
}
#aitElitePriorityModal .ait-elite-decision-cell small{
  display:block;
  margin-top:4px;
  max-width:260px;
  line-height:1.35;
  opacity:.78;
}
#aitElitePriorityModal .ait-elite-decision--buy{
  border-left-color:#16a34a;
  background:color-mix(in srgb,#16a34a 10%,transparent);
}
#aitElitePriorityModal .ait-elite-decision--wait{
  border-left-color:#d97706;
  background:color-mix(in srgb,#d97706 9%,transparent);
}
#aitElitePriorityModal .ait-elite-decision--blocked{
  border-left-color:#ea580c;
  background:color-mix(in srgb,#ea580c 12%,transparent);
}
#aitElitePriorityModal .ait-elite-decision--hold{
  border-left-color:#2563eb;
  background:color-mix(in srgb,#2563eb 9%,transparent);
}
#aitElitePriorityModal .ait-elite-decision--caution{
  border-left-color:#dc2626;
  background:color-mix(in srgb,#dc2626 9%,transparent);
}
#aitElitePriorityModal .ait-elite-decision--avoid{
  border-left-color:#991b1b;
  background:color-mix(in srgb,#991b1b 12%,transparent);
}
#aitEliteDecisionDetailModal .ait-elite-detail-group--decision{
  border-width:2px;
}
#aitEliteDecisionDetailModal .ait-elite-detail-group--decision.ait-elite-decision--blocked{
  border-color:color-mix(in srgb,#ea580c 42%,var(--v10-line,var(--line,#334155)));
  background:color-mix(in srgb,#ea580c 5%,transparent);
}
#aitEliteDecisionDetailModal .ait-elite-detail-group--decision.ait-elite-decision--buy{
  border-color:color-mix(in srgb,#16a34a 42%,var(--v10-line,var(--line,#334155)));
}
#aitEliteDecisionDetailModal .ait-elite-detail-group--decision.ait-elite-decision--caution,
#aitEliteDecisionDetailModal .ait-elite-detail-group--decision.ait-elite-decision--avoid{
  border-color:color-mix(in srgb,#dc2626 42%,var(--v10-line,var(--line,#334155)));
}
</style>

<style id="ait-elite-table-layout-v10111">
#aitElitePriorityModal .v11-scanner-table-wrap{
  overflow-x:auto!important;
  overflow-y:visible!important;
  -webkit-overflow-scrolling:touch;
  scrollbar-gutter:stable both-edges;
}
#aitElitePriorityModal .v11-potential-table{
  width:100%;
  min-width:1460px;
  table-layout:fixed;
  border-collapse:separate;
  border-spacing:0;
}
#aitElitePriorityModal .v11-potential-table th,
#aitElitePriorityModal .v11-potential-table td{
  vertical-align:top;
  white-space:normal!important;
  overflow-wrap:anywhere;
  word-break:normal;
  line-height:1.4;
  padding:11px 10px;
}
#aitElitePriorityModal .v11-potential-table th{
  white-space:nowrap!important;
}
#aitElitePriorityModal .v11-potential-table th:nth-child(1),
#aitElitePriorityModal .v11-potential-table td:nth-child(1){width:115px}
#aitElitePriorityModal .v11-potential-table th:nth-child(2),
#aitElitePriorityModal .v11-potential-table td:nth-child(2){width:125px}
#aitElitePriorityModal .v11-potential-table th:nth-child(3),
#aitElitePriorityModal .v11-potential-table td:nth-child(3){width:90px}
#aitElitePriorityModal .v11-potential-table th:nth-child(4),
#aitElitePriorityModal .v11-potential-table td:nth-child(4){width:235px}
#aitElitePriorityModal .v11-potential-table th:nth-child(5),
#aitElitePriorityModal .v11-potential-table td:nth-child(5){width:145px}
#aitElitePriorityModal .v11-potential-table th:nth-child(6),
#aitElitePriorityModal .v11-potential-table td:nth-child(6){width:145px}
#aitElitePriorityModal .v11-potential-table th:nth-child(7),
#aitElitePriorityModal .v11-potential-table td:nth-child(7){width:155px}
#aitElitePriorityModal .v11-potential-table th:nth-child(8),
#aitElitePriorityModal .v11-potential-table td:nth-child(8){width:175px}
#aitElitePriorityModal .v11-potential-table th:nth-child(9),
#aitElitePriorityModal .v11-potential-table td:nth-child(9){width:250px}
#aitElitePriorityModal .v11-potential-table th:nth-child(10),
#aitElitePriorityModal .v11-potential-table td:nth-child(10){width:125px}
#aitElitePriorityModal .v11-signal{
  display:inline-flex!important;
  max-width:100%;
  white-space:normal!important;
  flex-wrap:wrap;
  line-height:1.25;
}
#aitElitePriorityModal .ait-elite-decision-cell{
  min-width:0!important;
}
#aitElitePriorityModal .ait-elite-decision-cell strong,
#aitElitePriorityModal .ait-elite-decision-cell small{
  max-width:100%!important;
  overflow-wrap:anywhere;
}
#aitElitePriorityModal .ait-elite-details{
  width:100%;
  max-width:110px;
  white-space:nowrap;
}
#aitElitePriorityModal .v11-table-scrollbar{
  display:block;
}
@media (max-width:900px){
  #aitElitePriorityModal .v11-potential-table{min-width:1380px}
}
@media (max-width:640px){
  #aitElitePriorityModal .v11-potential-table{min-width:1320px}
  #aitElitePriorityModal .v11-potential-table th,
  #aitElitePriorityModal .v11-potential-table td{padding:9px 8px}
}
</style>
<style id="ait-elite-regime-table-layout-v10117">
/* AIT Elite Regime — mirror AIT Elite table comfort/layout without changing logic */
#aitEliteRegimeModal .v11-scanner-table-wrap,
#aitEliteRegimeWorkspace .v11-scanner-table-wrap{
  overflow-x:auto!important;
  overflow-y:visible!important;
  -webkit-overflow-scrolling:touch;
  scrollbar-gutter:stable both-edges;
}
#aitEliteRegimeModal .v11-potential-table,
#aitEliteRegimeWorkspace .v11-potential-table{
  width:100%;
  min-width:1460px;
  table-layout:fixed;
  border-collapse:separate;
  border-spacing:0;
}
#aitEliteRegimeModal .v11-potential-table th,
#aitEliteRegimeModal .v11-potential-table td,
#aitEliteRegimeWorkspace .v11-potential-table th,
#aitEliteRegimeWorkspace .v11-potential-table td{
  vertical-align:top;
  white-space:normal!important;
  overflow-wrap:anywhere;
  word-break:normal;
  line-height:1.4;
  padding:11px 10px;
}
#aitEliteRegimeModal .v11-potential-table th,
#aitEliteRegimeWorkspace .v11-potential-table th{white-space:nowrap!important}
#aitEliteRegimeModal .v11-potential-table th:nth-child(1),
#aitEliteRegimeModal .v11-potential-table td:nth-child(1),
#aitEliteRegimeWorkspace .v11-potential-table th:nth-child(1),
#aitEliteRegimeWorkspace .v11-potential-table td:nth-child(1){width:125px}
#aitEliteRegimeModal .v11-potential-table th:nth-child(2),
#aitEliteRegimeModal .v11-potential-table td:nth-child(2),
#aitEliteRegimeWorkspace .v11-potential-table th:nth-child(2),
#aitEliteRegimeWorkspace .v11-potential-table td:nth-child(2){width:125px}
#aitEliteRegimeModal .v11-potential-table th:nth-child(3),
#aitEliteRegimeModal .v11-potential-table td:nth-child(3),
#aitEliteRegimeWorkspace .v11-potential-table th:nth-child(3),
#aitEliteRegimeWorkspace .v11-potential-table td:nth-child(3){width:90px}
#aitEliteRegimeModal .v11-potential-table th:nth-child(4),
#aitEliteRegimeModal .v11-potential-table td:nth-child(4),
#aitEliteRegimeWorkspace .v11-potential-table th:nth-child(4),
#aitEliteRegimeWorkspace .v11-potential-table td:nth-child(4){width:235px}
#aitEliteRegimeModal .v11-potential-table th:nth-child(5),
#aitEliteRegimeModal .v11-potential-table td:nth-child(5),
#aitEliteRegimeWorkspace .v11-potential-table th:nth-child(5),
#aitEliteRegimeWorkspace .v11-potential-table td:nth-child(5){width:145px}
#aitEliteRegimeModal .v11-potential-table th:nth-child(6),
#aitEliteRegimeModal .v11-potential-table td:nth-child(6),
#aitEliteRegimeWorkspace .v11-potential-table th:nth-child(6),
#aitEliteRegimeWorkspace .v11-potential-table td:nth-child(6){width:145px}
#aitEliteRegimeModal .v11-potential-table th:nth-child(7),
#aitEliteRegimeModal .v11-potential-table td:nth-child(7),
#aitEliteRegimeWorkspace .v11-potential-table th:nth-child(7),
#aitEliteRegimeWorkspace .v11-potential-table td:nth-child(7){width:155px}
#aitEliteRegimeModal .v11-potential-table th:nth-child(8),
#aitEliteRegimeModal .v11-potential-table td:nth-child(8),
#aitEliteRegimeWorkspace .v11-potential-table th:nth-child(8),
#aitEliteRegimeWorkspace .v11-potential-table td:nth-child(8){width:175px}
#aitEliteRegimeModal .v11-potential-table th:nth-child(9),
#aitEliteRegimeModal .v11-potential-table td:nth-child(9),
#aitEliteRegimeWorkspace .v11-potential-table th:nth-child(9),
#aitEliteRegimeWorkspace .v11-potential-table td:nth-child(9){width:250px}
#aitEliteRegimeModal .v11-potential-table th:nth-child(10),
#aitEliteRegimeModal .v11-potential-table td:nth-child(10),
#aitEliteRegimeWorkspace .v11-potential-table th:nth-child(10),
#aitEliteRegimeWorkspace .v11-potential-table td:nth-child(10){width:125px}
#aitEliteRegimeModal .v11-signal,
#aitEliteRegimeWorkspace .v11-signal{
  display:inline-flex!important;
  max-width:100%;
  white-space:normal!important;
  flex-wrap:wrap;
  line-height:1.25;
}
#aitEliteRegimeModal .ait-elite-decision-cell,
#aitEliteRegimeWorkspace .ait-elite-decision-cell{min-width:0!important}
#aitEliteRegimeModal .ait-elite-decision-cell strong,
#aitEliteRegimeModal .ait-elite-decision-cell small,
#aitEliteRegimeWorkspace .ait-elite-decision-cell strong,
#aitEliteRegimeWorkspace .ait-elite-decision-cell small{max-width:100%!important;overflow-wrap:anywhere}
#aitEliteRegimeModal .ait-elite-regime-details,
#aitEliteRegimeWorkspace .ait-elite-regime-details{width:100%;max-width:110px;white-space:nowrap}
#aitEliteRegimeModal .v11-table-scrollbar,
#aitEliteRegimeWorkspace .v11-table-scrollbar{display:block}
#aitEliteRegimeModal .v11-scanner-table-wrap .v11-table tbody tr:nth-child(even),
#aitEliteRegimeWorkspace .v11-scanner-table-wrap .v11-table tbody tr:nth-child(even){background:color-mix(in srgb,var(--v10-card) 48%,transparent)}
@media (max-width:900px){
  #aitEliteRegimeModal .v11-potential-table,
  #aitEliteRegimeWorkspace .v11-potential-table{min-width:1380px}
}
@media (max-width:640px){
  #aitEliteRegimeModal .v11-potential-table,
  #aitEliteRegimeWorkspace .v11-potential-table{min-width:1320px}
  #aitEliteRegimeModal .v11-potential-table th,
  #aitEliteRegimeModal .v11-potential-table td,
  #aitEliteRegimeWorkspace .v11-potential-table th,
  #aitEliteRegimeWorkspace .v11-potential-table td{padding:9px 8px}
}
</style>

</head>
<body>
<div class="v10-mobile-bar">
 <button class="btn soft" type="button" id="v10OpenDrawer" aria-label="Open watch-list drawer">☰</button>
 <div class="v10-mobile-title">
  <strong>Ababil DSE Terminal</strong>
  <span>Mobile market workspace</span>
 </div>
 <div class="v105-top-actions">
<button class="btn soft v105-icon-btn" type="button" id="v11TerminalBtn" title="Trading terminal">⌁</button>
  
  <button class="btn soft v105-icon-btn" type="button" id="v105CommandBtn" title="Command palette">⌘</button>
  <button class="btn soft v105-icon-btn" type="button" id="v105NotifyBtn" title="Notifications">♢<span class="v105-count" id="v105NotifyCount">0</span></button>
 </div>
 <select class="v10-theme-quick" id="v10ThemeQuick" aria-label="Select theme">
  <option value="dark-glass">Dark Glass</option>
  <option value="classic-light">Classic</option>
  <option value="sapphire">Sapphire</option>
  <option value="emerald">Emerald</option>
  <option value="royal-purple">Purple</option>
  <option value="carbon-oled">Carbon</option>
  <option value="crimson">Crimson</option>
  <option value="coffee">Coffee</option>
  <option value="aurora">Aurora</option>
 </select>
</div>

<div class="v10-control-deck" aria-label="Main action groups">
 <div class="v10-control-group">
  <div class="v10-menu">
   <button class="btn v10-menu-trigger primary-menu" type="button"><span>⬇ Download</span><span>⌄</span></button>
   <div class="v10-menu-panel">
    <button type="button" data-proxy="dse3mUpdate">Download 3 months & view charts</button>
    <button type="button" data-proxy="archiveImport">Custom archive range</button>
    <button type="button" data-proxy="motherImport">Import DSE trading codes</button>
    <button type="button" data-proxy="quickMotherSync">Sync AmarStock codes</button>
   </div>
  </div>
  <div class="v10-menu">
   <button class="btn v10-menu-trigger" type="button"><span>◫ View</span><span>⌄</span></button>
   <div class="v10-menu-panel">
    <button type="button" data-proxy="viewListCharts">Saved chart gallery</button>
    <button type="button" data-proxy="viewDownloadedData">Downloaded data table</button>
    <div class="v10-menu-separator"></div>
    <button type="button" data-v10-scroll="marketWorkspace">Market-code workspace</button>
    <button type="button" data-v10-scroll="downloadWorkspace">Download status</button>
   </div>
  </div>
  <div class="v10-menu">
   <button class="btn v10-menu-trigger" type="button"><span>◆ Backup</span><span>⌄</span></button>
   <div class="v10-menu-panel">
    <button type="button" data-proxy="exportBtn">Backup dashboard + portfolio</button>
    <button type="button" data-proxy="importBtn">Restore dashboard</button>
   </div>
  </div>
 </div>

 
 <div class="v105-top-actions">
  <button class="btn soft v105-icon-btn" type="button" id="v105WorkspaceBtn" title="Workspaces">▦</button>
  <button class="btn soft v105-icon-btn" type="button" id="v105CommandBtnDesktop" title="Command palette">⌘</button>
  <button class="btn soft v105-icon-btn" type="button" id="v105NotifyBtnDesktop" title="Notifications">♢<span class="v105-count" id="v105NotifyCountDesktop">0</span></button>
 </div>
<div class="v10-menu align-right">
  <button class="btn v10-menu-trigger" type="button"><span>◐ Themes</span><span>⌄</span></button>
  <div class="v10-menu-panel" style="width:min(440px,92vw)">
   <div class="v10-theme-grid" id="v10ThemeGrid">
    <button class="v10-theme-option" type="button" data-theme-value="dark-glass"><span class="v10-swatch" style="--sw1:#38bdf8;--sw2:#2563eb"></span><strong>Dark Glass</strong><small>Premium default</small></button>
    <button class="v10-theme-option" type="button" data-theme-value="classic-light"><span class="v10-swatch" style="--sw1:#087f75;--sw2:#edf3f8"></span><strong>Classic</strong><small>Previous design</small></button>
    <button class="v10-theme-option" type="button" data-theme-value="sapphire"><span class="v10-swatch" style="--sw1:#60a5fa;--sw2:#1d4ed8"></span><strong>Sapphire</strong><small>Finance blue</small></button>
    <button class="v10-theme-option" type="button" data-theme-value="emerald"><span class="v10-swatch" style="--sw1:#34d399;--sw2:#047857"></span><strong>Emerald</strong><small>Trading green</small></button>
    <button class="v10-theme-option" type="button" data-theme-value="royal-purple"><span class="v10-swatch" style="--sw1:#c4b5fd;--sw2:#7c3aed"></span><strong>Royal Purple</strong><small>Premium violet</small></button>
    <button class="v10-theme-option" type="button" data-theme-value="carbon-oled"><span class="v10-swatch" style="--sw1:#f4f4f5;--sw2:#18181b"></span><strong>Carbon OLED</strong><small>True black</small></button>
    <button class="v10-theme-option" type="button" data-theme-value="crimson"><span class="v10-swatch" style="--sw1:#fb7185;--sw2:#be123c"></span><strong>Crimson</strong><small>Bold market red</small></button>
    <button class="v10-theme-option" type="button" data-theme-value="coffee"><span class="v10-swatch" style="--sw1:#d9a96f;--sw2:#6f3e1f"></span><strong>Coffee</strong><small>Warm workspace</small></button>
    <button class="v10-theme-option" type="button" data-theme-value="aurora"><span class="v10-swatch" style="--sw1:#5eead4;--sw2:#8b5cf6"></span><strong>Aurora</strong><small>Teal violet</small></button>
   </div>
  </div>
 </div>
</div>

<div class="v10-drawer-backdrop" id="v10DrawerBackdrop"></div>

<div class="v9-command">
 <div class="v9-brand">
  <div class="v9-logo">DSE</div>
  <div class="v9-brand-heading">
   <div class="v9-title">AIT - PSA</div>
   <div class="v9-state"><span class="v9-dot"></span> Local Terminal Ready</div>
  </div>
 </div>
</div>
<div class="v9-quick-grid">
 <div class="v9-stat"><span>Active workspace</span><strong id="v9ActiveList">Watch list</strong></div>
 <div class="v9-stat"><span>Tracked securities</span><strong id="v9TrackedCodes">0 codes</strong></div>
 <div class="v9-stat"><span>Saved OHLC records</span><strong id="v9SavedRecords">0 records</strong></div>
 <div class="v9-stat"><span>Archive engine</span><strong id="v9ArchiveState">Ready</strong></div>
</div>

<section class="v11-shell" id="v11Terminal">
 <nav class="v11-tabs v11-workspace-menu" aria-label="Trading terminal workspaces">
  <button class="v11-tab v11-menu-primary" type="button" data-v11-tab="portfolio">
   <span class="v11-menu-icon" aria-hidden="true">◫</span>
   <span>Portfolio</span>
  </button>

  <details class="v11-menu-group" data-v11-group="report" open>
   <summary>
    <span class="v11-menu-icon" aria-hidden="true">▥</span>
    <span>Report</span>
    <span class="v11-menu-chevron" aria-hidden="true">⌄</span>
   </summary>
   <div class="v11-submenu">
    <button class="v11-tab active" type="button" data-v11-tab="charts">Charts</button>
    <button class="v11-tab" type="button" data-v11-tab="reports">Report</button>
    <button class="v11-tab" type="button" data-v11-tab="explorer">Explorer</button>
   </div>
  </details>

  <details class="v11-menu-group" data-v11-group="scanner">
   <summary>
    <span class="v11-menu-icon" aria-hidden="true">⌁</span>
    <span>Scanner</span>
    <span class="v11-menu-chevron" aria-hidden="true">⌄</span>
   </summary>
   <div class="v11-submenu">
    <button class="v11-tab" type="button" data-v11-tab="indicators">Technical Scanner</button>
    <button class="v11-tab" type="button" data-v11-tab="vpa">Smart Money Scanner</button>
    <button class="v11-tab" type="button" data-v11-tab="comparison">Relative Strength Scanner</button>
    <button class="v11-tab" type="button" data-v11-tab="potential-composite">AIT Composite Screener</button>
    <button class="v11-tab" type="button" data-v11-tab="potential">AIT Elite Screener</button>
    <button class="v11-tab" type="button" data-v11-tab="potential-priority">AIT Signal Priority Screener</button>
   </div>
  </details>
 </nav>

 <section class="v11-workspace active" data-v11-workspace="charts">
  <div class="v11-grid two">
   <article class="v11-card">
    <div class="v11-card-head">
     <div><h3>Multi-chart workspace</h3><small>Compare up to four active watch-list symbols</small></div>
     <div class="v11-inline">
      <select id="v11ChartLayout">
       <option value="1">1 chart</option>
       <option value="2">2 charts</option>
       <option value="4">4 charts</option>
      </select>
      <button class="btn primary" type="button" id="v11RenderCharts">Render</button>
     </div>
    </div>
    <div class="v11-card-body">
     <div class="v11-controls">
      <label>Chart 1<select id="v11Symbol1"></select></label>
      <label>Chart 2<select id="v11Symbol2"></select></label>
      <label>Chart 3<select id="v11Symbol3"></select></label>
      <label>Chart 4<select id="v11Symbol4"></select></label>
     </div>
     <div class="v11-chart-layout layout-1" id="v11ChartLayoutGrid">
      <div class="v11-chart-slot"><span class="v11-chart-label">Chart 1</span><canvas id="v11Canvas1"></canvas></div>
      <div class="v11-chart-slot" hidden><span class="v11-chart-label">Chart 2</span><canvas id="v11Canvas2"></canvas></div>
      <div class="v11-chart-slot" hidden><span class="v11-chart-label">Chart 3</span><canvas id="v11Canvas3"></canvas></div>
      <div class="v11-chart-slot" hidden><span class="v11-chart-label">Chart 4</span><canvas id="v11Canvas4"></canvas></div>
     </div>
    </div>
   </article>

   <aside class="v11-card">
    <div class="v11-card-head"><div><h3>Chart settings</h3><small>Local analysis controls</small></div></div>
    <div class="v11-card-body">
     <div class="v11-indicator-list">
      <label class="v11-check"><input type="checkbox" id="v11Sma20" checked> SMA 20</label>
      <label class="v11-check"><input type="checkbox" id="v11Sma50"> SMA 50</label>
      <label class="v11-check"><input type="checkbox" id="v11Volume" checked> Volume</label>
      <label class="v11-check"><input type="checkbox" id="v11Grid" checked> Grid</label>
     </div>
     <div class="v11-note" style="margin-top:10px">Charts use downloaded local OHLC records. No external data is requested.</div>
    </div>
   </aside>
  </div>
 </section>

 <section class="v11-workspace" data-v11-workspace="indicators">
  <article class="v11-card v11-scanner-card">
   <div class="v11-card-head"><div><h3>Technical Scanner</h3><small>Trend, momentum, SMA, RSI and volume-based technical screening</small></div><div class="v11-potential-actions ait-scanner-toolbar">
      <div class="ait-scanner-download" data-ait-scanner-download>
       <button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span>
       </button>
       <div class="ait-scanner-download-menu" hidden>
        <button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button>
        <button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button>
       </div>
      </div>
      <button class="btn primary ait-scanner-run" id="v11RunScanner" type="button">Run</button>
      <div class="ait-scanner-charts" data-ait-scanner-charts>
       <button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span>
       </button>
       <div class="ait-scanner-charts-menu" hidden>
        <button class="btn soft" id="v11ViewIndicatorCharts" type="button">3M</button>
        <button class="btn soft" id="v11ViewIndicatorCharts6" type="button">6M</button>
        <button class="btn soft" id="v11ViewIndicatorCharts12" type="button">1Y</button>
       </div>
      </div>
     </div></div>
   <div class="v11-card-body">
    <section class="v11-potential-guideline v11-scanner-guideline"><div class="v11-potential-guideline-grid">
     <div class="v11-potential-guide v11-potential-guide--formula"><strong>Technical Score</strong><span>Combines price/SMA alignment, RSI condition and 10-session momentum.</span></div>
     <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Strong Setup</strong><span>Prefer price above SMA20, SMA20 above SMA50, constructive RSI and positive momentum.</span></div>
     <div class="v11-potential-guide v11-potential-guide--watch"><strong>Confirmation</strong><span>Verify breakout level, trading liquidity and follow-through before taking an entry.</span></div>
     <div class="v11-potential-guide v11-potential-guide--avoid"><strong>Risk Filter</strong><span>A high score is weakened by thin volume, extended price or loss of nearby support.</span></div>
    <div class="v11-potential-guide v11-potential-guide--formula"><strong>Technical Evidence</strong><span>Uses closing prices for SMA20, SMA50, RSI14 and 10-session momentum. Volume is a separate Smart Money check.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Formation Logic</strong><span>Four conditions each contribute 18 points: close above SMA20, SMA20 above SMA50, RSI 45–70 and positive momentum. Bounded price, SMA, RSI and momentum adjustments refine the 0–100 score. Signal uses condition count: 3–4 Buy, 2 Watch, 0–1 Avoid. Rows rank by Technical Score.</span></div>
  </div></section>
    <section class="v11-potential-guideline v11-technical-formation" aria-label="Technical score formation method">
     <div class="v11-potential-guideline-grid">
      <div class="v11-potential-guide v11-potential-guide--formula"><strong>Technical Score Formation</strong><span>The score is formed from price/SMA structure, RSI condition and momentum; volume is a separate confirmation check.</span></div>
      <div class="v11-potential-guide"><strong>Trend Structure</strong><span>Close above SMA20 and SMA20 above SMA50 receive stronger trend credit.</span></div>
      <div class="v11-potential-guide"><strong>Momentum &amp; RSI</strong><span>Positive momentum and a constructive RSI zone strengthen the technical setup.</span></div>
      <div class="v11-potential-guide"><strong>Volume Confirmation</strong><span>Check volume separately with Smart Money because Technical Score does not include it.</span></div>
     </div>
     <div class="v11-chip-row" style="margin-top:10px"><span class="v11-chip">Close above SMA20</span><span class="v11-chip">SMA20 above SMA50</span><span class="v11-chip">RSI 45–70</span><span class="v11-chip">Positive momentum</span></div>
     <div class="v11-note" style="margin-top:10px">These signals are mechanical summaries and should be confirmed with liquidity, support, resistance and risk controls.</div>
    </section>
    <div class="v11-scanner-table-region"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table"><thead><tr><th>Code</th><th>Close</th><th>SMA20</th><th>SMA50</th><th>RSI14</th><th>Momentum</th><th>Technical Score</th><th>Technical Signal</th></tr></thead><tbody id="v11IndicatorRows"></tbody></table></div></div>
   </div>
  </article>
 </section>

 <section class="v11-workspace" data-v11-workspace="comparison">
  <article class="v11-card v11-scanner-card">
   <div class="v11-card-head">
    <div><h3>Relative Strength Scanner</h3><small>Cross-stock ranking by return, momentum, volume participation and volatility</small></div>
    <div class="v11-potential-actions ait-scanner-toolbar">
      <div class="ait-scanner-download" data-ait-scanner-download>
       <button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span>
       </button>
       <div class="ait-scanner-download-menu" hidden>
        <button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button>
        <button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button>
       </div>
      </div>
      <button class="btn primary ait-scanner-run" id="v11RunComparison" type="button">Run</button>
      <div class="ait-scanner-charts" data-ait-scanner-charts>
       <button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span>
       </button>
       <div class="ait-scanner-charts-menu" hidden>
        <button class="btn soft" id="v11ViewComparisonCharts" type="button">3M</button>
        <button class="btn soft" id="v11ViewComparisonCharts6" type="button">6M</button>
        <button class="btn soft" id="v11ViewComparisonCharts12" type="button">1Y</button>
       </div>
      </div>
     </div>
   </div>
   <div class="v11-card-body">
    <div class="v11-summary-grid">
     <div class="v11-summary"><span>Best return</span><strong id="v11BestReturn">—</strong></div>
     <div class="v11-summary"><span>Lowest volatility</span><strong id="v11LowVol">—</strong></div>
     <div class="v11-summary"><span>Highest relative volume</span><strong id="v11HighRv">—</strong></div>
     <div class="v11-summary"><span>Strongest momentum</span><strong id="v11Momentum">—</strong></div>
    </div>
    <section class="v11-potential-guideline v11-scanner-guideline" style="margin-top:12px"><div class="v11-potential-guideline-grid">
     <div class="v11-potential-guide v11-potential-guide--formula"><strong>Relative Formula</strong><span>30% 20-day return + 25% momentum + 20% relative volume + 25% lower-volatility rank.</span></div>
     <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Leader</strong><span>Ranks strongest peers inside the currently active watch list; it is not an independent buy signal.</span></div>
     <div class="v11-potential-guide v11-potential-guide--watch"><strong>Use Case</strong><span>Use Relative Rank to choose between otherwise similar Technical and Smart Money candidates.</span></div>
     <div class="v11-potential-guide v11-potential-guide--avoid"><strong>Important Limit</strong><span>A weak stock can rank well in a weak list, so always verify its absolute Primary Score.</span></div>
    <div class="v11-potential-guide v11-potential-guide--formula"><strong>Relative Evidence</strong><span>Uses up to 20 closing prices for return and volatility, latest volume versus its 20-session average, and 10-session momentum across the active list.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Formation Logic</strong><span>Normalize factors against active-list peers. Relative Score = 30% return + 25% momentum + 20% relative volume + 25% inverse volatility. Negative return and momentum cap the score at 44.9. Rank by score, then return; Leader and Outperform also require positive price evidence.</span></div>
  </div></section>
    <div class="v11-scanner-table-region"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table"><thead><tr><th>Rank</th><th>Code</th><th>Last close</th><th>20D return</th><th>Volatility</th><th>Relative volume</th><th>Momentum</th><th>Relative Score</th><th>Relative Position</th></tr></thead><tbody id="v11ComparisonRows"></tbody></table></div></div>
   </div>
  </article>
 </section>

 <section class="v11-workspace" data-v11-workspace="portfolio">
  <div class="v11-portfolio-layout">
   <aside class="v11-card v11-portfolio-summary-card">
    <div class="v11-card-head"><div><h3>Portfolio summary</h3><small>Calculated from downloaded CloseP values</small></div></div>
    <div class="v11-card-body">
     <div class="v11-summary-grid">
      <div class="v11-summary"><span>Total cost value</span><strong id="v11PortfolioCost">0.00</strong></div>
      <div class="v11-summary"><span>Net market value</span><strong id="v11PortfolioValue">0.00</strong></div>
      <div class="v11-summary"><span>Net unrealized P/L</span><strong id="v11PortfolioPl">0.00</strong></div>
      <div class="v11-summary"><span>Portfolio P/L</span><strong id="v11PortfolioPlPercent">0.00%</strong></div>
      <div class="v11-summary"><span>Total broker commission</span><strong id="v11PortfolioCommission">0.00</strong></div>
      <div class="v11-summary"><span>Positions</span><strong id="v11PortfolioCount">0</strong></div>
     </div>
    </div>
   </aside>
   <article class="v11-card v11-portfolio-workspace-card">
    <div class="v11-card-head"><div><h3>Portfolio workspace</h3><small>Track positions locally in this browser</small></div><button class="btn primary" type="button" id="v11OpenPortfolioModal">Add position</button></div>
    <div class="v11-card-body">
     <div class="v11-table-wrap"><table class="v11-table"><thead><tr><th>Code</th><th>Quantity</th><th>Buy Price</th><th>Broker Commission</th><th>Costing Rate</th><th>Cost Value</th><th>CloseP</th><th>Net Market Value</th><th>Net P/L</th><th>% P/L</th><th>Actions</th></tr></thead><tbody id="v11PortfolioRows"></tbody></table></div>
    </div>
   </article>
  </div>
 </section>

 <section class="v11-workspace" data-v11-workspace="vpa">
  <article class="v11-card v11-scanner-card">
   <div class="v11-card-head"><div><h3>Smart Money Scanner</h3><small>VPA-based effort-versus-result, spread, volume and trend screening</small></div><div class="v11-potential-actions ait-scanner-toolbar">
      <div class="ait-scanner-download" data-ait-scanner-download>
       <button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span>
       </button>
       <div class="ait-scanner-download-menu" hidden>
        <button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button>
        <button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button>
       </div>
      </div>
      <button class="btn primary ait-scanner-run" id="v11RunVpa" type="button">Run</button>
      <div class="ait-scanner-charts" data-ait-scanner-charts>
       <button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span>
       </button>
       <div class="ait-scanner-charts-menu" hidden>
        <button class="btn soft" id="v11ViewVpaCharts" type="button">3M</button>
        <button class="btn soft" id="v11ViewVpaCharts6" type="button">6M</button>
        <button class="btn soft" id="v11ViewVpaCharts12" type="button">1Y</button>
       </div>
      </div>
     </div></div>
   <div class="v11-card-body">
    <section class="v11-potential-guideline v11-scanner-guideline"><div class="v11-potential-guideline-grid">
     <div class="v11-potential-guide v11-potential-guide--formula"><strong>Smart Money Score</strong><span>Summarizes price spread, relative volume, trend and effort-versus-result from local OHLCV history.</span></div>
     <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Accumulation Clues</strong><span>Look for constructive closes, expanding demand and efficient upward result without excessive volatility.</span></div>
     <div class="v11-potential-guide v11-potential-guide--watch"><strong>Confirmation</strong><span>Confirm the VPA classification with support holding, improving relative volume and later price follow-through.</span></div>
     <div class="v11-potential-guide v11-potential-guide--avoid"><strong>Interpret Carefully</strong><span>VPA is a heuristic; one high-volume bar does not prove institutional accumulation.</span></div>
    <div class="v11-potential-guide v11-potential-guide--formula"><strong>Smart Money Evidence</strong><span>Requires at least 10 OHLCV records. Compares the latest bar with up to 20 records for spread, volume and trend, plus the previous close for price movement.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Formation Logic</strong><span>Start at 50. Add 12 for an uptrend, otherwise subtract 10. Add 14 for high volume with a strong close, subtract 8 for very high volume with little price movement, add 8 for a wide spread with a strong close, and subtract 10 for a weak close. Clamp to 0–100: 75+ Buy, 55–74 Watch, below 55 Avoid.</span></div>
  </div></section>
    <div class="v11-scanner-table-region"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table"><thead><tr><th>Code</th><th>Smart Money Score</th><th>Spread</th><th>Rel. volume</th><th>Trend</th><th>Effort/result</th><th>Classification</th></tr></thead><tbody id="v11VpaRows"></tbody></table></div></div>
   </div>
  </article>
 </section>

 <section class="v11-workspace" data-v11-workspace="potential-composite">
  <article class="v11-card v11-scanner-card">
   <div class="v11-card-head"><div><h3>AIT Composite Screener</h3><small>Weighted multi-factor screening across technical, smart-money and relative-strength evidence</small></div><div class="v11-potential-actions ait-scanner-toolbar">
      <div class="ait-scanner-download" data-ait-scanner-download>
       <button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span>
       </button>
       <div class="ait-scanner-download-menu" hidden>
        <button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button>
        <button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button>
       </div>
      </div>
      <button class="btn primary ait-scanner-run" id="v11RunComposite" type="button">Run</button>
      <div class="ait-scanner-charts" data-ait-scanner-charts>
       <button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span>
       </button>
       <div class="ait-scanner-charts-menu" hidden>
        <button class="btn soft" id="v11ViewCompositeCharts" type="button">3M</button>
        <button class="btn soft" id="v11ViewCompositeCharts6" type="button">6M</button>
        <button class="btn soft" id="v11ViewCompositeCharts12" type="button">1Y</button>
       </div>
      </div>
     </div></div>
   <div class="v11-card-body">
    <section class="v11-potential-guideline"><div class="v11-potential-guideline-grid">
     <div class="v11-potential-guide v11-potential-guide--formula"><strong>Composite Formula</strong><span>Combined Score = 40% Technical + 35% Smart Money + 25% Relative Strength.</span></div>
     <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Purpose</strong><span>Use when you want all three analytical layers to contribute directly to one score.</span></div>
     <div class="v11-potential-guide v11-potential-guide--watch"><strong>Ranking</strong><span>Rows are ordered by Combined Score, then Smart Money and Technical confirmation.</span></div>
     <div class="v11-potential-guide v11-potential-guide--avoid"><strong>Safeguard</strong><span>Weak Technical and Smart Money evidence cannot become Strong Buy from relative ranking alone.</span></div>
    <div class="v11-potential-guide v11-potential-guide--formula"><strong>Composite Evidence</strong><span>Uses the latest Technical, Smart Money and Relative Strength scores, each with its own underlying lookback.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Formation Logic</strong><span>Combined Score = 40% Technical + 35% Smart Money + 25% Relative Strength. Strong Buy requires 75+ and both Technical and Smart Money at least 60; otherwise 62+ Buy, 48+ Watch, below 48 Avoid. Rank by Combined Score, then Smart Money and Technical.</span></div>
  </div></section>
    <div class="v11-scanner-table-region"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Rank</th><th>Trading Code</th><th>LTP</th><th>Technical</th><th>Smart Money</th><th>Relative</th><th>Combined Score</th><th>Strength</th><th>Signal</th></tr></thead><tbody id="v11CompositeRows"></tbody></table></div></div>
   </div>
  </article>
 </section>

 <section class="v11-workspace" data-v11-workspace="potential">
  <article class="v11-card v11-scanner-card">
   <div class="v11-card-head"><div><h3>AIT Elite Screener</h3><small>Balanced 50/50 primary scoring with relative-strength tie-breaking</small></div><div class="v11-potential-actions ait-scanner-toolbar">
      <div class="ait-scanner-download" data-ait-scanner-download>
       <button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span>
       </button>
       <div class="ait-scanner-download-menu" hidden>
        <button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button>
        <button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button>
       </div>
      </div>
      <button class="btn primary ait-scanner-run" id="v11RunPotential" type="button">Run</button>
      <div class="ait-scanner-charts" data-ait-scanner-charts>
       <button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span>
       </button>
       <div class="ait-scanner-charts-menu" hidden>
        <button class="btn soft" id="v11ViewPotentialCharts" type="button">3M</button>
        <button class="btn soft" id="v11ViewPotentialCharts6" type="button">6M</button>
        <button class="btn soft" id="v11ViewPotentialCharts12" type="button">1Y</button>
       </div>
      </div>
     </div></div>
   <div class="v11-card-body">
    <section class="v11-potential-guideline" aria-labelledby="v11PotentialGuidelineTitle"><div class="v11-potential-guideline-head"><div><h4 id="v11PotentialGuidelineTitle">Elite Screening Guideline</h4><p>Use this as the balanced flagship shortlist, then verify price action, liquidity, support and risk.</p></div></div><div class="v11-potential-guideline-grid">
     <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Strong Buy · 75–100</strong><span>The balanced Primary Score is strong and both Technical and Smart Money scores confirm it.</span></div>
     <div class="v11-potential-guide v11-potential-guide--watch"><strong>Buy / Watch · 48–74.99</strong><span>Buy begins at 62; 48–61.99 remains a developing Watch setup.</span></div>
     <div class="v11-potential-guide v11-potential-guide--avoid"><strong>Avoid · Below 48</strong><span>Relative Strength cannot upgrade a weak Primary Signal.</span></div>
     <div class="v11-potential-guide v11-potential-guide--formula"><strong>Elite Formula</strong><span>Primary Score = 50% Technical + 50% Smart Money. Relative Strength breaks ties within a 5-point Primary Score range.</span></div>
    <div class="v11-potential-guide v11-potential-guide--formula"><strong>Elite Screening Evidence</strong><span>Uses the latest Technical and Smart Money scores for absolute setup strength; active-list Relative Strength orders close scores.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Formation Logic</strong><span>Primary Score = 50% Technical + 50% Smart Money. Strong Buy requires 75+ with both components at least 60; otherwise 62+ Buy, 48+ Watch, below 48 Avoid. Relative Strength reorders groups less than 5 Primary points below their group leader without changing the signal.</span></div>
  </div></section>
    <div class="v11-scanner-table-region"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Rank</th><th>Trading Code</th><th>LTP</th><th>Technical</th><th>Smart Money</th><th>Primary Score</th><th>Relative Rank</th><th>Strength</th><th>Signal</th></tr></thead><tbody id="v11PotentialRows"></tbody></table></div></div>
   </div>
  </article>
 </section>

 <section class="v11-workspace" data-v11-workspace="elite-regime">
  <article class="v11-card v11-scanner-card">
   <div class="v11-card-head"><div><h3>AIT Elite Regime</h3><small>Regime-aware Elite scanner — adapts the calibrated Elite setup to Bull, Sideways and Bear market conditions.</small></div><div class="v11-potential-actions ait-scanner-toolbar"><div class="ait-scanner-download" data-ait-scanner-download><button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false"><span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span></button><div class="ait-scanner-download-menu" hidden><button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button><button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button></div></div><button class="btn primary ait-scanner-run" id="v11RunEliteRegime" type="button">Run</button><button class="btn soft" id="aitEliteRegimePerformance" data-ait-psa-open="aitEliteRegimePerformanceModal" type="button">Performance</button><div class="ait-scanner-charts" data-ait-scanner-charts><button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false"><span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span></button><div class="ait-scanner-charts-menu" hidden><button class="btn soft" id="aitEliteRegimeCharts3" type="button">3M</button><button class="btn soft" id="aitEliteRegimeCharts6" type="button">6M</button><button class="btn soft" id="aitEliteRegimeCharts12" type="button">1Y</button></div></div></div></div>
   <div class="v11-card-body">
    <section class="v11-potential-guideline"><div class="v11-potential-guideline-grid">
     <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Regime Detection</strong><span>Classifies the current market as Bull, Sideways or Bear using equal-weight universe trend, breadth and recent market return.</span></div>
     <div class="v11-potential-guide v11-potential-guide--formula"><strong>Regime Adjustment</strong><span>The original AIT Elite score remains the foundation. Regime compatibility adjusts conviction; it never turns weak evidence into a Strong Buy.</span></div>
     <div class="v11-potential-guide v11-potential-guide--watch"><strong>Risk Awareness</strong><span>Bear regimes require stronger setup evidence and reduce aggressive entry confidence.</span></div>
     <div class="v11-potential-guide v11-potential-guide--formula"><strong>Action Guide</strong><span>BUY NOW = actionable now. CONFIRMATION = wait for price/volume/regime confirmation before entry. WATCH = monitor. AVOID = do not enter.</span></div>
     <div class="v11-potential-guide v11-potential-guide--avoid"><strong>Purpose</strong><span>This is a separate experimental/diagnostic scanner beside AIT Elite, not a replacement for the original v4.4 scanner.</span></div>
    <div class="v11-potential-guide v11-potential-guide--formula"><strong>9D Regime Evidence</strong><span>Uses the 9D Elite setup plus current market breadth and return. Regime trend averages up to 20 trading dates across the active list.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Formation Logic</strong><span>Start with the 9D Elite Score. Bull adds 4 for Strong Buy or 2 otherwise; Sideways adds 0 for Strong Buy or subtracts 1 otherwise; Bear subtracts 7 for Strong Buy, 5 for Buy or 2 otherwise. Clamp to 0–100. The underlying signal, adjusted score and regime fit determine the action. This workspace orders actions first, then Regime Score and Elite Score.</span></div>
  </div></section>
    <div class="v105-metric-grid" style="margin-top:14px">
     <div class="v105-metric"><span>Market Regime</span><strong id="aitEliteRegimeLabel">—</strong><em>current classification</em></div>
     <div class="v105-metric"><span>Regime Confidence</span><strong id="aitEliteRegimeConfidence">—</strong><em>breadth + trend evidence</em></div>
     <div class="v105-metric"><span>Market Return</span><strong id="aitEliteRegimeReturn">—</strong><em>recent equal-weight universe</em></div>
     <div class="v105-metric"><span>Market Breadth</span><strong id="aitEliteRegimeBreadth">—</strong><em>stocks above short trend</em></div>
    </div>
    <div class="v11-scanner-table-region" style="margin-top:14px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Priority</th><th>Trading Code</th><th>LTP</th><th>What to Do</th><th>When</th><th>Setup Signal</th><th>Regime</th><th>Regime Score</th><th>Why</th><th>Details</th></tr></thead><tbody id="aitEliteRegimeRows"><tr><td colspan="10">Run AIT Elite Regime to calculate the regime-aware shortlist.</td></tr></tbody></table></div></div>
   </div>
  </article>
 </section>

 <section class="v11-workspace" data-v11-workspace="potential-priority">
  <article class="v11-card v11-scanner-card">
   <div class="v11-card-head"><div><h3>AIT Signal Priority Screener</h3><small>Signal-first screening that keeps every Strong Buy above Buy, Watch and Avoid</small></div><div class="v11-potential-actions ait-scanner-toolbar">
      <div class="ait-scanner-download" data-ait-scanner-download>
       <button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span>
       </button>
       <div class="ait-scanner-download-menu" hidden>
        <button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button>
        <button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button>
       </div>
      </div>
      <button class="btn primary ait-scanner-run" id="v11RunPriority" type="button">Run</button>
      <div class="ait-scanner-charts" data-ait-scanner-charts>
       <button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span>
       </button>
       <div class="ait-scanner-charts-menu" hidden>
        <button class="btn soft" id="v11ViewPriorityCharts" type="button">3M</button>
        <button class="btn soft" id="v11ViewPriorityCharts6" type="button">6M</button>
        <button class="btn soft" id="v11ViewPriorityCharts12" type="button">1Y</button>
       </div>
      </div>
     </div></div>
   <div class="v11-card-body">
    <section class="v11-potential-guideline"><div class="v11-potential-guideline-grid">
     <div class="v11-potential-guide v11-potential-guide--strongest"><strong>First Priority</strong><span>Signal order: Strong Buy → Buy → Watch → Avoid.</span></div>
     <div class="v11-potential-guide v11-potential-guide--formula"><strong>Primary Formula</strong><span>Primary Score = 50% Technical + 50% Smart Money.</span></div>
     <div class="v11-potential-guide v11-potential-guide--watch"><strong>Within Each Signal</strong><span>Primary Score ranks first; Relative Strength breaks close ties within 5 points.</span></div>
     <div class="v11-potential-guide v11-potential-guide--avoid"><strong>Stable Order</strong><span>Relative Strength can never move a Buy above a Strong Buy or upgrade the signal.</span></div>
    <div class="v11-potential-guide v11-potential-guide--formula"><strong>Latest Evidence</strong><span>Uses the latest Primary Score and signal from Technical and Smart Money, plus active-list Relative Strength.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Formation Logic</strong><span>Primary Score = 50% Technical + 50% Smart Money. Assign Strong Buy at 75+ with both components at least 60, otherwise Buy at 62+, Watch at 48+, or Avoid. Group Strong Buy → Buy → Watch → Avoid; rank within each signal by Primary Score with Relative Strength ordering close scores.</span></div>
  </div></section>
    <div class="v11-scanner-table-region"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Overall Rank</th><th>Signal Rank</th><th>Trading Code</th><th>LTP</th><th>Technical</th><th>Smart Money</th><th>Primary Score</th><th>Relative Rank</th><th>Signal</th></tr></thead><tbody id="v11PriorityRows"></tbody></table></div></div>
   </div>
  </article>
 </section>

 <section class="v11-workspace" data-v11-workspace="explorer">
  <div class="v11-explorer">
   <aside class="v11-card">
    <div class="v11-card-head"><div><h3>Watch-list explorer</h3><small>Search local symbols</small></div></div>
    <div class="v11-card-body">
     <label>Search<input id="v11ExplorerSearch" type="search" placeholder="ROBI, ALIF, SUMITPOWER…"></label>
     <div class="v11-chip-row" id="v11ExplorerLists"></div>
    </div>
   </aside>
   <article class="v11-card">
    <div class="v11-card-head"><div><h3>Available securities</h3><small>Symbols discovered from local history and watch lists</small></div></div>
    <div class="v11-card-body"><div class="v11-search-results" id="v11ExplorerResults"></div></div>
   </article>
  </div>
 </section>

 <section class="v11-workspace" data-v11-workspace="reports">
  <article class="v11-card">
   <div class="v11-card-head"><div><h3>Report center</h3><small>Generate local summaries from downloaded data</small></div></div>
   <div class="v11-card-body">
    <div class="v11-report-list">
     <div class="v11-report-item"><div class="v11-report-icon">▤</div><div><strong>DSE news report</strong><p>Categorized announcements and news-day closing prices for the active watch list.</p></div><button class="btn soft" type="button" data-ait-news-open="report">Open news</button></div>
     <div class="v11-report-item"><div class="v11-report-icon">▤</div><div><strong>Active watch-list report</strong><p>Codes, last close, records and coverage.</p></div><button class="btn soft" type="button" data-v11-report="watchlist">Generate</button></div>
     <div class="v11-report-item"><div class="v11-report-icon">⌁</div><div><strong>Technical scanner report</strong><p>SMA, RSI, momentum and signals.</p></div><button class="btn soft" type="button" data-v11-report="technical">Generate</button></div>
     <div class="v11-report-item"><div class="v11-report-icon">◫</div><div><strong>Comparison report</strong><p>Returns, volatility and relative volume.</p></div><button class="btn soft" type="button" data-v11-report="comparison">Generate</button></div>
     <div class="v11-report-item"><div class="v11-report-icon">◆</div><div><strong>Portfolio report</strong><p>Cost, market value and unrealized result.</p></div><button class="btn soft" type="button" data-v11-report="portfolio">Generate</button></div>
    </div>
    <textarea id="v11ReportOutput" rows="14" style="margin-top:10px" placeholder="Generated report will appear here…"></textarea>
    <div class="v11-inline" style="margin-top:8px"><button class="btn primary" type="button" id="v11DownloadReport">Download report</button><button class="btn soft" type="button" id="v11ClearReport">Clear</button></div>
   </div>
  </article>
 </section>
</section>
<section class="v105-dashboard" id="v105Dashboard">
 <div class="v105-hero">
  <div class="v105-hero-grid">
   <div>
    <div class="v105-brand-line">
     <h2>AIT - PSA</h2>
     <span class="v105-inline-ready"><i></i> Local Terminal Ready</span>
    </div>
    <p>Professional Stock Analyzer</p>
   </div>
   <div class="v105-health">
    <div class="v105-health-item"><span>Downloader</span><strong id="v105DownloaderHealth">Ready</strong></div>
    <div class="v105-health-item"><span>Local storage</span><strong id="v105StorageHealth">Available</strong></div>
    <div class="v105-health-item"><span>Active workspace</span><strong id="v105WorkspaceName">Trading</strong></div>
    <div class="v105-health-item"><span>Last activity</span><strong id="v105LastActivity">Waiting</strong></div>
   </div>
  </div>
 </div>

 <div class="v105-dashboard-grid">
  <article class="v105-panel">
   <div class="v105-panel-head">
    <div><h3>Live terminal metrics</h3><small>Automatically refreshed from local data</small></div>
    <span class="v105-queue-badge">LIVE</span>
   </div>
   <div class="v105-panel-body">
    <div class="v105-metric-grid">
     <div class="v105-metric"><span>Watch lists</span><strong id="v105ListCount">0</strong><em>Permanent local groups</em></div>
     <div class="v105-metric"><span>Tracked codes</span><strong id="v105CodeCount">0</strong><em>Active list securities</em></div>
     <div class="v105-metric"><span>Stored records</span><strong id="v105RecordCount">0</strong><em>OHLC observations</em></div>
     <div class="v105-metric"><span>Covered symbols</span><strong id="v105SymbolCount">0</strong><em>With local history</em></div>
    </div>
   </div>
  </article>

  <article class="v105-panel">
   <div class="v105-panel-head">
    <div><h3>Download queue</h3><small>Current and recent archive jobs</small></div>
    <span class="ait-psa-panel-meta">SESSION</span>
   </div>
   <div class="v105-panel-body">
    <div class="v105-list" id="v105QueueList">
     <div class="v105-empty">No archive job has started in this session.</div>
    </div>
   </div>
  </article>

  <article class="v105-panel">
   <div class="v105-panel-head">
    <div><h3>Recent activity</h3><small>Actions performed in this terminal</small></div>
    <span class="ait-psa-panel-meta">LATEST</span>
   </div>
   <div class="v105-panel-body">
    <div class="v105-list" id="v105ActivityList">
     <div class="v105-empty">Your recent actions will appear here.</div>
    </div>
   </div>
  </article>
 </div>
</section>


<div class="app">
<header><div><span class="ait-psa-section-kicker">MARKET COVERAGE</span><h1>Data Summary</h1><p>Live totals derived from your locally stored DSE directory, watch lists, and OHLC archive.</p></div><div class="badge"><strong id="lastArchive">Never</strong><span>Last archive import</span></div></header>
<section class="stats" id="overviewWorkspace">
 <div class="card stat"><label>DSE Trading Codes</label><strong id="sMother">0</strong></div>
 <div class="card stat"><label>Watch Lists</label><strong id="sLists">0</strong></div>
 <div class="card stat"><label>Historical Symbols</label><strong id="sHistory">0</strong></div>
 <div class="card stat"><label>OHLC Records</label><strong id="sRecords">0</strong></div>
</section>
<div class="layout">
<aside class="card sidebar">
 <div class="row"><div><h2>Watch Lists</h2><span class="small">Manage stock groups</span></div><button class="btn primary icon" id="newList">+</button></div>
 <div class="lists" id="lists"></div>
 <hr style="border:0;border-top:1px solid var(--line);margin:16px 0">
 <div class="row"><h3>Activity</h3><button class="btn soft" id="clearActivity">Clear</button></div><div class="activity" id="activity"></div>
</aside>
<main class="main">
<section id="downloadWorkspace" class="v1116-download-workspace">
 <div class="v1116-download-actions">
  <div class="v1116-download-intro">
   <span class="v1116-download-kicker">DATA OPERATIONS</span>
   <h3>Data Center</h3>
   <p>Import, synchronize, download, inspect, back up, and restore terminal data.</p>
  </div>

  <div class="v1116-download-action-grid">
   <button class="v1116-action-card" type="button" data-v1116-action="motherImport">
    <span class="v1116-action-icon">DSE</span>
    <span><strong>Import DSE Codes</strong><small>Import or replace the complete trading-code directory</small></span>
   </button>
   <button class="v1116-action-card" type="button" data-v1116-action="quickMotherSync">
    <span class="v1116-action-icon">↻</span>
    <span><strong>Sync DSE Codes</strong><small>Refresh the latest available DSE code list</small></span>
   </button>
   <button class="v1116-action-card" type="button" data-v1116-action="archiveImport">
    <span class="v1116-action-icon">OHLC</span>
    <span><strong>Import OHLC Archive</strong><small>Load historical market records from files, text, or URL</small></span>
   </button>
   <button class="v1116-action-card" type="button" data-v1116-action="downloadFundamentals">
    <span class="v1116-action-icon">FN</span>
    <span><strong>Download Fundamentals</strong><small>Download DSE Category, Business Segment and Last AGM for the current watch list</small></span>
   </button>
   <button class="v1116-action-card" type="button" data-v1116-action="instantDseUpdate">
    <span class="v1116-action-icon">LIVE</span>
    <span><strong>Instant Hybrid OHLC Download</strong><small>Available 10:00 AM–2:10 PM only when today’s official archive row is absent; merges AmarStock OpenP + DSE live data</small></span>
   </button>
   <button class="v1116-action-card" type="button" data-v1116-action="dse3mUpdate">
    <span class="v1116-action-icon">3M</span>
    <span><strong>Download DSE 3M</strong><small>Download active watch-list history and open charts</small></span>
   </button>
   <button class="v1116-action-card" type="button" data-v1116-action="viewListCharts">
    <span class="v1116-action-icon">▥</span>
    <span><strong>View Saved Charts</strong><small>Open saved three-month charts for the active list</small></span>
   </button>
   <button class="v1116-action-card" type="button" data-v1116-action="viewDownloadedData">
    <span class="v1116-action-icon">⌗</span>
    <span><strong>View Downloaded Data</strong><small>Inspect stored OHLC records in a data table</small></span>
   </button>
   <button class="v1116-action-card" type="button" data-v1116-action="exportBtn">
    <span class="v1116-action-icon">⇩</span>
    <span><strong>Backup Dashboard</strong><small>Export dashboard, market history, settings, and portfolio positions</small></span>
   </button>
   <button class="v1116-action-card" type="button" data-v1116-action="importBtn">
    <span class="v1116-action-icon">⇧</span>
    <span><strong>Restore Dashboard</strong><small>Restore a complete or legacy dashboard backup, including portfolio data</small></span>
   </button>
  </div>
 </div>
 <section class="card ait-download-status-panel" id="downloadStatusCard" data-v10-workspace="downloadWorkspace" style="display:none;margin-bottom:14px">
 <div class="row ait-download-status-layout">
  <div class="ait-download-status-orb" aria-hidden="true"><span>⇩</span></div>
  <div class="ait-download-status-main">
   <div class="ait-download-status-head">
    <div><small class="ait-download-status-kicker">LIVE DOWNLOAD STATUS</small><strong id="downloadStatusTitle">Preparing download</strong></div>
    <span class="small ait-download-status-percent" id="downloadStatusPercent">0%</span>
   </div>
   <div class="ait-download-status-track">
    <div id="downloadStatusBar" class="ait-download-status-bar" style="width:0%"></div>
   </div>
   <div class="small ait-download-status-text" id="downloadStatusText">Waiting to start…</div>
   <div class="ait-download-timing" id="downloadTiming" aria-live="polite">
    <div class="ait-download-time-card"><span>Time passed</span><strong id="downloadElapsedTime">00:00</strong><small id="downloadStartedAt">Not started</small></div>
    <div class="ait-download-time-card"><span>Approx. remaining</span><strong id="downloadEtaTime">Estimating…</strong><small id="downloadEtaFinish">Waiting for progress</small></div>
   </div>
  </div>
  <button class="btn soft" type="button" id="hideDownloadStatus">Hide</button>
 </div>
</section>
</section>

<section class="card toolbar v10-original-toolbar">
 <button
  type="button"
  id="v1118ThemeMenuAction"
  class="btn soft"
  aria-label="Theme Selection"
  title="Choose terminal theme">
  Theme Selection
 </button>

 <input class="input search" id="search" placeholder="Search trading codes...">
 <button class="btn primary" id="motherImport">Import DSE Trading Codes</button>
 <button class="btn blue" id="quickMotherSync">Sync DSE Trading Codes</button>
 <button class="btn blue" id="archiveImport">Import OHLC Archive</button>
 <button class="btn primary" id="downloadFundamentals">Download DSE Fundamentals</button><button class="btn primary" id="amarstockFundamentals" hidden>Download AmarStock Fundamentals</button>
 <button class="btn primary" id="instantDseUpdate">Instant Hybrid OHLC Download</button>
 <button class="btn primary" id="dse3mUpdate">Download DSE 3M</button>
 <button class="btn primary" id="dse6mUpdate">Download DSE 6M</button><button class="btn soft" id="incrementalOhlcDownload" type="button" hidden>Incremental OHLC Download</button><button class="btn soft" id="forceFullOhlc3M" type="button" hidden>Force Full OHLC 3M</button><button class="btn soft" id="forceFullOhlcDownload" type="button" hidden>Force Full OHLC 6M</button><button class="btn soft" id="forceFullOhlc1Y" type="button" hidden>Force Full OHLC 1Y</button>
 <button class="btn primary" id="viewListCharts">View Saved 3M Charts</button>
 <button class="btn primary" id="viewListCharts6">View Saved 6M Charts</button><button class="btn primary" id="viewListCharts12">View Saved 1Y Charts</button>
 <button class="btn soft" id="viewDownloadedData">View Downloaded Data</button>
 <button class="btn soft" id="emptyDownloadedData" type="button" hidden>Empty Downloaded Data</button>
 <button class="btn soft" id="exportBtn">Backup Dashboard</button>
 <button class="btn soft" id="importBtn">Restore Dashboard</button>
 <span class="small" id="saveStatus" style="align-self:center">Permanent autosave enabled</span>
 <input type="file" id="dashboardFile" accept=".json" hidden>
</section>
<div class="panels" id="marketWorkspace">
 <div class="v1116-search-first-row">
  <div class="v1114-code-search-shell">
 <div class="v1114-search-orb" aria-hidden="true">⌕</div>
 <div class="v1114-search-copy">
  <span class="v1114-search-kicker">DSE MARKET DIRECTORY</span>
  <label for="watchCodeSearch">Search Trading Code</label>
  <small>Instantly filter the DSE Trading Code List and Active Watch List</small>
 </div>
 <div class="v1114-search-field-wrap">
  <span class="v1114-search-icon" aria-hidden="true">⌕</span>
  <input class="input v1114-search-input" id="watchCodeSearch" type="search"
         autocomplete="off" spellcheck="false"
         placeholder="Search ROBI, ALIF, SUMITPOWER…">
  <kbd class="v1114-search-key">/</kbd>
 </div>
 <button class="btn soft v1114-search-clear" id="clearWatchCodeSearch" type="button">
  Clear
 </button>
 <div class="v1114-watch-search-status" id="watchCodeSearchStatus"></div>
</div>
 </div>

 <section class="card panel">
  <div class="head"><div><h2>DSE Trading Code List</h2><span class="small" id="motherMeta">Import the DSE trading-code list first.</span></div></div>
  <div class="scroll" id="mother"></div>
 </section>
 <section class="card panel">
  <div class="head">
   <div><h2 id="watchTitle">Active Watch List</h2><span class="small" id="watchMeta"></span></div>
   <div class="actions ait-watch-header-actions">
     <div class="v10-menu ait-watch-action-menu">
      <button class="btn v10-menu-trigger" type="button"><span>⇩ Download</span><span>⌄</span></button>
      <div class="v10-menu-panel">
       <button class="btn blue" id="dse3mUpdate2" type="button">3M</button>
       <button class="btn blue" id="dse6mUpdate2" type="button">6M</button>
       <button class="btn blue" id="dse1yUpdate2" type="button">1Y</button>
      </div>
     </div>
     <div class="v10-menu ait-watch-action-menu align-right">
      <button class="btn v10-menu-trigger primary-menu" type="button"><span>◫ Charts</span><span>⌄</span></button>
      <div class="v10-menu-panel">
       <button class="btn primary" id="viewListCharts2" type="button">3M</button>
       <button class="btn primary" id="viewListCharts6_2" type="button">6M</button>
       <button class="btn primary" id="viewListCharts12_2" type="button">1Y</button>
      </div>
     </div>
    </div>
  </div>
  <div class="scroll" id="watch"></div>
 </section>
</div>
</main>
</div>
</div>

<div class="modal v11-portfolio-position-modal" id="v11PortfolioModal" role="dialog" aria-modal="true" aria-labelledby="v11PortfolioModalTitle">
 <div class="dialog">
  <div class="modal-head"><div><h2 id="v11PortfolioModalTitle">Add portfolio position</h2><div class="small">Enter position details and broker commission.</div></div><button class="btn soft icon" type="button" id="v11ClosePortfolioModal" aria-label="Close">×</button></div>
  <div class="v11-portfolio-form">
   <label>Code<select id="v11PortfolioCode"></select></label>
   <label>Quantity<input id="v11PortfolioQty" type="number" min="0" step="1"></label>
   <label>Buy price<input id="v11PortfolioBuy" type="number" min="0" step="0.01"></label>
   <label>Broker commission (%)<input id="v11PortfolioCommissionRate" type="number" min="0" max="100" step="0.01" value="0.4"></label>
  </div>
  <div class="form-actions"><button class="btn soft" type="button" id="v11CancelPositionEdit">Cancel</button><button class="btn primary" type="button" id="v11AddPosition">Add position</button></div>
 </div>
</div>

<div class="modal" id="listModal"><div class="dialog"><div class="modal-head"><h2 id="listModalTitle">Create Watch List</h2><button class="btn soft icon" data-close="listModal">×</button></div><form class="form" id="listForm"><div class="field"><label>Watch-list name</label><input class="input" style="width:100%" id="listName" required maxlength="60"></div><div class="form-actions"><button type="button" class="btn soft" data-close="listModal">Cancel</button><button class="btn primary">Save</button></div></form></div></div>


<div class="modal" id="motherModal"><div class="dialog">
 <div class="modal-head">
  <div><h2>Import DSE Trading Codes</h2><div class="small">Import the complete listed-security directory from DSE data</div></div>
  <button class="btn soft icon" data-close="motherModal">×</button>
 </div>
 <div class="tabs" data-tab-group="mother">
  <button class="tab active" data-mother-tab="url">DSE Website</button>
  <button class="tab" data-mother-tab="file">Downloaded File</button>
  <button class="tab" data-mother-tab="paste">Paste Table</button>
 </div>

 <div class="tab-panel active" data-mother-panel="url">
  <div class="field">
   <label>Public DSE-list source</label>
   <select class="select" style="width:100%" id="motherSourceSelect">
    <option value="https://staticv2.amarstock.com/latest-share-price">AmarStock Latest Share Price</option>
    <option value="https://www.dsebd.org/latest_share_price_scroll_l.php">DSE Latest Share Price</option>
    <option value="custom">Custom URL</option>
   </select>
  </div>
  <div class="field" style="margin-top:9px">
   <label>Source URL</label>
   <input class="input" style="width:100%" id="motherUrl" value="https://staticv2.amarstock.com/latest-share-price">
  </div>
  <div class="field" style="margin-top:10px">
   <label class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="autoMotherSync" checked>
    <span class="form-check-label">Automatically refresh once daily when this dashboard opens</span>
   </label>
  </div>
  <div class="note" style="margin-top:9px">
   The dashboard first tries a direct browser request. Website CORS rules may block it even though the page opens normally. Your permanent watch lists are never replaced or deleted by DSE-list synchronization.
  </div>
  <div class="form-actions">
   <button class="btn soft" type="button" id="openMotherSource">Open Source Page</button>
   <button class="btn blue" type="button" id="fetchMother">Fetch Trading Codes</button>
  </div>
 </div>

 <div class="tab-panel" data-mother-panel="file">
  <div class="field">
   <label>DSE HTML, CSV, TSV or text file</label>
   <input class="input" style="width:100%" type="file" id="motherFiles" multiple accept=".html,.htm,.csv,.tsv,.txt">
  </div>
  <div class="note" style="margin-top:9px">
   You may select several downloaded pages. The parser extracts unique trading codes and ignores headings and price columns.
  </div>
  <div class="form-actions"><button class="btn blue" type="button" id="parseMotherFiles">Parse Files</button></div>
 </div>

 <div class="tab-panel" data-mother-panel="paste">
  <div class="field">
   <label>Copied DSE table or trading-code list</label>
   <textarea class="textarea" id="motherPaste" placeholder="Paste the DSE market table, CSV rows, or one trading code per line..."></textarea>
  </div>
  <div class="form-actions"><button class="btn blue" type="button" id="parseMotherPaste">Parse Pasted Codes</button></div>
 </div>

 <div id="motherResult" class="note" style="display:none;margin-top:11px"></div>
 <div class="form-actions" id="motherCommitArea" style="display:none">
  <button class="btn soft" type="button" id="mergeMother">Merge Codes</button>
  <button class="btn primary" type="button" id="replaceMother">Replace DSE Trading Code List</button>
 </div>
</div></div>

<div class="modal" id="archiveModal"><div class="dialog">
 <div class="modal-head"><div><h2>Import Historical OHLC Archive</h2><div class="small">Supports combined files or one file per trading code</div></div><button class="btn soft icon" data-close="archiveModal">×</button></div>
 <div class="note success-note" style="margin-bottom:12px">
  <strong>Recommended archive workflow:</strong> open AmarStock Data Download, choose Adjusted or Unadjusted and a date, download the CSV, then import it here. AmarStock does not currently expose a documented permanent historical-download URL that a standalone HTML page can safely call.
  <div style="margin-top:9px"><a class="btn primary link-btn" href="https://www.amarstock.com/csv-data-download" target="_blank" rel="noopener">Open AmarStock CSV Download</a></div>
 </div>
 <div class="card" style="margin-bottom:12px;padding:12px">
  <div class="row" style="align-items:flex-end">
   <div class="field" style="flex:1;min-width:160px">
    <label>DSE start date</label>
    <input class="input" type="date" id="dseStartDate">
   </div>
   <div class="field" style="flex:1;min-width:160px">
    <label>DSE end date</label>
    <input class="input" type="date" id="dseEndDate">
   </div>
   <button class="btn blue" type="button" id="fetchDseRange">Download DSE Range</button>
   <button class="btn soft" type="button" id="downloadDseCsv">Download CSV</button>
  </div>
  <div class="small" style="margin-top:8px">
   The market-data service downloads the DSE archive, normalizes OHLC records, and returns them to this dashboard.
  </div>
 </div>
 <div class="tabs"><button class="tab active" data-tab="files">Archive Files</button><button class="tab" data-tab="paste">Paste Data</button><button class="tab" data-tab="url">Archive URL</button></div>
 <div class="tab-panel active" data-panel="files">
  <div class="field"><label>DSE/AmarStock CSV, TSV, TXT or HTML files</label><input class="input" style="width:100%" type="file" id="ohlcFiles" multiple accept=".csv,.tsv,.txt,.html,.htm"></div>
  <div class="note" style="margin-top:9px">For separate files, name each file with its trading code, such as SUMITPOWER.csv. Combined files should contain columns similar to Code, Date, Open, High, Low, Close, Volume.</div>
  <div class="form-actions"><button class="btn blue" type="button" id="parseFiles">Parse Files</button></div>
 </div>
 <div class="tab-panel" data-panel="paste">
  <div class="field"><label>Paste archive rows</label><textarea class="textarea" id="pasteOhlc" placeholder="CODE,DATE,OPEN,HIGH,LOW,CLOSE,VOLUME&#10;SUMITPOWER,2026-07-01,17.1,17.5,16.8,17.0,245000"></textarea></div>
  <div class="form-actions"><button class="btn blue" type="button" id="parsePaste">Parse Pasted Data</button></div>
 </div>
 <div class="tab-panel" data-panel="url">
  <div class="field"><label>Public CSV/HTML archive URL</label><input class="input" style="width:100%" id="archiveUrl" placeholder="https://..."></div>
  <div class="field" style="margin-top:9px"><label>Trading code when the URL contains only one security</label><input class="input" style="width:100%" id="urlCode" placeholder="Example: SUMITPOWER"></div>
  <div class="note" style="margin-top:9px">Direct browser download works only when the archive website allows CORS and does not require AmarStock login. Otherwise download the file manually and use Archive Files.</div>
  <div class="form-actions"><button class="btn blue" type="button" id="fetchUrl">Download and Parse</button></div>
 </div>
 <div id="parseResult" class="note" style="display:none;margin-top:11px"></div>
 <div class="form-actions" id="commitArea" style="display:none"><button class="btn soft" type="button" id="mergeHistory">Merge Data</button><button class="btn primary" type="button" id="replaceHistory">Replace Historical Data</button></div>
</div></div>

<div class="modal" id="chartModal"><div class="dialog wide">
 <div class="modal-head"><div><h2 id="chartTitle">3-Month Candlestick Chart</h2><span class="small" id="chartSubtitle"></span></div><button class="btn soft icon" data-close="chartModal">×</button></div>
 <div class="chart-toolbar"><select class="select" id="chartRange"><option value="3">3 Months</option><option value="6">6 Months</option><option value="12">12 Months</option></select><button class="btn soft" id="downloadChart">Save PNG</button></div>
 <div class="chart-box"><canvas id="chartCanvas"></canvas></div><div class="chart-info" id="chartInfo"></div>
</div></div>

<div class="modal" id="galleryModal"><div class="dialog wide">
 <div class="modal-head"><div><h2 id="galleryTitle">Watch List — 3M Charts</h2><span class="small">All available local OHLC charts</span></div><button class="btn soft icon" data-close="galleryModal">×</button></div>
 <div class="v11-scanner-searchbar v11-chart-gallery-search" data-gallery-search="gallery">
  <div class="v11-scanner-searchbar__orb" aria-hidden="true">⌕</div>
  <div class="v11-scanner-searchbar__copy"><span class="v11-scanner-searchbar__kicker">CHART GALLERY</span><label for="gallerySearch">Search Trading Code</label><small>Instantly filter watch-list 3M, 6M and 1Y charts</small></div>
  <div class="v11-scanner-searchbar__field v11-chart-gallery-search__field"><span class="v11-scanner-searchbar__icon" aria-hidden="true">⌕</span><input class="input" id="gallerySearch" type="search" autocomplete="off" spellcheck="false" placeholder="Search ROBI, ALIF, SUMITPOWER…" aria-label="Search watch-list charts"><kbd class="v11-scanner-searchbar__key">/</kbd></div>
  <button class="btn soft v11-scanner-searchbar__clear v11-chart-gallery-search__clear" id="gallerySearchClear" type="button">Clear</button>
  <div class="v11-scanner-searchbar__count v11-chart-gallery-search__count" id="gallerySearchCount" aria-live="polite">0 shown</div>
 </div>
 <div class="gallery" id="gallery"></div>
</div></div>

<div class="modal v11-ranked-chart-modal" id="v11RankedChartModal"><div class="dialog wide">
 <div class="modal-head">
  <div><h2 id="v11RankedChartTitle">Ranked 3M Charts</h2><span class="small" id="v11RankedChartSummary">Ranked from highest to lowest score</span></div>
  <button class="btn soft icon" id="v11CloseRankedCharts" type="button" aria-label="Close ranked charts">×</button>
 </div>
 <div class="v11-scanner-searchbar v11-chart-gallery-search" data-gallery-search="v11RankedChartGallery">
  <div class="v11-scanner-searchbar__orb" aria-hidden="true">⌕</div>
  <div class="v11-scanner-searchbar__copy"><span class="v11-scanner-searchbar__kicker">RANKED CHARTS</span><label for="v11RankedChartSearch">Search Trading Code</label><small>Instantly filter ranked scanner 3M, 6M and 1Y charts</small></div>
  <div class="v11-scanner-searchbar__field v11-chart-gallery-search__field"><span class="v11-scanner-searchbar__icon" aria-hidden="true">⌕</span><input class="input" id="v11RankedChartSearch" type="search" autocomplete="off" spellcheck="false" placeholder="Search ROBI, ALIF, SUMITPOWER…" aria-label="Search ranked charts"><kbd class="v11-scanner-searchbar__key">/</kbd></div>
  <button class="btn soft v11-scanner-searchbar__clear v11-chart-gallery-search__clear" id="v11RankedChartSearchClear" type="button">Clear</button>
  <div class="v11-scanner-searchbar__count v11-chart-gallery-search__count" id="v11RankedChartSearchCount" aria-live="polite">0 shown</div>
 </div>
 <div class="gallery" id="v11RankedChartGallery"></div>
</div></div>


<div class="modal" id="dataModal"><div class="dialog wide">
 <div class="modal-head"><div><h2>Downloaded DSE Data</h2><span class="small" id="dataSummary">No data loaded</span></div><button class="btn soft icon" data-close="dataModal">×</button></div>
 <div style="overflow:auto"><table style="width:100%;border-collapse:collapse" id="dataTable"><thead><tr><th>Code</th><th>Date</th><th>Open</th><th>High</th><th>Low</th><th>Close</th><th>Volume</th></tr></thead><tbody></tbody></table></div>
</div></div>

<div class="modal ait-psa-download-confirm-modal" id="downloadConfirmModal" role="dialog" aria-modal="true" aria-labelledby="downloadConfirmTitle">
 <div class="dialog" style="max-width:560px">
  <div class="modal-head">
   <div><h2 id="downloadConfirmTitle">Confirm download</h2><span class="small">Review the operation before it starts</span></div>
   <button class="btn soft icon" id="downloadConfirmClose" type="button" aria-label="Close confirmation">×</button>
  </div>
  <div class="card" style="margin:0">
   <p id="downloadConfirmMessage" style="margin:0;line-height:1.65">Start this download?</p>
   <div class="note" id="downloadConfirmDetails" style="margin-top:12px">The operation may take several minutes depending on the number of trading codes and the selected period.</div>
   <div id="instantTradingWindowFields" class="ait-psa-instant-time-fields" hidden>
    <div style="font-weight:800;margin-bottom:10px">Instant trading-time window</div>
    <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px">
     <label style="display:grid;gap:6px"><span class="small">Trading start time</span><input class="input" id="instantTradingStartTime" type="time" value="10:00" step="60"></label>
     <label style="display:grid;gap:6px"><span class="small">Trading end time</span><input class="input" id="instantTradingEndTime" type="time" value="14:10" step="60"></label>
    </div>
    <div class="small" id="instantTradingWindowHint" style="margin-top:9px">Bangladesh time (Asia/Dhaka). Start time must be earlier than end time.</div>
   </div>
   <div class="form-actions" style="justify-content:flex-end;margin-top:18px">
    <button class="btn soft" id="downloadConfirmCancel" type="button">Cancel</button>
    <button class="btn primary" id="downloadConfirmProceed" type="button">Confirm &amp; Continue</button>
   </div>
  </div>
 </div>
</div>

<div class="modal ait-psa-operation-result-modal" id="operationResultModal" role="dialog" aria-modal="true" aria-labelledby="operationResultTitle">
 <div class="dialog" style="max-width:580px">
  <div class="modal-head">
   <div><h2 id="operationResultTitle">Operation completed</h2><span class="small" id="operationResultSubtitle">The requested operation finished successfully</span></div>
   <button class="btn soft icon" id="operationResultClose" type="button" aria-label="Close result">×</button>
  </div>
  <div class="card" style="margin:0">
   <div style="display:flex;gap:14px;align-items:flex-start">
    <div id="operationResultIcon" aria-hidden="true" style="font-size:34px;line-height:1">✓</div>
    <div style="min-width:0;flex:1">
     <p id="operationResultMessage" style="margin:0;line-height:1.65;font-weight:700">Completed successfully.</p>
     <div class="note" id="operationResultDetails" style="margin-top:12px">Your data is ready.</div>
    </div>
   </div>
   <div class="form-actions" style="justify-content:flex-end;margin-top:18px">
    <button class="btn soft" id="operationResultSecondary" type="button" style="display:none">View Status</button>
    <button class="btn primary" id="operationResultPrimary" type="button">Close</button>
   </div>
  </div>
 </div>
</div>

<nav class="v10-bottom-nav" aria-label="Mobile workspace navigation">
 <button type="button" data-v10-scroll="overviewWorkspace" class="active"><span>⌂</span>Overview</button>
 <button type="button" data-v10-scroll="downloadWorkspace"><span>⇩</span>Download</button>
 <button type="button" id="v10MobileLists"><span>☷</span>Lists</button>
 <button type="button" data-proxy="viewListCharts"><span>⌁</span>Charts</button>
</nav>
<div class="toast-wrap" id="toasts"></div>

<script>
"use strict";
class ID{static make(){return crypto?.randomUUID?.()||"id-"+Date.now().toString(36)+"-"+Math.random().toString(36).slice(2)}}
class OHLCStorage{
 static DB_NAME="ait-psa-market-data-v1";
 static STORE_NAME="state";
 static KEY="ohlc-history";
 static open(){
  return new Promise((resolve,reject)=>{
   if(!("indexedDB" in window))return reject(new Error("IndexedDB is not available in this browser."));
   const request=indexedDB.open(OHLCStorage.DB_NAME,1);
   request.onupgradeneeded=()=>{const db=request.result;if(!db.objectStoreNames.contains(OHLCStorage.STORE_NAME))db.createObjectStore(OHLCStorage.STORE_NAME)};
   request.onsuccess=()=>resolve(request.result);
   request.onerror=()=>reject(request.error||new Error("Unable to open IndexedDB."));
  });
 }
 static async load(){
  const db=await OHLCStorage.open();
  try{
   return await new Promise((resolve,reject)=>{
    const tx=db.transaction(OHLCStorage.STORE_NAME,"readonly"),req=tx.objectStore(OHLCStorage.STORE_NAME).get(OHLCStorage.KEY);
    req.onsuccess=()=>resolve(req.result&&typeof req.result==="object"?req.result:{});
    req.onerror=()=>reject(req.error||new Error("Unable to read OHLC history."));
   });
  }finally{db.close()}
 }
 static async save(history){
  const db=await OHLCStorage.open();
  try{
   await new Promise((resolve,reject)=>{
    const tx=db.transaction(OHLCStorage.STORE_NAME,"readwrite");
    tx.objectStore(OHLCStorage.STORE_NAME).put(history&&typeof history==="object"?history:{},OHLCStorage.KEY);
    tx.oncomplete=()=>resolve(true);
    tx.onerror=()=>reject(tx.error||new Error("Unable to save OHLC history."));
    tx.onabort=()=>reject(tx.error||new Error("OHLC history save was aborted."));
   });
   try{if(navigator.storage?.persist)navigator.storage.persist()}catch(_){}
   return true;
  }finally{db.close()}
 }
 static async clear(){return OHLCStorage.save({})}
}
class Store{
 static KEY="dse-watch-dashboard-v3";
 constructor(){this._lastHistorySignature="";this._savePromise=Promise.resolve()}
 load(){
  try{const d=JSON.parse(localStorage.getItem(Store.KEY));if(d&&d.watchLists)return this.norm(d)}catch(e){}
  const id=ID.make();
  return{motherCodes:[],motherSource:"",lastMotherImport:null,autoMotherSync:true,watchLists:[{id,name:"My DSE Watch List",codes:[]}],activeId:id,history:{},fundamentals:{},watchListDownloads:{version:1,lists:{}},lastFundamentalDownload:null,activity:[],lastArchive:null}
 }
 norm(d){d.motherCodes=Array.isArray(d.motherCodes)?[...new Set(d.motherCodes.map(x=>String(x).toUpperCase()))].sort():[];d.history=d.history&&typeof d.history==="object"?d.history:{};d.fundamentals=d.fundamentals&&typeof d.fundamentals==="object"?d.fundamentals:{};const migratedFundamentals={};Object.entries(d.fundamentals).forEach(([key,row])=>{const raw=String(row?.code||key||"").trim().toUpperCase();const canonical=raw.replace(/[^A-Z0-9.-]/g,"");if(canonical)migratedFundamentals[canonical]={...(row||{}),code:canonical};});d.fundamentals=migratedFundamentals;const Cache=window.AITWatchListDownloadCache;d.watchListDownloads=Cache?Cache.normalizeState(d.watchListDownloads):{version:1,lists:{}};d.lastFundamentalDownload=d.lastFundamentalDownload||null;d.motherSource=String(d.motherSource||"");d.lastMotherImport=d.lastMotherImport||null;d.autoMotherSync=d.autoMotherSync!==false;d.activity=Array.isArray(d.activity)?d.activity:[];if(!d.watchLists?.length){const id=ID.make();d.watchLists=[{id,name:"My DSE Watch List",codes:[]}];d.activeId=id}if(!d.watchLists.some(x=>x.id===d.activeId))d.activeId=d.watchLists[0].id;return d}
 historySignature(history){
  const h=history&&typeof history==="object"?history:{},codes=Object.keys(h).sort();
  let rows=0,tail="";
  for(const code of codes){const list=Array.isArray(h[code])?h[code]:[];rows+=list.length;const last=list.at(-1);tail+=`|${code}:${list.length}:${last?.date||""}:${last?.close??""}`;}
  let hash=2166136261;for(let i=0;i<tail.length;i++){hash^=tail.charCodeAt(i);hash=Math.imul(hash,16777619)}
  return `${codes.length}|${rows}|${(hash>>>0).toString(36)}`;
 }
 metadata(d){
  const copy={...d,history:{}};
  copy.ohlcStorage="indexeddb-v1";
  copy.ohlcRecordCount=Object.values(d?.history||{}).reduce((n,rows)=>n+(Array.isArray(rows)?rows.length:0),0);
  return copy;
 }
 saveMetadata(d){localStorage.setItem(Store.KEY,JSON.stringify(this.metadata(d)))}
 async hydrateHistory(d){
  const legacy=d.history&&typeof d.history==="object"?d.history:{};
  let indexed={};
  try{indexed=await OHLCStorage.load()}catch(e){console.warn("AIT OHLC IndexedDB load:",e)}
  const indexedCount=Object.values(indexed||{}).reduce((n,rows)=>n+(Array.isArray(rows)?rows.length:0),0);
  const legacyCount=Object.values(legacy||{}).reduce((n,rows)=>n+(Array.isArray(rows)?rows.length:0),0);
  if(indexedCount>0)d.history=indexed;
  else if(legacyCount>0){
   d.history=legacy;
   try{await OHLCStorage.save(legacy)}catch(e){console.error("AIT OHLC migration failed:",e);throw e}
  }else d.history={};
  this._lastHistorySignature=this.historySignature(d.history);
  this.saveMetadata(d);
  return d.history;
 }
 save(d){
  this.saveMetadata(d);
  const sig=this.historySignature(d.history);
  if(sig!==this._lastHistorySignature){
   this._lastHistorySignature=sig;
   this._savePromise=this._savePromise.then(()=>OHLCStorage.save(d.history)).catch(e=>{
    this._lastHistorySignature="";
    console.error("AIT OHLC IndexedDB save:",e);
    window.dispatchEvent(new CustomEvent("ait:ohlc-storage-error",{detail:{message:e?.message||String(e)}}));
   });
  }
  return this._savePromise;
 }
 flush(){return this._savePromise}
}
class MotherParser{
 static reserved=new Set(["SL","NO","TRADING","CODE","STOCK","COMPANY","SECURITY","LTP","OPEN","HIGH","LOW","CLOSE","CLOSEP","YCP","CHANGE","TRADE","VALUE","VOLUME","MARKET","PRICE","TOTAL","CATEGORY","SECTOR","DATE"]);
 static clean(v){return String(v??"").trim().toUpperCase().replace(/^["']|["']$/g,"").replace(/[^A-Z0-9().&_-]/g,"")}
 static valid(v){return v.length>=2&&v.length<=30&&/^[A-Z0-9][A-Z0-9().&_-]*$/.test(v)&&/[A-Z]/.test(v)&&!this.reserved.has(v)&&!/^[-+]?\d+(?:\.\d+)?$/.test(v)}
 static parse(text){
  let candidates=[];
  if(/<(table|html|body|tr|td)\b/i.test(text)){
   const doc=new DOMParser().parseFromString(text,"text/html");
   for(const row of doc.querySelectorAll("table tr")){
    const cells=[...row.querySelectorAll("th,td")].map(x=>x.textContent.trim());
    for(let i=0;i<Math.min(cells.length,3);i++){const c=this.clean(cells[i]);if(this.valid(c))candidates.push(c)}
   }
   if(candidates.length)return [...new Set(candidates)].sort();
   text=doc.body?.innerText||text;
  }
  for(const line of String(text).replace(/\r/g,"").split("\n")){
   const parts=line.split(/[\t,;| ]+/).filter(Boolean);
   for(let i=0;i<Math.min(parts.length,3);i++){const c=this.clean(parts[i]);if(this.valid(c))candidates.push(c)}
  }
  return [...new Set(candidates)].sort()
 }
}
class Parser{
 static num(v){const n=Number(String(v??"").replace(/,/g,"").trim());return Number.isFinite(n)?n:null}
 static date(v){const s=String(v??"").trim();if(!s)return null;const m=s.match(/^(\d{1,2})[-/](\d{1,2})[-/](\d{4})$/);if(m)return`${m[3]}-${m[2].padStart(2,"0")}-${m[1].padStart(2,"0")}`;const y=s.match(/^(\d{4})[-/](\d{1,2})[-/](\d{1,2})$/);if(y)return`${y[1]}-${y[2].padStart(2,"0")}-${y[3].padStart(2,"0")}`;const d=new Date(s);if(!Number.isNaN(d.valueOf()))return d.toISOString().slice(0,10);return null}
 static cleanCode(v){return String(v??"").trim().toUpperCase().replace(/[^A-Z0-9().&_-]/g,"")}
 static parse(text,fileCode=""){
  if(/<(table|html|body|tr|td)\b/i.test(text)){const doc=new DOMParser().parseFromString(text,"text/html");text=[...doc.querySelectorAll("tr")].map(r=>[...r.querySelectorAll("th,td")].map(c=>c.textContent.trim()).join(",")).join("\n")}
  const lines=text.replace(/\r/g,"").split("\n").filter(x=>x.trim());if(!lines.length)return{};
  const delimiter=lines[0].includes("\t")?"\t":lines[0].includes(";")?";":",";
  const rows=lines.map(line=>line.split(delimiter).map(x=>x.trim().replace(/^["']|["']$/g,"")));
  const head=rows[0].map(x=>x.toLowerCase().replace(/[^a-z]/g,""));
  const find=(names)=>head.findIndex(h=>names.includes(h));
  let idx={code:find(["code","tradingcode","symbol","instrument"]),date:find(["date","tradingdate","tradeDate".toLowerCase()]),open:find(["open","openp","openingprice","openprice"]),high:find(["high","highp","highprice"]),low:find(["low","lowp","lowprice"]),close:find(["close","closep","closingprice","ltp","lasttradedprice"]),volume:find(["volume","vol","totalvolume","totalvol"])};
  let start=Object.values(idx).some(i=>i>=0)?1:0;
  if(idx.date<0){idx={code:fileCode? -1:0,date:fileCode?0:1,open:fileCode?1:2,high:fileCode?2:3,low:fileCode?3:4,close:fileCode?4:5,volume:fileCode?5:6};start=0}
  const out={};
  for(let i=start;i<rows.length;i++){const r=rows[i];const code=Parser.cleanCode(fileCode||(idx.code>=0?r[idx.code]:""));const date=Parser.date(r[idx.date]);const o=Parser.num(r[idx.open]),h=Parser.num(r[idx.high]),l=Parser.num(r[idx.low]),c=Parser.num(r[idx.close]),v=idx.volume>=0?Parser.num(r[idx.volume])||0:0;if(!code||!date||[o,h,l,c].some(x=>x===null))continue;if(h<Math.max(o,c)||l>Math.min(o,c))continue;(out[code]??=[]).push({date,open:o,high:h,low:l,close:c,volume:v})}
  Object.keys(out).forEach(code=>{const m=new Map(out[code].map(x=>[x.date,x]));out[code]=[...m.values()].sort((a,b)=>a.date.localeCompare(b.date))});return out
 }
}
class CandleChart{
 static draw(canvas,data,opts={}){
  data=window.AITNews?.chartData(data,window.app?.s?.history?.[opts.code||canvas.dataset.newsCode]||data)||data;
  const rect=canvas.getBoundingClientRect(),dpr=devicePixelRatio||1;canvas.width=Math.max(1,Math.round((rect.width||600)*dpr));canvas.height=Math.max(1,Math.round((rect.height||300)*dpr));const ctx=canvas.getContext("2d");ctx.scale(dpr,dpr);const W=canvas.width/dpr,H=canvas.height/dpr;ctx.clearRect(0,0,W,H);
  canvas.dataset.newsCode=opts.code||canvas.dataset.newsCode||"";canvas._aitNewsHits=[];canvas.title="";canvas.style.cursor="";
  if(!data.length){ctx.fillStyle="#64748b";ctx.font="15px system-ui";ctx.textAlign="center";ctx.fillText("No OHLC records available for this period.",W/2,H/2);return}
  const newsEvents=window.AITNews?.eventsFor(data,window.AITNews.forCode(canvas.dataset.newsCode))||[];
  const margin={l:60,r:18,t:18,b:55},volH=80,priceBottom=H-margin.b-volH,gW=W-margin.l-margin.r,pH=priceBottom-margin.t;
  const newsMetrics=window.AITNews?.symbolMetrics(W,H);
  const bounds=window.AITNews?.bounds(data,newsEvents,pH,newsMetrics),min=bounds?.min??Math.min(...data.map(x=>x.low)),max=bounds?.max??Math.max(...data.map(x=>x.high)),range=Math.max(.01,max-min),maxVol=Math.max(1,...data.map(x=>x.volume||0));
  const y=p=>margin.t+(max-p)/range*pH,x=i=>margin.l+(i+.5)*gW/data.length,cw=Math.max(2,Math.min(11,gW/data.length*.62));
  window.AITNews?.watermark(ctx,margin.l,margin.t,gW,pH);
  ctx.strokeStyle="#e2e8f0";ctx.lineWidth=1;ctx.fillStyle="#64748b";ctx.font="11px system-ui";ctx.textAlign="right";
  for(let i=0;i<=5;i++){const yy=margin.t+i*pH/5,price=max-i*range/5;ctx.beginPath();ctx.moveTo(margin.l,yy);ctx.lineTo(W-margin.r,yy);ctx.stroke();ctx.fillText(price.toFixed(2),margin.l-7,yy+4)}
  const step=Math.max(1,Math.ceil(data.length/6));ctx.textAlign="center";for(let i=0;i<data.length;i+=step){ctx.fillText(data[i].date.slice(5),x(i),H-18)}
  data.forEach((d,i)=>{const up=d.close>=d.open,col=up?"#15803d":"#dc2626",xx=x(i);ctx.strokeStyle=col;ctx.fillStyle=col;ctx.beginPath();ctx.moveTo(xx,y(d.high));ctx.lineTo(xx,y(d.low));ctx.stroke();const top=y(Math.max(d.open,d.close)),bottom=y(Math.min(d.open,d.close));ctx.fillRect(xx-cw/2,top,cw,Math.max(1,bottom-top));const vh=(d.volume||0)/maxVol*(volH-15);ctx.globalAlpha=.35;ctx.fillRect(xx-cw/2,H-margin.b-vh,cw,vh);ctx.globalAlpha=1});
  ctx.strokeStyle="#cbd5e1";ctx.strokeRect(margin.l,margin.t,gW,pH);
  window.AITNews?.draw(ctx,canvas,newsEvents,x,y,newsMetrics);
 }
}
class App{
 constructor(){this.store=new Store();this.s=this.store.load();this.downloadCache=window.AITWatchListDownloadCache?new window.AITWatchListDownloadCache(this.s):null;this.downloadCache?.touch(this.active());this.editId=null;this.pending={};this.pendingMother=[];this.pendingMotherSource="";this.currentCode=null;this.searchTerm="";this._downloadTimingState=null;this._downloadTimingInterval=null;this._scannerUniverseSignature=this.scannerUniverseSignature()}
 async init(){["lastArchive","sMother","sLists","sHistory","sRecords","lists","activity","newList","clearActivity","search","motherImport","quickMotherSync","saveStatus","motherModal","motherSourceSelect","motherUrl","autoMotherSync","openMotherSource","fetchMother","motherFiles","parseMotherFiles","motherPaste","parseMotherPaste","motherResult","motherCommitArea","mergeMother","replaceMother","archiveImport","downloadFundamentals","amarstockFundamentals","instantDseUpdate","dse3mUpdate","dse3mUpdate2","dse6mUpdate","dse6mUpdate2","dse1yUpdate2","incrementalOhlcDownload","forceFullOhlc3M","forceFullOhlcDownload","forceFullOhlc1Y","viewListCharts","viewListCharts2","viewListCharts6","viewListCharts6_2","viewListCharts12","viewListCharts12_2","downloadStatusCard","downloadStatusTitle","downloadStatusPercent","downloadStatusBar","downloadStatusText","downloadTiming","downloadElapsedTime","downloadStartedAt","downloadEtaTime","downloadEtaFinish","hideDownloadStatus","viewDownloadedData","emptyDownloadedData","exportBtn","importBtn","dashboardFile","mother","motherMeta","watch","watchTitle","watchMeta","watchCodeSearch","clearWatchCodeSearch","watchCodeSearchStatus","listModal","listModalTitle","listForm","listName","archiveModal","dseStartDate","dseEndDate","fetchDseRange","downloadDseCsv","ohlcFiles","parseFiles","pasteOhlc","parsePaste","archiveUrl","urlCode","fetchUrl","parseResult","commitArea","mergeHistory","replaceHistory","chartModal","chartTitle","chartSubtitle","chartRange","downloadChart","chartCanvas","chartInfo","galleryModal","galleryTitle","gallery","dataModal","dataSummary","dataTable","downloadConfirmModal","downloadConfirmTitle","downloadConfirmMessage","downloadConfirmDetails","instantTradingWindowFields","instantTradingStartTime","instantTradingEndTime","instantTradingWindowHint","downloadConfirmClose","downloadConfirmCancel","downloadConfirmProceed","operationResultModal","operationResultTitle","operationResultSubtitle","operationResultIcon","operationResultMessage","operationResultDetails","operationResultClose","operationResultSecondary","operationResultPrimary","toasts"].forEach(id=>this[id]=document.getElementById(id));this.bind();
 this.searchTerm="";
 if(this.search)this.search.value="";
 if(this.watchCodeSearch)this.watchCodeSearch.value="";
 this.setDefaultDseDates();
 try{
  if(this.saveStatus)this.saveStatus.textContent="Loading OHLC history…";
  await this.store.hydrateHistory(this.s);
 }catch(e){
  console.error(e);
  this.toast(`OHLC storage initialization failed: ${e?.message||e}`,true);
 }
 this.render();
 if(this.saveStatus)this.saveStatus.textContent="Permanent autosave enabled • OHLC in IndexedDB";
 setTimeout(()=>this.maybeAutoSync(),500)}
 bind(){this.newList.onclick=()=>this.openList();this.listForm.onsubmit=e=>this.saveList(e);this.clearActivity.onclick=()=>{this.s.activity=[];this.persist();this.renderActivity()};this.search.oninput=e=>this.setTradingCodeSearch(e.target.value);
this.watchCodeSearch.oninput=e=>this.setTradingCodeSearch(e.target.value);
this.clearWatchCodeSearch.onclick=()=>{
 this.setTradingCodeSearch("");
 this.watchCodeSearch.focus();
};this.motherImport.onclick=()=>{this.autoMotherSync.checked=this.s.autoMotherSync!==false;this.open("motherModal")};
this.quickMotherSync.onclick=()=>this.fetchMotherCodes(true);
this.motherSourceSelect.onchange=()=>{if(this.motherSourceSelect.value!=="custom")this.motherUrl.value=this.motherSourceSelect.value};
this.autoMotherSync.onchange=()=>{this.s.autoMotherSync=this.autoMotherSync.checked;this.persist()};
this.openMotherSource.onclick=()=>window.open(this.motherUrl.value.trim(),"_blank","noopener");
this.fetchMother.onclick=()=>this.fetchMotherCodes(false);
this.parseMotherFiles.onclick=()=>this.readMotherFiles();
this.parseMotherPaste.onclick=()=>this.prepareMother(MotherParser.parse(this.motherPaste.value),"Pasted DSE data");
this.mergeMother.onclick=()=>this.commitMother(false);
this.replaceMother.onclick=()=>this.commitMother(true);
this.hideDownloadStatus.onclick=()=>this.downloadStatusCard.style.display="none";
this.downloadFundamentals.onclick=()=>this.startFundamentalDownload();if(this.amarstockFundamentals)this.amarstockFundamentals.onclick=()=>this.startAmarstockFundamentalDownload();
this.archiveImport.onclick=()=>this.open("archiveModal");
this.instantDseUpdate.onclick=async()=>{
 const context=this.activeWatchListContext();
 if(!context?.codes?.length)return this.toast("The active watch list is empty.",true);
 const initialState=this.instantDownloadEligibility(context,{
  start:this.instantTradingStartTime?.value||"10:00",
  end:this.instantTradingEndTime?.value||"14:10"
 });
 const refreshText=initialState.provisionalCodes.length
  ?`${initialState.provisionalCodes.length} existing provisional row${initialState.provisionalCodes.length===1?"":"s"} will be replaced. `
  :"";
 const officialText=initialState.officialCodes.length
  ?`${initialState.officialCodes.length} code${initialState.officialCodes.length===1?" has":"s have"} today’s official archive row and will block the operation unless the active watch list changes. `
  :"";
 const windowSelection=await this.confirmInstantDownload("Instant Hybrid OHLC Download",`Fetch today’s DSE market table plus AmarStock OpenP for ${context.name}?`,`${refreshText}${officialText}${context.codes.length} active-watch-list codes will be requested. Edit the Bangladesh trading-time window below, then continue.`,context);
 if(!windowSelection)return;
 if(this.activeWatchListContext()?.signature!==context.signature)return this.toast("The active watch list changed. Open Instant download again.",true);
 const eligibility=this.instantDownloadEligibility(context,windowSelection);
 if(!eligibility.allowed)return this.showInstantDownloadBlocked(eligibility);
 this.fetchInstantDse(context,windowSelection);
};
this.dse3mUpdate.onclick=this.dse3mUpdate2.onclick=async()=>{
 const context=this.activeWatchListContext(),plan=this.planIncrementalOhlcRange(3,false,context);
 const mode=plan.incremental?"Incremental sync":"Initial 3M download";
 const details=plan.incremental
  ?`Latest stored date: ${plan.latest}. Only ${plan.start} to ${plan.end} will be requested. The overlapping latest date is intentionally re-downloaded, then replaced/deduplicated by Trading Code + Date.`
  :`${context?.codes?.length||0} trading codes will be requested from ${plan.start} to ${plan.end}.${plan.missingCodes.length?` ${plan.missingCodes.length} code(s) have no cached OHLC and will be initialized.`:""} Progress will appear in Download Status.`;
 if(await this.confirmDownload("Sync DSE 3M",`${mode} for ${context?.name||"the active watch list"}?`,details)){if(!this.isActiveWatchListContext(context))return this.toast("The active watch list changed. Open the download again.",true);this.downloadActiveWatchlistMonths(3,false,context)}
};
this.dse6mUpdate.onclick=this.dse6mUpdate2.onclick=async()=>{
 const context=this.activeWatchListContext(),plan=this.planIncrementalOhlcRange(6,false,context);
 const mode=plan.incremental?"Incremental sync":"Initial 6M download";
 const details=plan.incremental
  ?`Latest stored date: ${plan.latest}. Only ${plan.start} to ${plan.end} will be requested. Existing historical data is preserved; the overlapping latest date is replaced and duplicates are removed.`
  :`${context?.codes?.length||0} trading codes will be requested from ${plan.start} to ${plan.end}.${plan.missingCodes.length?` ${plan.missingCodes.length} code(s) have no cached OHLC and will be initialized.`:""} Progress will appear in Download Status.`;
 if(await this.confirmDownload("Sync DSE 6M",`${mode} for ${context?.name||"the active watch list"}?`,details)){if(!this.isActiveWatchListContext(context))return this.toast("The active watch list changed. Open the download again.",true);this.downloadActiveWatchlistMonths(6,false,context)}
};
this.dse1yUpdate2.onclick=async()=>{
 const context=this.activeWatchListContext(),plan=this.planIncrementalOhlcRange(12,false,context);
 const mode=plan.incremental?"Incremental sync":"Initial 1Y download";
 const details=plan.incremental
  ?`Latest stored date: ${plan.latest}. Only ${plan.start} to ${plan.end} will be requested. Existing historical data is preserved; the overlapping latest date is replaced and duplicates are removed.`
  :`${context?.codes?.length||0} trading codes will be requested from ${plan.start} to ${plan.end}.${plan.missingCodes.length?` ${plan.missingCodes.length} code(s) have no cached OHLC and will be initialized.`:""} Progress will appear in Download Status.`;
 if(await this.confirmDownload("Sync DSE 1Y",`${mode} for ${context?.name||"the active watch list"}?`,details)){if(!this.isActiveWatchListContext(context))return this.toast("The active watch list changed. Open the download again.",true);this.downloadActiveWatchlistMonths(12,false,context)}
};
this.incrementalOhlcDownload.onclick=async()=>{
 const context=this.activeWatchListContext(),plan=this.planStrictIncrementalOhlcRange(context);
 if(!plan.latest)return this.toast("No stored OHLC exists for this watch list. Use OHLC → Force for the initial download.",true);
 if(await this.confirmDownload("Incremental OHLC Sync",`Download only the latest missing/recent OHLC range for ${context?.name||"the active watch list"}?`,`Common latest cached date: ${plan.latest}. Requested range: ${plan.start} to ${plan.end}. The oldest latest date across all active-list codes is used, so every cached code is brought forward safely.`)){if(!this.isActiveWatchListContext(context))return this.toast("The active watch list changed. Open the download again.",true);this.downloadIncrementalOhlc(context)}
};
this.forceFullOhlc3M.onclick=async()=>{
 const context=this.activeWatchListContext(),plan=this.planIncrementalOhlcRange(3,true,context);
 if(await this.confirmDownload("Force Full DSE 3M Download",`Re-download the complete three-month OHLC range for ${context?.name||"the active watch list"}?`,`Force mode: ${plan.start} to ${plan.end}. Existing rows outside the downloaded range remain preserved; overlapping Trading Code + Date rows are replaced.`)){if(!this.isActiveWatchListContext(context))return this.toast("The active watch list changed. Open the download again.",true);this.downloadActiveWatchlistMonths(3,true,context)}
};
this.forceFullOhlcDownload.onclick=async()=>{
 const context=this.activeWatchListContext(),plan=this.planIncrementalOhlcRange(6,true,context);
 if(await this.confirmDownload("Force Full DSE 6M Download",`Re-download the complete six-month OHLC range for ${context?.name||"the active watch list"}?`,`Force mode: ${plan.start} to ${plan.end}. Existing rows outside the downloaded range remain preserved; overlapping Trading Code + Date rows are replaced.`)){if(!this.isActiveWatchListContext(context))return this.toast("The active watch list changed. Open the download again.",true);this.downloadActiveWatchlistMonths(6,true,context)}
};
this.forceFullOhlc1Y.onclick=async()=>{
 const context=this.activeWatchListContext(),plan=this.planIncrementalOhlcRange(12,true,context);
 if(await this.confirmDownload("Force Full DSE 1Y Download",`Re-download the complete one-year OHLC range for ${context?.name||"the active watch list"}?`,`Force mode: ${plan.start} to ${plan.end}. Existing rows outside the downloaded range remain preserved; overlapping Trading Code + Date rows are replaced.`)){if(!this.isActiveWatchListContext(context))return this.toast("The active watch list changed. Open the download again.",true);this.downloadActiveWatchlistMonths(12,true,context)}
};
this.fetchDseRange.onclick=async()=>{
 if(!this.dseStartDate.value||!this.dseEndDate.value)return this.toast("Select dates first.",true);
 const context=this.activeWatchListContext();if(!context?.codes.length)return this.toast("The active watch list is empty.",true);
 if(await this.confirmDownload("Download DSE range",`Download DSE archive data for “${context.name}” from ${this.dseStartDate.value} to ${this.dseEndDate.value}?`,`${context.codes.length} active-watch-list codes will be requested and cached. Other market symbols will not be returned to the browser.`)){if(!this.isActiveWatchListContext(context))return this.toast("The active watch list changed. Open Range download again.",true);this.fetchDseArchive(this.dseStartDate.value,this.dseEndDate.value,true,false,false,false,"range",context)}
};
this.downloadDseCsv.onclick=async()=>{
 if(!this.dseStartDate.value||!this.dseEndDate.value)return this.toast("Select dates first.",true);
 const context=this.activeWatchListContext();if(!context?.codes.length)return this.toast("The active watch list is empty.",true);
 if(!(await this.confirmDownload("Download CSV",`Download a CSV for “${context.name}” from ${this.dseStartDate.value} to ${this.dseEndDate.value}?`,`${context.codes.length} active-watch-list codes will be included in the generated CSV.`)))return;
 if(this.activeWatchListContext()?.signature!==context.signature)return this.toast("The active watch list changed. Open CSV download again.",true);
 const p=new URLSearchParams({startDate:this.dseStartDate.value,endDate:this.dseEndDate.value,format:"csv",codes:context.codes.join(",")});
 window.location.href="dse_archive.php?"+p.toString()
};
this.viewListCharts.onclick=this.viewListCharts2.onclick=()=>this.openGallery(3);this.viewListCharts6.onclick=this.viewListCharts6_2.onclick=()=>this.openGallery(6);this.viewListCharts12.onclick=this.viewListCharts12_2.onclick=()=>this.openGallery(12);this.viewDownloadedData.onclick=()=>this.openDataPreview();this.emptyDownloadedData.onclick=()=>this.clearDownloadedData();this.parseFiles.onclick=()=>this.readFiles();this.parsePaste.onclick=()=>this.prepare(Parser.parse(this.pasteOhlc.value),"Pasted archive");this.fetchUrl.onclick=async()=>{if(await this.confirmDownload("Download archive URL","Download and parse the entered archive URL?","The remote source may block browser access; manual import remains available if it fails."))this.fetchArchive()};this.mergeHistory.onclick=()=>this.commit(false);this.replaceHistory.onclick=()=>this.commit(true);this.chartRange.onchange=()=>this.drawCurrent();this.downloadChart.onclick=()=>{const a=document.createElement("a");a.href=this.chartCanvas.toDataURL("image/png");a.download=`${this.currentCode||"DSE"}-candlestick.png`;a.click()};this.exportBtn.onclick=()=>this.export();this.importBtn.onclick=()=>this.dashboardFile.click();this.dashboardFile.onchange=e=>this.import(e);document.querySelectorAll("[data-close]").forEach(b=>b.onclick=()=>this.close(b.dataset.close));document.querySelectorAll(".modal").forEach(m=>m.onclick=e=>{if(e.target===m){if(m.id==="downloadConfirmModal")this.resolveDownloadConfirmation(false);else this.close(m.id)}});
this.downloadConfirmProceed.onclick=()=>this.resolveDownloadConfirmation(true);
this.downloadConfirmCancel.onclick=this.downloadConfirmClose.onclick=()=>this.resolveDownloadConfirmation(false);
this.operationResultClose.onclick=this.operationResultPrimary.onclick=()=>this.close("operationResultModal");
this.operationResultSecondary.onclick=()=>{
 this.close("operationResultModal");
 this.downloadStatusCard.style.display="block";
 try{window.openDataCenterTool?.("status","report",false)}catch(_){}
};document.querySelectorAll("[data-tab]").forEach(b=>b.onclick=()=>this.tab(b.dataset.tab));
document.querySelectorAll("[data-mother-tab]").forEach(b=>b.onclick=()=>this.motherTab(b.dataset.motherTab));window.addEventListener("resize",()=>{if(this.chartModal.classList.contains("open"))this.drawCurrent()})}
 active(){return this.s.watchLists.find(x=>x.id===this.s.activeId)||this.s.watchLists[0]}
 activeWatchListContext(list=this.active()){
  if(!list)return null;
  const codes=[...new Set((list.codes||[]).map(code=>String(code||"").trim().toUpperCase().replace(/[^A-Z0-9().&_-]/g,"")).filter(Boolean))];
  return{id:String(list.id||""),name:String(list.name||"Watch List"),codes,signature:`${String(list.id||"none")}|${codes.join("|")}`};
 }
 isActiveWatchListContext(context){return Boolean(context&&this.activeWatchListContext()?.signature===context.signature)}
 downloadCacheSummary(list=this.active()){
  return this.downloadCache?.summary(list,this.s.history||{},this.fundamentalStore())||{listName:list?.name||"Watch List",codeCount:list?.codes?.length||0,ohlc:{codeCount:0,recordCount:0,rangeStart:"",rangeEnd:"",commonLatestDate:"",missingCodes:[...(list?.codes||[])]},fundamentals:{codeCount:0,dseCount:0,amarstockCount:0},lastActivityAt:null,hasCachedData:false};
 }
 renderDownloadContexts(){
  const active=this.active();if(!active)return;
  const summary=this.downloadCacheSummary(active),format=value=>Number(value||0).toLocaleString();
  const range=summary.ohlc.rangeStart&&summary.ohlc.rangeEnd?`${summary.ohlc.rangeStart} → ${summary.ohlc.rangeEnd}`:"No OHLC range cached";
  const last=summary.lastActivityAt?new Date(summary.lastActivityAt).toLocaleString():"No list-specific download yet";
  const html=`<div class="ait-psa-download-scope__identity"><span>ACTIVE WATCH LIST</span><strong>${this.esc(summary.listName)}</strong><small>${format(summary.codeCount)} trading code${summary.codeCount===1?"":"s"} • ${this.esc(last)}</small></div><div class="ait-psa-download-scope__metrics"><span><b>${format(summary.ohlc.codeCount)}/${format(summary.codeCount)}</b> OHLC codes</span><span><b>${format(summary.ohlc.recordCount)}</b> OHLC rows</span><span><b>${format(summary.fundamentals.dseCount)}/${format(summary.codeCount)}</b> DSE fundamentals</span><span><b>${format(summary.fundamentals.amarstockCount)}/${format(summary.codeCount)}</b> AmarStock</span><small>${this.esc(range)} • Automatically restored when this watch list is selected.</small></div>`;
  const modalIds=["aitPsaDownloadMenuModal","aitPsaFundamentalsDownloadMenuModal","aitPsaOhlcDownloadMenuModal","aitPsaOhlcForceMenuModal"];
  modalIds.forEach(id=>{const body=document.querySelector(`#${id} .ait-psa-terminal-modal__body`);if(!body)return;let node=body.querySelector("[data-ait-download-context]");if(!node){node=document.createElement("aside");node.className="ait-psa-download-scope";node.dataset.aitDownloadContext="";node.setAttribute("role","status");node.setAttribute("aria-live","polite");body.prepend(node)}node.innerHTML=html;node.dataset.aitWatchListId=String(active.id||"")});
 }
 scannerUniverseSignature(){const active=this.active();const codes=[...new Set((active?.codes||[]).map(code=>String(code||"").trim().toUpperCase()).filter(Boolean))];return `${active?.id||"none"}|${codes.join("|")}`}
 persist(){const previousUniverse=this._scannerUniverseSignature||"",currentUniverse=this.scannerUniverseSignature();this._scannerUniverseSignature=currentUniverse;this.downloadCache?.reconcile(this.s.watchLists);this.store.save(this.s);if(previousUniverse!==currentUniverse){const active=this.active();window.dispatchEvent(new CustomEvent("ait:active-watchlist-changed",{detail:{activeId:active?.id||null,name:active?.name||"Watch List",codes:[...(active?.codes||[])],cache:this.downloadCacheSummary(active)}}))}if(this.saveStatus){this.saveStatus.textContent="Saved • OHLC IndexedDB • "+new Date().toLocaleTimeString();clearTimeout(this._saveTimer);this._saveTimer=setTimeout(()=>this.saveStatus.textContent="Permanent autosave enabled • OHLC in IndexedDB",2200)}}
 updatePremiumDashboard(){
  const active=this.active?.();
  const codes=active?.codes||[];
  const summary=this.downloadCacheSummary(active);
  const records=summary.ohlc.recordCount;
  const a=document.getElementById("v9ActiveList");
  const b=document.getElementById("v9TrackedCodes");
  const c=document.getElementById("v9SavedRecords");
  const d=document.getElementById("v9ArchiveState");
  if(a)a.textContent=active?.name||"Watch list";
  if(b)b.textContent=`${codes.length.toLocaleString()} codes`;
  if(c)c.textContent=`${records.toLocaleString()} records`;
  if(d)d.textContent=summary.hasCachedData?"Cached":"Ready";
 }
 render(){
  setTimeout(()=>this.updatePremiumDashboard(),0);this.renderStats();this.renderLists();this.renderMother();this.renderWatch();this.renderActivity();this.renderDownloadContexts()}
 renderStats(){const rc=Object.values(this.s.history).reduce((n,a)=>n+a.length,0);this.sMother.textContent=this.s.motherCodes.length;this.sLists.textContent=this.s.watchLists.length;this.sHistory.textContent=Object.keys(this.s.history).length;this.sRecords.textContent=rc.toLocaleString();this.lastArchive.textContent=this.s.lastArchive?new Date(this.s.lastArchive).toLocaleString():"Never"}
 renderLists(){this.lists.innerHTML=this.s.watchLists.map(l=>`<div class="list theme-list-item ${l.id===this.s.activeId?"active":""}"><button class="select-list" data-la="select" data-id="${l.id}"><span class="list-name">${this.esc(l.name)}</span><span class="small">${l.codes.length} codes</span></button><div class="actions"><button class="btn blue icon" title="View all 3M charts" data-la="charts" data-months="3" data-id="${l.id}">3M</button><button class="btn blue icon" title="View all 6M charts" data-la="charts" data-months="6" data-id="${l.id}">6M</button><button class="btn soft icon" data-la="edit" data-id="${l.id}">✎</button><button class="btn soft icon" data-la="delete" data-id="${l.id}">🗑</button></div></div>`).join("");this.lists.querySelectorAll("[data-la]").forEach(b=>b.onclick=()=>this.listAction(b.dataset.la,b.dataset.id,Number(b.dataset.months||3)))}
 setTradingCodeSearch(value){
  const normalized=String(value??"").trim().toUpperCase();
  this.searchTerm=normalized;

  if(this.search&&this.search.value!==normalized)this.search.value=normalized;
  if(this.watchCodeSearch&&this.watchCodeSearch.value!==normalized)this.watchCodeSearch.value=normalized;

  this.renderMother();
  this.renderWatch();
 }
 updateTradingCodeSearchStatus(dseMatches,watchMatches,totalDse,totalWatch){
  if(!this.watchCodeSearchStatus)return;
  this.watchCodeSearchStatus.textContent=this.searchTerm
   ?`${dseMatches} DSE match${dseMatches===1?"":"es"} • ${watchMatches} active watch-list match${watchMatches===1?"":"es"} for “${this.searchTerm}”`
   :`Showing all ${totalDse} DSE codes and ${totalWatch} active watch-list codes`;
 }
 renderMother(){
  const active=this.active()||{codes:[]};
  const activeCodes=Array.isArray(active.codes)?active.codes:[];
  const all=Array.isArray(this.s.motherCodes)?this.s.motherCodes:[];
  const arr=this.searchTerm?all.filter(code=>String(code).toUpperCase().includes(this.searchTerm)):[...all];

  this.motherMeta.textContent=`${arr.length} of ${all.length} codes${this.s.motherSource?" • "+this.s.motherSource:""}`;
  this.mother.innerHTML=arr.length
   ?arr.map(code=>`<div class="code-row${this.searchTerm?" v1112-search-match":""}">
      <div><span class="code">${code}</span><span class="meta">${this.s.history[code]?.length||0} OHLC records</span></div>
      <div class="actions">
       <button class="btn ${activeCodes.includes(code)?"soft":"primary"}" data-add="${code}" ${activeCodes.includes(code)?"disabled":""}>${activeCodes.includes(code)?"Added":"+ Add"}</button>
      </div>
     </div>`).join("")
   :`<div class="empty">${this.searchTerm?`No DSE trading code matches “${this.esc(this.searchTerm)}”.`:"No DSE trading codes. Import DSE codes or OHLC archive data."}</div>`;

  this.mother.querySelectorAll("[data-add]").forEach(button=>button.onclick=()=>this.add(button.dataset.add));

  const watchMatches=activeCodes.filter(code=>String(code).toUpperCase().includes(this.searchTerm)).length;
  this.updateTradingCodeSearchStatus(arr.length,watchMatches,all.length,activeCodes.length);
 }
 renderWatch(){
  const active=this.active();
  const activeCodes=Array.isArray(active?.codes)?active.codes:[];
  const arr=this.searchTerm?activeCodes.filter(code=>String(code).toUpperCase().includes(this.searchTerm)):[...activeCodes];

  this.watchTitle.textContent=active.name;
  this.watchMeta.textContent=`${arr.length} of ${activeCodes.length} codes`;
  this.watch.innerHTML=arr.length
   ?arr.map(code=>`<div class="code-row${this.searchTerm?" v1112-search-match":""}">
      <div><span class="code">${code}</span><span class="meta">${this.s.history[code]?.length||0} OHLC records</span></div>
      <div class="actions">
       <button class="btn red" data-remove="${code}">Remove</button>
      </div>
     </div>`).join("")
   :`<div class="empty">${this.searchTerm?`No active watch-list code matches “${this.esc(this.searchTerm)}”.`:"Add trading codes from the DSE Trading Code List."}</div>`;

  this.watch.querySelectorAll("[data-remove]").forEach(button=>button.onclick=()=>this.remove(button.dataset.remove));

  const dseMatches=this.s.motherCodes.filter(code=>code.includes(this.searchTerm)).length;
  this.updateTradingCodeSearchStatus(dseMatches,arr.length,this.s.motherCodes.length,activeCodes.length);
 }
 renderActivity(){this.activity.innerHTML=this.s.activity.length?this.s.activity.slice(0,8).map(x=>`<div><strong>${this.esc(x.m)}</strong><span>${new Date(x.at).toLocaleString()}</span></div>`).join(""):`<span class="small">No activity.</span>`}
 listAction(act,id,months=3){
  const l=this.s.watchLists.find(x=>x.id===id);if(!l)return;
  if(act==="select"){
   this.s.activeId=id;this.downloadCache?.touch(l);this.persist();this.render();
   const cached=this.downloadCacheSummary(l);this.toast(cached.hasCachedData?`${l.name} selected • ${cached.ohlc.recordCount.toLocaleString()} OHLC rows and ${cached.fundamentals.codeCount.toLocaleString()} fundamental records restored from cache.`:`${l.name} selected • no cached downloads yet.`);
  }else if(act==="charts"){
   this.s.activeId=id;this.downloadCache?.touch(l);this.persist();this.render();this.openGallery(months);
  }else if(act==="edit")this.openList(l);
  else if(act==="delete"){
   if(this.s.watchLists.length===1)return this.toast("At least one list must remain.",true);
   if(confirm(`Delete "${l.name}"?`)){this.downloadCache?.remove(id);this.s.watchLists=this.s.watchLists.filter(x=>x.id!==id);if(this.s.activeId===id){this.s.activeId=this.s.watchLists[0].id;this.downloadCache?.touch(this.active())}this.log(`Deleted watch list ${l.name}`);this.persist();this.render()}
  }
 }
 openList(l=null){this.editId=l?.id||null;this.listModalTitle.textContent=l?"Edit Watch List":"Create Watch List";this.listName.value=l?.name||"";this.open("listModal")}
 saveList(e){e.preventDefault();const n=this.listName.value.trim();if(!n)return;if(this.editId){this.s.watchLists.find(x=>x.id===this.editId).name=n}else{const id=ID.make();this.s.watchLists.push({id,name:n,codes:[]});this.s.activeId=id}this.log(`Saved watch list ${n}`);this.persist();this.close("listModal");this.render()}
 add(c){const a=this.active();if(!a.codes.includes(c))a.codes.push(c);this.log(`Added ${c} to ${a.name}`);this.persist();this.render()}
 remove(c){const a=this.active();a.codes=a.codes.filter(x=>x!==c);this.log(`Removed ${c} from ${a.name}`);this.persist();this.render()}
 motherTab(name){
  document.querySelectorAll("[data-mother-tab]").forEach(x=>x.classList.toggle("active",x.dataset.motherTab===name));
  document.querySelectorAll("[data-mother-panel]").forEach(x=>x.classList.toggle("active",x.dataset.motherPanel===name))
 }
 async fetchMotherCodes(silent=false){
  const url=this.motherUrl?.value?.trim()||"https://staticv2.amarstock.com/latest-share-price";
  if(!/^https?:\/\//i.test(url))return this.toast("Enter a valid source URL.",true);
  if(!silent){this.motherResult.style.display="block";this.motherResult.textContent="Downloading public market page…"}
  const attempts=[
   {name:"direct",url},
   {name:"CORS relay",url:"https://api.allorigins.win/raw?url="+encodeURIComponent(url)}
  ];
  let lastError="";
  for(const attempt of attempts){
   try{
    const controller=new AbortController(),timer=setTimeout(()=>controller.abort(),12000);
    const r=await fetch(attempt.url,{headers:{Accept:"text/html,text/plain,*/*"},signal:controller.signal});
    clearTimeout(timer);
    if(!r.ok)throw new Error("HTTP "+r.status);
    const body=await r.text(),codes=MotherParser.parse(body);
    if(codes.length<50)throw new Error("Only "+codes.length+" codes detected");
    this.prepareMother(codes,`${attempt.name}: ${url}`);
    this.commitMother(false,true);
    if(!silent)this.toast(`Synced ${codes.length} DSE trading codes.`);
    return true
   }catch(e){lastError=e.message||String(e)}
  }
  if(!silent){
   this.motherCommitArea.style.display="none";
   this.motherResult.style.display="block";
   this.motherResult.textContent="Automatic import was blocked by the source and the fallback relay. Open the source page, save it as HTML, and import it through Downloaded File.";
   this.toast("Automatic mother-list sync was blocked.",true)
  }
  console.warn("Mother sync failed:",lastError);
  return false
 }
 async maybeAutoSync(){
  if(this.s.autoMotherSync===false)return;
  const last=this.s.lastMotherImport?Date.now()-new Date(this.s.lastMotherImport).getTime():Infinity;
  if(last<20*60*60*1000)return;
  const oldUrl=this.motherUrl.value;
  this.motherUrl.value="https://staticv2.amarstock.com/latest-share-price";
  const ok=await this.fetchMotherCodes(true);
  this.motherUrl.value=oldUrl;
  if(ok)this.toast("Daily DSE trading-code list synchronized.")
 }
 async readMotherFiles(){
  const files=[...this.motherFiles.files];
  if(!files.length)return this.toast("Select one or more DSE files.",true);
  let codes=[];
  for(const f of files)codes.push(...MotherParser.parse(await f.text()));
  this.prepareMother([...new Set(codes)].sort(),files.map(x=>x.name).join(", "))
 }
 prepareMother(codes,source){
  this.pendingMother=[...new Set(codes.map(MotherParser.clean).filter(x=>MotherParser.valid(x)))].sort();
  this.pendingMotherSource=source;
  this.motherResult.style.display="block";
  this.motherResult.textContent=this.pendingMother.length
   ?`Found ${this.pendingMother.length} unique trading codes. Merge them or replace the current DSE Trading Code List.`
   :"No valid trading codes were detected.";
  this.motherCommitArea.style.display=this.pendingMother.length?"flex":"none"
 }
 commitMother(replace,silent=false){
  if(!this.pendingMother.length)return;
  this.s.motherCodes=replace?[...this.pendingMother]:[...new Set([...this.s.motherCodes,...this.pendingMother])].sort();
  this.s.motherSource=this.pendingMotherSource;
  this.s.lastMotherImport=new Date().toISOString();
  this.log(`${replace?"Replaced":"Merged"} DSE Trading Code List with ${this.pendingMother.length} codes`);
  this.persist();if(!silent)this.close("motherModal");this.render();
  if(!silent)this.toast(`DSE Trading Code List saved with ${this.s.motherCodes.length} codes.`)
 }
 formatDownloadDuration(seconds){
  const total=Math.max(0,Math.round(Number(seconds)||0)),h=Math.floor(total/3600),m=Math.floor((total%3600)/60),sec=total%60;
  return h>0?`${String(h).padStart(2,"0")}:${String(m).padStart(2,"0")}:${String(sec).padStart(2,"0")}`:`${String(m).padStart(2,"0")}:${String(sec).padStart(2,"0")}`;
 }
 formatDownloadClock(timestamp){
  try{return new Intl.DateTimeFormat("en-BD",{timeZone:"Asia/Dhaka",hour:"2-digit",minute:"2-digit",second:"2-digit",hour12:true}).format(new Date(timestamp))}catch(_){return new Date(timestamp).toLocaleTimeString()}
 }
 startDownloadTiming(percent=0){
  if(this._downloadTimingInterval){clearInterval(this._downloadTimingInterval);this._downloadTimingInterval=null}
  const now=Date.now();
  this._downloadTimingState={startedAt:now,lastAt:now,lastPercent:Math.max(0,Math.min(100,Number(percent)||0)),rate:null,state:"working",etaSeconds:null};
  if(this.downloadStartedAt)this.downloadStartedAt.textContent=`Started ${this.formatDownloadClock(now)}`;
  if(this.downloadElapsedTime)this.downloadElapsedTime.textContent="00:00";
  if(this.downloadEtaTime)this.downloadEtaTime.textContent="Estimating…";
  if(this.downloadEtaFinish)this.downloadEtaFinish.textContent="Waiting for enough progress";
  this._downloadTimingInterval=setInterval(()=>this.refreshDownloadTiming(),1000);
 }
 refreshDownloadTiming(){
  const t=this._downloadTimingState;if(!t)return;
  const now=Date.now(),elapsed=(now-t.startedAt)/1000;
  if(this.downloadElapsedTime)this.downloadElapsedTime.textContent=this.formatDownloadDuration(elapsed);
  if(t.state==="success"){
   if(this.downloadEtaTime)this.downloadEtaTime.textContent="Complete";
   if(this.downloadEtaFinish)this.downloadEtaFinish.textContent=`Finished in ${this.formatDownloadDuration(elapsed)}`;
   return;
  }
  if(t.state==="error"){
   if(this.downloadEtaTime)this.downloadEtaTime.textContent="Stopped";
   if(this.downloadEtaFinish)this.downloadEtaFinish.textContent=`Stopped after ${this.formatDownloadDuration(elapsed)}`;
   return;
  }
  if(t.etaSeconds!=null&&Number.isFinite(t.etaSeconds)&&t.etaSeconds>=0){
   if(this.downloadEtaTime)this.downloadEtaTime.textContent=this.formatDownloadDuration(t.etaSeconds);
   if(this.downloadEtaFinish){
    const finish=now+(t.etaSeconds*1000);
    this.downloadEtaFinish.textContent=`Approx. finish ${this.formatDownloadClock(finish)}`;
   }
  }else{
   if(this.downloadEtaTime)this.downloadEtaTime.textContent="Estimating…";
   if(this.downloadEtaFinish)this.downloadEtaFinish.textContent="Waiting for enough progress";
  }
 }
 updateDownloadTiming(percent,state="working"){
  const p=Math.max(0,Math.min(100,Number(percent)||0)),now=Date.now();
  let t=this._downloadTimingState;
  if(!t||t.state!=="working"||(state==="working"&&p<t.lastPercent-3)){
   this.startDownloadTiming(p);t=this._downloadTimingState;
  }
  if(state==="working"){
   const dt=Math.max(.25,(now-t.lastAt)/1000),dp=p-t.lastPercent;
   if(dp>0){
    const instantRate=dp/dt;
    t.rate=t.rate==null?instantRate:(t.rate*.72+instantRate*.28);
   }
   const elapsed=Math.max(1,(now-t.startedAt)/1000);
   const overallRate=p>=4?p/elapsed:null;
   const effectiveRate=t.rate&&overallRate?Math.min(t.rate*1.35,Math.max(overallRate*.45,(t.rate*.55+overallRate*.45))):(t.rate||overallRate);
   t.etaSeconds=effectiveRate&&p<100?(100-p)/effectiveRate:null;
   t.lastAt=now;t.lastPercent=p;
  }else{
   t.state=state;
   t.lastAt=now;t.lastPercent=p;
   t.etaSeconds=0;
   if(this._downloadTimingInterval){clearInterval(this._downloadTimingInterval);this._downloadTimingInterval=null}
  }
  this.refreshDownloadTiming();
 }
 showDownloadStatus(title,text,percent=0,state="working"){
  const pct=Math.max(0,Math.min(100,Number(percent)||0));
  if(state==="working"&&(!this._downloadTimingState||this._downloadTimingState.state!=="working"||pct<=5&&this._downloadTimingState.lastPercent>pct))this.startDownloadTiming(pct);
  this.updateDownloadTiming(pct,state);
  this.downloadStatusCard.style.display="block";
  this.downloadStatusTitle.textContent=(state==="success"?"✓ ":state==="error"?"⚠ ":"◉ ")+title;
  this.downloadStatusText.textContent=text;
  this.downloadStatusPercent.textContent=`${Math.round(pct)}%`;
  this.downloadStatusBar.style.width=`${pct}%`;
  this.downloadStatusBar.style.background=state==="success"?"#16a34a":state==="error"?"#dc2626":"#2563eb";
  window.dispatchEvent(new CustomEvent("dse:download-status",{detail:{title,text,percent:pct,state,elapsedSeconds:this._downloadTimingState?Math.round((Date.now()-this._downloadTimingState.startedAt)/1000):0,etaSeconds:this._downloadTimingState?.etaSeconds??null}}));
 }
 completeDownloadStatus(text){
  this.showDownloadStatus("Download completed",text,100,"success");
  this.showOperationResult({
   title:"Download completed",
   subtitle:"DSE archive data was saved successfully",
   message:"Download and local storage completed.",
   details:text||"The requested DSE data is now available in Download Status and local chart history.",
   icon:"✓",
   showStatus:true
  });
 }
 failDownloadStatus(text){
  this.showDownloadStatus("Download failed",text,100,"error");
 }
 setDefaultDseDates(){
  const end=new Date(),start=new Date(end);
  start.setMonth(start.getMonth()-3);
  const iso=d=>d.toISOString().slice(0,10);
  this.dseStartDate.value=iso(start);
  this.dseEndDate.value=iso(end)
 }
 dseApiUrl(start,end,forceRefresh=false,codes=[]){
  const p=new URLSearchParams({startDate:start,endDate:end,format:"json",v:"8"});
  const normalizedCodes=[...new Set((codes||[]).map(code=>String(code||"").trim().toUpperCase().replace(/[^A-Z0-9().&_-]/g,"")).filter(Boolean))];
  if(normalizedCodes.length)p.set("codes",normalizedCodes.join(","));
  if(forceRefresh)p.set("refresh","1");
  return "dse_archive.php?"+p.toString()
 }
 getDhakaMarketClock(){
  const formatter=new Intl.DateTimeFormat("en-CA",{
   timeZone:"Asia/Dhaka",year:"numeric",month:"2-digit",day:"2-digit",
   hour:"2-digit",minute:"2-digit",second:"2-digit",hourCycle:"h23"
  });
  const parts=Object.fromEntries(formatter.formatToParts(new Date()).filter(part=>part.type!=="literal").map(part=>[part.type,part.value]));
  const date=`${parts.year}-${parts.month}-${parts.day}`;
  const hour=Number(parts.hour||0),minute=Number(parts.minute||0);
  return {date,hour,minute,totalMinutes:(hour*60)+minute,time:`${String(hour).padStart(2,"0")}:${String(minute).padStart(2,"0")}`};
 }
 instantDownloadEligibility(active=this.active(),windowConfig={start:"10:00",end:"14:10"}){
  const clock=this.getDhakaMarketClock();
  const parseTime=value=>{const match=String(value||"").match(/^(\d{2}):(\d{2})$/);if(!match)return null;const hour=Number(match[1]),minute=Number(match[2]);return hour>=0&&hour<=23&&minute>=0&&minute<=59?(hour*60)+minute:null};
  const start=String(windowConfig?.start||"10:00");
  const end=String(windowConfig?.end||"14:10");
  const startMinutes=parseTime(start);
  const endMinutes=parseTime(end);
  const validWindow=startMinutes!==null&&endMinutes!==null&&startMinutes<endMinutes;
  const withinWindow=validWindow&&clock.totalMinutes>=startMinutes&&clock.totalMinutes<=endMinutes;
  const normalizeCode=value=>String(value||"").trim().toUpperCase().replace(/[^A-Z0-9().&_-]/g,"");
  const codes=(active?.codes||[]).map(normalizeCode).filter(Boolean);
  const officialCodes=[];
  const provisionalCodes=[];
  for(const code of codes){
   const rows=Array.isArray(this.s.history?.[code])?this.s.history[code]:[];
   const todayRows=rows.filter(row=>String(row?.date||"").slice(0,10)===clock.date);
   if(todayRows.some(row=>row?.provisional!==true))officialCodes.push(code);
   else if(todayRows.some(row=>row?.provisional===true))provisionalCodes.push(code);
  }
  const archiveExists=officialCodes.length>0;
  return {
   allowed:validWindow&&withinWindow&&!archiveExists,
   clock,withinWindow,validWindow,start,end,startMinutes,endMinutes,archiveExists,officialCodes,provisionalCodes,
   reason:!validWindow
    ?"Trading start time must be earlier than trading end time."
    :!withinWindow
     ?`Instant download is available only from ${start} to ${end} Bangladesh time. Current time: ${clock.time}.`
     :archiveExists
     ?`Official archive data for ${clock.date} already exists for ${officialCodes.length} active trading code${officialCodes.length===1?"":"s"}. Instant data will not replace official archive rows.`
     :""
  };
 }
 showInstantDownloadBlocked(result){
  const detailLines=[];
  if(!result.validWindow){
   detailLines.push("Trading start time must be earlier than trading end time.");
  }else if(!result.withinWindow){
   detailLines.push(`Allowed market window: ${result.start}–${result.end}`);
   detailLines.push(`Current Bangladesh time: ${result.clock.time}`);
  }
  if(result.archiveExists){
   detailLines.push(`Official archive date: ${result.clock.date}`);
   detailLines.push(`Archive rows detected: ${result.officialCodes.length}`);
   const preview=result.officialCodes.slice(0,12).join(", ");
   if(preview)detailLines.push(`Trading codes: ${preview}${result.officialCodes.length>12?" …":""}`);
  }
  this.showDownloadStatus("Instant download not available",result.reason,100,"error");
  this.showOperationResult({
   title:"Instant OHLC download not available",
   subtitle:`${result.clock.date} • Bangladesh market-time validation`,
   message:result.reason,
   details:detailLines.join(" • "),
   icon:"!",
   showStatus:true
  });
  this.log(`Instant hybrid OHLC blocked: ${result.reason}`);
  return false;
 }
 async fetchInstantDse(activeContext=this.activeWatchListContext(),windowConfig={start:"10:00",end:"14:10"}){
  const active=activeContext;
  if(!active?.codes?.length)return this.toast("The active watch list is empty.",true);
  const eligibility=this.instantDownloadEligibility(active,windowConfig);
  if(!eligibility.allowed)return this.showInstantDownloadBlocked(eligibility);
  const startedAt=Date.now();
  this.showDownloadStatus("Fetching instant DSE market data","Connecting to DSE live data and AmarStock OpenP…",12);
  try{
   const params=new URLSearchParams({action:"instant",format:"json",v:"8",codes:active.codes.join(",")});
   const r=await fetch("dse_archive.php?"+params.toString(),{headers:{Accept:"application/json"},cache:"no-store"});
   const rawText=await r.text();
   let payload=null;
   try{payload=JSON.parse(rawText)}catch(_){throw new Error(`Server returned invalid JSON: ${rawText.slice(0,180)}`)}
   if(!r.ok||!payload?.success)throw new Error(payload?.message||`HTTP ${r.status}`);
   this.showDownloadStatus("Matching live DSE rows",`DSE returned ${payload.symbolCount||0} symbols for ${payload.marketDate||"today"}.`,52);
   const normalizeCode=value=>String(value||"").trim().toUpperCase().replace(/[^A-Z0-9().&_-]/g,"");
   const wanted=new Set(active.codes.map(normalizeCode));
   const parsed={},missing=[];
   let replacedTodayCount=0;
   let insertedTodayCount=0;
   for(const [rawCode,rows] of Object.entries(payload.data||{})){
    const code=normalizeCode(rawCode);
    if(!wanted.has(code)||!Array.isArray(rows)||!rows.length)continue;
    const live=rows[rows.length-1];
    const old=(this.s.history[code]||[]).filter(x=>String(x.date||"")<String(live.date||"")).at(-1);
    const priorClose=Number(old?.close);
    const close=Number(live.close), rawOpen=Number(live.open), rawHigh=Number(live.high), rawLow=Number(live.low);
    const open=Number.isFinite(priorClose)&&priorClose>0?priorClose:(Number.isFinite(rawOpen)?rawOpen:close);
    const high=Math.max(Number.isFinite(rawHigh)?rawHigh:close,open,close);
    const low=Math.min(Number.isFinite(rawLow)&&rawLow>0?rawLow:close,open,close);
    if(!live.date||![open,high,low,close].every(Number.isFinite)||close<=0)continue;
    const marketDate=String(live.date).slice(0,10);
    const existingRows=Array.isArray(this.s.history[code])?this.s.history[code]:[];
    const hadToday=existingRows.some(row=>String(row?.date||"").slice(0,10)===marketDate);
    if(hadToday)replacedTodayCount++;else insertedTodayCount++;
    this.s.history[code]=existingRows.filter(row=>String(row?.date||"").slice(0,10)!==marketDate);
    parsed[code]=[{date:marketDate,open,high,low,close,volume:Number(live.volume||0),provisional:true,source:String(live.source||"Hybrid: AmarStock OpenP + DSE live")}];
   }
   for(const code of active.codes){if(!parsed[normalizeCode(code)])missing.push(code)}
   const count=Object.keys(parsed).length;
   if(!count)throw new Error(`The DSE live table returned ${payload.symbolCount||0} symbols, but none matched the active watch list.`);
   this.showDownloadStatus("Merging today’s provisional OHLC",`Saving ${count} live rows into the existing 3M/6M history…`,82);
   this.pending=parsed;
   this.pendingSource=`Hybrid OHLC • AmarStock OpenP + DSE market • ${payload.marketDate||"today"}`;
   this.downloadCache?.recordOhlc(active,{start:payload.marketDate,end:payload.marketDate,mode:"instant",source:this.pendingSource,records:count,requestedCodes:active.codes,matchedCodes:Object.keys(parsed),missingCodes:missing});
   this.commit(false,true);
   const seconds=Math.max(1,Math.round((Date.now()-startedAt)/1000));
   const detail=`Merged ${count} provisional live rows for ${payload.marketDate||"today"} in ${seconds}s.${missing.length?` ${missing.length} watch-list codes were not present in the live table.`:""}`;
   const matchedOpen=Number(payload.amarstockMatched||0);
   const fallbackOpen=Number(payload.openFallbackCount||0);
   const warning=String(payload.amarstockWarning||payload.warning||"").trim();
   this.showDownloadStatus("Download completed",detail,100,"success");
   this.showOperationResult({
    title:"Instant OHLC download completed",
    subtitle:`${payload.marketDate||"Today"} • Hybrid market-data merge`,
    message:`${count} trading-code rows for “${active.name}” were merged into its cached OHLC history.`,
    details:[
     `DSE live rows merged: ${count}`,
     `Existing today rows replaced: ${replacedTodayCount}`,
     `New today rows added: ${insertedTodayCount}`,
     `AmarStock OpenP matched: ${matchedOpen}`,
     `OpenP fallback used: ${fallbackOpen}`,
     `Missing watch-list codes: ${missing.length}`,
     `Duration: ${seconds}s`,
     `Scanner opened automatically: No`,
     warning?`Warning: ${warning}`:""
    ].filter(Boolean).join(" • "),
    icon:"✓",
    showStatus:true
   });
   this.log(`Instant hybrid OHLC merged for ${count} codes`);
   this.persist();
   window.dispatchEvent(new CustomEvent("ait:instant-dse-merged",{detail:{watchListId:active.id,watchListName:active.name,marketDate:payload.marketDate,codes:Object.keys(parsed),missing,replacedTodayCount,insertedTodayCount}}));
   this.toast("Instant hybrid OHLC download completed.");
   return true;
  }catch(e){
   console.error(e);
   const message=e?.message||String(e);
   this.failDownloadStatus(message);
   this.toast(`Instant hybrid OHLC download failed: ${message}`,true);
   return false;
  }
 }
 async fetchDseArchive(start,end,watchOnly=true,openCharts=false,allowNoUpdate=false,forceRefresh=false,cacheMode="range",watchContextOverride=null){
  if(!start||!end)return this.toast("Select DSE start and end dates.",true);
  if(start>end)return this.toast("Start date must be before end date.",true);

  const watchContext=watchOnly?(watchContextOverride||this.activeWatchListContext()):null;
  const activeCodes=watchContext?.codes||[];
  if(watchOnly&&!activeCodes.length)return this.toast("The active watch list is empty.",true);

  const startedAt=Date.now();
  this.showDownloadStatus(
   "Preparing DSE download",
   `${watchContext?`Active watch list: ${watchContext.name} • ${activeCodes.length} codes • `:""}Date range: ${start} to ${end}`,
   5
  );

  try{
   this.showDownloadStatus(
    "Downloading DSE archive",
    "The market-data service is downloading and combining archive chunks. Please keep this page open.",
    20
   );

   const dayMs=86400000;
   const firstDay=Date.parse(`${start}T00:00:00Z`);
   const lastDay=Date.parse(`${end}T00:00:00Z`);
   const windows=[];
   for(let day=firstDay;day<=lastDay;day+=56*dayMs){
    windows.push([new Date(day).toISOString().slice(0,10),new Date(Math.min(lastDay,day+55*dayMs)).toISOString().slice(0,10)]);
   }
   const combined={};
   let payload=null;
   for(let i=0;i<windows.length;i++){
    const [from,to]=windows[i];
    this.showDownloadStatus("Downloading DSE archive",`Date range ${i+1} of ${windows.length}: ${from} to ${to}…`,20+Math.round(40*i/windows.length));
    const r=await fetch(this.dseApiUrl(from,to,forceRefresh,activeCodes),{
     headers:{Accept:"application/json"},cache:"no-store"
    });
    const rawText=await r.text();
    let part=null;
    try{part=JSON.parse(rawText)}catch(_){throw new Error(`Server returned invalid JSON: ${rawText.slice(0,180)}`)}
    if(!r.ok||!part?.success){
     const serverMessage=String(part?.message||`HTTP ${r.status}`);
     if(windows.length>1)throw new Error(`DSE archive ${from} to ${to}: ${serverMessage}`);
    const noArchiveUpdate=allowNoUpdate&&/(no usable dse records|no usable records|no records were returned|no archive records|no data returned|no records found)/i.test(serverMessage);
    if(noArchiveUpdate){
     const seconds=Math.max(1,Math.round((Date.now()-startedAt)/1000));
     const message=`No finalized DSE archive update is available yet for ${start}${end!==start?` to ${end}`:""}. Existing local OHLC, including Instant data, was preserved.`;
     this.showDownloadStatus("No finalized archive update yet",message,100,"success");
     this.showOperationResult({
      title:"Incremental OHLC is already up to date",
      subtitle:`Checked ${start}${end!==start?` to ${end}`:""}`,
      message:"DSE has not returned a newer finalized archive row yet. Nothing was deleted or replaced.",
      details:`Existing latest date preserved: ${start} • Instant/local row preserved: Yes • Duration: ${seconds}s • Try Incremental again after DSE publishes the finalized archive.`,
      icon:"✓",
      showStatus:true
     });
     this.lastDownloadReport={watchListId:watchContext?.id||null,watchListName:watchContext?.name||null,requested:[...activeCodes],matched:[],missing:[],totalServerSymbols:0,records:0,csvFile:"",elapsedMs:Date.now()-startedAt,noUpdate:true,start,end};
     if(watchContext){this.downloadCache?.recordOhlc(watchContext,{start,end,mode:cacheMode,source:"DSE archive check",records:0,requestedCodes:activeCodes,matchedCodes:[],missingCodes:[],noUpdate:true});this.persist()}
     this.log(`Incremental OHLC checked ${start} to ${end}; no finalized DSE archive update yet, existing data preserved`);
     this.toast("No finalized DSE archive update yet. Existing OHLC was preserved.");
     return true;
    }
    throw new Error(serverMessage);
    }
    for(const [code,rows] of Object.entries(part.data||{})){
     (combined[code]??=[]).push(...(Array.isArray(rows)?rows:[]));
    }
    payload=part;
   }
   payload={...payload,data:combined,symbolCount:Object.keys(combined).length,recordCount:Object.values(combined).reduce((n,rows)=>n+rows.length,0)};
   this.showDownloadStatus("Reading server response","The download finished. Reading the parsed archive data…",60);

   this.showDownloadStatus(
    "Matching watch-list codes",
    `Server returned ${payload.symbolCount||0} requested symbols and ${payload.recordCount||0} records${watchContext?` for ${watchContext.name}`:""}.`,
    75
   );

   const raw=payload.data||{};
   const normalizedAll={};
   const normalizeCode=value=>String(value||"")
    .trim()
    .toUpperCase()
    .replace(/[^A-Z0-9().&_-]/g,"");

   for(const [code,rows] of Object.entries(raw)){
    const key=normalizeCode(code);
    if(!key)continue;
    normalizedAll[key]=(Array.isArray(rows)?rows:[]).map(r=>({
     date:String(r.date||""),
     open:Number(r.open),
     high:Number(r.high),
     low:Number(r.low),
     close:Number(r.close),
     volume:Number(r.volume||0)
    })).filter(r=>r.date&&[r.open,r.high,r.low,r.close].every(Number.isFinite));
   }

   const parsed={};
   const missing=[];
   if(watchOnly){
    for(const originalCode of activeCodes){
     const key=normalizeCode(originalCode);
     if(normalizedAll[key]?.length)parsed[key]=normalizedAll[key];
     else missing.push(originalCode);
    }
   }else{
    Object.assign(parsed,normalizedAll);
   }

   const count=Object.values(parsed).reduce((n,a)=>n+a.length,0);
   this.lastDownloadReport={
    watchListId:watchContext?.id||null,
    watchListName:watchContext?.name||null,
    requested:[...activeCodes],
    matched:Object.keys(parsed),
    missing,
    totalServerSymbols:Object.keys(normalizedAll).length,
    records:count,
    csvFile:payload.csvFile||"",
    elapsedMs:Date.now()-startedAt
   };

   if(!count){
    if(allowNoUpdate&&Object.keys(normalizedAll).length===0){
     const seconds=Math.max(1,Math.round((Date.now()-startedAt)/1000));
     const message=`No finalized DSE archive update is available yet for ${start}${end!==start?` to ${end}`:""}. Existing local OHLC, including Instant data, was preserved.`;
     this.showDownloadStatus("No finalized archive update yet",message,100,"success");
     this.showOperationResult({title:"Incremental OHLC is already up to date",subtitle:`Checked ${start}${end!==start?` to ${end}`:""}`,message:"No finalized DSE archive rows were returned. Existing local OHLC remains unchanged.",details:`Instant/local latest row preserved: Yes • Duration: ${seconds}s`,icon:"✓",showStatus:true});
     this.lastDownloadReport={watchListId:watchContext?.id||null,watchListName:watchContext?.name||null,requested:[...activeCodes],matched:[],missing:[],totalServerSymbols:0,records:0,csvFile:payload.csvFile||"",elapsedMs:Date.now()-startedAt,noUpdate:true,start,end};
     if(watchContext){this.downloadCache?.recordOhlc(watchContext,{start,end,mode:cacheMode,source:"DSE archive check",records:0,requestedCodes:activeCodes,matchedCodes:[],missingCodes:[],noUpdate:true});this.persist()}
     this.log(`Incremental OHLC checked ${start} to ${end}; zero finalized rows returned, existing data preserved`);
     this.toast("No finalized DSE archive update yet. Existing OHLC was preserved.");
     return true;
    }
    const examples=Object.keys(normalizedAll).slice(0,25).join(", ");
    throw new Error(`DSE parsed ${Object.keys(normalizedAll).length} symbols, but none matched this watch list. Available examples: ${examples}`);
   }

   this.showDownloadStatus(
    "Saving downloaded data",
    `Saving ${count} records for ${Object.keys(parsed).length} watch-list codes…`,
    90
   );

   this.pending=parsed;
   this.pendingSource=`DSE archive: ${payload.csvFile||"market-data service"}`;
   if(watchContext)this.downloadCache?.recordOhlc(watchContext,{start,end,mode:cacheMode,source:this.pendingSource,records:count,requestedCodes:activeCodes,matchedCodes:Object.keys(parsed),missingCodes:missing});
   this.commit(false,true);

   const seconds=Math.max(1,Math.round((Date.now()-startedAt)/1000));
   const missingText=missing.length?` Missing: ${missing.join(", ")}.`:"";
   const finalText=`Completed in ${seconds}s. Saved ${count} records for ${Object.keys(parsed).length} codes${watchContext?` in “${watchContext.name}”`:""}.${missingText}`;
   this.completeDownloadStatus(finalText);
   this.updatePremiumDashboard();
   this.toast(finalText);

   if(openCharts&&(!watchContext||this.activeWatchListContext()?.signature===watchContext.signature)){
    setTimeout(()=>this.openGallery(),250);
   }
   return true
  }catch(e){
   console.error(e);
   const message=e?.message||String(e);
   this.failDownloadStatus(message);
   this.toast(`DSE download failed: ${message}`,true);
   return false
  }
 }
 activeOhlcCoverage(list=this.active()){
  if(this.downloadCache)return this.downloadCache.ohlcCoverage(list,this.s.history||{});
  const requestedCodes=this.activeWatchListContext(list)?.codes||[],missingCodes=[],coveredCodes=[],latestByCode={};let recordCount=0,rangeStart="",rangeEnd="";
  requestedCodes.forEach(code=>{const rows=Array.isArray(this.s.history?.[code])?this.s.history[code]:[],dates=rows.map(row=>String(row?.date||"").slice(0,10)).filter(date=>/^\d{4}-\d{2}-\d{2}$/.test(date)).sort();recordCount+=rows.length;if(!dates.length){missingCodes.push(code);return}coveredCodes.push(code);latestByCode[code]=dates.at(-1);if(!rangeStart||dates[0]<rangeStart)rangeStart=dates[0];if(dates.at(-1)>rangeEnd)rangeEnd=dates.at(-1)});
  return{requestedCodes,missingCodes,coveredCodes,latestByCode,recordCount,rangeStart,rangeEnd,commonLatestDate:missingCodes.length||!coveredCodes.length?"":coveredCodes.map(code=>latestByCode[code]).sort()[0],complete:requestedCodes.length>0&&missingCodes.length===0};
 }
 latestStoredOhlcDate(codes=[]){return this.activeOhlcCoverage({id:"coverage",name:"Coverage",codes}).commonLatestDate}
 planIncrementalOhlcRange(months=3,forceFull=false,list=this.active()){
  const requested=Number(months),period=[3,6,12].includes(requested)?requested:3;
  const endDate=new Date(),fullStart=new Date(endDate);fullStart.setMonth(fullStart.getMonth()-period);
  const coverage=this.activeOhlcCoverage(list),iso=d=>d.toISOString().slice(0,10),end=this.dhakaTodayDate(),latest=coverage.commonLatestDate;
  const incremental=!forceFull&&coverage.complete&&!!latest;
  const start=incremental?(latest>end?end:latest):iso(fullStart);
  return {period,start,end,latest,incremental,forceFull,missingCodes:coverage.missingCodes,coverage};
 }
 dhakaTodayDate(){
  try{
   const parts=new Intl.DateTimeFormat("en-CA",{timeZone:"Asia/Dhaka",year:"numeric",month:"2-digit",day:"2-digit"}).formatToParts(new Date());
   const get=type=>parts.find(part=>part.type===type)?.value||"";
   return `${get("year")}-${get("month")}-${get("day")}`;
  }catch(_){return new Date().toISOString().slice(0,10)}
 }
 planStrictIncrementalOhlcRange(list=this.active()){
  const coverage=this.activeOhlcCoverage(list),end=this.dhakaTodayDate(),latest=coverage.commonLatestDate;
  return {start:latest?(latest>end?end:latest):"",end,latest,incremental:coverage.complete&&!!latest,replaceOverlap:true,missingCodes:coverage.missingCodes,coverage};
 }
 async downloadActiveWatchlistMonths(months=3,forceFull=false,watchContext=this.activeWatchListContext()){
  const a=watchContext;
  if(!a?.codes?.length)return this.toast("The active watch list is empty.",true);
  const plan=this.planIncrementalOhlcRange(months,forceFull,a);
  this.dseStartDate.value=plan.start;
  this.dseEndDate.value=plan.end;
  const label=plan.incremental?"incremental sync":`full ${plan.period}M download`;
  this.showDownloadStatus(`Preparing DSE ${label}`,`Active watch list: ${a.name} • ${a.codes.length} codes • ${plan.start} to ${plan.end}`,2);
  const mode=plan.incremental?"incremental":forceFull?`force-${plan.period}m`:`initial-${plan.period}m`;
  const ok=await this.fetchDseArchive(plan.start,plan.end,true,false,false,forceFull,mode,a);
  if(ok){
   this.log(`${plan.incremental?"Incremental":"Full"} OHLC sync ${plan.start} to ${plan.end}; duplicate Trading Code + Date rows replaced`);
  }
  return ok;
 }
 async downloadActiveWatchlist3M(context=this.activeWatchListContext()){return this.downloadActiveWatchlistMonths(3,false,context)}
 async downloadActiveWatchlist6M(context=this.activeWatchListContext()){return this.downloadActiveWatchlistMonths(6,false,context)}
 async downloadIncrementalOhlc(watchContext=this.activeWatchListContext()){
  const a=watchContext;if(!a?.codes?.length)return this.toast("The active watch list is empty.",true);
  const plan=this.planStrictIncrementalOhlcRange(a);
  if(!plan.latest){this.toast("No stored OHLC date was found. Use OHLC → Force for the initial 3M, 6M, 1Y or Range download.",true);return false}
  this.dseStartDate.value=plan.start;this.dseEndDate.value=plan.end;
  this.showDownloadStatus("Preparing incremental OHLC sync",`Active watch list: ${a.name} • ${a.codes.length} codes • ${plan.start} to ${plan.end} • latest DSE archive cache will be refreshed`,2);
  const ok=await this.fetchDseArchive(plan.start,plan.end,true,false,true,true,"incremental",a);
  if(ok&&!this.lastDownloadReport?.noUpdate)this.log(`Incremental OHLC sync ${plan.start} to ${plan.end}; overlapping Trading Code + Date rows replaced and duplicates removed`);
  return ok;
 }
 async readFiles(){const files=[...this.ohlcFiles.files];if(!files.length)return this.toast("Select archive files.",true);let all={};for(const f of files){const code=Parser.cleanCode(f.name.replace(/\.[^.]+$/,""));const parsed=Parser.parse(await f.text(),files.length>1?code:"");Object.entries(parsed).forEach(([c,r])=>(all[c]??=[]).push(...r))}this.prepare(all,files.map(f=>f.name).join(", "))}
 async fetchArchive(){const url=this.archiveUrl.value.trim();if(!url)return this.toast("Enter an archive URL.",true);try{const r=await fetch(url);if(!r.ok)throw Error();this.prepare(Parser.parse(await r.text(),Parser.cleanCode(this.urlCode.value)),url)}catch(e){this.toast("Archive download was blocked. Download the file manually and import it.",true)}}
 prepare(data,source){Object.keys(data).forEach(c=>{const m=new Map(data[c].map(x=>[x.date,x]));data[c]=[...m.values()].sort((a,b)=>a.date.localeCompare(b.date))});this.pending=data;const sy=Object.keys(data).length,rc=Object.values(data).reduce((n,a)=>n+a.length,0);this.parseResult.style.display="block";this.parseResult.textContent=sy?`Parsed ${rc.toLocaleString()} OHLC records for ${sy} trading codes from ${source}.`:"No valid OHLC rows detected.";this.commitArea.style.display=sy?"flex":"none"}
 mergeOhlcIncomingWins(existingRows=[],incomingRows=[]){
  const existing=(Array.isArray(existingRows)?existingRows:[]).filter(Boolean).map(row=>({...row,date:String(row?.date||"").slice(0,10)})).filter(row=>row.date);
  const incoming=(Array.isArray(incomingRows)?incomingRows:[]).filter(Boolean).map(row=>({...row,date:String(row?.date||"").slice(0,10)})).filter(row=>row.date);
  const incomingDates=new Set(incoming.map(row=>row.date));
  const preserved=existing.filter(row=>!incomingDates.has(row.date));
  const incomingByDate=new Map(incoming.map(row=>[row.date,row]));
  return [...preserved,...incomingByDate.values()].sort((a,b)=>a.date.localeCompare(b.date));
 }
 commit(replace,silent=false){
  if(replace){this.s.history={};this.downloadCache?.clearOhlc()}
  let replacedRows=0;
  for(const [c,r] of Object.entries(this.pending)){
   const old=replace?[]:(this.s.history[c]||[]);
   const incomingDates=new Set((Array.isArray(r)?r:[]).map(x=>String(x?.date||"").slice(0,10)).filter(Boolean));
   replacedRows+=old.filter(x=>incomingDates.has(String(x?.date||"").slice(0,10))).length;
   this.s.history[c]=this.mergeOhlcIncomingWins(old,r);
   if(!this.s.motherCodes.includes(c))this.s.motherCodes.push(c);
  }
  this.s.motherCodes=[...new Set(this.s.motherCodes)].sort();
  this.s.lastArchive=new Date().toISOString();
  this.s.lastArchiveSource=this.pendingSource||"Imported archive";
  this.log(`${replace?"Replaced":"Merged"} OHLC archive data${!replace&&replacedRows?` • ${replacedRows} overlapping Trading Code + Date rows replaced by downloaded data`:""}`);
  this.persist();
  window.dispatchEvent(new CustomEvent("ait:ohlc-history-changed",{detail:{replace,codes:Object.keys(this.pending).length,replacedRows}}));
  if(!silent)this.close("archiveModal");
  this.render();
  if(!silent)this.toast("Historical archive saved locally.");
 }
 openChart(code,months=3){this.currentCode=code;this.chartTitle.textContent=`${code} Candlestick Chart`;if(this.chartRange)this.chartRange.value=String([3,6,12].includes(Number(months))?Number(months):3);this.open("chartModal");setTimeout(()=>this.drawCurrent(),50)}
 rangeData(code,months){const a=this.s.history[code]||[];if(!a.length)return[];const last=new Date(a[a.length-1].date+"T00:00:00"),cut=new Date(last);cut.setMonth(cut.getMonth()-months);return a.filter(x=>new Date(x.date+"T00:00:00")>=cut)}
 drawCurrent(){const data=this.rangeData(this.currentCode,Number(this.chartRange.value));CandleChart.draw(this.chartCanvas,data,{code:this.currentCode});if(data.length){const f=data[0],l=data[data.length-1],chg=(l.close/f.close-1)*100;this.chartSubtitle.textContent=`${data.length} sessions • ${f.date} to ${l.date}`;this.chartInfo.innerHTML=`<span>Open: <b>${f.open.toFixed(2)}</b></span><span>Last close: <b>${l.close.toFixed(2)}</b></span><span>Change: <b>${chg.toFixed(2)}%</b></span><span>Total volume: <b>${data.reduce((n,x)=>n+x.volume,0).toLocaleString()}</b></span>`}else{this.chartSubtitle.textContent="No local OHLC data";this.chartInfo.innerHTML=""}}
 fundamentalStore(){const merged={};const absorb=(source)=>{if(!source||typeof source!=="object")return;Object.entries(source).forEach(([key,row])=>{if(!row||typeof row!=="object")return;const raw=String(row.code||key||"").trim().toUpperCase();const canonical=raw.replace(/[^A-Z0-9.-]/g,"");const compact=canonical.replace(/[^A-Z0-9]/g,"");if(canonical){merged[canonical]={...row,code:canonical};merged[compact]=merged[canonical];}})};absorb(this.s?.fundamentals);try{absorb(JSON.parse(localStorage.getItem("ait-psa-fundamentals-v1")||"{}"))}catch(_){ }try{const root=JSON.parse(localStorage.getItem(Store.KEY)||"{}");absorb(root?.fundamentals)}catch(_){ }return merged}
 fundamental(code){const raw=String(code||"").trim().toUpperCase();const canonical=raw.replace(/[^A-Z0-9.-]/g,"");const compact=canonical.replace(/[^A-Z0-9]/g,"");const store=this.fundamentalStore();return store[canonical]||store[compact]||store[raw]||null}
 cleanFundamentalRecord(row){if(!row||typeof row!=="object")return null;const text=(value,max=240)=>{const v=String(value??"").replace(/\s+/g," ").trim();return v&&v.length<=max?v:null};const date=value=>{const v=String(value??"");const m=v.match(/\b(?:\d{1,2}[-\/.]\d{1,2}[-\/.]\d{2,4}|\d{4}-\d{2}-\d{2})\b/);return m?m[0]:null};const num=value=>{if(value===null||value===undefined||value==="")return null;const n=Number(String(value).replace(/[% ,]/g,""));return Number.isFinite(n)?n:null};const cat=text(row.category,10);return {...row,category:cat&&/^[A-Z]$/i.test(cat)?cat.toUpperCase():null,businessSegment:text(row.businessSegment||row.sector||row.industry),yearEnd:text(row.yearEnd||row.financialYearEnd,40),lastAgmDate:date(row.lastAgmDate||row.lastAgm),peRatio:num(row.peRatio),eps:num(row.eps),priceNav:num(row.priceNav),freeFloat:num(row.freeFloat),beta:num(row.beta),dividendYield:num(row.dividendYield)} }
 fundamentalHtml(code){const f=this.cleanFundamentalRecord(this.fundamental(code));if(!f)return `<div class="ait-fundamental-strip ait-fundamental-strip--empty"><div class="ait-fundamental-item"><b>Fundamentals not downloaded</b></div></div>`;const item=(label,value,suffix="")=>{const shown=value===null||value===undefined||value===""?"—":`${value}${suffix}`;return `<div class="ait-fundamental-item"><small>${this.esc(label)}</small><b title="${this.esc(String(shown))}">${this.esc(String(shown))}</b></div>`};return `<div class="ait-fundamental-strip">${item("Cat",f.category)}${item("Business",f.businessSegment)}${item("Year End",f.yearEnd)}${item("Last AGM",f.lastAgmDate)}${item("P/E",f.peRatio)}${item("EPS",f.eps)}${item("Price/NAV",f.priceNav)}${item("Free Float",f.freeFloat,"%")}${item("Beta",f.beta)}${item("Dividend Yield",f.dividendYield,"%")}</div>`}
 async downloadFundamentalSource(source){const activeList=this.active();const codes=[...new Set((activeList?.codes||[]).map(x=>String(x).trim().toUpperCase()).filter(Boolean))];if(!activeList)return this.toast("Select an active watch list first.",true);if(!codes.length)return this.toast("The current watch list has no trading codes.",true);const isDse=source==="dse";const listName=String(activeList.name||"Current Watch List");const title=isDse?"Download DSE Fundamentals":"Download AmarStock Fundamentals";const fieldText=isDse?"Category, Business Segment, Year End and Last AGM":"P/E Ratio, EPS, Price/NAV, Free Float, Beta and Dividend Yield";const ok=await this.confirmDownload(title,`Download ${fieldText} for ${codes.length} trading codes in “${listName}”?`,`Only the selected source fields will be refreshed. Data downloaded from the other fundamentals source will be preserved.`);if(!ok)return;const latestActive=this.active();const latestCodes=[...new Set((latestActive?.codes||[]).map(x=>String(x).trim().toUpperCase()).filter(Boolean))];if(!latestActive||latestActive.id!==activeList.id||latestCodes.join("|")!==codes.join("|"))return this.toast("The active watch list changed. Open the fundamentals download again.",true);const endpoint=isDse?"dse_fundamentals.php":"amarstock_fundamentals.php";const sourceName=isDse?"DSE":"AmarStock";this.showDownloadStatus(`Downloading ${sourceName} fundamentals`,`${fieldText} • preparing requests…`,1,"working");const started=Date.now();let saved=0,failed=[],errors={};for(let i=0;i<codes.length;i+=20){const batch=codes.slice(i,i+20);try{const r=await fetch(`${endpoint}?_=${Date.now()}`,{method:"POST",cache:"no-store",headers:{"Content-Type":"application/json","Accept":"application/json"},body:JSON.stringify({codes:batch})});const raw=await r.text();let j={};try{j=JSON.parse(raw)}catch(_){throw new Error(`Invalid server response: ${raw.slice(0,120)}`)}if(!r.ok||!j.ok)throw new Error(j.message||`Request failed with HTTP ${r.status}`);Object.entries(j.data||{}).forEach(([code,row])=>{const canonical=String(row?.code||code||"").trim().toUpperCase().replace(/[^A-Z0-9.-]/g,"");if(!canonical||!row||typeof row!=="object")return;const previous=this.s.fundamentals[canonical]||{code:canonical};this.s.fundamentals[canonical]={...previous,...row,code:canonical};saved++;});failed.push(...(Array.isArray(j.failed)?j.failed:[]));Object.assign(errors,j.errors||{})}catch(e){batch.forEach(code=>{failed.push(code);errors[code]=String(e?.message||e)})}const pct=Math.round(((i+batch.length)/codes.length)*100);this.showDownloadStatus(`Downloading ${sourceName} fundamentals`,`${Math.min(i+batch.length,codes.length)} of ${codes.length} codes processed • ${saved} saved`,pct,"working");await new Promise(res=>setTimeout(res,120))}failed=[...new Set(failed.map(x=>String(x).toUpperCase()))];if(saved===0){this.showDownloadStatus(`${sourceName} fundamental download failed`,`No ${sourceName} fundamental records were saved.`,100,"error");const sample=Object.entries(errors).slice(0,5).map(([c,m])=>`${c}: ${m}`).join("\n");this.showOperationResult({title:`${sourceName} Fundamental Download Failed`,subtitle:"No records were committed",icon:"!",message:`${sourceName} did not return the requested fundamental fields.`,details:`Watch list: ${listName}\nTrading codes requested: ${codes.length}\nSaved: 0\nFailed: ${failed.length||codes.length}\nDuration: ${Math.max(1,Math.round((Date.now()-started)/1000))} seconds${sample?`\n\nError sample:\n${sample}`:""}`});return}this.s.lastFundamentalDownload=new Date().toISOString();try{localStorage.setItem("ait-psa-fundamentals-v1",JSON.stringify(this.s.fundamentals))}catch(_){ }this.persist();this.log(`Downloaded ${sourceName} fundamentals for ${saved} trading codes in ${listName}`);this.render();if(this.galleryModal?.classList.contains("open")){const months=Number(this.galleryModal.dataset?.months||3);this.openGallery(months)}if(document.getElementById("v11RankedChartModal")?.classList.contains("open")&&window.AITRefreshRankedCharts)window.AITRefreshRankedCharts();window.AITRefreshFundamentalsReport?.();window.dispatchEvent(new CustomEvent("ait:fundamentals-updated",{detail:{source:sourceName,saved,failed:failed.length}}));this.showDownloadStatus(`${sourceName} fundamental download completed`,`${saved} records saved${failed.length?`, ${failed.length} failed`:""}.`,100,"success");this.showOperationResult({title:`${sourceName} Fundamental Download Completed`,subtitle:`${sourceName} fields merged into the fundamentals store`,icon:"✓",message:`${saved} ${sourceName} fundamental records from “${listName}” were saved.`,details:`Fields: ${fieldText}\nWatch list: ${listName}\nTrading codes requested: ${codes.length}\nSaved: ${saved}\nFailed: ${failed.length}\nDuration: ${Math.max(1,Math.round((Date.now()-started)/1000))} seconds${failed.length?`\nFailed sample: ${failed.slice(0,10).join(", ")}`:""}`})}
 async downloadAndCacheFundamentalSource(source){
  const context=this.activeWatchListContext();if(!context?.codes.length)return this.downloadFundamentalSource(source);
  const previousCompletedAt=this.s.lastFundamentalDownload;
  await this.downloadFundamentalSource(source);
  if(this.s.lastFundamentalDownload===previousCompletedAt)return;
  const fundamentals=this.fundamentalStore(),hasValue=value=>value!==null&&value!==undefined&&value!=="";
  const fields=source==="amarstock"?["peRatio","eps","priceNav","freeFloat","beta","dividendYield"]:["category","businessSegment","sector","industry","yearEnd","financialYearEnd","lastAgmDate","lastAgm"];
  const matched=context.codes.filter(code=>{const row=fundamentals[code]||fundamentals[code.replace(/[^A-Z0-9]/g,"")];return row&&fields.some(field=>hasValue(row[field]))});
  if(!matched.length)return;
  const missing=context.codes.filter(code=>!matched.includes(code));
  this.downloadCache?.recordFundamentals(context,source,{requestedCodes:context.codes,matchedCodes:matched,missingCodes:missing,saved:matched.length,failed:missing.length});
  this.persist();this.renderDownloadContexts();
 }
 async startFundamentalDownload(){return this.downloadAndCacheFundamentalSource("dse")}
 async startAmarstockFundamentalDownload(){return this.downloadAndCacheFundamentalSource("amarstock")}
 openGallery(months=3){
  const period=[3,6,12].includes(Number(months))?Number(months):3;
  const a=this.active();
  this.galleryTitle.textContent=`${a.name} — ${period===12?"1Y":period+"M"} Charts`;this.galleryModal.dataset.months=String(period);
  this.gallery.innerHTML="";
  if(window.AITChartGallerySearch)window.AITChartGallerySearch.reset("gallery");
  this.open("galleryModal");
  if(!a.codes.length){this.gallery.innerHTML=`<div class="empty">This watch list is empty.</div>`;return}
  requestAnimationFrame(()=>{
   a.codes.forEach(c=>{
    const data=this.rangeData(c,period);
    const card=document.createElement("div");card.className="mini-card";
    card.innerHTML=`<div class="row"><h3>${this.esc(c)}</h3><div class="actions"><button class="btn blue" data-open="${c}" ${data.length?"":"disabled"}>Open</button><a class="btn soft" href="https://www.amarstock.com/stock/${encodeURIComponent(c)}" target="_blank" rel="noopener noreferrer" title="View ${this.esc(c)} on AmarStock">Details</a></div></div>${this.fundamentalHtml(c)}<div class="chart-box mini-chart"><canvas></canvas></div><div class="small">${data.length?`${data.length} sessions • ${data[0].date} to ${data[data.length-1].date}`:"No archive data for this code"}</div>`;
    this.gallery.appendChild(card);
    requestAnimationFrame(()=>CandleChart.draw(card.querySelector("canvas"),data,{code:c}));
    card.querySelector("[data-open]").onclick=()=>{this.close("galleryModal");this.openChart(c,period)}
   })
   if(window.AITChartGallerySearch)window.AITChartGallerySearch.refresh("gallery");
  })
 }
 openDataPreview(){
  const a=this.active(),rows=[];
  for(const code of a.codes){for(const r of (this.s.history[code]||[]).slice(-100))rows.push({code,...r})}
  rows.sort((x,y)=>y.date.localeCompare(x.date)||x.code.localeCompare(y.code));
  this.dataSummary.textContent=`${rows.length} visible rows from ${a.codes.length} watch-list codes`;
  const body=this.dataTable.querySelector("tbody");
  body.innerHTML=rows.length?rows.slice(0,500).map(r=>`<tr><td>${this.esc(r.code)}</td><td>${r.date}</td><td>${Number(r.open).toFixed(2)}</td><td>${Number(r.high).toFixed(2)}</td><td>${Number(r.low).toFixed(2)}</td><td>${Number(r.close).toFixed(2)}</td><td>${Number(r.volume||0).toLocaleString()}</td></tr>`).join(""):`<tr><td colspan="7">No downloaded data for the active watch list.</td></tr>`;
  this.open("dataModal")
 }
 tab(name){document.querySelectorAll(".tab").forEach(x=>x.classList.toggle("active",x.dataset.tab===name));document.querySelectorAll(".tab-panel").forEach(x=>x.classList.toggle("active",x.dataset.panel===name))}
 confirmInstantDownload(title,message,details="",activeContext=this.activeWatchListContext()){
  if(this._downloadConfirmResolver)this.resolveDownloadConfirmation(false);
  this.downloadConfirmTitle.textContent=title||"Confirm instant download";
  this.downloadConfirmMessage.textContent=message||"Start this instant download?";
  this.downloadConfirmDetails.textContent=details||"The selected trading-time window will be validated before download.";
  this.instantTradingWindowFields.hidden=false;
  this.instantTradingWindowFields.style.removeProperty("display");
  this.instantTradingStartTime.value=this.instantTradingStartTime.value||"10:00";
  this.instantTradingEndTime.value=this.instantTradingEndTime.value||"14:10";
  this.open("downloadConfirmModal");
  setTimeout(()=>this.instantTradingStartTime?.focus(),0);
  return new Promise(resolve=>{this._downloadConfirmResolver=confirmed=>{
   if(!confirmed)return resolve(false);
   const start=this.instantTradingStartTime.value||"10:00";
   const end=this.instantTradingEndTime.value||"14:10";
   const result=this.instantDownloadEligibility(activeContext,{start,end});
   if(!result.validWindow){
    this.instantTradingWindowHint.textContent="Start time must be earlier than end time.";
    this.instantTradingWindowHint.style.color="#dc2626";
    this.open("downloadConfirmModal");
    this._downloadConfirmResolver=confirmedAgain=>{
     if(!confirmedAgain)return resolve(false);
     const retryStart=this.instantTradingStartTime.value||"10:00";
     const retryEnd=this.instantTradingEndTime.value||"14:10";
     const retry=this.instantDownloadEligibility(activeContext,{start:retryStart,end:retryEnd});
     if(!retry.validWindow){this.showInstantDownloadBlocked(retry);return resolve(false)}
     resolve({start:retryStart,end:retryEnd});
    };
    return;
   }
   this.instantTradingWindowHint.textContent="Bangladesh time (Asia/Dhaka). Start time must be earlier than end time.";
   this.instantTradingWindowHint.style.color="";
   resolve({start,end});
  }});
 }
 confirmDownload(title,message,details=""){
  if(this._downloadConfirmResolver)this.resolveDownloadConfirmation(false);
  if(this.instantTradingWindowFields)this.instantTradingWindowFields.hidden=true;
  this.downloadConfirmTitle.textContent=title||"Confirm download";
  this.downloadConfirmMessage.textContent=message||"Start this download?";
  this.downloadConfirmDetails.textContent=details||"The operation will start only after confirmation.";
  this.open("downloadConfirmModal");
  setTimeout(()=>this.downloadConfirmProceed?.focus(),0);
  return new Promise(resolve=>{this._downloadConfirmResolver=resolve});
 }
 resolveDownloadConfirmation(confirmed){
  this.close("downloadConfirmModal");
  const resolve=this._downloadConfirmResolver;
  this._downloadConfirmResolver=null;
  if(resolve)resolve(Boolean(confirmed));
 }
 showOperationResult({title="Operation completed",subtitle="The requested operation finished successfully",message="Completed successfully.",details="Your data is ready.",icon="✓",showStatus=false}={}){
  this.operationResultTitle.textContent=title;
  this.operationResultSubtitle.textContent=subtitle;
  this.operationResultMessage.textContent=message;
  this.operationResultDetails.textContent=details;
  this.operationResultIcon.textContent=icon;
  this.operationResultSecondary.style.display=showStatus?"inline-flex":"none";
  this.open("operationResultModal");
  setTimeout(()=>this.operationResultPrimary?.focus(),0);
 }
 async clearDownloadedData(){
  const codes=Object.keys(this.s.history||{}).length;
  const records=Object.values(this.s.history||{}).reduce((total,rows)=>total+(Array.isArray(rows)?rows.length:0),0);
  if(!records){
   this.showOperationResult({title:"Downloaded data is already empty",subtitle:"No OHLC records were found",message:"There is no downloaded market data to remove.",details:"Watch lists, portfolio data, DSE trading codes and terminal settings remain unchanged.",icon:"ℹ"});
   return;
  }
  const confirmed=await this.confirmDownload("Empty downloaded data",`Permanently remove ${records.toLocaleString()} OHLC record${records===1?"":"s"} across ${codes.toLocaleString()} trading code${codes===1?"":"s"}?`,"This cannot be undone unless you have a backup. Watch lists, portfolio positions, DSE codes, themes and settings will be preserved.");
  if(!confirmed)return;
  this.s.history={};
  this.s.lastArchive=null;
  this.downloadCache?.clearOhlc();
  this.persist();
  this.render();
  this.downloadStatusCard.style.display="none";
  try{
   window.dispatchEvent(new CustomEvent("ait:ohlc-data-cleared",{detail:{codes,records}}));
   window.dispatchEvent(new Event("storage"));
  }catch(_){ }
  this.toast(`${records.toLocaleString()} downloaded OHLC records removed.`);
  this.showOperationResult({
   title:"Downloaded data emptied",
   subtitle:"Local OHLC storage cleared successfully",
   message:`Removed ${records.toLocaleString()} OHLC record${records===1?"":"s"} for ${codes.toLocaleString()} trading code${codes===1?"":"s"}.`,
   details:"Watch lists, portfolio positions, DSE trading codes, activity history, themes and terminal settings were preserved.",
   icon:"✓"
  });
 }
 async export(){
  const portfolioData=(()=>{try{const value=JSON.parse(localStorage.getItem("ababil-dse-v11-portfolio")||"[]");return Array.isArray(value)?value:[]}catch{return[]}})();
  if(!(await this.confirmDownload("Create terminal backup",`Download a complete backup containing dashboard and ${portfolioData.length} portfolio position${portfolioData.length===1?"":"s"}?`,"The backup can later restore watch lists, codes, OHLC history, settings stored in the dashboard state, and Portfolio data.")))return;
  const packageData={format:"ait-psa-terminal-backup",version:3,createdAt:new Date().toISOString(),dashboard:this.s,portfolio:portfolioData};
  const b=new Blob([JSON.stringify(packageData,null,2)],{type:"application/json"}),a=document.createElement("a");
  a.href=URL.createObjectURL(b);a.download=`ait-psa-complete-backup-${new Date().toISOString().slice(0,10)}.json`;a.click();URL.revokeObjectURL(a.href);
  const backupMessage=`Backup created with ${portfolioData.length} portfolio position${portfolioData.length===1?"":"s"}.`;
  this.toast(backupMessage);
  this.showOperationResult({
   title:"Backup completed",
   subtitle:"Complete terminal backup created",
   message:"Your backup file was generated successfully.",
   details:`Included dashboard state, watch lists, DSE codes, OHLC history, settings, activity data, and ${portfolioData.length} portfolio position${portfolioData.length===1?"":"s"}.`,
   icon:"✓"
  });
 }
 async import(e){
  const f=e.target.files[0];if(!f)return;
  try{
   const parsed=JSON.parse(await f.text());
   const isPackage=parsed&&parsed.format==="ait-psa-terminal-backup"&&parsed.dashboard;
   this.s=this.store.norm(isPackage?parsed.dashboard:parsed);
   this.downloadCache=window.AITWatchListDownloadCache?new window.AITWatchListDownloadCache(this.s):null;
   this.downloadCache?.touch(this.active());
   if(isPackage&&Array.isArray(parsed.portfolio)){
    localStorage.setItem("ababil-dse-v11-portfolio",JSON.stringify(parsed.portfolio));
    try{portfolio.splice(0,portfolio.length,...parsed.portfolio);renderPortfolio()}catch(_){window.dispatchEvent(new CustomEvent("ait-psa-portfolio-restored"))}
   }
   this.persist();this.render();
   const restoredMessage=isPackage?`Complete backup restored${Array.isArray(parsed.portfolio)?` with ${parsed.portfolio.length} portfolio position${parsed.portfolio.length===1?"":"s"}`:""}.`:"Legacy dashboard backup restored.";
   this.toast(restoredMessage);
   this.showOperationResult({
    title:"Restore completed",
    subtitle:"Terminal data restored successfully",
    message:restoredMessage,
    details:isPackage?"Dashboard, watch lists, downloaded data, settings, activity records, and Portfolio data are available immediately.":"The legacy dashboard backup was restored successfully.",
    icon:"✓"
   });
  }catch(x){this.toast("Invalid dashboard backup file.",true)}
  e.target.value=""
 }
 log(m){
  const at=new Date().toISOString();
  this.s.activity.unshift({m,at});
  this.s.activity=this.s.activity.slice(0,30);
  window.dispatchEvent(new CustomEvent("ait-psa-app-activity",{detail:{title:"Terminal activity",text:String(m||"Action completed"),type:"success",time:at}}));
 }
 open(id){document.getElementById(id).classList.add("open");document.body.style.overflow="hidden"}close(id){document.getElementById(id).classList.remove("open");document.body.style.overflow=""}
 toast(m,e=false){const d=document.createElement("div");d.className="toast"+(e?" error":"");d.textContent=m;this.toasts.appendChild(d);setTimeout(()=>d.remove(),3000)}esc(v){const d=document.createElement("div");d.textContent=String(v);return d.innerHTML}
}
document.addEventListener("DOMContentLoaded",()=>{
 const appInstance=new App();
 window.app=appInstance;
 window.dashboard=appInstance;
 appInstance.init();
});

document.addEventListener("DOMContentLoaded",()=>{
 const buttonMap=[
  ["dse3mUpdate","Download and open 3-month charts"],
  ["dse3mUpdate2","Download and open 3-month charts"],
  ["viewListCharts","Open saved chart gallery"],
  ["viewListCharts2","Open saved chart gallery"],
  ["archiveImport","Import archive data"],
  ["hideDownloadStatus","Hide download status"]
 ];
 for(const [id,title] of buttonMap){
  const el=document.getElementById(id);
  if(el)el.title=title;
 }

 document.addEventListener("keydown",event=>{
  if((event.ctrlKey||event.metaKey)&&event.key.toLowerCase()==="d"){
   event.preventDefault();
   document.getElementById("dse3mUpdate")?.click();
  }
  if((event.ctrlKey||event.metaKey)&&event.key.toLowerCase()==="g"){
   event.preventDefault();
   document.getElementById("viewListCharts")?.click();
  }
  if(event.key==="Escape"){
   document.querySelectorAll(".modal.open,.overlay.open").forEach(el=>el.classList.remove("open"));
  }
 });
});


/* =========================================================
   V10 INTERACTION LAYER
   ========================================================= */
document.addEventListener("DOMContentLoaded",()=>{
 const THEME_KEY="ababil-dse-v10-theme";
 const COLLAPSE_KEY="ababil-dse-v10-collapses";
 const allowedThemes=[
  "dark-glass","classic-light","sapphire","emerald","royal-purple",
  "carbon-oled","crimson","coffee","aurora"
 ];

 const safeRead=(key,fallback)=>{
  try{return JSON.parse(localStorage.getItem(key))??fallback}catch{return fallback}
 };
 const safeWrite=(key,value)=>{
  try{localStorage.setItem(key,JSON.stringify(value))}catch{}
 };

 const themeQuick=document.getElementById("v10ThemeQuick");
 const themeButtons=[...document.querySelectorAll("[data-theme-value]")];

 function applyTheme(theme){
  if(!allowedThemes.includes(theme))theme="dark-glass";
  document.documentElement.dataset.theme=theme;
  if(themeQuick)themeQuick.value=theme;
  themeButtons.forEach(btn=>btn.classList.toggle("active",btn.dataset.themeValue===theme));
  safeWrite(THEME_KEY,theme);
  window.dispatchEvent(new Event("resize"));
 }
 applyTheme(safeRead(THEME_KEY,"dark-glass"));
 themeQuick?.addEventListener("change",()=>applyTheme(themeQuick.value));
 themeButtons.forEach(btn=>btn.addEventListener("click",()=>{
  applyTheme(btn.dataset.themeValue);
  btn.closest(".v10-menu")?.classList.remove("open");
 }));

 // Dropdown button groups
 const menus=[...document.querySelectorAll(".v10-menu")];
 menus.forEach(menu=>{
  const trigger=menu.querySelector(".v10-menu-trigger");
  trigger?.addEventListener("click",event=>{
   event.stopPropagation();
   const willOpen=!menu.classList.contains("open");
   menus.forEach(item=>item.classList.remove("open"));
   if(willOpen)menu.classList.add("open");
  });
 });
 document.addEventListener("click",()=>menus.forEach(menu=>menu.classList.remove("open")));
 document.querySelectorAll(".v10-menu-panel").forEach(panel=>
  panel.addEventListener("click",event=>event.stopPropagation())
 );

 // Proxy grouped actions to the original, tested buttons.
 document.querySelectorAll("[data-proxy]").forEach(button=>{
  button.addEventListener("click",()=>{
   menus.forEach(menu=>menu.classList.remove("open"));
   document.getElementById(button.dataset.proxy)?.click();
  });
 });

 // Mobile drawer
 const sidebar=document.querySelector(".sidebar");
 const backdrop=document.getElementById("v10DrawerBackdrop");
 const openDrawer=()=>{
  if(!sidebar)return;
  sidebar.classList.add("v10-drawer","open");
  backdrop?.classList.add("open");
  document.body.style.overflow="hidden";
 };
 const closeDrawer=()=>{
  sidebar?.classList.remove("open");
  backdrop?.classList.remove("open");
  document.body.style.overflow="";
 };
 document.getElementById("v10OpenDrawer")?.addEventListener("click",openDrawer);
 document.getElementById("v10MobileLists")?.addEventListener("click",openDrawer);
 backdrop?.addEventListener("click",closeDrawer);
 sidebar?.addEventListener("click",event=>{
  if(window.innerWidth<980 && event.target.closest(".list-item"))setTimeout(closeDrawer,120);
 });
 window.addEventListener("resize",()=>{
  if(window.innerWidth>=980)closeDrawer();
 });

 // Scroll helpers
 function scrollToTarget(name){
  let target=document.getElementById(name);
  if(name==="downloadWorkspace")target=document.getElementById("downloadWorkspace")||document.getElementById("downloadStatusCard");
  target?.scrollIntoView({behavior:"smooth",block:"start"});
 }
 document.querySelectorAll("[data-v10-scroll]").forEach(button=>{
  button.addEventListener("click",()=>{
   scrollToTarget(button.dataset.v10Scroll);
   menus.forEach(menu=>menu.classList.remove("open"));
  });
 });

 // Download Center action cards invoke the original application controls.
 document.querySelectorAll("[data-v1116-action]").forEach(button=>{
  button.addEventListener("click",event=>{
   event.preventDefault();
   const target=document.getElementById(button.dataset.v1116Action);
   if(!target||target===button)return;
   target.click();
  });
 });


 // Collapsible workspace builder
 const collapseState=safeRead(COLLAPSE_KEY,{});
 function persistCollapses(){safeWrite(COLLAPSE_KEY,collapseState)}

 function makeCollapsible(element,key,title,subtitle,defaultOpen=true){
  if(!element||element.closest(".v10-collapse"))return;
  const shell=document.createElement("section");
  shell.className="v10-collapse";
  shell.dataset.collapseKey=key;

  const head=document.createElement("button");
  head.type="button";
  head.className="v10-collapse-head";
  head.setAttribute("aria-expanded","true");
  head.innerHTML=`<span class="v10-collapse-copy"><strong>${title}</strong><span>${subtitle}</span></span><span class="v10-collapse-icon">⌄</span>`;

  const body=document.createElement("div");
  body.className="v10-collapse-body";

  element.parentNode.insertBefore(shell,element);
  body.appendChild(element);
  shell.append(head,body);

  const open=collapseState[key]!==undefined?collapseState[key]:defaultOpen;
  shell.classList.toggle("closed",!open);
  head.setAttribute("aria-expanded",String(open));

  head.addEventListener("click",()=>{
   const nextOpen=shell.classList.contains("closed");
   shell.classList.toggle("closed",!nextOpen);
   head.setAttribute("aria-expanded",String(nextOpen));
   collapseState[key]=nextOpen;
   persistCollapses();
  });
 }

 makeCollapsible(
  document.getElementById("overviewWorkspace"),
  "overview","Market overview","Core list, symbol and OHLC statistics",true
 );
 makeCollapsible(
  document.querySelector("header"),
  "welcome","Terminal summary","Application identity and last archive import",false
 );
 makeCollapsible(
  document.getElementById("downloadWorkspace"),
  "download","Download center","All imports, synchronization, downloads, previews and backups",true
 );
 makeCollapsible(
  document.getElementById("marketWorkspace"),
  "market","Trading-code workspace","DSE directory and active watch-list securities",true
 );

 // Individual watch-list and mother panels become collapsible too.
 const marketPanels=[...document.querySelectorAll("#marketWorkspace > .panel")];
 marketPanels.forEach((panel,index)=>{
  makeCollapsible(
   panel,
   index===0?"mother-panel":"watch-panel",
   index===0?"DSE trading-code directory":"Active watch list",
   index===0?"Browse the complete DSE trading-code directory":"Operate selected securities and charts",
   true
  );
 });

 // Bottom navigation active state.
 const navButtons=[...document.querySelectorAll(".v10-bottom-nav button")];
 navButtons.forEach(button=>button.addEventListener("click",()=>{
  navButtons.forEach(item=>item.classList.remove("active"));
  button.classList.add("active");
 }));

 // Escape closes menus and drawer.
 document.addEventListener("keydown",event=>{
  if(event.key==="Escape"){
   menus.forEach(menu=>menu.classList.remove("open"));
   closeDrawer();
  }
 });

 // Initial desktop/mobile sidebar mode.
 if(sidebar)sidebar.classList.add("v10-drawer");
 if(window.innerWidth>=980)sidebar.classList.remove("open");
});


/* =========================================================
   V10.5 PROFESSIONAL PRODUCTIVITY LAYER
   ========================================================= */
document.addEventListener("DOMContentLoaded",()=>{
 const ACTIVITY_KEY="ababil-dse-v105-activity";
 const NOTIFY_KEY="ababil-dse-v105-notifications";
 const WORKSPACE_KEY="ababil-dse-v105-workspace";

 const read=(key,fallback)=>{
  try{return JSON.parse(localStorage.getItem(key))??fallback}catch{return fallback}
 };
 const write=(key,value)=>{
  try{localStorage.setItem(key,JSON.stringify(value))}catch{}
 };
 const nowTime=()=>new Intl.DateTimeFormat(undefined,{hour:"numeric",minute:"2-digit"}).format(new Date());
 const nowStamp=()=>new Date().toISOString();

 let activities=read(ACTIVITY_KEY,[]);
 // Migrate activity produced by the original dashboard application into the
 // professional activity timeline. Both interfaces now share one history.
 const legacyState=read("dse-watch-dashboard-v3",{});
 const legacyActivities=Array.isArray(legacyState?.activity)?legacyState.activity.map(item=>({
  title:"Dashboard activity",
  text:String(item?.m||"Activity completed"),
  type:"success",
  time:item?.at||nowStamp()
 })):[];
 if(legacyActivities.length){
  const seen=new Set(activities.map(item=>`${item.time}|${item.title}|${item.text}`));
  legacyActivities.forEach(item=>{
   const key=`${item.time}|${item.title}|${item.text}`;
   if(!seen.has(key)){activities.push(item);seen.add(key)}
  });
  activities.sort((a,b)=>new Date(b.time)-new Date(a.time));
  activities=activities.slice(0,100);
  write(ACTIVITY_KEY,activities);
 }
 let notifications=read(NOTIFY_KEY,[]);
 let queue=[];
 let activeWorkspace=read(WORKSPACE_KEY,"trading");
 let toastTimer=null;

 const els={
  queue:document.getElementById("v105QueueList"),
  activity:document.getElementById("v105ActivityList"),
  notifications:document.getElementById("v105NotificationList"),
  command:document.getElementById("v105CommandPalette"),
  commandSearch:document.getElementById("v105CommandSearch"),
  commandResults:document.getElementById("v105CommandResults"),
  drawer:document.getElementById("v105RightDrawer"),
  backdrop:document.getElementById("v105RightBackdrop"),
  notifyTab:document.getElementById("v105NotificationsTab"),
  workspaceTab:document.getElementById("v105WorkspacesTab"),
  drawerTitle:document.getElementById("v105DrawerTitle"),
  drawerSubtitle:document.getElementById("v105DrawerSubtitle"),
  toast:document.getElementById("v105Toast"),
  toastTitle:document.getElementById("v105ToastTitle"),
  toastText:document.getElementById("v105ToastText")
 };

 function escapeHtml(value){
  return String(value??"").replace(/[&<>"']/g,char=>({
   "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"
  })[char]);
 }

 function showToast(title,text,type="success"){
  if(!els.toast)return;
  els.toast.className=`v105-toast ${type}`;
  els.toastTitle.textContent=title;
  els.toastText.textContent=text;
  requestAnimationFrame(()=>els.toast.classList.add("show"));
  clearTimeout(toastTimer);
  toastTimer=setTimeout(()=>els.toast.classList.remove("show"),4200);
 }

 function addActivity(title,text,type="success"){
  activities.unshift({title,text,type,time:nowStamp()});
  activities=activities.slice(0,100);
  write(ACTIVITY_KEY,activities);
  renderActivity();
  window.dispatchEvent(new CustomEvent("ait-psa-activity-updated"));
  const last=document.getElementById("v105LastActivity");
  if(last)last.textContent=title;
 }
 window.aitPsaActivityAPI={
  add:(title,text,type="success")=>addActivity(title,text,type),
  read:()=>read(ACTIVITY_KEY,[]),
  clear:()=>{activities=[];write(ACTIVITY_KEY,activities);renderActivity();window.dispatchEvent(new CustomEvent("ait-psa-activity-updated"))}
 };
 window.addEventListener("ait-psa-app-activity",event=>{
  const detail=event.detail||{};
  addActivity(detail.title||"Terminal activity",detail.text||"Action completed",detail.type||"success");
 });
 window.addEventListener("ait-psa-activity-pending",event=>{
  const detail=event.detail||{};
  addActivity(detail.title||"Terminal activity",detail.text||"Action completed",detail.type||"success");
 });

 function addNotification(title,text,type="success"){
  notifications.unshift({title,text,type,time:nowStamp(),read:false});
  notifications=notifications.slice(0,40);
  write(NOTIFY_KEY,notifications);
  renderNotifications();
  showToast(title,text,type);
 }

 function relativeTime(iso){
  const diff=Math.max(0,Date.now()-new Date(iso).getTime());
  const min=Math.floor(diff/60000);
  if(min<1)return "now";
  if(min<60)return `${min}m`;
  const hr=Math.floor(min/60);
  if(hr<24)return `${hr}h`;
  return `${Math.floor(hr/24)}d`;
 }

 function renderActivity(){
  if(!els.activity)return;
  if(!activities.length){
   els.activity.innerHTML='<div class="v105-empty">Your recent actions will appear here.</div>';
   return;
  }
  els.activity.innerHTML=activities.slice(0,7).map(item=>`
   <div class="v105-list-item">
    <span class="v105-status-dot ${escapeHtml(item.type)}"></span>
    <div><strong>${escapeHtml(item.title)}</strong><p>${escapeHtml(item.text)}</p></div>
    <time>${relativeTime(item.time)}</time>
   </div>`).join("");
 }

 function renderNotifications(){
  if(!els.notifications)return;
  if(!notifications.length){
   els.notifications.innerHTML='<div class="v105-empty">No notifications yet.</div>';
  }else{
   els.notifications.innerHTML=notifications.map(item=>`
    <div class="v105-list-item">
     <span class="v105-status-dot ${escapeHtml(item.type)}"></span>
     <div><strong>${escapeHtml(item.title)}</strong><p>${escapeHtml(item.text)}</p></div>
     <time>${relativeTime(item.time)}</time>
    </div>`).join("");
  }
  const unread=notifications.filter(item=>!item.read).length;
  ["v105NotifyCount","v105NotifyCountDesktop"].forEach(id=>{
   const badge=document.getElementById(id);
   if(badge){badge.textContent=String(unread);badge.style.display=unread?"grid":"none"}
  });
 }

 function renderQueue(){
  if(!els.queue)return;
  if(!queue.length){
   els.queue.innerHTML='<div class="v105-empty">No archive job has started in this session.</div>';
   return;
  }
  els.queue.innerHTML=queue.slice(0,5).map(job=>`
   <div class="v105-progress-row">
    <div class="v105-progress-copy">
     <strong>${escapeHtml(job.title)}</strong>
     <span>${escapeHtml(job.text)}</span>
    </div>
    <span class="v105-queue-badge">${Math.round(job.percent)}%</span>
    <div class="v105-mini-progress"><i style="width:${Math.max(0,Math.min(100,job.percent))}%"></i></div>
   </div>`).join("");
 }

 function updateMetrics(){
  try{
   const app=window.app||window.dashboard||null;
   const state=app?.s||app?.state||{};
   const lists=state.lists||state.watchlists||[];
   const active=app?.active?.();
   const codes=active?.codes||[];
   const history=state.history||{};
   const records=Object.values(history).reduce((sum,rows)=>sum+(Array.isArray(rows)?rows.length:0),0);
   const symbols=Object.values(history).filter(rows=>Array.isArray(rows)&&rows.length).length;

   const values={
    v105ListCount:Array.isArray(lists)?lists.length:Object.keys(lists||{}).length,
    v105CodeCount:codes.length,
    v105RecordCount:records.toLocaleString(),
    v105SymbolCount:symbols
   };
   Object.entries(values).forEach(([id,value])=>{
    const el=document.getElementById(id);if(el)el.textContent=value;
   });
  }catch{}
 }

 function openDrawer(tab="notifications"){
  if(!els.drawer)return;
  els.drawer.classList.add("open");
  els.backdrop?.classList.add("open");
  els.drawer.setAttribute("aria-hidden","false");
  setDrawerTab(tab);
  if(tab==="notifications"){
   notifications=notifications.map(item=>({...item,read:true}));
   write(NOTIFY_KEY,notifications);
   renderNotifications();
  }
 }

 function closeDrawer(){
  els.drawer?.classList.remove("open");
  els.backdrop?.classList.remove("open");
  els.drawer?.setAttribute("aria-hidden","true");
 }

 function setDrawerTab(tab){
  const isNotifications=tab==="notifications";
  els.notifyTab.hidden=!isNotifications;
  els.workspaceTab.hidden=isNotifications;
  if(els.drawerTitle)els.drawerTitle.textContent=isNotifications?"Notifications":"Workspaces";
  if(els.drawerSubtitle)els.drawerSubtitle.textContent=isNotifications?"Terminal updates and alerts":"Switch between primary operating areas";
  document.querySelectorAll("[data-v105-tab]").forEach(btn=>
   btn.classList.toggle("active",btn.dataset.v105Tab===tab)
  );
 }

 const commands=[
  {icon:"⬇",name:"Download 3-month DSE data",detail:"Download, parse, save and open charts",keys:"Ctrl D",run:()=>document.getElementById("dse3mUpdate")?.click()},
  {icon:"◫",name:"Open saved chart gallery",detail:"View candlestick charts for the active list",keys:"Ctrl G",run:()=>document.getElementById("viewListCharts")?.click()},
  {icon:"▤",name:"View downloaded data",detail:"Inspect locally stored OHLC records",keys:"",run:()=>document.getElementById("viewDownloadedData")?.click()},
  {icon:"⌁",name:"Custom archive range",detail:"Choose start and end dates",keys:"",run:()=>document.getElementById("archiveImport")?.click()},
  {icon:"♢",name:"Open notifications",detail:"Review terminal events and alerts",keys:"Ctrl B",run:()=>openDrawer("notifications")},
  {icon:"▦",name:"Open workspaces",detail:"Jump between operating areas",keys:"",run:()=>openDrawer("workspaces")},
  {icon:"◆",name:"Backup dashboard + portfolio",detail:"Export terminal configuration and data",keys:"",run:()=>document.getElementById("exportBtn")?.click()},
  {icon:"◇",name:"Restore dashboard",detail:"Import a saved dashboard backup",keys:"",run:()=>document.getElementById("importBtn")?.click()},
  {icon:"◐",name:"Use Premium Dark Glass",detail:"Switch the interface theme",keys:"",run:()=>setTheme("dark-glass")},
  {icon:"○",name:"Use Classic Light",detail:"Restore the previous light design",keys:"",run:()=>setTheme("classic-light")},
  {icon:"◆",name:"Use Emerald theme",detail:"Switch to the green trading theme",keys:"",run:()=>setTheme("emerald")},
  {icon:"●",name:"Use Carbon OLED theme",detail:"Switch to the true-black interface",keys:"",run:()=>setTheme("carbon-oled")}
 ];
 let filteredCommands=[...commands];
 let commandIndex=0;

 function setTheme(theme){
  document.querySelector(`[data-theme-value="${theme}"]`)?.click();
 }

 function renderCommands(query=""){
  const q=query.trim().toLowerCase();
  filteredCommands=commands.filter(item=>
   !q||`${item.name} ${item.detail}`.toLowerCase().includes(q)
  );
  commandIndex=Math.min(commandIndex,Math.max(0,filteredCommands.length-1));
  els.commandResults.innerHTML=filteredCommands.length?filteredCommands.map((item,index)=>`
   <button class="v105-command-item ${index===commandIndex?"active":""}" type="button" data-command-index="${index}">
    <b>${escapeHtml(item.icon)}</b>
    <span><strong>${escapeHtml(item.name)}</strong><small>${escapeHtml(item.detail)}</small></span>
    ${item.keys?`<kbd>${escapeHtml(item.keys)}</kbd>`:"<span></span>"}
   </button>`).join(""):'<div class="v105-empty">No matching command.</div>';
  els.commandResults.querySelectorAll("[data-command-index]").forEach(button=>{
   button.addEventListener("click",()=>{
    const item=filteredCommands[Number(button.dataset.commandIndex)];
    closeCommand();
    item?.run();
   });
  });
 }

 function openCommand(){
  els.command?.classList.add("open");
  els.command?.setAttribute("aria-hidden","false");
  if(els.commandSearch){els.commandSearch.value="";els.commandSearch.focus()}
  commandIndex=0;
  renderCommands("");
 }

 function closeCommand(){
  els.command?.classList.remove("open");
  els.command?.setAttribute("aria-hidden","true");
 }

 function chooseCommand(){
  const item=filteredCommands[commandIndex];
  if(item){closeCommand();item.run()}
 }

 document.getElementById("v105CommandBtn")?.addEventListener("click",openCommand);
 document.getElementById("v105CommandBtnDesktop")?.addEventListener("click",openCommand);
 document.getElementById("v105HeroCommand")?.addEventListener("click",openCommand);
 document.getElementById("v105NotifyBtn")?.addEventListener("click",()=>openDrawer("notifications"));
 document.getElementById("v105NotifyBtnDesktop")?.addEventListener("click",()=>openDrawer("notifications"));
 document.getElementById("v105WorkspaceBtn")?.addEventListener("click",()=>openDrawer("workspaces"));
 document.getElementById("v105CloseDrawer")?.addEventListener("click",closeDrawer);
 els.backdrop?.addEventListener("click",closeDrawer);
 els.command?.addEventListener("click",event=>{if(event.target===els.command)closeCommand()});

 document.querySelectorAll("[data-v105-tab]").forEach(btn=>
  btn.addEventListener("click",()=>setDrawerTab(btn.dataset.v105Tab))
 );

 els.commandSearch?.addEventListener("input",()=>{
  commandIndex=0;renderCommands(els.commandSearch.value)
 });
 els.commandSearch?.addEventListener("keydown",event=>{
  if(event.key==="ArrowDown"){event.preventDefault();commandIndex=Math.min(commandIndex+1,filteredCommands.length-1);renderCommands(els.commandSearch.value)}
  if(event.key==="ArrowUp"){event.preventDefault();commandIndex=Math.max(commandIndex-1,0);renderCommands(els.commandSearch.value)}
  if(event.key==="Enter"){event.preventDefault();chooseCommand()}
  if(event.key==="Escape"){closeCommand()}
 });

 document.querySelectorAll(".v105-workspace-btn").forEach(button=>{
  button.classList.toggle("active",button.dataset.workspace===activeWorkspace);
  button.addEventListener("click",()=>{
   activeWorkspace=button.dataset.workspace;
   write(WORKSPACE_KEY,activeWorkspace);
   document.querySelectorAll(".v105-workspace-btn").forEach(item=>item.classList.toggle("active",item===button));
   const label=document.getElementById("v105WorkspaceName");
   if(label)label.textContent=button.querySelector("strong")?.textContent||activeWorkspace;
   closeDrawer();
   if(button.dataset.proxy)document.getElementById(button.dataset.proxy)?.click();
   if(button.dataset.target){
    const target=button.dataset.target==="downloadWorkspace"
     ?document.getElementById("downloadStatusCard")
     :document.getElementById(button.dataset.target);
    target?.scrollIntoView({behavior:"smooth",block:"start"});
   }
   addActivity("Workspace changed",`Opened ${button.querySelector("strong")?.textContent||activeWorkspace} workspace`,"success");
  });
 });

 document.getElementById("v105ClearActivity")?.addEventListener("click",()=>{
  activities=[];write(ACTIVITY_KEY,activities);renderActivity();
 });
 document.getElementById("v105ClearQueue")?.addEventListener("click",()=>{
  queue=[];renderQueue();
 });

 window.addEventListener("dse:download-status",event=>{
  const detail=event.detail||{};
  const active=queue[0];
  const next={
   title:detail.title||"DSE archive job",
   text:detail.text||"",
   percent:Number(detail.percent||0),
   state:detail.state||"working",
   time:nowStamp()
  };
  if(active && active.state==="working")queue[0]=next;
  else queue.unshift(next);
  queue=queue.slice(0,8);
  renderQueue();

  const health=document.getElementById("v105DownloaderHealth");
  if(health)health.textContent=detail.state==="success"?"Completed":detail.state==="error"?"Error":"Working";

  if(detail.state==="success"){
   addActivity("Download completed",detail.text||"DSE archive data saved successfully.","success");
   addNotification("Archive completed",detail.text||"DSE records are ready.","success");
   updateMetrics();
  }else if(detail.state==="error"){
   addActivity("Download failed",detail.text||"The archive job did not complete.","error");
   addNotification("Archive failed",detail.text||"Check the diagnostic message.","error");
  }else if(Number(detail.percent)<=5){
   addActivity("Download started",detail.text||"Preparing the DSE archive request.","warning");
  }
 });

 // Track important original controls.
 const trackedActions=[
  ["viewListCharts","Chart gallery opened","Opened saved candlestick charts."],
  ["archiveImport","Custom download opened","Selected a custom DSE archive range."],
  ["exportBtn","Backup requested","Prepared a dashboard backup."],
  ["importBtn","Restore requested","Opened dashboard restore."]
 ];
 trackedActions.forEach(([id,title,text])=>{
  document.getElementById(id)?.addEventListener("click",()=>addActivity(title,text,"success"));
 });

 document.addEventListener("keydown",event=>{
  const key=event.key.toLowerCase();
  if((event.ctrlKey||event.metaKey)&&key==="k"){
   event.preventDefault();openCommand();
  }
  if((event.ctrlKey||event.metaKey)&&key==="b"){
   event.preventDefault();openDrawer("notifications");
  }
  if(event.key==="Escape"){
   closeCommand();closeDrawer();
  }
 });

 // Proxy hero controls inserted after original V10 proxy binding ran.
 document.querySelectorAll("#v105Dashboard [data-proxy]").forEach(button=>{
  button.addEventListener("click",()=>document.getElementById(button.dataset.proxy)?.click());
 });

 renderActivity();
 renderNotifications();
 renderQueue();
 updateMetrics();
 setInterval(updateMetrics,3500);

 const workspaceLabel=document.getElementById("v105WorkspaceName");
 if(workspaceLabel)workspaceLabel.textContent=activeWorkspace.charAt(0).toUpperCase()+activeWorkspace.slice(1);

 // Initial welcome event only once.
 if(!read("ababil-dse-v105-welcomed",false)){
  addNotification("Welcome to v10.5","The professional dashboard, command palette and activity center are ready.","success");
  write("ababil-dse-v105-welcomed",true);
 }
});


/* =========================================================
   V11 TRADING TERMINAL LOGIC
   ========================================================= */
document.addEventListener("DOMContentLoaded",()=>{
 const PORTFOLIO_KEY="ababil-dse-v11-portfolio";
 const ACTIVE_TAB_KEY="ababil-dse-v11-tab";
 const tabs=[...document.querySelectorAll("[data-v11-tab]")];
 const workspaces=[...document.querySelectorAll("[data-v11-workspace]")];
 let portfolio=[];
 let portfolioEditIndex=-1;
 try{portfolio=JSON.parse(localStorage.getItem(PORTFOLIO_KEY)||"[]")}catch{portfolio=[]}

 const appState=()=>{
  const app=window.app||window.dashboard||null;
  let state=app?.s||app?.state||{};

  // Fallback to the application's real persistent store when a global
  // reference is temporarily unavailable during initialization.
  if(!state||!Object.keys(state).length){
   try{
    const stored=JSON.parse(localStorage.getItem("dse-watch-dashboard-v3")||"{}");
    if(stored&&typeof stored==="object")state=stored;
   }catch{}
  }

  let active={};
  try{
   active=app?.active?.()||{};
  }catch{}

  if(!active?.codes&&Array.isArray(state?.watchLists)){
   active=state.watchLists.find(list=>list?.id===state.activeId)||state.watchLists[0]||{};
  }

  return {
   app,
   state,
   active,
   history:state.history||{},
   lists:state.watchLists||state.lists||state.watchlists||[]
  };
 };
 const rowsFor=code=>{
  const {history}=appState();
  const rows=Array.isArray(history[code])?history[code]:[];
  const cutoff=window.__AIT_HISTORICAL_CUTOFF_DATE__||null;
  return cutoff?rows.filter(row=>String(row?.date||"")<=cutoff):rows;
 };
 const scannerCodes=()=>{
  const context=appState();
  if(window.AITScannerUniverse?.activeCodes)return window.AITScannerUniverse.activeCodes(context);
  return [...new Set((context.active?.codes||[]).map(code=>String(code||"").trim().toUpperCase()).filter(Boolean))];
 };
 const scannerUniverseSignature=()=>{
  const context=appState();
  if(window.AITScannerUniverse?.signature)return window.AITScannerUniverse.signature(context);
  return `${context.active?.id||"none"}|${scannerCodes().join("|")}`;
 };
 const scannerHistory=()=>{
  const context=appState();
  if(window.AITScannerUniverse?.activeHistory)return window.AITScannerUniverse.activeHistory(context);
  return Object.fromEntries(scannerCodes().map(code=>[code,Array.isArray(context.history?.[code])?context.history[code]:[]]));
 };
 const allCodes=()=>{
  const context=appState();
  if(window.AITScannerUniverse?.allCodes)return window.AITScannerUniverse.allCodes(context);
  const {state,history,lists}=context;
  const mother=Array.isArray(state?.motherCodes)?state.motherCodes:Object.keys(state?.motherCodes||{});
  const allWatchCodes=(Array.isArray(lists)?lists:[]).flatMap(list=>Array.isArray(list?.codes)?list.codes:[]);
  return [...new Set([...mother,...allWatchCodes,...Object.keys(history||{})].map(code=>String(code||"").trim().toUpperCase()).filter(Boolean))].sort();
 };
 // The broader universe remains available to non-scanner tools such as
 // Explorer and Portfolio selectors.
 const codes=allCodes;
 const last=(arr)=>arr?.length?arr[arr.length-1]:null;
 const avg=arr=>arr.length?arr.reduce((a,b)=>a+b,0)/arr.length:0;
 const std=arr=>{
  if(!arr.length)return 0;
  const m=avg(arr);return Math.sqrt(avg(arr.map(v=>(v-m)**2)));
 };
 const sma=(arr,n)=>{
  if(arr.length<n)return null;
  return avg(arr.slice(-n));
 };
 const rsi=(arr,n=14)=>{
  if(arr.length<n+1)return null;
  let gains=0,losses=0;
  for(let i=arr.length-n;i<arr.length;i++){
   const d=arr[i]-arr[i-1];
   if(d>0)gains+=d;else losses-=d;
  }
  if(losses===0)return 100;
  const rs=(gains/n)/(losses/n);
  return 100-(100/(1+rs));
 };
 const fmt=(n,d=2)=>Number.isFinite(Number(n))?Number(n).toFixed(d):"—";
 const esc=v=>String(v??"").replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"}[c]));

 function selectTab(name){
  const available=tabs.map(t=>t.dataset.v11Tab);
  if(!available.includes(name))name="charts";
  tabs.forEach(t=>t.classList.toggle("active",t.dataset.v11Tab===name));
  workspaces.forEach(w=>w.classList.toggle("active",w.dataset.v11Workspace===name));

  const reportTabs=["charts","reports","explorer"];
  const scannerTabs=["indicators","vpa","potential","potential-composite","potential-priority","elite-regime","comparison"];
  document.querySelectorAll("[data-v11-group]").forEach(group=>{
   const groupName=group.dataset.v11Group;
   const isActive=(groupName==="report"&&reportTabs.includes(name))||(groupName==="scanner"&&scannerTabs.includes(name));
   group.classList.toggle("active-group",isActive);
   if(isActive)group.open=true;
  });

  try{localStorage.setItem(ACTIVE_TAB_KEY,JSON.stringify(name))}catch{}
  document.getElementById("v11Terminal")?.scrollIntoView({behavior:"smooth",block:"start"});
  if(name==="explorer")renderExplorer();
  if(name==="portfolio")renderPortfolio();
  if(name==="potential")runPotential();
 }
 tabs.forEach(t=>t.addEventListener("click",()=>selectTab(t.dataset.v11Tab)));
 let savedTab="charts";
 try{savedTab=JSON.parse(localStorage.getItem(ACTIVE_TAB_KEY)||'"charts"')}catch{}
 selectTab(savedTab);

 document.getElementById("v11TerminalBtn")?.addEventListener("click",()=>selectTab(savedTab||"charts"));

 function fillSelects(){
  const list=codes();
  ["v11Symbol1","v11Symbol2","v11Symbol3","v11Symbol4","v11PortfolioCode"].forEach((id,index)=>{
   const el=document.getElementById(id);if(!el)return;
   const current=String(el.value||"").trim().toUpperCase();
   const signature=list.join("|");

   // Avoid rebuilding the select unnecessarily, which previously caused
   // the Portfolio Code field to appear blank or lose its selected value.
   if(el.dataset.codeSignature!==signature){
    el.innerHTML=list.length
     ? list.map(code=>`<option value="${esc(code)}">${esc(code)}</option>`).join("")
     : '<option value="">No trading codes available</option>';
    el.dataset.codeSignature=signature;
   }

   if(current&&list.includes(current)){
    el.value=current;
   }else if(id==="v11PortfolioCode"&&list.length){
    el.value=list[0];
   }else if(list[index]){
    el.value=list[index];
   }else{
    el.value="";
   }

   el.disabled=!list.length;
  });
 }
 fillSelects();
 setInterval(fillSelects,1500);
 window.addEventListener("storage",event=>{
  if(!event.key||(typeof Store!=="undefined"&&event.key===Store.KEY)||event.key==="dse-watch-dashboard-v3"){
   fillSelects();
  }
 });

 // Public refresh hook used after importing or synchronizing DSE trading codes.
 window.AbabilPortfolioCodes={
  refresh:fillSelects,
  getAll:codes
 };


 function drawChart(canvas,code){
  const rows=rowsFor(code);
  const ctx=canvas.getContext("2d");
  const rect=canvas.getBoundingClientRect();
  const dpr=window.devicePixelRatio||1;
  canvas.width=Math.max(1,Math.round((rect.width||320)*dpr));
  canvas.height=270*dpr;
  ctx.setTransform(dpr,0,0,dpr,0,0);
  const w=canvas.width/dpr,h=270;
  ctx.clearRect(0,0,w,h);
  canvas.dataset.newsCode=code;canvas._aitNewsHits=[];canvas.title="";canvas.style.cursor="";
  if(!rows.length){
   ctx.fillStyle=getComputedStyle(document.documentElement).getPropertyValue("--v10-muted");
   ctx.font="14px sans-serif";ctx.fillText("No local OHLC data",16,30);return;
  }
  const data=window.AITNews?.chartData(rows.slice(-90),rows)||rows.slice(-90);
  const newsEvents=window.AITNews?.eventsFor(data,window.AITNews.forCode(code))||[];
  const highs=data.map(r=>Number(r.high));
  const lows=data.map(r=>Number(r.low));
  const pad=24,plotH=h-48,step=(w-pad*2)/Math.max(1,data.length);
  const newsMetrics=window.AITNews?.symbolMetrics(w,h);
  const newsBounds=window.AITNews?.bounds(data,newsEvents,plotH,newsMetrics),max=newsBounds?.max??Math.max(...highs),min=newsBounds?.min??Math.min(...lows);
  const y=v=>pad+(max-v)/(max-min||1)*plotH;
  window.AITNews?.watermark(ctx,pad,pad,w-pad*2,plotH);
  const css=getComputedStyle(document.documentElement);
  const grid=css.getPropertyValue("--v10-line").trim()||"rgba(255,255,255,.15)";
  const up=css.getPropertyValue("--v10-success").trim()||"#22c55e";
  const down=css.getPropertyValue("--v10-danger").trim()||"#ef4444";
  const accent=css.getPropertyValue("--v10-primary").trim()||"#38bdf8";
  if(document.getElementById("v11Grid")?.checked){
   ctx.strokeStyle=grid;ctx.lineWidth=1;
   for(let i=0;i<5;i++){const yy=pad+(plotH/4)*i;ctx.beginPath();ctx.moveTo(pad,yy);ctx.lineTo(w-pad,yy);ctx.stroke()}
  }
  data.forEach((r,i)=>{
   const x=pad+i*step+step/2;
   const o=Number(r.open),c=Number(r.close),hi=Number(r.high),lo=Number(r.low);
   ctx.strokeStyle=c>=o?up:down;ctx.fillStyle=ctx.strokeStyle;
   ctx.beginPath();ctx.moveTo(x,y(hi));ctx.lineTo(x,y(lo));ctx.stroke();
   const top=Math.min(y(o),y(c)),height=Math.max(1,Math.abs(y(c)-y(o)));
   ctx.fillRect(x-Math.max(1,step*.28),top,Math.max(2,step*.56),height);
  });
  const closes=data.map(r=>Number(r.close));
  const drawSma=(period,color)=>{
   if(closes.length<period)return;
   ctx.strokeStyle=color;ctx.lineWidth=1.5;ctx.beginPath();let started=false;
  };
  function line(period,color){
   if(closes.length<period)return;
   ctx.strokeStyle=color;ctx.lineWidth=1.5;ctx.beginPath();let started=false;
   closes.forEach((_,i)=>{
    if(i<period-1)return;
    const value=avg(closes.slice(i-period+1,i+1));
    const x=pad+i*step+step/2,yy=y(value);
    if(!started){ctx.moveTo(x,yy);started=true}else ctx.lineTo(x,yy);
   });
   ctx.stroke();
  }
  if(document.getElementById("v11Sma20")?.checked)line(20,accent);
  if(document.getElementById("v11Sma50")?.checked)line(50,css.getPropertyValue("--v10-primary-2").trim()||"#8b5cf6");
  window.AITNews?.draw(ctx,canvas,newsEvents,i=>pad+i*step+step/2,y,newsMetrics);
  canvas.parentElement.querySelector(".v11-chart-label").textContent=code||"No symbol";
 }

 function renderCharts(){
  const count=Number(document.getElementById("v11ChartLayout")?.value||1);
  const grid=document.getElementById("v11ChartLayoutGrid");
  grid.className=`v11-chart-layout layout-${count}`;
  [...grid.children].forEach((slot,i)=>slot.hidden=i>=count);
  for(let i=1;i<=count;i++){
   const code=document.getElementById(`v11Symbol${i}`)?.value;
   const canvas=document.getElementById(`v11Canvas${i}`);
   if(canvas)drawChart(canvas,code);
  }
 }
 document.getElementById("v11RenderCharts")?.addEventListener("click",renderCharts);
 ["v11Sma20","v11Sma50","v11Grid"].forEach(id=>document.getElementById(id)?.addEventListener("change",renderCharts));
 window.addEventListener("resize",()=>setTimeout(renderCharts,80));
 setTimeout(renderCharts,500);

 function indicatorData(code){
  const rows=rowsFor(code),closes=rows.map(r=>Number(r.close)).filter(Number.isFinite);
  const current=last(closes);
  const s20=sma(closes,20),s50=sma(closes,50),r14=rsi(closes,14);
  const momentum=closes.length>10&&closes.at(-11)?((current/closes.at(-11))-1)*100:null;
  let points=0;
  if(s20&&current>s20)points++;
  if(s20&&s50&&s20>s50)points++;
  if(r14!==null&&r14>=45&&r14<=70)points++;
  if(momentum!==null&&momentum>0)points++;
  const signal=points>=3?"Buy":points===2?"Watch":"Avoid";

  // A continuous score makes stocks with the same signal rank consistently.
  const priceVsSma20=s20?((current/s20)-1)*100:0;
  const smaTrend=s20&&s50?((s20/s50)-1)*100:0;
  const rsiStrength=r14===null?0:Math.max(-15,Math.min(15,(r14-50)*0.75));
  const momentumStrength=momentum===null?0:Math.max(-20,Math.min(20,momentum));
  const strength=(points*100)+(priceVsSma20*2)+(smaTrend*2)+rsiStrength+momentumStrength;

  // Normalize the scanner result to a transparent 0–100 score for AIT Potential.
  let indicatorScore=points*18;
  indicatorScore+=Math.max(-8,Math.min(8,priceVsSma20*1.5));
  indicatorScore+=Math.max(-8,Math.min(8,smaTrend*1.5));
  indicatorScore+=r14===null?0:Math.max(-8,Math.min(8,(r14-50)*0.4));
  indicatorScore+=momentum===null?0:Math.max(-8,Math.min(8,momentum*0.8));
  indicatorScore=Math.max(0,Math.min(100,Math.round(indicatorScore)));

  return {code,current,s20,s50,r14,momentum,signal,points,strength,indicatorScore};
 }
 function runScanner(){
  const data=scannerCodes()
   .map(indicatorData)
   .filter(x=>x.current!==null)
   .sort((a,b)=>
    (b.indicatorScore-a.indicatorScore)||
    (b.strength-a.strength)||
    ((b.momentum??-Infinity)-(a.momentum??-Infinity))||
    a.code.localeCompare(b.code)
   );
  const tbody=document.getElementById("v11IndicatorRows");
  tbody.innerHTML=data.length?data.map(x=>`<tr><td>${esc(x.code)}</td><td>${fmt(x.current)}</td><td>${fmt(x.s20)}</td><td>${fmt(x.s50)}</td><td>${fmt(x.r14,1)}</td><td>${fmt(x.momentum,1)}%</td><td><span class="v11-score">${fmt(x.indicatorScore,0)}</span></td><td><span class="v11-signal ${x.signal.toLowerCase()}">${x.signal}</span></td></tr>`).join(""):'<tr><td colspan="8">No local data.</td></tr>';
  return data;
 }
 document.getElementById("v11RunScanner")?.addEventListener("click",runScanner);

 function comparisonData(code){
  const rows=rowsFor(code),closes=rows.map(r=>Number(r.close)).filter(Number.isFinite);
  const vols=rows.map(r=>Number(r.volume||0)).filter(Number.isFinite);
  if(closes.length<2)return null;
  const recent=closes.slice(-20),returns=[];
  for(let i=1;i<recent.length;i++)returns.push((recent[i]/recent[i-1]-1)*100);
  const ret20=recent.length>1?(recent.at(-1)/recent[0]-1)*100:0;
  const volatility=std(returns);
  const rv=vols.length?((vols.at(-1)||0)/(avg(vols.slice(-20))||1)):0;
  const momentum=closes.length>10?(closes.at(-1)/closes.at(-11)-1)*100:0;
  return {code,last:closes.at(-1),ret20,volatility,rv,momentum};
 }
 function comparisonDataset(){
  const data=scannerCodes().map(comparisonData).filter(Boolean);
  const normalize=(value,key,inverse=false)=>{
   const values=data.map(x=>Number(x[key])).filter(Number.isFinite),min=Math.min(...values),max=Math.max(...values);
   if(!values.length||max===min)return 50;
   const n=((value-min)/(max-min))*100;
   return inverse?100-n:n;
  };
  return data.map(x=>{
   const returnRank=normalize(x.ret20,"ret20");
   const momentumRank=normalize(x.momentum,"momentum");
   const volumeRank=normalize(Math.min(x.rv,3),"rv");
   const stabilityRank=normalize(x.volatility,"volatility",true);
   let score=Math.round((returnRank*.30+momentumRank*.25+volumeRank*.20+stabilityRank*.25)*10)/10;
   if(x.ret20<0&&x.momentum<0)score=Math.min(score,44.9);
   const relativeSignal=score>=75&&x.ret20>0&&x.momentum>0?"Leader":score>=60&&(x.ret20>0||x.momentum>0)?"Outperform":score>=45?"Neutral":"Laggard";
   return {...x,score,signal:relativeSignal,relativeSignal,returnRank,momentumRank,volumeRank,stabilityRank};
  }).sort((a,b)=>b.score-a.score||b.ret20-a.ret20||a.code.localeCompare(b.code));
 }
 function runComparison(){
  const data=comparisonDataset();
  document.getElementById("v11ComparisonRows").innerHTML=data.length?data.map((x,index)=>`<tr><td><strong>#${index+1}</strong></td><td><strong>${esc(x.code)}</strong></td><td>${fmt(x.last)}</td><td>${fmt(x.ret20,1)}%</td><td>${fmt(x.volatility,2)}%</td><td>${fmt(x.rv,2)}×</td><td>${fmt(x.momentum,1)}%</td><td><span class="v11-score">${fmt(x.score,1)}</span></td><td><span class="v11-signal ${x.relativeSignal.toLowerCase().replace(/\s+/g,"-")}">${x.relativeSignal}</span></td></tr>`).join(""):'<tr><td colspan="9">No local data.</td></tr>';
  const maxBy=(key,asc=false)=>data.length?[...data].sort((a,b)=>asc?a[key]-b[key]:b[key]-a[key])[0]:null;
  const best=maxBy("ret20"),low=maxBy("volatility",true),rv=maxBy("rv"),mom=maxBy("momentum");
  document.getElementById("v11BestReturn").textContent=best?`${best.code} ${fmt(best.ret20,1)}%`:"—";
  document.getElementById("v11LowVol").textContent=low?`${low.code} ${fmt(low.volatility,2)}%`:"—";
  document.getElementById("v11HighRv").textContent=rv?`${rv.code} ${fmt(rv.rv,2)}×`:"—";
  document.getElementById("v11Momentum").textContent=mom?`${mom.code} ${fmt(mom.momentum,1)}%`:"—";
  return data;
 }
 document.getElementById("v11RunComparison")?.addEventListener("click",runComparison);

 function savePortfolio(){try{localStorage.setItem(PORTFOLIO_KEY,JSON.stringify(portfolio))}catch{}}
 function renderPortfolio(){
  const tbody=document.getElementById("v11PortfolioRows");
  let grossCost=0,marketValue=0,totalCommission=0,netPl=0;
  tbody.innerHTML=portfolio.length?portfolio.map((p,i)=>{
   const row=last(rowsFor(p.code)),lastClose=Number(row?.close||0);
   const qty=Number(p.qty||0),buy=Number(p.buy||0),commissionRate=Math.max(0,Number(p.commissionRate??0.4));
   const costingRate=buy*(1+(commissionRate/100));
   const grossPositionCost=qty*buy;
   const grossPositionValue=qty*lastClose;
   const buyCommission=grossPositionCost*(commissionRate/100);
   const estimatedSellCommission=grossPositionValue*(commissionRate/100);
   const positionCommission=buyCommission+estimatedSellCommission;
   const adjustedCost=grossPositionCost+buyCommission;
   const netValue=grossPositionValue-estimatedSellCommission;
   const positionPl=netValue-adjustedCost;
   const positionPlPercent=adjustedCost>0?(positionPl/adjustedCost)*100:0;
   grossCost+=adjustedCost;marketValue+=netValue;totalCommission+=positionCommission;netPl+=positionPl;
   const plClass=positionPl>0?"positive":positionPl<0?"negative":"";
   return `<tr><td>${esc(p.code)}</td><td>${fmt(qty,0)}</td><td>${fmt(buy)}</td><td>${fmt(positionCommission)} <small>(${fmt(commissionRate,2)}%)</small></td><td>${fmt(costingRate)}</td><td>${fmt(adjustedCost)}</td><td>${fmt(lastClose)}</td><td>${fmt(netValue)}</td><td class="${plClass}">${fmt(positionPl)}</td><td class="${plClass}">${fmt(positionPlPercent,2)}%</td><td><div class="v11-portfolio-row-actions"><button class="btn soft" type="button" data-edit-position="${i}">Edit</button><button class="btn danger" type="button" data-remove-position="${i}">Remove</button></div></td></tr>`;
  }).join(""):'<tr><td colspan="11">No positions added.</td></tr>';
  tbody.querySelectorAll("[data-edit-position]").forEach(btn=>btn.addEventListener("click",()=>{
   const index=Number(btn.dataset.editPosition),position=portfolio[index];
   if(!position)return;
   portfolioEditIndex=index;
   document.getElementById("v11PortfolioCode").value=String(position.code||"");
   document.getElementById("v11PortfolioQty").value=String(position.qty??"");
   document.getElementById("v11PortfolioBuy").value=String(position.buy??"");
   document.getElementById("v11PortfolioCommissionRate").value=String(position.commissionRate??0.4);
   const submit=document.getElementById("v11AddPosition"),cancel=document.getElementById("v11CancelPositionEdit");
   if(submit)submit.textContent="Update position";
   if(cancel)cancel.hidden=false;
   const title=document.getElementById("v11PortfolioModalTitle");
   if(title)title.textContent="Edit portfolio position";
   document.getElementById("v11PortfolioModal")?.classList.add("open");
   document.getElementById("v11PortfolioQty")?.focus();
  }));
  tbody.querySelectorAll("[data-remove-position]").forEach(btn=>btn.addEventListener("click",()=>{
   const index=Number(btn.dataset.removePosition);
   portfolio.splice(index,1);
   if(portfolioEditIndex===index)resetPortfolioForm();
   else if(portfolioEditIndex>index)portfolioEditIndex--;
   savePortfolio();renderPortfolio();
  }));
  const portfolioPlPercent=grossCost>0?(netPl/grossCost)*100:0;
  document.getElementById("v11PortfolioCost").textContent=fmt(grossCost);
  document.getElementById("v11PortfolioValue").textContent=fmt(marketValue);
  document.getElementById("v11PortfolioCommission").textContent=fmt(totalCommission);
  document.getElementById("v11PortfolioPl").textContent=fmt(netPl);
  document.getElementById("v11PortfolioPlPercent").textContent=`${fmt(portfolioPlPercent,2)}%`;
  document.getElementById("v11PortfolioCount").textContent=portfolio.length;
 }
 function resetPortfolioForm(){
  portfolioEditIndex=-1;
  const qty=document.getElementById("v11PortfolioQty"),buy=document.getElementById("v11PortfolioBuy"),commission=document.getElementById("v11PortfolioCommissionRate"),submit=document.getElementById("v11AddPosition"),cancel=document.getElementById("v11CancelPositionEdit");
  if(qty)qty.value="";
  if(buy)buy.value="";
  if(commission)commission.value="0.4";
  if(submit)submit.textContent="Add position";
  if(cancel)cancel.hidden=false;
  const title=document.getElementById("v11PortfolioModalTitle");
  if(title)title.textContent="Add portfolio position";
 }
 function openPortfolioModal(){
  resetPortfolioForm();
  document.getElementById("v11PortfolioModal")?.classList.add("open");
  document.getElementById("v11PortfolioCode")?.focus();
 }
 function closePortfolioModal(){
  document.getElementById("v11PortfolioModal")?.classList.remove("open");
  resetPortfolioForm();
 }
 document.getElementById("v11OpenPortfolioModal")?.addEventListener("click",openPortfolioModal);
 document.getElementById("v11ClosePortfolioModal")?.addEventListener("click",closePortfolioModal);
 document.getElementById("v11CancelPositionEdit")?.addEventListener("click",closePortfolioModal);
 document.getElementById("v11PortfolioModal")?.addEventListener("click",event=>{if(event.target===event.currentTarget)closePortfolioModal()});
 document.addEventListener("keydown",event=>{if(event.key==="Escape"&&document.getElementById("v11PortfolioModal")?.classList.contains("open"))closePortfolioModal()});
 document.getElementById("v11AddPosition")?.addEventListener("click",()=>{
  const code=String(document.getElementById("v11PortfolioCode")?.value||"").trim().toUpperCase();
  const qty=Number(document.getElementById("v11PortfolioQty")?.value);
  const buy=Number(document.getElementById("v11PortfolioBuy")?.value);
  const commissionRate=Number(document.getElementById("v11PortfolioCommissionRate")?.value||0.4);
  if(!code||!Number.isFinite(qty)||qty<=0||!Number.isFinite(buy)||buy<=0||!Number.isFinite(commissionRate)||commissionRate<0||commissionRate>100)return;
  const position={code,qty,buy,commissionRate};
  if(portfolioEditIndex>=0&&portfolio[portfolioEditIndex])portfolio[portfolioEditIndex]=position;else portfolio.push(position);
  savePortfolio();renderPortfolio();closePortfolioModal();
 });
 renderPortfolio();

 function vpaData(code){
  const rows=rowsFor(code);
  if(rows.length<10)return null;
  const r=rows.at(-1),prev=rows.at(-2);
  const spread=Math.abs(Number(r.high)-Number(r.low));
  const avgSpread=avg(rows.slice(-20).map(x=>Math.abs(Number(x.high)-Number(x.low))))||1;
  const relSpread=spread/avgSpread;
  const relVolume=Number(r.volume||0)/(avg(rows.slice(-20).map(x=>Number(x.volume||0)))||1);
  const closePos=(Number(r.close)-Number(r.low))/(spread||1);
  const trend=Number(r.close)>avg(rows.slice(-20).map(x=>Number(x.close)))?"Up":"Down";
  const result=Math.abs(Number(r.close)-Number(prev.close))/(spread||1);
  let score=50;
  if(trend==="Up")score+=12;else score-=10;
  if(relVolume>1.2&&closePos>.65)score+=14;
  if(relVolume>1.5&&result<.25)score-=8;
  if(relSpread>1.2&&closePos>.6)score+=8;
  if(closePos<.35)score-=10;
  score=Math.max(0,Math.min(100,Math.round(score)));
  const cls=score>=75?"Buy":score>=55?"Watch":"Avoid";
  const effort=relVolume>1.3&&result<.3?"High effort / low result":relVolume>1.1?"Confirmed effort":"Normal";
  return {code,score,relSpread,relVolume,trend,effort,cls};
 }
 function runVpa(){
  const data=scannerCodes().map(vpaData).filter(Boolean).sort((a,b)=>b.score-a.score);
  document.getElementById("v11VpaRows").innerHTML=data.length?data.map(x=>`<tr><td>${esc(x.code)}</td><td><span class="v11-score">${x.score}</span></td><td>${fmt(x.relSpread,2)}×</td><td>${fmt(x.relVolume,2)}×</td><td>${x.trend}</td><td>${esc(x.effort)}</td><td><span class="v11-signal ${x.cls.toLowerCase()}">${x.cls}</span></td></tr>`).join(""):'<tr><td colspan="7">No sufficient local data.</td></tr>';
  return data;
 }
 document.getElementById("v11RunVpa")?.addEventListener("click",runVpa);

 function potentialData(code,comparisonMap=null){
  const indicator=indicatorData(code);
  const vpa=vpaData(code);
  if(indicator.current===null||!vpa)return null;
  if(!comparisonMap)comparisonMap=new Map(comparisonDataset().map(x=>[x.code,x]));
  const comparison=comparisonMap.get(code);
  const indicatorScore=indicator.indicatorScore;
  const vpaScore=vpa.score;
  const comparisonScore=comparison?comparison.score:50;
  const comparisonSignal=comparison?.relativeSignal||"Neutral";
  const primaryScore=Math.round(((indicatorScore*.50)+(vpaScore*.50))*10)/10;
  const signal=primaryScore>=75&&indicatorScore>=60&&vpaScore>=60?"Strong Buy":primaryScore>=62?"Buy":primaryScore>=48?"Watch":"Avoid";
  return {code,ltp:indicator.current,indicatorScore,vpaScore,comparisonScore,comparisonSignal,primaryScore,combinedScore:primaryScore,signal};
 }
 function rankPotentialData(items){
  const base=[...items].sort((a,b)=>(b.primaryScore-a.primaryScore)||(b.vpaScore-a.vpaScore)||(b.indicatorScore-a.indicatorScore)||a.code.localeCompare(b.code));
  const ranked=[];
  for(let i=0;i<base.length;){
   const anchor=base[i].primaryScore;
   let j=i+1;
   while(j<base.length&&(anchor-base[j].primaryScore)<5)j++;
   const group=base.slice(i,j).sort((a,b)=>(b.comparisonScore-a.comparisonScore)||(b.primaryScore-a.primaryScore)||(b.vpaScore-a.vpaScore)||(b.indicatorScore-a.indicatorScore)||a.code.localeCompare(b.code));
   ranked.push(...group);
   i=j;
  }
  return ranked.map((x,index)=>({...x,rank:index+1}));
 }
 function potentialDataset(){
  const comparisonMap=new Map(comparisonDataset().map(x=>[x.code,x]));
  return rankPotentialData(scannerCodes().map(code=>potentialData(code,comparisonMap)).filter(Boolean));
 }
 function runPotential(){
  const tbody=document.getElementById("v11PotentialRows");
  if(!tbody)return [];
  const data=potentialDataset();
  tbody.innerHTML=data.length?data.map(x=>`<tr>
   <td><strong>#${x.rank}</strong></td><td><strong>${esc(x.code)}</strong></td><td>${fmt(x.ltp,2)}</td>
   <td><span class="v11-score">${fmt(x.indicatorScore,0)}</span></td>
   <td><span class="v11-score">${fmt(x.vpaScore,0)}</span></td>
   <td><span class="v11-score">${fmt(x.primaryScore,1)}</span></td>
   <td><span class="v11-score">${fmt(x.comparisonScore,1)}</span><small style="display:block">${esc(x.comparisonSignal)}</small></td>
   <td><div class="v11-strength" aria-label="Strength ${fmt(x.primaryScore,1)} percent"><span class="v11-strength-track"><span class="v11-strength-fill" style="--v11-strength:${Math.max(0,Math.min(100,x.primaryScore))}%"></span></span><span class="v11-strength-value">${fmt(x.primaryScore,1)}%</span></div></td>
   <td><span class="v11-signal ${x.signal.toLowerCase().replace(/\s+/g,"-")}">${x.signal}</span></td>
  </tr>`).join(""):'<tr><td colspan="9">No sufficient local data for primary analysis.</td></tr>';
  return data;
 }
 document.getElementById("v11RunPotential")?.addEventListener("click",runPotential);

 function compositeDataset(){
  const comparisonMap=new Map(comparisonDataset().map(x=>[x.code,x]));
  return scannerCodes().map(code=>{
   const item=potentialData(code,comparisonMap); if(!item)return null;
   const combinedScore=Math.round((item.indicatorScore*.40+item.vpaScore*.35+item.comparisonScore*.25)*10)/10;
   const signal=combinedScore>=75&&item.indicatorScore>=60&&item.vpaScore>=60?"Strong Buy":combinedScore>=62?"Buy":combinedScore>=48?"Watch":"Avoid";
   return {...item,combinedScore,signal};
  }).filter(Boolean).sort((a,b)=>(b.combinedScore-a.combinedScore)||(b.vpaScore-a.vpaScore)||(b.indicatorScore-a.indicatorScore)||a.code.localeCompare(b.code)).map((x,index)=>({...x,rank:index+1}));
 }
 const prioritySnapshotCache={historySignature:"",rowsByDate:new Map()};
 function scannerHistorySignature(){
  const {app}=appState(),history=scannerHistory(),universe=scannerUniverseSignature();
  try{return `${universe}::${app?.store?.historySignature?.(history)||`${Object.keys(history).length}|${Object.values(history).reduce((sum,rows)=>sum+(Array.isArray(rows)?rows.length:0),0)}`}`}
  catch{return `${scannerUniverseSignature()}::unavailable`}
 }
 function clearPrioritySnapshotCache(){
  prioritySnapshotCache.historySignature="";
  prioritySnapshotCache.rowsByDate.clear();
 }
 function priorityDataset(){
  const historySignature=scannerHistorySignature();
  if(prioritySnapshotCache.historySignature!==historySignature){
   prioritySnapshotCache.historySignature=historySignature;
   prioritySnapshotCache.rowsByDate.clear();
  }
  const snapshotKey=String(window.__AIT_HISTORICAL_CUTOFF_DATE__||"latest");
  const cached=prioritySnapshotCache.rowsByDate.get(snapshotKey);
  if(cached)return cached.map(row=>({...row}));
  const priority={"Strong Buy":4,"Buy":3,"Watch":2,"Avoid":1};
  const source=potentialDataset();
  const groups=new Map();
  source.forEach(x=>{if(!groups.has(x.signal))groups.set(x.signal,[]);groups.get(x.signal).push(x);});
  const output=[];
  ["Strong Buy","Buy","Watch","Avoid"].forEach(signal=>{
   const group=groups.get(signal)||[];
   group.sort((a,b)=>(b.primaryScore-a.primaryScore)||(b.comparisonScore-a.comparisonScore)||(b.vpaScore-a.vpaScore)||(b.indicatorScore-a.indicatorScore)||a.code.localeCompare(b.code));
   // Relative Strength only reorders close Primary Scores inside the same signal group.
   const ranked=[];
   for(let i=0;i<group.length;){
    const anchor=group[i].primaryScore;let j=i+1;
    while(j<group.length&&(anchor-group[j].primaryScore)<5)j++;
    ranked.push(...group.slice(i,j).sort((a,b)=>(b.comparisonScore-a.comparisonScore)||(b.primaryScore-a.primaryScore)||a.code.localeCompare(b.code)));
    i=j;
   }
   ranked.forEach((x,index)=>output.push({...x,signalRank:index+1,signalPriority:priority[signal]}));
  });
  const result=output.map((x,index)=>({...x,rank:index+1}));
  prioritySnapshotCache.rowsByDate.set(snapshotKey,result.map(row=>({...row})));
  if(prioritySnapshotCache.rowsByDate.size>400){
   const oldest=prioritySnapshotCache.rowsByDate.keys().next().value;
   prioritySnapshotCache.rowsByDate.delete(oldest);
  }
  return result;
 }
 // Shared scanner-data bridge for modules declared outside this initialization scope.
 window.AITScannerDataBridge={
  appState,
  rowsFor,
  codes:scannerCodes,
  scannerCodes,
  allCodes,
  scannerHistory,
  scannerUniverseSignature,
  scannerHistorySignature,
  indicatorData,
  vpaData,
  comparisonDataset,
  potentialDataset,
  priorityDataset,
  clearPrioritySnapshotCache
 };
 ["ait:ohlc-history-changed","ait:instant-dse-merged","ait:ohlc-data-cleared","ait:active-watchlist-changed"].forEach(eventName=>window.addEventListener(eventName,()=>{
  clearPrioritySnapshotCache();
  window.AitSignalPriorityHistory?.clearCache?.();
  window.AitAdvancedSignalPriority?.clearCache?.();
  window.AitEliteSignalPriority?.clearCache?.();
 }));

 function renderPotentialRows(tbodyId,data,mode){
  const tbody=document.getElementById(tbodyId);if(!tbody)return data;
  if(mode==="priority"){
   tbody.innerHTML=data.length?data.map(x=>`<tr><td><strong>#${x.rank}</strong></td><td><strong>${esc(x.signal)} #${x.signalRank}</strong></td><td><strong>${esc(x.code)}</strong></td><td>${fmt(x.ltp,2)}</td><td><span class="v11-score">${fmt(x.indicatorScore,0)}</span></td><td><span class="v11-score">${fmt(x.vpaScore,0)}</span></td><td><span class="v11-score">${fmt(x.primaryScore,1)}</span></td><td><span class="v11-score">${fmt(x.comparisonScore,1)}</span><small style="display:block">${esc(x.comparisonSignal)}</small></td><td><span class="v11-signal ${x.signal.toLowerCase().replace(/\s+/g,"-")}">${x.signal}</span></td></tr>`).join(""):'<tr><td colspan="9">No sufficient local data.</td></tr>';
  }else{
   tbody.innerHTML=data.length?data.map(x=>`<tr><td><strong>#${x.rank}</strong></td><td><strong>${esc(x.code)}</strong></td><td>${fmt(x.ltp,2)}</td><td><span class="v11-score">${fmt(x.indicatorScore,0)}</span></td><td><span class="v11-score">${fmt(x.vpaScore,0)}</span></td><td><span class="v11-score">${fmt(x.comparisonScore,1)}</span></td><td><span class="v11-score">${fmt(x.combinedScore,1)}</span></td><td><div class="v11-strength"><span class="v11-strength-track"><span class="v11-strength-fill" style="--v11-strength:${Math.max(0,Math.min(100,x.combinedScore))}%"></span></span><span class="v11-strength-value">${fmt(x.combinedScore,1)}%</span></div></td><td><span class="v11-signal ${x.signal.toLowerCase().replace(/\s+/g,"-")}">${x.signal}</span></td></tr>`).join(""):'<tr><td colspan="9">No sufficient local data.</td></tr>';
  }
  return data;
 }
 function runComposite(){return renderPotentialRows("v11CompositeRows",compositeDataset(),"composite");}
 function runPriority(){return renderPotentialRows("v11PriorityRows",priorityDataset(),"priority");}
 document.getElementById("v11RunComposite")?.addEventListener("click",runComposite);
 document.getElementById("v11RunPriority")?.addEventListener("click",runPriority);

 function rankedChartData(mode){
  if(mode==="indicator"){
   return scannerCodes().map(indicatorData).filter(x=>x&&x.current!==null).map(x=>({
    code:x.code,ltp:x.current,score:Number(x.indicatorScore||0),signal:x.signal||"Avoid",
    scoreLabel:"Technical Score"
   })).sort((a,b)=>(b.score-a.score)||a.code.localeCompare(b.code));
  }
  if(mode==="vpa"){
   return scannerCodes().map(vpaData).filter(Boolean).map(x=>({
    code:x.code,ltp:last(rowsFor(x.code))?.close??null,score:Number(x.score||0),signal:x.cls||"Avoid",
    scoreLabel:"Smart Money Score"
   })).sort((a,b)=>(b.score-a.score)||a.code.localeCompare(b.code));
  }
  if(mode==="comparison"){
   return comparisonDataset().map(x=>({code:x.code,ltp:x.close,score:Number(x.comparisonScore||0),signal:x.comparisonSignal||"Neutral",scoreLabel:"Relative Score",rank:x.rank}));
  }
  if(mode==="composite"){
   return compositeDataset().map(x=>({code:x.code,ltp:x.ltp,score:Number(x.combinedScore||0),signal:x.signal||"Avoid",scoreLabel:"Combined Score",rank:x.rank}));
  }
  if(mode==="priority"){
   return priorityDataset().map(x=>({code:x.code,ltp:x.ltp,score:Number(x.primaryScore||0),signal:x.signal||"Avoid",scoreLabel:"Primary Score",rank:x.rank}));
  }
  if(mode==="historical"){
   const result=window.AitSignalPriorityHistory?.calculate?.();
   return (result?.rows||[]).map(x=>({code:x.code,ltp:last(rowsFor(x.code))?.close??null,score:Number(x.historicalScore||0),signal:x.signal||"Avoid",scoreLabel:"Historical Score",rank:x.rank}));
  }
  if(mode==="advanced"){
   const result=window.AitAdvancedSignalPriority?.calculate?.();
   return (result?.rows||[]).map(x=>({code:x.code,ltp:last(rowsFor(x.code))?.close??null,score:Number(x.advancedScore||0),signal:x.signal||"Avoid",scoreLabel:"Advanced Score",rank:x.rank}));
  }
  const addGroupedSignalRanks = rows => {
   const groups = new Map();
   rows.forEach(row => {
    const key = String(row.signal || "Watch");
    if(!groups.has(key)) groups.set(key, 0);
    groups.set(key, groups.get(key) + 1);
    row.signalRank = groups.get(key);
   });
   return rows;
  };
  if(["elite-priority-2d","elite-regime-2d","elite-priority-3d","elite-regime-3d","elite-priority-6d","elite-regime-6d"].includes(mode)){
   const regimeMode=mode.includes("regime"),days=Number(mode.match(/(2|3|6)d$/)[1]);
   const source=regimeMode?window[`AitEliteRegime${days}d`]?.calculate?.():(window[`AitElite${days}d`]?.calculate?.()?.rows||[]);
   const rows=(source||[]).map((x,index)=>({
    code:x.code,
    ltp:Number.isFinite(Number(x.ltp))?Number(x.ltp):last(rowsFor(x.code))?.close??null,
    score:Number(regimeMode?x.regimeScore:x.eliteScore)||0,
    signal:x.finalSignal||x.signal||"Avoid",
    scoreLabel:regimeMode?`${days}D Regime Score`:`${days}D Elite Score`,
    rank:index+1,
    priority:regimeMode?String(x.decision?.action||"WATCH"):String(x.calibratedPriority||"Watch"),
    action:regimeMode?x.decision?.action:x.tradeAction
   }));
   return addGroupedSignalRanks(rows);
  }
  if(mode==="elite-regime"){
   const result=window.AITEliteRegime?.run?.()||[];
   const rows=(result||[]).map(x=>({
    code:x.code,
    ltp:Number.isFinite(Number(x.ltp))?Number(x.ltp):last(rowsFor(x.code))?.close??null,
    score:Number(x.regimeScore||0),
    signal:x.signal||x.setupSignal||"Watch",
    scoreLabel:"Regime Score",
    rank:Number(x.rank)||0,
    priority:String(x?.priority?.label||x?.priority||((x.action==="BUY NOW")?"HIGH":x.action==="CONFIRMATION"?"MEDIUM":x.action==="WATCH"?"LOW":"AVOID")),
    action:x.action||"WATCH"
   })).sort((a,b)=>(a.rank||999999)-(b.rank||999999)||(b.score-a.score)||a.code.localeCompare(b.code));
   return addGroupedSignalRanks(rows);
  }
  if(mode==="elite-priority"){
   const result=window.AitEliteSignalPriority?.calculate?.();
   const rows=(result?.rows||[]).map(x=>({
    code:x.code,
    ltp:last(rowsFor(x.code))?.close??null,
    score:Number(x.eliteScore||0),
    signal:x.finalSignal||x.signal||"Avoid",
    scoreLabel:"Elite Score",
    rank:Number(x.rank)||0,
    priority:String(x.calibratedPriority||"Watch")
   })).sort((a,b)=>(a.rank||999999)-(b.rank||999999)||(b.score-a.score)||a.code.localeCompare(b.code));
   return addGroupedSignalRanks(rows);
  }
  return potentialDataset().map(x=>({
   code:x.code,ltp:x.ltp,score:Number(x.primaryScore||0),signal:x.signal||"Avoid",
   scoreLabel:"Primary score",rank:x.rank,comparisonScore:x.comparisonScore
  }));
 }

 function openRankedCharts(mode="potential",months=3){
  const period=[3,6,12].includes(Number(months))?Number(months):3;
  const periodLabel=period===12?"1Y":`${period}M`;
  const modal=document.getElementById("v11RankedChartModal");
  const gallery=document.getElementById("v11RankedChartGallery");
  const summary=document.getElementById("v11RankedChartSummary");
  const title=document.getElementById("v11RankedChartTitle");
  if(!modal||!gallery||!summary||!title)return;

  // Preserve the terminal's active theme tokens before promoting the modal
  // to <body>. The terminal applies part of its palette on a scoped ancestor,
  // so moving the modal without copying these values causes mismatched surfaces.
  const themeSource=
   document.querySelector("#aitPsaTradingModal:not([hidden])")||
   document.getElementById("v11Terminal")||
   document.querySelector(".ait-psa-terminal-modal:not([hidden])")||
   document.documentElement;
  const themeStyles=getComputedStyle(themeSource);
  const terminalPanel=themeStyles.getPropertyValue("--v10-panel-solid").trim()||themeStyles.getPropertyValue("--v10-card").trim()||themeStyles.backgroundColor;
  const terminalCard=themeStyles.getPropertyValue("--v10-card").trim()||terminalPanel;
  modal.style.setProperty("--v1125-surface-1",terminalPanel);
  modal.style.setProperty("--v1125-surface-2",terminalCard);
  [
   "--v10-bg","--v10-bg-soft","--v10-panel","--v10-panel-solid","--v10-card",
   "--v10-card-2","--v10-text","--v10-muted","--v10-line","--v10-primary",
   "--v10-primary-2","--v10-accent","--v10-shadow","--v1125-surface-1",
   "--v1125-surface-2","--v1125-surface-soft","--v1125-text","--v1125-muted",
   "--v1125-border","--v1125-accent"
  ].forEach(token=>{
   const value=themeStyles.getPropertyValue(token).trim();
   if(value)modal.style.setProperty(token,value);
  });

  // Use the terminal shell's actual rendered backdrop/shadow values for the
  // promoted modal instead of generic fixed colors.
  const sourceBackground=themeStyles.backgroundColor;
  const sourceShadow=themeStyles.getPropertyValue("--v10-shadow").trim();
  modal.style.setProperty("--v1125-overlay",
   sourceBackground&&sourceBackground!=="rgba(0, 0, 0, 0)"
    ?`color-mix(in srgb, ${sourceBackground} 76%, transparent)`
    :"rgba(2,6,23,.72)"
  );
  modal.style.setProperty("--v1125-shadow",sourceShadow||"rgba(2,6,23,.18)");

  // Keep the functional chart modal above the full-screen terminal shell.
  if(modal.parentElement!==document.body)document.body.appendChild(modal);

  const config={
   indicator:{title:`Technical Scanner — Ranked ${periodLabel} Charts`,description:"Technical Score"},
   vpa:{title:`Smart Money Scanner — Ranked ${periodLabel} Charts`,description:"Smart Money Score"},
   comparison:{title:`Relative Strength Scanner — Ranked ${periodLabel} Charts`,description:"Relative Score"},
   composite:{title:`AIT Composite Screener — Ranked ${periodLabel} Charts`,description:"40/35/25 Combined Score"},
   potential:{title:`AIT Elite Screener — Ranked ${periodLabel} Charts`,description:"50/50 Technical–Smart Money Primary Score; Relative Strength breaks close ties"},
   priority:{title:`AIT Signal Priority Screener — Ranked ${periodLabel} Charts`,description:"signal-priority order, then Primary Score"},
   historical:{title:`AIT Signal Priority Historical Performance — Ranked ${period===12?"1Y":period+"M"} Charts`,description:"Final Historical Score within Strong Buy → Buy → Watch → Avoid"},
   advanced:{title:`AIT Signal Priority Advanced Performance — Ranked ${period===12?"1Y":period+"M"} Charts`,description:"Advanced Score with momentum, stability, persistence and confirmation"},
   "elite-priority":{title:`AIT Signal Priority Elite Scanner — Ranked ${period===12?"1Y":period+"M"} Charts`,description:"calibrated Signal Rank (Strong Buy → Buy → Watch → Avoid), then Elite Score"},
   "elite-regime":{title:`AIT Elite Regime 9D — Ranked ${period===12?"1Y":period+"M"} Charts`,description:"regime-aware rank (Regime Score), preserving AIT Elite Regime scanner order"},
   "elite-priority-2d":{title:`AIT Elite 2D — Ranked ${period===12?"1Y":period+"M"} Charts`,description:"2D Elite rank and score"},
   "elite-regime-2d":{title:`AIT Elite Regime 2D — Ranked ${period===12?"1Y":period+"M"} Charts`,description:"2D regime-aware rank and score"},
   "elite-priority-3d":{title:`AIT Elite 3D — Ranked ${period===12?"1Y":period+"M"} Charts`,description:"3D Elite rank and score"},
   "elite-regime-3d":{title:`AIT Elite Regime 3D — Ranked ${period===12?"1Y":period+"M"} Charts`,description:"3D regime-aware rank and score"},
   "elite-priority-6d":{title:`AIT Elite 6D — Ranked ${period===12?"1Y":period+"M"} Charts`,description:"6D Elite rank and score"},
   "elite-regime-6d":{title:`AIT Elite Regime 6D — Ranked ${period===12?"1Y":period+"M"} Charts`,description:"6D regime-aware rank and score"}
  }[mode]||{title:`Ranked ${periodLabel} Charts`,description:"score"};
  const data=rankedChartData(mode);

  title.textContent=config.title;
  summary.textContent=data.length
   ?`${data.length} trading codes ranked from highest to lowest ${config.description}`
   :`No sufficient local data for ${config.description} charts`;

  if(window.AITChartGallerySearch)window.AITChartGallerySearch.reset("v11RankedChartGallery");
  gallery.innerHTML=data.length?data.map((x,index)=>{
   const rows=(window.app&&typeof window.app.rangeData==="function")?window.app.rangeData(x.code,period):rowsFor(x.code).slice(-(period===12?365:period===12?365:period===12?365:period===6?180:90));
   const coverage=rows.length?`${rows.length} sessions • ${rows[0].date} to ${rows[rows.length-1].date}`:"No archive data for this code";
   return `<div class="mini-card v11-ranked-mini-card" data-ranked-chart="${esc(x.code)}">
    <div class="row">
     <h3><span class="v11-ranked-number">#${index+1}</span> ${esc(x.code)}${mode.startsWith("elite-")&&x.signalRank?`<span class="v11-ranked-ranking-badge v11-ranked-ranking-badge--signal">${esc(String(x.signal||"Signal"))} #${x.signalRank}</span>`:""}${mode.startsWith("elite-")&&x.rank?`<span class="v11-ranked-ranking-badge v11-ranked-ranking-badge--overall">Overall #${x.rank}</span>`:""}${mode.startsWith("elite-")&&x.priority?`<span class="v11-ranked-priority-badge v11-ranked-priority-badge--${String(x.priority).toLowerCase().replace(/[^a-z0-9]+/g,"-").replace(/^-|-$/g,"")}">${esc(x.priority)}</span>`:""}</h3>
     <div class="actions">
      <button class="btn blue" type="button" data-open-ranked-code="${esc(x.code)}" ${rows.length?"":"disabled"}>Open</button>
      <a class="btn soft" href="https://www.amarstock.com/stock/${encodeURIComponent(x.code)}" target="_blank" rel="noopener noreferrer" title="View ${esc(x.code)} on AmarStock">Details</a>
     </div>
    </div>
    <div class="v11-ranked-summary-line">
     <span>LTP <b>${fmt(x.ltp,2)}</b></span>
     <span>${esc(x.scoreLabel)} <b>${fmt(x.score,1)}</b></span>
     <span class="v11-signal ${String(x.signal).toLowerCase().replace(/\s+/g,"-")}">${esc(x.signal)}</span>
    </div>
    ${(window.app&&typeof window.app.fundamentalHtml==="function")?window.app.fundamentalHtml(x.code):""}
    <div class="chart-box mini-chart"><canvas></canvas></div>
    <div class="small v11-ranked-coverage">${coverage}</div>
   </div>`;
  }).join(""):'<div class="empty">No sufficient local data for ranked charts.</div>';

  modal.dataset.mode=mode;modal.dataset.period=String(period);modal.classList.add("open");
  modal.setAttribute("aria-hidden","false");
  document.body.classList.add("v11-ranked-modal-open");

  requestAnimationFrame(()=>{
   data.forEach(x=>{
    const safeCode=window.CSS&&CSS.escape?CSS.escape(x.code):x.code.replace(/[^A-Za-z0-9_-]/g,"\\$&");
    const canvas=gallery.querySelector(`[data-ranked-chart="${safeCode}"] canvas`);
    if(!canvas)return;
    const rows=(window.app&&typeof window.app.rangeData==="function")?window.app.rangeData(x.code,period):rowsFor(x.code).slice(-(period===12?365:period===12?365:period===12?365:period===6?180:90));
    if(window.CandleChart&&typeof window.CandleChart.draw==="function")window.CandleChart.draw(canvas,rows,{code:x.code});
    else if(typeof CandleChart!=="undefined"&&typeof CandleChart.draw==="function")CandleChart.draw(canvas,rows,{code:x.code});
   });
   if(window.AITChartGallerySearch)window.AITChartGallerySearch.refresh("v11RankedChartGallery");
   gallery.querySelectorAll("[data-open-ranked-code]").forEach(button=>button.addEventListener("click",()=>{
    closeRankedCharts();
    if(window.app&&typeof window.app.openChart==="function"){
     window.app.openChart(button.dataset.openRankedCode);
     if(window.app.chartRange)window.app.chartRange.value=String(period);
     setTimeout(()=>window.app.drawCurrent?.(),60);
    }
   }));
  });
 }

 window.AITOpenRankedCharts=openRankedCharts;window.AITRefreshRankedCharts=()=>{const modal=document.getElementById("v11RankedChartModal");if(!modal?.classList.contains("open"))return;const mode=modal.dataset.mode||"potential";const period=Number(modal.dataset.period||3);openRankedCharts(mode,period);};

 function closeRankedCharts(){
  const modal=document.getElementById("v11RankedChartModal");
  modal?.classList.remove("open");
  modal?.setAttribute("aria-hidden","true");
  document.body.classList.remove("v11-ranked-modal-open");
 }

 document.getElementById("v11ViewPotentialCharts")?.addEventListener("click",()=>openRankedCharts("potential",3));
 document.getElementById("v11ViewPotentialCharts6")?.addEventListener("click",()=>openRankedCharts("potential",6));
 document.getElementById("v11ViewPotentialCharts12")?.addEventListener("click",()=>openRankedCharts("potential",12));
 document.getElementById("v11ViewIndicatorCharts")?.addEventListener("click",()=>openRankedCharts("indicator",3));
 document.getElementById("v11ViewIndicatorCharts6")?.addEventListener("click",()=>openRankedCharts("indicator",6));
 document.getElementById("v11ViewIndicatorCharts12")?.addEventListener("click",()=>openRankedCharts("indicator",12));
 document.getElementById("v11ViewVpaCharts")?.addEventListener("click",()=>openRankedCharts("vpa",3));
 document.getElementById("v11ViewVpaCharts6")?.addEventListener("click",()=>openRankedCharts("vpa",6));
 document.getElementById("v11ViewVpaCharts12")?.addEventListener("click",()=>openRankedCharts("vpa",12));
 document.getElementById("v11ViewComparisonCharts")?.addEventListener("click",()=>openRankedCharts("comparison",3));
 document.getElementById("v11ViewComparisonCharts6")?.addEventListener("click",()=>openRankedCharts("comparison",6));
 document.getElementById("v11ViewComparisonCharts12")?.addEventListener("click",()=>openRankedCharts("comparison",12));
 document.getElementById("v11ViewCompositeCharts")?.addEventListener("click",()=>openRankedCharts("composite",3));
 document.getElementById("v11ViewCompositeCharts6")?.addEventListener("click",()=>openRankedCharts("composite",6));
 document.getElementById("v11ViewCompositeCharts12")?.addEventListener("click",()=>openRankedCharts("composite",12));
 document.getElementById("v11ViewPriorityCharts")?.addEventListener("click",()=>openRankedCharts("priority",3));
 document.getElementById("v11ViewPriorityCharts6")?.addEventListener("click",()=>openRankedCharts("priority",6));
 document.getElementById("v11ViewPriorityCharts12")?.addEventListener("click",()=>openRankedCharts("priority",12));

 function syncScannerScrollbars(){
  document.querySelectorAll(".v11-scanner-table-region").forEach(region=>{
   const top=region.querySelector(".v11-table-scrollbar");
   const wrap=region.querySelector(".v11-scanner-table-wrap");
   const spacer=top?.firstElementChild;
   const table=wrap?.querySelector("table");
   if(!top||!wrap||!spacer||!table||top.dataset.synced)return;
   top.dataset.synced="1";
   const size=()=>{spacer.style.width=`${Math.max(table.scrollWidth,wrap.clientWidth)}px`;top.hidden=table.scrollWidth<=wrap.clientWidth+1;};
   let lock=false;
   top.addEventListener("scroll",()=>{if(lock)return;lock=true;wrap.scrollLeft=top.scrollLeft;requestAnimationFrame(()=>lock=false);});
   wrap.addEventListener("scroll",()=>{if(lock)return;lock=true;top.scrollLeft=wrap.scrollLeft;requestAnimationFrame(()=>lock=false);});
   new ResizeObserver(size).observe(table);new ResizeObserver(size).observe(wrap);size();
  });
 }
 function arrangeScannerLayouts(){
  document.querySelectorAll(".v11-scanner-card").forEach(card=>{
   const head=card.querySelector(":scope > .v11-card-head");
   const body=card.querySelector(":scope > .v11-card-body");
   const actions=head?.querySelector(".v11-potential-actions");
   const guideline=body?.querySelector(":scope > .v11-scanner-guideline, :scope > .v11-potential-guideline");
   if(!body||!guideline)return;
   guideline.classList.add("v11-scanner-guideline");
   body.insertBefore(guideline,body.firstElementChild);
   let row=body.querySelector(":scope > .v11-scanner-control-row");
   if(!row){
    row=document.createElement("div");
    row.className="v11-scanner-control-row";
    guideline.insertAdjacentElement("afterend",row);
   }
   if(actions)row.appendChild(actions);
  });
 }
 arrangeScannerLayouts();
 syncScannerScrollbars();
 window.addEventListener("resize",syncScannerScrollbars);
 document.querySelectorAll("[data-v11-tab]").forEach(button=>button.addEventListener("click",()=>setTimeout(syncScannerScrollbars,40)));
 document.getElementById("v11CloseRankedCharts")?.addEventListener("click",closeRankedCharts);
 document.getElementById("v11RankedChartModal")?.addEventListener("click",event=>{
  if(event.target===event.currentTarget)closeRankedCharts();
 });
 document.addEventListener("keydown",event=>{
  if(event.key==="Escape"&&document.getElementById("v11RankedChartModal")?.classList.contains("open"))closeRankedCharts();
 });

 function renderExplorer(){
  const q=(document.getElementById("v11ExplorerSearch")?.value||"").trim().toUpperCase();
  const all=codes().filter(c=>!q||c.includes(q));
  const container=document.getElementById("v11ExplorerResults");
  container.innerHTML=all.length?all.map(code=>{
   const rows=rowsFor(code),r=last(rows);
   return `<div class="v11-symbol-card"><strong>${esc(code)}</strong><small>${rows.length} records • Last ${fmt(r?.close)}</small><button class="btn soft" type="button" data-explorer-code="${esc(code)}">Open chart</button></div>`;
  }).join(""):'<div class="v11-empty">No matching symbols.</div>';
  container.querySelectorAll("[data-explorer-code]").forEach(btn=>btn.addEventListener("click",()=>{
   document.getElementById("v11Symbol1").value=btn.dataset.explorerCode;selectTab("charts");renderCharts();
  }));
  const {lists}=appState();
  const names=Array.isArray(lists)?lists.map(x=>x.name||"Watch list"):Object.keys(lists||{});
  document.getElementById("v11ExplorerLists").innerHTML=names.map(n=>`<span class="v11-chip">${esc(n)}</span>`).join("");
 }
 document.getElementById("v11ExplorerSearch")?.addEventListener("input",renderExplorer);
 renderExplorer();

 function buildReport(type){
  let text=`ABABIL DSE TERMINAL V11 REPORT\nGenerated: ${new Date().toLocaleString()}\n\n`;
  if(type==="watchlist"){
   const {active}=appState();
   text+=`ACTIVE WATCH LIST: ${active?.name||"Watch list"}\n`;
   (active?.codes||[]).forEach(code=>{const r=last(rowsFor(code));text+=`${code}: ${rowsFor(code).length} records, last close ${fmt(r?.close)}\n`});
  }else if(type==="technical"){
   text+="TECHNICAL SCANNER\n";
   runScanner().forEach(x=>text+=`${x.code}: Close ${fmt(x.current)}, SMA20 ${fmt(x.s20)}, SMA50 ${fmt(x.s50)}, RSI ${fmt(x.r14,1)}, ${x.signal}\n`);
  }else if(type==="comparison"){
   text+="STOCK COMPARISON\n";
   runComparison().forEach(x=>text+=`${x.code}: Score ${fmt(x.score,1)}, Signal ${x.signal}, Return ${fmt(x.ret20,1)}%, Volatility ${fmt(x.volatility,2)}%, RV ${fmt(x.rv,2)}x\n`);
  }else if(type==="portfolio"){
   text+="PORTFOLIO\n";
   portfolio.forEach(p=>{const lc=Number(last(rowsFor(p.code))?.close||0),rate=Math.max(0,Number(p.commissionRate??0.4)),costingRate=Number(p.buy||0)*(1+(rate/100)),grossCost=p.qty*p.buy,costValue=p.qty*costingRate,grossValue=p.qty*lc,commission=grossCost*(rate/100)+grossValue*(rate/100),netPl=(grossValue-grossValue*(rate/100))-costValue,plPct=costValue>0?netPl/costValue*100:0;text+=`${p.code}: Quantity ${p.qty}, Buy Price ${fmt(p.buy)}, Broker Commission ${fmt(commission)} (${fmt(rate,2)}%), Costing Rate ${fmt(costingRate)}, Cost Value ${fmt(costValue)}, CloseP ${fmt(lc)}, Net Market Value ${fmt(grossValue-grossValue*(rate/100))}, Net P/L ${fmt(netPl)} (${fmt(plPct,2)}%)\n`});
  }
  document.getElementById("v11ReportOutput").value=text;
 }
 document.querySelectorAll("[data-v11-report]").forEach(btn=>btn.addEventListener("click",()=>buildReport(btn.dataset.v11Report)));
 document.getElementById("v11ClearReport")?.addEventListener("click",()=>document.getElementById("v11ReportOutput").value="");
 document.getElementById("v11DownloadReport")?.addEventListener("click",()=>{
  const text=document.getElementById("v11ReportOutput").value;
  if(!text)return;
  const blob=new Blob([text],{type:"text/plain"});
  const a=document.createElement("a");a.href=URL.createObjectURL(blob);a.download=`dse-report-${new Date().toISOString().slice(0,10)}.txt`;a.click();URL.revokeObjectURL(a.href);
 });

 // Add terminal commands to existing command palette if possible.
 document.addEventListener("keydown",event=>{
  if((event.ctrlKey||event.metaKey)&&event.shiftKey&&event.key.toLowerCase()==="t"){
   event.preventDefault();selectTab("charts");
  }
 });
});



/* =========================================================
   V11.2 TRUE WORKSPACE SWITCHING
   ========================================================= */
document.addEventListener("DOMContentLoaded",()=>{
 const workspace=document.getElementById("v112ChartWorkspace");
 const host=document.getElementById("v112ChartHost");
 const noChart=document.getElementById("v112NoChart");
 const backBtn=document.getElementById("v112BackDashboard");
 const helpBtn=document.getElementById("v112ChartHelp");
 const helpPanel=document.getElementById("v112ChartHelpPanel");
 const fullscreenBtn=document.getElementById("v112ChartFullscreen");
 const refreshBtn=document.getElementById("v112ChartRefresh");
 const subtitle=document.getElementById("v112ChartSubtitle");

 let activeChartElement=null;
 let originalParent=null;
 let originalNextSibling=null;
 let lastFocused=null;
 let chartMode=false;

 function getApp(){
  return window.app||window.dashboard||null;
 }

 function getActiveList(){
  const app=getApp();
  try{return app?.active?.()||null}catch{return null}
 }

 function findChartViewer(){
  // Keep the mounted viewer stable. Selecting another hidden modal after each
  // append used to make the child-list observer endlessly swap chart panels.
  if(activeChartElement?.isConnected)return activeChartElement;
  const opened=document.querySelector("#galleryModal.open,#chartModal.open,#v11RankedChartModal.open");
  if(opened)return opened;
  const selectors=[
   "#chartModal",
   "#chartsModal",
   "#listChartsModal",
   "#viewChartsModal",
   "#chartDialog",
   '[id*="chart"][class*="modal" i]',
   '[class*="chart"][class*="modal" i]',
   '[id*="chart"][class*="dialog" i]',
   '[class*="chart"][class*="dialog" i]'
  ];

  for(const selector of selectors){
   const elements=[...document.querySelectorAll(selector)];
   const found=elements.find(el=>
    el!==workspace &&
    !el.closest("#v112ChartWorkspace") &&
    el.querySelector("canvas,svg,.chart,.candlestick,[class*='chart' i]")
   );
   if(found)return found;
  }

  const canvas=document.querySelector("body canvas");
  if(canvas){
   const parent=canvas.closest(".modal,.dialog,[class*='modal' i],[class*='dialog' i],.card,.panel");
   if(parent&&!parent.closest("#v112ChartWorkspace"))return parent;
  }

  return null;
 }

 function moveChartIntoWorkspace(element){
  if(!element)return false;

  if(activeChartElement===element){
   noChart.hidden=true;
   return true;
  }

  restoreChart();

  originalParent=element.parentNode;
  originalNextSibling=element.nextSibling;
  activeChartElement=element;

  element.hidden=false;
  element.style.removeProperty("display");
  element.classList.add("v112-chart-workspace-panel");

  element.querySelectorAll(
   '[data-close],.close,.modal-close,.dialog-close,[aria-label*="close" i]'
  ).forEach(button=>{
   button.dataset.v112OriginalDisplay=button.style.display||"";
   button.style.display="none";
  });

  host.appendChild(element);
  noChart.hidden=true;
  return true;
 }

 function restoreChart(){
  if(!activeChartElement)return;

  activeChartElement.classList.remove("v112-chart-workspace-panel");

  activeChartElement.querySelectorAll("[data-v112-original-display]").forEach(button=>{
   button.style.display=button.dataset.v112OriginalDisplay||"";
   delete button.dataset.v112OriginalDisplay;
  });

  if(originalParent){
   if(originalNextSibling&&originalNextSibling.parentNode===originalParent){
    originalParent.insertBefore(activeChartElement,originalNextSibling);
   }else{
    originalParent.appendChild(activeChartElement);
   }
  }

  activeChartElement=null;
  originalParent=null;
  originalNextSibling=null;
 }

 function updateSubtitle(){
  const active=getActiveList();
  const name=active?.name||"Active watch list";
  const count=Array.isArray(active?.codes)?active.codes.length:0;
  subtitle.textContent=count?`${name} • ${count} securities`:name;
 }

 function dispatchResize(){
  requestAnimationFrame(()=>{
   window.dispatchEvent(new Event("resize"));
   setTimeout(()=>window.dispatchEvent(new Event("resize")),120);
   setTimeout(()=>window.dispatchEvent(new Event("resize")),350);
  });
 }

 function enterChartWorkspace(){
  lastFocused=document.activeElement;
  chartMode=true;
  updateSubtitle();

  document.documentElement.classList.add("v112-chart-mode");
  document.body.classList.add("v112-chart-mode");
  workspace.setAttribute("aria-hidden","false");

  const viewer=findChartViewer();
  if(viewer){
   moveChartIntoWorkspace(viewer);
  }else{
   noChart.hidden=false;
  }

  backBtn.focus();
  dispatchResize();
 }

 function exitChartWorkspace(){
  chartMode=false;
  workspace.setAttribute("aria-hidden","true");
  document.documentElement.classList.remove("v112-chart-mode","v112-fullscreen");
  document.body.classList.remove("v112-chart-mode","v112-fullscreen");
  helpPanel.classList.remove("show");

  restoreChart();

  fullscreenBtn.textContent="⛶ Full Screen";
  fullscreenBtn.title="Enter full screen";

  if(lastFocused&&typeof lastFocused.focus==="function"){
   setTimeout(()=>lastFocused.focus(),0);
  }

  window.scrollTo({top:0,behavior:"auto"});
 }

 function toggleFullscreen(){
  const enabled=document.documentElement.classList.toggle("v112-fullscreen");
  document.body.classList.toggle("v112-fullscreen",enabled);
  fullscreenBtn.textContent=enabled?"🗗 Exit Full Screen":"⛶ Full Screen";
  fullscreenBtn.title=enabled?"Exit full screen":"Enter full screen";
  dispatchResize();
 }

 function refreshCharts(){
  const viewer=activeChartElement||findChartViewer();
  if(viewer&&viewer!==activeChartElement){
   moveChartIntoWorkspace(viewer);
  }
  dispatchResize();
 }

 backBtn.addEventListener("click",exitChartWorkspace);
 helpBtn.addEventListener("click",()=>helpPanel.classList.toggle("show"));
 fullscreenBtn.addEventListener("click",toggleFullscreen);
 refreshBtn.addEventListener("click",refreshCharts);

 function bindViewChartsButton(button){
  if(!button||button.dataset.v112Bound==="1")return;
  button.dataset.v112Bound="1";

  button.addEventListener("click",()=>{
   setTimeout(enterChartWorkspace,40);
   setTimeout(()=>{
    const viewer=findChartViewer();
    if(viewer)moveChartIntoWorkspace(viewer);
    dispatchResize();
   },220);
  });
 }

 function scanChartButtons(root=document){
  const buttons=[
   ...root.querySelectorAll?.("button,[role='button'],a")||[]
  ];

  buttons.forEach(button=>{
   const text=(button.textContent||"").trim().toLowerCase();
   if(
    button.id==="viewListCharts" ||
    button.dataset.proxy==="viewListCharts" ||
    text==="view charts" ||
    text.includes("chart gallery") ||
    text.includes("open charts")
   ){
    bindViewChartsButton(button);
   }
  });
 }

 scanChartButtons();

 const observer=new MutationObserver(mutations=>{
  for(const mutation of mutations){
   for(const node of mutation.addedNodes){
    if(!(node instanceof HTMLElement))continue;
    scanChartButtons(node);

    if(chartMode){
     const viewer=findChartViewer();
     if(viewer&&!viewer.closest("#v112ChartWorkspace")){
      moveChartIntoWorkspace(viewer);
      dispatchResize();
     }
    }

    node.querySelectorAll?.(".list-item,[data-list-id],[data-watchlist]").forEach(item=>{
     if(!item.hasAttribute("tabindex"))item.tabIndex=0;
     item.title=item.title||"Double-click or press Enter to open charts";
    });
   }
  }
 });

 observer.observe(document.body,{childList:true,subtree:true});

 function bindWatchContainer(container){
  if(!container||container.dataset.v112WatchBound==="1")return;
  container.dataset.v112WatchBound="1";

  container.addEventListener("dblclick",event=>{
   const item=event.target.closest(".list-item,[data-list-id],[data-watchlist],tr");
   if(!item)return;
   document.getElementById("viewListCharts")?.click();
  });

  container.addEventListener("keydown",event=>{
   if(event.key!=="Enter")return;
   const item=event.target.closest(".list-item,[data-list-id],[data-watchlist],tr");
   if(!item)return;
   event.preventDefault();
   document.getElementById("viewListCharts")?.click();
  });
 }

 [
  document.querySelector(".sidebar"),
  document.getElementById("marketWorkspace"),
  document.querySelector('[class*="watch" i]')
 ].filter(Boolean).forEach(bindWatchContainer);

 document.querySelectorAll(".list-item,[data-list-id],[data-watchlist]").forEach(item=>{
  if(!item.hasAttribute("tabindex"))item.tabIndex=0;
  item.title=item.title||"Double-click or press Enter to open charts";
 });

 document.addEventListener("keydown",event=>{
  if(!chartMode)return;

  if(event.key==="Escape"){
   event.preventDefault();
   exitChartWorkspace();
   return;
  }

  const tag=document.activeElement?.tagName;
  const typing=["INPUT","TEXTAREA","SELECT"].includes(tag);

  if(!typing&&event.key.toLowerCase()==="f"){
   event.preventDefault();
   toggleFullscreen();
  }
 });

 window.AbabilChartWorkspace={
  open:enterChartWorkspace,
  close:exitChartWorkspace,
  refresh:refreshCharts,
  toggleFullscreen
 };
});


/* =========================================================
   V11.3 WATCH-LIST VS 3M CHART MODAL FIX
   ========================================================= */
document.addEventListener("DOMContentLoaded",()=>{
 const modalSelectors=[
  "#chartModal",
  "#chartsModal",
  "#listChartsModal",
  "#viewChartsModal",
  "#threeMonthChartsModal",
  "#threeMonthsChartsModal",
  "#threeMonthChartModal",
  "#chartGalleryModal",
  '[id*="3m"][class*="modal" i]',
  '[id*="three"][id*="month"][class*="modal" i]',
  '[id*="chart"][class*="modal" i]',
  '[class*="3m"][class*="modal" i]',
  '[class*="three-month"][class*="modal" i]',
  '[class*="chart"][class*="modal" i]',
  '.modal:has(canvas)',
  '.modal:has(svg)',
  '.dialog:has(canvas)',
  '.dialog:has(svg)'
 ];

 function visible(el){
  if(!el || el.closest("#v112ChartWorkspace")) return false;
  const style=getComputedStyle(el);
  const rect=el.getBoundingClientRect();
  return !el.hidden &&
         style.display!=="none" &&
         style.visibility!=="hidden" &&
         Number(style.opacity||1)>0 &&
         rect.width>0 &&
         rect.height>0;
 }

 function chartModalIsOpen(){
  for(const selector of modalSelectors){
   try{
    for(const el of document.querySelectorAll(selector)){
     if(visible(el)) return true;
    }
   }catch{}
  }
  return false;
 }

 function syncLayerState(){
  const open=chartModalIsOpen();
  if(document.body.classList.contains("v113-chart-overlay-open")!==open)document.body.classList.toggle("v113-chart-overlay-open",open);

  if(open){
   document.querySelectorAll(modalSelectors.join(",")).forEach(el=>{
    if(!visible(el)) return;
    // This observer also watches style changes: only write when needed, or
    // a visible chart can continuously trigger its own mutation callback.
    if(el.style.getPropertyValue("z-index")!=="2147483645"||el.style.getPropertyPriority("z-index")!=="important")el.style.setProperty("z-index","2147483645","important");
    if(el.style.getPropertyValue("position")!=="fixed"||el.style.getPropertyPriority("position")!=="important")el.style.setProperty("position","fixed","important");
   });
  }
 }

 const observer=new MutationObserver(syncLayerState);
 observer.observe(document.documentElement,{
  subtree:true,
  childList:true,
  attributes:true,
  attributeFilter:["class","style","hidden","open","aria-hidden"]
 });

 document.addEventListener("click",()=>{
  setTimeout(syncLayerState,0);
  setTimeout(syncLayerState,50);
  setTimeout(syncLayerState,200);
 },true);

 document.addEventListener("keydown",event=>{
  if(event.key==="Escape"){
   setTimeout(syncLayerState,0);
   setTimeout(syncLayerState,150);
  }
 },true);

 window.addEventListener("resize",syncLayerState);
 syncLayerState();
});



/* =========================================================
   V11.5 PER-WATCH-LIST DATA TOOLTIP
   ========================================================= */
document.addEventListener("DOMContentLoaded",()=>{
 const tooltip=document.getElementById("v115WatchTooltip");
 const arrow=document.getElementById("v115WatchTooltipArrow");
 const nameEl=document.getElementById("v115WatchName");
 const subtitleEl=document.getElementById("v115WatchSubtitle");
 const countEl=document.getElementById("v115WatchCount");
 const codesEl=document.getElementById("v115WatchCodes");
 const previewMeta=document.getElementById("v115WatchPreviewMeta");
 const closeBtn=document.getElementById("v115WatchClose");
 const openChartsBtn=document.getElementById("v115WatchOpenCharts");
 const selectBtn=document.getElementById("v115WatchSelect");

 let activeItem=null;
 let activeList=null;
 let openTimer=null;
 let closeTimer=null;
 let locked=false;

 const itemSelectors=[
  ".list-item",
  "[data-list-id]",
  "[data-watchlist]",
  "[data-watch-list]",
  ".watch-list-item",
  ".watchlist-item"
 ];

 function appObject(){
  return window.app||window.dashboard||window.AbabilApp||null;
 }

 function getStoredLists(){
  const keys=[
   "watchlists",
   "watchLists",
   "ababil-watchlists",
   "ababil_watchlists",
   "dse-watchlists"
  ];

  for(const key of keys){
   try{
    const parsed=JSON.parse(localStorage.getItem(key)||"null");
    if(Array.isArray(parsed))return parsed;
    if(parsed&&Array.isArray(parsed.lists))return parsed.lists;
   }catch{}
  }
  return [];
 }

 function normalizeList(raw){
  if(!raw)return null;

  const name=
   raw.name ??
   raw.title ??
   raw.label ??
   raw.listName ??
   raw.watchListName ??
   "Watch List";

  let codes=
   raw.codes ??
   raw.symbols ??
   raw.items ??
   raw.tradingCodes ??
   raw.stocks ??
   [];

  if(typeof codes==="string"){
   codes=codes.split(/[,\s]+/).filter(Boolean);
  }

  if(!Array.isArray(codes))codes=[];

  codes=codes.map(item=>{
   if(typeof item==="string")return item;
   return item?.code ?? item?.symbol ?? item?.ticker ?? item?.tradingCode ?? "";
  }).filter(Boolean);

  return {
   ...raw,
   name:String(name),
   codes
  };
 }

 function listFromApp(item){
  const app=appObject();
  const id=
   item?.dataset?.listId ??
   item?.dataset?.watchlist ??
   item?.dataset?.watchList ??
   item?.dataset?.id ??
   null;

  const name=(item?.querySelector?.(".name,.title,strong,b")?.textContent || item?.textContent || "").trim();

  const pools=[
   app?.lists,
   app?.watchLists,
   app?.watchlists,
   app?.state?.lists,
   app?.state?.watchLists,
   app?.data?.lists,
   window.watchLists,
   window.watchlists,
   getStoredLists()
  ];

  for(const pool of pools){
   if(!Array.isArray(pool))continue;

   let found=null;
   if(id!=null){
    found=pool.find(entry=>
     String(entry?.id ?? entry?.listId ?? entry?.key ?? "")===String(id)
    );
   }

   if(!found && name){
    found=pool.find(entry=>
     String(entry?.name ?? entry?.title ?? entry?.label ?? "").trim().toLowerCase()===name.toLowerCase()
    );
   }

   if(found)return normalizeList(found);
  }

  try{
   const active=app?.active?.();
   if(active){
    const n=normalizeList(active);
    if(!name || n.name.toLowerCase()===name.toLowerCase())return n;
   }
  }catch{}

  return null;
 }

 function listFromDom(item){
  const rawName=
   item.dataset.name ||
   item.dataset.title ||
   item.querySelector(".name,.title,strong,b")?.textContent ||
   item.textContent ||
   "Watch List";

  let name=String(rawName).replace(/\(\s*\d+\s*\)\s*$/,"").trim();

  let codes=[];

  const dataCodes=
   item.dataset.codes ||
   item.dataset.symbols ||
   item.dataset.tradingCodes ||
   "";

  if(dataCodes){
   codes=dataCodes.split(/[,\s]+/).filter(Boolean);
  }

  if(!codes.length){
   const codeNodes=item.querySelectorAll("[data-code],.code,.symbol,.ticker");
   codes=[...codeNodes].map(node=>
    node.dataset.code || node.textContent.trim()
   ).filter(Boolean);
  }

  let declaredCount=null;
  const countMatch=item.textContent.match(/\((\d+)\)|\b(\d+)\s*(?:codes?|stocks?|symbols?)\b/i);
  if(countMatch)declaredCount=Number(countMatch[1]||countMatch[2]);

  return {
   name,
   codes,
   declaredCount
  };
 }

 function resolveList(item){
  return listFromApp(item) || listFromDom(item);
 }

 function render(list){
  const codes=Array.isArray(list.codes)?list.codes:[];
  const count=Number.isFinite(list.declaredCount)?list.declaredCount:codes.length;

  nameEl.textContent=list.name||"Watch List";
  subtitleEl.textContent=count===1?"1 trading code in this group":`${count} trading codes in this group`;
  countEl.textContent=String(count);
  codesEl.innerHTML="";

  const preview=codes.slice(0,10);

  if(preview.length){
   preview.forEach(code=>{
    const chip=document.createElement("span");
    chip.className="v115-watch-code";
    chip.textContent=code;
    codesEl.appendChild(chip);
   });

   const remaining=Math.max(0,count-preview.length);
   if(remaining>0){
    const more=document.createElement("span");
    more.className="v115-watch-more";
    more.textContent=`+${remaining} more`;
    codesEl.appendChild(more);
   }

   previewMeta.textContent=`Showing ${preview.length} of ${count}`;
  }else{
   const empty=document.createElement("div");
   empty.className="v115-watch-empty";
   empty.textContent=count
    ? `${count} trading codes are saved in this list.`
    : "No trading codes have been added yet.";
   codesEl.appendChild(empty);
   previewMeta.textContent="";
  }
 }

 function position(){
  if(!activeItem || !tooltip.classList.contains("open"))return;

  if(window.matchMedia("(max-width:620px)").matches){
   tooltip.style.left="";
   tooltip.style.top="";
   arrow.classList.remove("open");
   return;
  }

  const rect=activeItem.getBoundingClientRect();
  const margin=12;
  const gap=12;
  const width=Math.min(360,window.innerWidth-24);
  const height=Math.min(tooltip.scrollHeight||360,window.innerHeight*.7);

  let left=rect.right+gap;
  let top=rect.top;

  let side="right";

  if(left+width>window.innerWidth-margin){
   left=rect.left-width-gap;
   side="left";
  }

  if(left<margin){
   left=Math.max(margin,Math.min(rect.left,window.innerWidth-width-margin));
   top=rect.bottom+gap;
   side="bottom";
  }

  if(top+height>window.innerHeight-margin){
   top=Math.max(margin,window.innerHeight-height-margin);
  }

  tooltip.style.left=`${left}px`;
  tooltip.style.top=`${top}px`;

  const arrowSize=12;
  let arrowLeft;
  let arrowTop;

  if(side==="right"){
   arrowLeft=left-arrowSize/2;
   arrowTop=Math.min(rect.top+18,top+height-24);
  }else if(side==="left"){
   arrowLeft=left+width-arrowSize/2;
   arrowTop=Math.min(rect.top+18,top+height-24);
  }else{
   arrowLeft=Math.min(rect.left+24,left+width-24);
   arrowTop=top-arrowSize/2;
  }

  arrow.style.left=`${arrowLeft}px`;
  arrow.style.top=`${arrowTop}px`;
  arrow.classList.add("open");
 }

 function openFor(item,{interactive=false}={}){
  clearTimeout(closeTimer);
  activeItem=item;
  activeList=resolveList(item);
  render(activeList);

  tooltip.classList.toggle("interactive",interactive);
  tooltip.classList.add("open");
  tooltip.setAttribute("aria-hidden","false");
  position();
 }

 function close(force=false){
  if(locked&&!force)return;

  clearTimeout(openTimer);
  clearTimeout(closeTimer);

  tooltip.classList.remove("open","interactive");
  tooltip.setAttribute("aria-hidden","true");
  arrow.classList.remove("open");

  activeItem=null;
  activeList=null;
  locked=false;
 }

 function selectActiveItem(){
  if(!activeItem)return;
  activeItem.click();
 }

 function openCharts(){
  if(activeItem)activeItem.click();

  setTimeout(()=>{
   const button=
    document.getElementById("viewListCharts") ||
    [...document.querySelectorAll("button,a,[role='button']")].find(el=>
     /view charts|open charts|chart gallery/i.test((el.textContent||"").trim())
    );

   button?.click();
   close(true);
  },60);
 }

 function bindItem(item){
  if(!item || item.dataset.v115TooltipBound==="1")return;

  // Avoid binding unrelated generic rows outside the Watch Lists region.
  const sectionText=(item.closest("section,.card,.panel,.sidebar,aside,div")?.textContent||"").toLowerCase();
  if(!sectionText.includes("watch lists") && !item.matches("[data-list-id],[data-watchlist],[data-watch-list],.watch-list-item,.watchlist-item")){
   return;
  }

  item.dataset.v115TooltipBound="1";
  item.classList.add("v115-watch-item");

  if(!item.hasAttribute("tabindex"))item.tabIndex=0;

  item.addEventListener("mouseenter",()=>{
   clearTimeout(closeTimer);
   openTimer=setTimeout(()=>openFor(item),160);
  });

  item.addEventListener("mouseleave",()=>{
   clearTimeout(openTimer);
   if(!locked){
    closeTimer=setTimeout(()=>{
     if(!tooltip.matches(":hover"))close();
    },180);
   }
  });

  item.addEventListener("focus",()=>openFor(item));
  item.addEventListener("blur",()=>{
   if(!locked){
    closeTimer=setTimeout(()=>{
     if(!tooltip.contains(document.activeElement))close();
    },160);
   }
  });

  item.addEventListener("contextmenu",event=>{
   event.preventDefault();
   locked=true;
   openFor(item,{interactive:true});
  });

  item.addEventListener("click",()=>{
   if(window.matchMedia("(max-width:620px)").matches){
    if(activeItem===item && tooltip.classList.contains("open")){
     locked=true;
     tooltip.classList.add("interactive");
    }else{
     locked=true;
     openFor(item,{interactive:true});
    }
   }
  });
 }

 function scan(root=document){
  itemSelectors.forEach(selector=>{
   root.querySelectorAll?.(selector).forEach(bindItem);
  });
 }

 tooltip.addEventListener("mouseenter",()=>clearTimeout(closeTimer));
 tooltip.addEventListener("mouseleave",()=>{
  if(!locked)closeTimer=setTimeout(()=>close(),180);
 });

 closeBtn.addEventListener("click",()=>close(true));
 openChartsBtn.addEventListener("click",openCharts);
 selectBtn.addEventListener("click",()=>{
  selectActiveItem();
  close(true);
 });

 document.addEventListener("click",event=>{
  if(!tooltip.classList.contains("open"))return;
  if(tooltip.contains(event.target) || activeItem?.contains(event.target))return;
  close(true);
 });

 document.addEventListener("keydown",event=>{
  if(event.key==="Escape" && tooltip.classList.contains("open")){
   event.preventDefault();
   close(true);
  }
 });

 window.addEventListener("resize",position);
 window.addEventListener("scroll",position,true);

 const observer=new MutationObserver(mutations=>{
  for(const mutation of mutations){
   for(const node of mutation.addedNodes){
    if(!(node instanceof HTMLElement))continue;
    if(itemSelectors.some(selector=>node.matches?.(selector)))bindItem(node);
    scan(node);
   }
  }
 });

 observer.observe(document.body,{subtree:true,childList:true});
 scan();

 window.AbabilWatchListTooltip={
  refresh:()=>scan(),
  close:()=>close(true)
 };
});


/* =========================================================
   v11.7 LIGHT-GRAY CHART THEME PATCH
   ========================================================= */
document.addEventListener("DOMContentLoaded",()=>{

 const THEME={
  background:"#f3f4f6",
  plot:"#f8fafc",
  grid:"#d1d5db",
  gridSoft:"#e5e7eb",
  axis:"#374151",
  border:"#cbd5e1",
  bull:"#16a34a",
  bullBorder:"#15803d",
  bullWick:"#166534",
  bear:"#dc2626",
  bearBorder:"#b91c1c",
  bearWick:"#991b1b",
  volumeBull:"rgba(22,163,74,.45)",
  volumeBear:"rgba(220,38,38,.45)",
  crosshair:"#6b7280"
 };

 function patchChartJsDefaults(){
  const C=window.Chart;
  if(!C?.defaults)return;

  try{
   C.defaults.color=THEME.axis;
   C.defaults.borderColor=THEME.gridSoft;

   if(C.defaults.scale){
    C.defaults.scale.grid=C.defaults.scale.grid||{};
    C.defaults.scale.grid.color=THEME.gridSoft;
    C.defaults.scale.grid.borderColor=THEME.border;
    C.defaults.scale.ticks=C.defaults.scale.ticks||{};
    C.defaults.scale.ticks.color=THEME.axis;
   }

   const instances=
    typeof C.getChart==="function"
      ? [...document.querySelectorAll("canvas")].map(c=>C.getChart(c)).filter(Boolean)
      : Object.values(C.instances||{});

   instances.forEach(chart=>{
    chart.options=chart.options||{};
    chart.options.plugins=chart.options.plugins||{};
    chart.options.plugins.legend=chart.options.plugins.legend||{};
    chart.options.plugins.legend.labels=chart.options.plugins.legend.labels||{};
    chart.options.plugins.legend.labels.color=THEME.axis;

    if(chart.options.scales){
     Object.values(chart.options.scales).forEach(scale=>{
      scale.grid=scale.grid||{};
      scale.grid.color=THEME.gridSoft;
      scale.grid.borderColor=THEME.border;
      scale.ticks=scale.ticks||{};
      scale.ticks.color=THEME.axis;
      scale.border=scale.border||{};
      scale.border.color=THEME.border;
     });
    }

    chart.data?.datasets?.forEach(ds=>{
     const type=(ds.type||chart.config?.type||"").toLowerCase();

     if(type.includes("candlestick")||type.includes("ohlc")){
      ds.color={
       up:THEME.bull,
       down:THEME.bear,
       unchanged:"#64748b"
      };
      ds.borderColor={
       up:THEME.bullBorder,
       down:THEME.bearBorder,
       unchanged:"#475569"
      };
     }
    });

    chart.update?.("none");
   });
  }catch(e){}
 }

 function patchPlotly(){
  if(!window.Plotly)return;

  document.querySelectorAll(".js-plotly-plot").forEach(plot=>{
   try{
    window.Plotly.relayout(plot,{
     paper_bgcolor:THEME.background,
     plot_bgcolor:THEME.plot,
     font:{color:THEME.axis},
     xaxis:{
      gridcolor:THEME.gridSoft,
      zerolinecolor:THEME.grid,
      linecolor:THEME.border,
      tickfont:{color:THEME.axis}
     },
     yaxis:{
      gridcolor:THEME.gridSoft,
      zerolinecolor:THEME.grid,
      linecolor:THEME.border,
      tickfont:{color:THEME.axis}
     }
    });

    const update={
     increasing:{
      line:{color:THEME.bullBorder,width:1.3},
      fillcolor:THEME.bull
     },
     decreasing:{
      line:{color:THEME.bearBorder,width:1.3},
      fillcolor:THEME.bear
     }
    };

    window.Plotly.restyle(plot,update);
   }catch(e){}
  });
 }

 function patchHighcharts(){
  const H=window.Highcharts;
  if(!H)return;

  try{
   H.setOptions({
    chart:{
     backgroundColor:THEME.background,
     plotBackgroundColor:THEME.plot,
     plotBorderColor:THEME.border
    },
    colors:["#2563eb","#f59e0b","#7c3aed",THEME.bull,THEME.bear],
    xAxis:{
     gridLineColor:THEME.gridSoft,
     lineColor:THEME.border,
     tickColor:THEME.border,
     labels:{style:{color:THEME.axis}}
    },
    yAxis:{
     gridLineColor:THEME.gridSoft,
     lineColor:THEME.border,
     tickColor:THEME.border,
     labels:{style:{color:THEME.axis}},
     title:{style:{color:THEME.axis}}
    },
    legend:{itemStyle:{color:THEME.axis}},
    tooltip:{backgroundColor:"#ffffff",style:{color:THEME.axis}},
    plotOptions:{
     candlestick:{
      color:THEME.bear,
      lineColor:THEME.bearWick,
      upColor:THEME.bull,
      upLineColor:THEME.bullWick,
      lineWidth:1.4
     }
    }
   });

   (H.charts||[]).filter(Boolean).forEach(chart=>{
    chart.update({
     chart:{
      backgroundColor:THEME.background,
      plotBackgroundColor:THEME.plot,
      plotBorderColor:THEME.border
     },
     xAxis:{
      gridLineColor:THEME.gridSoft,
      lineColor:THEME.border,
      labels:{style:{color:THEME.axis}}
     },
     yAxis:{
      gridLineColor:THEME.gridSoft,
      lineColor:THEME.border,
      labels:{style:{color:THEME.axis}}
     },
     plotOptions:{
      candlestick:{
       color:THEME.bear,
       lineColor:THEME.bearWick,
       upColor:THEME.bull,
       upLineColor:THEME.bullWick,
       lineWidth:1.4
      }
     }
    },true,false,false);
   });
  }catch(e){}
 }

 function patchLightweightCharts(){
  const pools=[
   window.chart,
   window.mainChart,
   window.priceChart,
   window.candleChart,
   window.charts
  ];

  const charts=[];
  pools.forEach(item=>{
   if(Array.isArray(item))charts.push(...item);
   else if(item)charts.push(item);
  });

  charts.forEach(chart=>{
   try{
    chart.applyOptions?.({
     layout:{
      background:{type:"solid",color:THEME.plot},
      textColor:THEME.axis
     },
     grid:{
      vertLines:{color:THEME.gridSoft},
      horzLines:{color:THEME.gridSoft}
     },
     crosshair:{
      vertLine:{color:THEME.crosshair,width:1,style:2},
      horzLine:{color:THEME.crosshair,width:1,style:2}
     },
     rightPriceScale:{borderColor:THEME.border},
     timeScale:{borderColor:THEME.border}
    });
   }catch(e){}
  });

  const seriesPools=[
   window.candleSeries,
   window.candlestickSeries,
   window.priceSeries,
   window.series
  ];

  seriesPools.forEach(series=>{
   try{
    series?.applyOptions?.({
     upColor:THEME.bull,
     downColor:THEME.bear,
     borderUpColor:THEME.bullBorder,
     borderDownColor:THEME.bearBorder,
     wickUpColor:THEME.bullWick,
     wickDownColor:THEME.bearWick
    });
   }catch(e){}
  });
 }

 function patchECharts(){
  const echarts=window.echarts;
  if(!echarts?.getInstanceByDom)return;

  document.querySelectorAll("div,canvas").forEach(el=>{
   const instance=echarts.getInstanceByDom(el);
   if(!instance)return;

   try{
    const option=instance.getOption?.()||{};
    const xAxes=(option.xAxis||[]).map(axis=>({
     ...axis,
     axisLine:{...(axis.axisLine||{}),lineStyle:{...((axis.axisLine||{}).lineStyle||{}),color:THEME.border}},
     axisLabel:{...(axis.axisLabel||{}),color:THEME.axis},
     splitLine:{...(axis.splitLine||{}),lineStyle:{...((axis.splitLine||{}).lineStyle||{}),color:THEME.gridSoft}}
    }));
    const yAxes=(option.yAxis||[]).map(axis=>({
     ...axis,
     axisLine:{...(axis.axisLine||{}),lineStyle:{...((axis.axisLine||{}).lineStyle||{}),color:THEME.border}},
     axisLabel:{...(axis.axisLabel||{}),color:THEME.axis},
     splitLine:{...(axis.splitLine||{}),lineStyle:{...((axis.splitLine||{}).lineStyle||{}),color:THEME.gridSoft}}
    }));

    const series=(option.series||[]).map(s=>{
     if((s.type||"").toLowerCase()==="candlestick"){
      return {
       ...s,
       itemStyle:{
        ...(s.itemStyle||{}),
        color:THEME.bull,
        color0:THEME.bear,
        borderColor:THEME.bullBorder,
        borderColor0:THEME.bearBorder,
        borderWidth:1.4
       }
      };
     }
     return s;
    });

    instance.setOption({
     backgroundColor:THEME.plot,
     textStyle:{color:THEME.axis},
     xAxis:xAxes,
     yAxis:yAxes,
     series
    },false);
   }catch(e){}
  });
 }

 function applyAll(){
  document.querySelectorAll("canvas,svg").forEach(el=>{
   const host=el.closest(".chart-container,.chart-wrap,.chart-panel,.chart-box,.chart-area,.modal-content");
   if(host)host.style.backgroundColor=THEME.background;
   el.style.backgroundColor=THEME.plot;
  });

  patchChartJsDefaults();
  patchPlotly();
  patchHighcharts();
  patchLightweightCharts();
  patchECharts();
 }

 // Patch common chart construction functions where possible.
 function wrapHighchartsCreation(){
  if(!window.Highcharts||window.Highcharts.__v116Wrapped)return;
  window.Highcharts.__v116Wrapped=true;
  applyAll();
 }

 applyAll();
 setTimeout(applyAll,300);
 setTimeout(applyAll,1000);

 const observer=new MutationObserver(()=>{
  clearTimeout(window.__v116ChartTimer);
  window.__v116ChartTimer=setTimeout(applyAll,100);
 });
 observer.observe(document.body,{subtree:true,childList:true});

 window.addEventListener("resize",()=>setTimeout(applyAll,80));

 window.AbabilChartTheme={
  apply:applyAll,
  colors:THEME
 };
});


document.addEventListener("DOMContentLoaded",()=>{
 const menu=document.getElementById("v119TerminalMenu");
 const groups=document.getElementById("v119MenuGroups");
 const toggle=document.getElementById("v119MenuToggle");
 const closeBtn=document.getElementById("v119MenuClose");
 const backdrop=document.getElementById("v119MenuBackdrop");

 if(!menu||!groups||!toggle||!closeBtn||!backdrop)return;

 const groupMap=[
  ["theme selection","Appearance"],
  ["theme","Appearance"],
  ["appearance","Appearance"],
  ["palette","Appearance"],
  ["download","Data & Downloads"],
  ["archive","Data & Downloads"],
  ["import","Import & Storage"],
  ["sync","Import & Storage"],
  ["backup","Import & Storage"],
  ["restore","Import & Storage"],
  ["watch","Watch Lists"],
  ["list","Watch Lists"],
  ["chart","Charts & Analysis"],
  ["indicator","Charts & Analysis"],
  ["compare","Charts & Analysis"],
  ["terminal","Trading Workspace"],
  ["portfolio","Trading Workspace"],
  ["report","Reports & Export"],
  ["export","Reports & Export"],
  ["print","Reports & Export"],
  ["workspace","Workspaces"],
  ["command","Utilities"],
  ["notification","Utilities"],
  ["clear","Maintenance"],
  ["reset","Maintenance"],
  ["delete","Maintenance"]
 ];

 const order=[
  "Data & Downloads",
  "Import & Storage",
  "Watch Lists",
  "Charts & Analysis",
  "Trading Workspace",
  "Reports & Export",
  "Workspaces",
  "Appearance",
  "Utilities",
  "Maintenance",
  "General"
 ];

 function textOf(el){
  return String(
   el.textContent||
   el.value||
   el.getAttribute("aria-label")||
   el.title||
   ""
  ).replace(/\s+/g," ").trim();
 }

 function classify(el){
  const label=textOf(el).toLowerCase();
  const aria=String(el.getAttribute("aria-label")||"").toLowerCase();

  if(
   label.includes("theme selection")||
   aria.includes("theme selection")||
   el.id==="v1118ThemeMenuAction"
  ){
   return "Appearance";
  }

  const haystack=[
   el.id,
   el.className,
   el.name,
   el.title,
   el.getAttribute("aria-label"),
   textOf(el)
  ].filter(Boolean).join(" ").toLowerCase();

  for(const [needle,groupLabel] of groupMap){
   if(haystack.includes(needle))return groupLabel;
  }
  return "General";
 }

 /*
  * Important: only collect commands from the main control deck and the
  * original top toolbar. Never scan Trading Workspace cards, tabs or forms.
  */
 function sourceActions(){
  const selectors=[
   ".v10-control-deck .v10-menu-panel > button",
   ".v10-control-deck > .v105-top-actions > button",
   ".v10-original-toolbar > button",
   ".v10-original-toolbar > a.btn"
  ];

  const found=[...document.querySelectorAll(selectors.join(","))];
  const unique=[];
  const seen=new Set();

  for(const el of found){
   if(!(el instanceof HTMLElement))continue;
   if(el.closest("#v119TerminalMenu"))continue;

   const label=textOf(el);
   if(!label||/^(×|✕|close)$/i.test(label))continue;

   const normalizedLabel=label
    .toUpperCase()
    .replace(/MOTHER/g,"DSE")
    .replace(/[^A-Z0-9]+/g," ")
    .trim();

   const key=`LABEL:${normalizedLabel}`;

   if(seen.has(key))continue;
   seen.add(key);
   unique.push(el);
  }

  return unique;
 }

 function activateSource(source){
  /*
   * Native click is intentionally dispatched on the original control so all
   * existing listeners, proxy handlers and workspace switching remain intact.
   */
  source.dispatchEvent(new MouseEvent("click",{
   bubbles:true,
   cancelable:true,
   view:window
  }));
 }

 function cloneAction(source){
  const clone=source.cloneNode(true);
  clone.removeAttribute("id");
  clone.querySelectorAll("[id]").forEach(node=>node.removeAttribute("id"));
  clone.classList.add("v119-menu-action");
  clone.classList.remove("active","open","selected");

  if(clone.tagName==="INPUT"){
   clone.type="button";
  }else if(clone.tagName==="BUTTON"){
   clone.type="button";
  }

  clone.addEventListener("click",event=>{
   event.preventDefault();
   event.stopPropagation();

   const isThemeSelection=
    source.id==="v1118ThemeMenuAction"||
    source.getAttribute("aria-label")==="Theme Selection"||
    /^\s*Theme Selection\s*$/i.test(textOf(source));

   if(isThemeSelection){
    /*
     * Close only the opened menu panel through its native state handler.
     * Do not hide the Terminal Menu container—the launcher must remain
     * visible and reusable.
     */
    closeMenu(false);

    /*
     * Wait until the panel/backdrop close transition has released pointer
     * interaction, then open the Theme dialog.
     */
    window.setTimeout(()=>{
     window.dispatchEvent(new CustomEvent("v1124-open-theme-dialog"));
    },220);

    return;
   }

   closeMenu(false);
   requestAnimationFrame(()=>activateSource(source));
  });

  return clone;
 }

 function createGroup(name,items,index){
  const section=document.createElement("section");
  section.className="v119-menu-group";
  section.dataset.menuGroup=name;

  const heading=document.createElement("button");
  heading.type="button";
  heading.className="v119-menu-group-title";
  heading.setAttribute("aria-expanded","false");

  const body=document.createElement("div");
  body.className="v119-menu-group-body";
  body.hidden=true;

  section.classList.add("collapsed");

  heading.innerHTML=`
   <span>${name}</span>
   <span class="count">${items.length}</span>
   <span class="v1111-caret" aria-hidden="true">▼</span>
  `;

  items.forEach(item=>body.appendChild(cloneAction(item)));

  heading.addEventListener("click",event=>{
   event.preventDefault();
   event.stopPropagation();

   const willOpen=body.hidden;
   body.hidden=!willOpen;
   section.classList.toggle("collapsed",!willOpen);
   heading.setAttribute("aria-expanded",willOpen?"true":"false");
  });

  section.append(heading,body);
  return section;
 }

 function rebuild(){
  const actions=sourceActions();
  const grouped=new Map();

  actions.forEach(action=>{
   const group=classify(action);
   if(!grouped.has(group))grouped.set(group,[]);
   grouped.get(group).push(action);
  });

  groups.replaceChildren();

  [...grouped.entries()]
   .sort((a,b)=>{
    const ai=order.indexOf(a[0]);
    const bi=order.indexOf(b[0]);
    return (ai<0?999:ai)-(bi<0?999:bi);
   })
   .forEach(([name,items],index)=>{
    groups.appendChild(createGroup(name,items,index));
   });

  if(!groups.children.length){
   const empty=document.createElement("div");
   empty.className="v119-menu-empty";
   empty.textContent="No terminal commands are currently available.";
   groups.appendChild(empty);
  }

  /*
   * Hide only the duplicate top-level command controls. Workspace buttons,
   * report buttons, chart controls, tabs and portfolio controls remain intact.
   */
  document.querySelectorAll(".v10-control-deck").forEach(el=>{
   el.classList.add("v119-menu-source-hidden");
  });

  document.querySelectorAll(".v10-original-toolbar > button,.v10-original-toolbar > a.btn").forEach(el=>{
   el.classList.add("v119-menu-source-hidden");
  });
 }

 function openMenu(){
  menu.classList.add("open");
  backdrop.classList.add("open");
  document.body.classList.add("v119-menu-open");
  toggle.setAttribute("aria-expanded","true");
  toggle.setAttribute("aria-label","Close terminal menu");
  const label=toggle.querySelector(".label");
  if(label)label.textContent="Close Menu";
  groups.scrollTop=0;
 }

 function closeMenu(returnFocus=true){
  menu.classList.remove("open");
  backdrop.classList.remove("open");
  document.body.classList.remove("v119-menu-open");
  toggle.setAttribute("aria-expanded","false");
  toggle.setAttribute("aria-label","Open terminal menu");
  const label=toggle.querySelector(".label");
  if(label)label.textContent="Terminal Menu";
  if(returnFocus)setTimeout(()=>toggle.focus(),20);
 }

 toggle.addEventListener("click",event=>{
  event.preventDefault();
  event.stopPropagation();
  menu.classList.contains("open")?closeMenu():openMenu();
 });

 closeBtn.addEventListener("click",event=>{
  event.preventDefault();
  event.stopPropagation();
  closeMenu();
 });

 backdrop.addEventListener("click",()=>closeMenu());

 document.addEventListener("keydown",event=>{
  if(event.key==="Escape"&&menu.classList.contains("open")){
   event.preventDefault();
   closeMenu();
  }
 });

 /*
  * No body-wide MutationObserver is used here. The former observer rebuilt
  * the menu in response to its own DOM changes and interfered with clicks.
  */
 rebuild();
 setTimeout(rebuild,700);

 window.AbabilTerminalMenu={
  open:openMenu,
  close:closeMenu,
  rebuild
 };
});

document.addEventListener("keydown",event=>{
 if(event.key!=="/"||event.ctrlKey||event.metaKey||event.altKey)return;
 const target=event.target;
 if(target instanceof HTMLInputElement||
    target instanceof HTMLTextAreaElement||
    target?.isContentEditable)return;

 const input=document.getElementById("watchCodeSearch");
 if(!input)return;
 event.preventDefault();
 input.focus();
 input.select();
});






(function(){
 const THEME_CONTROL_ID="v10ThemeQuick";

 function ensureThemeDialog(){
  let dialog=document.getElementById("v1124ThemeDialog");
  if(dialog)return dialog;

  dialog=document.createElement("div");
  dialog.id="v1124ThemeDialog";
  dialog.className="v1124-theme-dialog";
  dialog.hidden=true;
  dialog.innerHTML=`
   <div class="v1124-theme-dialog-backdrop" data-v1124-close-theme></div>
   <section class="v1124-theme-dialog-panel" role="dialog" aria-modal="true" aria-labelledby="v1124ThemeDialogTitle">
    <header class="v1124-theme-dialog-header">
     <div>
      <span>APPEARANCE</span>
      <h3 id="v1124ThemeDialogTitle">Choose Terminal Theme</h3>
     </div>
     <button type="button" class="v1124-theme-dialog-close" data-v1124-close-theme aria-label="Close">×</button>
    </header>
    <div class="v1124-theme-options"></div>
   </section>
  `;

  document.body.appendChild(dialog);

  dialog.addEventListener("click",event=>{
   if(event.target.closest("[data-v1124-close-theme]")){
    closeThemeDialog();
   }
  });

  return dialog;
 }

 function openThemeDialog(){
  const control=document.getElementById(THEME_CONTROL_ID);
  if(!control)return;

  const dialog=ensureThemeDialog();
  const optionsHost=dialog.querySelector(".v1124-theme-options");
  optionsHost.innerHTML="";

  [...control.options].forEach(option=>{
   const button=document.createElement("button");
   button.type="button";
   button.className="v1124-theme-option";
   button.dataset.themeValue=option.value;
   button.classList.toggle("active",option.value===control.value);
   button.innerHTML=`
    <span class="v1124-theme-preview" aria-hidden="true">
     <i></i><i></i><i></i>
    </span>
    <span>
     <strong>${option.textContent.trim()}</strong>
     <small>${option.value===control.value?"Currently active":"Apply this theme"}</small>
    </span>
   `;

   button.addEventListener("click",()=>{
    control.value=option.value;
    control.dispatchEvent(new Event("change",{bubbles:true}));
    control.dispatchEvent(new Event("input",{bubbles:true}));

    optionsHost.querySelectorAll(".v1124-theme-option").forEach(item=>{
     const active=item.dataset.themeValue===control.value;
     item.classList.toggle("active",active);
     const small=item.querySelector("small");
     if(small)small.textContent=active?"Currently active":"Apply this theme";
    });

    setTimeout(closeThemeDialog,180);
   });

   optionsHost.appendChild(button);
  });

  dialog.hidden=false;
  dialog.setAttribute("aria-hidden","false");
  document.body.classList.add("v1124-theme-dialog-open");

  requestAnimationFrame(()=>{
   const activeButton=
    dialog.querySelector(".v1124-theme-option.active")||
    dialog.querySelector(".v1124-theme-option")||
    dialog.querySelector(".v1124-theme-dialog-close");

   if(activeButton)activeButton.focus({preventScroll:true});
  });
 }

 function closeThemeDialog(){
  const dialog=document.getElementById("v1124ThemeDialog");
  if(!dialog)return;

  dialog.hidden=true;
  dialog.setAttribute("aria-hidden","true");
  document.body.classList.remove("v1124-theme-dialog-open");

  const menuToggle=document.getElementById("v119MenuToggle");
  if(menuToggle){
   window.setTimeout(()=>menuToggle.focus({preventScroll:true}),20);
  }
 }

 window.addEventListener("v1124-open-theme-dialog",openThemeDialog);

 document.addEventListener("keydown",event=>{
  const dialog=document.getElementById("v1124ThemeDialog");
  if(event.key==="Escape"&&dialog&&!dialog.hidden){
   event.preventDefault();
   closeThemeDialog();
  }
 });


})();





(function(){
 const TOOLTIP_ATTR="data-v1126-watch-tooltip";

 function normalizedText(node){
  return String(node?.textContent||"").replace(/\s+/g," ").trim();
 }

 function findWatchListsSection(){
  const headings=[...document.querySelectorAll(
   "h1,h2,h3,h4,h5,h6,.card-title,.panel-title,.section-title,strong"
  )];

  const title=headings.find(node=>
   /^watch lists$/i.test(normalizedText(node))
  );

  if(!title)return null;

  const section=title.closest(
   "section,.card,.panel,.widget,.workspace,.workspace-panel,.watchlist-workspace,.watch-list-workspace"
  );

  if(!section)return null;

  const sectionText=normalizedText(section);
  return /manage stock groups/i.test(sectionText)?section:null;
 }

 function findWatchListContainer(section){
  const explicit=section.querySelector(
   "#watchLists,#watchListContainer,#watchlistContainer,"+
   ".watch-lists,.watchlists,.watch-list-list,.watchlist-list,"+
   ".watch-list-grid,.watchlist-grid,[data-watch-lists],[data-watchlists]"
  );
  if(explicit)return explicit;

  const candidates=[...section.querySelectorAll(
   ".list,.grid,.items,.tabs,.button-group,.watch-list-items,.watchlist-items,ul,ol"
  )];

  return candidates.find(node=>node.children.length>0)||section;
 }

 function isActionControl(element){
  const text=normalizedText(element).toLowerCase();
  return /^(add|create|new|delete|remove|rename|edit|save|cancel|manage)(\s|$)/i.test(text);
 }

 function getWatchListEntries(section,container){
  const explicit=[...container.querySelectorAll(
   "[data-watchlist-name],[data-watch-list-name],"+
   "[data-watchlist-id],[data-watch-list-id],"+
   ".watchlist-item,.watch-list-item,.watchlist-card,.watch-list-card,"+
   ".watchlist-tab,.watch-list-tab,.watchlist-button,.watch-list-button"
  )];

  if(explicit.length){
   return explicit.filter(item=>!isActionControl(item));
  }

  // Direct children are the safest fallback in this specific card.
  return [...container.children].filter(item=>{
   if(!(item instanceof HTMLElement))return false;
   if(isActionControl(item))return false;
   if(item.matches("script,style,template,form"))return false;
   return normalizedText(item).length>0;
  });
 }

 function getWatchListName(entry){
  const dataName=
   entry.dataset.watchlistName||
   entry.dataset.watchListName||
   entry.getAttribute("data-name");

  if(dataName)return String(dataName).trim();

  const named=entry.querySelector(
   "[data-watchlist-title],[data-watch-list-title],"+
   ".watchlist-name,.watch-list-name,.name,.title,strong,b"
  );

  if(named)return normalizedText(named);

  return normalizedText(entry)
   .replace(/\b\d+\s*(?:trading\s*)?(?:codes?|symbols?|stocks?|items?)\b.*$/i,"")
   .replace(/[×⋮…]+$/,"")
   .trim();
 }

 function parseCount(value){
  const number=parseInt(String(value??"").trim(),10);
  return Number.isFinite(number)?number:null;
 }

 function getWatchListCount(entry){
  const dataCount=[
   entry.dataset.tradingCodeCount,
   entry.dataset.codeCount,
   entry.dataset.watchlistCount,
   entry.dataset.watchListCount,
   entry.getAttribute("data-trading-code-count"),
   entry.getAttribute("data-code-count")
  ].map(parseCount).find(value=>value!==null);

  if(dataCount!==undefined)return dataCount;

  const countNode=entry.querySelector(
   "[data-trading-code-count],[data-code-count],"+
   ".trading-code-count,.code-count,.watchlist-count,.watch-list-count,.count,.badge"
  );

  if(countNode){
   const match=normalizedText(countNode).match(/\d+/);
   if(match)return parseInt(match[0],10);
  }

  const textCount=normalizedText(entry).match(
   /(\d+)\s*(?:trading\s*)?(?:codes?|symbols?|stocks?|items?)/i
  );
  if(textCount)return parseInt(textCount[1],10);

  // Count code chips/rows only inside this watch-list entry.
  const codeElements=[...entry.querySelectorAll(
   "[data-trading-code],[data-code],[data-symbol],"+
   ".trading-code,.stock-code,.symbol-code,.code-chip,.watch-code"
  )];

  if(codeElements.length){
   const values=codeElements.map(node=>
    node.dataset.tradingCode||
    node.dataset.code||
    node.dataset.symbol||
    normalizedText(node)
   ).map(value=>String(value).trim().toUpperCase()).filter(Boolean);

   return new Set(values).size;
  }

  // Some cards link to an external array/list using an ID.
  const watchId=
   entry.dataset.watchlistId||
   entry.dataset.watchListId||
   entry.getAttribute("data-id");

  if(watchId){
   const linked=document.querySelector(
    `[data-watchlist-codes="${CSS.escape(watchId)}"],`+
    `[data-watch-list-codes="${CSS.escape(watchId)}"]`
   );
   if(linked){
    const linkedCodes=linked.querySelectorAll(
     "[data-trading-code],[data-code],[data-symbol],.trading-code,.stock-code,.code-chip"
    );
    if(linkedCodes.length)return linkedCodes.length;
   }
  }

  return 0;
 }

 function enhance(){
  const section=findWatchListsSection();
  if(!section)return;

  section.dataset.v1126WatchListsSection="true";

  const container=findWatchListContainer(section);
  const entries=getWatchListEntries(section,container);

  entries.forEach(entry=>{
   const name=getWatchListName(entry);
   if(!name)return;

   const count=getWatchListCount(entry);
   const noun=count===1?"trading code":"trading codes";
   const tooltip=`${name} • ${count} ${noun}`;

   entry.setAttribute(TOOLTIP_ATTR,tooltip);
   entry.setAttribute("title",tooltip);

   if(
    !entry.hasAttribute("tabindex")&&
    !entry.matches("a,button,input,select,textarea,[tabindex]")
   ){
    entry.tabIndex=0;
   }

   entry.setAttribute("aria-label",tooltip);
  });
 }

 let timer=0;
 function schedule(){
  clearTimeout(timer);
  timer=setTimeout(enhance,80);
 }

 if(document.readyState==="loading"){
  document.addEventListener("DOMContentLoaded",enhance,{once:true});
 }else{
  enhance();
 }

 new MutationObserver(schedule).observe(document.documentElement,{
  subtree:true,
  childList:true,
  characterData:true,
  attributes:true,
  attributeFilter:[
   "data-watchlist-name",
   "data-watch-list-name",
   "data-watchlist-id",
   "data-watch-list-id",
   "data-trading-code-count",
   "data-code-count"
  ]
 });

 window.addEventListener("watchlist-updated",schedule);
 window.addEventListener("watch-list-updated",schedule);
 window.addEventListener("storage",schedule);
})();

</script>

<div class="v105-command" id="v105CommandPalette" aria-hidden="true">
 <div class="v105-command-card">
  <input class="v105-command-search" id="v105CommandSearch" type="search" placeholder="Type a command, view, theme or action…" autocomplete="off">
  <div class="v105-command-results" id="v105CommandResults"></div>
 </div>
</div>

<div class="v105-drawer-backdrop" id="v105RightBackdrop"></div>

<aside class="v105-drawer" id="v105RightDrawer" aria-hidden="true">
 <div class="v105-drawer-head">
  <div><strong id="v105DrawerTitle">Notifications</strong><div class="small" id="v105DrawerSubtitle">Terminal updates and alerts</div></div>
  <button class="btn soft v105-icon-btn" type="button" id="v105CloseDrawer">×</button>
 </div>
 <div class="v105-drawer-body">
  <div class="v105-drawer-tabs">
   <button class="btn soft active" type="button" data-v105-tab="notifications">Notifications</button>
   <button class="btn soft" type="button" data-v105-tab="workspaces">Workspaces</button>
  </div>
  <section id="v105NotificationsTab">
   <div class="v105-list" id="v105NotificationList">
    <div class="v105-empty">No notifications yet.</div>
   </div>
  </section>
  <section id="v105WorkspacesTab" hidden>
   <div class="v105-workspaces">
    <button class="v105-workspace-btn active" type="button" data-workspace="trading" data-target="marketWorkspace"><strong>Trading</strong><small>Watch lists and symbols</small></button>
    <button class="v105-workspace-btn" type="button" data-workspace="download" data-target="downloadWorkspace"><strong>Download</strong><small>Archive status and queue</small></button>
    <button class="v105-workspace-btn" type="button" data-workspace="charts" data-proxy="viewListCharts"><strong>Charts</strong><small>Candlestick gallery</small></button>
    <button class="v105-workspace-btn" type="button" data-workspace="elite" data-proxy="aitOpenElitePriority"><strong>AIT Elite</strong><small>Calibrated decision scanner</small></button>
    <button class="v105-workspace-btn" type="button" data-workspace="elite-regime" data-proxy="aitOpenEliteRegime"><strong>AIT Elite Regime</strong><small>Regime-aware decision scanner</small></button>
    <button class="v105-workspace-btn" type="button" data-workspace="overview" data-target="overviewWorkspace"><strong>Overview</strong><small>Terminal statistics</small></button>
   </div>
   <div style="margin-top:14px">
    <h3 style="margin:0 0 8px">Keyboard shortcuts</h3>
    <div class="v105-shortcuts"><span>Command palette</span><kbd>Ctrl K</kbd></div>
    <div class="v105-shortcuts"><span>Download 3-month data</span><kbd>Ctrl D</kbd></div>
    <div class="v105-shortcuts"><span>Open chart gallery</span><kbd>Ctrl G</kbd></div>
    <div class="v105-shortcuts"><span>Open notifications</span><kbd>Ctrl B</kbd></div>
    <div class="v105-shortcuts"><span>Close active panel</span><kbd>Esc</kbd></div>
   </div>
  </section>
 </div>
</aside>

<div class="v105-toast" id="v105Toast" role="status" aria-live="polite">
 <strong id="v105ToastTitle">Completed</strong>
 <p id="v105ToastText"></p>
</div>


<section id="v112ChartWorkspace" aria-hidden="true">
 <header class="v112-chart-toolbar">
  <div class="v112-chart-toolbar-left">
   <button class="btn v112-back-btn" type="button" id="v112BackDashboard">← Back to Dashboard</button>
   <div class="v112-chart-heading">
    <strong>Chart Workspace</strong>
    <span id="v112ChartSubtitle">Active watch-list charts</span>
   </div>
  </div>

  <div class="v112-chart-toolbar-right">
   <button class="btn soft" type="button" id="v112ChartHelp">?</button>
   <button class="btn soft" type="button" id="v112ChartRefresh">Refresh</button>
   <button class="btn soft" type="button" id="v112ChartFullscreen">⛶ Full Screen</button>
  </div>
 </header>

 <div class="v112-chart-help" id="v112ChartHelpPanel">
  Press Esc to return to the dashboard. Press F to toggle full screen. Double-click a watch-list item or press Enter to open its charts.
 </div>

 <main class="v112-chart-stage">
  <div class="v112-chart-host" id="v112ChartHost">
   <div class="v112-no-chart" id="v112NoChart">
    <div>
     <strong>No chart content is currently available.</strong>
     <p>Return to the dashboard, select a watch list and click View Charts.</p>
    </div>
   </div>
  </div>
 </main>
</section>


<div class="v115-watch-tooltip" id="v115WatchTooltip" role="dialog" aria-hidden="true" aria-label="Watch list information">
 <div class="v115-watch-tooltip-head">
  <div class="v115-watch-title">
   <div class="v115-watch-icon">📁</div>
   <div>
    <strong id="v115WatchName">Watch List</strong>
    <span id="v115WatchSubtitle">Stock group details</span>
   </div>
  </div>
  <button class="btn soft v115-watch-close" type="button" id="v115WatchClose" title="Close">✕</button>
 </div>

 <div class="v115-watch-tooltip-body">
  <div class="v115-watch-stats">
   <div class="v115-watch-stat">
    <span>Trading codes</span>
    <strong id="v115WatchCount">0</strong>
   </div>
   <div class="v115-watch-stat">
    <span>Group type</span>
    <strong>Watch List</strong>
   </div>
  </div>

  <div class="v115-watch-preview-title">
   <b>Trading code preview</b>
   <span id="v115WatchPreviewMeta"></span>
  </div>

  <div class="v115-watch-code-list" id="v115WatchCodes"></div>

  <div class="v115-watch-actions">
   <button class="btn primary" type="button" id="v115WatchOpenCharts">📈 View Charts</button>
   <button class="btn soft" type="button" id="v115WatchSelect">✓ Select List</button>
  </div>
 </div>
</div>
<div class="v115-watch-tooltip-arrow" id="v115WatchTooltipArrow"></div>


<button class="ait-psa-terminal-launcher" id="aitPsaTerminalLauncher" type="button" aria-controls="aitPsaTerminalDock" aria-expanded="false"><span class="ait-psa-terminal-launcher__icon">&gt;_</span><span>Terminal</span></button>
<button class="ait-psa-terminal-dock-backdrop" id="aitPsaTerminalDockBackdrop" type="button" aria-label="Close terminal"></button>
<aside class="ait-psa-terminal-dock" id="aitPsaTerminalDock" aria-hidden="true">
 <header class="ait-psa-terminal-head"><div><strong>AIT PSA Terminal</strong><small>Choose a full-width control group</small></div><button class="ait-psa-terminal-close" id="aitPsaTerminalDockClose" type="button">×</button></header>
 <div class="ait-psa-terminal-groups">
  <button class="ait-psa-terminal-group" id="aitPsaOpenAppearance" data-ait-psa-open="aitPsaAppearanceModal" type="button"><span class="ait-psa-terminal-group__icon">◉</span><span><b>Appearance</b><small>Theme selection and visual surface</small></span><i>→</i></button>
  <button class="ait-psa-terminal-group" id="aitPsaOpenInteraction" data-ait-psa-open="aitPsaInteractionModal" type="button"><span class="ait-psa-terminal-group__icon">✥</span><span><b>Interaction</b><small>Fullscreen, command palette and interface controls</small></span><i>→</i></button>
  <button class="ait-psa-terminal-group" id="aitPsaOpenNavigation" data-ait-psa-open="aitPsaNavigationModal" type="button"><span class="ait-psa-terminal-group__icon">🧭</span><span><b>Navigation</b><small>Jump to dashboard, summaries and notifications</small></span><i>→</i></button>
  <button class="ait-psa-terminal-group" id="aitPsaOpenNotification" data-ait-psa-open="aitPsaNotificationModal" type="button"><span class="ait-psa-terminal-group__icon">♢</span><span><b>Notification</b><small>Terminal events, download updates and alerts</small></span><i>→</i></button>
  <button class="ait-psa-terminal-group" id="aitPsaOpenWorkspace" data-ait-psa-open="aitPsaWorkspaceModal" type="button"><span class="ait-psa-terminal-group__icon">▦</span><span><b>Workspace</b><small>Watch List, Data Center and Trading</small></span><i>→</i></button>
 </div>
</aside>

<div class="ait-psa-terminal-modal-shell" id="aitPsaTerminalModalShell" aria-hidden="true"><button class="ait-psa-terminal-modal-backdrop" id="aitPsaTerminalModalBackdrop" type="button" aria-label="Close modal"></button>
 <section class="ait-psa-terminal-modal" id="aitPsaAppearanceModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">TERMINAL GROUP</span><h2>◉ Appearance</h2><p>Choose an appearance setting to configure.</p></div><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" id="aitPsaOpenThemeMenu" type="button"><span>◐</span><b>Theme</b><small>Open the terminal theme selection menu.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaThemeModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">APPEARANCE ITEM</span><h2>◐ Theme</h2><p>Select a theme to apply it immediately.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" id="aitPsaBackToAppearance" type="button">← Appearance</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body ait-psa-theme-host" id="aitPsaThemeHost"></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaInteractionModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">TERMINAL GROUP</span><h2>✥ Interaction</h2><p>Control the terminal viewport and productivity tools.</p></div><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" id="aitPsaOpenRecentActivity" type="button"><span>◷</span><b>Recent Activity</b><small>Review actions performed across the terminal.</small></button><button class="ait-psa-terminal-command" data-ait-command="command" type="button"><span>⌘</span><b>Command Palette</b><small>Search available terminal commands.</small></button><button class="ait-psa-terminal-command" data-ait-command="fullscreen" type="button"><span>⛶</span><b>Full Screen</b><small>Enter or leave browser fullscreen.</small></button><button class="ait-psa-terminal-command" data-ait-command="top" type="button"><span>↑</span><b>Page Top</b><small>Return to the dashboard header.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaRecentActivityModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">INTERACTION ITEM</span><h2>◷ Recent Activity</h2><p>Review actions performed across the terminal.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" id="aitPsaBackToInteraction" type="button">← Interaction</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-activity-toolbar"><div><strong>Activity timeline</strong><small id="aitPsaRecentActivityCount">0 activities</small></div><button class="ait-psa-terminal-back" id="aitPsaClearRecentActivity" type="button">Clear Activity</button></div><div class="ait-psa-activity-list v105-list" id="aitPsaRecentActivityList"><div class="v105-empty">Your recent actions will appear here.</div></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaNavigationModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">TERMINAL GROUP</span><h2>🧭 Navigation</h2><p>Navigate the simplified index page.</p></div><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-nav="v105Dashboard" type="button"><span>01</span><b>Dashboard</b><small>Operations overview and terminal health.</small></button><button class="ait-psa-terminal-command" data-ait-nav="overviewWorkspace" type="button"><span>02</span><b>Summaries</b><small>DSE codes, watch lists and OHLC totals.</small></button><button class="ait-psa-terminal-command" data-ait-nav="aitPsaHomeNotifications" type="button"><span>03</span><b>Notifications</b><small>Recent terminal events and alerts.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaNotificationModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">TERMINAL GROUP</span><h2>♢ Notification</h2><p>Review terminal events and alerts.</p></div><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></header><div class="ait-psa-terminal-modal__body"><div class="v105-list" id="aitPsaModalNotificationList"></div></div></section>
 <section class="ait-fund-report-modal" id="aitFundamentalsReportModal" aria-hidden="true"><div class="ait-fund-report-panel"><header class="ait-fund-report-head"><div><small>DATA CENTER REPORT</small><h2>Downloaded Fundamentals</h2><p id="aitFundamentalsReportMeta">Merged DSE and AmarStock fundamental data for the active watch list.</p></div><button class="btn soft" type="button" id="aitFundamentalsReportClose">Close</button></header><div class="ait-fund-report-body"><div class="ait-fund-report-search"><span>⌕</span><input id="aitFundamentalsReportSearch" type="search" placeholder="Search trading code, company, category, sector or business segment"><button class="btn soft" type="button" id="aitFundamentalsReportClear">Clear</button><span id="aitFundamentalsReportCount">0 shown</span></div><div class="ait-fund-report-table-wrap"><table class="ait-fund-report-table"><thead><tr><th>Code</th><th>Company</th><th>Cat</th><th>Business Segment</th><th>Year End</th><th>Last AGM</th><th>P/E</th><th>EPS</th><th>Price/NAV</th><th>Free Float</th><th>Beta</th><th>Dividend Yield</th><th>Status</th><th>Downloaded</th></tr></thead><tbody id="aitFundamentalsReportBody"></tbody></table></div></div></div></section>
<section class="ait-psa-terminal-modal" id="aitPsaWorkspaceModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">TERMINAL GROUP</span><h2>▦ Workspace</h2><p>Open a full-width workspace terminal.</p></div><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" id="aitPsaOpenWatchlist" data-ait-psa-open="aitPsaWatchlistMenuModal" type="button"><span>★</span><b>Watch List</b><small>Manage watch lists and run scanners for the active list.</small></button><button class="ait-psa-terminal-command" id="aitPsaOpenDownload" data-ait-psa-open="aitPsaDataCenterLauncherModal" type="button"><span>⇩</span><b>Data Center</b><small>Download and reuse data for the currently active watch list.</small></button><button class="ait-psa-terminal-command" id="aitPsaOpenTrading" data-ait-psa-open="aitPsaTradingLauncherModal" type="button"><span>▥</span><b>Trading</b><small>Open the portfolio workspace.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaDataCenterLauncherModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DATA WORKSPACE</span><h2>⇩ Data Center</h2><p>Choose a data operation category.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaWorkspaceModal" type="button">← Workspace</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaDownloadMenuModal" type="button"><span>⇩</span><b>Download</b><small>Download DSE history and custom archive ranges.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaSyncMenuModal" type="button"><span>↻</span><b>Sync</b><small>Synchronize the latest available market-code directory.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaImportMenuModal" type="button"><span>⇧</span><b>Import</b><small>Import codes, OHLC archives and dashboard backups.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaBackupMenuModal" type="button"><span>◆</span><b>Backup</b><small>Export a portable terminal data backup.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaDataReportMenuModal" type="button"><span>▥</span><b>Report</b><small>Review downloaded data, saved charts, generated reports and the explorer.</small></button><button class="ait-psa-terminal-command ait-psa-terminal-command--danger" data-ait-data-action="emptyDownloadedData" data-ait-data-group="empty" type="button"><span>⌫</span><b>Empty Downloaded Data</b><small>Remove all locally stored OHLC records while preserving watch lists, portfolio and settings.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaDownloadMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DATA CENTER CATEGORY</span><h2>⇩ Download</h2><p>Download and reuse data for the currently active watch list.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaDataCenterLauncherModal" type="button">← Data Center</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaFundamentalsDownloadMenuModal" type="button"><span>FN</span><b>Fundamentals</b><small>Download active-list fundamentals from DSE or AmarStock.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaOhlcDownloadMenuModal" type="button"><span>OHLC</span><b>OHLC</b><small>Active-list Instant, Incremental, Force and Range downloads.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaNewsDownloadMenuModal" type="button"><span>▤</span><b>News</b><small>Download all DSE archive news for the active watch list.</small></button></div></div></section>
<section class="ait-psa-terminal-modal" id="aitPsaFundamentalsDownloadMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DOWNLOAD GROUP</span><h2>FN Fundamentals</h2><p>Select a source for the active watch list.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaDownloadMenuModal" type="button">← Download</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-data-action="downloadFundamentals" data-ait-data-group="fundamentals" type="button"><span>DSE</span><b>DSE</b><small>Cache Category, Business Segment, Year End and Last AGM for active-list codes.</small></button><button class="ait-psa-terminal-command" data-ait-data-action="amarstockFundamentals" data-ait-data-group="fundamentals" type="button"><span>AS</span><b>AmarStock</b><small>Cache P/E, EPS, Price/NAV, Free Float, Beta and Dividend Yield for active-list codes.</small></button></div></div></section>
<section class="ait-psa-terminal-modal" id="aitPsaOhlcDownloadMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DOWNLOAD GROUP</span><h2>OHLC</h2><p>Active Watch List • Instant • Incremental • Force</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaDownloadMenuModal" type="button">← Download</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-data-action="instantDseUpdate" data-ait-data-group="ohlc" type="button"><span>LIVE</span><b>Instant</b><small>Cache today’s provisional OHLC snapshot for active-list codes.</small></button><button class="ait-psa-terminal-command" data-ait-data-action="incrementalOhlcDownload" data-ait-data-group="ohlc" type="button"><span>↻</span><b>Incremental</b><small>Update every cached active-list code from its common latest date to today.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaOhlcForceMenuModal" type="button"><span>⇩</span><b>Force</b><small>Bootstrap or repair active-list 3M, 6M, 1Y or exact-range history.</small></button></div></div></section>

<section class="ait-psa-terminal-modal" id="aitPsaNewsDownloadMenuModal" hidden role="dialog" aria-modal="true" aria-labelledby="aitNewsDownloadTitle">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">ACTIVE WATCH LIST · DOWNLOAD</span><h2 id="aitNewsDownloadTitle">▤ News</h2><p>Download the complete DSE news archive for every symbol in the active watch list.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaDownloadMenuModal" type="button">← Download</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button" aria-label="Close news downloads">×</button></div></header>
 <div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid">
  <button class="ait-psa-terminal-command" data-ait-news-download="all" type="button"><span>⇩</span><b>Download all news</b><small>Fetch every available DSE archive article through today for the active-list symbols. Existing news is merged without duplicates.</small></button>
  <button class="ait-psa-terminal-command" data-ait-news-download="update" type="button"><span>↻</span><b>Update news</b><small>Download from each symbol’s last checked date; initialize missing symbols with the full archive.</small></button>
  <button class="ait-psa-terminal-command" data-ait-news-open="download" type="button"><span>▤</span><b>News workspace</b><small>Read stored news, check download progress and explore categories.</small></button>
 </div></div>
</section>
<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitPsaNewsWorkspaceModal" hidden role="dialog" aria-modal="true" aria-labelledby="aitNewsWorkspaceTitle">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DSE NEWS · REPORT & WORKSPACE</span><h2 id="aitNewsWorkspaceTitle">▤ News</h2><p id="aitNewsScope">Select an active watch list.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" id="aitNewsBack" data-ait-psa-open="aitPsaDataReportMenuModal" type="button">← Report</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button" aria-label="Close news workspace">×</button></div></header>
 <div class="ait-psa-terminal-modal__body">
  <div class="ait-news-controls"><button class="btn primary" type="button" data-ait-news-download="all">Download all news</button><button class="btn soft" type="button" data-ait-news-download="update">Update news</button><button class="btn soft" id="aitNewsRetry" type="button" data-ait-news-download="retry" hidden>Retry failed symbols</button><button class="btn soft" id="aitNewsStop" type="button" disabled>Stop download</button><button class="btn soft" id="aitNewsExport" type="button">Export filtered CSV</button></div>
  <progress id="aitNewsProgress" max="100" value="0" aria-label="News download progress"></progress><p id="aitNewsStatus" role="status" aria-live="polite">News is stored on this device and restored when its watch list is selected.</p><ul id="aitNewsErrors"></ul>
  <p class="small" id="aitNewsCoverage">All news means all articles currently supplied by DSE; older saved articles remain available.</p>
  <details><summary>Category symbols, colors & chart rules</summary><p class="small">Each category shares one symbol; its types use different muted colors. A news article may have several categories. Chart symbols begin 10% below the day’s OHLC low and stack when several types occur on the same date. Lines join consecutive news-day closes: green for higher, red for lower, dark gray for equal. News without an OHLC row on its publication date is listed here and omitted from the chart. Categories are assigned from announcement wording.</p><div id="aitNewsLegend"></div></details>
  <div class="ait-news-filters"><label>Search news<input id="aitNewsSearch" type="search" placeholder="Title, text or trading code"></label><label>Symbol<select id="aitNewsCode"></select></label><label>Category<select id="aitNewsCategory"></select></label><label>Type<select id="aitNewsType"></select></label><label>From<input id="aitNewsFrom" type="date"></label><label>Through<input id="aitNewsTo" type="date"></label><button class="btn soft" id="aitNewsReset" type="button">Reset filters</button></div>
  <p id="aitNewsCount" class="small"></p>
  <p class="small">If CloseP is zero, the previous valid trading-day close is used for the news line and the marker when its low is also zero. The original OHLC data is preserved.</p>
  <div class="ait-news-table-wrap"><table class="ait-news-table" id="aitNewsTable"><thead><tr><th>Date</th><th>Trading Code</th><th>CloseP</th><th>News Category - Subcategory</th><th>News</th></tr></thead><tbody id="aitNewsRows"></tbody></table></div>
 </div>
</section>
<section class="ait-psa-terminal-modal" id="aitPsaOhlcForceMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">OHLC FORCE DOWNLOAD</span><h2>⇩ Force</h2><p>Choose a complete range for the active watch list.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaOhlcDownloadMenuModal" type="button">← OHLC</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-data-action="forceFullOhlc3M" data-ait-data-group="ohlcforce" type="button"><span>3M</span><b>3M</b><small>Refresh the active list’s complete previous three months.</small></button><button class="ait-psa-terminal-command" data-ait-data-action="forceFullOhlcDownload" data-ait-data-group="ohlcforce" type="button"><span>6M</span><b>6M</b><small>Refresh the active list’s complete previous six months.</small></button><button class="ait-psa-terminal-command" data-ait-data-action="forceFullOhlc1Y" data-ait-data-group="ohlcforce" type="button"><span>1Y</span><b>1Y</b><small>Refresh the active list’s complete previous year.</small></button><button class="ait-psa-terminal-command" data-ait-data-action="archiveImport" data-ait-data-group="ohlcforce" type="button"><span>↧</span><b>Range</b><small>Choose an exact active-list range and cache only its symbols.</small></button></div></div></section>
<section class="ait-psa-terminal-modal" id="aitPsaSyncMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DATA CENTER CATEGORY</span><h2>↻ Sync</h2><p>Select a synchronization operation.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaDataCenterLauncherModal" type="button">← Data Center</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-data-action="quickMotherSync" data-ait-data-group="sync" type="button"><span>↻</span><b>Sync DSE Codes</b><small>Refresh the latest available DSE trading-code list.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaImportMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DATA CENTER CATEGORY</span><h2>⇧ Import</h2><p>Select an import or restore operation.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaDataCenterLauncherModal" type="button">← Data Center</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-data-action="motherImport" data-ait-data-group="import" type="button"><span>DSE</span><b>Import DSE Codes</b><small>Import or replace the complete trading-code directory.</small></button><button class="ait-psa-terminal-command" data-ait-data-action="archiveImport" data-ait-data-group="import" type="button"><span>OHLC</span><b>Import OHLC Archive</b><small>Load historical records from files, pasted data or URL.</small></button><button class="ait-psa-terminal-command" data-ait-data-action="importBtn" data-ait-data-group="import" type="button"><span>⇧</span><b>Restore Dashboard</b><small>Restore a complete or legacy dashboard backup, including portfolio data.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaBackupMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DATA CENTER CATEGORY</span><h2>◆ Backup</h2><p>Select a backup operation.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaDataCenterLauncherModal" type="button">← Data Center</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-data-action="exportBtn" data-ait-data-group="backup" type="button"><span>⇩</span><b>Backup Dashboard</b><small>Export watch lists, codes, history and settings.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaDataReportMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DATA CENTER CATEGORY</span><h2>▥ Report</h2><p>Select downloaded data, saved charts, analysis, reports or the explorer.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaDataCenterLauncherModal" type="button">← Data Center</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaDataReportDownloadedModal" type="button"><span>⇩</span><b>Downloaded</b><small>Review downloaded Fundamentals and OHLC data.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaDataReportChartsModal" type="button"><span>▥</span><b>Saved Charts</b><small>Open saved 3M, 6M and 1Y chart galleries.</small></button><button class="ait-psa-terminal-command" data-ait-trading-tab="charts" data-ait-trading-group="data-report" type="button"><span>▥</span><b>Charts</b><small>Open the multi-chart analysis workspace.</small></button><button class="ait-psa-terminal-command" data-ait-trading-tab="reports" data-ait-trading-group="data-report" type="button"><span>≡</span><b>Report</b><small>Generate portfolio, scanner and comparison reports.</small></button><button class="ait-psa-terminal-command" data-ait-trading-tab="explorer" data-ait-trading-group="data-report" type="button"><span>⌕</span><b>Explorer</b><small>Explore saved OHLC history and local market data.</small></button><button class="ait-psa-terminal-command" data-ait-news-open="report" type="button"><span>▤</span><b>News</b><small>Search categorized announcements, read news and export the active-list news report.</small></button></div></div></section>
<section class="ait-psa-terminal-modal" id="aitPsaDataReportDownloadedModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DATA CENTER → REPORT</span><h2>⇩ Downloaded</h2><p>Select the downloaded dataset to review.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaDataReportMenuModal" type="button">← Report</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" id="aitPsaOpenFundamentalsReport" type="button"><span>FN</span><b>Fundamentals</b><small>Review merged DSE and AmarStock fundamental data for the active watch list.</small></button><button class="ait-psa-terminal-command" data-ait-data-action="viewDownloadedData" data-ait-data-group="report" type="button"><span>OHLC</span><b>OHLC</b><small>Inspect stored downloaded OHLC records in a data table.</small></button><button class="ait-psa-terminal-command" data-ait-news-open="report" type="button"><span>▤</span><b>News</b><small>Search categorized announcements, read news and export the active-list news report.</small></button></div></div></section>
<section class="ait-psa-terminal-modal" id="aitPsaDataReportChartsModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DATA CENTER → REPORT</span><h2>▥ Charts</h2><p>Select the saved chart-gallery range.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaDataReportMenuModal" type="button">← Report</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid"><button class="ait-psa-terminal-command" data-ait-data-action="viewListCharts" data-ait-data-group="report" type="button"><span>3M</span><b>3M</b><small>Open saved three-month charts for the active list.</small></button><button class="ait-psa-terminal-command" data-ait-data-action="viewListCharts6" data-ait-data-group="report" type="button"><span>6M</span><b>6M</b><small>Open saved six-month charts for the active list.</small></button><button class="ait-psa-terminal-command" data-ait-data-action="viewListCharts12" data-ait-data-group="charts" type="button"><span>1Y</span><b>1Y Charts</b><small>Review saved one-year charts for the active watch list.</small></button></div></div></section>
<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitPsaDownloadModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow" id="aitPsaDataCenterEyebrow">DATA CENTER TOOL</span><h2 id="aitPsaDataCenterTitle">⇩ Data Center</h2><p id="aitPsaDataCenterDescription">Selected data operation workspace.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" id="aitPsaDataCenterBack" type="button">← Data Center</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body ait-psa-workspace-host" id="aitPsaDownloadHost"></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaWatchlistMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">WORKSPACE CATEGORY</span><h2>★ Watch List</h2><p>Manage the selected stock universe or scan only its trading codes.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaWorkspaceModal" type="button">← Workspace</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid ait-psa-watchlist-menu-grid"><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaWatchlistManagerModal" type="button"><span>★</span><b>Manage Watch Lists</b><small>Create, select and edit watch lists and their DSE trading codes.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaScannerMenuModal" type="button"><span>⌁</span><b>Scanner</b><small>Run every scanner against the currently active watch list only.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitPsaWatchlistManagerModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">WATCH LIST TOOL</span><h2>★ Manage Watch Lists</h2><p>Manage stock groups, trading codes and chart access.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaWatchlistMenuModal" type="button">← Watch List</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body ait-psa-workspace-host" id="aitPsaWatchlistHost"></div></section>
 
<section class="ait-psa-terminal-modal" id="aitPsaSignalPriorityMenuModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">AIT POTENTIAL SIGNAL SCANNER</span><h2>★ AIT Potential Signal Scanner</h2><p>Select the scanner engine or automatic performance monitor.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaScannerMenuModal" type="button">← Scanner</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid ait-signal-priority-menu-grid">
  <button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaSignalPriorityEngineModal" type="button"><span>⚙</span><b>Engine</b><small>Open Latest, Historical, Advanced and Elite signal-priority scanners.</small></button>
  <button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaSignalPriorityPerformanceModal" type="button"><span>↗</span><b>Performance Monitor</b><small>Open automatic scanner performance-monitoring workspaces.</small></button>
 </div></div>
</section>

<section class="ait-psa-terminal-modal" id="aitPsaSignalPriorityPerformanceModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">AIT POTENTIAL SIGNAL SCANNER</span><h2>↗ Performance Monitor</h2><p>Select an automatic scanner performance monitor.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaSignalPriorityMenuModal" type="button">← AIT Potential Signal Scanner</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid ait-signal-priority-menu-grid">
  <button class="ait-psa-terminal-command" data-ait-psa-open="aitElitePerformanceModal" type="button"><span>✹</span><b>AIT Elite</b><small>Automatic rolling Elite validation, stability, benchmark-relative performance and calibration-health monitoring.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitEliteRegimePerformanceModal" type="button"><span>◈</span><b>AIT Elite Regime</b><small>Compare regime-specific signal performance, hit rate, excess return and stability.</small></button>
 </div></div>
</section>

<section class="ait-psa-terminal-modal" id="aitPsaSignalPriorityEngineModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">AIT POTENTIAL SIGNAL SCANNER</span><h2>⚙ Engine</h2><p>Select a signal-priority scanner engine.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaSignalPriorityMenuModal" type="button">← AIT Potential Signal Scanner</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid ait-signal-priority-menu-grid">
  <button class="ait-psa-terminal-command" data-ait-trading-tab="potential-priority" data-ait-trading-group="scanner" type="button"><span>●</span><b>Latest Performance</b><small>Run today’s AIT Signal Priority scanner.</small></button>
  <button class="ait-psa-terminal-command" id="aitOpenHistoricalPriority" type="button"><span>↗</span><b>Historical Performance</b><small>Rank stocks by day-to-day signal, score and rank improvement.</small></button>
  <button class="ait-psa-terminal-command" id="aitOpenAdvancedPriority" type="button"><span>✦</span><b>Advanced Performance</b><small>Historical strength, momentum, stability, persistence, and price-volume confirmation.</small></button>
  <button class="ait-psa-terminal-command" id="aitOpenElitePriority" type="button"><span>✹</span><b>AIT Elite</b><small>Final calibrated decision scanner with liquidity, volatility, breakout, support, entry quality and risk controls.</small></button>
  <button class="ait-psa-terminal-command" id="aitOpenEliteRegime" data-ait-psa-open="aitEliteRegimeModal" type="button"><span>◈</span><b>AIT Elite Regime</b><small>Regime-aware AIT Elite scanner for Bull, Sideways and Bear market conditions.</small></button>
 </div></div>
</section>

<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitHistoricalPriorityModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">SCANNER TOOL</span><h2>AIT Signal Priority — Historical Performance</h2><p>Signal-first screening strengthened by internally calculated historical performance.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaSignalPriorityEngineModal" type="button">← Engine</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body ait-psa-workspace-host"><section class="v11-workspace active"><article class="v11-card v11-scanner-card">
  <div class="v11-card-head"><div><h3>AIT Signal Priority Historical Screener</h3><small>Signal-first ranking using current Primary Score and internally calculated Historical Score</small></div><div class="v11-potential-actions ait-scanner-toolbar">
      <div class="ait-scanner-download" data-ait-scanner-download>
       <button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span>
       </button>
       <div class="ait-scanner-download-menu" hidden>
        <button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button>
        <button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button>
       </div>
      </div>
      <button class="btn primary ait-scanner-run" id="aitHistoricalPriorityRun" type="button">Run</button>
      <div class="ait-scanner-charts" data-ait-scanner-charts>
       <button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span>
       </button>
       <div class="ait-scanner-charts-menu" hidden>
        <button class="btn soft" id="aitHistoricalPriorityCharts3" type="button">3M</button>
        <button class="btn soft" id="aitHistoricalPriorityCharts6" type="button">6M</button>
        <button class="btn soft" id="aitHistoricalPriorityCharts12" type="button">1Y</button>
       </div>
      </div>
     </div></div>
  <div class="v11-card-body"><section class="v11-potential-guideline"><div class="v11-potential-guideline-grid">
   <div class="v11-potential-guide v11-potential-guide--strongest"><strong>First Priority</strong><span>Final signal order always remains Strong Buy → Buy → Watch → Avoid.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Historical Engine</strong><span>Historical Score uses weighted 3-day, 6-day and 9-day Primary Score averages.</span></div>
   <div class="v11-potential-guide v11-potential-guide--watch"><strong>Decision Formula</strong><span>Decision Score = 55% Primary Score + 45% Historical Score.</span></div>
   <div class="v11-potential-guide v11-potential-guide--avoid"><strong>Internal History</strong><span>Daily scanner snapshots are stored and calculated silently; raw history is not shown.</span></div>
  <div class="v11-potential-guide v11-potential-guide--formula"><strong>9D Evidence</strong><span>Replays Primary Score using only data available on each of the latest 9 trading dates. The underlying indicators retain their own lookbacks.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Formation Logic</strong><span>Historical Score = 45% latest 3-date average + 35% latest 6-date average + 20% latest 9-date average. Decision Score = 55% current Primary + 45% Historical. Decision Score and Technical/Smart Money gates assign the signal; rank within each signal by Decision Score, then Historical Score.</span></div>
  </div></section>
  <div class="v11-scanner-table-region"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Overall Rank</th><th>Signal Rank</th><th>Trading Code</th><th>LTP</th><th>Technical</th><th>Smart Money</th><th>Primary Score</th><th>Historical Score</th><th>Relative Rank</th><th>Signal</th></tr></thead><tbody id="aitHistoricalPriorityRows"><tr><td colspan="10">Run historical screen to calculate results.</td></tr></tbody></table></div></div>
  </div></article></section></div>
</section>

<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitAdvancedPriorityModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">SCANNER TOOL</span><h2>AIT Signal Priority — Advanced Performance</h2><p>Multi-factor confirmation scanner combining current strength with historical quality and price-volume validation.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaSignalPriorityEngineModal" type="button">← Engine</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body ait-psa-workspace-host"><section class="v11-workspace active"><article class="v11-card v11-scanner-card">
  <div class="v11-card-head"><div><h3>AIT Advanced Signal Priority Screener</h3><small>Signal-first ranking with historical momentum, stability, persistence and market confirmation</small></div><div class="v11-potential-actions ait-scanner-toolbar">
      <div class="ait-scanner-download" data-ait-scanner-download>
       <button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span>
       </button>
       <div class="ait-scanner-download-menu" hidden>
        <button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button>
        <button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button>
       </div>
      </div>
      <button class="btn primary ait-scanner-run" id="aitAdvancedPriorityRun" type="button">Run</button>
      <div class="ait-scanner-charts" data-ait-scanner-charts>
       <button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span>
       </button>
       <div class="ait-scanner-charts-menu" hidden>
        <button class="btn soft" id="aitAdvancedPriorityCharts3" type="button">3M</button>
        <button class="btn soft" id="aitAdvancedPriorityCharts6" type="button">6M</button>
        <button class="btn soft" id="aitAdvancedPriorityCharts12" type="button">1Y</button>
       </div>
      </div>
     </div></div>
  <div class="v11-card-body"><section class="v11-potential-guideline"><div class="v11-potential-guideline-grid">
   <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Signal Priority</strong><span>Final order remains Strong Buy → Buy → Watch → Avoid.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Advanced Score</strong><span>25% Primary + 20% Historical + 15% Momentum + 12% Stability + 13% Persistence + 15% Confirmation.</span></div>
   <div class="v11-potential-guide v11-potential-guide--watch"><strong>Trend Quality</strong><span>Momentum rewards improving scores; Stability penalizes erratic score changes.</span></div>
   <div class="v11-potential-guide v11-potential-guide--avoid"><strong>Confirmation</strong><span>Price trend, recent volume participation and signal persistence validate the final rank.</span></div>
  <div class="v11-potential-guide v11-potential-guide--formula"><strong>9D Evidence</strong><span>Uses 9 dated Primary snapshots for score changes, stability and signal persistence, plus recent closing prices and volume for confirmation.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Formation Logic</strong><span>Advanced Score = 25% Primary + 20% Historical + 15% Momentum + 12% Stability + 13% Persistence + 15% Confirmation. Strong Buy requires 76+ with Technical and Smart Money at least 60 and Confirmation at least 52; otherwise 63+ Buy, 49+ Watch, or Avoid. Group by signal, then rank by Advanced Score.</span></div>
  </div></section>
  <div class="v11-scanner-table-region"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Overall Rank</th><th>Signal Rank</th><th>Trading Code</th><th>LTP</th><th>Technical</th><th>Smart Money</th><th>Primary Score</th><th>Historical Score</th><th>Momentum</th><th>Stability</th><th>Persistence</th><th>Confirmation</th><th>Advanced Score</th><th>Signal</th></tr></thead><tbody id="aitAdvancedPriorityRows"><tr><td colspan="14">Run advanced screen to calculate results.</td></tr></tbody></table></div></div>
  </div></article></section></div>
</section>
<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitElitePriorityModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">DECISION ENGINE V1.4</span><h2>AIT Elite</h2><p>Self-checking multi-factor decision scanner: refreshes Elite performance state only when downloaded OHLC has changed, then combines current, historical and execution-quality evidence.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaSignalPriorityEngineModal" type="button">← Engine</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body ait-psa-workspace-host"><section class="v11-workspace active"><article class="v11-card v11-scanner-card">
  <div class="v11-card-head"><div><h3>AIT Elite</h3><small>Simple decision-first scanner: what to do, when to act, preferred horizon, model state and plain-language reason</small></div><div class="v11-potential-actions ait-scanner-toolbar">
      <div class="ait-scanner-download" data-ait-scanner-download>
       <button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span>
       </button>
       <div class="ait-scanner-download-menu" hidden>
        <button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button>
        <button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button>
       </div>
      </div>
      <button class="btn primary ait-scanner-run" id="aitElitePriorityRun" type="button">Run</button>
      <div class="ait-scanner-charts" data-ait-scanner-charts>
       <button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false">
        <span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span>
       </button>
       <div class="ait-scanner-charts-menu" hidden>
        <button class="btn soft" id="aitElitePriorityCharts3" type="button">3M</button>
        <button class="btn soft" id="aitElitePriorityCharts6" type="button">6M</button>
        <button class="btn soft" id="aitElitePriorityCharts12" type="button">1Y</button>
       </div>
      </div>
     </div></div>
  <div class="v11-card-body"><section class="v11-potential-guideline"><div class="v11-potential-guideline-grid">
   <div class="v11-potential-guide v11-potential-guide--strongest"><strong>1. What should I do?</strong><span><b>What to Do</b> is the authoritative decision after model health, position state, entry readiness and setup strength are combined. Read it first.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>2. Setup Signal ≠ Action</strong><span><b>Strong Buy / Buy</b> describes setup strength only. It does not mean buy when the final decision says WAIT, HOLD, REDUCE, EXIT or AVOID.</span></div>
   <div class="v11-potential-guide v11-potential-guide--watch"><strong>3. When & Horizon</strong><span>Now = actionable entry. Wait Confirmation / Pullback = no entry yet. Short = 3–6D; Mid = 9–20D. Long term is not validated.</span></div>
   <div class="v11-potential-guide v11-potential-guide--avoid"><strong>4. Model Safety Gate</strong><span>Healthy = normal confidence. Caution = stricter confirmation. Degraded = avoid aggressive entries. Recalibration Required = new buys are blocked even when the setup says Strong Buy.</span></div><div class="v11-potential-guide v11-potential-guide--formula"><strong>5. Elite v4.4 Rank Calibration</strong><span>Strong Buy is the frozen per-date Advanced Rank top 8%, selected before final holdout testing. Entry, liquidity, volatility and timing remain separate action gates, so a Strong Buy setup can still correctly say WAIT.</span></div>
  <div class="v11-potential-guide v11-potential-guide--formula"><strong>6. 9D Evidence</strong><span>Uses 9 dated Primary snapshots and the weighted 3/6/9-date Historical Score. Execution factors read up to 80 OHLCV records with shorter rolling windows; Technical and Smart Money retain their own lookbacks.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>7. Formation Logic</strong><span>Advanced combines Primary (25%), Historical (20%), Momentum (15%), Stability (12%), Persistence (13%) and Confirmation (15%). Elite Score blends weighted setup quality (62%) with timing and anti-chase adjustment (38%). Final setup signals use Advanced rank: top 8% Strong Buy, next 12% Buy, next 60% Watch, bottom 20% Avoid. Entry and model-health checks determine the action separately.</span></div>
  </div></section>
  <section class="ait-elite-summary-block" id="aitEliteDecisionSummary" style="margin-top:14px">
   <div class="ait-fundamental-strip">
    <div class="ait-fundamental-item"><small>Buy Now</small><b><span id="aitEliteCountBuyNow">0</span> ready new entries</b></div>
    <div class="ait-fundamental-item"><small>Wait / Blocked</small><b><span id="aitEliteCountWait">0</span> no-entry decisions</b></div>
    <div class="ait-fundamental-item"><small>Hold / Review</small><b><span id="aitEliteCountHold">0</span> portfolio actions</b></div>
    <div class="ait-fundamental-item"><small>Avoid / Exit</small><b><span id="aitEliteCountAvoid">0</span> reject or leave</b></div>
   </div>
  </section>
  <div class="v11-scanner-table-region" style="margin-top:14px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Priority</th><th>Trading Code</th><th>LTP</th><th>What to Do</th><th>When</th><th>Setup Signal</th><th>Best Horizon</th><th>Model State</th><th>Why</th><th>Details</th></tr></thead><tbody id="aitElitePriorityRows"><tr><td colspan="10">Open AIT Elite to calculate your decision list.</td></tr></tbody></table></div></div>
  </div></article></section></div>
</section>
<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitEliteDecisionDetailModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">AIT ELITE DETAILS</span><h2 id="aitEliteDetailTitle">Decision Details</h2><p>Technical evidence behind the simple action shown in the main Elite table.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitElitePriorityModal" type="button">← AIT Elite</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body ait-psa-workspace-host"><section class="v11-workspace active ait-elite-detail-workspace"><article class="v11-card ait-elite-detail-card"><div class="v11-card-body" id="aitEliteDetailBody"></div></article></section></div>
</section>
<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitEliteRegimeModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">REGIME-AWARE DECISION ENGINE</span><h2>AIT Elite Regime</h2><p>Regime-aware version of AIT Elite. The original AIT Elite remains unchanged.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaSignalPriorityEngineModal" type="button">← Engine</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body ait-psa-workspace-host"><section class="v11-workspace active"><article class="v11-card v11-scanner-card">
  <div class="v11-card-head"><div><h3>AIT Elite Regime Scanner</h3><small>Detects Bull, Sideways or Bear conditions and adjusts the calibrated Elite conviction without upgrading weak evidence.</small></div><div class="v11-potential-actions ait-scanner-toolbar"><div class="ait-scanner-download" data-ait-scanner-download><button class="btn soft ait-scanner-download-trigger" type="button" aria-haspopup="true" aria-expanded="false"><span>⇩ Download</span><span class="ait-scanner-download-caret">⌄</span></button><div class="ait-scanner-download-menu" hidden><button class="btn soft" type="button" data-ait-scanner-download-action="instant">Instant</button><button class="btn soft" type="button" data-ait-scanner-download-action="incremental">Incremental</button></div></div><button class="btn primary ait-scanner-run" id="aitEliteRegimeModalRun" type="button">Run</button><button class="btn soft" id="aitEliteRegimeModalPerformance" type="button">Performance</button><div class="ait-scanner-charts" data-ait-scanner-charts><button class="btn soft ait-scanner-charts-trigger" type="button" aria-haspopup="true" aria-expanded="false"><span>◫ Charts</span><span class="ait-scanner-charts-caret">⌄</span></button><div class="ait-scanner-charts-menu" hidden><button class="btn soft" id="aitEliteRegimeModalCharts3" type="button">3M</button><button class="btn soft" id="aitEliteRegimeModalCharts6" type="button">6M</button><button class="btn soft" id="aitEliteRegimeModalCharts12" type="button">1Y</button></div></div></div></div>
  <div class="v11-card-body">
   <section class="v11-potential-guideline" aria-labelledby="aitEliteRegimeModalGuidelineTitle"><div class="v11-potential-guideline-head"><div><h4 id="aitEliteRegimeModalGuidelineTitle">Elite Regime Guideline</h4><p>Use the calibrated AIT Elite evidence first, then interpret conviction through the current market regime. Regime context can strengthen or weaken confidence, but it cannot manufacture a Strong Buy from weak evidence.</p></div></div><div class="v11-potential-guideline-grid">
    <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Bull · Supportive</strong><span>Trend and breadth conditions favor long-side setups. Strong Elite evidence can receive stronger regime compatibility.</span></div>
    <div class="v11-potential-guide v11-potential-guide--watch"><strong>Sideways · Selective</strong><span>Directional edge is less consistent. Prefer stronger Elite evidence and confirmation before aggressive entries.</span></div>
    <div class="v11-potential-guide v11-potential-guide--avoid"><strong>Bear · Defensive</strong><span>Long-side risk is higher. The Regime Score becomes more demanding and weak setups should remain Watch or Avoid.</span></div>
    <div class="v11-potential-guide v11-potential-guide--formula"><strong>Decision Rule</strong><span>Elite Score + Regime Compatibility → Regime Score → BUY NOW / CONFIRMATION / WATCH / AVOID. The Regime layer never overrides the underlying Elite evidence.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>9D Regime Evidence</strong><span>Uses the 9D Elite setup plus current market breadth and return. Regime trend averages up to 20 trading dates across the active list.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>Formation Logic</strong><span>Start with the 9D Elite Score. Bull adds 4 for Strong Buy or 2 otherwise; Sideways adds 0 for Strong Buy or subtracts 1 otherwise; Bear subtracts 7 for Strong Buy, 5 for Buy or 2 otherwise. Clamp to 0–100. The underlying signal, adjusted score and regime fit determine the action. This modal ranks by Regime Score, then Elite Score.</span></div>
  </div></section>
   <div class="v105-metric-grid"><div class="v105-metric"><span>Market Regime</span><strong id="aitEliteRegimeModalLabel">—</strong></div><div class="v105-metric"><span>Confidence</span><strong id="aitEliteRegimeModalConfidence">—</strong></div><div class="v105-metric"><span>Market Return</span><strong id="aitEliteRegimeModalReturn">—</strong></div><div class="v105-metric"><span>Market Breadth</span><strong id="aitEliteRegimeModalBreadth">—</strong></div></div>
  <div class="v11-scanner-table-region" style="margin-top:14px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Priority</th><th>Trading Code</th><th>LTP</th><th>What to Do</th><th>When</th><th>Setup Signal</th><th>Regime</th><th>Regime Score</th><th>Why</th><th>Details</th></tr></thead><tbody id="aitEliteRegimeModalRows"><tr><td colspan="10">Click Run Scan to calculate the regime-aware shortlist.</td></tr></tbody></table></div></div></div>
 </article></section></div>
</section>

<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitEliteRegimeDetailModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">AIT ELITE REGIME DETAILS</span><h2 id="aitEliteRegimeDetailTitle">Regime Decision Details</h2><p>Detailed Elite evidence plus market-regime context behind the actionable row.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitEliteRegimeModal" type="button">← AIT Elite Regime</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body ait-psa-workspace-host"><section class="v11-workspace active ait-elite-detail-workspace"><article class="v11-card ait-elite-detail-card"><div class="v11-card-body" id="aitEliteRegimeDetailBody"></div></article></section></div>
</section>

<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitEliteRegimePerformanceModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">ELITE REGIME MONITOR</span><h2>AIT Elite Regime Performance Monitor</h2><p>Historical regime classification and regime-specific Elite signal validation reconstructed from downloaded OHLC data.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaSignalPriorityPerformanceModal" type="button">← Performance Monitor</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body ait-psa-workspace-host"><section class="v11-workspace active"><article class="v11-card v11-scanner-card"><div class="v11-card-head"><div><h3>AIT Elite Regime Historical Monitor</h3><small>Measures how Elite signals behaved in Bull, Sideways and Bear regimes. This is validation evidence, not a guaranteed forecast.</small></div><div class="v11-potential-actions"><span class="v11-status-chip" id="aitEliteRegimeMonitorStatus">Automatic</span></div></div><div class="v11-card-body">
  <section class="v11-potential-guideline" aria-labelledby="aitEliteRegimePerformanceGuidelineTitle"><div class="v11-potential-guideline-head"><div><h4 id="aitEliteRegimePerformanceGuidelineTitle">Elite Regime Performance Guideline</h4><p>This monitor is historical validation evidence. It measures how the same AIT Elite signals behaved after being classified into Bull, Sideways and Bear market regimes; it is not a guaranteed forecast.</p></div></div><div class="v11-potential-guideline-grid">
   <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Evaluated Dates</strong><span>Only chronological replay dates with enough forward market data are included. The replay must use information available on the signal date and never future data.</span></div>
   <div class="v11-potential-guide v11-potential-guide--formula"><strong>9D Excess</strong><span>Stock 9D forward return minus the equal-weight active-universe 9D forward return. Positive excess means the signal beat its contemporaneous benchmark.</span></div>
   <div class="v11-potential-guide v11-potential-guide--watch"><strong>Regime Stability</strong><span>Positive excess is stronger evidence when there are enough distinct regime dates and enough signal observations. A large observation count concentrated in only a few regime dates is treated as low-date-sample evidence.</span></div>
   <div class="v11-potential-guide v11-potential-guide--avoid"><strong>How to Read It</strong><span>Use sample size, excess return, win rate and median excess together. Strong historical evidence does not guarantee the next signal will win.</span></div>
  </div></section>
  <div class="v105-metric-grid"><div class="v105-metric"><span>Evaluated Dates</span><strong id="aitEliteRegimePerfDates">0</strong><em>historical replay dates</em></div><div class="v105-metric"><span>Best Regime</span><strong id="aitEliteRegimePerfBest">—</strong><em>highest excess evidence</em></div><div class="v105-metric"><span>Strongest Excess</span><strong id="aitEliteRegimePerfExcess">—</strong><em>across evaluated regimes</em></div><div class="v105-metric"><span>Stable Regimes</span><strong id="aitEliteRegimePerfStable">0</strong><em>positive and sufficiently sampled</em></div></div>
  <div class="v11-scanner-table-region" style="margin-top:14px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Regime</th><th>Dates</th><th>Samples</th><th>Strong Buy Samples</th><th>9D Raw</th><th>9D Excess</th><th>9D Win%</th><th>Avg Elite Score</th><th>Assessment</th></tr></thead><tbody id="aitEliteRegimePerformanceRows"><tr><td colspan="9">Regime performance will be calculated automatically.</td></tr></tbody></table></div></div>
  <div class="v11-scanner-table-region" style="margin-top:14px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Regime</th><th>Signal</th><th>Samples</th><th>Raw Avg</th><th>Excess Avg</th><th>Win%</th><th>Median</th><th>Risk Note</th></tr></thead><tbody id="aitEliteRegimeSignalRows"><tr><td colspan="8">Signal-by-regime diagnostics will appear automatically.</td></tr></tbody></table></div></div>
 </div></article></section></div>
</section>

<section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitElitePerformanceModal" hidden role="dialog" aria-modal="true">
 <header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">ELITE MONITORING V4.4</span><h2>AIT Elite Performance Monitor</h2><p>Leakage-safe rolling validation, walk-forward holdout checks, benchmark-adjusted ranking analysis and calibration-health diagnostics reconstructed from downloaded OHLC data.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaSignalPriorityPerformanceModal" type="button">← Performance Monitor</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header>
 <div class="ait-psa-terminal-modal__body ait-psa-workspace-host"><section class="v11-workspace active"><article class="v11-card v11-scanner-card">
  <div class="v11-card-head"><div><h3>AIT Elite Automatic Performance Monitoring v4.4</h3><small>Automatically rebuilds from downloaded OHLC, validates calibrated signals across rolling windows, and tests the frozen Advanced Rank separately in development, validation and final holdout periods.</small></div><div class="v11-potential-actions"><span class="v11-status-chip" id="aitElitePerformanceAutoStatus">Automatic</span></div></div>
  <div class="v11-card-body">
   <section class="v11-potential-guideline"><div class="v11-potential-guideline-grid">
    <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Excess Return</strong><span>For every date and horizon: stock forward return − equal-weight active-universe forward return. Positive excess means the signal beat its contemporaneous market universe.</span></div>
    <div class="v11-potential-guide v11-potential-guide--formula"><strong>Advanced Rank</strong><span>v4.4 uses Advanced Score for cross-sectional ranking after it passed separate development, validation and untouched holdout checks. Elite Setup calibration remains separate for signal labels.</span></div>
    <div class="v11-potential-guide v11-potential-guide--watch"><strong>Confidence</strong><span>Sample confidence rises from Low to Medium, High and Very High as evaluated observations increase. Small groups are intentionally discounted in the validation score.</span></div>
    <div class="v11-potential-guide v11-potential-guide--avoid"><strong>No Look-ahead</strong><span>Historical scores use data only through the replay date. Entry and every forward horizon require an exact positive close on the common market trading date; future OHLC is used only for evaluation.</span></div>
    <div class="v11-potential-guide v11-potential-guide--strongest"><strong>Strong Buy Trust</strong><span>The frozen Advanced Rank top-8% Strong Buy cohort is validated separately across 20D, 40D, 60D, 100D and all history. BUY NOW remains locked unless model reliability and current trust are acceptable.</span></div>
   </div></section>
   <div class="v105-metric-grid" style="margin-top:14px">
    <div class="v105-metric"><span>Trading Dates</span><strong id="aitElitePerfSnapshots">0</strong><em>automatically reconstructed</em></div>
    <div class="v105-metric"><span>Base Observations</span><strong id="aitElitePerfSignals">0</strong><em>exact signal-date close available</em></div>
    <div class="v105-metric"><span>9D Evaluable</span><strong id="aitElitePerf9dSignals">0</strong><em>exact 9th market-date close available</em></div>
    <div class="v105-metric"><span>9D Strong Buy Excess</span><strong id="aitElitePerfWin9">—</strong><em>average return above universe</em></div>
    <div class="v105-metric"><span>Evidence Quality</span><strong id="aitElitePerfAvg9">—</strong><em>diagnostic score, not forecast accuracy</em></div>
    <div class="v105-metric"><span>Advanced Rank Quality</span><strong id="aitElitePerfRankingQuality">—</strong><em>top percentiles vs bottom 20%</em></div>
    <div class="v105-metric"><span>Model Reliability</span><strong id="aitEliteReliabilityState">—</strong><em>rank, holdout and signal stability combined</em></div>
    <div class="v105-metric"><span>Holdout Rank</span><strong id="aitEliteHoldoutRank">—</strong><em>final 20% of trading dates</em></div>
    <div class="v105-metric"><span>Calibration Health</span><strong id="aitElitePerfCalibrationHealth">—</strong><em>automatic rolling stability status</em></div>
    <div class="v105-metric"><span>Decision Gate</span><strong id="aitEliteDecisionGate">—</strong><em>scanner permission for new entries</em></div>
    <div class="v105-metric"><span>SB Time Consistency</span><strong id="aitEliteSbConsistency">—</strong><em>positive 9D edge across rolling blocks</em></div>
   </div>
   <div style="margin-top:18px"><h3 style="margin:0 0 8px">Rolling Calibration Health</h3><small>Compares calibrated Final Signals across 20D, 40D, 60D, 100D and all history. v4.4 separates actionable Strong Buy evidence from the independently validated Advanced Rank and excludes non-trading observations.</small></div>
   <div class="v11-scanner-table-region" style="margin-top:8px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Window</th><th>Dates</th><th>Samples</th><th>Strong Buy 9D</th><th>Buy 9D</th><th>Watch 9D</th><th>Avoid 9D</th><th>20D SB−Avoid Spread</th><th>Ranking Quality</th><th>Signal Ordering</th><th>Health</th></tr></thead><tbody id="aitElitePerformanceRollingRows"><tr><td colspan="11">Rolling calibration health will be calculated automatically from downloaded OHLC data.</td></tr></tbody></table></div></div>
   <div class="v105-metric-grid" style="margin-top:14px">
    <div class="v105-metric"><span>Strong Buy Trust</span><strong id="aitEliteStrongBuyTrustState">—</strong><em>current evidence gate</em></div>
    <div class="v105-metric"><span>SB Samples</span><strong id="aitEliteStrongBuyTrustSamples">0</strong><em>all-history calibrated samples</em></div>
    <div class="v105-metric"><span>SB 9D Edge</span><strong id="aitEliteStrongBuyTrust9D">—</strong><em>vs active universe</em></div>
    <div class="v105-metric"><span>SB 20D Edge</span><strong id="aitEliteStrongBuyTrust20D">—</strong><em>vs active universe</em></div>
    <div class="v105-metric"><span>SB 9D 95% Range</span><strong id="aitEliteStrongBuyTrustCi">—</strong><em>Newey–West date-clustered diagnostic</em></div>
   </div>
   <div style="margin-top:16px"><h3 style="margin:0 0 8px">Strong Buy Trust Validation</h3><small>Separates Strong Buy reliability from overall ranking quality. Trust improves when Strong Buy has positive excess, beats Avoid, has adequate samples, and remains stable across medium windows.</small></div>
   <div class="v11-scanner-table-region" style="margin-top:8px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Window</th><th>SB Samples</th><th>6D SB</th><th>9D SB</th><th>15D SB</th><th>20D SB</th><th>9D SB−Avoid</th><th>20D SB−Avoid</th><th>Trust</th></tr></thead><tbody id="aitEliteStrongBuyTrustRows"><tr><td colspan="9">Strong Buy trust will be calculated automatically.</td></tr></tbody></table></div></div>
   <div style="margin-top:16px"><h3 style="margin:0 0 8px">Strong Buy Comparative Validation</h3><small>Shows whether calibrated Strong Buy adds value versus Buy, Watch, Avoid and every non-Strong-Buy observation. This remains the primary actionable-signal diagnostic in v4.4.</small></div>
   <div class="v11-scanner-table-region" style="margin-top:8px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Comparison</th><th>3D Spread</th><th>6D Spread</th><th>9D Spread</th><th>15D Spread</th><th>20D Spread</th></tr></thead><tbody id="aitEliteStrongBuyCompareRows"><tr><td colspan="6">Strong Buy comparative evidence will be calculated automatically.</td></tr></tbody></table></div></div>
   <div style="margin-top:16px"><h3 style="margin:0 0 8px">Strong Buy Time Consistency</h3><small>Splits history into non-overlapping 20-trading-date blocks. A robust edge should appear across multiple periods rather than depend on only one unusually profitable regime.</small></div>
   <div class="v11-scanner-table-region" style="margin-top:8px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Period</th><th>Dates</th><th>SB Samples</th><th>9D SB</th><th>9D SB−Non-SB</th><th>20D SB−Non-SB</th><th>Result</th></tr></thead><tbody id="aitEliteStrongBuyConsistencyRows"><tr><td colspan="7">Time consistency will be calculated automatically.</td></tr></tbody></table></div></div>
   <div style="margin-top:16px"><h3 style="margin:0 0 8px">Chronological Holdout Validation</h3><small>Evaluates the frozen Advanced Rank on the first 60%, next 20% and untouched final 20% of dates. No period is shuffled, and Strong Buy is reported separately from generic rank skill.</small></div>
   <div class="v11-scanner-table-region" style="margin-top:8px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Period</th><th>Dates</th><th>Samples</th><th>Rank Quality</th><th>Top 10% 9D</th><th>Bottom 20% 9D</th><th>9D Spread</th><th>SB Samples</th><th>SB 9D</th><th>Rank Test</th></tr></thead><tbody id="aitEliteTemporalValidationRows"><tr><td colspan="10">Chronological holdout validation will be calculated automatically.</td></tr></tbody></table></div></div>
   <p id="aitEliteReliabilityReason" style="margin:10px 0 0"><small>Reliability reasons will appear after reconstruction.</small></p>
   <div style="margin-top:16px"><h3 style="margin:0 0 8px">Legacy / Raw Signal Validation</h3><small>Diagnostic only. This table validates the older raw signal vocabulary and is not used for BUY NOW. A zero Strong Buy count here does not mean the calibrated Final Signal has no Strong Buy observations.</small></div>
   <div class="v11-scanner-table-region" style="margin-top:8px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Signal</th><th>Samples</th><th>Confidence</th><th>3D Raw</th><th>3D Excess</th><th>6D Raw</th><th>6D Excess</th><th>9D Raw</th><th>9D Excess</th><th>9D Excess Win%</th><th>15D Excess</th><th>20D Excess</th><th>MFE</th><th>MAE</th><th>Validation</th></tr></thead><tbody id="aitElitePerformanceRows"><tr><td colspan="15">Elite performance will be reconstructed automatically from downloaded OHLC data.</td></tr></tbody></table></div></div>
   <div style="margin-top:18px"><h3 style="margin:0 0 8px">Final Rank-Signal Validation</h3><small>Reconstructs the frozen Advanced Rank bands: Strong Buy top 8%, Buy 8–20%, Watch 20–80% and Avoid bottom 20%. Tradeability and entry readiness remain separate decision gates.</small></div>
   <div class="v11-scanner-table-region" style="margin-top:8px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Final Signal</th><th>Samples</th><th>Confidence</th><th>3D Excess</th><th>6D Excess</th><th>9D Excess</th><th>9D Excess Win%</th><th>15D Excess</th><th>20D Excess</th><th>MFE</th><th>MAE</th><th>Validation</th></tr></thead><tbody id="aitElitePerformanceCalibratedRows"><tr><td colspan="12">Calibrated signal validation will appear after automatic reconstruction.</td></tr></tbody></table></div></div>
   <div style="margin-top:18px"><h3 style="margin:0 0 8px">Advanced Rank Percentile-Band Validation</h3><small>Non-overlapping per-date Advanced Rank bands test whether better-ranked stocks deliver stronger forward excess. These bands do not redefine Strong Buy labels.</small></div>
   <div class="v11-scanner-table-region" style="margin-top:8px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Percentile Band</th><th>Samples</th><th>Confidence</th><th>3D Excess</th><th>6D Excess</th><th>9D Excess</th><th>9D Excess Win%</th><th>15D Excess</th><th>20D Excess</th><th>MFE</th><th>MAE</th><th>Validation</th></tr></thead><tbody id="aitElitePerformanceBucketRows"><tr><td colspan="12">Percentile-band validation will appear after automatic reconstruction.</td></tr></tbody></table></div></div>
   <div style="margin-top:18px"><h3 style="margin:0 0 8px">Advanced Ranking Diagnostic</h3><small>Tests broad cross-sectional Advanced Rank quality. Rank skill and Strong Buy trust are separate requirements inside the v4.4 reliability gate.</small></div>
   <div class="v11-scanner-table-region" style="margin-top:8px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Rank Group</th><th>Samples</th><th>Confidence</th><th>3D Excess</th><th>6D Excess</th><th>9D Excess</th><th>9D Excess Win%</th><th>15D Excess</th><th>20D Excess</th><th>Validation</th></tr></thead><tbody id="aitElitePerformancePercentileRows"><tr><td colspan="10">Percentile ranking validation will appear after automatic reconstruction.</td></tr></tbody></table></div></div>
   <div style="margin-top:18px"><h3 style="margin:0 0 8px">Universe Context</h3><small>The full reconstructed universe should have approximately zero excess return versus its own equal-weight benchmark; this table is context, not a ranking-skill score.</small></div>
   <div class="v11-scanner-table-region" style="margin-top:8px"><div class="v11-table-scrollbar" aria-label="Horizontal table scrollbar"><div></div></div><div class="v11-table-wrap v11-scanner-table-wrap"><table class="v11-table v11-potential-table"><thead><tr><th>Horizon</th><th>Samples</th><th>Raw Avg</th><th>Benchmark Avg</th><th>Excess Avg</th><th>Excess Win%</th></tr></thead><tbody id="aitElitePerformanceHorizonRows"><tr><td colspan="6">Holding-period analysis will appear after automatic reconstruction.</td></tr></tbody></table></div></div>
  </div>
 </article></section></div>
</section>
<section class="ait-psa-terminal-modal" id="aitPsaTradingLauncherModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">TRADING WORKSPACE</span><h2>▥ Trading</h2><p>Open the portfolio management workspace.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaWorkspaceModal" type="button">← Workspace</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid ait-psa-trading-launcher-grid"><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaPortfolioMenuModal" type="button"><span>◫</span><b>Portfolio</b><small>Positions, quantities, cost, value and profit or loss.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaPortfolioMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">TRADING CATEGORY</span><h2>◫ Portfolio</h2><p>Select the portfolio workspace.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaTradingLauncherModal" type="button">← Trading</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid ait-psa-trading-tool-grid"><button class="ait-psa-terminal-command" data-ait-trading-tab="portfolio" data-ait-trading-group="portfolio" type="button"><span>◫</span><b>Portfolio Manager</b><small>Manage holdings and review current portfolio performance.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal" id="aitPsaScannerMenuModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow">WATCH LIST SUBMENU</span><h2>⌁ Scanner</h2><p>Select a scanner for the active watch list.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" data-ait-psa-open="aitPsaWatchlistMenuModal" type="button">← Watch List</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body"><div class="ait-psa-terminal-command-grid ait-psa-trading-tool-grid"><button class="ait-psa-terminal-command" data-ait-trading-tab="indicators" data-ait-trading-group="scanner" type="button"><span>∿</span><b>Technical Scanner</b><small>Screen trend, momentum, SMA, RSI and volume conditions.</small></button><button class="ait-psa-terminal-command" data-ait-trading-tab="vpa" data-ait-trading-group="scanner" type="button"><span>▥</span><b>Smart Money Scanner</b><small>Analyze VPA, volume, spread and effort versus result.</small></button><button class="ait-psa-terminal-command" data-ait-trading-tab="comparison" data-ait-trading-group="scanner" type="button"><span>⇄</span><b>Relative Strength Scanner</b><small>Rank active stocks against their peers without issuing buy signals.</small></button><button class="ait-psa-terminal-command" data-ait-trading-tab="potential-composite" data-ait-trading-group="scanner" type="button"><span>◇</span><b>AIT Composite Screener</b><small>40/35/25 weighted multi-factor score.</small></button><button class="ait-psa-terminal-command" data-ait-trading-tab="potential" data-ait-trading-group="scanner" type="button"><span>◆</span><b>AIT Elite Screener</b><small>Balanced 50/50 primary score with relative tie-breaking.</small></button><button class="ait-psa-terminal-command" data-ait-psa-open="aitPsaSignalPriorityMenuModal" type="button"><span>★</span><b>AIT Potential Signal Scanner</b><small>Open the scanner Engine or automatic Performance Monitor.</small></button></div></div></section>
 <section class="ait-psa-terminal-modal ait-psa-workspace-modal" id="aitPsaTradingModal" hidden role="dialog" aria-modal="true"><header class="ait-psa-terminal-modal__head"><div><span class="ait-psa-terminal-modal__eyebrow" id="aitPsaTradingEyebrow">TRADING TOOL</span><h2 id="aitPsaTradingTitle">▥ Trading</h2><p id="aitPsaTradingDescription">Selected trading workspace.</p></div><div class="ait-psa-terminal-head-actions"><button class="ait-psa-terminal-back" id="aitPsaTradingBack" type="button">← Trading</button><button class="ait-psa-terminal-close" data-ait-psa-close type="button">×</button></div></header><div class="ait-psa-terminal-modal__body ait-psa-workspace-host" id="aitPsaTradingHost"></div></section>
</div>

<div class="v119-menu-backdrop" id="v119MenuBackdrop"></div>
<div class="v119-terminal-menu" id="v119TerminalMenu">
 <button class="btn primary v119-menu-toggle" id="v119MenuToggle" type="button" aria-expanded="false">
  <span class="dots"><i></i><i></i><i></i><i></i></span>
  <span class="label">Terminal Menu</span>
  <span>▼</span>
 </button>
 <div class="v119-menu-panel" id="v119MenuPanel">
  <div class="v119-menu-head">
   <div><strong>Terminal Menu</strong><small>Grouped terminal actions and appearance settings</small></div>
   <button class="btn soft v119-menu-close" id="v119MenuClose" type="button" aria-label="Close terminal menu" title="Close menu">✕</button>
  </div>
  <div class="v119-menu-groups" id="v119MenuGroups"></div>
 </div>
</div>

<script id="aitPsaPhaTerminalScript">
document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const launcher = document.getElementById('aitPsaTerminalLauncher');
  const dock = document.getElementById('aitPsaTerminalDock');
  const dockBackdrop = document.getElementById('aitPsaTerminalDockBackdrop');
  const shell = document.getElementById('aitPsaTerminalModalShell');
  if (!launcher || !dock || !dockBackdrop || !shell) return;

  body.classList.add('ait-psa-index-only');
  let lastFocus = launcher;
  const recordTerminalActivity = (title, text, type = 'success') => {
    if (window.aitPsaActivityAPI?.add) window.aitPsaActivityAPI.add(title, text, type);
    else window.dispatchEvent(new CustomEvent('ait-psa-activity-pending', { detail: { title, text, type } }));
  };
  const modalActivityNames = {
    aitPsaAppearanceModal: 'Appearance',
    aitPsaThemeModal: 'Theme',
    aitPsaInteractionModal: 'Interaction',
    aitPsaRecentActivityModal: 'Recent Activity',
    aitPsaNavigationModal: 'Navigation',
    aitPsaNotificationModal: 'Notification',
    aitPsaWorkspaceModal: 'Workspace',
    aitPsaDataCenterLauncherModal: 'Data Center',
    aitPsaDownloadMenuModal: 'Download',
    aitPsaFundamentalsDownloadMenuModal: 'Fundamentals',
    aitPsaOhlcDownloadMenuModal: 'OHLC',
    aitPsaSyncMenuModal: 'Sync',
    aitPsaImportMenuModal: 'Import',
    aitPsaBackupMenuModal: 'Backup',
    aitPsaDataReportMenuModal: 'Data Center Report',
    aitPsaDataReportDownloadedModal: 'Downloaded Data',
    aitPsaDataReportChartsModal: 'Data Charts',
    aitPsaDownloadModal: 'Data Center Tool',
    aitPsaWatchlistMenuModal: 'Watch List',
    aitPsaWatchlistManagerModal: 'Manage Watch Lists',
    aitPsaTradingLauncherModal: 'Trading',
    aitPsaPortfolioMenuModal: 'Portfolio',
    aitPsaScannerMenuModal: 'Scanner',
    aitPsaTradingModal: 'Trading Tool'
  };

  const syncBodyLock = () => body.classList.toggle(
    'ait-psa-terminal-open',
    dock.classList.contains('open') || shell.classList.contains('open')
  );

  const setDock = (open) => {
    dock.classList.toggle('open', open);
    dockBackdrop.classList.toggle('open', open);
    dock.setAttribute('aria-hidden', String(!open));
    launcher.setAttribute('aria-expanded', String(open));
    syncBodyLock();
  };

  const closeModal = () => {
    shell.querySelectorAll('.ait-psa-terminal-modal').forEach((modal) => { modal.hidden = true; });
    shell.classList.remove('open');
    shell.setAttribute('aria-hidden', 'true');
    syncBodyLock();
    lastFocus?.focus?.();
  };

  const openModal = (id) => {
    const modal = document.getElementById(id);
    if (!modal) return;
    lastFocus = document.activeElement;
    setDock(false);
    shell.querySelectorAll('.ait-psa-terminal-modal').forEach((item) => { item.hidden = true; });
    modal.hidden = false;
    shell.classList.add('open');
    shell.setAttribute('aria-hidden', 'false');
    syncBodyLock();
    requestAnimationFrame(() => {
      modal.querySelector('button,[href],input,select')?.focus();
      if (id === 'aitPsaTradingModal') window.dispatchEvent(new Event('resize'));
    });
    const activityName = modalActivityNames[id];
    if (activityName) recordTerminalActivity(`${activityName} opened`, `${activityName} terminal menu opened`);
  };

  // Keep each original functional workspace independent.
  const themeHost = document.getElementById('aitPsaThemeHost');

  const download = document.getElementById('downloadWorkspace');
  const downloadHost = document.getElementById('aitPsaDownloadHost');
  if (download && downloadHost) downloadHost.appendChild(download);

  const sidebar = document.querySelector('.app > .layout > .sidebar');
  const marketWorkspace = document.getElementById('marketWorkspace');
  const watchHost = document.getElementById('aitPsaWatchlistHost');
  if (watchHost && (sidebar || marketWorkspace)) {
    const watchLayout = document.createElement('div');
    watchLayout.className = 'ait-psa-watchlist-layout';
    if (sidebar) watchLayout.appendChild(sidebar);
    if (marketWorkspace) watchLayout.appendChild(marketWorkspace);
    watchHost.appendChild(watchLayout);
  }

  const trading = document.getElementById('v11Terminal');
  const tradingHost = document.getElementById('aitPsaTradingHost');
  if (trading && tradingHost) tradingHost.appendChild(trading);

  launcher.addEventListener('click', () => {
    const opening = !dock.classList.contains('open');
    setDock(opening);
    if (opening) recordTerminalActivity('Terminal opened', 'Main terminal menu opened');
  });
  dockBackdrop.addEventListener('click', () => setDock(false));

  const bindModalRoute = (buttonId, modalId) => {
    const button = document.getElementById(buttonId);
    if (!button) return;
    button.addEventListener('click', (event) => {
      event.preventDefault();
      event.stopPropagation();
      openModal(modalId);
    });
  };

  [
    ['aitPsaOpenAppearance', 'aitPsaAppearanceModal'],
    ['aitPsaOpenInteraction', 'aitPsaInteractionModal'],
    ['aitPsaOpenRecentActivity', 'aitPsaRecentActivityModal'],
    ['aitPsaBackToInteraction', 'aitPsaInteractionModal'],
    ['aitPsaOpenNavigation', 'aitPsaNavigationModal'],
    ['aitPsaOpenNotification', 'aitPsaNotificationModal'],
    ['aitPsaOpenWorkspace', 'aitPsaWorkspaceModal'],
    ['aitPsaOpenThemeMenu', 'aitPsaThemeModal'],
    ['aitPsaBackToAppearance', 'aitPsaAppearanceModal'],
    ['aitPsaOpenDownload', 'aitPsaDataCenterLauncherModal'],
    ['aitPsaOpenWatchlist', 'aitPsaWatchlistMenuModal'],
    ['aitPsaOpenTrading', 'aitPsaTradingLauncherModal']
  ].forEach(([buttonId, modalId]) => bindModalRoute(buttonId, modalId));

  // Dedicated Theme terminal. It does not depend on the old hidden menu or proxy clicks.
  const themeDefinitions = [
    ['dark-glass', 'Dark Glass', 'Premium default'],
    ['classic-light', 'Classic', 'Clean light interface'],
    ['sapphire', 'Sapphire', 'Finance blue'],
    ['emerald', 'Emerald', 'Trading green'],
    ['royal-purple', 'Royal Purple', 'Premium violet'],
    ['carbon-oled', 'Carbon OLED', 'True black'],
    ['crimson', 'Crimson', 'Bold market red'],
    ['coffee', 'Coffee', 'Warm workspace'],
    ['aurora', 'Aurora', 'Teal violet']
  ];

  if (themeHost) {
    themeHost.innerHTML = '<div class="v10-theme-grid ait-psa-native-theme-grid" id="aitPsaNativeThemeGrid"></div>';
    const nativeThemeGrid = document.getElementById('aitPsaNativeThemeGrid');
    const currentTheme = document.documentElement.dataset.theme || 'dark-glass';

    themeDefinitions.forEach(([value, label, description]) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'v10-theme-option';
      button.dataset.aitThemeValue = value;
      button.classList.toggle('active', currentTheme === value);
      button.innerHTML = `<span class="v10-swatch"></span><strong>${label}</strong><small>${description}</small>`;
      nativeThemeGrid?.appendChild(button);
    });

    nativeThemeGrid?.addEventListener('click', (event) => {
      const option = event.target.closest('[data-ait-theme-value]');
      if (!option) return;
      const theme = option.dataset.aitThemeValue;
      document.documentElement.dataset.theme = theme;
      try { localStorage.setItem('ababil-dse-v10-theme', JSON.stringify(theme)); } catch (_) {}

      const quickSelect = document.getElementById('v10ThemeQuick');
      if (quickSelect) quickSelect.value = theme;

      document.querySelectorAll('[data-theme-value]').forEach((legacyOption) => {
        legacyOption.classList.toggle('active', legacyOption.dataset.themeValue === theme);
      });
      nativeThemeGrid.querySelectorAll('[data-ait-theme-value]').forEach((nativeOption) => {
        nativeOption.classList.toggle('active', nativeOption.dataset.aitThemeValue === theme);
      });

      const selectedTheme = themeDefinitions.find(([value]) => value === theme);
      recordTerminalActivity('Theme changed', `Theme changed to ${selectedTheme?.[1] || theme}`);
      window.dispatchEvent(new CustomEvent('ait:theme-changed', { detail: { theme } }));
    });
  }

  const dataCenterGroupModal = {
    download: 'aitPsaDownloadMenuModal',
    sync: 'aitPsaSyncMenuModal',
    import: 'aitPsaImportMenuModal',
    backup: 'aitPsaBackupMenuModal',
    report: 'aitPsaDataReportMenuModal',
    empty: 'aitPsaDataCenterLauncherModal',
    fundamentals: 'aitPsaFundamentalsDownloadMenuModal',
    ohlc: 'aitPsaOhlcDownloadMenuModal',     ohlcforce: 'aitPsaOhlcForceMenuModal'
  };
  const dataCenterDefinitions = {
    downloadFundamentals: ['DSE', 'DSE Fundamentals', 'Download Category, Business Segment, Year End and Last AGM for the current watch list.'],
    amarstockFundamentals: ['AS', 'AmarStock Fundamentals', 'Download P/E Ratio, EPS, Price/NAV, Free Float, Beta and Dividend Yield for the current watch list.'],
    instantDseUpdate: ['LIVE', 'Instant Hybrid OHLC Download', 'Available during the configured trading window when today’s official archive data is absent.'],
    incrementalOhlcDownload: ['↻', 'Incremental OHLC Sync', 'Normal daily update from the latest stored OHLC date through today.'],
    dse3mUpdate: ['3M', 'Legacy DSE 3M Sync', 'Compatibility action for the existing 3M workflow.'],
    dse6mUpdate: ['6M', 'Legacy DSE 6M Sync', 'Compatibility action for the existing 6M workflow.'],
    forceFullOhlc3M: ['3M', 'Force Full DSE 3M', 'Bootstrap/repair mode: re-download the full three-month OHLC range.'],
    forceFullOhlcDownload: ['6M', 'Force Full DSE 6M', 'Bootstrap/repair mode: re-download the full six-month OHLC range.'],
    forceFullOhlc1Y: ['1Y', 'Force Full DSE 1Y', 'Bootstrap/repair mode: re-download the full one-year OHLC range.'],
    archiveImport: ['OHLC', 'Archive Workspace', 'Download or import historical OHLC archive records.'],
    quickMotherSync: ['↻', 'Sync DSE Codes', 'Synchronize the latest available DSE code directory.'],
    motherImport: ['DSE', 'Import DSE Codes', 'Import or replace the complete trading-code directory.'],
    importBtn: ['⇧', 'Restore Dashboard', 'Restore terminal data from a dashboard backup.'],
    exportBtn: ['⇩', 'Backup Dashboard', 'Export terminal data and settings as a portable backup.'],
    viewListCharts: ['3M', 'Saved 3M Charts', 'Review saved three-month charts for the active watch list.'],
    viewListCharts6: ['6M', 'Saved 6M Charts', 'Review saved six-month charts for the active watch list.'],     viewListCharts12: ['1Y', 'Saved 1Y Charts', 'Review saved one-year charts for the active watch list.'],
    viewDownloadedData: ['⌗', 'Downloaded Data', 'Inspect stored OHLC records in a data table.'],
    status: ['◉', 'Download Status', 'Review Data Center operations and current download status.'],
    emptyDownloadedData: ['⌫', 'Empty Downloaded Data', 'Permanently remove all locally stored OHLC records while preserving watch lists, portfolio and settings.']
  };
  let activeDataCenterGroup = 'download';

  const openDataCenterTool = (actionName, groupName, execute = true) => {
    activeDataCenterGroup = groupName || 'download';
    const definition = dataCenterDefinitions[actionName] || ['⇩', 'Data Center', 'Selected data operation workspace.'];
    const title = document.getElementById('aitPsaDataCenterTitle');
    const description = document.getElementById('aitPsaDataCenterDescription');
    const eyebrow = document.getElementById('aitPsaDataCenterEyebrow');
    const back = document.getElementById('aitPsaDataCenterBack');
    if (title) title.textContent = `${definition[0]} ${definition[1]}`;
    if (description) description.textContent = definition[2];
    if (eyebrow) eyebrow.textContent = `${activeDataCenterGroup.toUpperCase()} TOOL`;
    if (back) back.textContent = activeDataCenterGroup==='empty'?'← Data Center':`← ${activeDataCenterGroup.charAt(0).toUpperCase()+activeDataCenterGroup.slice(1)}`;
    openModal('aitPsaDownloadModal');
    if (execute && actionName !== 'status') {
      requestAnimationFrame(() => {
        const target = document.getElementById(actionName);
        if (target) target.click();
      });
    } else if (actionName === 'status') {
      requestAnimationFrame(() => {
        const statusCard = document.getElementById('downloadStatusCard');
        if (statusCard) {
          statusCard.style.display = '';
          statusCard.scrollIntoView({behavior:'smooth',block:'start'});
        }
      });
    }
    recordTerminalActivity(`${definition[1]} opened`, `${activeDataCenterGroup} data center tool opened`);
  };

  document.getElementById('aitPsaDataCenterBack')?.addEventListener('click', () => {
    openModal(dataCenterGroupModal[activeDataCenterGroup] || 'aitPsaDataCenterLauncherModal');
  });

  const tradingToolDefinitions = {
    portfolio: ['◫ Portfolio', 'Portfolio holdings and performance workspace.'],
    charts: ['▥ Charts', 'Multi-chart analysis workspace.'],
    reports: ['≡ Report', 'Generated trading and scanner reports.'],
    explorer: ['⌕ Explorer', 'Saved OHLC history and local data explorer.'],
    indicators: ['∿ Technical Scanner', 'Technical trend, momentum and volume screening.'],
    vpa: ['▥ Smart Money Scanner', 'VPA-based volume and price-spread screening.'],
    comparison: ['⇄ Relative Strength Scanner', 'Cross-stock relative ranking workspace.'],
    'potential-composite': ['◇ AIT Composite Screener', '40/35/25 weighted multi-factor screening.'],
    potential: ['◆ AIT Elite Screener', 'Balanced 50/50 primary scoring with relative tie-breaking.'],
    'elite-regime': ['◈ AIT Elite Regime', 'Regime-aware Elite scoring for Bull, Sideways and Bear market conditions.'],
    'potential-priority': ['★ AIT Signal Priority Screener', 'Signal-first ranking with close-score relative tie-breaking.']
  };
  const tradingGroupModal = {
    portfolio: 'aitPsaPortfolioMenuModal',
    scanner: 'aitPsaScannerMenuModal',
    'data-report': 'aitPsaDataReportMenuModal'
  };
  const tradingGroupLabels = {
    portfolio: 'Portfolio',
    scanner: 'Scanner',
    'data-report': 'Data Center Report'
  };
  let activeTradingGroup = 'portfolio';

  const openTradingTool = (tabName, groupName) => {
    activeTradingGroup = groupName || 'portfolio';
    const definition = tradingToolDefinitions[tabName] || ['▥ Trading', 'Selected trading workspace.'];
    const groupLabel = tradingGroupLabels[activeTradingGroup] || 'Trading';
    const title = document.getElementById('aitPsaTradingTitle');
    const description = document.getElementById('aitPsaTradingDescription');
    const eyebrow = document.getElementById('aitPsaTradingEyebrow');
    const back = document.getElementById('aitPsaTradingBack');
    if (title) title.textContent = definition[0];
    if (description) description.textContent = definition[1];
    if (eyebrow) eyebrow.textContent = `${groupLabel.toUpperCase()} TOOL`;
    if (back) back.textContent = `← ${groupLabel}`;

    const tabButton = document.querySelector(`[data-v11-tab="${CSS.escape(tabName)}"]`);
    tabButton?.click();
    openModal('aitPsaTradingModal');
    requestAnimationFrame(() => window.dispatchEvent(new Event('resize')));
    recordTerminalActivity(`${definition[0].replace(/^[^A-Za-z]+/, '')} opened`, `${groupLabel} tool opened`);
  };

  document.getElementById('aitPsaTradingBack')?.addEventListener('click', () => {
    openModal(tradingGroupModal[activeTradingGroup] || 'aitPsaTradingLauncherModal');
  });

  document.addEventListener('click', async (event) => {
    const dockClose = event.target.closest('#aitPsaTerminalDockClose');
    if (dockClose) { setDock(false); return; }

    const dataTool = event.target.closest('[data-ait-data-action]');
    if (dataTool) {
      event.preventDefault();
      event.stopPropagation();
      const actionName=dataTool.dataset.aitDataAction;
      if(['dse3mUpdate','dse6mUpdate','incrementalOhlcDownload','forceFullOhlc3M','forceFullOhlcDownload','forceFullOhlc1Y'].includes(actionName)){
        closeModal();
        const target=document.getElementById(actionName);
        if(target)target.click();
        requestAnimationFrame(()=>openDataCenterTool('status','report',false));
      }else{
        openDataCenterTool(actionName, dataTool.dataset.aitDataGroup, true);
      }
      return;
    }

    const dataWorkspace = event.target.closest('[data-ait-data-workspace]');
    if (dataWorkspace) {
      event.preventDefault();
      event.stopPropagation();
      openDataCenterTool(dataWorkspace.dataset.aitDataWorkspace, dataWorkspace.dataset.aitDataGroup, false);
      return;
    }

    const tradingTool = event.target.closest('[data-ait-trading-tab]');
    if (tradingTool) {
      event.preventDefault();
      event.stopPropagation();
      openTradingTool(tradingTool.dataset.aitTradingTab, tradingTool.dataset.aitTradingGroup);
      return;
    }

    const group = event.target.closest('[data-ait-psa-open]');
    if (group) {
      event.preventDefault();
      event.stopPropagation();
      openModal(group.dataset.aitPsaOpen);
      return;
    }

    if (event.target.closest('[data-ait-psa-close],#aitPsaTerminalModalBackdrop')) {
      closeModal(); return;
    }

    const nav = event.target.closest('[data-ait-nav]');
    if (nav) {
      const target = document.getElementById(nav.dataset.aitNav);
      recordTerminalActivity('Navigation used', `Navigated to ${nav.textContent.trim().replace(/\s+/g, ' ')}`);
      closeModal();
      setTimeout(() => target?.scrollIntoView({ behavior: 'smooth', block: 'start' }), 70);
      return;
    }

    const commandButton = event.target.closest('[data-ait-command]');
    if (commandButton) {
      const command = commandButton.dataset.aitCommand;
      if (command === 'command') {
        recordTerminalActivity('Command Palette opened', 'Terminal command palette opened');
        closeModal();
        setTimeout(() => (document.getElementById('v105CommandBtnDesktop') || document.getElementById('v105CommandBtn'))?.click(), 60);
      } else if (command === 'top') {
        recordTerminalActivity('Page Top used', 'Returned to the dashboard header');
        closeModal();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      } else if (command === 'fullscreen') {
        recordTerminalActivity('Fullscreen toggled', document.fullscreenElement ? 'Exited fullscreen mode' : 'Entered fullscreen mode');
        try {
          if (document.fullscreenElement) await document.exitFullscreen();
          else await document.documentElement.requestFullscreen();
        } catch (_) {}
      }
    }
  });

  // Recent Activity reads the shared persistent activity store directly.
  const activityTarget = document.getElementById('aitPsaRecentActivityList');
  const activityCount = document.getElementById('aitPsaRecentActivityCount');
  const activityKey = 'ababil-dse-v105-activity';
  const activityEscape = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
  const activityRelativeTime = iso => {
    const diff=Math.max(0,Date.now()-new Date(iso).getTime());
    const min=Math.floor(diff/60000);
    if(min<1)return 'now';
    if(min<60)return `${min}m ago`;
    const hr=Math.floor(min/60);
    if(hr<24)return `${hr}h ago`;
    return `${Math.floor(hr/24)}d ago`;
  };
  const readRecentActivities = () => {
    try { const value=JSON.parse(localStorage.getItem(activityKey)); return Array.isArray(value)?value:[]; } catch (_) { return []; }
  };
  const syncRecentActivity = () => {
    if (!activityTarget) return;
    const items=readRecentActivities();
    activityTarget.innerHTML=items.length?items.map(item=>`
      <div class="v105-list-item">
       <span class="v105-status-dot ${activityEscape(item.type||'success')}"></span>
       <div><strong>${activityEscape(item.title||'Activity')}</strong><p>${activityEscape(item.text||'Action completed')}</p></div>
       <time title="${activityEscape(new Date(item.time).toLocaleString())}">${activityRelativeTime(item.time)}</time>
      </div>`).join(''):'<div class="v105-empty">Your recent actions will appear here.</div>';
    if (activityCount) activityCount.textContent = `${items.length} ${items.length === 1 ? 'activity' : 'activities'}`;
  };
  document.getElementById('aitPsaClearRecentActivity')?.addEventListener('click', () => {
    window.aitPsaActivityAPI?.clear?.();
    try {
      const state=JSON.parse(localStorage.getItem('dse-watch-dashboard-v3')||'{}');
      if(state&&typeof state==='object'){state.activity=[];localStorage.setItem('dse-watch-dashboard-v3',JSON.stringify(state));}
    } catch (_) {}
    syncRecentActivity();
  });
  window.addEventListener('ait-psa-activity-updated',syncRecentActivity);
  window.addEventListener('storage',event=>{if(event.key===activityKey)syncRecentActivity()});
  syncRecentActivity();

  // Centralized activity tracking for every meaningful action performed inside the terminal.
  const normalizeActivityLabel = element => {
    const explicit = element.getAttribute('aria-label') || element.getAttribute('title');
    const bold = element.querySelector('b,strong')?.textContent;
    const raw = explicit || bold || element.textContent || element.name || element.id || 'Terminal action';
    return String(raw).replace(/\s+/g, ' ').trim().replace(/^[←→×✕⌘⛶↑⇩★▥◐◷♢▦✥◉\s]+/, '').trim() || 'Terminal action';
  };
  const routeIds = new Set([
    'aitPsaOpenAppearance','aitPsaOpenInteraction','aitPsaOpenRecentActivity','aitPsaBackToInteraction',
    'aitPsaOpenNavigation','aitPsaOpenNotification','aitPsaOpenWorkspace','aitPsaOpenThemeMenu',
    'aitPsaBackToAppearance','aitPsaOpenDownload','aitPsaOpenWatchlist','aitPsaOpenTrading',
    'aitPsaTerminalLauncher','aitPsaTerminalDockClose','aitPsaClearRecentActivity'
  ]);
  document.addEventListener('click', event => {
    const action = event.target.closest('button,a,[role="button"]');
    if (!action || routeIds.has(action.id) || action.matches('[data-ait-psa-close],[data-ait-psa-open],[data-ait-nav],[data-ait-command],[data-ait-theme-value],[data-theme-value]')) return;
    const inTerminal = action.closest('#aitPsaTerminalDock,#aitPsaTerminalModalShell');
    const functionalDialog = body.classList.contains('ait-psa-terminal-open') && action.closest('.modal.open,[role="dialog"].open,.v111-chart-modal.open');
    if (!inTerminal && !functionalDialog) return;
    const label = normalizeActivityLabel(action);
    recordTerminalActivity(`${label}`, `${label} action used`);
  }, true);
  document.addEventListener('change', event => {
    const field = event.target.closest('select,input,textarea');
    if (!field) return;
    const inTerminal = field.closest('#aitPsaTerminalModalShell');
    const functionalDialog = body.classList.contains('ait-psa-terminal-open') && field.closest('.modal.open,[role="dialog"].open');
    if (!inTerminal && !functionalDialog) return;
    const label = field.labels?.[0]?.textContent?.trim() || field.getAttribute('aria-label') || field.name || field.id || 'Terminal setting';
    let value = field.type === 'file' ? `${field.files?.length || 0} file selected` : field.type === 'checkbox' ? (field.checked ? 'enabled' : 'disabled') : String(field.value || 'updated');
    if (value.length > 80) value = `${value.slice(0,77)}...`;
    recordTerminalActivity(`${label} changed`, `${label}: ${value}`);
  }, true);

  // Notifications remain sourced from the original working notification list.
  const source = document.getElementById('v105NotificationList');
  const overview = document.getElementById('overviewWorkspace');
  const home = document.createElement('section');
  home.className = 'ait-psa-home-notifications';
  home.id = 'aitPsaHomeNotifications';
  home.innerHTML = '<article class="v105-panel"><div class="v105-panel-head"><div><h3>Notifications</h3><small>Recent terminal updates and alerts</small></div><span class="ait-psa-panel-meta">LIVE FEED</span></div><div class="v105-panel-body"><div class="v105-list" id="aitPsaHomeNotificationList"></div></div></article>';
  overview?.insertAdjacentElement('afterend', home);

  const syncNotifications = () => {
    const html = source?.innerHTML || '<div class="v105-empty">No notifications yet.</div>';
    const homeList = document.getElementById('aitPsaHomeNotificationList');
    const modalList = document.getElementById('aitPsaModalNotificationList');
    if (homeList) homeList.innerHTML = html;
    if (modalList) modalList.innerHTML = html;
  };
  syncNotifications();
  if (source) new MutationObserver(syncNotifications).observe(source, { childList: true, subtree: true, characterData: true });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    if (shell.classList.contains('open')) closeModal();
    else if (dock.classList.contains('open')) setDock(false);
  });
});
</script>

<style id="v10020-scanner-search-style">
.v11-scanner-searchbar{position:relative;display:grid;grid-template-columns:auto minmax(190px,.65fr) minmax(300px,1.35fr) auto;grid-template-areas:"orb copy field clear" "orb status status status";gap:9px 14px;align-items:center;overflow:hidden;margin:12px 0 10px;padding:16px;border:1px solid var(--v10-line,var(--line,rgba(148,163,184,.30)));border-radius:20px;background:linear-gradient(135deg,color-mix(in srgb,var(--v10-card,var(--card,#111827)) 96%,transparent),color-mix(in srgb,var(--v10-panel-solid,var(--panel,#0f172a)) 94%,transparent));color:var(--v10-text,var(--text,#e5edf8));box-shadow:0 18px 42px color-mix(in srgb,var(--v10-shadow,rgba(0,0,0,.32)) 80%,transparent),inset 0 1px 0 color-mix(in srgb,#fff 10%,transparent);isolation:isolate}
.v11-scanner-searchbar::before{content:"";position:absolute;inset:-1px;z-index:-2;border-radius:inherit;background:radial-gradient(circle at 12% 10%,color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 28%,transparent),transparent 32%),radial-gradient(circle at 88% 100%,color-mix(in srgb,var(--v10-accent,var(--accent,#06b6d4)) 20%,transparent),transparent 34%);pointer-events:none}
.v11-scanner-searchbar::after{content:"";position:absolute;top:0;left:9%;right:9%;height:1px;background:linear-gradient(90deg,transparent,color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 78%,#fff),transparent);opacity:.85;pointer-events:none}
.v11-scanner-searchbar__orb{grid-area:orb;display:grid;place-items:center;width:54px;height:54px;border:1px solid color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 44%,var(--v10-line,var(--line,#334155)));border-radius:17px;background:linear-gradient(145deg,color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 24%,var(--v10-card,var(--card,#111827))),color-mix(in srgb,var(--v10-card,var(--card,#111827)) 96%,transparent));color:var(--v10-primary,var(--primary,#60a5fa));font-size:1.75rem;font-weight:900;box-shadow:0 10px 28px color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 22%,transparent),inset 0 1px 0 rgba(255,255,255,.11)}
.v11-scanner-searchbar__copy{grid-area:copy;min-width:0}.v11-scanner-searchbar__copy label{display:block;color:var(--v10-text,var(--text,#f8fafc));font-size:1rem;font-weight:900;letter-spacing:-.01em}.v11-scanner-searchbar__copy small{display:block;margin-top:3px;color:var(--v10-muted,var(--muted,#94a3b8));font-size:.72rem;line-height:1.35}.v11-scanner-searchbar__kicker{display:block;margin-bottom:2px;color:var(--v10-primary,var(--primary,#60a5fa));font-size:.62rem;font-weight:900;letter-spacing:.13em;text-transform:uppercase}
.v11-scanner-searchbar__field{grid-area:field;position:relative;min-width:0}.v11-scanner-searchbar__icon{position:absolute;left:14px;top:50%;z-index:2;transform:translateY(-50%);color:var(--v10-primary,var(--primary,#60a5fa));font-size:1.15rem;pointer-events:none}.v11-scanner-searchbar input{width:100%!important;min-height:50px!important;padding:11px 46px 11px 42px!important;border:1px solid color-mix(in srgb,var(--v10-line,var(--line,#334155)) 90%,transparent)!important;border-radius:15px!important;outline:0!important;background:color-mix(in srgb,var(--v10-input,var(--v10-panel-solid,var(--panel,#0f172a))) 96%,transparent)!important;color:var(--v10-text,var(--text,#f8fafc))!important;font-size:.92rem!important;font-weight:750!important;box-shadow:inset 0 1px 0 rgba(255,255,255,.04),0 8px 22px rgba(0,0,0,.12)!important;transition:border-color .18s ease,box-shadow .18s ease,transform .18s ease,background .18s ease!important}.v11-scanner-searchbar input::placeholder{color:color-mix(in srgb,var(--v10-muted,var(--muted,#94a3b8)) 84%,transparent);font-weight:600}.v11-scanner-searchbar input:hover{border-color:color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 52%,var(--v10-line,var(--line,#334155)))!important}.v11-scanner-searchbar input:focus{border-color:var(--v10-primary,var(--primary,#2563eb))!important;background:color-mix(in srgb,var(--v10-card,var(--card,#111827)) 97%,transparent)!important;box-shadow:0 0 0 4px color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 18%,transparent),0 14px 34px color-mix(in srgb,var(--v10-primary,var(--primary,#2563eb)) 16%,transparent)!important;transform:translateY(-1px)}
.v11-scanner-searchbar__key{position:absolute;right:12px;top:50%;transform:translateY(-50%);min-width:25px;padding:3px 7px;border:1px solid var(--v10-line,var(--line,#334155));border-bottom-width:2px;border-radius:7px;background:color-mix(in srgb,var(--v10-card,var(--card,#111827)) 90%,transparent);color:var(--v10-muted,var(--muted,#94a3b8));font:700 .7rem/1 system-ui,sans-serif;text-align:center;pointer-events:none}
.v11-scanner-searchbar__clear{grid-area:clear;display:inline-flex!important;visibility:visible!important;align-items:center;justify-content:center;min-width:82px;min-height:48px!important;padding-inline:17px!important;border-radius:14px!important}.v11-scanner-searchbar__clear:disabled{display:inline-flex!important;visibility:visible!important;opacity:.55;cursor:not-allowed}.v11-scanner-searchbar__count{grid-area:status;min-height:18px;color:var(--v10-muted,var(--muted,#94a3b8));font-size:.72rem;font-weight:650}.v11-scanner-search-empty td{text-align:center;padding:20px!important;opacity:.7}
@media(max-width:940px){.v11-scanner-searchbar{grid-template-columns:auto minmax(0,1fr) auto;grid-template-areas:"orb copy clear" "field field field" "status status status"}}
@media(max-width:620px){.v11-scanner-searchbar{grid-template-columns:1fr auto;grid-template-areas:"copy copy" "field clear" "status status";padding:13px}.v11-scanner-searchbar__orb{display:none}.v11-scanner-searchbar__copy small{display:none}}
@media(max-width:430px){.v11-scanner-searchbar{grid-template-columns:1fr;grid-template-areas:"copy" "field" "clear" "status"}.v11-scanner-searchbar__clear{width:100%}}
</style>
<script id="v10019-scanner-search-script">
(()=>{
 const normalize=value=>String(value||'').toUpperCase().replace(/\s+/g,' ').trim();
 const setupCard=(card,index)=>{
  if(!card||card.dataset.v10020SearchReady==='1')return;
  const region=card.querySelector('.v11-scanner-table-region');
  const tbody=region?.querySelector('tbody');
  if(!region||!tbody)return;
  card.dataset.v10020SearchReady='1';
  const title=card.querySelector('.v11-card-head h3')?.textContent?.trim()||'Scanner';
  const id=`v11ScannerSearch${index}`;
  const bar=document.createElement('div');
  bar.className='v11-scanner-searchbar';
  bar.innerHTML=`<div class="v11-scanner-searchbar__orb" aria-hidden="true">⌕</div><div class="v11-scanner-searchbar__copy"><span class="v11-scanner-searchbar__kicker">SCANNER RESULTS</span><label for="${id}">Search Trading Code</label><small>Instantly filter ${title} ranked results</small></div><div class="v11-scanner-searchbar__field"><span class="v11-scanner-searchbar__icon" aria-hidden="true">⌕</span><input class="input" id="${id}" type="search" autocomplete="off" spellcheck="false" placeholder="Search ROBI, ALIF, SUMITPOWER…" aria-label="Search ${title} results"><kbd class="v11-scanner-searchbar__key">/</kbd></div><button class="btn soft v11-scanner-searchbar__clear" type="button">Clear</button><div class="v11-scanner-searchbar__count" aria-live="polite">0 shown</div>`;
  region.before(bar);
  const input=bar.querySelector('input');
  const clear=bar.querySelector('button');
  const count=bar.querySelector('.v11-scanner-searchbar__count');
  const apply=()=>{
   const q=normalize(input.value);
   let total=0,shown=0;
   tbody.querySelectorAll('tr').forEach(row=>{
    if(row.classList.contains('v11-scanner-search-empty'))row.remove();
   });
   const rows=[...tbody.querySelectorAll('tr')];
   rows.forEach(row=>{
    const isMessage=row.children.length===1 && /no local data|no sufficient|no data/i.test(row.textContent||'');
    if(isMessage){row.hidden=!!q;return;}
    total++;
    const match=!q||normalize(row.textContent).includes(q);
    row.hidden=!match;
    if(match)shown++;
   });
   if(q&&total>0&&shown===0){
    const empty=document.createElement('tr');
    empty.className='v11-scanner-search-empty';
    const colspan=region.querySelector('thead tr')?.children.length||1;
    empty.innerHTML=`<td colspan="${colspan}">No scanner result matches “${String(input.value).replace(/[<>&\"]/g,c=>({'<':'&lt;','>':'&gt;','&':'&amp;','"':'&quot;'}[c]))}”.</td>`;
    tbody.appendChild(empty);
   }
   count.textContent=q?`${shown} of ${total} shown`:`${total} result${total===1?'':'s'}`;
   clear.hidden=false;
   clear.disabled=!input.value;
   clear.setAttribute('aria-disabled', input.value ? 'false' : 'true');
  };
  input.addEventListener('input',apply);
  clear.addEventListener('click',()=>{input.value='';apply();input.focus()});
  new MutationObserver(()=>requestAnimationFrame(apply)).observe(tbody,{childList:true,subtree:false});
  apply();
 };
 const init=()=>document.querySelectorAll('.v11-scanner-card').forEach(setupCard);
 if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init,{once:true});else init();
 new MutationObserver(init).observe(document.documentElement,{childList:true,subtree:true});
})();
</script>


<style id="v10030-chart-gallery-search-style">
.v11-chart-gallery-search{margin:0 0 14px}
.v11-chart-gallery-empty{grid-column:1/-1;padding:24px;text-align:center;color:var(--v10-muted,var(--muted,#94a3b8));border:1px dashed var(--v10-line,var(--line,#334155));border-radius:14px}
</style>
<script id="v10029-chart-gallery-search-script">
(()=>{"use strict";
 const configs={
  gallery:{input:"gallerySearch",clear:"gallerySearchClear",count:"gallerySearchCount"},
  v11RankedChartGallery:{input:"v11RankedChartSearch",clear:"v11RankedChartSearchClear",count:"v11RankedChartSearchCount"}
 };
 const normalize=value=>String(value||"").trim().toUpperCase();
 function elements(galleryId){const cfg=configs[galleryId],gallery=document.getElementById(galleryId);if(!cfg||!gallery)return null;return{gallery,input:document.getElementById(cfg.input),clear:document.getElementById(cfg.clear),count:document.getElementById(cfg.count)}}
 function apply(galleryId){const refs=elements(galleryId);if(!refs)return;const term=normalize(refs.input?.value);const cards=[...refs.gallery.querySelectorAll(":scope > .mini-card")];let shown=0;cards.forEach(card=>{const code=normalize(card.getAttribute("data-ranked-chart")||card.querySelector("h3")?.textContent||card.textContent);const visible=!term||code.includes(term);card.hidden=!visible;if(visible)shown++});let empty=refs.gallery.querySelector(":scope > .v11-chart-gallery-empty");if(term&&cards.length&&shown===0){if(!empty){empty=document.createElement("div");empty.className="v11-chart-gallery-empty";refs.gallery.appendChild(empty)}empty.textContent=`No chart matches “${refs.input.value.trim()}”.`;empty.hidden=false}else if(empty)empty.remove();if(refs.count)refs.count.textContent=`${shown} of ${cards.length} shown`;if(refs.clear)refs.clear.disabled=!term}
 function bind(galleryId){const refs=elements(galleryId);if(!refs||refs.input?.dataset.bound==="1")return;if(refs.input){refs.input.dataset.bound="1";refs.input.addEventListener("input",()=>apply(galleryId));refs.input.addEventListener("keydown",event=>{if(event.key==="Escape"&&refs.input.value){refs.input.value="";apply(galleryId)}})}refs.clear?.addEventListener("click",()=>{if(refs.input)refs.input.value="";apply(galleryId);refs.input?.focus()});apply(galleryId)}
 function reset(galleryId){bind(galleryId);const refs=elements(galleryId);if(refs?.input)refs.input.value="";apply(galleryId)}
 function refresh(galleryId){bind(galleryId);apply(galleryId)}
 window.AITChartGallerySearch={reset,refresh,apply};
 document.addEventListener("DOMContentLoaded",()=>Object.keys(configs).forEach(bind));
})();
</script>


<script id="ait-history-priority-script">
(()=>{"use strict";
 const clamp=n=>Math.max(0,Math.min(100,Number(n)||0));
 const esc=v=>String(v??"").replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#039;"}[c]));
 const mean=values=>values.length?values.reduce((sum,value)=>sum+(Number(value)||0),0)/values.length:0;
 const finalSignal=(score,technical,smartMoney)=>score>=75&&technical>=60&&smartMoney>=60?"Strong Buy":score>=62?"Buy":score>=48?"Watch":"Avoid";
 let cache={signature:"",rows:[],dates:[]};

 const scannerBridge=()=>window.AITScannerDataBridge||null;
 const marketHistory=()=>{
  try{return scannerBridge()?.appState?.()?.history||{}}catch(error){console.warn("Historical history lookup failed",error);return {}}
 };
 const scannerCodes=()=>scannerBridge()?.scannerCodes?.()||scannerBridge()?.codes?.()||[];
 const availableDates=()=>{const cutoff=window.__AIT_HISTORICAL_CUTOFF_DATE__||null,history=marketHistory();return [...new Set(scannerCodes().flatMap(code=>Array.isArray(history[code])?history[code].map(row=>String(row?.date||"")).filter(Boolean):[]))].filter(date=>!cutoff||date<=cutoff).sort()};
 const signatureFor=dates=>`${scannerBridge()?.scannerHistorySignature?.()||scannerCodes().join("|")}|${dates.at(-1)||"none"}|${dates.length}`;

 const buildDailyPriority=dates=>{
  const daily=[];
  const previous=window.__AIT_HISTORICAL_CUTOFF_DATE__;
  try{
   dates.forEach(date=>{
    window.__AIT_HISTORICAL_CUTOFF_DATE__=date;
    const rows=scannerBridge()?.priorityDataset?.()||[];
    daily.push({date,rows:rows.map(row=>({...row}))});
   });
  }finally{
   if(previous)window.__AIT_HISTORICAL_CUTOFF_DATE__=previous;
   else delete window.__AIT_HISTORICAL_CUTOFF_DATE__;
  }
  return daily;
 };

 const calculate=()=>{
  const allDates=availableDates();
  if(allDates.length<9)return {rows:[],dates:allDates,required:9,available:allDates.length};
  const calculationDates=allDates.slice(-9),signature=signatureFor(allDates);
  if(cache.signature===signature&&cache.rows.length)return {rows:cache.rows,dates:cache.dates,required:9,available:allDates.length};

  const daily=buildDailyPriority(calculationDates),latest=daily.at(-1);
  if(!latest?.rows?.length)return {rows:[],dates:calculationDates,required:9,available:allDates.length};

  const output=latest.rows.map(current=>{
   const timeline=daily.map(snapshot=>snapshot.rows.find(row=>row.code===current.code)).filter(Boolean);
   const scores=timeline.map(row=>Number(row.primaryScore)||0);
   const avg3=mean(scores.slice(-3));
   const avg6=mean(scores.slice(-6));
   const avg9=mean(scores.slice(-9));
   const historicalScore=clamp(avg3*.45+avg6*.35+avg9*.20);
   const primaryScore=Number(current.primaryScore)||0;
   const decisionScore=clamp(primaryScore*.55+historicalScore*.45);
   const signal=finalSignal(decisionScore,Number(current.indicatorScore)||0,Number(current.vpaScore)||0);
   return {...current,primaryScore,historicalScore,decisionScore,signal};
  });

  const groups={"Strong Buy":[],"Buy":[],"Watch":[],"Avoid":[]};
  output.forEach(row=>(groups[row.signal]||groups.Avoid).push(row));
  const ranked=[];
  ["Strong Buy","Buy","Watch","Avoid"].forEach(signal=>{
   groups[signal].sort((a,b)=>(b.decisionScore-a.decisionScore)||(b.historicalScore-a.historicalScore)||(b.primaryScore-a.primaryScore)||(b.comparisonScore-a.comparisonScore)||String(a.code).localeCompare(String(b.code)));
   groups[signal].forEach((row,index)=>ranked.push({...row,signalRank:index+1}));
  });
  const rows=ranked.map((row,index)=>({...row,rank:index+1}));
  cache={signature,rows,dates:calculationDates};
  return {rows,dates:calculationDates,required:9,available:allDates.length};
 };

 const render=()=>{
  const tbody=document.getElementById("aitHistoricalPriorityRows");
  if(!tbody)return [];
  const result=calculate(),rows=result.rows||[];
  if(!rows.length){
   tbody.innerHTML=`<tr><td colspan="10">${result.available<9?`Historical scanning requires at least 9 trading dates. ${result.available||0} are currently available in local OHLC storage.`:"No eligible securities could be calculated from the downloaded OHLC data."}</td></tr>`;
   return [];
  }
  tbody.innerHTML=rows.map(row=>`<tr><td><strong>#${row.rank}</strong></td><td><strong>${esc(row.signal)} #${row.signalRank}</strong></td><td><strong>${esc(row.code)}</strong></td><td>${(Number(row.ltp)||0).toFixed(2)}</td><td><span class="v11-score">${(Number(row.indicatorScore)||0).toFixed(0)}</span></td><td><span class="v11-score">${(Number(row.vpaScore)||0).toFixed(0)}</span></td><td><span class="v11-score">${(Number(row.primaryScore)||0).toFixed(1)}</span></td><td><span class="v11-score">${(Number(row.historicalScore)||0).toFixed(1)}</span></td><td><span class="v11-score">${(Number(row.comparisonScore)||0).toFixed(1)}</span><small style="display:block">${esc(row.comparisonSignal||"Neutral")}</small></td><td><span class="v11-signal ${row.signal.toLowerCase().replace(/\s+/g,"-")}">${esc(row.signal)}</span></td></tr>`).join("");
  return rows;
 };

 const run=()=>{cache={signature:"",rows:[],dates:[]};return render()};
 document.getElementById("aitOpenHistoricalPriority")?.addEventListener("click",()=>{document.getElementById("aitPsaSignalPriorityEngineModal")?.setAttribute("hidden","");document.getElementById("aitHistoricalPriorityModal")?.removeAttribute("hidden");render()});
 document.getElementById("aitHistoricalPriorityRun")?.addEventListener("click",run);
 document.getElementById("aitHistoricalPriorityCharts3")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("historical",3));
 document.getElementById("aitHistoricalPriorityCharts6")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("historical",6));
 document.getElementById("aitHistoricalPriorityCharts12")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("historical",12));
 window.AitSignalPriorityHistory={calculate,render,run,clearCache:()=>{cache={signature:"",rows:[],dates:[]}}};
})();
</script>

<script id="ait-advanced-priority-script">
(()=>{"use strict";
 const clamp=n=>Math.max(0,Math.min(100,Number(n)||0));
 const esc=v=>String(v??"").replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#039;"}[c]));
 const mean=v=>v.length?v.reduce((a,b)=>a+(Number(b)||0),0)/v.length:0;
 const std=v=>{if(v.length<2)return 0;const m=mean(v);return Math.sqrt(mean(v.map(x=>(Number(x)-m)**2)))};
 const bridge=()=>window.AITScannerDataBridge||null;
 const history=()=>{try{return bridge()?.appState?.()?.history||{}}catch{return {}}};
 const scannerCodes=()=>bridge()?.scannerCodes?.()||bridge()?.codes?.()||[];
 const dates=()=>{const cutoff=window.__AIT_HISTORICAL_CUTOFF_DATE__||null,h=history();return [...new Set(scannerCodes().flatMap(code=>Array.isArray(h[code])?h[code].map(r=>String(r?.date||"")).filter(Boolean):[]))].filter(date=>!cutoff||date<=cutoff).sort()};
 const signalValue=s=>s==="Strong Buy"?100:s==="Buy"?76:s==="Watch"?48:18;
 const finalSignal=(score,t,v,c)=>score>=76&&t>=60&&v>=60&&c>=52?"Strong Buy":score>=63?"Buy":score>=49?"Watch":"Avoid";
 let cache={sig:"",rows:[],daily:[]};
 const dailyPriority=calcDates=>{const out=[],prev=window.__AIT_HISTORICAL_CUTOFF_DATE__;try{calcDates.forEach(date=>{window.__AIT_HISTORICAL_CUTOFF_DATE__=date;out.push({date,rows:(bridge()?.priorityDataset?.()||[]).map(r=>({...r}))})})}finally{if(prev)window.__AIT_HISTORICAL_CUTOFF_DATE__=prev;else delete window.__AIT_HISTORICAL_CUTOFF_DATE__}return out};
 const confirmationFor=(code,calcDates)=>{const rows=(history()[code]||[]).filter(r=>calcDates.includes(String(r?.date||""))).sort((a,b)=>String(a.date).localeCompare(String(b.date)));if(rows.length<Math.min(3,calcDates.length))return 35;const shortWindow=calcDates.length===2?1:3;const closes=rows.map(r=>Number(r.close)||0),vols=rows.map(r=>Number(r.volume)||0);const latest=closes.at(-1),avg3=mean(closes.slice(-shortWindow)),avg6=mean(closes.slice(-6));const ret=closes.length>1&&closes.at(-2)?((latest/closes.at(-2))-1)*100:0;const vol3=mean(vols.slice(-shortWindow)),vol6=mean(vols.slice(-6));let score=50;score+=latest>=avg3?12:-10;score+=avg3>=avg6?12:-10;score+=ret>0?Math.min(10,ret*3):Math.max(-10,ret*3);score+=vol6>0?Math.max(-10,Math.min(14,((vol3/vol6)-1)*25)):0;return clamp(score)};
 const calculate=(windowDays=9)=>{const all=dates();if(all.length<windowDays)return {rows:[],available:all.length,required:windowDays};const calcDates=all.slice(-windowDays),sig=`${windowDays}|${bridge()?.scannerHistorySignature?.()||scannerCodes().join('|')}|${calcDates.join('|')}`;if(cache.sig===sig&&cache.rows.length)return {rows:cache.rows,available:all.length,required:windowDays};const daily=dailyPriority(calcDates),latest=daily.at(-1);if(!latest?.rows?.length)return {rows:[],available:all.length,required:windowDays};const historicalRows=windowDays===9?(window.AitSignalPriorityHistory?.calculate?.()?.rows||[]):[],historicalByCode=new Map(historicalRows.map(row=>[String(row.code||"").toUpperCase(),row]));const out=latest.rows.map(current=>{const timeline=daily.map(d=>d.rows.find(r=>r.code===current.code)).filter(Boolean);const scores=timeline.map(r=>Number(r.primaryScore)||0);const hist=historicalByCode.get(String(current.code||"").toUpperCase())?.historicalScore??mean(scores);const diffs=scores.slice(1).map((v,i)=>v-scores[i]);const recent=mean(diffs.slice(-3)),older=mean(diffs.slice(0,Math.max(1,diffs.length-3)));const momentum=clamp(50+recent*7+(recent-older)*5);const stability=clamp(100-std(scores)*8);const persistence=clamp(mean(timeline.slice(-Math.min(6,windowDays)).map(r=>signalValue(r.signal)))+Math.min(12,timeline.slice().reverse().findIndex(r=>!["Strong Buy","Buy"].includes(r.signal))===-1?12:0));const confirmation=confirmationFor(current.code,calcDates);const primary=Number(current.primaryScore)||0;const advancedScore=clamp(primary*.25+Number(hist)*.20+momentum*.15+stability*.12+persistence*.13+confirmation*.15);const signal=finalSignal(advancedScore,Number(current.indicatorScore)||0,Number(current.vpaScore)||0,confirmation);return {...current,primaryScore:primary,historicalScore:Number(hist)||0,momentumScore:momentum,stabilityScore:stability,persistenceScore:persistence,confirmationScore:confirmation,advancedScore,signal}});const groups={"Strong Buy":[],"Buy":[],"Watch":[],"Avoid":[]};out.forEach(r=>(groups[r.signal]||groups.Avoid).push(r));const ranked=[];["Strong Buy","Buy","Watch","Avoid"].forEach(signal=>{groups[signal].sort((a,b)=>(b.advancedScore-a.advancedScore)||(b.confirmationScore-a.confirmationScore)||(b.historicalScore-a.historicalScore)||(b.primaryScore-a.primaryScore)||String(a.code).localeCompare(String(b.code)));groups[signal].forEach((r,i)=>ranked.push({...r,signalRank:i+1}))});const rows=ranked.map((r,i)=>({...r,rank:i+1}));cache={sig,rows,daily};return {rows,available:all.length,required:windowDays}};
 const render=()=>{const tbody=document.getElementById("aitAdvancedPriorityRows");if(!tbody)return[];const result=calculate(),rows=result.rows||[];if(!rows.length){tbody.innerHTML=`<tr><td colspan="14">${result.available<9?`Advanced scanning requires at least 9 trading dates. ${result.available||0} are currently available.`:"No eligible securities could be calculated."}</td></tr>`;return[]}tbody.innerHTML=rows.map(r=>`<tr><td><strong>#${r.rank}</strong></td><td><strong>${esc(r.signal)} #${r.signalRank}</strong></td><td><strong>${esc(r.code)}</strong></td><td>${(Number(r.ltp)||0).toFixed(2)}</td><td><span class="v11-score">${(Number(r.indicatorScore)||0).toFixed(0)}</span></td><td><span class="v11-score">${(Number(r.vpaScore)||0).toFixed(0)}</span></td><td><span class="v11-score">${(Number(r.primaryScore)||0).toFixed(1)}</span></td><td><span class="v11-score">${(Number(r.historicalScore)||0).toFixed(1)}</span></td><td><span class="v11-score">${(Number(r.momentumScore)||0).toFixed(1)}</span></td><td><span class="v11-score">${(Number(r.stabilityScore)||0).toFixed(1)}</span></td><td><span class="v11-score">${(Number(r.persistenceScore)||0).toFixed(1)}</span></td><td><span class="v11-score">${(Number(r.confirmationScore)||0).toFixed(1)}</span></td><td><span class="v11-score">${(Number(r.advancedScore)||0).toFixed(1)}</span></td><td><span class="v11-signal ${r.signal.toLowerCase().replace(/\s+/g,"-")}">${esc(r.signal)}</span></td></tr>`).join("");return rows};
 const run=()=>{cache={sig:"",rows:[],daily:[]};window.AitSignalPriorityHistory?.clearCache?.();return render()};
 document.getElementById("aitOpenAdvancedPriority")?.addEventListener("click",()=>{document.getElementById("aitPsaSignalPriorityEngineModal")?.setAttribute("hidden","");document.getElementById("aitAdvancedPriorityModal")?.removeAttribute("hidden");render()});
 document.getElementById("aitAdvancedPriorityRun")?.addEventListener("click",run);
 document.getElementById("aitAdvancedPriorityCharts3")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("advanced",3));
 document.getElementById("aitAdvancedPriorityCharts6")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("advanced",6));
 document.getElementById("aitAdvancedPriorityCharts12")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("advanced",12));
 window.AitAdvancedSignalPriority={calculate,render,run,clearCache:()=>{cache={sig:"",rows:[],daily:[]}}};
})();
</script>


<script id="ait-elite-regime-script">
(()=>{"use strict";
 const esc=v=>String(v??"").replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#039;"}[c]));
 const clamp=(n,a=0,b=100)=>Math.max(a,Math.min(b,Number(n)||0));
 const mean=a=>a.length?a.reduce((x,y)=>x+y,0)/a.length:null;
 const median=a=>{if(!a.length)return null;const x=[...a].sort((a,b)=>a-b),m=Math.floor(x.length/2);return x.length%2?x[m]:(x[m-1]+x[m])/2};
 const pct=(n,d=2)=>Number.isFinite(Number(n))?`${Number(n).toFixed(d)}%`:"—";
 const bridge=()=>window.AITScannerDataBridge||null;
 const state=()=>{try{return bridge()?.appState?.()||{history:{}}}catch{return {history:{}}}};
 const history=()=>state().history||{};
 const codes=()=>bridge()?.scannerCodes?.()||bridge()?.codes?.()||[];
 const rowsFor=(code,cutoff=null)=>{const r=Array.isArray(history()[code])?history()[code]:[];return (cutoff?r.filter(x=>String(x?.date||"")<=cutoff):r).sort((a,b)=>String(a.date).localeCompare(String(b.date)))};
 const dates=()=>[...new Set(codes().flatMap(c=>rowsFor(c).map(r=>String(r?.date||"")).filter(Boolean)))].sort();
 const closeAt=(code,date)=>{const r=rowsFor(code).find(x=>String(x.date)===date);return Number.isFinite(Number(r?.close))?Number(r.close):null};
 const prevClose=(code,date)=>{const r=rowsFor(code).filter(x=>String(x.date)<date).at(-1);return Number.isFinite(Number(r?.close))?Number(r.close):null};
 const marketStats=(date)=>{const vals=codes().map(c=>{const c0=closeAt(c,date),p=prevClose(c,date);return c0!=null&&p>0?(c0/p-1)*100:null}).filter(Number.isFinite);const ret=mean(vals);const breadth=vals.length?vals.filter(x=>x>0).length/vals.length*100:0;return {ret,breadth,n:vals.length}};
 const classify=(date)=>{const d=dates().filter(x=>x<=date), recent=d.slice(-20), prev=d.at(-2);const now=marketStats(date), prior=prev?marketStats(prev):{ret:0,breadth:50};const series=recent.map(x=>marketStats(x).ret).filter(Number.isFinite);const momentum=mean(series)||0;let label="Sideways";if(now.breadth>=62&&momentum>=0.15&&now.ret>=0)label="Bull";else if(now.breadth<=38&&momentum<=-0.15&&now.ret<=0)label="Bear";const confidence=clamp(50+Math.abs(now.breadth-50)*0.9+Math.abs(momentum)*8,0,100);return {...now,previousReturn:prior.ret,momentum,label,confidence}};
 const snapshotRows=(date)=>{const prev=window.__AIT_HISTORICAL_CUTOFF_DATE__;try{window.__AIT_HISTORICAL_CUTOFF_DATE__=date;return bridge()?.priorityDataset?.()||[]}finally{if(prev)window.__AIT_HISTORICAL_CUTOFF_DATE__=prev;else delete window.__AIT_HISTORICAL_CUTOFF_DATE__}};
 const latestRegime=()=>{const d=dates().at(-1);return d?{date:d,...classify(d)}:null};
 const regimeAdjustment=(regime,score,signal)=>{let adj=0;if(regime.label==="Bull")adj=signal==="Strong Buy"?4:2;if(regime.label==="Sideways")adj=signal==="Strong Buy"?0:-1;if(regime.label==="Bear")adj=signal==="Strong Buy"?-7:signal==="Buy"?-5:-2;const regimeScore=clamp(score+adj);let fit="Neutral";if(regime.label==="Bull"&&score>=70)fit="Supportive";else if(regime.label==="Bear"&&score>=75)fit="Defensive";else if(regime.label==="Bear")fit="Adverse";else if(regime.label==="Sideways"&&score>=70)fit="Selective";return {regimeScore,fit}};
 const regimeWhen=action=>{if(action==="BUY NOW")return "Now";if(action==="CONFIRMATION")return "Wait for confirmation";if(action==="WATCH")return "Monitor / wait";if(action==="AVOID")return "Do not enter";return "Review"};
 const regimeDecision=({regimeScore,signal,fit})=>{const score=Number(regimeScore)||0;if(signal==="Avoid")return {action:"AVOID",tone:"avoid",why:"Underlying Elite signal is Avoid."};if(score>=80&&signal==="Strong Buy"&&fit!=="Adverse")return {action:"BUY NOW",tone:"buy",why:"Strong Elite setup with sufficient regime support."};if(score>=70&&["Strong Buy","Buy"].includes(signal))return {action:"CONFIRMATION",tone:"wait",why:`Good ${signal} setup, but current regime requires confirmation before entry.`};if(fit==="Adverse"||score<50)return {action:"AVOID",tone:"avoid",why:"Regime context and score do not provide enough support for a new entry."};return {action:"WATCH",tone:"caution",why:"Keep under observation until score or confirmation improves."}};
 const regimePriority=(action,rank)=>({label:action==="BUY NOW"?"HIGH":action==="CONFIRMATION"?"MEDIUM":action==="WATCH"?"LOW":"AVOID",rank});
 const decisionToneClass=t=>t==="buy"?"ait-elite-decision--buy":t==="wait"?"ait-elite-decision--wait":t==="avoid"?"ait-elite-decision--avoid":"ait-elite-decision--caution";
 const regimeScoreBand=v=>{const n=Number(v)||0;return n>=80?"Strong":n>=70?"Good":n>=55?"Mixed":"Weak"};
 const showRegimeDetails=code=>{
  const row=(window.AitEliteRegimeState?.rows||[]).find(x=>String(x.code)===String(code));
  if(!row)return;
  const d=row.decision||regimeDecision({regimeScore:row.regimeScore,signal:row.signal,fit:row.fit});
  const title=document.getElementById("aitEliteRegimeDetailTitle"),body=document.getElementById("aitEliteRegimeDetailBody");
  const group=(titleText,subtitle,items,cls="")=>`<section class="ait-elite-detail-group ${cls}"><div class="ait-elite-detail-group-head"><div><h3>${esc(titleText)}</h3><p>${esc(subtitle)}</p></div></div><div class="ait-fundamental-strip">${items.join("")}</div></section>`;
  const item=(label,value,note="")=>`<div class="ait-fundamental-item"><small>${esc(label)}</small><b>${esc(value)}</b>${note?`<em>${esc(note)}</em>`:""}</div>`;
  if(title)title.textContent=`${row.code} — ${d.action}`;
  if(body)body.innerHTML=`
   ${group("1. What should I do?","This is the final regime-aware decision shown in the scanner row.",[
    item("FINAL DECISION",d.action,d.why),
    item("Priority",`${row.priority?.label||"—"} #${row.rank}`,`Overall #${row.rank}`),
    item("When",regimeWhen(d.action),row.fit||"Neutral"),
    item("Setup Signal",`${row.signal||"Avoid"}`,`Elite Score ${Number(row.eliteScore??row.primaryScore??0).toFixed(1)}`),
    item("Regime",`${row.regime?.label||row.regime||"—"}`,`Confidence ${row.regime?.confidence!=null?Number(row.regime.confidence).toFixed(0)+"%":"—"}`),
    item("Regime Score",Number(row.regimeScore??0).toFixed(1),regimeScoreBand(row.regimeScore)),
    item("Regime Fit",row.fit||"Neutral"),
    item("Why",d.why)
   ],`ait-elite-detail-group--decision ${decisionToneClass(d.tone)}`)}
   ${group("2. Market Regime Evidence","Current regime context used to adjust Elite conviction.",[
    item("Market Regime",row.regime?.label||row.regime||"—"),
    item("Confidence",row.regime?.confidence!=null?`${Number(row.regime.confidence).toFixed(0)}%`:"—"),
    item("Market Return",row.regime?.ret!=null?pct(row.regime.ret):"—","Recent equal-weight universe"),
    item("Market Breadth",row.regime?.breadth!=null?`${Number(row.regime.breadth).toFixed(0)}%`:"—","Stocks above short trend"),
    item("Momentum",row.regime?.momentum!=null?Number(row.regime.momentum).toFixed(2):"—"),
    item("Regime Adjustment",Number(row.regimeScore??0)-Number(row.eliteScore??row.primaryScore??0)>=0?`+${(Number(row.regimeScore??0)-Number(row.eliteScore??row.primaryScore??0)).toFixed(1)}`:(Number(row.regimeScore??0)-Number(row.eliteScore??row.primaryScore??0)).toFixed(1))
   ])}
   ${group("3. AIT Elite Foundation","The underlying Elite signal remains the primary evidence; regime context does not replace it.",[
    item("Elite Score",Number(row.eliteScore??row.primaryScore??0).toFixed(1),regimeScoreBand(row.eliteScore??row.primaryScore)),
    item("Technical",Number(row.indicatorScore??row.technicalScore??0).toFixed(0)),
    item("Smart Money",Number(row.vpaScore??row.smartMoneyScore??0).toFixed(0)),
    item("Primary Score",Number(row.primaryScore??0).toFixed(1)),
    item("Advanced Score",Number(row.advancedScore??row.rankingScore??0).toFixed(1)),
    item("LTP",Number(row.ltp??0).toFixed(2))
   ])}
   ${group("4. Entry & Risk","Use these values with the action gate before entering.",[
    item("Entry State",row.entryState||"Review"),
    item("Entry Quality",Number(row.entryQualityScore??0).toFixed(1),regimeScoreBand(row.entryQualityScore)),
    item("Breakout",Number(row.breakoutScore??0).toFixed(1),regimeScoreBand(row.breakoutScore)),
    item("Support",Number(row.supportScore??0).toFixed(1),regimeScoreBand(row.supportScore)),
    item("Liquidity",Number(row.liquidityScore??0).toFixed(1),regimeScoreBand(row.liquidityScore)),
    item("Volatility Safety",Number(row.volatilitySafetyScore??0).toFixed(1),regimeScoreBand(row.volatilitySafetyScore))
   ])}
   ${group("5. Ranking & Action Logic","Regime ranking preserves the Elite evidence and applies a regime compatibility layer.",[
    item("Overall Rank",`#${row.rank}`),
    item("Signal Rank",row.signalRank?`${row.signal} #${row.signalRank}`:row.signal||"—"),
    item("Regime Priority",row.priority?.label||"—"),
    item("Final Action",d.action),
    item("Confirmation Rule",d.action==="CONFIRMATION"?"Wait for price / volume / regime confirmation before entry":"No extra regime confirmation gate is currently required"),
    item("Risk Note",row.regime?.label==="Bear"?"Higher downside sensitivity":row.regime?.label==="Sideways"?"Selective entries":"Trend supportive")
   ])}`;
  document.getElementById("aitEliteRegimeModal")?.setAttribute("hidden","");
  document.getElementById("aitEliteRegimeDetailModal")?.removeAttribute("hidden");
 };
 const run=()=>{const regime=latestRegime(),tbody=document.getElementById("aitEliteRegimeRows");if(!tbody||!regime)return [];const eliteBase=(()=>{try{const rows=window.AitEliteSignalPriority?.calculate?.(9)?.rows||[];if(rows.length)return rows;}catch(e){console.error("AIT Elite Regime:",e)}return (bridge()?.priorityDataset?.()||[]).map(x=>({...x,eliteScore:Number(x.eliteScore??x.primaryScore??0),finalSignal:x.finalSignal||x.signal||"Avoid"}))})();const base=eliteBase;const rows=base.map(x=>{const score=Number(x.eliteScore??x.primaryScore??0),signal=String(x.finalSignal||x.signal||"Avoid"),a=regimeAdjustment(regime,score,signal),decision=regimeDecision({...a,signal});return {...x,...a,signal,action:decision.action,decision,regime}}).sort((a,b)=>{const order={"BUY NOW":1,"CONFIRMATION":2,"WATCH":3,"AVOID":4};return (order[a.action]-order[b.action])||(b.regimeScore-a.regimeScore)||(b.eliteScore-a.eliteScore)||String(a.code).localeCompare(String(b.code))}).map((x,i)=>({...x,rank:i+1,signalRank:x.signalRank||null,priority:regimePriority(x.action,i+1)})); window.AitEliteRegimeState={rows,regime};document.getElementById("aitEliteRegimeLabel")?.replaceChildren(document.createTextNode(regime.label));document.getElementById("aitEliteRegimeConfidence")?.replaceChildren(document.createTextNode(`${regime.confidence.toFixed(0)}%`));document.getElementById("aitEliteRegimeReturn")?.replaceChildren(document.createTextNode(pct(regime.ret)));document.getElementById("aitEliteRegimeBreadth")?.replaceChildren(document.createTextNode(`${regime.breadth.toFixed(0)}%`));document.getElementById("aitEliteRegimeState")?.replaceChildren(document.createTextNode(`${regime.label} • ${regime.confidence.toFixed(0)}%`));tbody.innerHTML=rows.length?rows.map(x=>{const d=x.decision||regimeDecision({regimeScore:x.regimeScore,signal:x.signal,fit:x.fit});return `<tr><td class="ait-elite-decision-cell ${decisionToneClass(d.tone)}"><strong>${esc(x.priority.label)} #${x.rank}</strong><small style="display:block">Overall #${x.rank}</small></td><td><strong>${esc(x.code)}</strong></td><td>${Number.isFinite(Number(x.ltp))?Number(x.ltp).toFixed(2):"—"}</td><td class="ait-elite-decision-cell ${decisionToneClass(d.tone)}"><strong>${esc(d.action)}</strong><small>${esc(d.why)}</small></td><td><strong>${esc(regimeWhen(d.action))}</strong><small style="display:block">${esc(x.fit)}</small></td><td><span class="v11-signal ${String(x.signal||"watch").toLowerCase().replace(/\s+/g,"-")}">${esc(x.signal)}</span><small style="display:block">Elite ${Number(x.eliteScore??x.primaryScore??0).toFixed(1)}</small></td><td><span class="v11-status-chip">${esc(regime.label)}</span><small style="display:block">${esc(x.fit)}</small></td><td><strong>${x.regimeScore.toFixed(1)}</strong><small style="display:block">Elite ${Number(x.eliteScore??x.primaryScore??0).toFixed(1)}</small></td><td class="ait-elite-why-cell">${esc(d.why)}</td><td><button class="btn soft ait-elite-regime-details" data-code="${esc(x.code)}" type="button">View Details</button></td></tr>`}).join(""):"<tr><td colspan=10>No Elite data available.</td></tr>";tbody.querySelectorAll(".ait-elite-regime-details").forEach(btn=>btn.addEventListener("click",()=>showRegimeDetails(btn.dataset.code)));return rows};
 const evaluate=async()=>{
  // Always force the original AIT Elite chronological replay first. The Regime
  // monitor must never depend on a previously rendered scanner or stale cache.
  // This keeps signal construction, forward returns and benchmark/excess math
  // identical to AIT Elite v4.4 while adding only regime classification here.
  try{
   let all=[];
   if(typeof window.AitElitePerformance?.rebuild==='function'){
    all=await window.AitElitePerformance.rebuild();
   }
   if(!Array.isArray(all)||!all.length){
    all=await window.AitElitePerformance?.evaluate?.();
   }
   if(Array.isArray(all)){
    const mapped=all.map(r=>{
     const date=String(r?.date||"").slice(0,10);
     const regime=classify(date);
     const ret=Number(r?.returns?.[9]);
     const excess=Number(r?.excess?.[9]);
     return {
      date,
      regime:regime.label,
      signal:String(r?.finalSignal||r?.signal||"Avoid"),
      eliteScore:Number(r?.eliteScore??r?.rankingScore??r?.advancedScore??r?.primaryScore??r?.rankingScore??0),
      ret:Number.isFinite(ret)?ret:null,
      excess:Number.isFinite(excess)?excess:null
     };
    }).filter(r=>r.date&&r.regime&&Number.isFinite(r.ret)&&Number.isFinite(r.excess));
    return mapped;
   }
  }catch(error){
   console.error("AIT Elite Regime performance replay:",error);
  }
  return [];
 };
 const renderMonitor=async()=>{
  // Reuse AIT Elite's incremental/cached performance pipeline. Do NOT force a full
  // historical rebuild when the user opens Performance; that can block the UI on
  // large OHLC datasets. ensureCurrent() rebuilds only when the downloaded history
  // signature changed, then evaluate() reuses the in-memory/local cache.
  try{await window.AitElitePerformance?.ensureCurrent?.()}catch(error){console.error("AIT Elite Regime performance prepare:",error)}
  const rows=await evaluate(),body=document.getElementById("aitEliteRegimePerformanceRows"),sigBody=document.getElementById("aitEliteRegimeSignalRows");if(!rows.length){if(body)body.innerHTML="<tr><td colspan=9>No evaluated Elite history is available. The monitor could not find 9D forward returns from the AIT Elite historical replay.</td></tr>";if(sigBody)sigBody.innerHTML="<tr><td colspan=8>No regime signal diagnostics are available until historical replay produces evaluable 9D outcomes.</td></tr>";document.getElementById("aitEliteRegimePerfDates")?.replaceChildren(document.createTextNode("0"));document.getElementById("aitEliteRegimePerfBest")?.replaceChildren(document.createTextNode("—"));document.getElementById("aitEliteRegimePerfExcess")?.replaceChildren(document.createTextNode("—"));document.getElementById("aitEliteRegimePerfStable")?.replaceChildren(document.createTextNode("0"));return rows;}const groups=["Bull","Sideways","Bear"].map(reg=>{const r=rows.filter(x=>x.regime===reg),sb=r.filter(x=>x.signal==="Strong Buy");return {reg,n:r.length,dates:new Set(r.map(x=>x.date)).size,sb:sb.length,raw:mean(sb.map(x=>x.ret)),ex:mean(sb.map(x=>x.excess)),win:sb.length?sb.filter(x=>x.excess>0).length/sb.length*100:null,score:mean(r.map(x=>x.eliteScore))}});body.innerHTML=groups.map(g=>{const evidence=g.dates>=30&&g.n>=500&&g.ex!=null;const moderate=g.dates>=15&&g.n>=250&&g.ex!=null;const label=evidence&&g.ex>0?"SUPPORTIVE":moderate&&g.ex>0?"SELECTIVE":g.dates<15?"CAUTION · LOW DATE SAMPLE":"DEFENSIVE";return `<tr><td><strong>${g.reg}</strong></td><td>${g.dates}</td><td>${g.n}</td><td>${g.sb}</td><td>${pct(g.raw)}</td><td>${pct(g.ex)}</td><td>${pct(g.win,1)}</td><td>${g.score==null?"—":g.score.toFixed(1)}</td><td><strong>${label}</strong></td></tr>`;}).join("");const signalRows=[];for(const reg of ["Bull","Sideways","Bear"])for(const sig of ["Strong Buy","Buy","Watch","Avoid"]){const r=rows.filter(x=>x.regime===reg&&x.signal===sig);signalRows.push({reg,sig,n:r.length,raw:mean(r.map(x=>x.ret)),ex:mean(r.map(x=>x.excess)),win:r.length?r.filter(x=>x.excess>0).length/r.length*100:null,med:median(r.map(x=>x.excess)),risk:reg==="Bear"?"Higher downside sensitivity":reg==="Sideways"?"Selective entries":"Trend supportive"})}sigBody.innerHTML=signalRows.map(g=>`<tr><td>${g.reg}</td><td><strong>${g.sig}</strong></td><td>${g.n}</td><td>${pct(g.raw)}</td><td>${pct(g.ex)}</td><td>${pct(g.win,1)}</td><td>${pct(g.med)}</td><td>${g.risk}</td></tr>`).join("");const valid=groups.filter(g=>g.dates>=30&&g.n>=500&&g.ex!=null),best=valid.sort((a,b)=>(b.ex??-Infinity)-(a.ex??-Infinity))[0];document.getElementById("aitEliteRegimePerfDates")?.replaceChildren(document.createTextNode(String(new Set(rows.map(x=>x.date)).size)));document.getElementById("aitEliteRegimePerfBest")?.replaceChildren(document.createTextNode(best?.reg||"—"));document.getElementById("aitEliteRegimePerfExcess")?.replaceChildren(document.createTextNode(pct(best?.ex)));document.getElementById("aitEliteRegimePerfStable")?.replaceChildren(document.createTextNode(String(valid.filter(g=>g.ex>0).length)));return rows};
 document.getElementById("v11RunEliteRegime")?.addEventListener("click",()=>{const fn=async()=>{try{await window.AitElitePerformance?.ensureCurrent?.()}catch(_){}return run()};return window.AITEliteBusy?.execute?.({kicker:"AIT ELITE REGIME",title:"Calculating regime-aware signals",text:"Detecting market regime and adapting calibrated Elite conviction…"},fn)||fn()});
 document.getElementById("aitEliteRegimeCharts3")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("elite-regime",3));
 document.getElementById("aitEliteRegimeCharts6")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("elite-regime",6));
 document.getElementById("aitEliteRegimeCharts12")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("elite-regime",12));
 document.querySelectorAll('[data-ait-psa-open="aitEliteRegimePerformanceModal"]').forEach(b=>b.addEventListener("click",()=>{setTimeout(()=>{window.AITEliteBusy?.execute?.({kicker:"AIT ELITE REGIME PERFORMANCE",title:"Reconstructing regime performance",text:"Replaying the original AIT Elite history and classifying each evaluated date by market regime…"},renderMonitor)},80)}));
 const renderModal=()=>{const regime=latestRegime(),tbody=document.getElementById("aitEliteRegimeModalRows");if(!tbody||!regime){if(tbody)tbody.innerHTML="<tr><td colspan=9>No historical OHLC data is available. Download market data first.</td></tr>";return [];}const base=window.AitEliteSignalPriority?.calculate?.(9)?.rows||[];const rows=base.map(x=>{const score=Number(x.eliteScore??x.primaryScore??x.advancedScore??0),signal=x.signal||x.finalSignal||"Avoid",a=regimeAdjustment(regime,score,signal),decision=regimeDecision({...a,signal});return {...x,eliteScore:score,signal,...a,action:decision.action,decision,regime}}).sort((a,b)=>(b.regimeScore-a.regimeScore)||(b.eliteScore-a.eliteScore)||String(a.code).localeCompare(String(b.code))).map((x,i)=>({...x,rank:i+1,priority:regimePriority(x.action,i+1)})); window.AitEliteRegimeState={rows,regime};document.getElementById("aitEliteRegimeModalLabel")?.replaceChildren(document.createTextNode(regime.label));document.getElementById("aitEliteRegimeModalConfidence")?.replaceChildren(document.createTextNode(`${regime.confidence.toFixed(0)}%`));document.getElementById("aitEliteRegimeModalReturn")?.replaceChildren(document.createTextNode(pct(regime.ret)));document.getElementById("aitEliteRegimeModalBreadth")?.replaceChildren(document.createTextNode(`${regime.breadth.toFixed(0)}%`));document.getElementById("aitEliteRegimeModalState")?.replaceChildren(document.createTextNode(`${regime.label} • ${regime.confidence.toFixed(0)}%`));tbody.innerHTML=rows.length?rows.map(x=>{const d=regimeDecision({regimeScore:x.regimeScore,signal:x.signal,fit:x.fit});const priority=regimePriority(d.action,x.rank||0);return `<tr><td class="ait-elite-decision-cell ${decisionToneClass(d.tone)}"><strong>${esc(priority.label)} #${x.rank}</strong><small style="display:block">Overall #${x.rank}</small></td><td><strong>${esc(x.code)}</strong></td><td>${Number.isFinite(Number(x.ltp))?Number(x.ltp).toFixed(2):"—"}</td><td class="ait-elite-decision-cell ${decisionToneClass(d.tone)}"><strong>${esc(d.action)}</strong><small>${esc(d.why)}</small></td><td><strong>${esc(regimeWhen(d.action))}</strong><small style="display:block">${esc(x.fit)}</small></td><td><span class="v11-signal ${String(x.signal||"watch").toLowerCase().replace(/\s+/g,"-")}">${esc(x.signal)}</span><small style="display:block">Elite ${Number(x.eliteScore).toFixed(1)}</small></td><td><span class="v11-status-chip">${esc(regime.label)}</span><small style="display:block">${esc(x.fit)}</small></td><td><strong>${x.regimeScore.toFixed(1)}</strong><small style="display:block">Elite ${Number(x.eliteScore).toFixed(1)}</small></td><td class="ait-elite-why-cell">${esc(d.why)}</td><td><button class="btn soft ait-elite-regime-details" data-code="${esc(x.code)}" type="button">View Details</button></td></tr>`}).join(""):"<tr><td colspan=10>No eligible securities could be calculated. Ensure DSE OHLC data is downloaded and at least 9 trading dates are available.</td></tr>";tbody.querySelectorAll(".ait-elite-regime-details").forEach(btn=>btn.addEventListener("click",()=>showRegimeDetails(btn.dataset.code)));return rows};
 document.getElementById("aitEliteRegimeModalRun")?.addEventListener("click",()=>{const fn=async()=>{try{await window.AitElitePerformance?.ensureCurrent?.()}catch(_){}return renderModal()};return window.AITEliteBusy?.execute?.({kicker:"AIT ELITE REGIME",title:"Scanning regime-aware signals",text:"Detecting market regime and ranking the calibrated Elite universe…"},fn)||fn()});
 document.getElementById("aitEliteRegimeModalCharts3")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("elite-regime",3));
 document.getElementById("aitEliteRegimeModalCharts6")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("elite-regime",6));
 document.getElementById("aitEliteRegimeModalCharts12")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("elite-regime",12));
 document.getElementById("aitEliteRegimeModalPerformance")?.setAttribute("data-ait-psa-open","aitEliteRegimePerformanceModal");
 document.getElementById("aitEliteRegimeCharts")?.addEventListener("click",()=>document.getElementById("viewListCharts")?.click());
 document.getElementById("aitEliteRegimeModalCharts")?.addEventListener("click",()=>document.getElementById("viewListCharts")?.click());
 window.AITEliteRegime={run:()=>{const rows=run();renderModal();return rows},evaluate:renderMonitor,currentRegime:latestRegime,regimeForDate:classify,render:renderModal,adjust:regimeAdjustment,decide:regimeDecision};
})();
</script>
<script id="ait-elite-calculation-cursor-script">
(()=>{"use strict";
 const layer=()=>document.getElementById("aitEliteCalculationLayer");
 const setText=(id,value)=>{const el=document.getElementById(id);if(el&&value)el.textContent=value};
 let depth=0;
 const show=(options={})=>{
  depth++;
  setText("aitEliteCalculationKicker",options.kicker||"AIT ELITE ENGINE V3");
  setText("aitEliteCalculationTitle",options.title||"Calculating Elite signals");
  setText("aitEliteCalculationText",options.text||"Analyzing ranking, confirmation, risk and decision evidence…");
  layer()?.classList.add("is-active");
  layer()?.setAttribute("aria-hidden","false");
  document.body.classList.add("ait-elite-is-calculating");
 };
 const hide=()=>{
  depth=Math.max(0,depth-1);
  if(depth>0)return;
  layer()?.classList.remove("is-active");
  layer()?.setAttribute("aria-hidden","true");
  document.body.classList.remove("ait-elite-is-calculating");
 };
 const nextPaint=()=>new Promise(resolve=>requestAnimationFrame(()=>requestAnimationFrame(resolve)));
 const execute=async(options,task)=>{
  show(options);
  try{await nextPaint();return await task()}finally{hide()}
 };
 const update=(options={})=>{setText("aitEliteCalculationKicker",options.kicker);setText("aitEliteCalculationTitle",options.title);setText("aitEliteCalculationText",options.text)};
 window.AITEliteBusy={show,hide,update,execute,nextPaint,isActive:()=>depth>0};
})();
</script>
<script id="ait-elite-priority-script">
(()=>{"use strict";
 const clamp=n=>Math.max(0,Math.min(100,Number(n)||0));
 const esc=v=>String(v??"").replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#039;"}[c]));
 const mean=v=>v.length?v.reduce((a,b)=>a+(Number(b)||0),0)/v.length:0;
 const bridge=()=>window.AITScannerDataBridge||null;
 const history=()=>{try{return bridge()?.appState?.()?.history||{}}catch{return {}}};
 const rowsFor=code=>{try{return bridge()?.rowsFor?.(code)||history()[code]||[]}catch{return history()[code]||[]}};
 const signal=(score,liquidity,safety,entry)=>score>=72&&liquidity>=35&&safety>=35&&entry>=60?"Strong Buy":score>=60&&liquidity>=30&&safety>=30&&entry>=52?"Buy":score>=46?"Watch":"Avoid";
 const calibratedPriority=(r,rank,total)=>{
  const pct=total>0?(rank/total)*100:100;
  const liquidity=Number(r.liquidityScore)||0,safety=Number(r.volatilitySafetyScore)||0,entry=Number(r.entryQualityScore)||0;
  const advanced=Number(r.advancedScore)||0,historical=Number(r.historicalScore)||0,confirmation=Number(r.confirmationScore)||0;
  const technical=Number(r.indicatorScore)||0,smartMoney=Number(r.vpaScore)||0;
  const coreGate=liquidity>=30&&safety>=30,qualityGate=advanced>=50&&historical>=45&&confirmation>=48&&technical>=50&&smartMoney>=50;
  let priority="Watch";
  if(pct<=15&&coreGate&&qualityGate&&entry>=60)priority="Elite Priority";
  else if(pct<=25&&coreGate&&qualityGate&&entry>=54)priority="High Priority";
  else if(pct<=40&&coreGate&&advanced>=48&&historical>=42&&entry>=50)priority="Candidate";
  else if(pct>=75||!coreGate)priority="Avoid";
  return {rankPercentile:pct,calibratedPriority:priority};
 };
 const finalRankSignal=(r)=>{
  // Frozen v4.4 rule. Top 8% was selected on development + validation only,
  // then passed the untouched final 20% holdout. Tradeability is evaluated
  // separately by entryState, shortTermSignal and the model safety gate.
  const pct=Number(r.rankingPercentile)||100;
  if(pct<=8)return "Strong Buy";
  if(pct<=20)return "Buy";
  if(pct<=80)return "Watch";
  return "Avoid";
 };
 const MODEL_STATE_KEY="ait-psa-elite-model-state-v8";
 const portfolioPositions=()=>{try{const v=JSON.parse(localStorage.getItem("ababil-dse-v11-portfolio")||"[]");return Array.isArray(v)?v:[]}catch{return[]}};
 const isHeld=code=>portfolioPositions().some(p=>String(p?.code||"").toUpperCase()===String(code||"").toUpperCase()&&Number(p?.qty||0)>0);
 const storedModelStateRecord=()=>{try{const v=JSON.parse(localStorage.getItem(MODEL_STATE_KEY)||"null");return v&&typeof v==="object"?v:null}catch{return null}};
 const storedModelState=()=>String(storedModelStateRecord()?.overall||"Unverified");
 const storedStrongBuyTrust=()=>String(storedModelStateRecord()?.strongBuyTrust||"Unverified");
 const storedDecisionGate=()=>String(storedModelStateRecord()?.decisionGate||"LOCKED");
 const shortTermSignal=r=>{
  const b=Number(r.breakoutScore)||0,e=Number(r.entryQualityScore)||0,l=Number(r.liquidityScore)||0,v=Number(r.volatilitySafetyScore)||0,t=Number(r.indicatorScore)||0,m=Number(r.vpaScore)||0,c=Number(r.confirmationScore)||0;
  if(l<25||v<25)return "Avoid";
  if(b>=55&&b<=82&&e>=68&&l>=38&&v>=38&&t>=60&&m>=60&&c>=58)return "Strong Buy";
  if(b>=48&&e>=57&&l>=32&&v>=32&&t>=52&&m>=52&&c>=50)return "Buy";
  return "Watch";
 };
 const midTermSignal=r=>{
  const h=Number(r.historicalScore)||0,a=Number(r.advancedScore)||0,su=Number(r.supportScore)||0,fs=String(r.finalSignal||"Avoid");
  if(fs==="Strong Buy"&&h>=60&&a>=60&&su>=45)return "Strong Buy";
  if(["Strong Buy","Buy"].includes(fs)&&h>=50&&a>=50)return "Buy";
  if(fs==="Avoid")return "Avoid";
  return "Watch";
 };
 const entryState=r=>{
  const fs=String(r.finalSignal||"Avoid"),b=Number(r.breakoutScore)||0,e=Number(r.entryQualityScore)||0,su=Number(r.supportScore)||0,c=Number(r.confirmationScore)||0;
  if(fs==="Avoid")return "Invalid / Avoid";
  if(["Strong Buy","Buy"].includes(fs)&&b>=45&&b<=72&&e>=68&&su>=45&&c>=58)return "Ready";
  if(["Strong Buy","Buy"].includes(fs)&&(e<58||b>72)&&su>=48)return "Pullback Preferred";
  if(["Strong Buy","Buy"].includes(fs))return "Await Confirmation";
  return "No Entry";
 };
 const tradeAction=r=>{
  const held=isHeld(r.code),state=String(r.modelState||"Unverified"),fs=String(r.finalSignal||"Avoid"),entry=String(r.entryState||"No Entry"),st=String(r.shortTerm||"Watch"),mt=String(r.midTerm||"Watch");
  if(held){
   if(fs==="Avoid"||st==="Avoid")return "Exit";
   if(state==="Recalibration Required"||state==="Degraded")return fs==="Strong Buy"?"Hold / Tight Risk":"Reduce";
   if(fs==="Watch"&&mt==="Watch")return "Hold / Review";
   return "Hold";
  }
  if(state==="Recalibration Required")return "Suspend New Buy";
  if(fs==="Avoid"||st==="Avoid")return "Avoid";
  if(state==="Degraded")return "Watch";
  if(entry==="Pullback Preferred")return "Buy on Pullback";
  if(entry==="Await Confirmation")return "Buy on Confirmation";
  if(entry==="Ready"&&fs==="Strong Buy"&&st==="Strong Buy"&&mt==="Strong Buy"&&state==="Healthy")return "Buy Now";
  if(entry==="Ready"&&fs==="Strong Buy"&&state==="Healthy"&&storedDecisionGate()==="OPEN"&&storedStrongBuyTrust()==="Trusted"&&["Strong Buy","Buy"].includes(st)&&["Strong Buy","Buy"].includes(mt))return "Buy Now";
  if(entry==="Ready"&&["Strong Buy","Buy"].includes(fs))return "Buy on Confirmation";
  return "Watch";
 };
 const decisionLayer=(r,windowDays=9)=>{
  const modelState=windowDays===9?storedModelState():"Unverified",shortTerm=shortTermSignal(r),midTerm=midTermSignal(r),longTerm="Not Validated",entryStateValue=entryState(r);
  const merged={...r,modelState,shortTerm,midTerm,longTerm,entryState:entryStateValue};
  return {...merged,tradeAction:tradeAction(merged)};
 };
 let cache={sig:"",rows:[]};
 const metrics=(code,windowDays=9)=>{
  const rows=rowsFor(code).filter(r=>Number.isFinite(Number(r?.close))&&Number(r?.close)>0).slice(windowDays===9?-80:-windowDays);
  if(rows.length<windowDays)return {liquidity:0,safety:0,breakout:0,support:0,entry:0};
  const closes=rows.map(r=>Number(r.close)||0), highs=rows.map(r=>Number(r.high)||Number(r.close)||0), lows=rows.map(r=>Number(r.low)||Number(r.close)||0), vols=rows.map(r=>Number(r.volume)||0);
  const latest=closes.at(-1), avgVol20=mean(vols.slice(-20)), avgVol5=mean(vols.slice(-5));
  const liquidity=clamp(25+Math.log10(Math.max(1,avgVol20))*11+(avgVol20>0?Math.min(18,(avgVol5/avgVol20)*9):0));
  const returns=closes.slice(1).map((v,i)=>closes[i]?((v/closes[i])-1)*100:0);
  const volStd=Math.sqrt(mean(returns.map(x=>(x-mean(returns))**2)));
  const safety=clamp(100-volStd*18);
  const priorHigh=Math.max(...highs.slice(-21,-1));
  const avg20=mean(closes.slice(-20)), avg9=mean(closes.slice(-9));
  const breakout=clamp(50+(priorHigh>0?((latest/priorHigh)-1)*180:0)+(avgVol20>0?((avgVol5/avgVol20)-1)*18:0)+(latest>=avg9?8:-8));
  const recentLow=Math.min(...lows.slice(-20));
  const supportDistance=latest>0?((latest-recentLow)/latest)*100:100;
  const support=clamp(88-supportDistance*5+(latest>=avg20?10:-8));
  const extension=avg20>0?((latest/avg20)-1)*100:0;
  const entry=clamp(82-Math.max(0,extension-6)*5-Math.max(0,-extension)*3+(avg9>=avg20?12:-6));
  return {liquidity,safety,breakout,support,entry};
 };
 const calculate=(windowDays=9)=>{
  const advanced=window.AitAdvancedSignalPriority?.calculate?.(windowDays)||{rows:[],available:0,required:windowDays};
  const primaryRows=bridge()?.priorityDataset?.()||[];
  const primaryMap=new Map(primaryRows.map(row=>[String(row.code||"").toUpperCase(),row]));
  const sig=`${windowDays}|${advanced.rows?.map(r=>`${r.code}:${Number(r.advancedScore||0).toFixed(2)}`).join('|')||''}|${primaryRows.map(r=>`${r.code}:${Number(r.primaryScore||0).toFixed(1)}:${r.rank||0}:${r.signalRank||0}`).join('|')}|${bridge()?.scannerHistorySignature?.()||bridge()?.scannerUniverseSignature?.()||''}`;
  if(cache.sig===sig&&cache.rows.length)return {rows:cache.rows,available:advanced.available,required:advanced.required};
  const out=(advanced.rows||[]).map(r=>{
   const m=metrics(r.code,windowDays),primary=primaryMap.get(String(r.code||"").toUpperCase())||{};
   const advancedScore=Number(r.advancedScore)||0,historicalScore=Number(r.historicalScore)||0,confirmationScore=Number(r.confirmationScore)||0;
   const rawSetupScore=clamp(advancedScore*.25+historicalScore*.14+confirmationScore*.14+m.entry*.17+m.support*.12+m.liquidity*.08+m.safety*.07+m.breakout*.03);
   const qualityFloor=clamp(advancedScore*.22+historicalScore*.18+confirmationScore*.18+m.entry*.18+m.support*.10+m.liquidity*.07+m.safety*.07);
   const chasePenalty=Math.max(0,m.breakout-68)*.55+Math.max(0,rawSetupScore-70)*.70+Math.max(0,58-m.entry)*.30;
   const timingBonus=Math.max(0,m.entry-60)*.22+Math.max(0,m.support-45)*.10+Math.max(0,confirmationScore-52)*.10;
   const evidenceAdjustment=clamp(50+(70-rawSetupScore)*.55+timingBonus-chasePenalty);
   const eliteScore=clamp(qualityFloor*.62+evidenceAdjustment*.38);
   return {...r,
    primaryOverallRank:Number(primary.rank)||0,
    primarySignalRank:Number(primary.signalRank)||0,
    primarySignal:String(primary.signal||r.signal||"Avoid"),
    primaryLtp:Number(primary.ltp??r.ltp)||0,
    primaryTechnicalScore:Number(primary.indicatorScore??r.indicatorScore)||0,
    primarySmartMoneyScore:Number(primary.vpaScore??r.vpaScore)||0,
    primaryScore:Number(primary.primaryScore??r.primaryScore)||0,
    primaryRelativeScore:Number(primary.comparisonScore??r.comparisonScore)||0,
    primaryRelativeSignal:String(primary.comparisonSignal??r.comparisonSignal??"Neutral"),
    liquidityScore:m.liquidity,volatilitySafetyScore:m.safety,breakoutScore:m.breakout,supportScore:m.support,entryQualityScore:m.entry,rawSetupScore,evidenceAdjustment,eliteScore,signal:signal(eliteScore,m.liquidity,m.safety,m.entry)}
  });
  const seed=[...out].sort((a,b)=>(b.eliteScore-a.eliteScore)||(b.advancedScore-a.advancedScore)||(b.liquidityScore-a.liquidityScore)||(b.breakoutScore-a.breakoutScore)||String(a.code).localeCompare(String(b.code)));
  const total=seed.length;
  const calibrated=seed.map((r,i)=>{const setupRank=i+1,cal=calibratedPriority(r,setupRank,total);return {...r,setupRank,setupRankPercentile:cal.rankPercentile,...cal}});
  const rankingSeed=[...calibrated].sort((a,b)=>(b.advancedScore-a.advancedScore)||(b.eliteScore-a.eliteScore)||(b.liquidityScore-a.liquidityScore)||String(a.code).localeCompare(String(b.code)));
  const ranked=rankingSeed.map((r,i)=>{const merged={...r,rankingScore:Number(r.advancedScore)||0,rankingRank:i+1,rankingPercentile:total?((i+1)/total)*100:100};return decisionLayer({...merged,finalSignal:finalRankSignal(merged)},windowDays)});
  const groups={"Strong Buy":[],"Buy":[],"Watch":[],"Avoid":[]};ranked.forEach(r=>(groups[r.finalSignal]||groups.Avoid).push(r));const rows=[];
  ["Strong Buy","Buy","Watch","Avoid"].forEach(name=>{groups[name].sort((a,b)=>(b.rankingScore-a.rankingScore)||(b.eliteScore-a.eliteScore)||(b.liquidityScore-a.liquidityScore)||(b.breakoutScore-a.breakoutScore)||String(a.code).localeCompare(String(b.code)));groups[name].forEach((r,i)=>rows.push({...r,signalRank:i+1}))});
  rows.forEach((r,i)=>{r.rank=i+1});cache={sig,rows};return {rows,available:advanced.available,required:advanced.required};
 };
 const simpleWhen=r=>{
  const action=String(r.tradeAction||"Watch"),entry=String(r.entryState||"No Entry");
  if(action==="Buy Now")return "Now";
  if(action==="Buy on Pullback")return "Wait Pullback";
  if(action==="Buy on Confirmation")return "Wait Confirmation";
  if(["Hold","Hold / Review","Hold / Tight Risk","Reduce","Exit"].includes(action))return "Existing Position";
  if(entry==="Ready")return "Ready";
  return "Wait";
 };
 const bestHorizon=r=>{
  const st=String(r.shortTerm||"Watch"),mt=String(r.midTerm||"Watch");
  const good=x=>["Strong Buy","Buy"].includes(x);
  if(good(st)&&good(mt))return "Short + Mid";
  if(good(st))return "Short 3–6D";
  if(good(mt))return "Mid 9–20D";
  return "No Buy Horizon";
 };
 const finalDecision=r=>{
  const action=String(r.tradeAction||"Watch"),state=String(r.modelState||"Unverified"),held=isHeld(r.code);
  if(action==="Buy Now")return {label:"BUY NOW",tone:"buy",short:"Entry conditions and model state permit a new position."};
  if(action==="Buy on Confirmation")return {label:"WAIT — BUY ON CONFIRMATION",tone:"wait",short:"Do not enter until confirmation improves."};
  if(action==="Buy on Pullback")return {label:"WAIT — BUY ON PULLBACK",tone:"wait",short:"Do not chase; wait for a better price near support."};
  if(action==="Suspend New Buy")return {label:"WAIT — DO NOT BUY YET",tone:"blocked",short:"The setup may be strong, but the performance safety gate blocks new entries."};
  if(action==="Hold")return {label:"HOLD",tone:"hold",short:"Existing position remains acceptable."};
  if(action==="Hold / Review")return {label:"HOLD — REVIEW",tone:"hold",short:"Keep the existing position under review; do not add."};
  if(action==="Hold / Tight Risk")return {label:"HOLD — TIGHT RISK",tone:"caution",short:"Keep only with tighter risk control while model health is weak."};
  if(action==="Reduce")return {label:"REDUCE",tone:"caution",short:"Existing position has weakened; reduce exposure according to your risk plan."};
  if(action==="Exit")return {label:"EXIT",tone:"avoid",short:"Existing-position risk conditions failed."};
  if(action==="Avoid")return {label:"AVOID",tone:"avoid",short:"Do not open a new position under the current evidence."};
  if(state==="Degraded"&&!held)return {label:"WAIT — MODEL DEGRADED",tone:"blocked",short:"New entry is not justified while recent model performance is degraded."};
  return {label:"WAIT — WATCH",tone:"wait",short:"The setup is not actionable yet."};
 };
 const decisionClass=r=>`ait-elite-decision--${finalDecision(r).tone}`;
 const setupLabel=r=>`${r.finalSignal||"Avoid"} #${r.signalRank||"—"}`;
 const plainReason=r=>{
  const action=String(r.tradeAction||"Watch"),state=String(r.modelState||"Unverified"),signal=String(r.finalSignal||"Avoid");
  if(action==="Buy Now")return `High-priority ${signal} setup; entry, liquidity and risk checks are ready.`;
  if(action==="Buy on Confirmation")return `Good ${signal} candidate, but confirmation/breakout is not strong enough yet.`;
  if(action==="Buy on Pullback")return `Good candidate, but current entry quality favors waiting nearer support.`;
  if(action==="Hold")return `Existing position remains acceptable under the current ${state} model state.`;
  if(action==="Hold / Review")return "Existing position is weakening; review support and do not add yet.";
  if(action==="Hold / Tight Risk")return `Model is ${state}; keep position only with tighter risk control.`;
  if(action==="Reduce")return `Existing position has weakened while model state is ${state}.`;
  if(action==="Exit")return "Risk/signal conditions failed for an existing position.";
  if(action==="Suspend New Buy")return `Setup signal is ${signal}, but the ${state} performance safety gate overrides it. Wait; do not open a new position yet.`;
  if(action==="Avoid")return "Signal, liquidity, volatility or short-term risk gate failed.";
  if(String(r.entryState||"")==="Ready"&&state!=="Healthy")return `Entry setup is Ready, but model state is ${state}; BUY NOW remains locked.`;
  return "Setup is not ready for a new entry; keep it on watch.";
 };
 const updateDecisionSummary=rows=>{
  const set=(id,n)=>document.getElementById(id)?.replaceChildren(document.createTextNode(String(n)));
  set("aitEliteCountBuyNow",rows.filter(r=>r.tradeAction==="Buy Now").length);
  set("aitEliteCountWait",rows.filter(r=>["Buy on Confirmation","Buy on Pullback","Watch","Suspend New Buy"].includes(r.tradeAction)).length);
  set("aitEliteCountHold",rows.filter(r=>["Hold","Hold / Review","Hold / Tight Risk","Reduce"].includes(r.tradeAction)).length);
  set("aitEliteCountAvoid",rows.filter(r=>["Avoid","Exit"].includes(r.tradeAction)).length);
 };
 const scoreBand=value=>{const n=Number(value)||0;return n>=75?"Strong":n>=60?"Good":n>=45?"Mixed":"Weak"};
 const showDetails=code=>{
  const r=(cache.rows||[]).find(x=>String(x.code)===String(code));if(!r)return;
  const title=document.getElementById("aitEliteDetailTitle"),body=document.getElementById("aitEliteDetailBody");
  const decision=finalDecision(r);
  if(title)title.textContent=`${r.code} — ${decision.label}`;
  const actionWhen=simpleWhen(r),horizon=bestHorizon(r),reason=plainReason(r);
  const group=(titleText,subtitle,items,cls="")=>`<section class="ait-elite-detail-group ${cls}"><div class="ait-elite-detail-group-head"><div><h3>${esc(titleText)}</h3><p>${esc(subtitle)}</p></div></div><div class="ait-fundamental-strip">${items.join("")}</div></section>`;
  const item=(label,value,note="")=>`<div class="ait-fundamental-item"><small>${esc(label)}</small><b>${esc(value)}</b>${note?`<em>${esc(note)}</em>`:""}</div>`;
  if(body)body.innerHTML=`
   ${group("1. What should I do?","This is the final decision. It has higher priority than the Strong Buy / Buy setup badge.",[
    item("FINAL DECISION",decision.label,decision.short),
    item("When",actionWhen,r.entryState||"No Entry"),
    item("Model Safety Gate",r.modelState||"Unverified",r.modelState==="Healthy"?"New entries may be considered when stock-specific gates pass":r.modelState==="Caution"?"Require stronger confirmation":r.modelState==="Degraded"?"Avoid aggressive new entries":"Recalibration blocks new buys"),
    item("Strong Buy Trust",storedStrongBuyTrust(),storedStrongBuyTrust()==="Trusted"?"Strong Buy evidence is supportive":storedStrongBuyTrust()==="Conditional"?"Use confirmation; regime is not fully stable":"BUY NOW stays locked until Strong Buy evidence improves"),
    item("Decision Gate",storedDecisionGate(),storedDecisionGate()==="OPEN"?"Performance evidence permits qualified new entries":storedDecisionGate()==="CONFIRMATION ONLY"?"Wait for stronger stock-specific confirmation":"New BUY NOW entries are locked by validation"),
    item("Setup Signal",`${r.finalSignal||"Avoid"} #${r.signalRank}`,`Setup strength only • Elite overall #${r.rank}`),
    item("Best Horizon",horizon,`Short: ${r.shortTerm||"Watch"} • Mid: ${r.midTerm||"Watch"}`),
    item("Why",reason)
   ],`ait-elite-detail-group--decision ${decisionClass(r)}`)}

   ${group("2. Primary Signal Evidence","These are the fields from the Primary Signal Priority table. They explain the foundation of the Elite decision.",[
    item("Primary Overall Rank",r.primaryOverallRank?`#${r.primaryOverallRank}`:"—","Rank in the Primary table"),
    item("Primary Signal Rank",r.primarySignalRank?`${r.primarySignal||"Avoid"} #${r.primarySignalRank}`:(r.primarySignal||"—"),"Rank inside the same Primary signal"),
    item("LTP",(Number(r.primaryLtp||r.ltp)||0).toFixed(2),"Latest price used by the Primary layer"),
    item("Technical",(Number(r.primaryTechnicalScore)||0).toFixed(0),scoreBand(r.primaryTechnicalScore)),
    item("Smart Money",(Number(r.primarySmartMoneyScore)||0).toFixed(0),scoreBand(r.primarySmartMoneyScore)),
    item("Primary Score",(Number(r.primaryScore)||0).toFixed(1),"50% Technical + 50% Smart Money"),
    item("Relative Rank",(Number(r.primaryRelativeScore)||0).toFixed(1),r.primaryRelativeSignal||"Neutral"),
    item("Primary Signal",r.primarySignal||"Avoid","Base signal before Historical / Advanced / Elite calibration")
   ])}

   ${group("3. Historical & Confirmation","This group tells you whether the Primary setup has persisted and whether recent price/volume behavior confirms it.",[
    item("Historical",(Number(r.historicalScore)||0).toFixed(1),scoreBand(r.historicalScore)),
    item("Momentum",(Number(r.momentumScore)||0).toFixed(1),scoreBand(r.momentumScore)),
    item("Stability",(Number(r.stabilityScore)||0).toFixed(1),scoreBand(r.stabilityScore)),
    item("Persistence",(Number(r.persistenceScore)||0).toFixed(1),scoreBand(r.persistenceScore)),
    item("Confirmation",(Number(r.confirmationScore)||0).toFixed(1),scoreBand(r.confirmationScore)),
    item("Advanced Score",(Number(r.advancedScore)||0).toFixed(1),scoreBand(r.advancedScore))
   ])}

   ${group("4. Entry & Risk","Use this group to decide whether a good signal is actually tradable now or should wait for confirmation/pullback.",[
    item("Entry State",r.entryState||"No Entry",actionWhen),
    item("Entry Quality",(Number(r.entryQualityScore)||0).toFixed(1),scoreBand(r.entryQualityScore)),
    item("Breakout",(Number(r.breakoutScore)||0).toFixed(1),scoreBand(r.breakoutScore)),
    item("Support",(Number(r.supportScore)||0).toFixed(1),scoreBand(r.supportScore)),
    item("Liquidity",(Number(r.liquidityScore)||0).toFixed(1),scoreBand(r.liquidityScore)),
    item("Volatility Safety",(Number(r.volatilitySafetyScore)||0).toFixed(1),scoreBand(r.volatilitySafetyScore))
   ])}

   ${group("5. Ranking & Calibration","Advanced Rank is the walk-forward-validated cross-sectional order. Elite Setup calibration remains a separate gate for Strong Buy / Buy labels.",[
    item("Advanced Rank Score",(Number(r.rankingScore??r.advancedScore)||0).toFixed(1),scoreBand(r.rankingScore??r.advancedScore)),
    item("Advanced Rank",r.rankingRank?`#${r.rankingRank} • Top ${(Number(r.rankingPercentile)||100).toFixed(1)}%`:"—","Validated development / validation / holdout ranking"),
    item("Elite Setup Score",(Number(r.eliteScore)||0).toFixed(1),scoreBand(r.eliteScore)),
    item("Raw Setup Score",(Number(r.rawSetupScore)||0).toFixed(1),"Diagnostic only — no longer used directly as rank"),
    item("Evidence Adjustment",(Number(r.evidenceAdjustment)||0).toFixed(1),"Anti-chase / entry-value calibration"),
    item("Setup Percentile",`Top ${(Number(r.setupRankPercentile??r.rankPercentile)||100).toFixed(1)}%`,r.calibratedPriority||"Watch"),
    item("Setup Priority",r.calibratedPriority||"Watch"),
    item("Short Term",`${r.shortTerm||"Watch"} • 3–6D`),
    item("Mid Term",`${r.midTerm||"Watch"} • 9–20D`),
    item("Long Term",r.longTerm||"Not Validated","Do not infer long-term reliability from the current 20D validation")
   ])}`;
  document.getElementById("aitElitePriorityModal")?.setAttribute("hidden","");
  document.getElementById("aitEliteDecisionDetailModal")?.removeAttribute("hidden");
 };
 const render=()=>{const tbody=document.getElementById("aitElitePriorityRows");if(!tbody)return[];const result=calculate(),rows=result.rows||[];if(!rows.length){tbody.innerHTML=`<tr><td colspan="10">${result.available<9?`Elite scanning requires at least 9 trading dates. ${result.available||0} are currently available.`:"No eligible securities could be calculated."}</td></tr>`;updateDecisionSummary([]);return[]}updateDecisionSummary(rows);tbody.innerHTML=rows.map(r=>{const decision=finalDecision(r);return `<tr><td><strong>${esc(r.finalSignal||"Avoid")} #${r.signalRank}</strong><small style="display:block">Overall #${r.rank}</small></td><td><strong>${esc(r.code)}</strong></td><td>${(Number(r.ltp)||0).toFixed(2)}</td><td class="ait-elite-decision-cell ${decisionClass(r)}"><strong>${esc(decision.label)}</strong><small>${esc(decision.short)}</small></td><td><strong>${esc(simpleWhen(r))}</strong><small style="display:block">${esc(r.entryState||"No Entry")}</small></td><td><span class="v11-signal ${String(r.finalSignal||"watch").toLowerCase().replace(/\s+/g,"-")}">${esc(setupLabel(r))}</span><small style="display:block">Setup strength only</small></td><td><strong>${esc(bestHorizon(r))}</strong><small style="display:block">${esc(r.shortTerm||"Watch")} / ${esc(r.midTerm||"Watch")}</small></td><td><strong>${esc(r.modelState||"Unverified")}</strong></td><td class="ait-elite-why-cell">${esc(plainReason(r))}</td><td><button class="btn soft ait-elite-details" data-code="${esc(r.code)}" type="button">View Details</button></td></tr>`}).join("");tbody.querySelectorAll(".ait-elite-details").forEach(btn=>btn.addEventListener("click",()=>showDetails(btn.dataset.code)));return rows};
 const run=()=>{cache={sig:"",rows:[]};window.AitAdvancedSignalPriority?.clearCache?.();window.AitSignalPriorityHistory?.clearCache?.();return render()};
 const ensurePerformanceState=async()=>{try{return await window.AitElitePerformance?.ensureCurrent?.()}catch(_){return false}};
 document.getElementById("aitOpenElitePriority")?.addEventListener("click",()=>{document.getElementById("aitPsaSignalPriorityEngineModal")?.setAttribute("hidden","");document.getElementById("aitElitePriorityModal")?.removeAttribute("hidden");window.AITEliteBusy?.execute?.({kicker:"AIT ELITE SCANNER",title:"Building your decision list",text:"Checking performance state, ranking stocks, validating risk and preparing actions…"},async()=>{await ensurePerformanceState();cache={sig:"",rows:[]};return render()})});
 document.getElementById("aitElitePriorityRun")?.addEventListener("click",()=>window.AITEliteBusy?.execute?.({kicker:"AIT ELITE SCANNER",title:"Recalculating Elite signals",text:"Refreshing calibrated ranks, horizons, entry state and trade actions…"},async()=>{await ensurePerformanceState();return run()}));
 document.getElementById("aitElitePriorityCharts3")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("elite-priority",3));
 document.getElementById("aitElitePriorityCharts6")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("elite-priority",6));
 document.getElementById("aitElitePriorityCharts12")?.addEventListener("click",()=>window.AITOpenRankedCharts?.("elite-priority",12));
 window.AitEliteSignalPriority={calculate,render,run,clearCache:()=>{cache={sig:"",rows:[]}}};
})();
</script>
<script id="ait-elite-performance-script">
(()=>{"use strict";
 const KEY="ait-psa-elite-performance-auto-v15",H=[1,3,6,9,15,20],ORDER=["Strong Buy","Buy","Watch","Avoid"],MIN_LOOKBACK=20;
 const PERCENTILE_BANDS=[
  {label:"Top 5%",from:0,to:.05},{label:"5–10%",from:.05,to:.10},{label:"10–20%",from:.10,to:.20},
  {label:"20–50%",from:.20,to:.50},{label:"50–80%",from:.50,to:.80},{label:"Bottom 20%",from:.80,to:1}
 ];
 const bridge=()=>window.AITScannerDataBridge||null;
 const history=()=>{try{return bridge()?.appState?.()?.history||{}}catch{return {}}};
 const scannerCodes=()=>bridge()?.scannerCodes?.()||bridge()?.codes?.()||[];
 const num=v=>Number.isFinite(Number(v))?Number(v):null;
 const clamp=n=>Math.max(0,Math.min(100,Number(n)||0));
 const pct=v=>v==null?"—":`${v>=0?"+":""}${v.toFixed(2)}%`;
 const mean=a=>a.length?a.reduce((s,v)=>s+v,0)/a.length:null;
 const median=a=>{if(!a.length)return null;const b=[...a].sort((x,y)=>x-y),m=Math.floor(b.length/2);return b.length%2?b[m]:(b[m-1]+b[m])/2};
 const allDates=()=>{const h=history();return [...new Set(scannerCodes().flatMap(code=>Array.isArray(h[code])?h[code].map(r=>String(r?.date||"").slice(0,10)).filter(Boolean):[]))].sort()};
 const historyFingerprint=(maximumDate=null)=>{const h=history(),codes=scannerCodes(),universe=bridge()?.scannerUniverseSignature?.()||codes.join("|");let hash=2166136261,rows=0,lastDate="none";codes.forEach(code=>{const codeToken=`#${code}|`;for(let i=0;i<codeToken.length;i++){hash^=codeToken.charCodeAt(i);hash=Math.imul(hash,16777619)}(Array.isArray(h[code])?h[code]:[]).forEach(r=>{const d=String(r?.date||"").slice(0,10);if(!d||(maximumDate&&d>maximumDate))return;rows++;if(lastDate==="none"||d>lastDate)lastDate=d;const token=`${d}|${r?.open??""}|${r?.high??""}|${r?.low??""}|${r?.close??""}|${r?.volume??""};`;for(let i=0;i<token.length;i++){hash^=token.charCodeAt(i);hash=Math.imul(hash,16777619)}})});return `${lastDate}|${universe}|${codes.length}|${rows}|${(hash>>>0).toString(36)}`};
 const signature=()=>historyFingerprint();
 const load=()=>{try{const x=JSON.parse(localStorage.getItem(KEY)||"null");if(!x||typeof x!=="object")return null;if(!Array.isArray(x.records)&&Array.isArray(x.packedRecords)&&Array.isArray(x.dates)&&Array.isArray(x.codes)){x.records=x.packedRecords.map(p=>({date:x.dates[p[0]],code:x.codes[p[1]],signal:ORDER[p[2]]||"Avoid",finalSignal:ORDER[p[3]]||"Avoid",rankingScore:Number(p[4])||0,entryClose:Number(p[5])||0})).filter(r=>r.date&&r.code&&r.entryClose>0)}return x}catch{return null}};
 const save=x=>{try{const codes=[...new Set((x.records||[]).map(r=>r.code))].sort(),dateIndex=new Map((x.dates||[]).map((date,index)=>[date,index])),codeIndex=new Map(codes.map((code,index)=>[code,index])),signalIndex=value=>{const index=ORDER.indexOf(value);return index<0?ORDER.length-1:index},packedRecords=(x.records||[]).map(r=>[dateIndex.get(r.date),codeIndex.get(r.code),signalIndex(r.signal),signalIndex(r.finalSignal),Number(r.rankingScore)||0,Number(r.entryClose)||0]);const payload={...x,records:undefined,codes,packedRecords};localStorage.setItem(KEY,JSON.stringify(payload));return true}catch(_){return false}};
 const confidence=n=>n<=0?{label:"Insufficient",score:0}:n>=300?{label:"Very High",score:100}:n>=100?{label:"High",score:82}:n>=30?{label:"Medium",score:62}:n>=10?{label:"Low",score:38}:{label:"Very Low",score:20};
 const marketSeriesCache={signature:"",rowsByCode:new Map(),indexByCode:new Map(),calendarDates:[],calendarIndex:new Map()};
 function prepareMarketSeries(currentSignature=signature()){
  if(marketSeriesCache.signature===currentSignature)return;
  marketSeriesCache.signature=currentSignature;
  marketSeriesCache.rowsByCode.clear();
  marketSeriesCache.indexByCode.clear();
  marketSeriesCache.calendarDates=allDates();
  marketSeriesCache.calendarIndex=new Map(marketSeriesCache.calendarDates.map((date,index)=>[date,index]));
  const h=history();
  scannerCodes().forEach(code=>{
   const rows=h[code];
   const positive=(Array.isArray(rows)?rows:[]).filter(row=>row?.date&&num(row.close)!=null&&Number(row.close)>0).sort((a,b)=>String(a.date).localeCompare(String(b.date)));
   const canonical=String(code||"").toUpperCase();
   marketSeriesCache.rowsByCode.set(canonical,positive);
   marketSeriesCache.indexByCode.set(canonical,new Map(positive.map((row,index)=>[String(row.date).slice(0,10),index])));
  });
 }
 const positiveSeries=code=>marketSeriesCache.rowsByCode.get(String(code||"").toUpperCase())||[];
 function clearScannerCaches(){window.AitEliteSignalPriority?.clearCache?.();window.AitAdvancedSignalPriority?.clearCache?.();window.AitSignalPriorityHistory?.clearCache?.()}
 function closeAt(code,date){const canonical=String(code||"").toUpperCase(),rows=positiveSeries(canonical),index=marketSeriesCache.indexByCode.get(canonical)?.get(date);return index==null?null:num(rows[index]?.close)}
 function setBusyProgress(title,text){try{window.AITEliteBusy?.update?.({title,text})}catch(_){}}
 const yieldBrowser=()=>new Promise(resolve=>setTimeout(resolve,0));
 async function reconstructAsync(force=false){
  const dates=allDates(),sig=signature(),cached=load(),eligible=dates.slice(Math.min(MIN_LOOKBACK-1,dates.length));prepareMarketSeries(sig);
  if(!force&&cached?.signature===sig&&Array.isArray(cached.records)&&Array.isArray(cached.dates))return cached;
  let records=[],startIndex=0,mode="Full reconstruction";
  if(!force&&cached&&Array.isArray(cached.records)&&Array.isArray(cached.dates)&&cached.dates.length&&cached.historyEndDate&&cached.sourceFingerprint===historyFingerprint(cached.historyEndDate)){
   const common=Math.min(cached.dates.length,eligible.length);
   let prefix=0;while(prefix<common&&cached.dates[prefix]===eligible[prefix])prefix++;
   if(prefix===cached.dates.length&&eligible.length>=cached.dates.length){
    startIndex=Math.max(0,cached.dates.length-2);
    const keepDates=new Set(eligible.slice(0,startIndex));
    records=cached.records.filter(r=>keepDates.has(r.date));
    mode=eligible.length>cached.dates.length?"Incremental reconstruction":"Tail refresh";
   }
  }
  const pending=eligible.slice(startIndex),previous=window.__AIT_HISTORICAL_CUTOFF_DATE__;
  try{
   for(let i=0;i<pending.length;i++){
    const date=pending[i];window.__AIT_HISTORICAL_CUTOFF_DATE__=date;clearScannerCaches();
    const result=window.AitEliteSignalPriority?.calculate?.();
    (result?.rows||[]).forEach(r=>{const entryClose=closeAt(r.code,date);if(entryClose==null)return;records.push({date,code:String(r.code||"").toUpperCase(),signal:r.signal||"Avoid",finalSignal:r.finalSignal||"Avoid",rankingScore:Number(r.rankingScore??r.advancedScore)||0,entryClose})});
    setBusyProgress(`${mode} • ${i+1}/${pending.length||1} dates`,`Reconstructing ${date}. Cached history is being reused wherever possible.`);
    await yieldBrowser();
   }
  }finally{if(previous)window.__AIT_HISTORICAL_CUTOFF_DATE__=previous;else delete window.__AIT_HISTORICAL_CUTOFF_DATE__;clearScannerCaches()}
  const historyEndDate=dates.at(-1)||null,data={version:15,signature:sig,sourceFingerprint:historyEndDate?historyFingerprint(historyEndDate):sig,historyEndDate,builtAt:new Date().toISOString(),dates:eligible,records};save(data);return data;
 }
 function evaluateRaw(r){const code=String(r.code||"").toUpperCase(),data=positiveSeries(code),rowIndex=marketSeriesCache.indexByCode.get(code),calendarIndex=marketSeriesCache.calendarIndex.get(r.date);if(calendarIndex==null||!r.entryClose)return {...r,returns:{},mfe:null,mae:null};const base=Number(r.entryClose),returns={};H.forEach(h=>{const targetDate=marketSeriesCache.calendarDates[calendarIndex+h],targetIndex=targetDate?rowIndex?.get(targetDate):null,x=targetIndex==null?null:data[targetIndex];returns[h]=x?((Number(x.close)/base)-1)*100:null});const futureDates=marketSeriesCache.calendarDates.slice(calendarIndex+1,calendarIndex+21),future=futureDates.map(date=>{const index=rowIndex?.get(date);return index==null?null:data[index]}).filter(Boolean);return {...r,returns,mfe:future.length?Math.max(...future.map(x=>((Number(x.high??x.close)/base)-1)*100)):null,mae:future.length?Math.min(...future.map(x=>((Number(x.low??x.close)/base)-1)*100)):null}}
 function attachBenchmark(rows){const byDate=new Map();rows.forEach(r=>{if(!byDate.has(r.date))byDate.set(r.date,[]);byDate.get(r.date).push(r)});const benchmarkByDate=new Map();byDate.forEach((peers,date)=>{const benchmark={};H.forEach(h=>{const values=[];for(const peer of peers){const value=peer.returns?.[h];if(value!=null&&Number.isFinite(value))values.push(value)}benchmark[h]=mean(values)});benchmarkByDate.set(date,benchmark)});return rows.map(r=>{const benchmark=benchmarkByDate.get(r.date)||{},excess={};H.forEach(h=>{excess[h]=r.returns?.[h]!=null&&benchmark[h]!=null?r.returns[h]-benchmark[h]:null});return {...r,benchmark,excess}})}
 function stats(rows,h){const raw=rows.map(r=>r.returns?.[h]).filter(v=>v!=null&&Number.isFinite(v)),bench=rows.map(r=>r.benchmark?.[h]).filter(v=>v!=null&&Number.isFinite(v)),ex=rows.map(r=>r.excess?.[h]).filter(v=>v!=null&&Number.isFinite(v));return {n:ex.length,rawAvg:mean(raw),benchAvg:mean(bench),excessAvg:mean(ex),excessMedian:median(ex),excessWin:ex.length?ex.filter(v=>v>0).length/ex.length*100:null}}
 function validation(rows){const s3=stats(rows,3),s6=stats(rows,6),s9=stats(rows,9),n=Math.max(s3.n,s6.n,s9.n),conf=confidence(n);if(n<=0)return {score:null,confidence:conf,n:0,edge:null,win:null,risk:null};const weightedParts=[[s3.excessAvg,.2],[s6.excessAvg,.3],[s9.excessAvg,.5]].filter(([v])=>v!=null);const weightTotal=weightedParts.reduce((a,[,w])=>a+w,0)||1,weightedExcess=weightedParts.reduce((a,[v,w])=>a+v*w,0)/weightTotal,edge=clamp(50+weightedExcess*10),win=clamp(s9.excessWin??50),mfe=mean(rows.map(r=>r.mfe).filter(v=>v!=null)),mae=mean(rows.map(r=>r.mae).filter(v=>v!=null)),risk=mfe==null||mae==null?50:clamp((mfe/(Math.max(.01,mfe+Math.abs(mae))))*100);return {score:clamp(edge*.35+win*.30+conf.score*.20+risk*.15),confidence:conf,n,edge,win,risk}}
 function monotonicity(all){const vals=PERCENTILE_BANDS.map(b=>({b,v:stats(percentileBandRows(all,b.from,b.to),9).excessAvg})).filter(x=>x.v!=null);if(vals.length<2)return 50;let good=0,total=0;for(let i=0;i<vals.length-1;i++){total++;if(vals[i].v>=vals[i+1].v)good++}return total?good/total*100:50}
 function globalValidation(all){const top=percentileRows(all,.10,"top"),v=validation(top.length?top:all),mono=monotonicity(all);return v.score==null?null:clamp(v.score*.75+mono*.25)}
 function percentileRows(all,fraction,side="top"){
  const byDate=new Map();all.forEach(r=>{if(!byDate.has(r.date))byDate.set(r.date,[]);byDate.get(r.date).push(r)});const selected=[];
  byDate.forEach(rows=>{const sorted=[...rows].sort((a,b)=>(Number(b.rankingScore??b.advancedScore)||0)-(Number(a.rankingScore??a.advancedScore)||0)||(Number(a.rankingRank)||0)-(Number(b.rankingRank)||0));if(!sorted.length)return;const count=Math.max(1,Math.ceil(sorted.length*fraction));selected.push(...(side==="bottom"?sorted.slice(-count):sorted.slice(0,count)))});return selected;
 }
 function percentileBandRows(all,from,to){
  const byDate=new Map();all.forEach(r=>{if(!byDate.has(r.date))byDate.set(r.date,[]);byDate.get(r.date).push(r)});const selected=[];
  byDate.forEach(rows=>{const sorted=[...rows].sort((a,b)=>(Number(b.rankingScore??b.advancedScore)||0)-(Number(a.rankingScore??a.advancedScore)||0)||(Number(a.rankingRank)||0)-(Number(b.rankingRank)||0));if(!sorted.length)return;const start=Math.floor(sorted.length*from),end=Math.max(start+1,Math.ceil(sorted.length*to));selected.push(...sorted.slice(start,Math.min(sorted.length,end)))});
  return selected;
 }
 const PERCENTILES=[
  {label:"Top 5%",rows:all=>percentileRows(all,.05,"top")},
  {label:"Top 10%",rows:all=>percentileRows(all,.10,"top")},
  {label:"Top 20%",rows:all=>percentileRows(all,.20,"top")},
  {label:"Bottom 20%",rows:all=>percentileRows(all,.20,"bottom")}
 ];
 function rankingQuality(all){
  const top10=percentileRows(all,.10,"top"),top20=percentileRows(all,.20,"top"),bottom20=percentileRows(all,.20,"bottom");
  const spreads=[3,6,9,15,20].map(h=>{const a=stats(top10,h).excessAvg,b=stats(bottom20,h).excessAvg;return a==null||b==null?null:a-b}).filter(v=>v!=null);
  const top20_9=stats(top20,9).excessAvg,bottom9=stats(bottom20,9).excessAvg,spreadAvg=mean(spreads);
  if(spreadAvg==null)return {score:null,spread9:null,label:"Insufficient Data"};
  const spread9=top20_9==null||bottom9==null?null:top20_9-bottom9;
  const score=clamp(50+spreadAvg*12+(spread9??0)*8);
  const label=score>=70?"Strong":score>=60?"Good":score>=50?"Mixed":score>=40?"Weak":"Poor";
  return {score,spread9,label};
 }
 function calibratedSignalQuality(all){
  const vals=ORDER.map(signal=>({signal,v:stats(all.filter(r=>(r.finalSignal||"Avoid")===signal),9).excessAvg})).filter(x=>x.v!=null);
  if(vals.length<2)return {score:null,label:"Insufficient Data"};
  let good=0,total=0;for(let i=0;i<vals.length-1;i++){total++;if(vals[i].v>=vals[i+1].v)good++}
  const score=total?good/total*100:null;
  return {score,label:score==null?"Insufficient Data":score>=100?"Ordered":score>=67?"Mostly Ordered":score>=34?"Mixed":"Poor"};
 }
 function windowByDates(all,count){
  const dates=[...new Set(all.map(r=>r.date).filter(Boolean))].sort();
  const selected=count==null?dates:dates.slice(-Math.max(0,count));
  const set=new Set(selected);return {dates:selected,rows:all.filter(r=>set.has(r.date))};
 }
 function signalOrdering(rows){
  const vals=ORDER.map(signal=>({signal,v:stats(rows.filter(r=>(r.finalSignal||"Avoid")===signal),9).excessAvg,n:stats(rows.filter(r=>(r.finalSignal||"Avoid")===signal),9).n}));
  const available=vals.filter(x=>x.v!=null);
  if(available.length<4)return {score:null,label:"Insufficient Data",values:vals};
  let good=0;for(let i=0;i<available.length-1;i++)if(available[i].v>=available[i+1].v)good++;
  const score=good/3*100;return {score,label:score===100?"Ordered":score>=66.7?"Mostly Ordered":score>=33.4?"Mixed":"Poor",values:vals};
 }
 function rollingHealth(rows,dateCount,label){
  const w=windowByDates(rows,dateCount),ordering=signalOrdering(w.rows),rq=rankingQuality(w.rows);
  const sb=stats(w.rows.filter(r=>(r.finalSignal||"Avoid")==="Strong Buy"),9),buy=stats(w.rows.filter(r=>(r.finalSignal||"Avoid")==="Buy"),9),watch=stats(w.rows.filter(r=>(r.finalSignal||"Avoid")==="Watch"),9),avoid=stats(w.rows.filter(r=>(r.finalSignal||"Avoid")==="Avoid"),9);
  const sb20=stats(w.rows.filter(r=>(r.finalSignal||"Avoid")==="Strong Buy"),20).excessAvg,avoid20=stats(w.rows.filter(r=>(r.finalSignal||"Avoid")==="Avoid"),20).excessAvg,spread20=sb20==null||avoid20==null?null:sb20-avoid20;
  const sampleCount=Math.max(sb.n,buy.n,watch.n,avoid.n),minClass=Math.min(...[sb.n,buy.n,watch.n,avoid.n]);
  let health="Insufficient Data";
  if(w.dates.length>=Math.min(20,dateCount||20)&&sampleCount>=30&&minClass>=5){
    const severe=(ordering.score!=null&&ordering.score<34)||(rq.score!=null&&rq.score<50)||(spread20!=null&&spread20<=0)||(sb.excessAvg!=null&&avoid.excessAvg!=null&&sb.excessAvg<=avoid.excessAvg);
    const caution=(ordering.score!=null&&ordering.score<67)||(rq.score!=null&&rq.score<60)||(spread20!=null&&spread20<1)||(sb.excessAvg!=null&&sb.excessAvg<=0);
    health=severe?"Degraded":caution?"Caution":"Healthy";
  }
  return {label,dates:w.dates.length,rows:w.rows,samples:w.rows.length,sb,buy,watch,avoid,spread20,rq,ordering,health};
 }
 function strongBuyTrustWindow(all,dateCount,label){
  const w=windowByDates(all,dateCount),sbRows=w.rows.filter(r=>(r.finalSignal||"Avoid")==="Strong Buy"),avoidRows=w.rows.filter(r=>(r.finalSignal||"Avoid")==="Avoid");
  const s6=stats(sbRows,6),s9=stats(sbRows,9),s15=stats(sbRows,15),s20=stats(sbRows,20),a9=stats(avoidRows,9),a20=stats(avoidRows,20);
  const spread9=s9.excessAvg==null||a9.excessAvg==null?null:s9.excessAvg-a9.excessAvg,spread20=s20.excessAvg==null||a20.excessAvg==null?null:s20.excessAvg-a20.excessAvg;
  let trust="Insufficient";if(s9.n>=30){const strong=(s9.excessAvg??-99)>0&&(s15.excessAvg??-99)>0&&(spread9??-99)>.15&&(spread20??-99)>0;const acceptable=(s9.excessAvg??-99)>-.10&&(spread9??-99)>0&&(s20.excessAvg??-99)>-.20;trust=strong?"Trusted":acceptable?"Conditional":"Weak"}
  return {label,dates:w.dates.length,samples:s9.n,s6,s9,s15,s20,spread9,spread20,trust};
 }
 function strongBuyTrust(all){
  const windows=[strongBuyTrustWindow(all,20,"Recent 20D"),strongBuyTrustWindow(all,40,"Recent 40D"),strongBuyTrustWindow(all,60,"Recent 60D"),strongBuyTrustWindow(all,100,"Recent 100D"),strongBuyTrustWindow(all,null,"All History")];
  const [recent,medium,confirm,regime,history]=windows;let overall="Insufficient";
  if(history.samples>=30){if(confirm.trust==="Weak"&&regime.trust==="Weak")overall="Weak";else if(regime.trust==="Trusted"&&["Trusted","Conditional"].includes(confirm.trust))overall=(recent.trust==="Weak"||medium.trust==="Weak")?"Conditional":"Trusted";else if(["Trusted","Conditional"].includes(regime.trust)||["Trusted","Conditional"].includes(confirm.trust))overall="Conditional";else overall=history.trust}
  return {overall,windows};
 }
 function strongBuyComparison(all){
  const sb=all.filter(r=>(r.finalSignal||"Avoid")==="Strong Buy"),others=all.filter(r=>(r.finalSignal||"Avoid")!=="Strong Buy");
  const groups=[{label:"SB vs Buy",rows:all.filter(r=>(r.finalSignal||"Avoid")==="Buy")},{label:"SB vs Watch",rows:all.filter(r=>(r.finalSignal||"Avoid")==="Watch")},{label:"SB vs Avoid",rows:all.filter(r=>(r.finalSignal||"Avoid")==="Avoid")},{label:"SB vs All Non-SB",rows:others}];
  return groups.map(g=>{const spreads={};H.filter(h=>h!==1).forEach(h=>{const a=stats(sb,h).excessAvg,b=stats(g.rows,h).excessAvg;spreads[h]=a==null||b==null?null:a-b});return {label:g.label,spreads}});
 }
function strongBuyTimeConsistency(all,blockSize=20){
  const dates=[...new Set(all.map(r=>r.date))].sort(),blocks=[];for(let i=0;i<dates.length;i+=blockSize){const ds=dates.slice(i,i+blockSize);if(ds.length<Math.min(10,blockSize))continue;const set=new Set(ds),rows=all.filter(r=>set.has(r.date)),sb=rows.filter(r=>(r.finalSignal||"Avoid")==="Strong Buy"),non=rows.filter(r=>(r.finalSignal||"Avoid")!=="Strong Buy"),s9=stats(sb,9),n9=stats(non,9),s20=stats(sb,20),n20=stats(non,20),spread9=s9.excessAvg==null||n9.excessAvg==null?null:s9.excessAvg-n9.excessAvg,spread20=s20.excessAvg==null||n20.excessAvg==null?null:s20.excessAvg-n20.excessAvg;blocks.push({label:`${ds[0]} → ${ds.at(-1)}`,dates:ds.length,samples:s9.n,s9,spread9,spread20,result:s9.n<10?"Insufficient":(s9.excessAvg>0&&spread9>0)?"Positive":"Weak"})}const eligible=blocks.filter(b=>b.result!=="Insufficient"),positive=eligible.filter(b=>b.result==="Positive").length,ratio=eligible.length?positive/eligible.length:null;return {blocks,eligible:eligible.length,positive,ratio,label:ratio==null?"Insufficient":ratio>=.65?"Consistent":ratio>=.5?"Mixed":"Unstable"};
 }
 function hacInterval(rows,horizon=9){
  const byDate=new Map();rows.forEach(r=>{const value=r.excess?.[horizon];if(value==null||!Number.isFinite(value))return;if(!byDate.has(r.date))byDate.set(r.date,[]);byDate.get(r.date).push(value)});
  const values=[...byDate.entries()].sort(([a],[b])=>a.localeCompare(b)).map(([,items])=>mean(items)).filter(v=>v!=null),n=values.length;
  if(n<12)return {n,mean:mean(values),lower:null,upper:null,se:null};
  const average=mean(values),centered=values.map(v=>v-average),bandwidth=Math.min(Math.max(1,horizon),n-1);
  let longRunVariance=centered.reduce((sum,v)=>sum+v*v,0)/n;
  for(let lag=1;lag<=bandwidth;lag++){let covariance=0;for(let i=lag;i<n;i++)covariance+=centered[i]*centered[i-lag];covariance/=n;longRunVariance+=2*(1-lag/(bandwidth+1))*covariance}
  const se=Math.sqrt(Math.max(0,longRunVariance)/n),margin=1.96*se;return {n,mean:average,lower:average-margin,upper:average+margin,se};
 }
 function temporalHoldoutValidation(all){
  const dates=[...new Set(all.map(r=>r.date).filter(Boolean))].sort(),developmentEnd=Math.floor(dates.length*.60),validationEnd=Math.floor(dates.length*.80);
  const definitions=[{label:"Development 60%",dates:dates.slice(0,developmentEnd)},{label:"Validation 20%",dates:dates.slice(developmentEnd,validationEnd)},{label:"Final Holdout 20%",dates:dates.slice(validationEnd)}];
  const periods=definitions.map(period=>{const selected=new Set(period.dates),rows=all.filter(r=>selected.has(r.date)),rq=rankingQuality(rows),top10=stats(percentileRows(rows,.10,"top"),9),bottom20=stats(percentileRows(rows,.20,"bottom"),9),sb9=stats(rows.filter(r=>(r.finalSignal||"Avoid")==="Strong Buy"),9),spread=top10.excessAvg==null||bottom20.excessAvg==null?null:top10.excessAvg-bottom20.excessAvg;let result="Insufficient";if(period.dates.length>=20&&top10.n>=30&&bottom20.n>=30){if((rq.score??0)>=60&&(spread??-99)>0&&(top10.excessAvg??-99)>0)result="Pass";else if((rq.score??0)>=60&&(spread??-99)>0)result="Caution";else result="Fail"}return {...period,rows:rows.length,rq,top10,bottom20,spread,sb9,result}});
  return {periods,holdout:periods.at(-1)||null};
 }
 function reliabilityAssessment(health,trust,consistency,temporal,interval){
  const holdout=temporal.holdout,history=trust.windows.at(-1),rankPeriods=temporal.periods.filter(p=>p.result!=="Insufficient"),rankPass=rankPeriods.length===3&&rankPeriods.every(p=>p.result==="Pass"),structuralSignal=history?.trust==="Trusted"&&(history?.s9?.excessAvg??-99)>0,holdoutSignal=(holdout?.sb9?.n??0)>=30&&(holdout?.sb9?.excessAvg??-99)>0,statisticallySupported=interval?.lower!=null&&interval.lower>0;
  let status="NOT RELIABLE";if(rankPass&&structuralSignal&&holdoutSignal&&statisticallySupported&&consistency.label==="Consistent")status="RELIABLE";else if(rankPass&&structuralSignal&&holdoutSignal&&!(["Recalibration Required","Degraded"].includes(health)))status="CONDITIONAL";
  const reasons=[];reasons.push(rankPass?"Advanced Rank passed all three chronological periods":"Advanced Rank did not pass every chronological period");reasons.push(structuralSignal?"all-history Strong Buy edge is positive and trusted":"all-history Strong Buy evidence is not trusted");reasons.push(holdoutSignal?"Strong Buy is positive in the final holdout":"Strong Buy is not positive with 30+ samples in the final holdout");reasons.push(consistency.label==="Consistent"?`time consistency is ${consistency.positive}/${consistency.eligible}`:`time consistency is only ${consistency.positive}/${consistency.eligible} eligible blocks`);reasons.push(statisticallySupported?"the date-clustered 95% lower bound is above zero":"the date-clustered 95% range still includes zero");if(health!=="Healthy")reasons.push(`current rolling health is ${health}`);return {status,reasons,rankPass,structuralSignal,holdoutSignal,statisticallySupported};
 }
 function decisionGate(health,trust,consistency,reliability){
  if(["Recalibration Required","Degraded"].includes(health))return "LOCKED";
  if(reliability?.status==="NOT RELIABLE")return "LOCKED";
  if(trust==="Weak"||trust==="Insufficient")return "LOCKED";
  if(consistency.label==="Unstable")return "LOCKED";
  if(reliability?.status==="RELIABLE"&&health==="Healthy"&&trust==="Trusted"&&consistency.label==="Consistent")return "OPEN";
  return "CONFIRMATION ONLY";
 }
 function calibrationHealth(all){
  // v4.1: separate immediate regime stress from structural model failure.
  // 20D/40D can lock BUY NOW through Caution, but recalibration requires
  // deterioration that persists through the 60D and 100D confirmation windows.
  const windows=[
    rollingHealth(all,20,"Recent 20D"),
    rollingHealth(all,40,"Recent 40D"),
    rollingHealth(all,60,"Recent 60D"),
    rollingHealth(all,100,"Recent 100D"),
    rollingHealth(all,null,"All History")
  ];
  const recent=windows[0],medium=windows[1],confirm=windows[2],regime=windows[3],history=windows[4];
  const known=windows.filter(w=>w.health!=="Insufficient Data");
  let overall="Insufficient Data";
  if(known.length){
    const bad=w=>w.health==="Degraded";
    const warn=w=>w.health==="Caution"||w.health==="Degraded";
    // Structural failure: weakness persists beyond the latest short window.
    if(bad(medium)&&bad(confirm)&&bad(regime))overall="Recalibration Required";
    else if(bad(confirm)&&bad(regime))overall="Degraded";
    // Short-lived regime weakness remains a safety lock, but does not label
    // the model itself broken when 60D/100D evidence is still acceptable.
    else if(bad(recent)||bad(medium)||warn(confirm)||warn(regime))overall="Caution";
    else if(confirm.health==="Healthy"&&regime.health==="Healthy")overall="Healthy";
    else if(regime.health==="Healthy")overall="Healthy";
    else overall=known[0].health;
  }
  return {overall,windows};
 }
 async function evaluateRecordsAsync(records){
  const out=[],chunk=220,total=records.length;
  for(let i=0;i<total;i+=chunk){
   const part=records.slice(i,i+chunk);for(const r of part)out.push(evaluateRaw(r));
   setBusyProgress(`Evaluating forward performance • ${Math.min(i+chunk,total)}/${total}`,`Calculating returns, MFE and MAE while keeping the browser responsive.`);
   await yieldBrowser();
  }
  return out;
 }
 const evaluatedMemoryCache={signature:"",built:null,all:null};
 async function evaluatedAsync(force=false){
  const currentSignature=signature();
  if(!force&&evaluatedMemoryCache.signature===currentSignature&&evaluatedMemoryCache.built&&Array.isArray(evaluatedMemoryCache.all))return {built:evaluatedMemoryCache.built,all:evaluatedMemoryCache.all};
  const built=await reconstructAsync(force);
  const raw=await evaluateRecordsAsync(built.records||[]);
  setBusyProgress("Building benchmark & validation","Calculating excess returns, percentile ranking and rolling calibration health.");
  await yieldBrowser();
  const all=attachBenchmark(raw);evaluatedMemoryCache.signature=currentSignature;evaluatedMemoryCache.built=built;evaluatedMemoryCache.all=all;return {built,all};
 }
 let lastRenderedSignature="";
 async function render(force=false){
  const currentSignature=signature();if(!force&&lastRenderedSignature===currentSignature&&Array.isArray(evaluatedMemoryCache.all))return evaluatedMemoryCache.all;
  const status=document.getElementById("aitElitePerformanceAutoStatus");if(status)status.textContent="Analyzing OHLC…";const {built,all}=await evaluatedAsync(force);
  document.getElementById("aitElitePerfSnapshots")?.replaceChildren(document.createTextNode(String((built.dates||[]).length)));
  document.getElementById("aitElitePerfSignals")?.replaceChildren(document.createTextNode(String(all.length)));
  document.getElementById("aitElitePerf9dSignals")?.replaceChildren(document.createTextNode(String(stats(all,9).n)));
  const sbRows=all.filter(r=>(r.finalSignal||"Avoid")==="Strong Buy"),sb9=stats(sbRows,9),global=globalValidation(all),rankQuality=rankingQuality(all),health=calibrationHealth(all);
  document.getElementById("aitElitePerfWin9")?.replaceChildren(document.createTextNode(pct(sb9.excessAvg)));
  document.getElementById("aitElitePerfAvg9")?.replaceChildren(document.createTextNode(global==null?"N/A":global.toFixed(1)));
  document.getElementById("aitElitePerfRankingQuality")?.replaceChildren(document.createTextNode(rankQuality.score==null?"N/A":`${rankQuality.score.toFixed(1)} • ${rankQuality.label}`));
  const sbTrust=strongBuyTrust(all),sbCompare=strongBuyComparison(all),sbConsistency=strongBuyTimeConsistency(all),temporal=temporalHoldoutValidation(all),sbCi=hacInterval(sbRows,9),reliability=reliabilityAssessment(health.overall,sbTrust,sbConsistency,temporal,sbCi),gate=decisionGate(health.overall,sbTrust.overall,sbConsistency,reliability);
  document.getElementById("aitEliteReliabilityState")?.replaceChildren(document.createTextNode(reliability.status));
  document.getElementById("aitEliteHoldoutRank")?.replaceChildren(document.createTextNode(temporal.holdout?.rq?.score==null?"N/A":`${temporal.holdout.rq.score.toFixed(1)} • ${temporal.holdout.result}`));
  document.getElementById("aitElitePerfCalibrationHealth")?.replaceChildren(document.createTextNode(health.overall));
  document.getElementById("aitEliteDecisionGate")?.replaceChildren(document.createTextNode(gate));
  document.getElementById("aitEliteSbConsistency")?.replaceChildren(document.createTextNode(sbConsistency.ratio==null?"N/A":`${(sbConsistency.ratio*100).toFixed(0)}% (${sbConsistency.positive}/${sbConsistency.eligible}) • ${sbConsistency.label}`));
  document.getElementById("aitEliteStrongBuyTrustState")?.replaceChildren(document.createTextNode(sbTrust.overall));const sbAll=sbTrust.windows.at(-1);
  document.getElementById("aitEliteStrongBuyTrustSamples")?.replaceChildren(document.createTextNode(String(sbAll?.samples||0)));
  document.getElementById("aitEliteStrongBuyTrust9D")?.replaceChildren(document.createTextNode(pct(sbAll?.s9?.excessAvg??null)));
  document.getElementById("aitEliteStrongBuyTrust20D")?.replaceChildren(document.createTextNode(pct(sbAll?.s20?.excessAvg??null)));
  document.getElementById("aitEliteStrongBuyTrustCi")?.replaceChildren(document.createTextNode(sbCi.lower==null||sbCi.upper==null?"N/A":`${pct(sbCi.lower)} to ${pct(sbCi.upper)}`));
  document.getElementById("aitEliteReliabilityReason")?.replaceChildren(document.createTextNode(`Reliability: ${reliability.reasons.join("; ")}.`));
  try{localStorage.setItem("ait-psa-elite-model-state-v8",JSON.stringify({overall:health.overall,reliability:reliability.status,strongBuyTrust:sbTrust.overall,decisionGate:gate,strongBuyConsistency:sbConsistency.label,strongBuyConsistencyRatio:sbConsistency.ratio,holdoutRankQuality:temporal.holdout?.rq?.score??null,holdoutStrongBuy9D:temporal.holdout?.sb9?.excessAvg??null,updatedAt:new Date().toISOString(),dates:(built.dates||[]).length,signature:signature()}))}catch{}
  if(status)status.textContent=`On-demand v4.4 reliability-validation • ${(built.dates||[]).length} dates • ${reliability.status} • ${health.overall} • SB ${sbTrust.overall} • ${gate}`;
  const rollingBody=document.getElementById("aitElitePerformanceRollingRows");if(rollingBody){rollingBody.innerHTML=health.windows.map(w=>`<tr><td><strong>${w.label}</strong></td><td>${w.dates}</td><td>${w.samples}</td><td>${pct(w.sb.excessAvg)}</td><td>${pct(w.buy.excessAvg)}</td><td>${pct(w.watch.excessAvg)}</td><td>${pct(w.avoid.excessAvg)}</td><td>${pct(w.spread20)}</td><td>${w.rq.score==null?"N/A":w.rq.score.toFixed(1)+" • "+w.rq.label}</td><td>${w.ordering.label}</td><td><strong>${w.health}</strong></td></tr>`).join("")}
  const trustBody=document.getElementById("aitEliteStrongBuyTrustRows");if(trustBody){trustBody.innerHTML=sbTrust.windows.map(w=>`<tr><td><strong>${w.label}</strong></td><td>${w.samples}</td><td>${pct(w.s6.excessAvg)}</td><td>${pct(w.s9.excessAvg)}</td><td>${pct(w.s15.excessAvg)}</td><td>${pct(w.s20.excessAvg)}</td><td>${pct(w.spread9)}</td><td>${pct(w.spread20)}</td><td><strong>${w.trust}</strong></td></tr>`).join("")}
  const compareBody=document.getElementById("aitEliteStrongBuyCompareRows");if(compareBody){compareBody.innerHTML=sbCompare.map(g=>`<tr><td><strong>${g.label}</strong></td><td>${pct(g.spreads[3])}</td><td>${pct(g.spreads[6])}</td><td>${pct(g.spreads[9])}</td><td>${pct(g.spreads[15])}</td><td>${pct(g.spreads[20])}</td></tr>`).join("")}
  const consistencyBody=document.getElementById("aitEliteStrongBuyConsistencyRows");if(consistencyBody){consistencyBody.innerHTML=sbConsistency.blocks.map(b=>`<tr><td><strong>${b.label}</strong></td><td>${b.dates}</td><td>${b.samples}</td><td>${pct(b.s9.excessAvg)}</td><td>${pct(b.spread9)}</td><td>${pct(b.spread20)}</td><td><strong>${b.result}</strong></td></tr>`).join("")}
  const temporalBody=document.getElementById("aitEliteTemporalValidationRows");if(temporalBody){temporalBody.innerHTML=temporal.periods.map(p=>`<tr><td><strong>${p.label}</strong><small style="display:block">${p.dates[0]||"—"} → ${p.dates.at(-1)||"—"}</small></td><td>${p.dates.length}</td><td>${p.rows}</td><td>${p.rq.score==null?"N/A":p.rq.score.toFixed(1)+" • "+p.rq.label}</td><td>${pct(p.top10.excessAvg)}</td><td>${pct(p.bottom20.excessAvg)}</td><td>${pct(p.spread)}</td><td>${p.sb9.n}</td><td>${pct(p.sb9.excessAvg)}</td><td><strong>${p.result}</strong></td></tr>`).join("")}
  const tbody=document.getElementById("aitElitePerformanceRows");
  if(tbody){if(!all.length)tbody.innerHTML=`<tr><td colspan="15">No eligible Elite history could be reconstructed. At least ${MIN_LOOKBACK} downloaded trading dates are required.</td></tr>`;else tbody.innerHTML=ORDER.map(sig=>{const rows=all.filter(r=>r.signal===sig),v=validation(rows),s3=stats(rows,3),s6=stats(rows,6),s9=stats(rows,9),s15=stats(rows,15),s20=stats(rows,20),mfe=mean(rows.map(r=>r.mfe).filter(x=>x!=null)),mae=mean(rows.map(r=>r.mae).filter(x=>x!=null));return `<tr><td><strong>${sig}</strong></td><td>${v.n}</td><td>${v.confidence.label}</td><td>${pct(s3.rawAvg)}</td><td>${pct(s3.excessAvg)}</td><td>${pct(s6.rawAvg)}</td><td>${pct(s6.excessAvg)}</td><td>${pct(s9.rawAvg)}</td><td>${pct(s9.excessAvg)}</td><td>${s9.excessWin==null?"—":s9.excessWin.toFixed(1)+"%"}</td><td>${pct(s15.excessAvg)}</td><td>${pct(s20.excessAvg)}</td><td>${pct(mfe)}</td><td>${pct(mae)}</td><td><strong>${v.score==null?"N/A":v.score.toFixed(1)}</strong></td></tr>`}).join("")}
  const calibratedBody=document.getElementById("aitElitePerformanceCalibratedRows");if(calibratedBody){calibratedBody.innerHTML=ORDER.map(sig=>{const rows=all.filter(r=>(r.finalSignal||"Avoid")===sig),v=validation(rows),s3=stats(rows,3),s6=stats(rows,6),s9=stats(rows,9),s15=stats(rows,15),s20=stats(rows,20),mfe=mean(rows.map(r=>r.mfe).filter(x=>x!=null)),mae=mean(rows.map(r=>r.mae).filter(x=>x!=null));return `<tr><td><strong>${sig}</strong></td><td>${v.n}</td><td>${v.confidence.label}</td><td>${pct(s3.excessAvg)}</td><td>${pct(s6.excessAvg)}</td><td>${pct(s9.excessAvg)}</td><td>${s9.excessWin==null?"—":s9.excessWin.toFixed(1)+"%"}</td><td>${pct(s15.excessAvg)}</td><td>${pct(s20.excessAvg)}</td><td>${pct(mfe)}</td><td>${pct(mae)}</td><td><strong>${v.score==null?"N/A":v.score.toFixed(1)}</strong></td></tr>`}).join("")}
    const bucketBody=document.getElementById("aitElitePerformanceBucketRows");if(bucketBody){bucketBody.innerHTML=PERCENTILE_BANDS.map(b=>{const rows=percentileBandRows(all,b.from,b.to),v=validation(rows),s3=stats(rows,3),s6=stats(rows,6),s9=stats(rows,9),s15=stats(rows,15),s20=stats(rows,20),mfe=mean(rows.map(r=>r.mfe).filter(x=>x!=null)),mae=mean(rows.map(r=>r.mae).filter(x=>x!=null));return `<tr><td><strong>${b.label}</strong></td><td>${v.n}</td><td>${v.confidence.label}</td><td>${pct(s3.excessAvg)}</td><td>${pct(s6.excessAvg)}</td><td>${pct(s9.excessAvg)}</td><td>${s9.excessWin==null?"—":s9.excessWin.toFixed(1)+"%"}</td><td>${pct(s15.excessAvg)}</td><td>${pct(s20.excessAvg)}</td><td>${pct(mfe)}</td><td>${pct(mae)}</td><td><strong>${v.score==null?"N/A":v.score.toFixed(1)}</strong></td></tr>`}).join("")}
  const percentileBody=document.getElementById("aitElitePerformancePercentileRows");if(percentileBody){percentileBody.innerHTML=PERCENTILES.map(g=>{const rows=g.rows(all),v=validation(rows),s3=stats(rows,3),s6=stats(rows,6),s9=stats(rows,9),s15=stats(rows,15),s20=stats(rows,20);return `<tr><td><strong>${g.label}</strong></td><td>${v.n}</td><td>${v.confidence.label}</td><td>${pct(s3.excessAvg)}</td><td>${pct(s6.excessAvg)}</td><td>${pct(s9.excessAvg)}</td><td>${s9.excessWin==null?"—":s9.excessWin.toFixed(1)+"%"}</td><td>${pct(s15.excessAvg)}</td><td>${pct(s20.excessAvg)}</td><td><strong>${v.score==null?"N/A":v.score.toFixed(1)}</strong></td></tr>`}).join("")}
  const horizonBody=document.getElementById("aitElitePerformanceHorizonRows");if(horizonBody){horizonBody.innerHTML=H.map(h=>{const st=stats(all,h);return `<tr><td><strong>${h}D</strong></td><td>${st.n}</td><td>${pct(st.rawAvg)}</td><td>${pct(st.benchAvg)}</td><td>${pct(st.excessAvg)}</td><td>${st.excessWin==null?"—":st.excessWin.toFixed(1)+"%"}</td></tr>`}).join("")}
  lastRenderedSignature=currentSignature;return all;
 }
 let lastObservedSignature="",activeRun=null;
 async function runOnDemand(force=false){
  if(activeRun&&!force)return activeRun;
  activeRun=(async()=>{try{lastObservedSignature=signature();return await render(force)}catch(e){console.error("AIT Elite performance:",e);return []}finally{activeRun=null}})();
  return activeRun;
 }
 document.querySelectorAll('[data-ait-psa-open="aitElitePerformanceModal"]').forEach(button=>{
  button.addEventListener("click",()=>window.AITEliteBusy?.execute?.({kicker:"AIT ELITE PERFORMANCE",title:"Reconstructing performance history",text:"Replaying downloaded OHLC, evaluating rolling windows and measuring calibration health…"},()=>runOnDemand()));
 });
 const storedModelSignature=()=>{try{const v=JSON.parse(localStorage.getItem("ait-psa-elite-model-state-v8")||"null");return v&&typeof v==="object"?String(v.signature||""):""}catch{return ""}};
 async function ensureCurrent(){const current=signature();if(!current||!scannerCodes().length)return false;if(storedModelSignature()!==current){await runOnDemand(false);return true}return false}
 window.AitElitePerformance={rebuild:()=>{try{localStorage.removeItem(KEY)}catch(_){}evaluatedMemoryCache.signature="";evaluatedMemoryCache.built=null;evaluatedMemoryCache.all=null;lastRenderedSignature="";lastObservedSignature="";return runOnDemand(true)},evaluate:async()=>{const x=await evaluatedAsync(false);return x.all},render:runOnDemand,ensureCurrent,currentSignature:signature,storageKey:KEY};
})();
</script>
<script>
(function(){
 const modal=document.getElementById("aitFundamentalsReportModal"),body=document.getElementById("aitFundamentalsReportBody"),search=document.getElementById("aitFundamentalsReportSearch"),count=document.getElementById("aitFundamentalsReportCount"),meta=document.getElementById("aitFundamentalsReportMeta");
 const esc=v=>String(v??"").replace(/[&<>"']/g,m=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"}[m]));
 const rows=()=>{const app=window.app;const store=app&&typeof app.fundamentalStore==="function"?app.fundamentalStore():{};const byCode=new Map();Object.values(store||{}).forEach(r=>{if(!r||typeof r!=="object")return;const clean=app&&typeof app.cleanFundamentalRecord==="function"?app.cleanFundamentalRecord(r):r;const c=String(clean?.code||"").trim().toUpperCase();if(c)byCode.set(c,{...clean,code:c,status:"Saved"})});const active=app&&typeof app.active==="function"?app.active():null;const codes=[...new Set((active?.codes||[]).map(c=>String(c).trim().toUpperCase()).filter(Boolean))];return codes.map(code=>byCode.get(code)||{code,status:"Missing",allFundamentals:{}}).sort((a,b)=>String(a.code).localeCompare(String(b.code)))};
 function render(){const q=String(search?.value||"").trim().toLowerCase();const all=rows();const filtered=all.filter(r=>[r.code,r.companyName,r.category,r.businessSegment,r.yearEnd,r.peRatio,r.eps,r.priceNav,r.freeFloat,r.beta,r.dividendYield].some(v=>String(v||"").toLowerCase().includes(q)));if(count)count.textContent=`${filtered.length} of ${all.length} shown`;if(meta)meta.textContent=all.length?`${all.filter(r=>r.status==="Saved").length} saved of ${all.length} active watch-list codes${window.app?.s?.lastFundamentalDownload?` • Last download ${new Date(window.app.s.lastFundamentalDownload).toLocaleString()}`:""}`:"No saved fundamental records were found.";if(body)body.innerHTML=filtered.length?filtered.map(r=>`<tr><td><b>${esc(r.code)}</b></td><td>${esc(r.companyName||"—")}</td><td>${esc(r.category||"—")}</td><td>${esc(r.businessSegment||"—")}</td><td>${esc(r.yearEnd||"—")}</td><td>${esc(r.lastAgmDate||"—")}</td><td>${esc(r.peRatio??"—")}</td><td>${esc(r.eps??"—")}</td><td>${esc(r.priceNav??"—")}</td><td>${esc(r.freeFloat==null?"—":`${r.freeFloat}%`)}</td><td>${esc(r.beta??"—")}</td><td>${esc(r.dividendYield==null?"—":`${r.dividendYield}%`)}</td><td>${esc(r.status||"Saved")}</td><td>${esc((r.amarstockDownloadedAt||r.downloadedAt)?new Date(r.amarstockDownloadedAt||r.downloadedAt).toLocaleString():"—")}</td></tr>`).join(""):`<tr><td colspan="14" class="ait-fund-report-empty">${all.length?"No fundamentals match the search.":"No fundamentals are stored. Run Download Fundamentals first."}</td></tr>`}
 function open(){render();modal?.classList.add("open");modal?.setAttribute("aria-hidden","false");setTimeout(()=>search?.focus(),50)}
 function close(){modal?.classList.remove("open");modal?.setAttribute("aria-hidden","true")}
 document.getElementById("aitPsaOpenFundamentalsReport")?.addEventListener("click",open);document.getElementById("aitFundamentalsReportClose")?.addEventListener("click",close);document.getElementById("aitFundamentalsReportClear")?.addEventListener("click",()=>{if(search)search.value="";render();search?.focus()});search?.addEventListener("input",render);modal?.addEventListener("click",e=>{if(e.target===modal)close()});document.addEventListener("keydown",e=>{if(e.key==="Escape"&&modal?.classList.contains("open"))close()});window.AITRefreshFundamentalsReport=render;
})();
</script>

<div class="ait-elite-calc-layer" id="aitEliteCalculationLayer" aria-hidden="true" aria-live="polite">
 <div class="ait-elite-calc-card" role="status">
  <div class="ait-elite-calc-orbit"><div class="ait-elite-calc-core">AIT</div></div>
  <div class="ait-elite-calc-kicker" id="aitEliteCalculationKicker">AIT ELITE ENGINE</div>
  <h3 class="ait-elite-calc-title" id="aitEliteCalculationTitle">Calculating Elite signals</h3>
  <p class="ait-elite-calc-text" id="aitEliteCalculationText">Analyzing ranking, confirmation, risk and decision evidence…</p>
  <div class="ait-elite-calc-track"><div class="ait-elite-calc-bar"></div></div>
 </div>
</div>

<script id="ait-scanner-chart-dropdown-script-v10102">
document.addEventListener("DOMContentLoaded",()=>{
 const groups=[...document.querySelectorAll("[data-ait-scanner-charts]")];
 const closeAll=(except=null)=>{
  groups.forEach(group=>{
   if(group===except)return;
   group.classList.remove("is-open");
   const trigger=group.querySelector(".ait-scanner-charts-trigger");
   const menu=group.querySelector(".ait-scanner-charts-menu");
   trigger?.setAttribute("aria-expanded","false");
   if(menu)menu.hidden=true;
  });
 };
 groups.forEach(group=>{
  const trigger=group.querySelector(".ait-scanner-charts-trigger");
  const menu=group.querySelector(".ait-scanner-charts-menu");
  trigger?.addEventListener("click",event=>{
   event.preventDefault();event.stopPropagation();
   const willOpen=!group.classList.contains("is-open");
   closeAll(group);
   group.classList.toggle("is-open",willOpen);
   trigger.setAttribute("aria-expanded",willOpen?"true":"false");
   if(menu)menu.hidden=!willOpen;
  });
  menu?.addEventListener("click",event=>{
   if(event.target.closest("button")){
    group.classList.remove("is-open");
    trigger?.setAttribute("aria-expanded","false");
    menu.hidden=true;
   }
  });
 });
 document.addEventListener("click",()=>closeAll());
 document.addEventListener("keydown",event=>{if(event.key==="Escape")closeAll()});
});
</script>

<script id="ait-scanner-download-dropdown-script-v10108">
document.addEventListener("DOMContentLoaded",()=>{
 const groups=[...document.querySelectorAll("[data-ait-scanner-download]")];
 const closeAll=(except=null)=>{groups.forEach(group=>{if(group===except)return;group.classList.remove("is-open");const trigger=group.querySelector(".ait-scanner-download-trigger");const menu=group.querySelector(".ait-scanner-download-menu");trigger?.setAttribute("aria-expanded","false");if(menu)menu.hidden=true;});};
 const triggerExistingDownload=(action)=>{const id=action==="instant"?"instantDseUpdate":"incrementalOhlcDownload";const target=document.getElementById(id);if(!target)return false;target.click();return true;};
 groups.forEach(group=>{const trigger=group.querySelector(".ait-scanner-download-trigger");const menu=group.querySelector(".ait-scanner-download-menu");trigger?.addEventListener("click",event=>{event.preventDefault();event.stopPropagation();const willOpen=!group.classList.contains("is-open");closeAll(group);group.classList.toggle("is-open",willOpen);trigger.setAttribute("aria-expanded",willOpen?"true":"false");if(menu)menu.hidden=!willOpen;});menu?.addEventListener("click",event=>{const button=event.target.closest("[data-ait-scanner-download-action]");if(!button)return;event.preventDefault();event.stopPropagation();const action=button.dataset.aitScannerDownloadAction;group.classList.remove("is-open");trigger?.setAttribute("aria-expanded","false");menu.hidden=true;triggerExistingDownload(action);});});
 document.addEventListener("click",()=>closeAll());document.addEventListener("keydown",event=>{if(event.key==="Escape")closeAll()});
});
</script>
<script type="module" src="assets/js/ait-sortable-filterable-table.js"></script>
<script src="assets/js/ait-elite-horizons.js"></script>
<script src="assets/js/ait-elite-performance-compare.js"></script>
</body>
</html>
