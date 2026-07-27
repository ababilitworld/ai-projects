<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Ababil DSE Market Intelligence Terminal v11.8</title>
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
.v11-signal.buy{background:color-mix(in srgb,var(--v10-success) 14%,transparent);color:var(--v10-success)}
.v11-signal.watch{background:color-mix(in srgb,var(--v10-warning) 14%,transparent);color:var(--v10-warning)}
.v11-signal.avoid{background:color-mix(in srgb,var(--v10-danger) 14%,transparent);color:var(--v10-danger)}
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

.chart-container,
.chart-wrap,
.chart-panel,
.chart-box,
.chart-area,
.chart-canvas-wrap,
.modal .chart-container,
.modal .chart-wrap,
#chart,
#charts,
[id*="chart" i],
[class*="chart-" i]{
 background:var(--v116-chart-bg)!important;
 border-color:var(--v116-chart-border)!important;
}

.chart-container canvas,
.chart-wrap canvas,
.chart-panel canvas,
.chart-box canvas,
.chart-area canvas,
.modal canvas,
canvas[id*="chart" i],
canvas[class*="chart" i]{
 background:var(--v116-chart-plot)!important;
 border-radius:10px;
}

.chart-container svg,
.chart-wrap svg,
.chart-panel svg,
.chart-box svg,
.chart-area svg,
.modal svg{
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

<section class="v11-shell" id="v11Terminal">
 <nav class="v11-tabs" aria-label="Trading terminal workspaces">
  <button class="v11-tab active" type="button" data-v11-tab="charts">Charts</button>
  <button class="v11-tab" type="button" data-v11-tab="indicators">Indicators</button>
  <button class="v11-tab" type="button" data-v11-tab="comparison">Comparison</button>
  <button class="v11-tab" type="button" data-v11-tab="portfolio">Portfolio</button>
  <button class="v11-tab" type="button" data-v11-tab="vpa">VPA</button>
  <button class="v11-tab" type="button" data-v11-tab="explorer">Explorer</button>
  <button class="v11-tab" type="button" data-v11-tab="reports">Reports</button>
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
  <div class="v11-grid two">
   <article class="v11-card">
    <div class="v11-card-head"><div><h3>Technical indicator scanner</h3><small>SMA, RSI, momentum and volume diagnostics</small></div><button class="btn primary" id="v11RunScanner" type="button">Run scanner</button></div>
    <div class="v11-card-body">
     <div class="v11-table-wrap"><table class="v11-table"><thead><tr><th>Code</th><th>Close</th><th>SMA20</th><th>SMA50</th><th>RSI14</th><th>Momentum</th><th>Signal</th></tr></thead><tbody id="v11IndicatorRows"></tbody></table></div>
    </div>
   </article>
   <aside class="v11-card">
    <div class="v11-card-head"><div><h3>Scanner guidance</h3><small>How signals are formed</small></div></div>
    <div class="v11-card-body">
     <div class="v11-chip-row"><span class="v11-chip">Close above SMA20</span><span class="v11-chip">SMA20 above SMA50</span><span class="v11-chip">RSI 45–70</span><span class="v11-chip">Positive momentum</span></div>
     <div class="v11-note" style="margin-top:10px">These signals are mechanical summaries, not investment advice.</div>
    </div>
   </aside>
  </div>
 </section>

 <section class="v11-workspace" data-v11-workspace="comparison">
  <article class="v11-card">
   <div class="v11-card-head">
    <div><h3>Stock comparison</h3><small>Compare price, return, volatility and relative volume</small></div>
    <button class="btn primary" type="button" id="v11RunComparison">Compare active list</button>
   </div>
   <div class="v11-card-body">
    <div class="v11-summary-grid">
     <div class="v11-summary"><span>Best return</span><strong id="v11BestReturn">—</strong></div>
     <div class="v11-summary"><span>Lowest volatility</span><strong id="v11LowVol">—</strong></div>
     <div class="v11-summary"><span>Highest relative volume</span><strong id="v11HighRv">—</strong></div>
     <div class="v11-summary"><span>Strongest momentum</span><strong id="v11Momentum">—</strong></div>
    </div>
    <div class="v11-table-wrap" style="margin-top:10px"><table class="v11-table"><thead><tr><th>Code</th><th>Last close</th><th>20D return</th><th>Volatility</th><th>Relative volume</th><th>Momentum</th></tr></thead><tbody id="v11ComparisonRows"></tbody></table></div>
   </div>
  </article>
 </section>

 <section class="v11-workspace" data-v11-workspace="portfolio">
  <div class="v11-grid two">
   <article class="v11-card">
    <div class="v11-card-head"><div><h3>Portfolio workspace</h3><small>Track positions locally in this browser</small></div></div>
    <div class="v11-card-body">
     <div class="v11-portfolio-form">
      <label>Code<select id="v11PortfolioCode"></select></label>
      <label>Quantity<input id="v11PortfolioQty" type="number" min="0" step="1"></label>
      <label>Buy price<input id="v11PortfolioBuy" type="number" min="0" step="0.01"></label>
      <button class="btn primary" type="button" id="v11AddPosition">Add position</button>
     </div>
     <div class="v11-table-wrap"><table class="v11-table"><thead><tr><th>Code</th><th>Qty</th><th>Buy</th><th>Last</th><th>Cost</th><th>Value</th><th>P/L</th><th></th></tr></thead><tbody id="v11PortfolioRows"></tbody></table></div>
    </div>
   </article>
   <aside class="v11-card">
    <div class="v11-card-head"><div><h3>Portfolio summary</h3><small>Calculated from downloaded closing prices</small></div></div>
    <div class="v11-card-body">
     <div class="v11-summary-grid">
      <div class="v11-summary"><span>Total cost</span><strong id="v11PortfolioCost">0.00</strong></div>
      <div class="v11-summary"><span>Market value</span><strong id="v11PortfolioValue">0.00</strong></div>
      <div class="v11-summary"><span>Unrealized P/L</span><strong id="v11PortfolioPl">0.00</strong></div>
      <div class="v11-summary"><span>Positions</span><strong id="v11PortfolioCount">0</strong></div>
     </div>
    </div>
   </aside>
  </div>
 </section>

 <section class="v11-workspace" data-v11-workspace="vpa">
  <article class="v11-card">
   <div class="v11-card-head"><div><h3>VPA-style analysis workspace</h3><small>Effort-versus-result, spread, volume and trend scoring</small></div><button class="btn primary" id="v11RunVpa" type="button">Analyze active list</button></div>
   <div class="v11-card-body">
    <div class="v11-table-wrap"><table class="v11-table"><thead><tr><th>Code</th><th>Score</th><th>Spread</th><th>Rel. volume</th><th>Trend</th><th>Effort/result</th><th>Classification</th></tr></thead><tbody id="v11VpaRows"></tbody></table></div>
    <div class="v11-note" style="margin-top:10px">The VPA score is a transparent heuristic derived only from locally stored OHLCV data. It does not claim to identify institutional activity with certainty.</div>
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
    <div class="v105-eyebrow">Market operations center</div>
    <h2>Everything important, visible at a glance</h2>
    <p>Download DSE archives, manage watch lists, inspect stored OHLC history and jump to chart analysis without searching through the page.</p>
    <div class="v105-hero-actions">
     <button class="btn primary" type="button" data-proxy="dse3mUpdate">Download 3M data</button>
     <button class="btn soft" type="button" data-proxy="viewListCharts">Open charts</button>
     <button class="btn soft" type="button" id="v105HeroCommand">Search commands</button>
    </div>
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
    <button class="btn soft" type="button" id="v105ClearQueue">Clear</button>
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
    <button class="btn soft" type="button" id="v105ClearActivity">Clear</button>
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
  window.dispatchEvent(new CustomEvent("dse:download-status",{detail:{title,text,percent,state}}));
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
  activities=activities.slice(0,30);
  write(ACTIVITY_KEY,activities);
  renderActivity();
  const last=document.getElementById("v105LastActivity");
  if(last)last.textContent=title;
 }

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
  {icon:"◆",name:"Backup dashboard",detail:"Export terminal configuration and data",keys:"",run:()=>document.getElementById("exportBtn")?.click()},
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
  return Array.isArray(history[code])?history[code]:[];
 };
 const codes=()=>{
  const {state,active,history,lists}=appState();

  const mother=Array.isArray(state?.motherCodes)
   ? state.motherCodes
   : Object.keys(state?.motherCodes||{});

  const activeCodes=Array.isArray(active?.codes)?active.codes:[];

  const allWatchCodes=(Array.isArray(lists)?lists:[])
   .flatMap(list=>Array.isArray(list?.codes)?list.codes:[]);

  return [...new Set([
   ...mother,
   ...activeCodes,
   ...allWatchCodes,
   ...Object.keys(history||{})
  ].map(code=>String(code||"").trim().toUpperCase()).filter(Boolean))].sort();
 };
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
  tabs.forEach(t=>t.classList.toggle("active",t.dataset.v11Tab===name));
  workspaces.forEach(w=>w.classList.toggle("active",w.dataset.v11Workspace===name));
  try{localStorage.setItem(ACTIVE_TAB_KEY,JSON.stringify(name))}catch{}
  document.getElementById("v11Terminal")?.scrollIntoView({behavior:"smooth",block:"start"});
  if(name==="explorer")renderExplorer();
  if(name==="portfolio")renderPortfolio();
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

 // Public refresh hook used after importing or synchronizing mother codes.
 window.AbabilPortfolioCodes={
  refresh:fillSelects,
  getAll:codes
 };


 function drawChart(canvas,code){
  const rows=rowsFor(code);
  const ctx=canvas.getContext("2d");
  const rect=canvas.getBoundingClientRect();
  const dpr=window.devicePixelRatio||1;
  canvas.width=Math.max(320,rect.width*dpr);
  canvas.height=270*dpr;
  ctx.setTransform(dpr,0,0,dpr,0,0);
  const w=canvas.width/dpr,h=270;
  ctx.clearRect(0,0,w,h);
  if(!rows.length){
   ctx.fillStyle=getComputedStyle(document.documentElement).getPropertyValue("--v10-muted");
   ctx.font="14px sans-serif";ctx.fillText("No local OHLC data",16,30);return;
  }
  const data=rows.slice(-90);
  const highs=data.map(r=>Number(r.high));
  const lows=data.map(r=>Number(r.low));
  const max=Math.max(...highs),min=Math.min(...lows);
  const pad=24,plotH=h-48,step=(w-pad*2)/Math.max(1,data.length);
  const y=v=>pad+(max-v)/(max-min||1)*plotH;
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
  return {code,current,s20,s50,r14,momentum,signal};
 }
 function runScanner(){
  const data=codes().map(indicatorData).filter(x=>x.current!==null);
  const tbody=document.getElementById("v11IndicatorRows");
  tbody.innerHTML=data.length?data.map(x=>`<tr><td>${esc(x.code)}</td><td>${fmt(x.current)}</td><td>${fmt(x.s20)}</td><td>${fmt(x.s50)}</td><td>${fmt(x.r14,1)}</td><td>${fmt(x.momentum,1)}%</td><td><span class="v11-signal ${x.signal.toLowerCase()}">${x.signal}</span></td></tr>`).join(""):'<tr><td colspan="7">No local data.</td></tr>';
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
 function runComparison(){
  const data=codes().map(comparisonData).filter(Boolean);
  document.getElementById("v11ComparisonRows").innerHTML=data.length?data.map(x=>`<tr><td>${esc(x.code)}</td><td>${fmt(x.last)}</td><td>${fmt(x.ret20,1)}%</td><td>${fmt(x.volatility,2)}%</td><td>${fmt(x.rv,2)}×</td><td>${fmt(x.momentum,1)}%</td></tr>`).join(""):'<tr><td colspan="6">No local data.</td></tr>';
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
  let cost=0,value=0;
  tbody.innerHTML=portfolio.length?portfolio.map((p,i)=>{
   const row=last(rowsFor(p.code)),lastClose=Number(row?.close||0);
   const c=p.qty*p.buy,v=p.qty*lastClose,pl=v-c;cost+=c;value+=v;
   return `<tr><td>${esc(p.code)}</td><td>${fmt(p.qty,0)}</td><td>${fmt(p.buy)}</td><td>${fmt(lastClose)}</td><td>${fmt(c)}</td><td>${fmt(v)}</td><td>${fmt(pl)}</td><td><button class="btn danger" type="button" data-remove-position="${i}">Remove</button></td></tr>`;
  }).join(""):'<tr><td colspan="8">No positions added.</td></tr>';
  tbody.querySelectorAll("[data-remove-position]").forEach(btn=>btn.addEventListener("click",()=>{portfolio.splice(Number(btn.dataset.removePosition),1);savePortfolio();renderPortfolio()}));
  document.getElementById("v11PortfolioCost").textContent=fmt(cost);
  document.getElementById("v11PortfolioValue").textContent=fmt(value);
  document.getElementById("v11PortfolioPl").textContent=fmt(value-cost);
  document.getElementById("v11PortfolioCount").textContent=portfolio.length;
 }
 document.getElementById("v11AddPosition")?.addEventListener("click",()=>{
  const code=String(document.getElementById("v11PortfolioCode")?.value||"").trim().toUpperCase();
  const qty=Number(document.getElementById("v11PortfolioQty")?.value);
  const buy=Number(document.getElementById("v11PortfolioBuy")?.value);
  if(!code||!Number.isFinite(qty)||qty<=0||!Number.isFinite(buy)||buy<=0)return;
  portfolio.push({code,qty,buy});savePortfolio();renderPortfolio();
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
  const data=codes().map(vpaData).filter(Boolean).sort((a,b)=>b.score-a.score);
  document.getElementById("v11VpaRows").innerHTML=data.length?data.map(x=>`<tr><td>${esc(x.code)}</td><td><span class="v11-score">${x.score}</span></td><td>${fmt(x.relSpread,2)}×</td><td>${fmt(x.relVolume,2)}×</td><td>${x.trend}</td><td>${esc(x.effort)}</td><td><span class="v11-signal ${x.cls.toLowerCase()}">${x.cls}</span></td></tr>`).join(""):'<tr><td colspan="7">No sufficient local data.</td></tr>';
  return data;
 }
 document.getElementById("v11RunVpa")?.addEventListener("click",runVpa);

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
   runComparison().forEach(x=>text+=`${x.code}: Return ${fmt(x.ret20,1)}%, Volatility ${fmt(x.volatility,2)}%, RV ${fmt(x.rv,2)}x\n`);
  }else if(type==="portfolio"){
   text+="PORTFOLIO\n";
   portfolio.forEach(p=>{const lc=Number(last(rowsFor(p.code))?.close||0);text+=`${p.code}: Qty ${p.qty}, Buy ${fmt(p.buy)}, Last ${fmt(lc)}, P/L ${fmt(p.qty*(lc-p.buy))}\n`});
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
  document.body.classList.toggle("v113-chart-overlay-open",open);

  if(open){
   document.querySelectorAll(modalSelectors.join(",")).forEach(el=>{
    if(!visible(el)) return;
    el.style.setProperty("z-index","2147483645","important");
    el.style.setProperty("position","fixed","important");
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
</body>
</html>