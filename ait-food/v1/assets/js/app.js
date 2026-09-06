import BakingBook from './BakingBook.js';
import ThemeManager from './ThemeManager.js';
import PrintManager from './PrintManager.js';
import TocManager from './TocManager.js';
import RecipeManager from './RecipeManager.js';

const recipes=[
{id:'vanilla-cake',name:'Vanilla Cake',category:'Cake',difficulty:'Beginner',yield:'1 × 8-inch',prep:'20 min',bake:'30–35 min',preheat:'12 min',temp:165,rack:'Middle',
ingredients:[['ময়দা','150 g','Structure'],['চিনি','120 g','Sweetness'],['ডিম','3টি / ~150 g','Structure'],['তেল','80 g','Moisture'],['দুধ','40 g','Hydration'],['Baking powder','5 g','Leavening'],['Corn flour','15 g','Tender crumb'],['Vanilla essence','2 g','Flavour']],
steps:['ওভেন 165°C-এ 12 মিনিট preheat করুন।','ময়দা, corn flour ও baking powder sift করুন।','ডিম ও চিনি হালকা ও ফোমি হওয়া পর্যন্ত whisk করুন।','তেল, দুধ ও vanilla ধীরে মেশান।','Dry ingredients fold করুন; overmix করবেন না।','Pan-এর প্রায় 65–70% ভরুন এবং middle rack-এ bake করুন।','Toothpick পরিষ্কার/হালকা crumbসহ বের হলে cake বের করুন।'],
quality:'সমান golden top, নরম crumb, মাঝখানে collapse নয়, অতিরিক্ত শুকনো নয়।'},
{id:'soft-bread',name:'Bakery-style Soft Bread',category:'Bread',difficulty:'Intermediate',yield:'1 loaf',prep:'25 min + proof',bake:'30–35 min',preheat:'12 min',temp:185,rack:'Lower-middle',
ingredients:[['ময়দা','500 g','Structure'],['Instant yeast','7 g','Fermentation'],['চিনি','25 g','Flavour/softness'],['লবণ','8 g','Flavour'],['দুধ/পানি','300–320 g','Hydration'],['তেল/Butter','30 g','Tenderness'],['Milk powder','20 g','Milk flavour']],
steps:['সব dry ingredients মেশান; yeast ও salt সরাসরি এক জায়গায় জমতে দেবেন না।','তরল ধীরে যোগ করে dough তৈরি করুন।','10–15 মিনিট knead করে smooth dough এবং windowpane-এর কাছাকাছি development আনুন।','ঢেকে প্রথম proof করুন; প্রায় দ্বিগুণ হলে shape করুন।','Pan-এ রাখুন এবং দ্বিতীয় proof দিন যতক্ষণ dough প্রায় 80–90% expanded হয়।','185°C-এ top + bottom heating-এ lower-middle rack-এ bake করুন।','বের করে সঙ্গে সঙ্গে হালকা butter/oil brush করে rack-এ cool করুন।'],
quality:'হালকা golden crust, নরম elastic crumb, uniform pores, চাপ দিলে crumb ফিরে আসবে।'},
{id:'sweet-bun',name:'Soft Sweet Bun',category:'Bun',difficulty:'Intermediate',yield:'10 × ~70 g',prep:'30 min + proof',bake:'16–20 min',preheat:'12 min',temp:185,rack:'Middle',
ingredients:[['ময়দা','500 g','Structure'],['Instant yeast','7 g','Fermentation'],['চিনি','60 g','Sweetness'],['লবণ','7 g','Flavour'],['দুধ','260 g','Hydration'],['ডিম','50 g','Richness'],['Butter','40 g','Softness'],['Milk powder','20 g','Flavour']],
steps:['Dough তৈরি করে smooth ও elastic হওয়া পর্যন্ত knead করুন।','প্রথম proof দিন।','প্রতি piece প্রায় 70 g scale করে tight ball shape করুন।','Tray-এ gap রেখে second proof দিন।','Egg wash দিয়ে 185°C preheated oven-এ bake করুন।','Golden colour হলে বের করুন এবং cooling rack-এ রাখুন।'],
quality:'সমান গোল shape, glossy golden top, soft crumb এবং uniform size।'},
{id:'butter-biscuit',name:'Butter Biscuit',category:'Biscuit',difficulty:'Beginner',yield:'25–30 pcs',prep:'20 min',bake:'12–16 min',preheat:'12 min',temp:170,rack:'Middle',
ingredients:[['ময়দা','250 g','Structure'],['Butter','150 g','Richness'],['Icing sugar','90 g','Sweetness'],['Corn flour','30 g','Tenderness'],['Vanilla essence','2 g','Flavour']],
steps:['Butter ও icing sugar cream করুন; অতিরিক্ত whip করবেন না।','Vanilla যোগ করুন।','Sifted flour ও corn flour fold করে soft dough তৈরি করুন।','Dough chill করে portion/shape করুন।','170°C-এ middle rack-এ bake করুন যতক্ষণ edge হালকা golden হয়।','Tray-তে 5 মিনিট রেখে rack-এ cool করুন।'],
quality:'Crisp edge, tender bite, clean shape, অতিরিক্ত spread নয়।'},
{id:'chicken-patties',name:'Chicken Patties',category:'Patties',difficulty:'Advanced',yield:'10 × ~80 g',prep:'45 min',bake:'20–25 min',preheat:'15 min',temp:200,rack:'Middle',
ingredients:[['Puff pastry sheet','600 g','Layers'],['Chicken filling','300 g','Filling'],['ডিম','50 g','Egg wash'],['Black pepper','2 g','Flavour'],['লবণ','5 g','Flavour']],
steps:['Puff pastry cold রাখুন এবং butter layer গলতে দেবেন না।','Sheet roll করে portion কাটুন; filling কেন্দ্রের দিকে রাখুন।','Edge-এ egg wash দিয়ে seal করুন।','Top-এ egg wash দিন এবং প্রয়োজন হলে ছোট vent করুন।','200°C preheated oven-এ middle rack-এ bake করুন।','Layers ফুলে golden ও bottom dry/crisp হলে বের করুন।'],
quality:'Visible flaky layers, crisp bottom, sealed edge এবং evenly browned top।'}
];

const root=document.documentElement;
const book=new BakingBook({container:document.querySelector('#aitb-recipes'),recipes});
const theme=new ThemeManager(root);
const print=new PrintManager();
const toc=new TocManager(document.querySelector('#aitb-toc'));
const manager=new RecipeManager(book);

theme.init(); book.render(); toc.build();
document.addEventListener('click',e=>{const action=e.target.closest('[data-aitb-action]')?.dataset.aitbAction;if(action==='theme')theme.toggle();if(action==='print')print.print();});
const search=document.querySelector('#aitb-search'), category=document.querySelector('#aitb-category');
const update=()=>{book.render(manager.filter({query:search.value,category:category.value}));toc.build();};
search.addEventListener('input',update);category.addEventListener('change',update);
