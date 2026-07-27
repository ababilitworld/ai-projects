<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Ababil DSE Market Intelligence Terminal v10</title>
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
.lists{display:grid;gap:8px;margin-top:13px}.list{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:6px;align-items:center;padding:9px;border:1px solid var(--line);border-radius:11px}.list.active{background:#ccfbf1;border-color:var(--primary)}.select-list{border:0;background:none;text-align:left;min-width:0}.list-name{font-weight:900;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block}.actions{display:flex;gap:5px;flex-wrap:wrap}
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

</style>

<script>
try{
 const saved=JSON.parse(localStorage.getItem("ababil-dse-v10-theme"));
 document.documentElement.dataset.theme=saved||"dark-glass";
}catch{document.documentElement.dataset.theme="dark-glass"}
</script>

</head>
<body>
<div class="v10-mobile-bar">
 <button class="btn soft" type="button" id="v10OpenDrawer" aria-label="Open watch-list drawer">☰</button>
 <div class="v10-mobile-title">
  <strong>Ababil DSE Terminal</strong>
  <span>Mobile market workspace</span>
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
    <button type="button" data-proxy="motherImport">Import mother codes</button>
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
    <button type="button" data-proxy="exportBtn">Backup dashboard</button>
    <button type="button" data-proxy="importBtn">Restore dashboard</button>
   </div>
  </div>
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
  <div>
   <div class="v9-title">Ababil Market Intelligence Terminal</div>
   <div class="v9-sub">Watch lists, DSE archive sync, local OHLC history and interactive candlestick analysis</div>
  </div>
 </div>
 <div class="v9-state"><span class="v9-dot"></span> Local terminal ready</div>
</div>
<div class="v9-quick-grid">
 <div class="v9-stat"><span>Active workspace</span><strong id="v9ActiveList">Watch list</strong></div>
 <div class="v9-stat"><span>Tracked securities</span><strong id="v9TrackedCodes">0 codes</strong></div>
 <div class="v9-stat"><span>Saved OHLC records</span><strong id="v9SavedRecords">0 records</strong></div>
 <div class="v9-stat"><span>Archive engine</span><strong id="v9ArchiveState">Ready</strong></div>
</div>

<div class="app">
<header><div><h1>DSE Watch List Dashboard</h1><p>Premium DSE market intelligence workspace with watch lists, archive sync, OHLC storage and interactive charts.</p></div><div class="badge"><strong id="lastArchive">Never</strong><span>Last archive import</span></div></header>
<section class="stats" id="overviewWorkspace">
 <div class="card stat"><label>Mother Codes</label><strong id="sMother">0</strong></div>
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
<section class="card" id="downloadStatusCard" data-v10-workspace="downloadWorkspace" style="display:none;margin-bottom:14px">
 <div class="row" style="align-items:center;gap:12px">
  <div style="flex:1;min-width:220px">
   <div style="display:flex;justify-content:space-between;gap:12px;align-items:center">
    <strong id="downloadStatusTitle">Preparing download</strong>
    <span class="small" id="downloadStatusPercent">0%</span>
   </div>
   <div style="height:10px;background:#e5e7eb;border-radius:999px;overflow:hidden;margin-top:8px">
    <div id="downloadStatusBar" style="height:100%;width:0%;background:#2563eb;transition:width .25s ease"></div>
   </div>
   <div class="small" id="downloadStatusText" style="margin-top:8px">Waiting to start…</div>
  </div>
  <button class="btn soft" type="button" id="hideDownloadStatus">Hide</button>
 </div>
</section>

<section class="card toolbar v10-original-toolbar">
 <input class="input search" id="search" placeholder="Search trading codes...">
 <button class="btn primary" id="motherImport">Import Mother Codes</button>
 <button class="btn blue" id="quickMotherSync">Sync AmarStock Codes</button>
 <button class="btn blue" id="archiveImport">Import OHLC Archive</button>
 <button class="btn primary" id="dse3mUpdate">Download DSE 3M & View Charts</button>
 <button class="btn primary" id="viewListCharts">View Saved 3M Charts</button>
 <button class="btn soft" id="viewDownloadedData">View Downloaded Data</button>
 <button class="btn soft" id="exportBtn">Backup Dashboard</button>
 <button class="btn soft" id="importBtn">Restore Dashboard</button>
 <span class="small" id="saveStatus" style="align-self:center">Permanent autosave enabled</span>
 <input type="file" id="dashboardFile" accept=".json" hidden>
</section>
<div class="panels" id="marketWorkspace">
 <section class="card panel"><div class="head"><div><h2>Mother Trading-Code List</h2><span class="small" id="motherMeta">Import the mother list first.</span></div></div><div class="scroll" id="mother"></div></section>
 <section class="card panel"><div class="head"><div><h2 id="watchTitle">Watch List</h2><span class="small" id="watchMeta"></span></div><div class="actions"><button class="btn blue" id="dse3mUpdate2">Download DSE 3M</button><button class="btn primary" id="viewListCharts2">View Saved 3M Charts</button></div></div><div class="scroll" id="watch"></div></section>
</div>
</main>
</div>
</div>

<div class="modal" id="listModal"><div class="dialog"><div class="modal-head"><h2 id="listModalTitle">Create Watch List</h2><button class="btn soft icon" data-close="listModal">×</button></div><form class="form" id="listForm"><div class="field"><label>Watch-list name</label><input class="input" style="width:100%" id="listName" required maxlength="60"></div><div class="form-actions"><button type="button" class="btn soft" data-close="listModal">Cancel</button><button class="btn primary">Save</button></div></form></div></div>


<div class="modal" id="motherModal"><div class="dialog">
 <div class="modal-head">
  <div><h2>Import Mother Trading Codes</h2><div class="small">Import the complete listed-security directory from DSE data</div></div>
  <button class="btn soft icon" data-close="motherModal">×</button>
 </div>
 <div class="tabs" data-tab-group="mother">
  <button class="tab active" data-mother-tab="url">DSE Website</button>
  <button class="tab" data-mother-tab="file">Downloaded File</button>
  <button class="tab" data-mother-tab="paste">Paste Table</button>
 </div>

 <div class="tab-panel active" data-mother-panel="url">
  <div class="field">
   <label>Public mother-list source</label>
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
   The dashboard first tries a direct browser request. Website CORS rules may block it even though the page opens normally. Your permanent watch lists are never replaced or deleted by mother-list synchronization.
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
  <button class="btn primary" type="button" id="replaceMother">Replace Mother List</button>
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
   PHP cURL downloads the DSE archive server-side, saves normalized CSV files, and returns records to this dashboard.
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
 <div class="gallery" id="gallery"></div>
</div></div>


<div class="modal" id="dataModal"><div class="dialog wide">
 <div class="modal-head"><div><h2>Downloaded DSE Data</h2><span class="small" id="dataSummary">No data loaded</span></div><button class="btn soft icon" data-close="dataModal">×</button></div>
 <div style="overflow:auto"><table style="width:100%;border-collapse:collapse" id="dataTable"><thead><tr><th>Code</th><th>Date</th><th>Open</th><th>High</th><th>Low</th><th>Close</th><th>Volume</th></tr></thead><tbody></tbody></table></div>
</div></div>

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
class Store{
 static KEY="dse-watch-dashboard-v3";
 load(){try{const d=JSON.parse(localStorage.getItem(Store.KEY));if(d&&d.watchLists)return this.norm(d)}catch(e){}const id=ID.make();return{motherCodes:[],motherSource:"",lastMotherImport:null,autoMotherSync:true,watchLists:[{id,name:"My DSE Watch List",codes:[]}],activeId:id,history:{},activity:[],lastArchive:null}}
 norm(d){d.motherCodes=Array.isArray(d.motherCodes)?[...new Set(d.motherCodes.map(x=>String(x).toUpperCase()))].sort():[];d.history=d.history&&typeof d.history==="object"?d.history:{};d.motherSource=String(d.motherSource||"");d.lastMotherImport=d.lastMotherImport||null;d.autoMotherSync=d.autoMotherSync!==false;d.activity=Array.isArray(d.activity)?d.activity:[];if(!d.watchLists?.length){const id=ID.make();d.watchLists=[{id,name:"My DSE Watch List",codes:[]}];d.activeId=id}if(!d.watchLists.some(x=>x.id===d.activeId))d.activeId=d.watchLists[0].id;return d}
 save(d){localStorage.setItem(Store.KEY,JSON.stringify(d))}
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
  const rect=canvas.getBoundingClientRect(),dpr=devicePixelRatio||1;canvas.width=Math.max(600,rect.width*dpr);canvas.height=Math.max(300,rect.height*dpr);const ctx=canvas.getContext("2d");ctx.scale(dpr,dpr);const W=canvas.width/dpr,H=canvas.height/dpr;ctx.clearRect(0,0,W,H);
  if(!data.length){ctx.fillStyle="#64748b";ctx.font="15px system-ui";ctx.textAlign="center";ctx.fillText("No OHLC records available for this period.",W/2,H/2);return}
  const margin={l:60,r:18,t:18,b:55},volH=80,priceBottom=H-margin.b-volH,gW=W-margin.l-margin.r,pH=priceBottom-margin.t;const min=Math.min(...data.map(x=>x.low)),max=Math.max(...data.map(x=>x.high)),range=Math.max(.01,max-min),maxVol=Math.max(1,...data.map(x=>x.volume||0));
  const y=p=>margin.t+(max-p)/range*pH,x=i=>margin.l+(i+.5)*gW/data.length,cw=Math.max(2,Math.min(11,gW/data.length*.62));
  ctx.strokeStyle="#e2e8f0";ctx.lineWidth=1;ctx.fillStyle="#64748b";ctx.font="11px system-ui";ctx.textAlign="right";
  for(let i=0;i<=5;i++){const yy=margin.t+i*pH/5,price=max-i*range/5;ctx.beginPath();ctx.moveTo(margin.l,yy);ctx.lineTo(W-margin.r,yy);ctx.stroke();ctx.fillText(price.toFixed(2),margin.l-7,yy+4)}
  const step=Math.max(1,Math.ceil(data.length/6));ctx.textAlign="center";for(let i=0;i<data.length;i+=step){ctx.fillText(data[i].date.slice(5),x(i),H-18)}
  data.forEach((d,i)=>{const up=d.close>=d.open,col=up?"#15803d":"#dc2626",xx=x(i);ctx.strokeStyle=col;ctx.fillStyle=col;ctx.beginPath();ctx.moveTo(xx,y(d.high));ctx.lineTo(xx,y(d.low));ctx.stroke();const top=y(Math.max(d.open,d.close)),bottom=y(Math.min(d.open,d.close));ctx.fillRect(xx-cw/2,top,cw,Math.max(1,bottom-top));const vh=(d.volume||0)/maxVol*(volH-15);ctx.globalAlpha=.35;ctx.fillRect(xx-cw/2,H-margin.b-vh,cw,vh);ctx.globalAlpha=1});
  ctx.strokeStyle="#cbd5e1";ctx.strokeRect(margin.l,margin.t,gW,pH);
 }
}
class App{
 constructor(){this.store=new Store();this.s=this.store.load();this.editId=null;this.pending={};this.pendingMother=[];this.pendingMotherSource="";this.currentCode=null;this.searchTerm=""}
 init(){["lastArchive","sMother","sLists","sHistory","sRecords","lists","activity","newList","clearActivity","search","motherImport","quickMotherSync","saveStatus","motherModal","motherSourceSelect","motherUrl","autoMotherSync","openMotherSource","fetchMother","motherFiles","parseMotherFiles","motherPaste","parseMotherPaste","motherResult","motherCommitArea","mergeMother","replaceMother","archiveImport","dse3mUpdate","dse3mUpdate2","viewListCharts","viewListCharts2","downloadStatusCard","downloadStatusTitle","downloadStatusPercent","downloadStatusBar","downloadStatusText","hideDownloadStatus","viewDownloadedData","exportBtn","importBtn","dashboardFile","mother","motherMeta","watch","watchTitle","watchMeta","listModal","listModalTitle","listForm","listName","archiveModal","dseStartDate","dseEndDate","fetchDseRange","downloadDseCsv","ohlcFiles","parseFiles","pasteOhlc","parsePaste","archiveUrl","urlCode","fetchUrl","parseResult","commitArea","mergeHistory","replaceHistory","chartModal","chartTitle","chartSubtitle","chartRange","downloadChart","chartCanvas","chartInfo","galleryModal","galleryTitle","gallery","dataModal","dataSummary","dataTable","toasts"].forEach(id=>this[id]=document.getElementById(id));this.bind();this.setDefaultDseDates();this.render();setTimeout(()=>this.maybeAutoSync(),500)}
 bind(){this.newList.onclick=()=>this.openList();this.listForm.onsubmit=e=>this.saveList(e);this.clearActivity.onclick=()=>{this.s.activity=[];this.persist();this.renderActivity()};this.search.oninput=e=>{this.searchTerm=e.target.value.trim().toUpperCase();this.renderMother();this.renderWatch()};this.motherImport.onclick=()=>{this.autoMotherSync.checked=this.s.autoMotherSync!==false;this.open("motherModal")};
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
this.archiveImport.onclick=()=>this.open("archiveModal");
this.dse3mUpdate.onclick=this.dse3mUpdate2.onclick=()=>this.downloadActiveWatchlist3M();
this.fetchDseRange.onclick=()=>this.fetchDseArchive(this.dseStartDate.value,this.dseEndDate.value,false,false);
this.downloadDseCsv.onclick=()=>{
 if(!this.dseStartDate.value||!this.dseEndDate.value)return this.toast("Select dates first.",true);
 const p=new URLSearchParams({startDate:this.dseStartDate.value,endDate:this.dseEndDate.value,format:"csv"});
 window.location.href="dse_archive.php?"+p.toString()
};
this.viewListCharts.onclick=this.viewListCharts2.onclick=()=>this.openGallery();this.viewDownloadedData.onclick=()=>this.openDataPreview();this.parseFiles.onclick=()=>this.readFiles();this.parsePaste.onclick=()=>this.prepare(Parser.parse(this.pasteOhlc.value),"Pasted archive");this.fetchUrl.onclick=()=>this.fetchArchive();this.mergeHistory.onclick=()=>this.commit(false);this.replaceHistory.onclick=()=>this.commit(true);this.chartRange.onchange=()=>this.drawCurrent();this.downloadChart.onclick=()=>{const a=document.createElement("a");a.href=this.chartCanvas.toDataURL("image/png");a.download=`${this.currentCode||"DSE"}-candlestick.png`;a.click()};this.exportBtn.onclick=()=>this.export();this.importBtn.onclick=()=>this.dashboardFile.click();this.dashboardFile.onchange=e=>this.import(e);document.querySelectorAll("[data-close]").forEach(b=>b.onclick=()=>this.close(b.dataset.close));document.querySelectorAll(".modal").forEach(m=>m.onclick=e=>{if(e.target===m)this.close(m.id)});document.querySelectorAll("[data-tab]").forEach(b=>b.onclick=()=>this.tab(b.dataset.tab));
document.querySelectorAll("[data-mother-tab]").forEach(b=>b.onclick=()=>this.motherTab(b.dataset.motherTab));window.addEventListener("resize",()=>{if(this.chartModal.classList.contains("open"))this.drawCurrent()})}
 active(){return this.s.watchLists.find(x=>x.id===this.s.activeId)||this.s.watchLists[0]}persist(){this.store.save(this.s);if(this.saveStatus){this.saveStatus.textContent="Saved permanently at "+new Date().toLocaleTimeString();clearTimeout(this._saveTimer);this._saveTimer=setTimeout(()=>this.saveStatus.textContent="Permanent autosave enabled",2200)}}
 updatePremiumDashboard(){
  const active=this.active?.();
  const codes=active?.codes||[];
  const history=this.s?.history||{};
  const records=Object.values(history).reduce((sum,rows)=>sum+(Array.isArray(rows)?rows.length:0),0);
  const a=document.getElementById("v9ActiveList");
  const b=document.getElementById("v9TrackedCodes");
  const c=document.getElementById("v9SavedRecords");
  const d=document.getElementById("v9ArchiveState");
  if(a)a.textContent=active?.name||"Watch list";
  if(b)b.textContent=`${codes.length.toLocaleString()} codes`;
  if(c)c.textContent=`${records.toLocaleString()} records`;
  if(d)d.textContent=records?"Synced":"Ready";
 }
 render(){
  setTimeout(()=>this.updatePremiumDashboard(),0);this.renderStats();this.renderLists();this.renderMother();this.renderWatch();this.renderActivity()}
 renderStats(){const rc=Object.values(this.s.history).reduce((n,a)=>n+a.length,0);this.sMother.textContent=this.s.motherCodes.length;this.sLists.textContent=this.s.watchLists.length;this.sHistory.textContent=Object.keys(this.s.history).length;this.sRecords.textContent=rc.toLocaleString();this.lastArchive.textContent=this.s.lastArchive?new Date(this.s.lastArchive).toLocaleString():"Never"}
 renderLists(){this.lists.innerHTML=this.s.watchLists.map(l=>`<div class="list ${l.id===this.s.activeId?"active":""}"><button class="select-list" data-la="select" data-id="${l.id}"><span class="list-name">${this.esc(l.name)}</span><span class="small">${l.codes.length} codes</span></button><div class="actions"><button class="btn blue icon" title="View all 3M charts" data-la="charts" data-id="${l.id}">▥</button><button class="btn soft icon" data-la="edit" data-id="${l.id}">✎</button><button class="btn soft icon" data-la="delete" data-id="${l.id}">🗑</button></div></div>`).join("");this.lists.querySelectorAll("[data-la]").forEach(b=>b.onclick=()=>this.listAction(b.dataset.la,b.dataset.id))}
 renderMother(){const a=this.active(),arr=this.s.motherCodes.filter(c=>c.includes(this.searchTerm));this.motherMeta.textContent=`${arr.length} of ${this.s.motherCodes.length} codes${this.s.motherSource?" • "+this.s.motherSource:""}`;this.mother.innerHTML=arr.length?arr.map(c=>`<div class="code-row"><div><span class="code">${c}</span><span class="meta">${this.s.history[c]?.length||0} OHLC records</span></div><div class="actions">${this.s.history[c]?.length?`<button class="btn blue" data-chart="${c}">3M Chart</button>`:""}<button class="btn ${a.codes.includes(c)?"soft":"primary"}" data-add="${c}" ${a.codes.includes(c)?"disabled":""}>${a.codes.includes(c)?"Added":"+ Add"}</button></div></div>`).join(""):`<div class="empty">No mother codes. Import codes or OHLC archive data.</div>`;this.mother.querySelectorAll("[data-add]").forEach(b=>b.onclick=()=>this.add(b.dataset.add));this.mother.querySelectorAll("[data-chart]").forEach(b=>b.onclick=()=>this.openChart(b.dataset.chart))}
 renderWatch(){const a=this.active(),arr=a.codes.filter(c=>c.includes(this.searchTerm));this.watchTitle.textContent=a.name;this.watchMeta.textContent=`${arr.length} of ${a.codes.length} codes`;this.watch.innerHTML=arr.length?arr.map(c=>`<div class="code-row"><div><span class="code">${c}</span><span class="meta">${this.s.history[c]?.length||0} OHLC records</span></div><div class="actions"><button class="btn blue" data-chart="${c}" ${this.s.history[c]?.length?"":"disabled"}>3M Chart</button><button class="btn red" data-remove="${c}">Remove</button></div></div>`).join(""):`<div class="empty">Add trading codes from the mother list.</div>`;this.watch.querySelectorAll("[data-chart]").forEach(b=>b.onclick=()=>this.openChart(b.dataset.chart));this.watch.querySelectorAll("[data-remove]").forEach(b=>b.onclick=()=>this.remove(b.dataset.remove))}
 renderActivity(){this.activity.innerHTML=this.s.activity.length?this.s.activity.slice(0,8).map(x=>`<div><strong>${this.esc(x.m)}</strong><span>${new Date(x.at).toLocaleString()}</span></div>`).join(""):`<span class="small">No activity.</span>`}
 listAction(act,id){const l=this.s.watchLists.find(x=>x.id===id);if(!l)return;if(act==="select"){this.s.activeId=id;this.persist();this.render()}else if(act==="charts"){this.s.activeId=id;this.persist();this.render();this.openGallery()}else if(act==="edit")this.openList(l);else if(act==="delete"){if(this.s.watchLists.length===1)return this.toast("At least one list must remain.",true);if(confirm(`Delete "${l.name}"?`)){this.s.watchLists=this.s.watchLists.filter(x=>x.id!==id);if(this.s.activeId===id)this.s.activeId=this.s.watchLists[0].id;this.log(`Deleted watch list ${l.name}`);this.persist();this.render()}}}
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
    if(!silent)this.toast(`Synced ${codes.length} mother codes.`);
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
  if(ok)this.toast("Daily AmarStock mother list synchronized.")
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
   ?`Found ${this.pendingMother.length} unique trading codes. Merge them or replace the current mother list.`
   :"No valid trading codes were detected.";
  this.motherCommitArea.style.display=this.pendingMother.length?"flex":"none"
 }
 commitMother(replace,silent=false){
  if(!this.pendingMother.length)return;
  this.s.motherCodes=replace?[...this.pendingMother]:[...new Set([...this.s.motherCodes,...this.pendingMother])].sort();
  this.s.motherSource=this.pendingMotherSource;
  this.s.lastMotherImport=new Date().toISOString();
  this.log(`${replace?"Replaced":"Merged"} mother list with ${this.pendingMother.length} codes`);
  this.persist();if(!silent)this.close("motherModal");this.render();
  if(!silent)this.toast(`Mother list saved with ${this.s.motherCodes.length} codes.`)
 }
 showDownloadStatus(title,text,percent=0,state="working"){
  this.downloadStatusCard.style.display="block";
  this.downloadStatusTitle.textContent=(state==="success"?"✓ ":state==="error"?"⚠ ":"◉ ")+title;
  this.downloadStatusText.textContent=text;
  this.downloadStatusPercent.textContent=`${Math.max(0,Math.min(100,Math.round(percent)))}%`;
  this.downloadStatusBar.style.width=`${Math.max(0,Math.min(100,percent))}%`;
  this.downloadStatusBar.style.background=state==="success"?"#16a34a":state==="error"?"#dc2626":"#2563eb";
 }
 completeDownloadStatus(text){
  this.showDownloadStatus("Download completed",text,100,"success");
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
 dseApiUrl(start,end){
  const p=new URLSearchParams({startDate:start,endDate:end,format:"json",v:"7"});
  return "dse_archive.php?"+p.toString()
 }
 async fetchDseArchive(start,end,watchOnly=true,openCharts=false){
  if(!start||!end)return this.toast("Select DSE start and end dates.",true);
  if(start>end)return this.toast("Start date must be before end date.",true);

  const activeCodes=watchOnly?this.active().codes:[];
  if(watchOnly&&!activeCodes.length)return this.toast("The active watch list is empty.",true);

  const startedAt=Date.now();
  this.showDownloadStatus(
   "Preparing DSE download",
   `Date range: ${start} to ${end}`,
   5
  );

  try{
   this.showDownloadStatus(
    "Downloading DSE archive",
    "PHP cURL is downloading and combining archive chunks. Please keep this page open.",
    20
   );

   const r=await fetch(this.dseApiUrl(start,end),{
    headers:{Accept:"application/json"},
    cache:"no-store"
   });

   this.showDownloadStatus(
    "Reading server response",
    "The download finished. Reading the parsed archive data…",
    60
   );

   const rawText=await r.text();
   let payload=null;
   try{
    payload=JSON.parse(rawText);
   }catch(parseError){
    throw new Error(`Server returned invalid JSON: ${rawText.slice(0,180)}`);
   }

   if(!r.ok||!payload?.success){
    throw new Error(payload?.message||`HTTP ${r.status}`);
   }

   this.showDownloadStatus(
    "Matching watch-list codes",
    `Server parsed ${payload.symbolCount||0} symbols and ${payload.recordCount||0} records.`,
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
    requested:[...activeCodes],
    matched:Object.keys(parsed),
    missing,
    totalServerSymbols:Object.keys(normalizedAll).length,
    records:count,
    csvFile:payload.csvFile||"",
    elapsedMs:Date.now()-startedAt
   };

   if(!count){
    const examples=Object.keys(normalizedAll).slice(0,25).join(", ");
    throw new Error(`DSE parsed ${Object.keys(normalizedAll).length} symbols, but none matched this watch list. Available examples: ${examples}`);
   }

   this.showDownloadStatus(
    "Saving downloaded data",
    `Saving ${count} records for ${Object.keys(parsed).length} watch-list codes…`,
    90
   );

   this.pending=parsed;
   this.pendingSource=`DSE PHP cURL cache: ${payload.csvFile||"saved CSV"}`;
   this.commit(false,true);

   const seconds=Math.max(1,Math.round((Date.now()-startedAt)/1000));
   const missingText=missing.length?` Missing: ${missing.join(", ")}.`:"";
   const finalText=`Completed in ${seconds}s. Saved ${count} records for ${Object.keys(parsed).length} codes.${missingText}`;
   this.completeDownloadStatus(finalText);
   this.updatePremiumDashboard();
   this.toast(finalText);

   if(openCharts){
    setTimeout(()=>this.openGallery(),250);
   }
   return true
  }catch(e){
   console.error(e);
   const message=e?.message||String(e);
   this.failDownloadStatus(message);
   this.toast(`DSE PHP download failed: ${message}`,true);
   return false
  }
 }
 async downloadActiveWatchlist3M(){
  const a=this.active();
  if(!a.codes.length)return this.toast("The active watch list is empty.",true);
  const end=new Date(),start=new Date(end);
  start.setMonth(start.getMonth()-3);
  const iso=d=>d.toISOString().slice(0,10);
  this.dseStartDate.value=iso(start);
  this.dseEndDate.value=iso(end);
  await this.fetchDseArchive(iso(start),iso(end),true,true)
 }
 async readFiles(){const files=[...this.ohlcFiles.files];if(!files.length)return this.toast("Select archive files.",true);let all={};for(const f of files){const code=Parser.cleanCode(f.name.replace(/\.[^.]+$/,""));const parsed=Parser.parse(await f.text(),files.length>1?code:"");Object.entries(parsed).forEach(([c,r])=>(all[c]??=[]).push(...r))}this.prepare(all,files.map(f=>f.name).join(", "))}
 async fetchArchive(){const url=this.archiveUrl.value.trim();if(!url)return this.toast("Enter an archive URL.",true);try{const r=await fetch(url);if(!r.ok)throw Error();this.prepare(Parser.parse(await r.text(),Parser.cleanCode(this.urlCode.value)),url)}catch(e){this.toast("Archive download was blocked. Download the file manually and import it.",true)}}
 prepare(data,source){Object.keys(data).forEach(c=>{const m=new Map(data[c].map(x=>[x.date,x]));data[c]=[...m.values()].sort((a,b)=>a.date.localeCompare(b.date))});this.pending=data;const sy=Object.keys(data).length,rc=Object.values(data).reduce((n,a)=>n+a.length,0);this.parseResult.style.display="block";this.parseResult.textContent=sy?`Parsed ${rc.toLocaleString()} OHLC records for ${sy} trading codes from ${source}.`:"No valid OHLC rows detected.";this.commitArea.style.display=sy?"flex":"none"}
 commit(replace,silent=false){if(replace)this.s.history={};for(const [c,r] of Object.entries(this.pending)){const old=replace?[]:(this.s.history[c]||[]);const m=new Map([...old,...r].map(x=>[x.date,x]));this.s.history[c]=[...m.values()].sort((a,b)=>a.date.localeCompare(b.date));if(!this.s.motherCodes.includes(c))this.s.motherCodes.push(c)}this.s.motherCodes=[...new Set(this.s.motherCodes)].sort();this.s.lastArchive=new Date().toISOString();this.s.lastArchiveSource=this.pendingSource||"Imported archive";this.log(`${replace?"Replaced":"Merged"} OHLC archive data`);this.persist();if(!silent)this.close("archiveModal");this.render();if(!silent)this.toast("Historical archive saved locally.")}
 openChart(code){this.currentCode=code;this.chartTitle.textContent=`${code} Candlestick Chart`;this.open("chartModal");setTimeout(()=>this.drawCurrent(),50)}
 rangeData(code,months){const a=this.s.history[code]||[];if(!a.length)return[];const last=new Date(a[a.length-1].date+"T00:00:00"),cut=new Date(last);cut.setMonth(cut.getMonth()-months);return a.filter(x=>new Date(x.date+"T00:00:00")>=cut)}
 drawCurrent(){const data=this.rangeData(this.currentCode,Number(this.chartRange.value));CandleChart.draw(this.chartCanvas,data);if(data.length){const f=data[0],l=data[data.length-1],chg=(l.close/f.close-1)*100;this.chartSubtitle.textContent=`${data.length} sessions • ${f.date} to ${l.date}`;this.chartInfo.innerHTML=`<span>Open: <b>${f.open.toFixed(2)}</b></span><span>Last close: <b>${l.close.toFixed(2)}</b></span><span>Change: <b>${chg.toFixed(2)}%</b></span><span>Total volume: <b>${data.reduce((n,x)=>n+x.volume,0).toLocaleString()}</b></span>`}else{this.chartSubtitle.textContent="No local OHLC data";this.chartInfo.innerHTML=""}}
 openGallery(){
  const a=this.active();
  this.galleryTitle.textContent=`${a.name} — 3M Charts`;
  this.gallery.innerHTML="";
  this.open("galleryModal");
  if(!a.codes.length){this.gallery.innerHTML=`<div class="empty">This watch list is empty.</div>`;return}
  requestAnimationFrame(()=>{
   a.codes.forEach(c=>{
    const data=this.rangeData(c,3);
    const card=document.createElement("div");card.className="mini-card";
    card.innerHTML=`<div class="row"><h3>${this.esc(c)}</h3><button class="btn blue" data-open="${c}" ${data.length?"":"disabled"}>Open</button></div><div class="chart-box mini-chart"><canvas></canvas></div><div class="small">${data.length?`${data.length} sessions • ${data[0].date} to ${data[data.length-1].date}`:"No archive data for this code"}</div>`;
    this.gallery.appendChild(card);
    requestAnimationFrame(()=>CandleChart.draw(card.querySelector("canvas"),data));
    card.querySelector("[data-open]").onclick=()=>{this.close("galleryModal");this.openChart(c)}
   })
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
 export(){const b=new Blob([JSON.stringify(this.s,null,2)],{type:"application/json"}),a=document.createElement("a");a.href=URL.createObjectURL(b);a.download=`dse-permanent-dashboard-backup-${new Date().toISOString().slice(0,10)}.json`;a.click();URL.revokeObjectURL(a.href)}
 async import(e){const f=e.target.files[0];if(!f)return;try{this.s=this.store.norm(JSON.parse(await f.text()));this.persist();this.render();this.toast("Permanent dashboard backup restored.")}catch(x){this.toast("Invalid dashboard file.",true)}e.target.value=""}
 log(m){this.s.activity.unshift({m,at:new Date().toISOString()});this.s.activity=this.s.activity.slice(0,30)}
 open(id){document.getElementById(id).classList.add("open");document.body.style.overflow="hidden"}close(id){document.getElementById(id).classList.remove("open");document.body.style.overflow=""}
 toast(m,e=false){const d=document.createElement("div");d.className="toast"+(e?" error":"");d.textContent=m;this.toasts.appendChild(d);setTimeout(()=>d.remove(),3000)}esc(v){const d=document.createElement("div");d.textContent=String(v);return d.innerHTML}
}
document.addEventListener("DOMContentLoaded",()=>new App().init());

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
  if(name==="downloadWorkspace")target=document.getElementById("downloadStatusCard")||document.querySelector(".v10-original-toolbar");
  target?.scrollIntoView({behavior:"smooth",block:"start"});
 }
 document.querySelectorAll("[data-v10-scroll]").forEach(button=>{
  button.addEventListener("click",()=>{
   scrollToTarget(button.dataset.v10Scroll);
   menus.forEach(menu=>menu.classList.remove("open"));
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
  document.getElementById("downloadStatusCard"),
  "download","Download center","Live archive progress, completion and errors",true
 );
 makeCollapsible(
  document.getElementById("marketWorkspace"),
  "market","Trading-code workspace","Mother directory and active watch-list securities",true
 );

 // Individual watch-list and mother panels become collapsible too.
 const marketPanels=[...document.querySelectorAll("#marketWorkspace > .panel")];
 marketPanels.forEach((panel,index)=>{
  makeCollapsible(
   panel,
   index===0?"mother-panel":"watch-panel",
   index===0?"Mother trading-code directory":"Active watch list",
   index===0?"Browse the complete security directory":"Operate selected securities and charts",
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

</script>
</body>
</html>