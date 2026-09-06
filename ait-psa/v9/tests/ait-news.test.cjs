const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const news = require('../assets/js/ait-news.js');
const tag = (title, body='') => news.classify({title,body});
assert.deepEqual(tag('GP: Q1 Financial Results'), [{category:'financial',type:'q1'}]);
assert.deepEqual(tag('GP: Q2 Financial Results'), [{category:'financial',type:'q2'}]);
assert.deepEqual(tag('GP: Q3 Financial Results'), [{category:'financial',type:'q3'}]);
assert.deepEqual(tag('GP: Board Meeting', 'Will consider Q1 financial statements and dividend'), [{category:'board',type:'scheduled'}]);
assert.deepEqual(tag('GP: Dividend Declaration', 'Recommends 10% cash and 5% stock dividend'), [{category:'dividend',type:'declaration'}]);
assert.deepEqual(tag('GP: No dividend'), [{category:'dividend',type:'declaration'}]);
assert.deepEqual(tag('GP: Dividend Disbursement'), [{category:'dividend',type:'disbursement'}]);
assert.deepEqual(tag('GP: Credit Rating', 'Reaffirmed AAA'), [{category:'credit',type:'rating'}]);
assert.deepEqual(tag('GP: Q4 Financial Results'), [{category:'financial',type:'q4'}]);
assert.deepEqual(tag('GP: Spot News'), [{category:'spot',type:'notice'}]);
assert.deepEqual(tag('GP: Suspension for Record Date'), [{category:'trading',type:'suspension'}]);
assert.deepEqual(tag('GP: Resumption after Record Date'), [{category:'trading',type:'resumption'}]);
assert.deepEqual(tag('GP: Price Hike'), [{category:'pricehike',type:'notice'}]);
for(const type of ['buy','sell','transfer'])assert.deepEqual(tag('GP: Declaration of '+type),[{category:'declaration',type}]);
assert.deepEqual(tag('GP: Price Sensitive Information'), [{category:'sensitive',type:'disclosure'}]);
assert.deepEqual(tag('GP: Office notice'), [{category:'general',type:'notice'}]);
for (const [category,c] of Object.entries(news.categories)) {
  assert.equal(new Set(Object.keys(c.types).map(type=>news.style({category,type}).symbol)).size,1);
  assert.equal(new Set(Object.values(c.types).map(t=>t[1])).size,Object.keys(c.types).length);
}
const bars = [10,12,9,9].map((close,i)=>({date:`2026-08-0${i+1}`,open:close,high:close+1,low:close-1,close,volume:100}));
const articles = bars.map((bar,i)=>({id:String(i),code:'GP',date:bar.date,title:'GP: Q1 Financial Results',body:'EPS released'}));
articles.push({...articles[0],id:'extra',title:'GP: Credit Rating',body:'AAA rating announced'});
articles.push({id:'off-calendar',date:'2026-08-07',code:'GP',title:'General'});
const merged = news.mergeRows(articles, articles);
assert.equal(merged.length,6,'Re-downloads must not duplicate articles');
const download = news.mergeDownload({rows:articles,start:'1900-01-01',end:'2026-08-20',sourceStart:'2024-08-20',sourceEnd:'2026-08-20'}, {rows:[],start:'2026-08-20',end:'2026-09-06',sourceStart:'2026-08-20',sourceEnd:'2026-09-06'});
assert.equal(download.rows.length,6,'An empty update must preserve saved news');
assert.equal(download.sourceStart,'2024-08-20','An incremental update must retain the historical coverage');
assert.equal(download.end,'2026-09-06');
const events = news.eventsFor(bars, merged);
assert.equal(events.length,4,'One close per news day; unmatched dates omitted');
assert.equal(events[0].tags.length,2,'Multiple news categories share their publication date');
assert.equal(events[0].markerPrice,8.1,'Marker starts at exactly 90% of OHLC low');
assert.deepEqual(news.segments(events).map(s=>s.color),[news.lineColors.up,news.lineColors.down,news.lineColors.equal]);
const b = news.bounds(bars,events,130);
for (const e of events) {
  const markerY = (b.max-e.markerPrice)/b.range*130;
  assert.ok(markerY+(e.tags.length-1)*15+7<=130,'Stacked markers must fit inside the plot');
}
assert.deepEqual(news.eventsFor(bars,[]),[]);
assert.deepEqual(news.segments(events.slice(0,1)),[]);
const zeroBars=[{date:'2026-08-01',close:100,open:99,high:101,low:98},{date:'2026-08-02',close:0,open:0,high:0,low:0},{date:'2026-08-03',close:0,open:0,high:0,low:0}];
const zeroNews=zeroBars.map((r,i)=>({id:String(i),code:'GP',date:r.date,title:'Spot News'}));
const zeroEvents=news.eventsFor(zeroBars.slice(1),zeroNews,zeroBars);
assert.deepEqual(zeroEvents.map(e=>e.close),[100,100]);
assert.deepEqual(zeroEvents.map(e=>e.markerPrice),[90,90]);
assert.ok(zeroEvents.every(e=>e.usedPreviousClose));
assert.equal(news.segments(zeroEvents)[0].color,news.lineColors.equal);
assert.equal(zeroBars[1].close,0,'Drawing must not overwrite stored OHLC');
assert.equal(news.eventsFor(zeroBars.slice(1),zeroNews).length,0,'No invented close when no previous valid price exists');
assert.equal(new Set(Object.values(news.categories).map(c=>c.symbol)).size,Object.keys(news.categories).length);
assert.equal(new Set(Object.values(news.categories).map(c=>c.color)).size,Object.keys(news.categories).length);
const source = fs.readFileSync(require('node:path').join(__dirname,'..','index.php'),'utf8');
for (const match of source.matchAll(/<script\b([^>]*)>([\s\S]*?)<\/script>/g)) {
  if (!/\bsrc=|type="module"/.test(match[1])) new vm.Script(match[2]);
}
assert.ok(source.includes('data-ait-psa-open="aitPsaNewsDownloadMenuModal"'));
assert.ok(source.includes('id="aitPsaNewsWorkspaceModal"'));
assert.ok(source.includes('id="aitNewsTable"'));
assert.ok(source.includes('<th>Date</th><th>Trading Code</th><th>CloseP</th><th>News Category - Subcategory</th><th>News</th>'));
assert.ok(source.includes('if(activeChartElement?.isConnected)return activeChartElement;'),'Mounted charts must not be swapped on each DOM mutation');
for (const text of ['{code:this.currentCode}','{code:c}','{code:x.code}','AITNews?.draw(ctx,canvas,newsEvents,i=>']) assert.ok(source.includes(text),`Chart integration: ${text}`);
console.log('News classification, deduplication, date alignment, line colors, marker bounds and all chart integrations passed.');
