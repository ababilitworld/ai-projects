window.AIT_TERMINAL_SCHEMA={
  brand:{title:'AIT – PHA',subtitle:'Personal Health Assistant',icon:'⌘'},
  launcher:{title:'Terminal',icon:'>_'},
  menu:[
    {id:'workspace',label:'Workspace',icon:'⚡',description:'Data Center and reports',children:[
      {id:'data-center',label:'Data Center',icon:'🗄',description:'Data, backup, sync and import',children:[
        {id:'data',label:'Data',icon:'🧾',description:'Food and profile records',children:[
          {id:'food',label:'Food',icon:'🥗',description:'Food Data workspace',action:{type:'workspace',route:'data-center/food/index.html',title:'Food Data Workspace',breadcrumb:['Workspace','Data Center','Data','Food']}},
          {id:'profile',label:'Profile',icon:'👤',description:'Health planner profiles',action:{type:'workspace',route:'planner/health-planner/index.html?module=profilesModule',title:'Profile List',breadcrumb:['Workspace','Data Center','Data','Profile']}}
        ]},
        {id:'backup',label:'Backup',icon:'💾',description:'Download planner data',action:{type:'command',command:'backup'}},
        {id:'sync',label:'Sync',icon:'🔄',description:'Save local checkpoint',action:{type:'command',command:'sync'}},
        {id:'import',label:'Import',icon:'📥',description:'Restore JSON backup',action:{type:'command',command:'import'}}
      ]},
      {id:'report',label:'Report',icon:'🖨',description:'Print, poster and image',children:[
        {id:'print',label:'Print',icon:'🖨',description:'Color print workflow',action:{type:'command',command:'print'}},
        {id:'poster',label:'Poster',icon:'🪧',description:'A3 landscape poster',action:{type:'command',command:'poster'}},
        {id:'image',label:'Image',icon:'🖼',description:'Image export',action:{type:'command',command:'image'}}
      ]},
      {id:'tools',label:'Tools',icon:'🧰',description:'Exercise, calculators and health planner',children:[
            {id:'exercise',label:'Exercise',icon:'🏃',description:'Walking and breathing',children:[
              {id:'walking',label:'Walking',icon:'🚶',description:'Walking exercise',action:{type:'workspace',route:'exercise/walking/index.html',title:'Walking Exercise',breadcrumb:['Tools','Exercise','Walking']}},
              {id:'breathing',label:'Breathing',icon:'🌬',description:'Breathing exercise',action:{type:'workspace',route:'exercise/breathing/index.html',title:'Breathing Exercise',breadcrumb:['Tools','Exercise','Breathing']}}
            ]},
            {id:'calculator',label:'Calculator',icon:'🧮',description:'Health calculators',children:[
              {id:'bmi',label:'BMI',icon:'⚖',description:'Body mass index',action:{type:'workspace',route:'calculator/bmi/index.html',title:'BMI Calculator',breadcrumb:['Tools','Calculator','BMI']}},
              {id:'bmr',label:'BMR',icon:'🔥',description:'Basal metabolic rate',action:{type:'workspace',route:'calculator/bmr/index.html',title:'BMR Calculator',breadcrumb:['Tools','Calculator','BMR']}},
              {id:'bsr',label:'BSR',icon:'📐',description:'Body shape ratio',action:{type:'workspace',route:'calculator/bsr/index.html',title:'BSR Calculator',breadcrumb:['Tools','Calculator','BSR']}},
              {id:'fat',label:'Fat',icon:'📊',description:'Body fat estimate',action:{type:'workspace',route:'calculator/fat/index.html',title:'Body Fat Calculator',breadcrumb:['Tools','Calculator','Fat']}},
              {id:'live-weight',label:'Live Weight',icon:'📈',description:'Target weight planner',action:{type:'workspace',route:'calculator/live-weight/index.html',title:'Live Weight Planner',breadcrumb:['Tools','Calculator','Live Weight']}}
            ]},
            {id:'planner',label:'AIT – Health Planner',icon:'🗓',description:'Profile and reports',children:[
              {id:'planner-profile',label:'Profile',icon:'👤',description:'Profile list',action:{type:'workspace',route:'planner/health-planner/index.html?module=profilesModule',title:'AIT – Health Planner / Profile',breadcrumb:['Tools','AIT – Health Planner','Profile']}},
              {id:'planner-report',label:'Report',icon:'📊',description:'Generated reports',action:{type:'workspace',route:'planner/health-planner/index.html?module=reportsModule',title:'AIT – Health Planner / Report',breadcrumb:['Tools','AIT – Health Planner','Report']}}
            ]}
          ]}
    ]},
    
    {id:'appearance',label:'Appearance',icon:'🎨',description:'Theme and visual settings',action:{type:'modal',modalId:'appearanceModal'}},
    {id:'interaction',label:'Interaction',icon:'🖱',description:'Interaction settings',action:{type:'modal',modalId:'interactionModal'}},
    {id:'navigation',label:'Navigation',icon:'🧭',description:'Book navigation',action:{type:'modal',modalId:'navigationModal'}},
    {id:'notification',label:'Notification',icon:'🔔',description:'Notification settings',action:{type:'modal',modalId:'notificationModal'}},
    {id:'activity',label:'Activity',icon:'🕘',description:'Recent activity',action:{type:'modal',modalId:'activityModal'}}
  ]
};