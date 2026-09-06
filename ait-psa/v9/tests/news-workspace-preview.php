<?php
// Uses separate browser stores; never seeds or overwrites the user's watch lists/news.
if (isset($_GET['client'])) {
    header('Content-Type: application/javascript');
    echo str_replace('ait-psa-dse-news-v1', 'ait-psa-news-qa-v1', file_get_contents(__DIR__ . '/../assets/js/ait-news.js'));
    exit;
}
$source = file_get_contents(__DIR__ . '/../index.php');
$source = str_replace(['dse-watch-dashboard-v3', 'ait-psa-market-data-v1'], ['ait-news-qa-dashboard', 'ait-news-qa-market'], $source);
$source = str_replace('src="assets/js/ait-news.js"', 'src="tests/news-workspace-preview.php?client=1"', $source);
$seed = <<<'HTML'
<base href="../"><script>
if(!localStorage.getItem('ait-news-qa-dashboard')) localStorage.setItem('ait-news-qa-dashboard',JSON.stringify({motherCodes:['GP'],autoMotherSync:false,watchLists:[{id:'qa-news',name:'News QA — test prices',codes:['GP']},{id:'qa-empty',name:'News QA — empty list',codes:[]}],activeId:'qa-news',history:{GP:[{date:'2026-08-10',open:98,high:103,low:97,close:100,volume:1000},{date:'2026-08-11',open:99,high:103,low:98,close:100,volume:1100},{date:'2026-08-12',open:101,high:113,low:100,close:110,volume:1200}]}}));
window.addEventListener('load',()=>AITNews.openWorkspace('report'));
</script>
HTML;
echo str_replace('<head>', '<head>' . $seed, $source);
