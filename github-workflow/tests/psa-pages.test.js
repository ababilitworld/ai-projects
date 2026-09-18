import test from 'node:test';
import assert from 'node:assert/strict';
import {existsSync,readFileSync} from 'node:fs';
import path from 'node:path';
import {fileURLToPath} from 'node:url';
import worker,{testHooks} from '../src/psa-pages-worker.js';
import {buildSite} from '../scripts/build-site.js';

const root=path.resolve(path.dirname(fileURLToPath(import.meta.url)),'../..');
const sample=readFileSync(path.join(root,'ait-psa/v9/storage/dse-cache/dse-v7-chunk-2025-09-06-to-2025-09-19-all.html'),'utf8');

test('Pages build publishes PSA app and only its four API routes',()=>{
  const config=JSON.parse(readFileSync(path.join(root,'github-workflow/site.config.json'),'utf8'));
  const output=buildSite(root,config).output;
  const html=readFileSync(path.join(output,'ait-psa/v9/index.html'),'utf8');
  const routes=JSON.parse(readFileSync(path.join(output,'_routes.json'),'utf8'));
  assert.match(html,/ait-elite-horizons\.js/);
  assert.match(html,/ait-elite-performance-compare\.js/);
  assert.equal(routes.include.length,4);
  assert.match(readFileSync(path.join(output,'_worker.js'),'utf8'),/env\.ASSETS\.fetch/);
  assert.equal(existsSync(path.join(output,'ait-psa/v9/storage')),false);
});

test('DSE archive adapter parses actual sample and scopes responses',async()=>{
  const parsed=testHooks.parseArchive(sample,['1JANATAMF']);
  assert.deepEqual(Object.keys(parsed),['1JANATAMF']);
  assert.equal(parsed['1JANATAMF'].length,10);
  const oldFetch=globalThis.fetch;
  globalThis.fetch=async()=>new Response(sample,{status:200});
  try{
    const request=new Request('https://example.pages.dev/ait-psa/v9/dse_archive.php?startDate=2025-09-06&endDate=2025-09-19&codes=1JANATAMF');
    const result=await worker.fetch(request,{ASSETS:{fetch:()=>{throw Error('unexpected static fallback')}}});
    const body=await result.json();
    assert.equal(result.status,200);
    assert.equal(body.success,true);
    assert.equal(body.symbolCount,1);
    assert.equal(body.recordCount,10);
    assert.equal(body.data['1JANATAMF'][0].date,'2025-09-07');
  }finally{globalThis.fetch=oldFetch}
});

test('fixed route rejects bad dates and static routes fall through',async()=>{
  const bad=await worker.fetch(new Request('https://example.pages.dev/ait-psa/v9/dse_archive.php?startDate=2025-02-30&endDate=2025-03-01'),{ASSETS:{fetch:()=>{throw Error('unexpected')}}});
  assert.equal(bad.status,400);
  assert.equal((await bad.json()).success,false);
  const staticResult=await worker.fetch(new Request('https://example.pages.dev/ait-mtc/index.html'),{ASSETS:{fetch:()=>new Response('static')}});
  assert.equal(await staticResult.text(),'static');
});

test('fundamental adapters preserve the browser data contract',async()=>{
  const oldFetch=globalThis.fetch;
  globalThis.fetch=async request=>new Response(String(request).includes('amarstock')?JSON.stringify({cc:'12.5',cb:'3.4',cj:'20',ck:'15%',do:'1.2',cm:'5%'}):'<table><tr><td>Company Name</td><td>Test Company</td></tr><tr><td>Market Category</td><td>A</td></tr><tr><td>Sector</td><td>Bank</td></tr><tr><td>Year End</td><td>December</td></tr></table>');
  try{
    const post=path=>worker.fetch(new Request(`https://example.pages.dev/ait-psa/v9/${path}`,{method:'POST',body:JSON.stringify({codes:['TEST']})}),{ASSETS:{fetch:()=>{throw Error('unexpected')}}});
    const dse=await (await post('dse_fundamentals.php')).json();
    const amar=await (await post('amarstock_fundamentals.php')).json();
    assert.equal(dse.data.TEST.category,'A');
    assert.equal(dse.data.TEST.businessSegment,'Bank');
    assert.equal(amar.data.TEST.peRatio,12.5);
    assert.equal(amar.data.TEST.freeFloat,15);
  }finally{globalThis.fetch=oldFetch}
});

test('instant and news downloads return browser-compatible records',async()=>{
  const live='<table><tr><th>Trading Code</th><th>LTP</th><th>High</th><th>Low</th><th>YCP</th><th>Volume</th></tr><tr><td>TEST</td><td>101</td><td>103</td><td>99</td><td>100</td><td>5000</td></tr></table>';
  const opens='<table><tr><th>Trading Code</th><th>OpenP</th></tr><tr><td>TEST</td><td>100.5</td></tr></table>';
  const news='<html><table><tr><td>Trading Code</td><td>TEST</td></tr><tr><td>News Title</td><td>Board meeting</td></tr><tr><td>News</td><td>Meeting scheduled.</td></tr><tr><td>Post Date</td><td>2026-01-12</td></tr></table></html>';
  const oldFetch=globalThis.fetch;
  globalThis.fetch=async input=>new Response(String(input).includes('old_news')?news:String(input).includes('amarstock')?opens:live);
  try{
    const env={ASSETS:{fetch:()=>{throw Error('unexpected')}}};
    const instant=await (await worker.fetch(new Request('https://example.pages.dev/ait-psa/v9/dse_archive.php?action=instant&codes=TEST'),env)).json();
    assert.equal(instant.data.TEST[0].open,100.5);
    assert.equal(instant.amarstockOpenMatched,1);
    const result=await worker.fetch(new Request('https://example.pages.dev/ait-psa/v9/dse_news.php',{method:'POST',body:JSON.stringify({code:'TEST',start:'2026-01-01',end:'2026-01-31'})}),env);
    const body=await result.json();
    assert.equal(body.ok,true);
    assert.equal(body.rows[0].title,'Board meeting');
    assert.equal(body.rows[0].id.length,64);
  }finally{globalThis.fetch=oldFetch}
});
