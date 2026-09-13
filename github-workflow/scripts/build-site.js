import {cpSync,existsSync,lstatSync,mkdirSync,readdirSync,readFileSync,rmSync,writeFileSync} from 'node:fs';
import path from 'node:path';
import {fileURLToPath} from 'node:url';
const guideRoot=path.resolve(path.dirname(fileURLToPath(import.meta.url)),'..');
export const allowedExtensions=new Set(['.html','.css','.js','.mjs','.json','.svg','.png','.jpg','.jpeg','.gif','.webp','.ico','.woff','.woff2','.ttf','.mp3','.mp4','.webm','.pdf','.txt','.md']);
const excludedNames=new Set(['tmp','node_modules','vendor','tests','scripts','docs','dist','coverage','work','outputs']);
export function isPublishable(relative){const parts=relative.split(/[\\/]/);return !parts.some(part=>part.startsWith('.')||excludedNames.has(part.toLowerCase()))&&allowedExtensions.has(path.extname(relative).toLowerCase())&&!/^(package(-lock)?\.json|site\.config\.json|AGENTS\.md)$/i.test(parts.at(-1));}
const escape=value=>String(value).replace(/[&<>"']/g,char=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char]));
export function buildSite(repoRoot,config){
  const output=path.join(repoRoot,'.cloudflare-dist');
  // Only this fixed, generated directory is replaced. Never accept an output path from configuration.
  rmSync(output,{recursive:true,force:true});mkdirSync(output,{recursive:true});let count=0;const available=[];
  for(const project of config.projects){
    if(!/^[a-z0-9-]+$/.test(project.path)||project.entry.includes('..')||path.isAbsolute(project.entry))throw new Error('Unsafe project path');
    const source=path.join(repoRoot,project.path);
    if(!existsSync(path.join(source,project.entry))){console.warn(`Skipping ${project.path}: entry does not exist`);continue;}
    function walk(dir,relative=''){
      for(const item of readdirSync(dir,{withFileTypes:true})){
        const rel=path.join(relative,item.name);const full=path.join(dir,item.name);
        if(lstatSync(full).isSymbolicLink())continue;
        if(item.isDirectory()){if(!item.name.startsWith('.')&&!excludedNames.has(item.name.toLowerCase()))walk(full,rel);}
        else if(isPublishable(rel)){
          if(lstatSync(full).size>25*1024*1024)throw new Error(`Asset exceeds Pages 25 MiB limit: ${project.path}/${rel}`);
          const target=path.join(output,project.path,rel);mkdirSync(path.dirname(target),{recursive:true});cpSync(full,target);count++;
        }
      }
    }
    walk(source);
    // Handbook markdown is intentionally public documentation, copied separately from app runtime assets.
    if(project.path==='github-workflow')cpSync(path.join(source,'docs'),path.join(output,project.path,'docs'),{recursive:true});
    available.push(project);
  }
  if(!available.some(project=>project.path==='github-workflow'))throw new Error('Workflow guide is required');
  const cards=available.map(project=>`<a href="./${escape(project.path)}/${escape(project.entry)}"><span>↗</span><h2>${escape(project.name)}</h2><p>${escape(project.description)}</p></a>`).join('');
  writeFileSync(path.join(output,'index.html'),`<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>AI Projects · Ababil IT World</title><style>*{box-sizing:border-box}body{margin:0;padding:8vw;background:#102119;color:#eef4e7;font:16px/1.6 system-ui}small{letter-spacing:.2em;color:#c9eaa0}h1{font-size:clamp(40px,7vw,86px);font-weight:500;letter-spacing:-.06em;line-height:1.05;margin:25px 0}p{color:#afc2a8}main{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:18px;margin-top:50px}a{padding:28px;border:1px solid #486041;border-radius:16px;color:inherit;text-decoration:none;background:#193023}a:hover{background:#27452e}a:focus-visible{outline:3px solid #d0ef9c;outline-offset:4px}a>span{float:right;color:#d0ef9c}h2{font-size:21px;font-weight:500}a p{font-size:13px}footer{margin-top:40px;font-size:12px;color:#afc2a8}</style></head><body><small>ABABIL IT WORLD / PROJECT COLLECTION</small><h1>Ideas made useful.</h1><p>Explore the static projects and the release handbook.</p><main>${cards}</main><footer>PHP applications continue on their existing host. AIT-MLL is awaiting its first implementation.</footer></body></html>`);
  writeFileSync(path.join(output,'_headers'),'/*\n  X-Content-Type-Options: nosniff\n  Referrer-Policy: strict-origin-when-cross-origin\n');
  console.log(`Built ${available.length} projects, ${count} assets → .cloudflare-dist`);return {output,count,projects:available};
}
if(process.argv[1]&&path.resolve(process.argv[1])===fileURLToPath(import.meta.url))buildSite(path.resolve(guideRoot,'..'),JSON.parse(readFileSync(path.join(guideRoot,'site.config.json'),'utf8')));
