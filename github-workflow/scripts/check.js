import {readFileSync,readdirSync,existsSync} from 'node:fs';
import path from 'node:path';
import {fileURLToPath} from 'node:url';
import {spawnSync} from 'node:child_process';
const root=path.resolve(path.dirname(fileURLToPath(import.meta.url)),'..');
let failures=0;
for(const dir of ['src','scripts','tests'])for(const name of readdirSync(path.join(root,dir)).filter(name=>name.endsWith('.js'))){const result=spawnSync(process.execPath,['--check',path.join(root,dir,name)],{encoding:'utf8'});if(result.status!==0){console.error(result.stderr);failures++;}}
const html=readFileSync(path.join(root,'index.html'),'utf8');
for(const match of html.matchAll(/(?:href|src)="(\.\/[^"#]+)"/g))if(!existsSync(path.resolve(root,match[1]))){console.error(`Missing local reference: ${match[1]}`);failures++;}
for(const name of ['data.js','core.js','components.js','app.js'])for(const match of readFileSync(path.join(root,'src',name),'utf8').matchAll(/from\s+['"](\.[^'"]+)['"]/g))if(!existsSync(path.resolve(root,'src',match[1]))){console.error(`Missing module: ${match[1]}`);failures++;}
if(failures)process.exitCode=1;else console.log('JavaScript syntax, module imports and handbook file references passed.');
